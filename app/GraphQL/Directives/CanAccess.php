<?php

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\Directive;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CanAccessDirective extends BaseDirective implements FieldMiddleware, DefinedDirective
{
  public function name(): string
  {
    return 'canAccess';
  }

  public function handleField(FieldValue $fieldValue, Closure $next): FieldValue
  {

    $previousResolver = $fieldValue->getResolver();

    $wrappedResolver = function ($root, array $args, GraphQLContext $context, ResolveInfo $info) use ($previousResolver): string {
      $result = $previousResolver($root, $args, $context, $info);

      return $this->test($result);
    };

    $fieldValue->setResolver($wrappedResolver);

    return $next($fieldValue);
  }

  public function test($type_name)
  {
    foreach (Auth::user()->projects as $project) {
      // from session biasanya string, karenaya kita makai == bukan, ====
      if ($project->id == request()->session()->get('project')["id"]) {
        // dd($project->entities);
        foreach ($project->entities as $entity) {
          if ($entity->table_name == $type_name) {
            return true;
          }
        };

        return false;
      }
    };

    return false;
  }
}
