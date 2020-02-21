<?php

namespace App\Admin\Controllers;

use App\Models\Project;
use App\Models\UserProjectDay;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\User;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Table;

class ProjectController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '项目';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Project);
//        $grid->model()->where('status', '=', '未完成');
        $grid->column('id', __('Id'));
        $grid->column('name', __('项目名'));
//        $grid->column('group_leaders', __('分管组长'))->display(function ($group_leaders) {
//            return implode(',', $group_leaders);
//        });
        $grid->column('group_leaders', __('分管组长'))->label();
        $grid->column('checkers', __('审核员'))->label();
        $grid->column('speed_test', __('测速员'))->label();
        $grid->column('manager', __('项目经理'))->label();
        $grid->column('start_time', __('开始时间'));
        $grid->column('estimated_time', __('预计完成时间'));
        $grid->column('finish_time', __('实际完成时间'));
        $grid->column('source', __('项目来源'));
        $grid->column('accuracy_rate', __('准确率要求'));
        $grid->column('estimated_count', __('预计总量'));
        $grid->column('accepted_count', __('入库量'));
        $grid->column('unit_price', __('单价'));
        $grid->column('label_unit_price', __('标注单价'));
        $grid->column('check_unit_price', __('审核单价'));
        $grid->column('estimated_total_revenue', __('预计总收入'));
        $grid->column('total_revenue', __('总收入'));
        $grid->column('status', __('状态'));
        $grid->column('progress', __('进度'))->progressBar($style = 'primary', $size = 'sm', $max = 100);


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    //详情页用show方法，detail弃用;如需启动记得补充字段
//    protected function detail($id)
//    {
//        $show = new Show(Project::findOrFail($id));
//
//        $show->field('id', __('Id'));
//        $show->field('name', __('项目名称'));
//        $show->field('group_leaders', __('分管组长'))->label();
//        $show->field('checkers', __('审核员'))->label();
//        $show->field('manager', __('项目经理'))->label();
//        $show->field('start_time', __('开始时间'));
//        $show->field('estimated_time', __('预计完成时间'));
//        $show->field('finish_time', __('实际完成时间'));
//        $show->field('estimated_count', __('预计总量'));
//        $show->field('summary', __('项目简介'));
//        $show->field('unit_price', __('单价'));
//        $show->field('estimated_total_revenue', __('预计总收入'));
//        $show->field('total_revenue', __('总收入'));
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
        $form = new Form(new Project);

        $form->text('name', __('项目名称'))->required();
        $form->datetime('start_time', __('开始时间'))->required();
        $form->datetime('estimated_time', __('预计完成时间'))->required();
        $form->datetime('finish_time', __('实际完成时间'));
        $form->text('source', __('项目来源'))->required();
        $form->decimal('accuracy_rate', __('准确率要求'))->required();
        $form->number('estimated_count', __('预计总量'))->required();
        $form->number('accepted_count', __('入库量'));
        $form->text('summary', __('项目简介'));
        $form->decimal('unit_price', __('单价'))->required();
        $form->decimal('label_unit_price', __('标注单价'))->required();
        $form->decimal('check_unit_price', __('审核单价'))->required();
        $form->decimal('total_revenue', __('总收入'));

        $user_groups = User::select('name')->where(['type' => '组长'])->get()->toArray();
        $groups = [];
        foreach ($user_groups as $user_group) {
            $groups[$user_group['name']] = $user_group['name'];
        }
        $form->multipleSelect('group_leaders', '分管项目组长')->options($groups);

        //所有人都可以当审核员或项目经理或测速员
        $users = User::select('name')->get()->toArray();
        $users_option = [];
        foreach ($users as $user) {
            $users_option[$user['name']] = $user['name'];
        }
        $form->multipleSelect('checkers', '审核员')->options($groups);
        $form->multipleSelect('manager', '项目经理')->options($users_option);
        $form->multipleSelect('speed_test', '测速员')->options($users_option);


        $status = [
            '未完成' => '未完成',
            '已完成' => '已完成'
        ];
        $form->select('status', __('状态'))->options($status)->required();
        return $form;
    }


    public function show($id, Content $content)
    {

        // 选填
        $content->header('项目详情');

        // 选填
        $content->description('');

        // 添加面包屑导航 since v1.5.7
        $content->breadcrumb(
            ['text' => '首页', 'url' => '/'],
            ['text' => '项目', 'url' => '/projects'],
            ['text' => '项目详情']
        );

//        // 填充页面body部分，这里可以填入任何可被渲染的对象
//        $content->body('<b>hello world</b>');


        //数据
        $project_data = Project::find($id)->toArray();
        //【项目基础信息】

        $project_data['checkers'] = implode('，', $project_data['checkers']);
        $project_data['speed_test'] = implode('，', $project_data['speed_test']);
        $project_data['manager'] = implode('，', $project_data['manager']);
        $project_data['group_leaders'] = implode('，', $project_data['group_leaders']);

        //时间进度
        $start_time = strtotime($project_data['start_time']);
        $estimated_time = strtotime($project_data['estimated_time']);
        $now = time();
        if ($estimated_time <= $start_time) {
            $time_progress = 0;
        } else {
            $time_progress = round(($now - $start_time) / ($estimated_time - $start_time), 3);
        }
        $time_progress = $time_progress * 100 . '%';
        //标注进度
        $estimated_count = $project_data['estimated_count'];
        $actual_label_count = UserProjectDay::where(['project_id' => $id])->sum('daily_label');
        $label_progress = round($actual_label_count / $estimated_count, 3);
        $label_progress = $label_progress . '%';
        //审核进度
        $actual_check_count = UserProjectDay::where(['project_id' => $id])->sum('daily_check');
        $check_progress = round($actual_check_count / $estimated_count, 3);
        $check_progress = $check_progress . '%';


        //近两周的日期
        $last_two_weeks = [];
        $curtime = time();
        for ($i = 1; $i < 14; $i++) {
            $last_two_weeks[] = date('Y-m-d', $curtime - $i * 86400);
        }
        $daily_total = [];
        foreach ($last_two_weeks as $day) {
            $sum = UserProjectDay::where(['date' => $day, 'project_id' => $id])->sum('daily_label');
            if ($sum == 0) {
                $avg = 0;
            } else {
                $avg = $sum / UserProjectDay::where(['date' => $day, 'project_id' => $id])->count();
            }
            $daily_total[$day] = ['sum' => (integer)$sum, 'avg' => $avg];
        }

        $daily_total_format = [['name' => '人均标注量', 'date1' => $daily_total[$last_two_weeks[0]]['avg'], 'date2' => $daily_total[$last_two_weeks[1]]['avg'], 'date3' => $daily_total[$last_two_weeks[2]]['avg'], 'date4' => $daily_total[$last_two_weeks[3]]['avg'], 'date5' => $daily_total[$last_two_weeks[4]]['avg'], 'date6' => $daily_total[$last_two_weeks[5]]['avg'], 'date7' => $daily_total[$last_two_weeks[6]]['avg'], 'date8' => $daily_total[$last_two_weeks[7]]['avg'], 'date9' => $daily_total[$last_two_weeks[8]]['avg'], 'date10' => $daily_total[$last_two_weeks[9]]['avg'], 'date11' => $daily_total[$last_two_weeks[10]]['avg'], 'date12' => $daily_total[$last_two_weeks[11]]['avg']],
            ['name' => '总标注量', 'date1' => $daily_total[$last_two_weeks[0]]['sum'], 'date2' => $daily_total[$last_two_weeks[1]]['sum'], 'date3' => $daily_total[$last_two_weeks[2]]['sum'], 'date4' => $daily_total[$last_two_weeks[3]]['sum'], 'date5' => $daily_total[$last_two_weeks[4]]['sum'], 'date6' => $daily_total[$last_two_weeks[5]]['sum'], 'date7' => $daily_total[$last_two_weeks[6]]['sum'], 'date8' => $daily_total[$last_two_weeks[7]]['sum'], 'date9' => $daily_total[$last_two_weeks[8]]['sum'], 'date10' => $daily_total[$last_two_weeks[9]]['sum'], 'date11' => $daily_total[$last_two_weeks[10]]['sum'], 'date12' => $daily_total[$last_two_weeks[11]]['sum']]];
//        dd($daily_total_format);

        //产值排行(只看标注量)
        $performance_this_project = UserProjectDay::where(['project_id' => $id])->get()->toArray();
        //dd($performance_this_project);
        $employee_numbers = [];
        foreach ($performance_this_project as $value) {
            $employee_numbers[] = $value['employee_number'];
        }
        $employee_numbers = array_unique($employee_numbers);
        //项目下所有人的标注总量
        $employee_performance = [];
        foreach ($employee_numbers as $employee_number) {
            $employee_performance[$employee_number] = 0;
            foreach ($performance_this_project as $value) {
                if ($value['employee_number'] == $employee_number) {
                    $employee_performance[$employee_number] += $value['daily_label'];
                }
            }

        }
        //排序
        array_multisort($employee_performance, SORT_DESC);
        $top3 = array_slice($employee_performance, 0, 3);
        //根据工号查名字和标注天数
        $top3_fommat = [];
        //键是工号，值是标注总量
        foreach ($top3 as $key => $value) {
            $employee_name = User::where(['employee_number' => $key])->first()->name;
            $label_days = UserProjectDay::where(['project_id' => $id, 'employee_number' => $key])->count();
            $top3_fommat[] = ['name' => $employee_name, 'label_total' => $value, 'employee_number' => $key, 'label_days' => $label_days];
        }
        $bottom3 = array_slice($employee_performance, count($employee_performance) - 3, 3);
        $bottom3_fommat = [];
        //键是工号，值是标注总量
        foreach ($bottom3 as $key => $value) {
            $employee_name = User::where(['employee_number' => $key])->first()->name;
            $label_days = UserProjectDay::where(['project_id' => $id, 'employee_number' => $key])->count();
            $bottom3_fommat[] = ['name' => $employee_name, 'label_total' => $value, 'employee_number' => $key, 'label_days' => $label_days];
        }
        //项目当前收入
        $current_total_income = $project_data['accepted_count'] * $project_data['unit_price'];
        //项目当前最大收入
        $current_total_income_max = array_sum($employee_performance) * $project_data['unit_price'];
        //标注总人天数
        $label_total_user_day = UserProjectDay::where(['project_id' => $id])->where('daily_label', '>', '0')->count();
        //审核总人天数
        $check_total_user_day = UserProjectDay::where(['project_id' => $id])->where('daily_check', '>', '0')->count();
        //标注基础成本支出
        $label_base_cost = $label_total_user_day * 76;
        //审核基础成本支出
        $check_base_cost = $check_total_user_day * 76;
        //标注绩效支出
        $label_performance_cost = array_sum($employee_performance) * $project_data['label_unit_price'];
        //审核绩效支出
        $check_sum = UserProjectDay::where(['project_id' => $id])->sum('daily_check');
        $check_performance_cost = $check_sum * $project_data['check_unit_price'];
        //项目当前收益
        $current_revenue = $current_total_income - $label_base_cost - $check_base_cost - $label_performance_cost - $check_performance_cost;
        //项目当前最大可能收益
        $current_revenue_max = $current_total_income_max - $label_base_cost - $check_base_cost - $label_performance_cost - $check_performance_cost;
        //项目潜在标注绩效成本
        $label_potential_cost = ($project_data['estimated_count'] - array_sum($employee_performance)) * $project_data['label_unit_price'];
        //项目潜在审核绩效成本
        $check_potential_cost = ($project_data['estimated_count'] - $check_sum) * $project_data['label_unit_price'];
        //剩余标注人天数
        $last_label = UserProjectDay::where(['project_id' => $id])->where('daily_label', '>', 0)->orderBy('date', 'desc')->first();
        if (!empty($last_label)) {
            $last_label_date = $last_label->date;
        }
        $last_avg_label_user_day = UserProjectDay::where(['project_id' => $id, 'date' => $last_label_date])->avg('daily_label');
        $surplus_label_user_day = ($project_data['estimated_count'] - array_sum($employee_performance)) / $last_avg_label_user_day;
        //剩余审核人天数
        $last_check = UserProjectDay::where(['project_id' => $id])->where('daily_check', '>', 0)->orderBy('date', 'desc')->first();
        if (!empty($last_check)) {
            $last_check_date = $last_check->date;
            $last_avg_check_user_day = UserProjectDay::where(['project_id' => $id, 'date' => $last_check_date])->avg('daily_label');
            $surplus_check_user_day = ($project_data['estimated_count'] - $check_sum) / $last_avg_check_user_day;
            //剩余标注基础成本
            $surplus_label_base_cost = $surplus_label_user_day * 76;
            //剩余审核基础成本
            $surplus_check_base_cost = $surplus_check_user_day * 96;
            //项目预计最终收益
            $project_estimated_finial_revenue = $current_revenue - $surplus_label_base_cost - $surplus_check_base_cost;

        } else {
            $surplus_check_user_day = 'no data';
            $surplus_label_base_cost='no data';
            $project_estimated_finial_revenue='no data';
            $surplus_check_base_cost='no data';
        }


        $revenue_data = [
            'current_total_income' => $current_total_income,
            'current_total_income_max' => $current_total_income_max,
            'label_total_user_day' => $label_total_user_day,
            'check_total_user_day' => $check_total_user_day,
            'label_base_cost' => $label_base_cost,
            'check_base_cost' => $check_base_cost,
            'label_performance_cost' => $label_performance_cost,
            'check_performance_cost' => $check_performance_cost,
            'current_revenue' => $current_revenue,
            'current_revenue_max' => $current_revenue_max,
            'label_potential_cost' => $label_potential_cost,
            'check_potential_cost' => $check_potential_cost,
            'surplus_label_user_day' => $surplus_label_user_day,
            'surplus_check_user_day' => $surplus_check_user_day,
            'surplus_label_base_cost' => $surplus_label_base_cost,
            'surplus_check_base_cost' => $surplus_check_base_cost,
            'project_estimated_finial_revenue' => $project_estimated_finial_revenue,

        ];


//         // 直接渲染视图输出，Since v1.6.12
        $content->view('projectdetail', ['project_data' => $project_data, 'time_progress' => $time_progress, 'label_progress' => $label_progress, 'check_progress' => $check_progress, 'last_two_weeks' => $last_two_weeks, 'daily_total_format' => $daily_total_format, 'top3' => $top3_fommat, 'bottom3' => $bottom3_fommat, 'revenue_data' => $revenue_data]);

        return $content;
    }
}
