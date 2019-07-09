<?php
declare(strict_types = 1);

namespace Brotkrueml\BytCoordconverter\Formatter;

/**
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter;

interface FormatterInterface
{
    public function format(CoordinateConverterParameter $parameter): string;
}
