<?php

namespace Acme\StoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeStoreBundle extends Bundle
{
    public function getParent() {
        return 'FOSUserBundle';
    }
}
