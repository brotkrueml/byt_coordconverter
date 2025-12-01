<?php

declare(strict_types=1);

/*
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\BytCoordconverter\Formatter;

use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter;

/**
 * @internal
 */
final class DegreeFormatter extends AbstractWgs84Formatter
{
    public function format(CoordinateConverterParameter $parameter): string
    {
        $newLatitude = \number_format(
            \abs($parameter->getLatitude()),
            $parameter->getNumberOfDecimals(),
        );
        $newLongitude = \number_format(
            \abs($parameter->getLongitude()),
            $parameter->getNumberOfDecimals(),
        );

        if ($parameter->shouldTrailingZerosBeRemoved()) {
            $newLatitude = \rtrim($newLatitude, '0.');
            $newLongitude = \rtrim($newLongitude, '0.');
        }

        $newLatitude .= '°';
        $newLongitude .= '°';

        return $this->getFormattedLatitudeLongitude($newLatitude, $newLongitude, $parameter);
    }
}
