<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle\Token;

interface TokenFactoryInterface
{
    public function create(string $token, array $data): Token;
}
