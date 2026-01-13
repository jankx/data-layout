<?php
namespace Jankx\DataLayout;

use Jankx\DataLayout\Interfaces\DataLayoutInterface;
use Jankx\DataLayout\Interfaces\ContentLayoutInterface;
use Jankx\TemplateEngine\TemplateEngine;
use WP_Query;

abstract class AbstractDataLayout implements DataLayoutInterface
{
    protected ?ContentLayoutInterface $contentLayout = null;
    protected TemplateEngine $templateEngine;
    protected array $attributes = [];

    public function __construct(TemplateEngine $templateEngine, array $attributes = [])
    {
        $this->templateEngine = $templateEngine;
        $this->attributes = $attributes;
    }

    public function setContentLayout(ContentLayoutInterface $contentLayout)
    {
        $this->contentLayout = $contentLayout;
    }

    public function getContentLayout(): ?ContentLayoutInterface
    {
        return $this->contentLayout;
    }

    abstract public function getName(): string;

    public function render(WP_Query $query): string
    {
        if (!$this->contentLayout) {
            throw new \Exception("Content layout must be set for Data Layout " . $this->getName());
        }

        $items = [];
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $items[] = $this->contentLayout->renderItem($query->post);
            }
            wp_reset_postdata();
        }

        $pagination = '';
        if ($query->max_num_pages > 1 && ($this->attributes['show_pagination'] ?? false)) {
            $current_page = max(1, get_query_var('paged', 1));
            $pagination = paginate_links([
                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                'format' => '?paged=%#%',
                'current' => $current_page,
                'total' => $query->max_num_pages,
                'type' => 'list',
                'prev_text' => '<i class="icon-angle-left"></i>',
                'next_text' => '<i class="icon-angle-right"></i>',
            ]);
        }

        return $this->templateEngine->render(
            'layouts/' . $this->getName(),
            array_merge($this->attributes, [
                'items' => $items,
                'query' => $query,
                'pagination' => $pagination,
            ])
        );
    }
}
