<?php

namespace App\Http\Controllers;

use CM;
use App\EntityStore;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Services\ContentModelService;

class ContentModelController extends Controller
{
    protected $contentModelService;

    public function __construct(ContentModelService $cm)
    {
        $this->contentModelService = $cm;
    }

    public function generateGraphQLSchema()
    {
    }

    public function tes()
    {
        $data_relation = array(
            "nama" => "Relasi Phone ke Customer",
            "description" => "Desc Phone ke customer",
            "type" => [
                "name" => "many-many",
                "modifier" => "belongsTo",
            ],
            "target_model" => [
                "name" => "customer"
            ],
        );

        $name = "phone";

        $fields = array(
            [
                "db_type" => "string",
                "display_name" => "Name",
                "name" => "name",
                "input_type" => "text",
                "max" => 100,
                "max_filesize" => null,
                "min" => 10,
                "required" => "required",
            ],
            [
                "db_type" => "string",
                "display_name" => "Alamat",
                "name" => "alamat",
                "input_type" => "text",
                "max" => null,
                "max_filesize" => null,
                "min" => null,
                "required" => null,
            ]
        );

        $this->generateTrait($name, $data_relation);
        $this->generateModel($name);
    }

    public function createPivotTableMigration($model1, $model2)
    {
        $model1_in_lowercase = Str::lower(Str::singular($model1));
        $model2_in_lowercase = Str::lower(Str::singular($model2));

        $model1_in_studly = Str::studly(Str::singular($model1));
        $model2_in_studly = Str::studly(Str::singular($model2));

        $fileName = date('Y_m_d_His') . '_' . 'create_' . strtolower($model1_in_lowercase . '_' . $model2_in_lowercase) . '_table.php';
        $path = database_path('migrations/' . $fileName);
        copy(resource_path('stubs/pivot_table_migration.stub'), $path);
        $templateData = file_get_contents($path);
        $templateData = str_replace('{Model1}', $model1_in_studly, $templateData);
        $templateData = str_replace('{Model2}', $model2_in_studly, $templateData);
        $templateData = str_replace('{Model1Lowercase}', $model1_in_lowercase, $templateData);
        $templateData = str_replace('{Model2Lowercase}', $model2_in_lowercase, $templateData);

        file_put_contents($path, $templateData);
    }

    public function isManytoMany($name, $relation_data = null)
    {
        if ($relation_data == null) {
            return;
        }

        foreach ($relation_data as $data) {
            $relation_type = $data["type"]["name"];
            $target = $data["target_model"]["name"];

            if ($relation_type == "many-many") {
                // many to many

                // create migration
                $compare_model_name = strcmp($target, $name);

                $model1 = null; //lebih kecil secara alphabet
                $model2 = null; //lebih beasr secara alphabet

                if ($compare_model_name < 0) {
                    $model1 = $target;
                    $model2 = $name;
                } else {
                    $model2 = $target;
                    $model1 = $name;
                }

                $this->createPivotTableMigration($model1, $model2);
            }
        }
    }

    protected function generateRequest($name, $fields, $requestType)
    {
        $name = underscore_to_space($name);
        $name_studly = Str::studly($name);

        $path = app_path('Http/Requests/');

        if (!file_exists($path))
            mkdir($path);

        $validation = '';
        foreach ($fields as $field) {
            $field_name = "
                    '" . $field['name'] . "'" . " => ";

            $required = $field['validation']['required'] != null ? "required" : "";

            $isRequestTypeisUpdate = $requestType == "Update";
            $isUniqueExist =  $field['validation']['unique'] != null;

            $unique = '';
            if ($isUniqueExist && $isRequestTypeisUpdate) {
                $unique = "| unique:" . Str::plural($name)  . "," . $field['name'] . "'.\$this->id,";
            } else if ($isUniqueExist) {
                $unique = "| unique:" . Str::plural($name)  . "," . $field['name'] . "',";
            } else {
                $unique = "',";
            }

            $max = $field['validation']['max'] != null ? "| max:" . $field['validation']['max'] : "";
            $min = $field['validation']['min'] != null ? "| min:" . $field['validation']['min'] : "";

            $validation .= $field_name . "'" . $required . $max . $min . $unique;
        };

        $path = app_path('Http/Requests/' . $name_studly . $requestType . 'Request.php');
        copy(resource_path('stubs/request.stub.php'), $path);
        $data = file_get_contents($path);
        $data = str_replace('{Model}', $name_studly . $requestType, $data);
        $data = str_replace('{Validation}', $validation, $data);
        file_put_contents($path, $data);
    }

    public function submitRelatedModel()
    {
        $id_of_selected_record = request()->data;
        $data_relation = request()->data_relation;

        if ($data_relation["name"] == "many-many") 
        {
            
        }

        return;
    }

    public function changeInputType($fields)
    {
        foreach ($fields as $key => $field) {
            if ($field["name"] === "password") {
                $fields[$key]["input_type"] = "password";
            }
            if ($field["name"] === "email") {
                $fields[$key]["input_type"] = "email";
            }
        }

        return $fields;
    }

    public function generate(Request $request)
    {
        // return 'ok';
        $properties = $request->properties;
        $fields = $request->fields_collection;
        $fields_in_html = $request->field_collection_in_html;
        $relation_data = $request->relation_data;
        $properties = json_decode($properties, true);
        $fields = $this->changeInputType($fields);
        $name = $properties["name"];
        $json_fields = $this->generateModelJson($fields, $properties);

        $this->insertCMInfo($properties, $json_fields);
        $this->isManytoMany($name, $relation_data);
        $this->generateMigration($name, $fields, $relation_data);
        $this->generateTrait($name, $relation_data);
        $this->pushRoute($name);
        $this->generateModel($name);
        $this->generateService($name);
        $this->generateRequest($name, $fields, "Create");
        $this->generateRequest($name, $fields, "Update");
        $this->generateController($name);
        $this->generateMenu($name);
        $this->generateView($name, $fields, $relation_data);

        // Artisan::call('migrate:fresh', [
        //     '--force' => true,
        // ]);
        Artisan::call('migrate');

        flash('Content Model created successfully')->success();

        // return redirect(route('content_model.index'));
    }

    public function loadRelatedModel()
    {
        $target_model = request()->target_model;

        $result = DB::table($target_model)->select('*')->get();

        return response()->json($result);
    }

    protected function generateView($name, $fields, $relation_data = null)
    {
        // return $fields;

        $name = Str::snake($name);
        $path = resource_path('views/' . Str::plural($name));
        if (!file_exists($path))
            mkdir($path);

        $vars = [
            'Name' => $name,
            'Plural' => Str::title(Str::plural($name)),
            'var' => Str::camel($name),
            'var_plural' => Str::camel(Str::plural($name)),
            'view' => Str::snake(Str::plural($name)),
            'route' => Str::kebab(underscore_to_space(Str::plural($name)))
        ];

        $files = [
            'index.stub.blade',
            'form.stub.blade',
            'create.stub.blade',
            'edit.stub.blade',
        ];

        $field_form = "";
        $field_index = "";
        $field_index_header = "";

        foreach ($fields as $field) {
            $field_form .= "@field([
                'label' => \"" . $field['display_name'] . "\",
                'name' => \"" . $field['name'] . "\",
                'type' => \"" . $field['input_type'] . "\",
                'validation'=>[
                    'required' => \"" . $field["validation"]['required'] . "\",
                    'unique' => \"" . $field["validation"]['unique'] . "\",
                    'max' => \"" . $field["validation"]['max'] . "\",
                    'min' => \"" . $field["validation"]['min'] . "\",
                ]
            ])\n";

            if ($field["input_type"] === "file") {
                $field_index .= "
                <td>
                    <img src=\"{{ asset($" . $vars['var'] . "->" . $field['name'] . " ) }}\" alt=\"\" width=\"50\" height=\"50\">
                </td>\n";
            } else {
                $field_index .= "<td>{{ $" . $vars['var'] . "->" . $field['name'] . " }}</td>\n";
            }

            $field_index_header .= "<th> " . $field['display_name'] . "</th>\n";
        };

        if ($relation_data != null) {
            foreach ($relation_data as $data_relation) {

                $field_form .= "
                    <div class=\"form-group row mb-4\">
                        <label for=\"field-title\" class=\"col-form-label text-md-right col-12 col-md-3 col-lg-3 \">"
                    . $data_relation["target_model"]["name"] . "
                        </label>
        
                        <div class=\"col-sm-12 col-md-7\">            
                            <button class=\"btn btn-primary\" type=\"button\" data-id=\"" . $data_relation["target_model"]["name"] . "\" id=\"selectRelation\" onclick=\"selectRelatedRelation('" . $data_relation["target_model"]["name"] . "," . $data_relation["type"]["name"] . "," . $data_relation["type"]["modifier"] . "')\")>Select " . $data_relation["target_model"]["name"] . "</button>
                        </div>
                    </div>\n";

                $field_index .= "<td>{{ $" . $vars['var'] . "->" . $data_relation["target_model"]["name"] . " }}</td>\n";

                $field_index_header .= "<th> " . $data_relation["target_model"]["name"] . "</th>\n";
            }
        }

        foreach ($files as $view) {
            $file = str_replace('stub.blade', 'blade.php', $view);
            copy(resource_path('stubs/' . $view), $path . '/' . $file);

            $data = file_get_contents($path . '/' . $file);
            $data = str_replace('{Name}', $vars['Name'], $data);
            $data = str_replace('{Plural}', $vars['Plural'], $data);
            $data = str_replace('{var}', $vars['var'], $data);
            $data = str_replace('{var_plural}', $vars['var_plural'], $data);
            $data = str_replace('{route}', $vars['route'], $data);
            $data = str_replace('{form_fields}', $field_form, $data);
            $data = str_replace('{index_fields}', $field_index, $data);
            $data = str_replace('{index_header_fields}', $field_index_header, $data);
            $data = str_replace('{view}', $vars['view'], $data);
            file_put_contents($path . '/' . $file, $data);
        }
    }

    public function generateTrait($name, $relation_data = null)
    {
        $name_singular = Str::singular($name);
        $name_studly = Str::studly($name_singular);

        $template = '';

        if ($relation_data != null) {
            foreach ($relation_data as $data) {
                $model_target = $data["target_model"]["name"];
                $model_target = Str::singular($model_target);
                $name_studly_target = Str::studly($model_target);

                $relation_type = $data["type"]["name"];
                $modifier = $data["type"]["modifier"];

                if (($relation_type == "one-many" && $modifier == "hasMany") || ($relation_type === "many-many")) {
                    $model_target = Str::plural($model_target);
                }

                $template .= '            
        public function ' . $model_target . '()
        {
            return $this->' . $modifier . '("App\\' . $name_studly_target . '");            
        }';
            }
        }

        $path = app_path('Traits/' . $name_studly . 'Trait.php');
        copy(resource_path('stubs/relation_trait.stub.php'), $path);
        $data = file_get_contents($path);
        $data = str_replace('{Name}', $name_studly, $data);

        if ($template != '') {
            $data = str_replace('{Relation}', $template, $data);
        } else {
            $data = str_replace('{Relation}', '', $data);
        }

        file_put_contents($path, $data);
    }

    public function load()
    {
        $entity = EntityStore::select(['id', 'table_name'])->get();

        return response()->json($entity);
    }

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

        // dd($cm);

        return view('content_model.index', compact('cm_list', 'cm'));
    }


    public function builder()
    {
        return view('content_model.builder');
    }

    public function edit($table_name)
    {
        $result = EntityStore::where('table_name', $table_name)->first();

        return response()->json($result);
    }


    public function deleteField(Request $request)
    {

        // drop table
        $exitCode = Artisan::call('cm:delete_field', [
            'args' => [$request->table_name, $request->field_name]
        ]);

        $this->updateJson($request->table_name, $request->model);
    }

    public function update(Request $request)
    {
        $entity = EntityStore::where('table_name', $request->model_table_name)->first();
        $entity->table_display_name = $request->model_dis_name;
        $entity->table_description = $request->model_desc;

        $status = $entity->save();

        if ($status) {
            $this->updateJson($request->model_table_name, $request->info_model);

            return response()->json([
                'message' => 'Data Update successfully!'
            ]);
        }

        return response()->json([
            'message' => 'Failed update'
        ]);
    }

    public function updateJson($table_name, $json)
    {
        $status = Storage::disk('cm')->put(Str::singular($table_name) . '.json', response()->json($json)->getContent());
    }

    public function save()
    {
    }

    public function destroy($table_name)
    {
        //delete entity record
        $removedTable = EntityStore::where('table_name', $table_name)->first()->delete();

        // dd($removedTable);

        // drop table
        $exitCode = Artisan::call('cm:delete', [
            'table_name' => $table_name
        ]);

        // delete json file
        $exitCode = Storage::disk('cm')->delete(Str::singular($table_name) . '.json');

        // remove route
        $this->removeRoute($table_name);

        // remove menu
        $this->removeMenu($table_name);

        // remove view
        $this->removeView($table_name);

        // remove controller
        $this->removeController($table_name);

        //delete trait
        $this->removeTrait($table_name);

        //delete Model
        $this->removeModel($table_name);

        // remove request
        $this->removeRequest($table_name);

        //remove services
        $this->removeService($table_name);

        flash('Content Model deleted successfully')->success();

        return redirect(route('content_model.index'));
    }

    public function removeModel($table_name)
    {
        $name_studly = Str::studly(Str::singular($table_name));
        $model_path = app_path($name_studly . '.php');

        if (file_exists($model_path)) {
            return unlink($model_path);
        };

        return false;
    }

    public function removeService($table_name)
    {
        $name = underscore_to_space($table_name);
        $name_studly = Str::studly(Str::singular($name));
        $path_service = app_path('Services/' . $name_studly . 'Service.php');

        if (file_exists($path_service)) {
            return unlink($path_service);
        }

        return false;
    }

    public function removeTrait($table_name)
    {
        $name = underscore_to_space($table_name);
        $name_studly = Str::studly(Str::singular($name));
        $path_trait = app_path('Traits/' . $name_studly . 'Trait.php');

        if (file_exists($path_trait)) {
            return unlink($path_trait);
        }

        return false;
    }

    public function removeRequest($table_name)
    {
        $name = underscore_to_space($table_name);
        $name_studly = Str::studly(Str::singular($name));
        $path_create = app_path('Http/Requests/' . $name_studly . 'CreateRequest.php');
        $path_update = app_path('Http/Requests/' . $name_studly . 'UpdateRequest.php');

        if (file_exists($path_create)) {
            unlink($path_create);
            return unlink($path_update);
        }

        return false;
    }

    public function removeController($table_name)
    {
        $name_singular = Str::singular($table_name);
        $name_singular_studly = Str::studly($name_singular);
        $path = app_path('Http/Controllers/' . $name_singular_studly . 'Controller.php');

        if (file_exists($path)) {
            return unlink($path);
        }

        return false;
    }

    public function removeView($table_name)
    {
        $path = resource_path('views/' . $table_name);

        if (file_exists($path)) {
            $status = $this->rrmdir($path);

            return $status;
        }

        return false;
    }

    function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        $this->rrmdir($dir . "/" . $object);
                    else unlink($dir . "/" . $object);
                }
            }
            reset($objects);

            return rmdir($dir);
        }
    }

    public function removeMenu($table_name)
    {
        $table_name = Str::singular($table_name);
        $name = underscore_to_space($table_name);
        $name_studly = underscore_to_space($name);
        $name_studly_plural = underscore_to_space($name_studly);
        $name_kebab = Str::kebab($name);
        $name_kebab_plural = Str::plural($name_kebab);

        $path = resource_path('views/partials/cm-menu.blade.php');
        $menu_contents = file_get_contents($path);
        $existing_menu_contents = file_get_contents($path);
        $menu_stub_path = resource_path('stubs/menu.stub');
        $menu_template = file_get_contents($menu_stub_path);
        $data = str_replace('{route}', $name_kebab_plural, $menu_template);
        $data = str_replace('{model}', $name_studly, $data);
        $data = str_replace('{modelPlural}', $name_studly_plural, $data);

        if (Str::contains($existing_menu_contents, $data)) {
            $new_menu = str_replace($data, '', $existing_menu_contents);
            file_put_contents($path, $new_menu);
        }
    }

    public function removeRoute($table_name)
    {
        $name_plural_kebab = Str::kebab($table_name);
        $name_plural_studly = Str::studly($table_name);

        $route_path = base_path('routes/cm/cm_route.php');
        $existing_route_contents = file_get_contents($route_path);
        $route_stub_path = resource_path('stubs/routes.stub');
        $route_template = file_get_contents($route_stub_path);

        $data = str_replace('{Route}', $name_plural_kebab, $route_template);
        $data = str_replace('{Model}', Str::singular($name_plural_studly), $data);

        if (Str::contains($existing_route_contents, $data)) {
            $new_routes = str_replace($data, '', $existing_route_contents);
            file_put_contents($route_path, $new_routes);
        }
    }

    public function getAttributes($cm_url = "blog_posts")
    {
        $cm_url_singular = Str::singular($cm_url);
        $json = Storage::disk('cm')->get($cm_url_singular . '.json');
        $json = json_decode($json, true);

        return $json;
    }

    public function layout()
    {
        return view('content_model.layout');
    }

    public function insertCMInfo($properties, $json_fields)
    {
        $name_plural = Str::plural($properties["name"]);
        $display_name = $properties["display_name"];
        $description = $properties["description"];

        //save entity
        $entity_store = EntityStore::firstOrCreate(
            [
                "table_name" => $name_plural,
                "table_display_name" => $display_name,
                "table_description" => $description,
                "field_collections" => $json_fields
            ]
        );

        $entity_store->users()->syncWithoutDetaching(Auth::user());
    }

    public function generateModelJson($fields, $properties)
    {
        $new = [];
        // $prop = json_decode($properties, true);
        $name = $properties["name"];

        foreach ($fields as $key => $value) {
            $new[$value['name']] = $value;
        }

        $data_model = [];
        $data_model["info"] = $properties;
        $data_model["attributes"] = $new;

        Storage::disk('cm')->put($name . '.json', response()->json($data_model)->getContent());
        $data_model = json_encode($data_model, JSON_PRETTY_PRINT);

        return $data_model;
    }

    public function pushRoute($name)
    {
        $name = underscore_to_space($name);
        $name_plural = Str::plural($name);
        $name_plural_kebab = Str::kebab($name_plural);
        $name_plural_studly = Str::studly($name);
        $route_path = base_path('routes/cm/cm_route.php');
        $route_contents = file_get_contents($route_path);
        $existing_route_contents = file_get_contents($route_path);
        $route_stub_path = resource_path('stubs/routes.stub');
        $route_template = file_get_contents($route_stub_path);
        $data = str_replace('{Route}', $name_plural_kebab, $route_template);
        $data = str_replace('{Model}', $name_plural_studly, $data);
        $route_contents .= "\n\n" . $data;

        if (!Str::contains($existing_route_contents, $data))
            file_put_contents($route_path, $route_contents);
    }


    protected function generateMenu($name)
    {
        $name = underscore_to_space($name);
        $name_studly = underscore_to_space($name);
        $name_studly_plural = underscore_to_space($name_studly);
        $name_kebab = Str::kebab($name);
        $name_kebab_plural = Str::plural($name_kebab);

        $path = resource_path('views/partials/cm-menu.blade.php');
        $menu_contents = file_get_contents($path);
        $existing_menu_contents = file_get_contents($path);
        $menu_stub_path = resource_path('stubs/menu.stub');
        $menu_template = file_get_contents($menu_stub_path);
        $data = str_replace('{route}', $name_kebab_plural, $menu_template);
        $data = str_replace('{model}', $name_studly, $data);
        $data = str_replace('{modelPlural}', $name_studly_plural, $data);
        $menu_contents .= "\n\n" . $data;

        if (!Str::contains($existing_menu_contents, $data))
            file_put_contents($path, $menu_contents);
    }

    protected function generateController($name)
    {
        $name = underscore_to_space($name);
        $name_studly = Str::studly($name);

        $vars = [
            'Model' => $name_studly,
            'serviceCamel' => Str::camel($name . 'Service'),
            'Service' => $name_studly . 'Service',
            'var_plural' => Str::camel(Str::plural($name)),
            'var' => Str::camel($name),
            'route' => Str::kebab(Str::plural($name)),
            'view' => Str::snake(Str::plural($name))
        ];

        $path = app_path('Http/Controllers/' . $vars['Model'] . 'Controller.php');
        copy(resource_path('stubs/controller.stub.php'), $path);
        $data = file_get_contents($path);
        $data = str_replace('{Model}', $vars['Model'], $data);
        $data = str_replace('{serviceCamel}', $vars['serviceCamel'], $data);
        $data = str_replace('{Service}', $vars['Service'], $data);
        $data = str_replace('{var_plural}', $vars['var_plural'], $data);
        $data = str_replace('{var}', $vars['var'], $data);
        $data = str_replace('{route}', $vars['route'], $data);
        $data = str_replace('{view}', $vars['view'], $data);
        file_put_contents($path, $data);
    }

    public function generateModel($name)
    {
        // $name = underscore_to_space($name);
        $name_studly = Str::studly($name);
        $name_plural = Str::plural($name);
        // dd($name_studly);
        $path = app_path($name_studly . '.php');
        copy(resource_path('stubs/model.stub.php'), $path);
        $data = file_get_contents($path);
        $data = str_replace('{Name}', $name_studly, $data);
        $data = str_replace('{plural}', $name_plural, $data);
        file_put_contents($path, $data);
    }


    public function create()
    {
        return view('content_model.create');
    }

    protected function generateService($name)
    {
        $name = underscore_to_space($name);
        $name_studly = Str::studly($name);
        $name_camel = Str::camel($name);
        $service = resource_path('stubs/service.stub.php');
        $path = app_path('Services/');

        if (!file_exists($path))
            mkdir(app_path('Services/'));

        $path = app_path('Services/' . $name_studly . 'Service.php');

        copy($service, $path);
        $data = file_get_contents($service);
        $data = str_replace('{Model}', $name_studly, $data);
        $data = str_replace('{var}', $name_camel, $data);
        file_put_contents($path, $data);
    }

    protected function generateMigration($name, $fields, $relation_data = null)
    {
        $name_plural = Str::plural($name);
        $name_plural_studly = Str::studly($name_plural);
        $fileName = date('Y_m_d_His') . '_' . 'create_' . strtolower($name_plural) . '_table.php';
        $path = database_path('migrations/' . $fileName);
        copy(resource_path('stubs/migration.stub'), $path);
        $templateData = file_get_contents($path);
        $templateData = str_replace('{TABLE_NAME_TITLE}', $name_plural_studly, $templateData);
        $templateData = str_replace('{TABLE_NAME}', $name_plural, $templateData);
        $fields_migration = $this->generateFields($fields);
        $templateData = str_replace('{FIELDS}', $fields_migration, $templateData);

        // for one many relationship

        if ($relation_data != null) {
            foreach ($relation_data as $data) {
                $relation_type = $data["type"]["name"];
                $target = $data["target_model"]["name"];
                $target = Str::singular($target);
                $modifier = $data["type"]["modifier"];

                if ($relation_type != "many-many" || ($relation_type == "one-many" && $modifier == 'hasMany')) {
                    $target .= "_id";
                    $structure = "\$table->unsignedBigInteger('$target');";
                    $templateData = str_replace('{FOREIGNKEY}', $structure, $templateData);
                } else {
                    $templateData = str_replace('{FOREIGNKEY}', "", $templateData);
                }
            }
        } else {
            $templateData = str_replace('{FOREIGNKEY}', "", $templateData);
        }

        file_put_contents($path, $templateData);
    }

    protected function generateFields($fields)
    {
        $fieldsnya = [];

        foreach ($fields as $field) {
            $fieldsnya[] = $this->prepareMigrationText($field['db_type'], $field['name'], $field['validation']);
        }

        return implode(infy_nl_tab(1, 3), $fieldsnya);
    }

    protected function prepareMigrationText($fieldnya, $name, $validation)
    {
        $inputsArr = explode(':', $fieldnya);
        $migration_text = '$table->';

        $fieldTypeParams = explode(',', array_shift($inputsArr));
        $fieldType = array_shift($fieldTypeParams);

        $migration_text .= $fieldType . "('" . $name . "'";

        if ($fieldType == 'enum') {
            $migration_text .= ', [';
            foreach ($fieldTypeParams as $param) {
                $migration_text .= "'" . $param . "',";
            }
            $migration_text = substr($migration_text, 0, strlen($migration_text) - 1);
            $migration_text .= ']';
        } else {
            foreach ($fieldTypeParams as $param) {
                $migration_text .= ', ' . $param;
            }
        }

        $migration_text .= ')';

        if ($validation["unique"] != null) {
            $migration_text .= "->unique()";
        };

        foreach ($inputsArr as $input) {
            $inputParams = explode(',', $input);
            $functionName = array_shift($inputParams);
            if ($functionName == 'foreign') {
                $foreignTable = array_shift($inputParams);
                $foreignField = array_shift($inputParams);
                $this->foreignKeyText .= "\$table->foreign('" . $name . "')->references('" . $foreignField . "')->on('" . $foreignTable . "');";
            } else {
                $migration_text .= '->' . $functionName;
                $migration_text .= '(';
                $migration_text .= implode(', ', $inputParams);
                $migration_text .= ')';
            }
        }

        $migration_text .= ';';

        return $migration_text;
    }
}
