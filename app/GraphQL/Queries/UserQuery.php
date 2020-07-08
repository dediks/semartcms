<?php

namespace App\GraphQL\Queries;

use App\User;

class UserQuery
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
        return User::inRandomOrder()->limit($args["total"])->get();
    }
}
