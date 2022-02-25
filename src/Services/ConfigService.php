<?php declare(strict_types=1);

namespace VitesseCms\Configuration\Services;

use VitesseCms\Configuration\Utils\DomainConfigUtil;
use VitesseCms\Core\Services\UrlService;
use VitesseCms\Language\Models\Language;

class ConfigService implements ConfigServiceInterface
{
    /**
     * @var DomainConfigUtil
     */
    protected $config;

    /**
     * @var UrlService
     */
    protected $url;

    /**
     * @var Language
     */
    protected $language;

    /**
     * @var string
     */
    protected $vendorNameDir;

    public function __construct(DomainConfigUtil $config, UrlService $url)
    {
        $this->config = $config;
        $this->url = $url;
        $this->vendorNameDir = $config->getRootDir() . '../';
    }

    public function getUploadUri(): string
    {
        return str_replace('/' . $this->getLanguageShort() . '/', '/', $this->url->getBaseUri())
            . 'uploads/' .
            $this->config->get('account') . '/';
    }

    public function getLanguageShort(): string
    {
        if ($this->language !== null) :
            return $this->language->getShortCode();
        endif;

        return $this->config->getLanguageShort();
    }

    public function getTranslationDir(): string
    {
        return $this->getVendorNameDir() . 'language/src/Translations/' . $this->getLanguageLocale() . '/';
    }

    public function getVendorNameDir(): string
    {
        return $this->vendorNameDir;
    }

    public function getLanguageLocale(): string
    {
        if ($this->language !== null) :
            return $this->language->getLocale();
        endif;

        return $this->config->getLanguageLocale();
    }

    public function getAccountTranslationDir(): string
    {
        return $this->getAccountDir() . 'src/language/Translations/' . $this->getLanguageLocale() . '/';
    }

    public function getAccountDir(): string
    {
        return $this->config->getAccountDir();
    }

    public function getAccountTemplateDir(): string
    {
        return $this->config->getAccountDir().'Template/';
    }

    public function getAccount(): string
    {
        return $this->config->getAccount();
    }

    public function getTemplateDir(): string
    {
        return $this->config->getTemplateDir();
    }

    public function getCoreTemplateDir(): string
    {
        return $this->config->getCoreTemplateDir();
    }

    public function getRootDir(): string
    {
        return $this->config->getRootDir();
    }

    public function getAssetsDir(): string
    {
        return $this->getWebDir() . 'assets/' . $this->config->get('account') . '/';
    }

    public function getWebDir(): string
    {
        return $this->config->getWebDir();
    }

    public function getUploadDir(): string
    {
        return $this->config->getUploadDir();
    }

    public function getUploadBaseDir(): string
    {
        return $this->config->getSystemDir() . '../public_html/uploads/';
    }

    public function getDomainDir(): string
    {
        return $this->config->getDomainDir();
    }

    public function getCacheDir(): string
    {
        return $this->config->getCacheDir();
    }

    public function getLanguageShortDefault(): ?string
    {
        return $this->config->getLanguageShortDefault();
    }


    public function hasLanguage(): bool
    {
        return $this->config->hasLanguage() || $this->language !== null;
    }

    public function getHost(): string
    {
        return $this->config->getHost();
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function setLanguage(Language $language): ConfigService
    {
        $this->language = $language;

        return $this;
    }

    public function hasMovedTo(): bool
    {
        return $this->config->hasMovedTo();
    }

    public function getMovedTo(): string
    {
        return $this->config->getMovedTo();
    }

    public function getMongoDatabase(): string
    {
        return $this->config->getMongoDatabase();
    }

    public function getMongoUri(): string
    {
        return $this->config->getMongoUri();
    }

    public function renderAdminListChildren(): bool
    {
        return $this->config->renderAdminListChildren();
    }

    public function getBeanstalkHost(): string
    {
        return $this->config->getBeanstalkHost();
    }

    public function getBeanstalkPort(): int
    {
        return $this->config->getBeanstalkPort();
    }

    public function getTemplatePositions(): array
    {
        return (array)$this->config->getTemplate()->get('positions');
    }

    public function isEcommerce(): bool
    {
        if ($this->config->get('ecommerce') === null):
            return false;
        endif;

        return (bool)$this->config->get('ecommerce');
    }

    public function getElasticSearchHost(): string
    {
        return $this->config->get('elasticsearch')->get('host');
    }
}
