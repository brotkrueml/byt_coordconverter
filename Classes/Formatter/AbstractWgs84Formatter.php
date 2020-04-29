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

abstract class AbstractWgs84Formatter implements FormatterInterface
{
    protected function getFormattedLatitudeLongitude(
        string $latitude,
        string $longitude,
        CoordinateConverterParameter $parameter
    ): string {
        $formattedCoordinate = '';

        if ($parameter->getCardinalPointsPosition() === 'before') {
            $formattedCoordinate .= $parameter->getCardinalPointForLatitude() . ' ';
        }

        $formattedCoordinate .= $latitude;

        if ($parameter->getCardinalPointsPosition() === 'after') {
            $formattedCoordinate .= ' ' . $parameter->getCardinalPointForLatitude();
        }

        $formattedCoordinate .= $parameter->getDelimiter();

        if ($parameter->getCardinalPointsPosition() === 'before') {
            $formattedCoordinate .= $parameter->getCardinalPointForLongitude() . ' ';
        }

        $formattedCoordinate .= $longitude;

        if ($parameter->getCardinalPointsPosition() === 'after') {
            $formattedCoordinate .= ' ' . $parameter->getCardinalPointForLongitude();
        }

        return $formattedCoordinate;
    }
}
