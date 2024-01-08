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

use ArrayAccess;
use Laminas\View\Exception\InvalidArgumentException;
use Laminas\View\Exception\RuntimeException;
use Laminas\View\Model\ModelInterface;
use Laminas\View\Renderer\RendererInterface;
use Laminas\View\Resolver\ResolverInterface;
use Mezzio\LaminasView\LaminasViewRenderer;

use function count;
use function is_array;

final class PartialRenderer implements PartialRendererInterface, RendererInterface
{
    /** @throws void */
    public function __construct(private readonly LaminasViewRenderer $renderer)
    {
        // nothing to do
    }

    /**
     * Processes a view script and returns the output.
     *
     * @param array<int, string>|ModelInterface|string|null                    $nameOrModel The script/resource process, or a view model
     * @param array<(int|string), mixed>|ArrayAccess<(int|string), mixed>|null $values      Values to use during rendering
     *
     * @return string the script output
     *
     * @throws RuntimeException
     * @throws InvalidArgumentException
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
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

    /**
     * @return $this
     *
     * @throws void
     */
    public function getEngine(): self
    {
        return $this;
    }

    /**
     * @throws void
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function setResolver(ResolverInterface $resolver): self
    {
        return $this;
    }
}
