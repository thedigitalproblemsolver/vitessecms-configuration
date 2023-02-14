<?php declare(strict_types=1);

namespace VitesseCms\Configuration\Enums;

use VitesseCms\Core\AbstractEnum;

enum ConfigurationEnum: string
{
    case SERVICE_LISTENER = 'configService';
    case ATTACH_SERVICE_LISTENER = 'configService:attach';
}
