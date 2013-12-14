<?php
namespace Byterror\BytCoordconverter\ViewHelpers;

/***************************************************************
*  Copyright notice
*
*  (c) 2013 Chris Müller <byt3error@web.de>
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
     * @param string $delimiter
     * @param boolean $showErrors
     * @return string
     */
    public function render($latitude, $longitude, $outputFormat = 'degree', $cardinalPoints = 'N|S|E|W', $cardinalPointsPosition = 'before', $delimiter = ', ', $showErrors = FALSE) {
        $latitude = (float) $latitude;
        $longitude = (float) $longitude;
        $cardinalPointsArray = explode('|', $cardinalPoints);

        if (($latitude > 90.0) || ($latitude < -90.0)) {
            return $showErrors ? 'Wrong latitude: must be between 90.0 and -90.0 (given: ' . htmlspecialchars($latitude) . ')' : '';
        }

        if (($longitude > 180.0) || ($longitude < -180.0)) {
            return $showErrors ? 'Wrong longitude: must be between 180.0 and -180.0 (given: ' . htmlspecialchars($longitude) . ')' : '';
        }

        if (count($cardinalPointsArray) !== 4) {
            return $showErrors ? 'Wrong number of parameters for cardinal points: must be 4 (separated by |, given: ' . htmlspecialchars($cardinalPoints) . ')' : '';
        }

        if (($cardinalPointsPosition !== 'before') && ($cardinalPointsPosition !== 'after')) {
            return $showErrors ? 'Wrong cardinal points position: must be before or after (given: ' . htmlspecialchars($cardinalPointsPosition) . ')' : '';
        }

        if (!in_array($outputFormat, $this->allowedOutputFormats)) {
            return $showErrors ? 'Wrong output format (given: ' . htmlspecialchars($outputFormat) . ', allowed: ' . implode(', ', $this->allowedOutputFormats) . ')' : '';
        }

        $functionCall = 'get' . ucfirst($outputFormat) . 'Notation';

        return $this->$functionCall($latitude, $longitude, $cardinalPointsArray, $cardinalPointsPosition, $delimiter);
    }



    /**
     * Get the decimal notation
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $cardinalPoints
     * @param array $cardinalPointsPosition not needed
     * @param string $delimiter
     * @return string
     */
    protected function getDegreeNotation($latitude, $longitude, $cardinalPoints, $cardinalPointsPosition, $delimiter) {
        return $this->getFormattedLatitudeLongitude(
            abs($latitude),
            abs($longitude),
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
     * @param string $delimiter
     * @return string
     */
    protected function getDegreeMinutesNotation($latitude, $longitude, $cardinalPoints, $cardinalPointsPosition, $delimiter) {
        $latitudeDegrees = abs((int) $latitude);
        $latitudeMinutes = abs(($latitude - (int) $latitude) * 60);

        $longitudeDegrees = abs((int) $longitude);
        $longitudeMinutes = abs(($longitude - (int) $longitude) * 60);

        return $this->getFormattedLatitudeLongitude(
            $latitudeDegrees . '°' . number_format($latitudeMinutes, 3) . '\'',
            $longitudeDegrees . '°' . number_format($longitudeMinutes, 3) . '\'',
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
     * @param string $delimiter
     * @return string
     */
    protected function getDegreeMinutesSecondsNotation($latitude, $longitude, $cardinalPoints, $cardinalPointsPosition, $delimiter) {
        $latitudeDegrees = abs((int) $latitude);
        $latitudeMinutes = abs(($latitude - (int) $latitude) * 60);
        $latitudeSeconds = abs(($latitudeMinutes - (int) $latitudeMinutes) * 60);
        $latitudeMinutes = (int) $latitudeMinutes;

        $longitudeDegrees = abs((int) $longitude);
        $longitudeMinutes = abs(($longitude - (int) $longitude) * 60);
        $longitudeSeconds = abs(($longitudeMinutes - (int) $longitudeMinutes) * 60);
        $longitudeMinutes = (int) $longitudeMinutes;

        return $this->getFormattedLatitudeLongitude(
            $latitudeDegrees . '° ' . $latitudeMinutes . '\' ' . number_format($latitudeSeconds, 2) . '"',
            $longitudeDegrees . '° ' . $longitudeMinutes . '\' ' . number_format($longitudeSeconds, 2) . '"',
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
     * @param string $delimiter not needed
     * @return string
     */
    protected function getUTMNotation($latitude, $longitude, $cardinalPoints, $cardinalPointsPosition, $delimiter) {
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
            return htmlspecialchars($north);
        }

        return htmlspecialchars($south);
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
            return htmlspecialchars($east);
        }

        return htmlspecialchars($west);
    }
}