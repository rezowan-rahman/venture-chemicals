<?php

namespace Venture\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class VentureUserBundle extends Bundle
{
    public function getParent() {
        return 'FOSUserBundle';
    }
}
