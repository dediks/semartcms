<?php

namespace App\GraphQL\Queries;

use App\{MODEL_NAME};

class {MODEL_NAME}Query
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
    }

    public function getRandom($root, array $args)
    {
        return {MODEL_NAME}::inRandomOrder()->limit($args["total"])->get();
    }
    public function findBy($root, array $args)
    {
        return {MODEL_NAME}::where($args["identifier"], $args["operator"], $args["value"])->first();
    }

    public function getPage($root, array $args)
    {
        $start = $args["page"] * $args["size"];
        $end = $start + $args["size"];

        ${MODEL_NAME_PLURAL_LOWER} = {MODEL_NAME}::all();

        $result = [
            "{MODEL_NAME_PLURAL_LOWER}" => ${MODEL_NAME_PLURAL_LOWER}->slice($start, $end),
            "hasMore" => $end < ${MODEL_NAME_PLURAL_LOWER}->count()
        ];

        return $result;
    }

    public function search($root, array $args)
    {
        $keyword = $args["kw"];
        $column_name = $args["col_name"];

        $criteria = {MODEL_NAME}::select('*')->where($column_name, 'LIKE', "%" . $keyword . "%")->get();

        return $criteria;
    }

    public function login($root, array $args)
    {
        $customer = {MODEL_NAME}::where('email', '=', $args["email"])->first();
        if ($args["password"] == $args["password"]) {
            return $customer;
        }

        return "fail";
    }
}
