<?php

namespace Northern\MaintenanceModeBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    private $kernel;

    private $filesystem;

    private $twig;

    public function __construct(KernelInterface $kernel, Filesystem $filesystem, Environment $twig)
    {
        $this->kernel     = $kernel;
        $this->filesystem = $filesystem;
        $this->twig       = $twig;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($this->filesystem->exists($this->kernel->getProjectDir() . '/var/maintenance.flag')) {
            $event->setResponse(new Response($this->twig->render('@NorthernMaintenanceMode/maintenance.html.twig'), 503, ['Retry-After' => 300]));
        }
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
