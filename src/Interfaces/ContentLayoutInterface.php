<?php
namespace Jankx\DataLayout\Interfaces;

use WP_Post;

interface ContentLayoutInterface
{
    public function getName(): string;

    public function renderItem(WP_Post $post): string;
}
