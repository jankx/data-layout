<?php
namespace Jankx\DataLayout;

use Jankx\DataLayout\Interfaces\DataLayoutInterface;
use Jankx\DataLayout\Interfaces\ContentLayoutInterface;
use Jankx\TemplateEngine\TemplateEngine;

class LayoutManager
{
    protected static $instance;
    protected $dataLayouts = [];
    protected $contentLayouts = [];
    protected $templateEngine;

    public function __construct(TemplateEngine $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public static function getInstance(?TemplateEngine $templateEngine = null): self
    {
        if (is_null(self::$instance) && $templateEngine) {
            self::$instance = new self($templateEngine);
        }
        return self::$instance;
    }

    public function registerDataLayout(string $name, string $className)
    {
        $this->dataLayouts[$name] = $className;
    }

    public function registerContentLayout(string $name, string $className)
    {
        $this->contentLayouts[$name] = $className;
    }

    public function createDataLayout(string $name, array $attributes = []): ?DataLayoutInterface
    {
        if (!isset($this->dataLayouts[$name])) {
            return null;
        }

        $className = $this->dataLayouts[$name];
        return new $className($this->templateEngine, $attributes);
    }

    public function createContentLayout(string $name, array $options = []): ?ContentLayoutInterface
    {
        if (!isset($this->contentLayouts[$name])) {
            return null;
        }

        $className = $this->contentLayouts[$name];
        return new $className($this->templateEngine, $options);
    }
}
