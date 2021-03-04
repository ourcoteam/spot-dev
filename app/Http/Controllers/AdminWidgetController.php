<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AdminContainer;
use App\AdminContainerWidget;
use App\AdminWidget;

class AdminWidgetController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|max:255',
            'value' => 'nullable|max:294967295',
            'link' => 'nullable|max:255',
            // 'sort' => 'nullable|integer',
            'class' => 'nullable|max:255',
            // 'container_id' => 'required|exists:admin_containers,id',
        ]);
        // $container = AdminContainer::find($request->container_id);
        // $sort = ($container->item->last()->sort ?? -1) + 1 ;

        $widget = new AdminWidget();
        $widget->title = $request->title;
        $widget->value = $request->value;
        $widget->link = $request->link;
        // $widget->sort = $sort;
        $widget->class = $request->class;
        // $widget->widget_id = $request->widget_id;
        $widget->save();

        flash(translate('New widget has been created successfully'))->success();
        return redirect()->route('website.container.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:admin_widgets,id',
            'title' => 'nullable|max:255',
            'value' => 'nullable|max:294967295',
            'link' => 'nullable|max:255',
            'class' => 'nullable|max:255',
        ]);
        $widget = new AdminWidget();
        $widget->title = $request->title;
        $widget->link = $request->link;
        $widget->sort = $request->sort;
        $widget->class = $request->class;
        $widget->widget_id = $request->widget_id;
        $widget->save();

        flash(translate('New widget has been created successfully'))->success();
        return redirect()->route('website.container.index');
    }

    public function update_container_widget(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:admin_container_widgets,id',
            'title' => 'nullable|max:255',
            'value' => 'nullable|max:294967295',
            'link' => 'nullable|max:255',
            'class' => 'nullable|max:255',
        ]);
        $widget = AdminContainerWidget::find($request->id);
        $widget->title = $request->title;
        $widget->value = $request->value;
        $widget->link = $request->link;
        $widget->class = $request->class;
        $widget->save();

        flash(translate('New widget has been updated successfully'))->success();
        return redirect()->route('website.container.index');
    }

    public function clone(Request $request)
    {
        $request->validate([
            'container_widgets' => 'required|array',
            // 'container_widgets.*' => 'required|exists:admin_container_widgets,id',
            'widget_id' => 'required|exists:admin_widgets,id', // container_widget belongs to this widget 
            'container_id' => 'required|exists:admin_containers,id',
            'source' => 'nullable|exists:admin_containers,id',
        ]);
        // return $request;
        $new_container_widget_id = 0;

        foreach ($request->container_widgets as $key => $container_widget_id) {
            $container_widget = AdminContainerWidget::find($container_widget_id);
            if($container_widget){
                // return $container_widget;
                $container_widget->container_id = $request->container_id;
                $container_widget->sort = $key;
                $container_widget->save();
            }else{
                $widget = AdminWidget::find($request->widget_id); // container_widget belongs to this widget 
                $container_widget = new AdminContainerWidget();
                $container_widget->title = $widget->title;
                $container_widget->value = $widget->value;
                $container_widget->link = $widget->link;
                $container_widget->sort = $key;
                $container_widget->class = $widget->class;
                $container_widget->widget_id = $widget->id;
                $container_widget->container_id = $request->container_id;
                // return $container_widget;
                $container_widget->save();
                $new_container_widget_id = $container_widget->id; 
            }
        }
        return ['id'=>$new_container_widget_id,'message'=>"Widget has been Added successfully!"];
        
    }

    public function destroy($id)
    {
        $widget = AdminWidget::findOrFail($id);
        $widget->delete();
        flash(translate('Widget has been deleted successfully'))->success();
        return redirect()->back();
    }

    public function destroy_container_widget($id)
    {
        $container_widget = AdminContainerWidget::findOrFail($id);
        $container_widget->delete();
        flash(translate('Widget has been deleted successfully'))->success();
        return redirect()->back();
    }
}
