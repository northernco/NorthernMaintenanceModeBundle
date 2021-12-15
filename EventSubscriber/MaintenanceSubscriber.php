<?php

namespace Northern\MaintenanceModeBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    private Filesystem $filesystem;

    private Environment $twig;

    private string $flagPath;

    private int $retryAfter;

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

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
