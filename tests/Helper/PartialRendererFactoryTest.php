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

namespace Mimmi20Test\LaminasView\Helper\PartialRenderer\Helper;

use Mezzio\LaminasView\LaminasViewRenderer;
use Mimmi20\LaminasView\Helper\PartialRenderer\Helper\PartialRenderer;
use Mimmi20\LaminasView\Helper\PartialRenderer\Helper\PartialRendererFactory;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;

use function assert;

final class PartialRendererFactoryTest extends TestCase
{
    /**
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testInvocation(): void
    {
        $renderer = $this->createMock(LaminasViewRenderer::class);

        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $container->expects(self::once())
            ->method('get')
            ->with(LaminasViewRenderer::class)
            ->willReturn($renderer);

        assert($container instanceof ContainerInterface);
        $helper = (new PartialRendererFactory())($container);

        self::assertInstanceOf(PartialRenderer::class, $helper);
    }
}
