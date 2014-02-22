<?php

namespace MC\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MCCoreBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
