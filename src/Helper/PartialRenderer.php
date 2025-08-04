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

namespace Mimmi20\LaminasView\Helper\PartialRenderer\Helper;

use ArrayAccess;
use Laminas\View\Exception\InvalidArgumentException;
use Laminas\View\Exception\RuntimeException;
use Laminas\View\Model\ModelInterface;
use Laminas\View\Renderer\RendererInterface;
use Laminas\View\Resolver\ResolverInterface;
use Mezzio\LaminasView\LaminasViewRenderer;
use Override;

use function count;
use function is_array;

final readonly class PartialRenderer implements PartialRendererInterface, RendererInterface
{
    /** @throws void */
    public function __construct(private LaminasViewRenderer $renderer)
    {
        // nothing to do
    }

    /**
     * Processes a view script and returns the output.
     *
     * @param array<int, string>|ModelInterface|string|null        $nameOrModel The script/resource process, or a view model
     * @param array<string, mixed>|ArrayAccess<string, mixed>|null $values      Values to use during rendering
     *
     * @return string the script output
     *
     * @throws RuntimeException
     * @throws InvalidArgumentException
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint
     */
    #[Override]
    public function render($nameOrModel, $values = null)
    {
        if ($nameOrModel === null || $nameOrModel === '' || $nameOrModel === []) {
            throw new RuntimeException('Unable to render partial: No partial view script provided');
        }

        if (is_array($nameOrModel)) {
            if (count($nameOrModel) !== 2) {
                throw new InvalidArgumentException(
                    'Unable to render partial: A view partial supplied as '
                    . 'an array must contain one value: the partial view script',
                );
            }

            $nameOrModel = $nameOrModel[0];
        }

        if ($values === null) {
            $values = [];
        }

        $model = $values;

        if ($nameOrModel instanceof ModelInterface) {
            $model       = $nameOrModel->setVariables($model);
            $nameOrModel = $model->getTemplate();
        }

        return $this->renderer->render($nameOrModel, $model);
    }

    /** @throws void */
    #[Override]
    public function getEngine(): self
    {
        return $this;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    #[Override]
    public function setResolver(ResolverInterface $resolver): self
    {
        return $this;
    }
}
