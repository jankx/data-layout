<?php
namespace Jankx\DataLayout\ContentLayouts;

use Jankx\DataLayout\AbstractContentLayout;
use WP_Post;

class Native extends AbstractContentLayout
{
    public function getName(): string
    {
        return 'native';
    }

    public function renderItem(WP_Post $post): string
    {
        global $post;
        $original_post = $post;
        $post = get_post($post);
        setup_postdata($post);

        ob_start();

        $slug = $this->options['template_slug'] ?? 'template-parts/content';
        $name = $this->options['template_name'] ?? get_post_format();

        if ($slug === 'woocommerce') {
            if (function_exists('wc_get_template_part')) {
                wc_get_template_part('content', 'product');
            }
        } else {
            get_template_part($slug, $name);
        }

        $content = ob_get_clean();

        // Restore global post
        $post = $original_post;
        if ($post) {
            setup_postdata($post);
        }

        return $content;
    }
}
