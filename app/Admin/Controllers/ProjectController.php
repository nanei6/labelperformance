<?php

namespace App\Admin\Controllers;

use App\Models\Project;
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
        $grid->column('manager', __('项目经理'))->label();
        $grid->column('start_time', __('开始时间'));
        $grid->column('estimated_time', __('预计完成时间'));
        $grid->column('finish_time', __('实际完成时间'));
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
    protected function detail($id)
    {
        $show = new Show(Project::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('项目名称'));
        $show->field('group_leaders', __('分管组长'))->label();
        $show->field('checkers', __('审核员'))->label();
        $show->field('manager', __('项目经理'))->label();
        $show->field('start_time', __('开始时间'));
        $show->field('estimated_time', __('预计完成时间'));
        $show->field('finish_time', __('实际完成时间'));
        $show->field('estimated_count', __('预计总量'));
        $show->field('summary', __('项目简介'));
        $show->field('unit_price', __('单价'));
        $show->field('estimated_total_revenue', __('预计总收入'));
        $show->field('total_revenue', __('总收入'));
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
        $form = new Form(new Project);

        $form->text('name', __('项目名称'))->required();
        $form->datetime('start_time', __('开始时间'))->required();
        $form->datetime('estimated_time', __('预计完成时间'))->required();
        $form->datetime('finish_time', __('实际完成时间'));
        $form->number('estimated_count', __('预计总量'))->required();
        $form->number('accepted_count', __('入库量'));
        $form->text('summary', __('项目简介'));
        $form->decimal('unit_price', __('单价'));
        $form->decimal('label_unit_price', __('标注单价'));
        $form->decimal('check_unit_price', __('审核单价'));
        $form->decimal('total_revenue', __('总收入'));

        $user_groups = User::select('name')->where(['type' => '组长'])->get()->toArray();
        $groups = [];
        foreach ($user_groups as $user_group) {
            $groups[$user_group['name']] = $user_group['name'];
        }
        $form->multipleSelect('group_leaders', '分管项目组长')->options($groups);

        //所有人都可以当审核员或项目经理
        $users = User::select('name')->get()->toArray();
        $users_option = [];
        foreach ($users as $user) {
            $users_option[$user['name']] = $user['name'];
        }
        $form->multipleSelect('checkers', '审核员')->options($groups);
        $form->multipleSelect('manager', '项目经理')->options($users_option);


        $status = [
            '未完成' => '未完成',
            '已完成' => '已完成'
        ];
        $form->select('status', __('状态'))->options($status)->required();
        return $form;
    }


//    public function show($id, Content $content)
//    {
//
//        // 选填
//        $content->header('项目详情');
//
//        // 选填
//        $content->description('');
//
//        // 添加面包屑导航 since v1.5.7
//        $content->breadcrumb(
//            ['text' => '首页', 'url' => '/'],
//            ['text' => '项目', 'url' => '/projects'],
//            ['text' => '项目详情']
//        );
//
////        // 填充页面body部分，这里可以填入任何可被渲染的对象
////        $content->body('<b>hello world</b>');
//
//
//        //数据
//
//
//
//        // 直接渲染视图输出，Since v1.6.12
//        $content->view('projectdetail', ['data' => 'foo']);
//
//        return $content;
//    }
}
