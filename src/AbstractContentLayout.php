<?php
namespace Jankx\DataLayout;

use Jankx\DataLayout\Interfaces\ContentLayoutInterface;
use Jankx\TemplateEngine\TemplateEngine;
use WP_Post;

abstract class AbstractContentLayout implements ContentLayoutInterface
{
    protected TemplateEngine $templateEngine;
    protected array $options = [];

    public function __construct(TemplateEngine $templateEngine, array $options = [])
    {
        $this->templateEngine = $templateEngine;
        $this->options = $options;
    }

    abstract public function getName(): string;

    public function renderItem(WP_Post $post): string
    {
        return $this->templateEngine->render(
            'content/' . $this->getName(),
            array_merge($this->options, [
                'post' => $post,
            ])
        );
    }
}
