<?php

namespace App\GraphQL\Queries;

use App\Test;

class TestQuery
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
        return Test::inRandomOrder()->limit($args["total"])->get();
    }
    public function findBy($root, array $args)
    {
        return Test::where($args["identifier"], $args["operator"], $args["value"])->first();
    }

    public function getPage($root, array $args)
    {
        $start = $args["page"] * $args["size"];
        $end = $start + $args["size"];

        $tests = Test::all();

        $result = [
            "tests" => $tests->slice($start, $end),
            "hasMore" => $end < $tests->count()
        ];

        return $result;
    }

    public function search($root, array $args)
    {
        $keyword = $args["kw"];
        $column_name = $args["col_name"];

        $criteria = Test::select('*')->where($column_name, 'LIKE', "%" . $keyword . "%")->get();

        return $criteria;
    }

    public function login($root, array $args)
    {
        $customer = Test::where('email', '=', $args["email"])->first();
        if ($args["password"] == $args["password"]) {
            return $customer;
        }

        return "fail";
    }
}
