<?php

namespace Northern\MaintenanceModeBundle\DependencyInjection;

class NorthernMaintenanceModeExtension extends \Symfony\Component\HttpKernel\DependencyInjection\Extension
{
    /**
     * @inheritDoc
     */
    public function load(array $configs, \Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $loader = new \Symfony\Component\DependencyInjection\Loader\XmlFileLoader($container, new \Symfony\Component\Config\FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
