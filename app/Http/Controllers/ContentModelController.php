<?php

namespace App\Http\Controllers;

use CM;
use App\EntityStore;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Services\ContentModelService;

class ContentModelController extends Controller
{  
    protected $contentModelService;

    public function __construct(ContentModelService $cm)
    {
        $this->contentModelService = $cm;
    }

    public function edit($table_name){
        $result = EntityStore::where('table_name', $table_name)->first();

        return response()->json($result);
    }

    public function index($cm_url = 'index'){        

        $cm = EntityStore::where('table_name', $cm_url)->first();        
        $cm_list = EntityStore::all();       
        
        if(!$cm && $cm_url == 'index'){
            $cm = [
                'table_display_name' => 'Index',
                'table_description' => 'Manage Your Content Model',
                'table_name' => null
            ];

            $cm = (object) $cm;
        }

		return view('content_model.index', compact('cm_list', 'cm'));
    }

    public function deleteField(Request $request){

           // drop table
        $exitCode = Artisan::call('cm:delete_field', [
            'args' => [ $request->table_name, $request->field_name ]
        ]);

        $this->updateJson($request->table_name, $request->model);            
    }

    public function update(Request $request){
        $entity = EntityStore::where('table_name', $request->model_table_name)->first();
        $entity->table_display_name = $request->model_dis_name;
        $entity->table_description = $request->model_desc;

        $status = $entity->save();

        if($status){
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
        $status = Storage::disk('cm')->put(Str::singular($table_name).'.json', response()->json($json)->getContent());
    }

    public function save(){

    }

    public function destroy($table_name){
        //delete entity record
        $removedTable = EntityStore::where('table_name', $table_name)->first()->delete();

        // dd($removedTable);

        // drop table
        $exitCode = Artisan::call('cm:delete', [
            'table_name' => $table_name
        ]);

        // delete json file
        $exitCode = Storage::disk('cm')->delete(Str::singular($table_name).'.json');

        // remove route
        $this->removeRoute($table_name);
        
        // remove menu
        $this->removeMenu($table_name);
        
        // remove view
        $this->removeView($table_name);

        // remove controller
        $this->removeController($table_name);      
        
        //delete Model
        $this->removeModel($table_name);

        // remove request
        $this->removeRequest($table_name);        

        //remove services
        $this->removeService($table_name);        

        flash('Content Model deleted successfully')->success();

        return redirect(route('content_model.index'));
    }

    public function removeModel($table_name){
        $name_studly = Str::studly(Str::singular($table_name)); 
        $model_path = app_path($name_studly . '.php');

        if(file_exists($model_path)){
            return unlink($model_path);
        };

        return false;
    }

    public function removeService($table_name)
    {
        $name = underscore_to_space($table_name);
        $name_studly = Str::studly(Str::singular($name)); 
        $path_service = app_path('Services/' . $name_studly . 'Service.php');

        if(file_exists($path_service))
        {
            return unlink($path_service);
        }

        return false;
    }

    public function removeRequest($table_name)
    {
        $name = underscore_to_space($table_name);
        $name_studly = Str::studly(Str::singular($name));
        $path_create = app_path('Http/Requests/' . $name_studly .'CreateRequest.php');
        $path_update = app_path('Http/Requests/' . $name_studly .'UpdateRequest.php');
        
        if(file_exists($path_create))
        {
            unlink($path_create);
            return unlink($path_update);
        }

        return false;
    }

    public function removeController($table_name)
    {
        $name_singular = Str::singular($table_name);
        $name_singular_studly = Str::studly($name_singular);
        $path = app_path('Http/Controllers/'. $name_singular_studly.'Controller.php');

        if(file_exists($path)){
            return unlink($path);            
        }

        return false;
    }

    public function removeView($table_name)
    {
        $path = resource_path('views/'. $table_name);

        if(file_exists($path)){            
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
                    if (filetype($dir."/".$object) == "dir") 
                        $this->rrmdir($dir."/".$object); else unlink($dir."/".$object); 
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

        if (Str::contains($existing_menu_contents, $data))
        {
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

        if (Str::contains($existing_route_contents, $data))
        {
            $new_routes = str_replace($data,'',$existing_route_contents);         
            file_put_contents($route_path, $new_routes);        
        }            
    }

    public function getAttributes($cm_url="blog_posts")
    {
        $cm_url_singular = Str::singular($cm_url);
        $json = Storage::disk('cm')->get($cm_url_singular.'.json');
        $json = json_decode($json, true);

        return $json;
    }

    public function layout()
    {
        return view('content_model.layout');
    }

    public function generate(Request $request) 
    {
        $properties = $request->properties;    
        $fields = $request->fields_collection;        

        $json_fields = $this->generateModelJson($fields, $properties);        

        $properties = json_decode($properties);   
        $name = $properties->name;

        $this->insertCMInfo($properties, $json_fields);    

        $this->generateMigration($name, $fields);
        $this->pushRoute($name);
        $this->generateModel($name);
        $this->generateService($name);
        $this->generateRequest($name, "Create");
        $this->generateRequest($name, "Update");
        $this->generateController($name);
        $this->generateMenu($name);
        $this->generateView($name, $fields);

        // Artisan::call('migrate:fresh', [
        //     '--force' => true,
        // ]);
        Artisan::call('migrate');

        flash('Content Model created successfully')->success();

        return redirect(route('content_model.index'));
    }

    public function insertCMInfo($properties, $json_fields)
    {
        $name_plural = Str::plural($properties->name);
        $display_name = $properties->display_name;
        $description = $properties->description;
        
        //save entity
        $entity_store = new EntityStore;
        $entity_store->table_name = $name_plural;
        $entity_store->table_display_name = $display_name;
        $entity_store->table_description = $description;
        $entity_store->field_collections = $json_fields;
        $entity_store->save();
    }

    public function generateModelJson($fields, $properties)
    {
        $new = [];
        $prop = json_decode($properties);   
        $name = $prop->name;

        foreach ($fields as $key => $value) {
            $new[$value['name']] = $value;           
        }   

        $data_model = [];
        $data_model["info"] = json_decode($properties,TRUE);
        $data_model["attributes"] = $new;       
        
        Storage::disk('cm')->put($name.'.json', response()->json($data_model)->getContent());
        $data_model =json_encode($data_model, JSON_PRETTY_PRINT);

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
        $route_contents .= "\n\n".$data;

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
        $menu_contents .= "\n\n".$data;

        if (!Str::contains($existing_menu_contents, $data))            
            file_put_contents($path, $menu_contents);        
    }

    protected function generateRequest($name, $requestType)
    {
        $name = underscore_to_space($name);
        $name_studly = Str::studly($name);

        $path = app_path('Http/Requests/');
        
        if(!file_exists($path))
            mkdir($path);

        $path = app_path('Http/Requests/' . $name_studly . $requestType .'Request.php');
        copy(resource_path('stubs/request.stub.php'), $path);
        $data = file_get_contents($path);
        $data = str_replace('{Model}', $name_studly.$requestType , $data);
        file_put_contents($path, $data);
    }

    protected function generateView($name, $fields)
    {
        $name = Str::snake($name);
        $path = resource_path('views/' . Str::plural($name));
        if(!file_exists($path))
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
                'label' => \"".$field['display_name']."\",
                'name' => \"".$field['name']."\",
                'type' => \"".$field['input_type']."\",
            ])\n";           

            $field_index .= "<td>{{ $".$vars['var']."->".$field['name']." }}</td>\n";           
            $field_index_header .= "<th> ".$field['display_name']."</th>\n";           
        };        

        foreach($files as $view) {
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

    public function generateModel($name){
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

    public function create() {
        return view('content_model.create');
    }

    protected function generateService($name)
    {
        $name = underscore_to_space($name);
        $name_studly = Str::studly($name); 
        $name_camel = Str::camel($name); 
        $service = resource_path('stubs/service.stub.php');
        $path = app_path('Services/');

        if(!file_exists($path))
            mkdir(app_path('Services/'));

        $path = app_path('Services/' . $name_studly . 'Service.php');

        copy($service, $path);
        $data = file_get_contents($service);
        $data = str_replace('{Model}', $name_studly, $data);
        $data = str_replace('{var}', $name_camel, $data);
        file_put_contents($path, $data);
    }

    protected function generateMigration($name, $fields)
    {
        $name_plural = Str::plural($name);
        $name_plural_studly = Str::studly($name_plural);
        $fileName = date('Y_m_d_His').'_'.'create_'.strtolower($name_plural).'_table.php';
        $path = database_path('migrations/'. $fileName);
        copy(resource_path('stubs/migration.stub'), $path);
        $templateData = file_get_contents($path);
        $templateData = str_replace('{TABLE_NAME_TITLE}', $name_plural_studly, $templateData);            
        $templateData = str_replace('{TABLE_NAME}', $name_plural, $templateData);            
        $fields_migration = $this->generateFields($fields);
        $templateData = str_replace('{FIELDS}', $fields_migration, $templateData);        
        file_put_contents($path, $templateData);
    }

    protected function generateFields($fields)
    {
        $fieldsnya = [];

        foreach ($fields as $field) {          
            $fieldsnya[] = $this->prepareMigrationText($field['db_type'], $field['name'] );
        }

        return implode(infy_nl_tab(1, 3), $fieldsnya);
    }

    protected function prepareMigrationText($fieldnya, $name)
    {
        $inputsArr = explode(':', $fieldnya);
        $migration_text = '$table->';

        $fieldTypeParams = explode(',', array_shift($inputsArr));
        $fieldType = array_shift($fieldTypeParams);
        $migration_text .= $fieldType."('".$name."'";

        if ($fieldType == 'enum') {
            $migration_text .= ', [';
            foreach ($fieldTypeParams as $param) {
                $migration_text .= "'".$param."',";
            }
            $migration_text = substr($migration_text, 0, strlen($migration_text) - 1);
            $migration_text .= ']';
        } else {
            foreach ($fieldTypeParams as $param) {
                $migration_text .= ', '.$param;
            }
        }

        $migration_text .= ')';

        foreach ($inputsArr as $input) {
            $inputParams = explode(',', $input);
            $functionName = array_shift($inputParams);
            if ($functionName == 'foreign') {
                $foreignTable = array_shift($inputParams);
                $foreignField = array_shift($inputParams);
                $this->foreignKeyText .= "\$table->foreign('".$name."')->references('".$foreignField."')->on('".$foreignTable."');";
            } else {
                $migration_text .= '->'.$functionName;
                $migration_text .= '(';
                $migration_text .= implode(', ', $inputParams);
                $migration_text .= ')';
            }
        }

        $migration_text .= ';';

        return $migration_text;
    }
}
