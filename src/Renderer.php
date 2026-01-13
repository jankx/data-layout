<?php
namespace Jankx\DataLayout;

use WP_Query;

class Renderer
{
    public static function render($queryOrArgs, $layoutName = 'grid', $contentLayoutName = 'card', $attributes = [])
    {
        $query = $queryOrArgs instanceof WP_Query ? $queryOrArgs : new WP_Query($queryOrArgs);
        $manager = LayoutManager::getInstance();

        if (!$manager) {
            throw new \Exception("Jankx Data Layout must be booted first.");
        }

        $dataLayout = $manager->createDataLayout($layoutName, $attributes);
        $contentLayout = $manager->createContentLayout($contentLayoutName, $attributes);

        if ($dataLayout && $contentLayout) {
            $dataLayout->setContentLayout($contentLayout);
            return $dataLayout->render($query);
        }

        return '';
    }
}
