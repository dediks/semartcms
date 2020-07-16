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

    public function generateGraphQLSchema($name, $fields, $relation_data)
    {
        $singularName = Str::singular($name);
        $plural_name = Str::plural($name);
        $plural_name_lower = strtolower($plural_name);
        $singular_studly_name = Str::studly($singularName);
        $plural_studly_name = Str::studly($plural_name);
        $plural_camel_name = Str::camel($plural_name);
        $singular_camel_name = Str::camel($singularName);

        $path = base_path("graphql/" . $singularName);
        $queries_path = app_path("GraphQL/Queries");
        $mutations_path = app_path("GraphQL/Mutations");
        $directives_path = app_path("GraphQL/Directives");

        if (!file_exists($path))
            mkdir($path);

        if (!file_exists($queries_path))
            mkdir($queries_path);

        if (!file_exists($mutations_path))
            mkdir($mutations_path);

        if (!file_exists($directives_path))
            mkdir($directives_path);

        $path = $path . '/' . $singularName . '.graphql';
        $queries_path = $queries_path . '/' . $singular_studly_name . "Query.php";
        $mutations_path = $mutations_path . '/' . $singular_studly_name . 'Mutations.php';
        $directives_path = $directives_path . '/' . $singular_studly_name . 'Directives.php';

        $field_text = '';
        $field_text_mutation = '';
        foreach ($fields as $field) {
            $type_studly = Str::studly($field["db_type"]);

            $field_type = "";
            switch ($type_studly) {
                case "Integer":
                    $field_type = "Int";
                    break;
                case "Text":
                    $field_type = "String";
                    break;
                default:
                    $field_type = $type_studly;
            }

            $field_text .= "\t" . $field["name"] . ":" . $field_type;
            $field_text_mutation .= "\t" . $field["name"] . ":" . $field_type;

            foreach ($field["validation"] as $validation) {
                $validation == "required" ? $field_text .= "!" : '';
                $validation == "required" ? $field_text_mutation .= "!" : '';
            };

            $field_text_mutation .= "\r\n";
            $field_text .= "\r\n";
        };

        if ($relation_data != null) {
            foreach ($relation_data as $rel) {
                $rel_type = $rel["type"]["name"];
                $rel_modifier = $rel["type"]["modifier"];
                $target_model = $rel["target_model"]["name"];
                $target_model_lower = strtolower($target_model);
                $target_model_singular = Str::singular($target_model);

                if ($rel_type == "many-many" || ($rel_type == "one-many" && $rel_modifier == "hasMany")) {
                    $field_text .= "\t" . Str::plural($target_model_lower)  . ": [" . Str::studly($target_model_singular) . "] @" . $rel_modifier;
                } else {
                    $field_text .= "\t" . Str::singular($target_model_lower)  . ": " . Str::studly($target_model_singular) . "@" . $rel_modifier;
                }
                $field_text .= "\r\n";
            }
        }

        copy(resource_path('stubs/graphql/schema/schema.stub.graphql'), $path);
        copy(resource_path('stubs/graphql/query/query.stub.php'), $queries_path);
        $schema_data = file_get_contents($path);
        $schema_data = str_replace('{NAME_PLURAL_CAMEL}', $plural_camel_name, $schema_data);
        $schema_data = str_replace('{NAME_SINGULAR_STUDLY}', $singular_studly_name, $schema_data);
        $schema_data = str_replace('{NAME_SINGULAR_CAMEL}', $singular_camel_name, $schema_data);
        $schema_data = str_replace('{NAME_PLURAL_STUDLY}', $plural_studly_name, $schema_data);
        $schema_data = str_replace('{FieldsMutation}', $field_text_mutation, $schema_data);
        $schema_data = str_replace('{Fields}', $field_text, $schema_data);
        file_put_contents($path, $schema_data);

        $query_data = file_get_contents($queries_path);
        $query_data = str_replace('{MODEL_NAME}', $singular_studly_name, $query_data);
        $query_data = str_replace('{MODEL_NAME_PLURAL_LOWER}', $plural_name_lower, $query_data);

        if (file_put_contents($queries_path, $query_data) !== false) {
            return true;
        } else {
            return false;
        }
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
