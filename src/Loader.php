<?php
namespace Jankx\DataLayout;

use Jankx\TemplateEngine\Engines\LatteEngine;
use Jankx\TemplateEngine\TemplateEngine;

class Loader
{
    public static function boot()
    {
        $templateEngine = new TemplateEngine(
            new LatteEngine(),
            dirname(__DIR__) . '/templates'
        );

        $manager = LayoutManager::getInstance($templateEngine);

        // Register default Data Layouts
        $manager->registerDataLayout('grid', Layouts\Grid::class);
        $manager->registerDataLayout('list', Layouts\ListLayout::class);
        $manager->registerDataLayout('carousel', Layouts\Carousel::class);
        $manager->registerDataLayout('masonry', Layouts\Masonry::class);
        $manager->registerDataLayout('horizontal', Layouts\Horizontal::class);

        // Register default Content Layouts
        $manager->registerContentLayout('card', ContentLayouts\Card::class);
        $manager->registerContentLayout('simple', ContentLayouts\Simple::class);

        new AjaxHandler();
    }
}
