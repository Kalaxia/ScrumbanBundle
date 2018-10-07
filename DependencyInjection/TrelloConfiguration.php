<?php

namespace Scrumban\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class TrelloConfiguration implements ConfigurationInterface
{
    
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('scrumban');
        
        $rootNode
            ->children()
                ->arrayNode('trello')->canBeUnset()
                    ->children()
                        ->booleanNode('has_plus_for_trello')->end()
                        ->scalarNode('api_key')->end()
                        ->scalarNode('api_token')->end()
                        ->arrayNode('boards')
                            ->useAttributeAsKey('n')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('id')->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('columns')
                            ->useAttributeAsKey('n')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('name')->end()
                                    ->scalarNode('type')->end()
                                    ->scalarNode('status')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        
        return $treeBuilder;
    }

}