<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Nuvola\OAuth2AuthenticatorBundle\Repository\UserRepository;
use Nuvola\OAuth2AuthenticatorBundle\Service\IntrospectService;
use Nuvola\OAuth2AuthenticatorBundle\Token\TokenFactory;

final class OAuth2AuthenticatorExtension extends ConfigurableExtension
{
    public function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yaml');

        $definition = $container->getDefinition(IntrospectService::class);
        $definition->replaceArgument(1, $mergedConfig['client_id']);
        $definition->replaceArgument(2, $mergedConfig['client_secret']);
        $definition->replaceArgument(3, $mergedConfig['itrospect']['endpoint']);

        $definition = $container->getDefinition(TokenFactory::class);
        $definition->replaceArgument(0, $mergedConfig['itrospect']['user_identifier_property']);

        $definition = $container->getDefinition(UserRepository::class);
        $definition->replaceArgument(1, $mergedConfig['userinfo_endpoint'] ?? '');
    }

    public function getAlias(): string
    {
        return 'oauth2_authenticator';
    }
}
