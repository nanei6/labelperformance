<?php

namespace App\Admin\Controllers;

use App\Models\Project;
use App\Models\UserProjectDay;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;
use App\Models\User;

class UserProjectDayController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '员工日工作情况';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserProjectDay);

        $grid->column('user.name', __('员工名'));
        $grid->column('project.name', __('项目名'));
        $grid->column('date', __('日期'))->display(function ($date) {
            return date('Y-m-d', strtotime($date));
        });
        $grid->column('workload', __('日工作量'));
        $grid->column('daily_standard', __('日标注标准量'));
        $grid->column('daily_label', __('日标注量'));
        $grid->column('standard_check', __('日审核标准量'));
        $grid->column('daily_check', __('日审核量'));


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(UserProjectDay::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('employee_number', __('工号'));
        $show->field('project_id', __('项目ID'));
        $show->field('date', __('日期'));
        $show->field('workload', __('日工作量'));
        $show->field('daily_standard', __('日标注标准量'));
        $show->field('daily_label', __('日标注量'));
        $show->field('standard_check', __('日审核标准量'));
        $show->field('daily_check', __('日审核量'));
        $show->user('用户信息', function ($user) {
            $user->name('用户名');
        });
        $show->project('项目信息', function ($user) {
            $user->name('项目名');
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserProjectDay);

        //成员选择
        $user_info = User::select(['name', 'employee_number'])->where(['status' => '正常'])->get()->toArray();
        $employee_numbers = [];
        foreach ($user_info as $value) {
            $employee_numbers[$value['employee_number']] = $value['name'];
        }
        $form->select('employee_number', __('选择成员'))->options($employee_numbers);


        //项目列表
        $projecrt_info = Project::select(['name', 'id'])->get()->toArray();
        $project_ids=[];
        foreach ($projecrt_info as $value){
            $project_ids[$value['id']]=$value['name'];
        }


        //项目默认上次填写
        $user_project_day=UserProjectDay::orderBy('id','desc')->first();
        if($user_project_day==null){
            $default_project_id=1;
    }else{
            $default_project_id=$user_project_day->project_id;
        }
        $form->select('project_id', __('选择项目'))->options($project_ids)->default($default_project_id);


        //日期默认今天
        $form->datetime('date', __('日期'))->format('YYYY-MM-DD')->default(date('Y-m-d',time()));

       //日工作量默认1
        $form->decimal('workload',__('日工作量(0.1-1)'))->default(1);


        //日标准量默认上次填写
        if($user_project_day==null){
            $default_daily_standard=0;
            $default_check_standard=0;
        }else{
            $default_daily_standard=$user_project_day->daily_standard;
            $default_check_standard=$user_project_day->standard_check;
        }
        $form->number('daily_standard', __('日标注标准量'))->default($default_daily_standard);
        $form->number('daily_label', __('日标注量'))->default(0);

        $form->number('standard_check', __('日审核标准量'))->default($default_check_standard);
        $form->number('daily_check', __('日审核量'))->default(0);

        return $form;
    }
}
