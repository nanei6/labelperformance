<?php

namespace App\Admin\Controllers;

use App\Models\Cost;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '成本';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new cost);


        $grid->column('social_security', __('社保费用'));
        $grid->column('social_security_per_person', __('社保平均每人费用'));
        $grid->column('chummage', __('房租'));
        $grid->column('property_fee', __('物业费'));
        $grid->column('travel_expenses', __('差旅费用'));
        $grid->column('entertainment_expenses', __('招待费用'));
        $grid->column('date', __('日期'))->display(function ($entry_time) {
            return date('Y-m',strtotime($entry_time));
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
        $show = new Show(cost::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('social_security', __('社保费用'));
        $show->field('social_security_per_person', __('社保平均每人'));
        $show->field('chummage', __('房租'));
        $show->field('property_fee', __('物业费'));
        $show->field('travel_expenses', __('差旅费用'));
        $show->field('entertainment_expenses', __('招待费用'));
        $show->field('date', __('日期'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new cost);

        $form->text('social_security', __('社保费用'));
        $form->text('social_security_per_person', __('社保平均每人'));
        $form->text('chummage', __('房租'));
        $form->text('property_fee', __('物业费'));
        $form->text('travel_expenses', __('差旅费用'));
        $form->text('entertainment_expenses', __('招待费用'));
        $form->datetime('date', __('日期'))->format('YYYY-MM')->required();;

        return $form;
    }
}
