<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle\EventDispatcher\Event;

use Symfony\Component\Security\Core\User\UserInterface;
use Nuvola\OAuth2AuthenticatorBundle\Token\Token;

final class TokenVerifiedEvent
{
    private ?UserInterface $user = null;

    public function __construct(
        public readonly Token $token,
    ) {
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function isUserSet(): bool
    {
        return $this->user instanceof UserInterface;
    }

    public function setUser(UserInterface $user): void
    {
        $this->user = $user;
    }
}
