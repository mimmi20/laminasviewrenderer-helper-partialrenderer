<?php

/**
 * This file is part of the mimmi20/laminasviewrenderer-helper-partialrenderer package.
 *
 * Copyright (c) 2021-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20\LaminasView\Helper\PartialRenderer\Helper;

use Mezzio\LaminasView\LaminasViewRenderer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

use function assert;

final class PartialRendererFactory
{
    /** @throws ContainerExceptionInterface */
    public function __invoke(ContainerInterface $container): PartialRenderer
    {
        $renderer = $container->get(LaminasViewRenderer::class);

        assert($renderer instanceof LaminasViewRenderer);

        return new PartialRenderer($renderer);
    }
}
