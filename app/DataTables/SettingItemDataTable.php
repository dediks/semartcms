<?php

namespace App\DataTables;

use App\SettingItem;
use Yajra\DataTables\Services\DataTable;
use FieldHelper;

class SettingItemDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->editColumn('group', function(SettingItem $model) {
                return $model->group->display_name;
            })
            ->editColumn('type', function(SettingItem $model) {
                return FieldHelper::getDisplayName($model->type);
            })
            ->addColumn('action', function(SettingItem $model) {
                $route = 'setting_items';
                return view('layouts.datatable_action', compact('model', 'route'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\SettingItem $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SettingItem $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '200px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name',
            'display_name',
            [
                'name' => 'group',
                'title' => 'Group',
                'data' => 'group',
                'orderable' => false,
                'searchable' => false
            ],
            'type',
            'created_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'SettingItem_' . date('YmdHis');
    }
}
