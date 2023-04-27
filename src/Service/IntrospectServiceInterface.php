<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle\Service;

use Nuvola\OAuth2AuthenticatorBundle\Token\Token;

interface IntrospectServiceInterface
{
    public function itrospect(string $token): Token;
}
