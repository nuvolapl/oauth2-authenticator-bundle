<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle\Token;

final readonly class Token
{
    public function __construct(
        public string|int $userIdentifier,
        public string $token,
        public array $data,
    ) {
    }
}
