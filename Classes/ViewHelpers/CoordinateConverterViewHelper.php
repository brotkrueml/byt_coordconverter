<?php
namespace Byterror\BytCoordconverter\ViewHelpers;

/***************************************************************
*  Copyright notice
*
*  (c) 2013-2014 Chris Müller <byt3error@web.de>
*
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
* ************************************************************* */

use Byterror\BytCoordconverter\Utility\UtmUtility;
use Byterror\BytCoordconverter\Domain\Model\CoordinateConverterParameter as Parameter;


/**
 * View helper for converting a geospatial coordinate into another
 * format
 *
 * @author Chris Müller <byt3error@web.de>
 * @package Byt_coordconverter
 */
class CoordinateConverterViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
    /**
     * @var Parameter
     */
    protected $parameter;

    /**
     * Render method
     *
     * @param float $latitude
     * @param float $longitude
     * @param string $outputFormat
     * @param string $cardinalPoints in format North South East West
     * @param string $cardinalPointsPosition [before|after]
     * @param int $numberOfDecimals
     * @param boolean $removeTrailingZeros
     * @param string $delimiter
     * @param boolean $showErrors
     * @return string
     */
    public function render($latitude, $longitude, $outputFormat = 'degree', $cardinalPoints = 'N|S|E|W', $cardinalPointsPosition = 'before', $numberOfDecimals = 5, $removeTrailingZeros = FALSE, $delimiter = ', ', $showErrors = FALSE) {
        try {
            $this->parameter = new Parameter(
                $latitude,
                $longitude,
                $outputFormat,
                $cardinalPoints,
                $cardinalPointsPosition,
                $numberOfDecimals,
                $removeTrailingZeros,
                $delimiter
            );
        } catch (\InvalidArgumentException $e) {
            if ($showErrors) {
                return $e->getMessage();
            }

            return '';
        }

        $functionCall = 'get' . ucfirst($this->parameter->getOutputFormat()) . 'Notation';

        return htmlspecialchars(
            $this->$functionCall()
        );
    }


    /**
     * @return string
     */
    protected function getDegreeNotation() {
        $newLatitude = number_format(
            abs($this->parameter->getLatitude()),
            $this->parameter->getNumberOfDecimals()
        );
        $newLongitude = number_format(
            abs($this->parameter->getLongitude()),
            $this->parameter->getNumberOfDecimals()
        );

        if ($this->parameter->shouldTrailingZerosBeRemoved()) {
            $newLatitude = rtrim($newLatitude, '0.');
            $newLongitude = rtrim($newLongitude, '0.');
        }

        $newLatitude .=  '°';
        $newLongitude .=  '°';

        return $this->getFormattedLatitudeLongitude(
            $newLatitude,
            $newLongitude,
            $this->parameter->getCardinalPointForLatitude(),
            $this->parameter->getCardinalPointForLongitude(),
            $this->parameter->getCardinalPointsPosition(),
            $this->parameter->getDelimiter()
        );
    }


    /**
     * @return string
     */
    protected function getDegreeMinutesNotation() {
        $latitudeDegrees = abs((int) $this->parameter->getLatitude());
        $latitudeMinutes = number_format(
            abs(($this->parameter->getLatitude() - (int) $this->parameter->getLatitude()) * 60),
            $this->parameter->getNumberOfDecimals()
        );

        $longitudeDegrees = abs((int) $this->parameter->getLongitude());
        $longitudeMinutes = number_format(
            abs(($this->parameter->getLongitude() - (int) $this->parameter->getLongitude()) * 60),
            $this->parameter->getNumberOfDecimals()
        );

        if ($this->parameter->shouldTrailingZerosBeRemoved()) {
            $latitudeMinutes = rtrim($latitudeMinutes, '0.');
            $longitudeMinutes = rtrim($longitudeMinutes, '0.');
        }

        $newLatitude = $latitudeDegrees . '°';
        $newLongitude = $longitudeDegrees . '°';

        if ($latitudeMinutes) {
            $newLatitude .=  ' ' . $latitudeMinutes . '\'';
        }

        if ($longitudeMinutes) {
            $newLongitude .=  ' ' . $longitudeMinutes . '\'';
        }

        return $this->getFormattedLatitudeLongitude(
            $newLatitude,
            $newLongitude,
            $this->parameter->getCardinalPointForLatitude(),
            $this->parameter->getCardinalPointForLongitude(),
            $this->parameter->getCardinalPointsPosition(),
            $this->parameter->getDelimiter()
        );
    }


    /**
     * @return string
     */
    protected function getDegreeMinutesSecondsNotation() {
        $latitudeDegrees = abs((int) $this->parameter->getLatitude());
        $latitudeMinutes = abs(($this->parameter->getLatitude() - (int) $this->parameter->getLatitude()) * 60);
        $latitudeSeconds = number_format(
            abs(($latitudeMinutes - (int) $latitudeMinutes) * 60),
            $this->parameter->getNumberOfDecimals()
        );
        $latitudeMinutes = (int) $latitudeMinutes;

        $longitudeDegrees = abs((int) $this->parameter->getLongitude());
        $longitudeMinutes = abs(($this->parameter->getLongitude() - (int) $this->parameter->getLongitude()) * 60);
        $longitudeSeconds = number_format(
            abs(($longitudeMinutes - (int) $longitudeMinutes) * 60),
            $this->parameter->getNumberOfDecimals()
        );
        $longitudeMinutes = (int) $longitudeMinutes;

        $newLatitude = $latitudeDegrees . '°';
        $newLongitude = $longitudeDegrees . '°';

        if ($this->parameter->shouldTrailingZerosBeRemoved()) {
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

        return $this->getFormattedLatitudeLongitude(
            $newLatitude,
            $newLongitude,
            $this->parameter->getCardinalPointForLatitude(),
            $this->parameter->getCardinalPointForLongitude(),
            $this->parameter->getCardinalPointsPosition(),
            $this->parameter->getDelimiter()
        );
    }



    /**
     * @return string
     */
    protected function getUTMNotation() {
        return UtmUtility::getUtmFromLatitudeLongitude(
            $this->parameter->getLatitude(),
            $this->parameter->getLongitude()
        );
    }


    /**
     * Get the formatted latitude/longitude
     *
     * @param string $latitude
     * @param string $longitude
     * @param string $northOrSouth
     * @param string $eastOrWest
     * @param string $cardinalPointPosition
     * @param string $delimiter
     * @return string
     */
    protected function getFormattedLatitudeLongitude($latitude, $longitude, $northOrSouth, $eastOrWest, $cardinalPointPosition, $delimiter) {
        $formattedCoordinate = '';

        if ($cardinalPointPosition === 'before') {
            $formattedCoordinate .= $northOrSouth . ' ';
        }

        $formattedCoordinate .= $latitude;

        if ($cardinalPointPosition === 'after') {
            $formattedCoordinate .= ' ' . $northOrSouth;
        }

        $formattedCoordinate .= $delimiter;

        if ($cardinalPointPosition === 'before') {
            $formattedCoordinate .= $eastOrWest . ' ';
        }

        $formattedCoordinate .= $longitude;

        if ($cardinalPointPosition === 'after') {
            $formattedCoordinate .= ' ' . $eastOrWest;
        }

        return $formattedCoordinate;
    }
}