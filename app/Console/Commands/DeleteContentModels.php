<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DeleteContentModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cm:delete {table_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for Delete a Content Model';

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
        $name_plural = $this->argument('table_name');
        $name_plural_studly = Str::studly($name_plural);
        $fileName = date('Y_m_d_His').'_'.'drop_'.strtolower($name_plural).'_table.php';
        $path = database_path('migrations/'. $fileName);
        copy(resource_path('stubs/cm/delete_migration.stub'), $path);
        $templateData = file_get_contents($path);
        $templateData = str_replace('{TABLE_NAME_TITLE}', $name_plural_studly, $templateData);            
        $templateData = str_replace('{TABLE_NAME}', $name_plural, $templateData);            
        file_put_contents($path, $templateData);

        $status = Artisan::call('migrate');

        if($status)
            $this->info('Success Delete Content Model');
        //run migration
    }
}
