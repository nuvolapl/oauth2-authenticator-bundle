<?php

declare(strict_types=1);

namespace Nuvola\OAuth2AuthenticatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('oauth2_authenticator');
        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('client_id')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('client_secret')->isRequired()->cannotBeEmpty()->end()
            ->arrayNode('itrospect')
            ->isRequired()
            ->children()
            ->scalarNode('endpoint')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('user_identifier_property')->defaultValue('sub')->end()
            ->end()
            ->end()
            ->scalarNode('userinfo_endpoint')->cannotBeEmpty()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
