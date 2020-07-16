<?php

namespace App\Http\View\Composers;

use App\EntityStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CMMenuComposer
{
  public function __construct()
  {
  }

  public function compose(View $view)
  {
    if (!Auth::user()->hasRole("Super Admin")) {
      $project_id = session('project')['id'];
      if (isset($project_id)) {
        $entities = \App\Project::find($project_id)->entities()->get(['table_name']);

        $view->with('menus', $entities);
      }
    } else {
      $entities = EntityStore::all();
      $view->with('menus', $entities);
    }
  }
}
