<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentModelGeneratorController extends Controller
{
    public function builder()
    {
        // $this->loadFields();
        return view('content_model_generator.builder');
    }
    public function generate()
    {
    }

    public function loadFields($type, $file)
    {
        $path = resource_path("stuff/files/" . $file . "." . $type);
        if (file_exists($path)) {
            $content = file_get_contents($path);
            if ($type == 'json') {
                $content = json_decode($content);
            }
            return response(['data' => $content], 200);
        }
        return response(['data' => "File can't be found (" . $path . ")"], 404);
    }
}
