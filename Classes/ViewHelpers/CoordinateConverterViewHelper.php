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
     * @param string $delimiter
     * @param boolean $showErrors
     * @return string
     */
    public function render($latitude, $longitude, $outputFormat = 'degree', $cardinalPoints = 'N|S|E|W', $delimiter = ', ', $showErrors = FALSE) {
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

        if (!in_array($outputFormat, $this->allowedOutputFormats)) {
            return $showErrors ? 'Wrong output format (given: ' . htmlspecialchars($outputFormat) . ', allowed: ' . implode(', ', $this->allowedOutputFormats) . ')' : '';
        }

        $functionCall = 'get' . ucfirst($outputFormat) . 'Notation';

        return $this->$functionCall($latitude, $longitude, $cardinalPointsArray, $delimiter);
    }



    /**
     * Get the decimal notation
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $cardinalPoints
     * @param string $delimiter
     * @return string
     */
    protected function getDegreeNotation($latitude, $longitude, $cardinalPoints, $delimiter) {
        $content  = $this->getCardinalPointForLatitude($latitude, $cardinalPoints[0], $cardinalPoints[1]);
        $content .= abs($latitude);

        $content .= htmlspecialchars($delimiter);

        $content .= $this->getCardinalPointForLongitude($longitude, $cardinalPoints[2], $cardinalPoints[3]);
        $content .= abs($longitude);

        return $content;
    }



    /**
     * Get the degree with minutes notation
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $cardinalPoints
     * @param string $delimiter
     * @return string
     */
    protected function getDegreeMinutesNotation($latitude, $longitude, $cardinalPoints, $delimiter) {
        $newLatitudeDegrees = abs((int) $latitude);
        $newLatitudeMinutes = abs(($latitude - (int) $latitude) * 60);

        $newLongitudeDegrees = abs((int) $longitude);
        $newLongitudeMinutes = abs(($longitude - (int) $longitude) * 60);

        $content  = $this->getCardinalPointForLatitude($latitude, $cardinalPoints[0], $cardinalPoints[1]);
        $content .= $newLatitudeDegrees . '°' . number_format($newLatitudeMinutes, 3) . '\'';

        $content .= htmlspecialchars($delimiter);

        $content .= $this->getCardinalPointForLongitude($latitude, $cardinalPoints[2], $cardinalPoints[3]);
        $content .= $newLongitudeDegrees . '°' . number_format($newLongitudeMinutes, 3) . '\'';

        return $content;
    }



    /**
     * Get the degree with minutes and seconds notation
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $cardinalPoints
     * @param string $delimiter
     * @return string
     */
    protected function getDegreeMinutesSecondsNotation($latitude, $longitude, $cardinalPoints, $delimiter) {
        $newLatitudeDegrees = abs((int) $latitude);
        $newLatitudeMinutes = abs(($latitude - (int) $latitude) * 60);
        $newLatitudeSeconds = abs(($newLatitudeMinutes - (int) $newLatitudeMinutes) * 60);
        $newLatitudeMinutes = (int) $newLatitudeMinutes;

        $newLongitudeDegrees = abs((int) $longitude);
        $newLongitudeMinutes = abs(($longitude - (int) $longitude) * 60);
        $newLongitudeSeconds = abs(($newLongitudeMinutes - (int) $newLongitudeMinutes) * 60);
        $newLongitudeMinutes = (int) $newLongitudeMinutes;

        $content  = $this->getCardinalPointForLatitude($latitude, $cardinalPoints[0], $cardinalPoints[1]);
        $content .= $newLatitudeDegrees . '° ' . $newLatitudeMinutes . '\' ' . number_format($newLatitudeSeconds, 2) . '"';

        $content .= htmlspecialchars($delimiter);

        $content .= $this->getCardinalPointForLongitude($latitude, $cardinalPoints[2], $cardinalPoints[3]);
        $content .= $newLongitudeDegrees . '° ' . $newLongitudeMinutes . '\' ' . number_format($newLongitudeSeconds, 2) . '"';

        return $content;
    }



    /**
     * Get the UTM notation
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $cardinalPoints not needed
     * @param string $delimiter not needed
     * @return string
     */
    protected function getUTMNotation($latitude, $longitude, $cardinalPoints, $delimiter) {
        return UtmUtility::getUtmFromLatitudeLongitude($latitude, $longitude);
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
            return htmlspecialchars($north) . ' ';
        }

        return htmlspecialchars($south) . ' ';
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
            return htmlspecialchars($east) . ' ';
        }

        return htmlspecialchars($west) . ' ';
    }
}