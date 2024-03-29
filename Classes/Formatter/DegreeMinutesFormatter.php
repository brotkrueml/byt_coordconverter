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
final class DegreeMinutesFormatter extends AbstractWgs84Formatter
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

        if ($latitudeMinutes !== '' && $latitudeMinutes !== '0') {
            $newLatitude .= ' ' . $latitudeMinutes . '\'';
        }

        if ($longitudeMinutes !== '' && $longitudeMinutes !== '0') {
            $newLongitude .= ' ' . $longitudeMinutes . '\'';
        }

        return $this->getFormattedLatitudeLongitude($newLatitude, $newLongitude, $parameter);
    }
}
