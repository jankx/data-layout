<?php
namespace Jankx\DataLayout\Interfaces;

use WP_Query;

interface DataLayoutInterface
{
    public function getName(): string;

    public function render(WP_Query $query): string;

    public function setContentLayout(ContentLayoutInterface $contentLayout);

    public function getContentLayout(): ?ContentLayoutInterface;
}
