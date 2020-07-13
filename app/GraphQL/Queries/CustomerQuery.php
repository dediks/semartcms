<?php

namespace App\GraphQL\Queries;

use App\Customer;

class CustomerQuery
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
        return Customer::inRandomOrder()->limit($args["total"])->get();
    }
    public function findBy($root, array $args)
    {
        return Customer::where($args["identifier"], $args["operator"], $args["value"])->first();
    }

    public function getPage($root, array $args)
    {
        $start = $args["page"] * $args["size"];
        $end = $start + $args["size"];

        $customers = Customer::all();

        $result = [
            "customers" => $customers->slice($start, $end),
            "hasMore" => $end < $customers->count()
        ];

        return $result;
    }

    public function search($root, array $args)
    {
        $keyword = $args["kw"];
        $column_name = $args["col_name"];

        $criteria = Customer::select('*')->where($column_name, 'LIKE', "%" . $keyword . "%")->get();

        return $criteria;
    }

    public function login($root, array $args)
    {
        $customer = Customer::where('email', '=', $args["email"])->first();
        if ($args["password"] == $args["password"]) {
            return $customer;
        }

        return "fail";
    }
}
