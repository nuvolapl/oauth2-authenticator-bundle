<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle\Repository;

interface AuthBearerAwareInterface
{
    public function setAuthBearer(string $token);
}
