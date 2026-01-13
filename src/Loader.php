<?php
namespace Jankx\DataLayout;

use Jankx\TemplateEngine\Engines\LatteEngine;
use Jankx\TemplateEngine\TemplateEngine;
use Jankx\DataLayout\Layouts\Grid;
use Jankx\DataLayout\Layouts\ListLayout;
use Jankx\DataLayout\Layouts\Carousel;
use Jankx\DataLayout\Layouts\Masonry;
use Jankx\DataLayout\Layouts\Horizontal;
use Jankx\DataLayout\ContentLayouts\Card;
use Jankx\DataLayout\ContentLayouts\Simple;
use Jankx\DataLayout\ContentLayouts\Native;
use Jankx\DataLayout\ContentLayouts\AkselosCard;
use Jankx\DataLayout\AjaxHandler;

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
        $manager->registerDataLayout('grid', Grid::class);
        $manager->registerDataLayout('list', ListLayout::class);
        $manager->registerDataLayout('carousel', Carousel::class);
        $manager->registerDataLayout('masonry', Masonry::class);
        $manager->registerDataLayout('horizontal', Horizontal::class);

        // Register default Content Layouts
        $manager->registerContentLayout('card', Card::class);
        $manager->registerContentLayout('simple', Simple::class);
        $manager->registerContentLayout('native', Native::class);
        $manager->registerContentLayout('akselos-card', AkselosCard::class);

        new AjaxHandler();
    }
}
