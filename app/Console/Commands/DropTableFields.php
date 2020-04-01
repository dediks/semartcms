<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DropTableFields extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cm:delete_field {args*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to delete field';

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
    public function handle()
    {
        $table_name = $this->argument()['args'][0];
        $column_name = $this->argument()['args'][1];

        $name_plural_studly = Str::studly($table_name);
        $fileName = date('Y_m_d_His').'_'.'drop_'.strtolower($table_name).'_table.php';

        $path = database_path('migrations/'. $fileName);

        if(file_exists($path))
        {
            $fileName = date('Y_m_d_His').'_'.'drop_'.strtolower($table_name).sha1(time()).'_table.php';
            $path = database_path('migrations/'. $fileName);
        };

        copy(resource_path('stubs/cm/drop_column_migration.stub'), $path);
        $templateData = file_get_contents($path);
        $templateData = str_replace('{TABLE_NAME_TITLE}', $name_plural_studly, $templateData);            
        $templateData = str_replace('{TABLE_NAME}', $table_name, $templateData);            
        $templateData = str_replace('{COLUMN_NAME}', $column_name, $templateData);            
        file_put_contents($path, $templateData);

        $status = Artisan::call('migrate');

        if($status)
            $this->info('Display this on the screen');
    }
}
