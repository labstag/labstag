<?php

namespace Labstag\Handler;

use Labstag\Entity\User;

class UserPublishingHandler
{
    public function handle(User $entity): void
    {
        unset($entity);
        // your logic for publishing book or/and eg. return your custom data
    }
}
