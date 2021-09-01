<?php declare(strict_types=1);

namespace VitesseCms\Configuration\Listeners;

use Phalcon\Events\Event;
use VitesseCms\Configuration\Services\ConfigService;

class ServiceListener
{
    /**
     * @var ConfigService
     */
    private $configuration;

    public function __construct(ConfigService $configuration)
    {
        $this->configuration = $configuration;
    }

    public function attach( Event $event): ConfigService
    {
        return $this->configuration;
    }
}
