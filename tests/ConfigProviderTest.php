<?php

/**
 * This file is part of the mimmi20/laminasviewrenderer-helper-partialrenderer package.
 *
 * Copyright (c) 2021-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Mimmi20Test\LaminasView\Helper\PartialRenderer;

use Mimmi20\LaminasView\Helper\PartialRenderer\ConfigProvider;
use Mimmi20\LaminasView\Helper\PartialRenderer\Helper\PartialRenderer;
use Mimmi20\LaminasView\Helper\PartialRenderer\Helper\PartialRendererInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

final class ConfigProviderTest extends TestCase
{
    /** @throws Exception */
    public function testReturnedArrayContainsDependencies(): void
    {
        $config = (new ConfigProvider())();
        self::assertIsArray($config);
        self::assertCount(1, $config);

        self::assertArrayHasKey('dependencies', $config);

        $dependencies = $config['dependencies'];
        self::assertIsArray($dependencies);
        self::assertCount(2, $dependencies);
        self::assertArrayHasKey('factories', $dependencies);

        $factories = $dependencies['factories'];
        self::assertIsArray($factories);
        self::assertCount(1, $factories);
        self::assertArrayHasKey(PartialRenderer::class, $factories);

        $aliases = $dependencies['aliases'];
        self::assertIsArray($aliases);
        self::assertCount(1, $aliases);
        self::assertArrayHasKey(PartialRendererInterface::class, $aliases);
    }

    /** @throws Exception */
    public function testReturnedArrayContainsDependencies2(): void
    {
        $dependencies = (new ConfigProvider())->getDependencyConfig();
        self::assertIsArray($dependencies);
        self::assertCount(2, $dependencies);
        self::assertArrayHasKey('factories', $dependencies);

        $factories = $dependencies['factories'];
        self::assertIsArray($factories);
        self::assertCount(1, $factories);
        self::assertArrayHasKey(PartialRenderer::class, $factories);

        $aliases = $dependencies['aliases'];
        self::assertIsArray($aliases);
        self::assertCount(1, $aliases);
        self::assertArrayHasKey(PartialRendererInterface::class, $aliases);
    }
}
