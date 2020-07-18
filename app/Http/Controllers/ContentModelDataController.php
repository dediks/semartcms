<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentModelDataController extends Controller
{
    public function batchDestroy()
    {
        $tableName = request()->table_name;
        $ids = request()->ids;

        $deleted = DB::table($tableName)->whereIn("id", $ids)->delete();

        return response()->json($deleted);
    }
}
