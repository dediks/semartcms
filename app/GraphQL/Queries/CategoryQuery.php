<?php

namespace App\GraphQL\Queries;

use App\Category;

class CategoryQuery
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
        return Category::inRandomOrder()->limit($args["total"])->get();
    }

    public function findBy($root, array $args)
    {
        return Category::where($args["identifier"], $args["operator"], $args["value"])->first();
    }


    public function getPage($root, array $args)
    {
        $start = $args["page"] * $args["size"];
        $end = $start + $args["size"];

        $categories = Category::all();

        $result = [
            "categories" => $categories->slice($start, $end),
            "hasMore" => $end < $categories->count()
        ];

        return $result;
    }
}
