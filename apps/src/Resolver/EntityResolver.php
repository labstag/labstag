<?php

namespace Labstag\Resolver;

use ApiPlatform\Core\GraphQl\Resolver\QueryItemResolverInterface;

final class EntityResolver implements QueryItemResolverInterface
{
    /**
     * @param mixed|null $item
     *
     * @return mixed
     */
    public function __invoke($item, array $context)
    {
        // Query arguments are in $context['args'].

        // Do something with the book.
        // Or fetch the book if it has not been retrieved.

        return $item;
    }
}