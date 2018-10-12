<?php

namespace Byterror\BytCoordconverter\ViewHelpers;

/**
 * This file is part of the "byt_coordconverter" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Byterror\BytCoordconverter\Utility\UtmUtility;
use Byterror\BytCoordconverter\Domain\Model\CoordinateConverterParameter as Parameter;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;


class CoordinateConverterViewHelper extends AbstractViewHelper
{
    /** @var Parameter */
    private $parameter;


    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('latitude', 'string', 'The latitude to be converted', true);
        $this->registerArgument('longitude', 'string', 'The longitude to be converted', true);
        $this->registerArgument('outputFormat', 'string', 'The format of the coordinates for the output', false,
            'degree');
        $this->registerArgument('cardinalPoints', 'string', 'The naming of the cardinal points', false, 'N|S|E|W');
        $this->registerArgument('cardinalPointsPosition', 'string', 'The position of the cardinal points', false,
            'before');
        $this->registerArgument('numberOfDecimals', 'int', 'The number of decimals to be shown', false, 5);
        $this->registerArgument('removeTrailingZeros', 'bool', 'Should trailing zeros be removed', false, false);
        $this->registerArgument('delimiter', 'string', 'The delimiter of the coordinates', false, ', ');
        $this->registerArgument('showErrors', 'bool', 'Show errors in frontend, useful for debugging', false, false);
    }

    public function render()
    {
        try {
            $this->parameter = new Parameter(
                $this->arguments['latitude'],
                $this->arguments['longitude'],
                $this->arguments['outputFormat'],
                $this->arguments['cardinalPoints'],
                $this->arguments['cardinalPointsPosition'],
                $this->arguments['numberOfDecimals'],
                $this->arguments['removeTrailingZeros'],
                $this->arguments['delimiter']
            );
        } catch (\InvalidArgumentException $e) {
            if ($this->arguments['showErrors']) {
                return $e->getMessage();
            }

            return '';
        }

        $functionCall = 'get' . ucfirst($this->parameter->getOutputFormat()) . 'Notation';

        return htmlspecialchars(
            $this->$functionCall()
        );
    }

    protected function getDegreeNotation()
    {
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

        $newLatitude .= '°';
        $newLongitude .= '°';

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
    protected function getDegreeMinutesNotation()
    {
        $latitudeDegrees = abs((int)$this->parameter->getLatitude());
        $latitudeMinutes = number_format(
            abs(($this->parameter->getLatitude() - (int)$this->parameter->getLatitude()) * 60),
            $this->parameter->getNumberOfDecimals()
        );

        $longitudeDegrees = abs((int)$this->parameter->getLongitude());
        $longitudeMinutes = number_format(
            abs(($this->parameter->getLongitude() - (int)$this->parameter->getLongitude()) * 60),
            $this->parameter->getNumberOfDecimals()
        );

        if ($this->parameter->shouldTrailingZerosBeRemoved()) {
            $latitudeMinutes = rtrim($latitudeMinutes, '0.');
            $longitudeMinutes = rtrim($longitudeMinutes, '0.');
        }

        $newLatitude = $latitudeDegrees . '°';
        $newLongitude = $longitudeDegrees . '°';

        if ($latitudeMinutes) {
            $newLatitude .= ' ' . $latitudeMinutes . '\'';
        }

        if ($longitudeMinutes) {
            $newLongitude .= ' ' . $longitudeMinutes . '\'';
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
    protected function getDegreeMinutesSecondsNotation()
    {
        $latitudeDegrees = abs((int)$this->parameter->getLatitude());
        $latitudeMinutes = abs(($this->parameter->getLatitude() - (int)$this->parameter->getLatitude()) * 60);
        $latitudeSeconds = number_format(
            abs(($latitudeMinutes - (int)$latitudeMinutes) * 60),
            $this->parameter->getNumberOfDecimals()
        );
        $latitudeMinutes = (int)$latitudeMinutes;

        $longitudeDegrees = abs((int)$this->parameter->getLongitude());
        $longitudeMinutes = abs(($this->parameter->getLongitude() - (int)$this->parameter->getLongitude()) * 60);
        $longitudeSeconds = number_format(
            abs(($longitudeMinutes - (int)$longitudeMinutes) * 60),
            $this->parameter->getNumberOfDecimals()
        );
        $longitudeMinutes = (int)$longitudeMinutes;

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


    protected function getUTMNotation()
    {
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
    protected function getFormattedLatitudeLongitude(
        $latitude,
        $longitude,
        $northOrSouth,
        $eastOrWest,
        $cardinalPointPosition,
        $delimiter
    ) {
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