<?php

namespace App\GraphQL\Queries;

use App\Book;

class BookQuery
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
        return Book::inRandomOrder()->limit($args["total"])->get();
    }
    public function findBy($root, array $args)
    {
        return Book::where($args["identifier"], $args["operator"], $args["value"])->first();
    }

    public function getPage($root, array $args)
    {
        $start = $args["page"] * $args["size"];
        $end = $start + $args["size"];

        $books = Book::all();

        $result = [
            "books" => $books->slice($start, $end),
            "hasMore" => $end < $books->count()
        ];

        return $result;
    }

    public function search($root, array $args)
    {
        $keyword = $args["kw"];
        $column_name = $args["col_name"];

        $criteria = Book::select('*')->where($column_name, 'LIKE', "%" . $keyword . "%")->get();

        return $criteria;
    }

    public function login($root, array $args)
    {
        $customer = Book::where('email', '=', $args["email"])->first();
        if ($args["password"] == $args["password"]) {
            return $customer;
        }

        return "fail";
    }
}
