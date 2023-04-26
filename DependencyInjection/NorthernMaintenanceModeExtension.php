<?php

namespace Northern\MaintenanceModeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class NorthernMaintenanceModeExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $maintenanceCommandDefinition = $container->getDefinition('northern_maintenance_mode.command.maintenance_command');
        $maintenanceCommandDefinition->setArgument('$flagPath', $mergedConfig['maintenance_flag_path']);

        $maintenanceSubscriberDefinition = $container->getDefinition('northern_maintenance_mode.event_subscriber.maintenance_subscriber');
        $maintenanceSubscriberDefinition->setArgument('$flagPath', $mergedConfig['maintenance_flag_path'])
                                        ->setArgument('$retryAfter', $mergedConfig['retry_after']);
    }
}
