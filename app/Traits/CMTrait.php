<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait CMTrait
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
}
