<?php

namespace App;

use App\Traits\ContentModelTrait;
use Illuminate\Database\Eloquent\Model;

class ContentModel extends Model
{
  use ContentModelTrait;

  public static function del($entities)
  {
    foreach ($entities as $entity) {
      //delete entity record
      (new self)->removeTableOnDB($entity->table_name);

      // delete json file
      (new self)->removeModelJson($entity->table_name);

      // remove route
      (new self)->removeRoute($entity->table_name);

      // remove view
      (new self)->removeView($entity->table_name);

      // remove controller
      (new self)->removeController($entity->table_name);

      //delete trait
      (new self)->removeTrait($entity->table_name);

      //delete Model
      (new self)->removeModel($entity->table_name);

      // remove request
      (new self)->removeRequest($entity->table_name);

      //remove services
      (new self)->removeService($entity->table_name);

      (new self)->deleteSchema($entity->table_name);

      (new self)->deleteQuery($entity->table_name);
    }
  }
}
