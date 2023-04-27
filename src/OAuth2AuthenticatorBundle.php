<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Nuvola\OAuth2AuthenticatorBundle\DependencyInjection\OAuth2AuthenticatorExtension;

final class OAuth2AuthenticatorBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new OAuth2AuthenticatorExtension();
    }
}
