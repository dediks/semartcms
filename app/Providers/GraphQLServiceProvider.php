<?php

declare(strict_types=1);

namespace App\Providers;

use GraphQL\Type\Definition\Type;
use Illuminate\Support\ServiceProvider;
use GraphQL\Type\Definition\ObjectType;
use Nuwave\Lighthouse\Schema\TypeRegistry;

class GraphQLServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(TypeRegistry $typeRegistry): void
    {
        $typeRegistry->register(
            new ObjectType([
                'name' => 'Comment',
                'fields' => function () use ($typeRegistry): array {
                    return [
                        'id' => [
                            'type' => Type::id()
                        ],
                        'content' => [
                            'type' => Type::string()
                        ],
                        'date_created' => [
                            'type' => Type::string()
                        ],
                        'updated_at' => [
                            'type' => Type::string()
                        ]
                    ];
                }
            ])
        );
    }
}
