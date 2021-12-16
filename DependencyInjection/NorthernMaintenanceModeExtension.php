<?php

namespace Northern\MaintenanceModeBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class NorthernMaintenanceModeExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $maintenanceCommandDefinition = $container->getDefinition('northern_maintenance_mode.command.maintenance_command');
        $maintenanceCommandDefinition->setArgument('$flagPath', $config['maintenance_flag_path']);

        $maintenanceSubscriberDefinition = $container->getDefinition('northern_maintenance_mode.event_subscriber.maintenance_subscriber');
        $maintenanceSubscriberDefinition->setArgument('$flagPath', $config['maintenance_flag_path'])
                                        ->setArgument('$retryAfter', $config['retry_after']);
    }
}
