<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

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

        $grid->column('name', __('姓名'));
        $grid->column('employee_number', __('工号'));
        $grid->column('group', __('组名'));
        $grid->column('type', __('类型'));
        $grid->column('status', __('状态'));
        $grid->column('entry_time', __('入职时间'))->display(function ($entry_time) {
            return date('Y-m-d',strtotime($entry_time));
        });


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
        $show = new Show(User::findOrFail($id));

        $show->field('name', __('名字'));

        $show->field('employee_number', __('工号'));
        $show->field('group', __('组名'));
        $show->field('type', __('类型'));
        $show->field('entry_time', __('入职时间'));
        $show->field('status', __('状态'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('修改时间'));

        return $show;
    }

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
        $user_groups=User::select('name')->where(['type'=>'组长'])->get()->toArray();
        $groups=['无分组'=>'无分组'];
        foreach ($user_groups as $user_group){
            $groups[$user_group['name']]=$user_group['name'];
        }

        $form->select('group', __('组名'))->options($groups)->required();
        $types=[
            '组长'=>'组长',
            '组员'=>'组员',
        ];
        $form->select('type', __('类型'))->options($types);
        $form->datetime('entry_time', __('入职时间'))->format('YYYY-MM-DD')->required();
        $status=[
            '正常'=>'正常',
            '禁用'=>'禁用',
            '删除'=>'删除'
        ];
        $form->select('status', __('状态'))->options($status)->required();

        return $form;
    }
}
