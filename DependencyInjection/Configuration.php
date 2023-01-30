<?php

namespace Northern\MaintenanceModeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('northern_maintenance_mode');

        // @formatter:off
        $treeBuilder->getRootNode()
                    ->children()
                        ->scalarNode('maintenance_flag_path')
                            ->info('This is where the maintenance flag is placed within the project folder structure.')
                            ->defaultValue('%kernel.project_dir%/var/maintenance.flag')
                            ->cannotBeEmpty()
                        ->end()
                        ->integerNode('retry_after')
                            ->info('This is how long (in milliseconds) the user agent should wait before making a follow-up request.')
                            ->defaultValue(300)
                            ->min(0)
                        ->end()
                    ->end();
        // @formatter:on

        return $treeBuilder;
    }
}
