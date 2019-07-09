<?php
declare(strict_types=1);

namespace Brotkrueml\BytCoordconverter\Formatter;

/**
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter;

class DegreeFormatter extends AbstractWgs84Formatter
{
    public function format(CoordinateConverterParameter $parameter): string
    {
        $newLatitude = \number_format(
            \abs($parameter->getLatitude()),
            $parameter->getNumberOfDecimals()
        );
        $newLongitude = \number_format(
            \abs($parameter->getLongitude()),
            $parameter->getNumberOfDecimals()
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
