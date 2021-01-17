<?php declare(strict_types=1);

namespace VitesseCms\Configuration\Utils;

use Phalcon\Config\Adapter\Ini;

abstract class AbstractConfigUtil extends Ini
{
    /**
     * @var string
     */
    protected $systemDir;

    protected function setBaseDirs(): void
    {
        $this->systemDir = __DIR__ . '/../../../../';
    }

    public function getSystemDir(): string
    {
        return $this->systemDir;
    }
}
