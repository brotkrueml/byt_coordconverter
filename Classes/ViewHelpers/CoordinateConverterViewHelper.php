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


/**
 * View helper for converting a geospatial coordinate into another
 * format
 *
 * @author Chris Müller <byt3error@web.de>
 * @package Byt_coordconverter
 * @subpackage ViewHelpers\CoordConverter
 */
class CoordinateConverterViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * The allowed coordinate formats
     *
     * @var array
     */
    protected $allowedOutputFormats = array(
        'degree',
        'degreeMinutes',
        'degreeMinutesSeconds',
        'UTM',
    );


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
        $latitude = (float) $latitude;
        $longitude = (float) $longitude;
        $cardinalPointsArray = explode('|', $cardinalPoints);
        $numberOfDecimals = (int) $numberOfDecimals;

        try {
            $this->checkInputParameters($latitude, $longitude, $cardinalPoints, $cardinalPointsPosition, $outputFormat);
        } catch (\InvalidArgumentException $e) {
            if ($showErrors) {
                return $e->getMessage();
            }

            return '';
        }

        $functionCall = 'get' . ucfirst($outputFormat) . 'Notation';

        return htmlspecialchars(
            $this->$functionCall($latitude, $longitude, $cardinalPointsArray, $cardinalPointsPosition, $numberOfDecimals, $removeTrailingZeros, $delimiter)
        );
    }


    /**
     * Get the decimal notation
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $cardinalPoints
     * @param array $cardinalPointsPosition not needed
     * @param int $numberOfDecimals
     * @param boolean $removeTrailingZeros
     * @param string $delimiter
     * @return string
     */
    protected function getDegreeNotation($latitude, $longitude, $cardinalPoints, $cardinalPointsPosition, $numberOfDecimals, $removeTrailingZeros, $delimiter) {
        $newLatitude = number_format(abs($latitude), $numberOfDecimals);
        $newLongitude = number_format(abs($longitude), $numberOfDecimals);

        if ($removeTrailingZeros) {
            $newLatitude = rtrim($newLatitude, '0.');
            $newLongitude = rtrim($newLongitude, '0.');
        }

        $newLatitude .=  '°';
        $newLongitude .=  '°';

        return $this->getFormattedLatitudeLongitude(
            $newLatitude,
            $newLongitude,
            $this->getCardinalPointForLatitude($latitude, $cardinalPoints[0], $cardinalPoints[1]),
            $this->getCardinalPointForLongitude($longitude, $cardinalPoints[2], $cardinalPoints[3]),
            $cardinalPointsPosition,
            $delimiter
        );
    }


    /**
     * Get the degree with minutes notation
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $cardinalPoints
     * @param array $cardinalPointsPosition not needed
     * @param int $numberOfDecimals
     * @param boolean $removeTrailingZeros
     * @param string $delimiter
     * @return string
     */
    protected function getDegreeMinutesNotation($latitude, $longitude, $cardinalPoints, $cardinalPointsPosition, $numberOfDecimals, $removeTrailingZeros, $delimiter) {
        $latitudeDegrees = abs((int) $latitude);
        $latitudeMinutes = number_format(abs(($latitude - (int) $latitude) * 60), $numberOfDecimals);

        $longitudeDegrees = abs((int) $longitude);
        $longitudeMinutes = number_format(abs(($longitude - (int) $longitude) * 60), $numberOfDecimals);

        if ($removeTrailingZeros) {
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
            $this->getCardinalPointForLatitude($latitude, $cardinalPoints[0], $cardinalPoints[1]),
            $this->getCardinalPointForLongitude($longitude, $cardinalPoints[2], $cardinalPoints[3]),
            $cardinalPointsPosition,
            $delimiter
        );
    }


    /**
     * Get the degree with minutes and seconds notation
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $cardinalPoints
     * @param array $cardinalPointsPosition not needed
     * @param int $numberOfDecimals
     * @param boolean $removeTrailingZeros
     * @param string $delimiter
     * @return string
     */
    protected function getDegreeMinutesSecondsNotation($latitude, $longitude, $cardinalPoints, $cardinalPointsPosition, $numberOfDecimals, $removeTrailingZeros, $delimiter) {
        $latitudeDegrees = abs((int) $latitude);
        $latitudeMinutes = abs(($latitude - (int) $latitude) * 60);
        $latitudeSeconds = number_format(abs(($latitudeMinutes - (int) $latitudeMinutes) * 60), $numberOfDecimals);
        $latitudeMinutes = (int) $latitudeMinutes;

        $longitudeDegrees = abs((int) $longitude);
        $longitudeMinutes = abs(($longitude - (int) $longitude) * 60);
        $longitudeSeconds = number_format(abs(($longitudeMinutes - (int) $longitudeMinutes) * 60), $numberOfDecimals);
        $longitudeMinutes = (int) $longitudeMinutes;

        $newLatitude = $latitudeDegrees . '°';
        $newLongitude = $longitudeDegrees . '°';

        if ($removeTrailingZeros) {
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
            $this->getCardinalPointForLatitude($latitude, $cardinalPoints[0], $cardinalPoints[1]),
            $this->getCardinalPointForLongitude($longitude, $cardinalPoints[2], $cardinalPoints[3]),
            $cardinalPointsPosition,
            $delimiter
        );
    }



    /**
     * Get the UTM notation
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $cardinalPoints not needed
     * @param array $cardinalPointsPosition not needed
     * @param int $numberOfDecimals not needed
     * @param boolean $removeTrailingZeros not needed
     * @param string $delimiter not needed
     * @return string
     */
    protected function getUTMNotation($latitude, $longitude, $cardinalPoints, $cardinalPointsPosition, $numberOfDecimals, $removeTrailingZeros, $delimiter) {
        return UtmUtility::getUtmFromLatitudeLongitude($latitude, $longitude);
    }


    /**
     * Get the formatted latitude/longitude
     *
     * @param float|string $latitude
     * @param float|string $longitude
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


    /**
     * Get the cardinal point for a latitude
     *
     * @param float $latitude
     * @param string $north
     * @param string $south
     * @return string
     */
    protected function getCardinalPointForLatitude($latitude, $north, $south) {
        if ($latitude >= 0.0) {
            return $north;
        }

        return $south;
    }



    /**
     * Get the cardinal point for a longitude
     *
     * @param float $longitude
     * @param string $east
     * @param string $west
     * @return string
     */
    protected function getCardinalPointForLongitude($longitude, $east, $west) {
        if ($longitude >= 0.0) {
            return $east;
        }

        return $west;
    }



    /**
     * Check the input parameters of the view helper
     *
     * @param $latitude
     * @param $longitude
     * @param $cardinalPoints
     * @param $cardinalPointsPosition
     * @param $outputFormat
     * @return bool
     * @throws \InvalidArgumentException
     */
    protected function checkInputParameters($latitude, $longitude, $cardinalPoints, $cardinalPointsPosition, $outputFormat)
    {
        if (($latitude > 90.0) || ($latitude < -90.0)) {
            throw new \InvalidArgumentException(
                'Wrong latitude: must be between 90.0 and -90.0 (given: ' . htmlspecialchars($latitude) . ')'
            );
        }

        if (($longitude > 180.0) || ($longitude < -180.0)) {
            throw new \InvalidArgumentException(
                'Wrong longitude: must be between 180.0 and -180.0 (given: ' . htmlspecialchars($longitude) . ')'
            );
        }

        $cardinalPointsArray = explode('|', $cardinalPoints);
        if (count($cardinalPointsArray) !== 4) {
            throw new \InvalidArgumentException(
                'Wrong number of parameters for cardinal points: must be 4 (separated by |, given: ' . htmlspecialchars($cardinalPoints) . ')'
            );
        }

        if (($cardinalPointsPosition !== 'before') && ($cardinalPointsPosition !== 'after')) {
            throw new \InvalidArgumentException(
                'Wrong cardinal points position: must be before or after (given: ' . htmlspecialchars($cardinalPointsPosition) . ')'
            );
        }

        if (!in_array($outputFormat, $this->allowedOutputFormats)) {
            throw new \InvalidArgumentException(
                'Wrong output format (given: ' . htmlspecialchars($outputFormat) . ', allowed: ' . implode(', ', $this->allowedOutputFormats) . ')'
            );
        }

        return TRUE;
    }
}