<?php declare(strict_types=1);

namespace VitesseCms\Configuration\Services;

interface ConfigServiceInterface
{
    public function getVendorNameDir(): string;

    public function getCoreTemplateDir(): string;

    public function getRootDir(): string;
}
