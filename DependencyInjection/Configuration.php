<?php

namespace Success\CategoryBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
//use Success\CategoryBundle\CategoryBundle;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('category');

        /*$rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('driver')->defaultValue(CategoryBundle::DRIVER_DOCTRINE_ORM)->end()                
            ->end()
        ;

        $this->addClassesSection($rootNode);*/

        return $treeBuilder;
    }
    
    private function addClassesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->children()

                        ->arrayNode('category')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('model')->defaultValue('Success\CategoryBundle\Entity\Category')->end()
                                ->scalarNode('controller')->defaultValue('Success\CategoryBundle\Controller\CategoryController')->end()
                                ->scalarNode('repository')->defaultValue('Success\CategoryBundle\Entity\Repository\CategoryRepository')->end()
                                ->scalarNode('admin')->defaultValue('Success\CategoryBundle\Admin\CategoryAdmin')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
