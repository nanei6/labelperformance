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
        $grid->column('daily_standard', __('日标准量'));
        $grid->column('daily_label', __('日标注量'));


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

        $show->field('id', __('Id'));
        $show->field('employee_number', __('Employee number'));
        $show->field('project_id', __('Project id'));
        $show->field('date', __('Date'));
        $show->field('daily_standard', __('Daily standard'));
        $show->field('daily_label', __('Daily label'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

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

        //
        //组长只能添加自己的组员
        $admin_name = Admin::user()->name;
        $user_info = User::select(['name', 'employee_number'])->where(['group' => $admin_name, 'status' => '正常', 'type' => '组员'])->get()->toArray();
        $employee_numbers = [];
        foreach ($user_info as $value) {
            $employee_numbers[$value['employee_number']] = $value['name'];
        }
        $form->select('employee_number', __('选择组员'))->options($employee_numbers);


        //
        //组长只能添加自己分管的未完成的项目
        $projecrt_info = Project::select(['name', 'id'])->where('group_leaders', 'like', '%' . $admin_name . '%')->get()->toArray();
        $project_ids=[];
        foreach ($projecrt_info as $value){
            $project_ids[$value['id']]=$value['name'];
        }
        $form->select('project_id', __('选择项目'))->options($project_ids);
        $form->datetime('date', __('日期'))->format('YYYY-MM-DD');
        $form->number('daily_standard', __('日标准量'));
        $form->number('daily_label', __('日标注量'));

        return $form;
    }
}
