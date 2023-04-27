<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle\Token;

final class TokenFactory implements TokenFactoryInterface
{
    public function __construct(private readonly string $identifierProperty)
    {
    }

    public function create(string $token, array $data): Token
    {
        if (false === isset($data[$this->identifierProperty])) {
            throw new \Exception("Property \"{$this->identifierProperty}\" not found!"); // TODO: Custom Exception
        }

        return new Token($data[$this->identifierProperty], $token, $data);
    }
}
