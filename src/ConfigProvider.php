<?php
/**
 * This file is part of the mimmi20/laminasviewrenderer-helper-partialrenderer package.
 *
 * Copyright (c) 2021-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\LaminasView\Helper\PartialRenderer;

final class ConfigProvider
{
    /**
     * Return general-purpose laminas-navigation configuration.
     *
     * @return array<string, array<string, array<string, string>>>
     *
     * @throws void
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    /**
     * Return application-level dependency configuration.
     *
     * @return array<string, array<string, string>>
     *
     * @throws void
     */
    public function getDependencyConfig(): array
    {
        return [
            'factories' => [
                Helper\PartialRenderer::class => Helper\PartialRendererFactory::class,
            ],
            'aliases' => [
                Helper\PartialRendererInterface::class => Helper\PartialRenderer::class,
            ],
        ];
    }
}
