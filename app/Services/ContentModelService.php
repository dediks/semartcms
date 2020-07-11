<?php

namespace Services;

use App\EntityStore;
use CM;

class ContentModelService
{

    public function model()
    {
        return EntityStore::all();
    }

    public function paginate($num)
    {
        return $this->model()->paginate($num);
    }

    public function getLast()
    {
        return $this->model()->orderBy('sort', 'desc')->first();
    }

    public function create($request)
    {
        $input = $request->all();

        $content_model = $this->model()->create($input);

        // event(new content_modelGroupCreated($content_model));

        return $content_model;
    }

    public function find($id)
    {
        return $this->model()->find($id);
    }

    public function findByName($name)
    {
        return $this->model()->whereName($name)->first();
    }

    public function findAndUpdate($id, $request)
    {
        $content_model = $this->find($id);

        $input = $request->all();
        $content_model->update($input);

        // event(new content_modelGroupUpdated($content_model));

        return $content_model;
    }

    public function delete($id)
    {
        $content_model = $this->find($id);

        $content_model->delete();

        // event(new content_modelGroupDeleted($content_model));

        return $content_model;
    }
}
