<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ContentModelGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:content_model {content_model_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Content Model Command';    

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    protected function makeRequest($name)
    {
        $path = app_path('Http/Requests/' . $name . '.php');
        copy(resource_path('stubs/request.stub.php'), $path);
        $data = file_get_contents($path);
        $data = str_replace('{Name}', $name, $data);
        file_put_contents($path, $data);
    }

    protected function makeModel($name)
    {
        $path = app_path($name . '.php');
        copy(resource_path('stubs/model.stub.php'), $path);
        $data = file_get_contents($path);
        $data = str_replace('{Name}', $name, $data);
        $data = str_replace('{plural}', Str::snake(Str::plural($name)), $data);
        file_put_contents($path, $data);

    }

    protected function makeController($name)
    {
        $vars = [
            'Module' => $name,
            'serviceCamel' => Str::camel($name . 'Service'),
            'Service' => $name . 'Service',
            'var_plural' => Str::snake(Str::plural($name)),
            'var' => Str::snake($name),
            'route' => Str::snake(Str::plural($name))
        ];

        $path = app_path('Http/Controllers/' . $name . 'Controller.php');
        copy(resource_path('stubs/controller.stub.php'), $path);
        $data = file_get_contents($path);
        $data = str_replace('{Module}', $vars['Module'], $data);
        $data = str_replace('{serviceCamel}', $vars['serviceCamel'], $data);
        $data = str_replace('{Service}', $vars['Service'], $data);
        $data = str_replace('{var_plural}', $vars['var_plural'], $data);
        $data = str_replace('{var}', $vars['var'], $data);
        $data = str_replace('{route}', $vars['route'], $data);
        file_put_contents($path, $data);        
    }

    protected function makeMigration($name)
    {
        $module_name_plural = Str::plural($name);
        
        $destinationDir = base_path('database/migrations/create_' . strtolower($module_name_plural) . '_table');
        
        if (file_exists($destinationDir)) {
            $answer = $this->ask('Do you want to overwrite migration file? (y|N) :', false);

            if (strtolower($answer) != 'y' and strtolower($answer) != 'yes') {
                return false;
            }
        } else {
            Artisan::call('make:migration create_' . strtolower($module_name_plural) . '_table');
        }
    }

    protected function makeView($name)
    {
        $name = Str::snake($name);
        $path = resource_path('views/' . Str::plural($name));
        mkdir($path);

        $vars = [
            'Name' => $name,
            'Plural' => Str::title(Str::plural($name)),
            'var_plural' => Str::snake(Str::plural($name)),
            'var' => Str::snake($name),
            'route' => Str::snake(Str::plural($name))
        ];

        $files = [
            'index.stub.blade',
            'form.stub.blade',
            'create.stub.blade',
            'edit.stub.blade',
        ];

        foreach($files as $view) {
            $file = str_replace('stub.blade', 'blade.php', $view);
            copy(resource_path('stubs/' . $view), $path . '/' . $file);

            $data = file_get_contents($path . '/' . $file);
            $data = str_replace('{Name}', $vars['Name'], $data);
            $data = str_replace('{Plural}', $vars['Plural'], $data);
            $data = str_replace('{var}', $vars['var'], $data);
            $data = str_replace('{var_plural}', $vars['var_plural'], $data);
            $data = str_replace('{route}', $vars['route'], $data);
            file_put_contents($path . '/' . $file, $data);
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $content_model_name = $this->argument('content_model_name');
        
        $this->info('Creating a migration ...');
        $this->makeMigration($content_model_name);

        $this->info('Creating a request ...');
        $this->makeRequest($content_model_name . 'CreateRequest');
        $this->makeRequest($content_model_name . 'UpdateRequest');

        $this->info('Creating a controller ...');
        $this->makeController($content_model_name);

        $this->info('Creating a model ...');
        $this->makeModel($content_model_name);

        $this->info('Copying service stub ...');
        $service = resource_path('stubs/service.stub.php');
        $dest = app_path('Services/' . $content_model_name . 'Service.php');
        copy($service, $dest);

        $this->info('Updating service stub ...');
        $data = file_get_contents($service);
        $data = str_replace('{Model}', $content_model_name, $data);
        $data = str_replace('{var}', strtolower($content_model_name), $data);

        $this->info('Service layer created ...');
        file_put_contents($dest, $data);

        $this->info('Scaffolding view ...');
        $this->makeView($content_model_name);

        // Artisan::call('migrate');

        $this->info('Content Model created successfully');
    }
}
