<?php

namespace spec\Labstag\Form\Admin;

use Labstag\Form\Admin\ProfilType;
use PhpSpec\ObjectBehavior;

class ProfilTypeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ProfilType::class);
    }
}