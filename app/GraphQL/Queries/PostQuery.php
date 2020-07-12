<?php

namespace App\GraphQL\Queries;

use App\Post;

class PostQuery
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
        return Post::inRandomOrder()->limit($args["total"])->get();
    }
    public function findBy($root, array $args)
    {
        return Post::where($args["identifier"], $args["operator"], $args["value"])->first();
    }

    public function getPage($root, array $args)
    {
        $start = $args["page"] * $args["size"];
        $end = $start + $args["size"];

        $posts = Post::all();

        $result = [
            "posts" => $posts->slice($start, $end),
            "hasMore" => $end < $posts->count()
        ];

        return $result;
    }

    public function search($root, array $args)
    {
        $keyword = $args["kw"];
        $column_name = $args["col_name"];

        $criteria = Post::select('*')->where($column_name, 'LIKE', "%" . $keyword . "%")->get();

        return $criteria;
    }

    public function login($root, array $args)
    {
        $customer = Post::where('email', '=', $args["email"])->first();
        if ($args["password"] == $args["password"]) {
            return $customer;
        }

        return "fail";
    }
}
