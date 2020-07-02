<?php

namespace Modules\ContentModelGenerator\Http\Controllers;

use Modules\ContentModelGenerator\Entities\EntityStore;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Services\ContentModelService;

class ContentModelGeneratorController extends Controller
{
    public function index($cm_url = 'index')
    {
        $cm = EntityStore::where('table_name', $cm_url)->first();
        $cm_list = EntityStore::all();

        if (!$cm && $cm_url == 'index') {
            $cm = [
                'table_display_name' => 'Index',
                'table_description' => 'Manage Your Content Model',
                'table_name' => null
            ];

            $cm = (object) $cm;
        }

        return view('contentmodelgenerator::index', compact('cm_list', 'cm'));
    }

    public function create()
    {
        
        return view('contentmodelgenerator::create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        return view('contentmodelgenerator::show');
    }

    public function edit($id)
    {
        return view('contentmodelgenerator::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
