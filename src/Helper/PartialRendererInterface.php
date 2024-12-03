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

interface PartialRendererInterface
{
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
    public function render($nameOrModel, $values = null);
}
