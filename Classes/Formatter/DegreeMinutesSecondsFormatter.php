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
final class DegreeMinutesSecondsFormatter extends AbstractWgs84Formatter
{
    public function format(CoordinateConverterParameter $parameter): string
    {
        $newLatitude = $this->formatCoordinate(
            $parameter->getLatitude(),
            $parameter->getNumberOfDecimals(),
            $parameter->shouldTrailingZerosBeRemoved()
        );

        $newLongitude = $this->formatCoordinate(
            $parameter->getLongitude(),
            $parameter->getNumberOfDecimals(),
            $parameter->shouldTrailingZerosBeRemoved()
        );

        return $this->getFormattedLatitudeLongitude($newLatitude, $newLongitude, $parameter);
    }

    private function formatCoordinate(float $coordinate, int $numberOfDecimals, bool $removeTrailingZeros): string
    {
        $degrees = \abs((int)$coordinate);
        $minutes = \abs(($coordinate - (int)$coordinate) * 60);
        $seconds = \number_format(
            \abs(($minutes - (int)$minutes) * 60),
            $numberOfDecimals
        );
        $minutes = (int)$minutes;

        $coordinate = $degrees . '°';

        if (! $removeTrailingZeros) {
            return $coordinate . ' ' . $minutes . '\' ' . $seconds . '"';
        }

        $seconds = \rtrim($seconds, '0.');

        if ($seconds) {
            return $coordinate . ' ' . $minutes . '\' ' . $seconds . '"';
        }

        if ($minutes) {
            return $coordinate . ' ' . $minutes . '\'';
        }

        return $coordinate;
    }
}
