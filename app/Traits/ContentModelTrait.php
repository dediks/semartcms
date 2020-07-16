<?php

namespace App\Traits;

use App\EntityStore;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

trait ContentModelTrait
{
  public function deleteSchema($name)
  {
    $name = Str::singular($name);
    $dir = base_path('graphql/' . $name);
    $result = File::deleteDirectory($dir);

    return $result;
  }
  public function deleteQuery($name)
  {
    $name = Str::singular($name);
    $name = Str::studly($name);
    $dir = app_path("GraphQL/Queries/" . $name . "Query.php");
    $result = File::delete($dir);

    return $result;
  }
  public function deleteMutation($name)
  {
    $dir = app_path('GraphQL/Mutations/' . $name);
    $result = File::delete($dir);

    return $result;
  }

  public function removeModelJson($table_name)
  {
    $exitCode = Storage::disk('cm')->delete(Str::singular($table_name) . '.json');
  }

  public function removeTableOnDB($table_name)
  {
    $removeTable = EntityStore::where('table_name', $table_name)->first();
    if ($removeTable)
      $removeTable->delete();

    $exitCode = Artisan::call('cm:delete', [
      'table_name' => $table_name
    ]);
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
}
