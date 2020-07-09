<?php

namespace App\DataTables;

use App\Permission;
use Yajra\DataTables\Services\DataTable;

class PermissionDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables($query)
            ->rawColumns(['action'])
            ->addColumn('action', function (Permission $model) {
                $route = 'permission';
                return view('layouts.datatable_action', compact('model', 'route'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Permission $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Permission $model)
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
            'guard_name',
            'created_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Permission_' . date('YmdHis');
    }
}
