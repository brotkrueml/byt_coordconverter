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

class DegreeMinutesFormatter extends AbstractWgs84Formatter
{
    public function format(CoordinateConverterParameter $parameter): string
    {
        $latitudeDegrees = \abs((int)$parameter->getLatitude());
        $latitudeMinutes = \number_format(
            \abs(($parameter->getLatitude() - (int)$parameter->getLatitude()) * 60),
            $parameter->getNumberOfDecimals()
        );

        $longitudeDegrees = \abs((int)$parameter->getLongitude());
        $longitudeMinutes = \number_format(
            \abs(($parameter->getLongitude() - (int)$parameter->getLongitude()) * 60),
            $parameter->getNumberOfDecimals()
        );

        if ($parameter->shouldTrailingZerosBeRemoved()) {
            $latitudeMinutes = \rtrim($latitudeMinutes, '0.');
            $longitudeMinutes = \rtrim($longitudeMinutes, '0.');
        }

        $newLatitude = $latitudeDegrees . '°';
        $newLongitude = $longitudeDegrees . '°';

        if ($latitudeMinutes) {
            $newLatitude .= ' ' . $latitudeMinutes . '\'';
        }

        if ($longitudeMinutes) {
            $newLongitude .= ' ' . $longitudeMinutes . '\'';
        }

        return $this->getFormattedLatitudeLongitude($newLatitude, $newLongitude, $parameter);
    }
}
