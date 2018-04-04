<?php

namespace BonPlanBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BonPlanBundle extends Bundle
{
    public function getParent ()
    {
        return 'FOSUserBundle';
    }
}
