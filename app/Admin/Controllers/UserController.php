<?php

namespace App\Admin\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\UserProjectDay;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Table;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '员工';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);
        $grid->column('employee_number', __('工号'));
        $grid->column('name', __('姓名'));
        $grid->column('type', __('类型'));
        $grid->column('group', __('组名'));
        $grid->column('status', __('状态'));
        $grid->column('entry_time', __('入职时间'))->display(function ($entry_time) {
            return date('Y-m-d', strtotime($entry_time));
        });


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    //此方法已弃用，启用时注意添加字段
//    protected function detail($id)
//    {
//        $show = new Show(User::findOrFail($id));
//
//        $show->field('name', __('名字'));
//        $show->field('employee_number', __('工号'));
//        $show->field('group', __('组名'));
//        $show->field('type', __('类型'));
//        $show->field('entry_time', __('入职时间'));
//        $show->field('status', __('状态'));
//        $show->field('created_at', __('创建时间'));
//        $show->field('updated_at', __('修改时间'));
//
//        return $show;
//    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $form->text('name', __('名字'))->required();
        $form->text('employee_number', __('工号'))->required();

        //group字段暂定为组长名称
        $user_groups = User::select('name')->where(['type' => '组长'])->get()->toArray();
        $groups = ['无分组' => '无分组'];
        foreach ($user_groups as $user_group) {
            $groups[$user_group['name']] = $user_group['name'];
        }

        $form->select('group', __('组名'))->options($groups)->required();
        $types = [
            '组长' => '组长',
            '组员' => '组员',
        ];
        $form->select('type', __('类型'))->options($types);
        $form->datetime('entry_time', __('入职时间'))->format('YYYY-MM-DD')->required();
        $status = [
            '正常' => '正常',
            '禁用' => '禁用',
            '删除' => '删除'
        ];
        $form->select('status', __('状态'))->options($status)->required();

        return $form;
    }


    public function show($id, Content $content)
    {

        // 选填
        $content->header('员工详情');

        // 选填
        $content->description('');

        // 添加面包屑导航 since v1.5.7
        $content->breadcrumb(
            ['text' => '首页', 'url' => '/'],
            ['text' => '员工', 'url' => '/projects'],
            ['text' => '员工详情']
        );

        // 填充页面body部分，这里可以填入任何可被渲染的对象
//        $content->body('<b>hello world</b>');

//数据=========================================================
        $user_data = User::find($id)->toArray();
        //【员工基本信息】
        $employeeData = $user_data;
        $employee_number = $user_data['employee_number'];

        //【当前参与项目】
        //参与项目
        $user_project_data = UserProjectDay::with('project')->where(['employee_number' => $employee_number])->get()->toArray();
        //获得当前项目名称和id
        $current_project_name = [];
        $current_project_ids = [];
        foreach ($user_project_data as $value) {
            if ($value['project']['status'] == '未完成') {
                $current_project_name[] = $value['project']['name'];
                $current_project_ids[] = $value['project']['id'];
            }
        }
        $current_project_str = implode('、', array_unique($current_project_name));
        $current_project_ids = array_unique($current_project_ids);

        //【当前项目信息表格】
        $projectData = [];
        $performance = [];
        foreach ($current_project_ids as $current_project_id) {
            //名称、单价
            $current_project = Project::find($current_project_id);
            $name = $current_project->name;
            $unit_price = $current_project->unit_price;
            //参加日期、上次标注产出、上次审核产出、标注基础量、审核基础量、上次日均标注量、上次最高标注量
            $join_time = UserProjectDay::where(['project_id' => $current_project_id, 'employee_number' => $employee_number])->min('date');
            $last_label_info = UserProjectDay::where(['project_id' => $current_project_id, 'employee_number' => $employee_number])->orderBy('date', 'desc')->first()->toArray();
            $last_label = $last_label_info['daily_label'];
            $last_check = $last_label_info['daily_check'];
            $last_daily_standard = $last_label_info['daily_standard'];
            $last_standard_check = $last_label_info['standard_check'];
            $last_date = $last_label_info['date'];

            //计算上次标注平均量
            $last_all_info = UserProjectDay::where(['date' => $last_date])->get()->toArray();
            $last_label_total = 0;//总标注数量非真实数量,如A做了0.5天200个,按400个算
            $last_label_max = 0;
            $count = 0;
            foreach ($last_all_info as $value) {
                $last_label_total += $value['daily_label'] / $value['workload'];
                if ($value['daily_label'] > $last_label_max) {
                    $last_label_max = $value['daily_label'];
                }
                $count++;

            }
            $last_label_avg = $last_label_total / $count;//非真实平均数
            $projectData[] = [
                'name' => $name,
                'unit_price' => $unit_price,
                'join_time' => date('Y-m-d', strtotime($join_time)),
                'last_label' => $last_label,
                'last_check' => $last_check,
                'last_daily_standard' => $last_daily_standard,
                'last_standard_check' => $last_standard_check,
                'last_label_avg' => $last_label_avg,
                'last_label_max' => $last_label_max,
                'last_date' => date('Y-m-d', strtotime($last_date))
            ];

            //【近两周表现情况】
            //近两周的日期
            $last_two_weeks = [];
            $curtime = time();
            for ($i = 1; $i < 14; $i++) {
                $last_two_weeks[] = date('Y-m-d', $curtime - $i * 86400);
            }
            foreach ($last_two_weeks as $day) {
                $temp2 = UserProjectDay::with('project')->where(['date' => $day, 'project_id' => $current_project_id])->first();
                if (empty($temp2)) {
                    $performance[$name][$day]['daily_label'] = 0;
                    $performance[$name][$day]['daily_check'] = 0;
                    $performance[$name][$day]['output'] = 0;
                } else {
                    $temp2 = $temp2->toArray();
                    $performance[$name][$day]['daily_label'] = $temp2['daily_label'];
                    $performance[$name][$day]['daily_check'] = $temp2['daily_check'];
                    $performance[$name][$day]['output'] = $temp2['daily_label'] * $temp2['project']['unit_price'];
                }
            }


        }

        //【上月情况】
        //上月1日0点
        $last_month_1st = date('Y-m-1', strtotime('-1 month', time()));
        //本月1日0点
        $this_month_1st = date('Y-m-1', time());
        //上月此员工所有每日情况
        $last_month_performance = UserProjectDay::where(['employee_number' => $employee_number])->where('date', '>=', $last_month_1st)->where('date', '<', $this_month_1st)->get()->toArray();
        //dd($last_month_performance);
        //上月此员工所有的项目id
        $last_month_project_ids = [];
        foreach ($last_month_performance as $value) {
            $last_month_project_ids[] = $value['project_id'];
        };
        $last_month_project_ids = array_unique($last_month_project_ids);
        //上月情况
        $last_month = [];
        foreach ($last_month_project_ids as $last_month_project_id) {
            $temp3 = Project::where(['id' => $last_month_project_id])->first();
            $last_month[] = ['id' => $last_month_project_id, 'name' => $temp3->name, 'unit_price' => $temp3->unit_price];
        }
        //dd($last_month);
        foreach ($last_month as $key => $value) {
            $last_month_label_number = 0;
            $last_month_check_number = 0;
            foreach ($last_month_performance as $v) {
                if ($v['project_id'] == $value['id']) {
                    $last_month_label_number += $v['daily_label'];
                    $last_month_check_number += $v['daily_check'];
                }
            }
            $last_month[$key]['label_number'] = $last_month_label_number;
            $last_month[$key]['check_number'] = $last_month_check_number;

        }
        foreach ($last_month as $key => $value) {
            $temp4 = Project::where(['id' => $value['id']])->first();
            $last_month[$key]['output'] = $temp4->unit_price * $value['label_number'];
            $last_month[$key]['salary'] = $temp4->label_unit_price * $value['label_number'] + $temp4->check_unit_price * $value['check_number'];
        }


        //【本月情况】
        //本月今天0点
        $this_month_today = date('Y-m-d', time());
        //本月1日0点
        $this_month_1st = date('Y-m-1', time());
        //本月此员工所有每日情况
        $this_month_performance = UserProjectDay::where(['employee_number' => $employee_number])->where('date', '>=', $this_month_1st)->where('date', '<=', $this_month_today)->get()->toArray();
        //dd($this_month_performance);
        //本月此员工所有的项目id
        $this_month_project_ids = [];
        foreach ($this_month_performance as $value) {
            $this_month_project_ids[] = $value['project_id'];
        };
        $this_month_project_ids = array_unique($this_month_project_ids);
        //本月情况
        $this_month = [];
        foreach ($this_month_project_ids as $this_month_project_id) {
            $temp4 = Project::where(['id' => $this_month_project_id])->first();
            $this_month[] = ['id' => $this_month_project_id, 'name' => $temp4->name, 'unit_price' => $temp4->unit_price];
        }
        //dd($this_month);
        foreach ($this_month as $key => $value) {
            $this_month_label_number = 0;
            $this_month_check_number = 0;
            foreach ($this_month_performance as $v) {
                if ($v['project_id'] == $value['id']) {
                    $this_month_label_number += $v['daily_label'];
                    $this_month_check_number += $v['daily_check'];
                }
            }
            $this_month[$key]['label_number'] = $this_month_label_number;
            $this_month[$key]['check_number'] = $this_month_check_number;

        }
        foreach ($this_month as $key => $value) {
            $temp4 = Project::where(['id' => $value['id']])->first();
            $this_month[$key]['output'] = $temp4->unit_price * $value['label_number'];
            $this_month[$key]['salary'] = $temp4->label_unit_price * $value['label_number'] + $temp4->check_unit_price * $value['check_number'];
        }

//dd(json_encode($projectData));
// 直接渲染视图输出，Since v1.6.12=================================
        $content->view('employee_detail', ['employeeData' => $employeeData, 'current_project' => $current_project_str, 'projectData' => $projectData, 'performance' => $performance, 'last_month' => $last_month,'this_month' => $this_month]);

        return $content;
    }
}
