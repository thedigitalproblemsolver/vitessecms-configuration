<?php
declare(strict_types=1);

namespace VitesseCms\Configuration\Utils;

use Phalcon\Config\Adapter\Ini;
use Phalcon\Config\Config;
use RuntimeException;
use VitesseCms\Core\Utils\DebugUtil;
use VitesseCms\Core\Utils\DirectoryUtil;

class DomainConfigUtil extends Ini
{
    public function __construct(string $basePath, int $mode = 1)
    {
        $this->host = $_SERVER['HTTP_HOST'];
        $this->movedTo = '';
        $this->systemDir = $basePath . 'vendor/';

        $domainConfigFile = $basePath . 'config/domain/' . $this->host . '/config.ini';
        if (!is_file($domainConfigFile)) :
            $this->host = str_replace('www.', '', $this->host);
            $domainConfigFile = $basePath . 'config/domain/' . $this->host . '/config.ini';
            if (is_file($domainConfigFile)) :
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: http://' . $this->host);
            endif;
            if (DebugUtil::isDev()) :
                $this->host = str_replace('new.', '', $this->host);
                $domainConfigFile = $basePath . 'config/domain/' . $this->host . '/config.ini';
                if (!is_file($domainConfigFile)) :
                    throw new RuntimeException('Geen domein aanwezig');
                endif;
            else :
                throw new RuntimeException('Geen domein aanwezig');
            endif;
        endif;

        parent::__construct($domainConfigFile, $mode);
    }

    public function setDirectories(): DomainConfigUtil
    {
        $this->rootDir = $this->systemDir . 'vitessecms/vitessecms/';
        $this->webDir = $this->systemDir . '../public_html/';
        $this->uploadDir = $this->systemDir . '../public_html/uploads/' . $this->getAccount() . '/';
        $this->domainDir = $this->systemDir . '../config/domain/';
        $this->accountDir = $this->systemDir . '../config/account/' . $this->getAccount() . '/';
        $this->cacheDir = $this->systemDir . '../cache/' . $this->getAccount() . '/';

        if (!DirectoryUtil::exists($this->getUploadDir(), true)) :
            throw new RuntimeException(
                sprintf(
                    'Directory "%s" was not created',
                    $this->getUploadDir()
                )
            );
        endif;

        if (!DirectoryUtil::exists($this->getCacheDir(), true)) :
            throw new RuntimeException(
                sprintf(
                    'Directory "%s" was not created',
                    $this->getCacheDir()
                )
            );
        endif;

        return $this;
    }

    public function getTemplate(): Config
    {
        return $this->template;
    }

    public function setTemplate(): DomainConfigUtil
    {
        $this->templateDir = $this->systemDir . 'vitessecms/mustache/src/Template/';
        $this->coreTemplateDir = $this->systemDir . 'vitessecms/mustache/src/Template/core/';

        $settingFile = $this->systemDir . '../config/Template/' . $this->get('template') . '/settings.ini';
        if (is_file($settingFile)):
            $this->templateDir = $this->systemDir . '../config/Template/' . $this->get('template') . '/';
            $this->template = new Ini($settingFile);
        endif;

        $settingFile = $this->systemDir . 'vitessecms/mustache/src/Template/core/settings.ini';
        if (is_string($this->template) && is_file($settingFile)):
            $this->template = new Ini($settingFile);
            $this->templateDir = $this->coreTemplateDir;
        endif;

        return $this;
    }

    public function getTemplateDir(): string
    {
        return $this->templateDir;
    }

    public function getCoreTemplateDir(): string
    {
        return $this->coreTemplateDir;
    }

    public function getRootDir(): string
    {
        return $this->rootDir;
    }

    public function getWebDir(): string
    {
        return $this->webDir;
    }

    public function getUploadDir(): string
    {
        return $this->uploadDir;
    }

    public function getDomainDir(): string
    {
        return $this->domainDir;
    }

    public function getAccountDir(): string
    {
        return $this->accountDir;
    }

    public function getCacheDir(): string
    {
        return $this->cacheDir;
    }

    public function getAccount(): string
    {
        return $this->get('account');
    }

    public function getLanguageShort(): string
    {
        return $this->language->short;
    }

    public function getLanguageLocale(): string
    {
        return $this->language->locale;
    }

    public function getLanguageShortDefault(): ?string
    {
        return $this->languageShortDefault;
    }

    public function hasLanguage(): bool
    {
        return $this->language !== null;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function hasMovedTo(): bool
    {
        return !empty($this->movedTo);
    }

    public function getMovedTo(): ?string
    {
        return $this->movedTo;
    }

    public function getMongoDatabase(): string
    {
        return $this->mongo->database;
    }

    public function getMongoUri(): string
    {
        return !empty($this->mongo->ip) ? 'mongodb://' . $this->mongo->ip . '/' : 'mongodb://127.0.0.1/';
    }

    public function renderAdminListChildren(): bool
    {
        return $this->admin->renderAdminListChildren ?? true;
    }

    public function getBeanstalkHost(): string
    {
        return $this->beanstalk->host ?? '127.0.0.1';
    }

    public function getBeanstalkPort(): int
    {
        return $this->beanstalk->port ?? 11300;
    }

    public function getSystemDir(): string
    {
        return $this->systemDir;
    }
}
