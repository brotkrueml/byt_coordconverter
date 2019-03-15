<?php
declare(strict_types=1);

namespace Brotkrueml\BytCoordconverter\Formatter;

use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter;

class DegreeMinutesSecondsFormatter extends AbstractWgs84Formatter
{
    public function format(CoordinateConverterParameter $parameter): string
    {
        $latitudeDegrees = abs((int)$parameter->getLatitude());
        $latitudeMinutes = abs(($parameter->getLatitude() - (int)$parameter->getLatitude()) * 60);
        $latitudeSeconds = number_format(
            abs(($latitudeMinutes - (int)$latitudeMinutes) * 60),
            $parameter->getNumberOfDecimals()
        );
        $latitudeMinutes = (int)$latitudeMinutes;

        $longitudeDegrees = abs((int)$parameter->getLongitude());
        $longitudeMinutes = abs(($parameter->getLongitude() - (int)$parameter->getLongitude()) * 60);
        $longitudeSeconds = number_format(
            abs(($longitudeMinutes - (int)$longitudeMinutes) * 60),
            $parameter->getNumberOfDecimals()
        );
        $longitudeMinutes = (int)$longitudeMinutes;

        $newLatitude = $latitudeDegrees . '°';
        $newLongitude = $longitudeDegrees . '°';

        if ($parameter->shouldTrailingZerosBeRemoved()) {
            $latitudeSeconds = rtrim($latitudeSeconds, '0.');
            $longitudeSeconds = rtrim($longitudeSeconds, '0.');

            if (empty($latitudeSeconds)) {
                if ($latitudeMinutes !== 0) {
                    $newLatitude .= ' ' . $latitudeMinutes . '\'';
                }
            } else {
                $newLatitude .= ' ' . $latitudeMinutes . '\' ' . $latitudeSeconds . '"';
            }

            if (empty($longitudeSeconds)) {
                if ($longitudeMinutes !== 0) {
                    $newLongitude .= ' ' . $longitudeMinutes . '\'';
                }
            } else {
                $newLongitude .= ' ' . $longitudeMinutes . '\' ' . $longitudeSeconds . '"';
            }
        } else {
            $newLatitude .= ' ' . $latitudeMinutes . '\' ' . $latitudeSeconds . '"';
            $newLongitude .= ' ' . $longitudeMinutes . '\' ' . $longitudeSeconds . '"';
        }

        return $this->getFormattedLatitudeLongitude($newLatitude, $newLongitude, $parameter);
    }
}