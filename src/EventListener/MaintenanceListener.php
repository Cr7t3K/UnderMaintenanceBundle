<?php

namespace Cvr\UnderMaintenanceBundle\EventListener;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Twig\Environment;

class MaintenanceListener
{
    private const MAINTENANCE_TOKEN_NAME = 'maintenance';

    /** @var ParameterBagInterface $parameterBag */
    private $parameterBag;

    /** @var Environment $twig */
    private $twig;

    public function __construct(ParameterBagInterface $parameterBag, Environment $twig)
    {
        $this->parameterBag = $parameterBag;
        $this->twig = $twig;
    }

    public function onKernelResponse(ResponseEvent $event)
    {
        $onMaintenance = $this->parameterBag->get('app_maintenance');
        $maintenanceToken = $this->parameterBag->get('app_maintenance_token');

        if (!$onMaintenance) {
            return;
        }

        $requestToken = $event->getRequest()->query->get(self::MAINTENANCE_TOKEN_NAME);

        /** @var Cookie $cookieToken */
        $cookieToken = $event->getRequest()->cookies->get(self::MAINTENANCE_TOKEN_NAME);

        if ($requestToken !== $maintenanceToken && $cookieToken !== $maintenanceToken) {
            $event->getResponse()->setContent(
                $this->twig->render('@UnderMaintenance/maintenance.html.twig')
            );
            return;
        }

        if ($cookieToken !== $maintenanceToken) {
            $event->getResponse()->headers->setCookie(new Cookie(
                self::MAINTENANCE_TOKEN_NAME,
                $maintenanceToken,
                (new \DateTime('+15 days', new \DateTimeZone('UTC')))->getTimestamp(),
                '/',
                null,
                null,
                true
            ));
        }
    }
}