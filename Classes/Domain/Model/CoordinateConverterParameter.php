<?php
namespace Byterror\BytCoordconverter\Domain\Model;

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


/**
 * Parameter representing the parameters given to the view helper
 *
 * @author Chris Müller <byt3error@web.de>
 * @package Byt_coordconverter
 */
class CoordinateConverterParameter {
    /**
     * @var array
     */
    private $allowedOutputFormats = array(
        'degree',
        'degreeMinutes',
        'degreeMinutesSeconds',
        'UTM',
    );

    private $allowedCardinalPointsPositions = array(
        'after',
        'before',
    );

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var string
     */
    private $outputFormat;

    /**
     * @var array
     */
    private $cardinalPointsList;

    /**
     * @var string
     */
    private $cardinalPointsPosition;

    /**
     * @var int
     */
    private $numberOfDecimals;

    /**
     * @var bool
     */
    private $removeTrailingZeros;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @param string $latitude
     * @param string $longitude
     * @param string $outputFormat
     * @param string $cardinalPoints
     * @param string $cardinalPointsPosition
     * @param string|int $numberOfDecimals
     * @param string|bool $removeTrailingZeros
     * @param string $delimiter
     * @throws \InvalidArgumentException
     */
    public function __construct($latitude, $longitude, $outputFormat, $cardinalPoints, $cardinalPointsPosition, $numberOfDecimals, $removeTrailingZeros, $delimiter) {
        $this
            ->setLatitude($latitude)
            ->setLongitude($longitude)
            ->setOutputFormat($outputFormat)
            ->setCardinalPoints($cardinalPoints)
            ->setCardinalPointsPosition($cardinalPointsPosition)
            ->setNumberOfDecimals($numberOfDecimals)
            ->setRemoveTrailingZeros($removeTrailingZeros)
            ->setDelimiter($delimiter);
    }

    /**
     * @param string $latitude
     * @return CoordinateConverterParameter
     * @throws \InvalidArgumentException
     */
    protected function setLatitude($latitude) {
        $this->latitude = (float)$latitude;

        if (($this->latitude > 90.0) || ($this->latitude < -90.0)) {
            throw new \InvalidArgumentException(
                'Invalid latitude: must be a value between 90.0 and -90.0 (given: ' . htmlspecialchars($this->latitude) . ')'
            );
        }

        return $this;
    }

    /**
     * @param string $longitude
     * @return CoordinateConverterParameter
     * @throws \InvalidArgumentException
     */
    private function setLongitude($longitude) {
        $this->longitude = (float)$longitude;

        if (($this->longitude > 180.0) || ($this->longitude < -180.0)) {
            throw new \InvalidArgumentException(
                'Invalid longitude: must be a value between 180.0 and -180.0 (given: ' . htmlspecialchars($this->longitude) . ')'
            );
        }

        return $this;
    }

    /**
     * @param string $outputFormat
     * @return CoordinateConverterParameter
     * @throws \InvalidArgumentException
     */
    private function setOutputFormat($outputFormat) {
        $this->outputFormat = $outputFormat;

        if (!in_array($this->outputFormat, $this->allowedOutputFormats)) {
            throw new \InvalidArgumentException(
                'Invalid output format: must be one of [' . implode('|', $this->allowedOutputFormats) . '] (given: ' . htmlspecialchars($this->longitude) . ')'
            );
        }

        return $this;
    }

    /**
     * @param string $cardinalPoints
     * @return CoordinateConverterParameter
     * @throws \InvalidArgumentException
     */
    private function setCardinalPoints($cardinalPoints) {
        $this->cardinalPointsList = explode('|', $cardinalPoints);

        if (count($this->cardinalPointsList) !== 4) {
            throw new \InvalidArgumentException(
                'Invalid number of parameters for cardinal points: must be 4 (separated by |, given: ' . htmlspecialchars($cardinalPoints) . ')'
            );
        }

        return $this;
    }

    /**
     * @param string $cardinalPointsPosition
     * @return CoordinateConverterParameter
     * @throws \InvalidArgumentException
     */
    private function setCardinalPointsPosition($cardinalPointsPosition) {
        $this->cardinalPointsPosition = $cardinalPointsPosition;

        if (!in_array($this->cardinalPointsPosition, $this->allowedCardinalPointsPositions)) {
            throw new \InvalidArgumentException(
                'Invalid cardinal points position: must be one of [' . implode('|', $this->allowedCardinalPointsPositions) . '] (given: ' . htmlspecialchars($cardinalPointsPosition) . ')'
            );
        }

        return $this;
    }

    /**
     * @param string|int $numberOfDecimals
     * @return CoordinateConverterParameter
     * @throws \InvalidArgumentException
     */
    private function setNumberOfDecimals($numberOfDecimals) {
        $this->numberOfDecimals = (int)$numberOfDecimals;

        if ($numberOfDecimals < 0) {
            throw new \InvalidArgumentException(
                'The number of decimals cannot be negative'
            );
        }

        return $this;
    }

    /**
     * @param string|bool $removeTrailingZeros
     * @return CoordinateConverterParameter
     */
    private function setRemoveTrailingZeros($removeTrailingZeros) {
        $this->removeTrailingZeros = (bool)$removeTrailingZeros;

        return $this;
    }

    /**
     * @param string $delimiter
     * @return CoordinateConverterParameter
     */
    private function setDelimiter($delimiter) {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getOutputFormat() {
        return $this->outputFormat;
    }

    /**
     * @return string
     */
    public function getCardinalPointNameForNorth() {
        return $this->cardinalPointsList[0];
    }

    /**
     * @return string
     */
    public function getCardinalPointForLatitude() {
        if ($this->latitude >= 0.0) {
            return $this->cardinalPointsList[0];
        }

        return $this->cardinalPointsList[1];
    }


    /**
     * @return string
     */
    public function getCardinalPointForLongitude() {
        if ($this->longitude >= 0.0) {
            return $this->cardinalPointsList[2];
        }

        return $this->cardinalPointsList[3];
    }

    /**
     * @return string
     */
    public function getCardinalPointsPosition() {
        return $this->cardinalPointsPosition;
    }

    /**
     * @return int
     */
    public function getNumberOfDecimals() {
        return $this->numberOfDecimals;
    }

    /**
     * @return bool
     */
    public function shouldTrailingZerosBeRemoved() {
        return $this->removeTrailingZeros;
    }

    /**
     * @return string
     */
    public function getDelimiter() {
        return $this->delimiter;
    }
}