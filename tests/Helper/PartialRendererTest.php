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

namespace Mimmi20Test\LaminasView\Helper\PartialRenderer\Helper;

use Laminas\View\Exception\ExceptionInterface;
use Laminas\View\Exception\InvalidArgumentException;
use Laminas\View\Exception\RuntimeException;
use Laminas\View\Model\ModelInterface;
use Laminas\View\Resolver\ResolverInterface;
use Mezzio\LaminasView\LaminasViewRenderer;
use Mimmi20\LaminasView\Helper\PartialRenderer\Helper\PartialRenderer;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

use function assert;

final class PartialRendererTest extends TestCase
{
    /**
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function testRenderPartialWithWrongPartial(): void
    {
        $partial = ['abc'];
        $data    = [];

        $renderer = $this->getMockBuilder(LaminasViewRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $renderer->expects(self::never())
            ->method('render');

        assert($renderer instanceof LaminasViewRenderer);
        $helper = new PartialRenderer($renderer);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Unable to render partial: A view partial supplied as an array must contain one value: the partial view script',
        );
        $this->expectExceptionCode(0);

        $helper->render($partial, $data);
    }

    /**
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function testRenderPartial(): void
    {
        $data = [];

        $partial  = 'testPartial';
        $expected = 'renderedPartial';

        $renderer = $this->getMockBuilder(LaminasViewRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $renderer->expects(self::once())
            ->method('render')
            ->with($partial, $data)
            ->willReturn($expected);

        assert($renderer instanceof LaminasViewRenderer);
        $helper = new PartialRenderer($renderer);

        self::assertSame($expected, $helper->render($partial, $data));
    }

    /**
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function testRenderPartialWithArrayPartial(): void
    {
        $partial  = 'testPartial';
        $expected = 'renderedPartial';
        $data     = ['x' => $partial, 'y' => 'test'];

        $renderer = $this->getMockBuilder(LaminasViewRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $renderer->expects(self::once())
            ->method('render')
            ->with($partial, $data)
            ->willReturn($expected);

        assert($renderer instanceof LaminasViewRenderer);
        $helper = new PartialRenderer($renderer);

        self::assertSame($expected, $helper->render($partial, $data));
    }

    /**
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function testRenderPartialWithPartialModel(): void
    {
        $expected = 'renderedPartial';
        $partial  = 'testPartial';
        $data     = ['x' => $partial, 'y' => 'test'];

        $model = $this->getMockBuilder(ModelInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $model->expects(self::once())
            ->method('setVariables')
            ->with($data)
            ->willReturnSelf();
        $model->expects(self::once())
            ->method('getTemplate')
            ->willReturn($partial);

        $renderer = $this->getMockBuilder(LaminasViewRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $renderer->expects(self::once())
            ->method('render')
            ->with($partial, $model)
            ->willReturn($expected);

        assert($renderer instanceof LaminasViewRenderer);
        $helper = new PartialRenderer($renderer);

        self::assertSame($expected, $helper->render($model, $data));
    }

    /**
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function testRenderPartialWithPartialModelWithoutPartial(): void
    {
        $expected = 'renderedPartial';
        $partial  = 'testPartial';
        $data     = ['x' => $partial, 'y' => 'test'];

        $renderer = $this->getMockBuilder(LaminasViewRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $renderer->expects(self::never())
            ->method('render');

        assert($renderer instanceof LaminasViewRenderer);
        $helper = new PartialRenderer($renderer);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unable to render partial: No partial view script provided');
        $this->expectExceptionCode(0);

        self::assertSame($expected, $helper->render(null, $data));
    }

    /**
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function testRenderPartialWithArrayPartial2(): void
    {
        $expected = 'renderedPartial';
        $partial  = ['abc', 'bcd'];
        $data     = [];

        $renderer = $this->getMockBuilder(LaminasViewRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $renderer->expects(self::once())
            ->method('render')
            ->with('abc', $data)
            ->willReturn($expected);

        assert($renderer instanceof LaminasViewRenderer);
        $helper = new PartialRenderer($renderer);

        self::assertSame($expected, $helper->render($partial, $data));
    }

    /**
     * @throws Exception
     * @throws ExceptionInterface
     */
    public function testRenderPartialWithArrayPartial3(): void
    {
        $expected = 'renderedPartial';
        $partial  = ['abc', 'bcd'];
        $data     = null;

        $renderer = $this->getMockBuilder(LaminasViewRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $renderer->expects(self::once())
            ->method('render')
            ->with('abc', [])
            ->willReturn($expected);

        assert($renderer instanceof LaminasViewRenderer);
        $helper = new PartialRenderer($renderer);

        self::assertSame($expected, $helper->render($partial, $data));
    }

    /** @throws Exception */
    public function testGetEngine(): void
    {
        $renderer = $this->getMockBuilder(LaminasViewRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $renderer->expects(self::never())
            ->method('render');

        assert($renderer instanceof LaminasViewRenderer);
        $helper = new PartialRenderer($renderer);

        self::assertSame($helper, $helper->getEngine());
    }

    /** @throws Exception */
    public function testSetResolver(): void
    {
        $resolver = $this->getMockBuilder(ResolverInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $resolver->expects(self::never())
            ->method('resolve');

        $renderer = $this->getMockBuilder(LaminasViewRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $renderer->expects(self::never())
            ->method('render');

        assert($renderer instanceof LaminasViewRenderer);
        $helper = new PartialRenderer($renderer);

        self::assertSame($helper, $helper->setResolver($resolver));
    }
}
