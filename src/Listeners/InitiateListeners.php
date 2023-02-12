<?php declare(strict_types=1);

namespace VitesseCms\Configuration\Listeners;

use VitesseCms\Configuration\Enums\ConfigurationEnum;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;

class InitiateListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        $di->eventsManager->attach(ConfigurationEnum::SERVICE_LISTENER->value, new ServiceListener($di->configuration));
    }
}
