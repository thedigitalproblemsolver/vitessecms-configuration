<?php
declare(strict_types=1);

namespace VitesseCms\Configuration\Listeners;

use VitesseCms\Configuration\Enums\ConfigurationEnum;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $injectable): void
    {
        $injectable->eventsManager->attach(
            ConfigurationEnum::SERVICE_LISTENER->value,
            new ServiceListener($injectable->configuration)
        );
    }
}
