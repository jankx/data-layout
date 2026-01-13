<?php
namespace Jankx\DataLayout;

class AjaxHandler
{
    public function __construct()
    {
        add_action('wp_ajax_jankx_data_layout', [$this, 'handle']);
        add_action('wp_ajax_nopriv_jankx_data_layout', [$this, 'handle']);
    }

    public function handle()
    {
        $post_type = $_POST['post_type'] ?? 'post';
        $paged = $_POST['paged'] ?? 1;
        $layout = $_POST['layout'] ?? 'grid';
        $content_layout = $_POST['content_layout'] ?? 'card';

        $args = [
            'post_type' => $post_type,
            'paged' => $paged,
            'posts_per_page' => $_POST['posts_per_page'] ?? 10,
        ];

        try {
            $html = Renderer::render($args, $layout, $content_layout, $_POST);
            wp_send_json_success(['html' => $html]);
        } catch (\Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }
}
