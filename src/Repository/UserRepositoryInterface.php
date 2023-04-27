<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle\Repository;

interface UserRepositoryInterface
{
    public function getUserInfo(): array;
}
