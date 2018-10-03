<?php

namespace Scrumban;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Scrumban\DependencyInjection\ScrumbanExtension;

class ScrumbanBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new ScrumbanExtension();
    }
}