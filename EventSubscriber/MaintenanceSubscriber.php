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
    private $filesystem;

    private $twig;

    private $flagPath;

    private $retryAfter;

    public function __construct(
        Filesystem $filesystem,
        Environment $twig,
        string $flagPath,
        int $retryAfter
    ) {
        $this->filesystem = $filesystem;
        $this->twig       = $twig;
        $this->flagPath   = $flagPath;
        $this->retryAfter = $retryAfter;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if ($this->filesystem->exists($this->flagPath)) {
            $event->setResponse(new Response($this->twig->render('@NorthernMaintenanceMode/maintenance.html.twig'), 503, ['Retry-After' => $this->retryAfter]));
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
