<?php

namespace Brotkrueml\BytCoordconverter\ViewHelpers;

/**
 * This file is part of the "byt_coordconverter" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Brotkrueml\BytCoordconverter\Utility\UtmUtility;
use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter as Parameter;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper;

class CoordinateConverterViewHelper extends ViewHelper\AbstractViewHelper
{
    /** @var Parameter */
    private static $parameter;


    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument(
            'latitude',
            'string',
            'The latitude to be converted (in decimal notation)',
            true
        );
        $this->registerArgument(
            'longitude',
            'string',
            'The longitude to be converted (in decimal notation)',
            true
        );
        $this->registerArgument(
            'outputFormat',
            'string',
            'The format of the coordinates for the output (possible values: degree, degreeMinutes, degreeMinutesSeconds, UTM',
            false,
            'degree'
        );
        $this->registerArgument(
            'cardinalPoints',
            'string',
            'The naming of the cardinal points (North, South, East, West) separated by | character',
            false,
            'N|S|E|W'
        );
        $this->registerArgument(
            'cardinalPointsPosition',
            'string',
            'The position of the cardinal points (possible values: before, after)',
            false,
            'before'
        );
        $this->registerArgument(
            'numberOfDecimals',
            'int',
            'The number of decimals to be shown',
            false,
            5
        );
        $this->registerArgument(
            'removeTrailingZeros',
            'bool',
            'Should trailing zeros be removed',
            false,
            false
        );
        $this->registerArgument(
            'delimiter',
            'string',
            'The delimiter of the coordinates',
            false,
            ', '
        );
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        try {
            static::$parameter = new Parameter(
                (float)$arguments['latitude'],
                (float)$arguments['longitude'],
                $arguments['outputFormat'] ?? 'degree',
                $arguments['cardinalPoints'] ?? 'N|S|E|W',
                $arguments['cardinalPointsPosition'] ?? 'before',
                $arguments['numberOfDecimals'] ?? 5,
                (bool)($arguments['removeTrailingZeros'] ?? false),
                $arguments['delimiter'] ?? ', '
            );
        } catch (\InvalidArgumentException $e) {
            throw new ViewHelper\Exception($e->getMessage(), $e->getCode(), $e);
        }

        $functionCall = 'get' . ucfirst(static::$parameter->getOutputFormat()) . 'Notation';

        return static::$functionCall();
    }

    protected static function getDegreeNotation(): string
    {
        $newLatitude = number_format(
            abs(static::$parameter->getLatitude()),
            static::$parameter->getNumberOfDecimals()
        );
        $newLongitude = number_format(
            abs(static::$parameter->getLongitude()),
            static::$parameter->getNumberOfDecimals()
        );

        if (static::$parameter->shouldTrailingZerosBeRemoved()) {
            $newLatitude = rtrim($newLatitude, '0.');
            $newLongitude = rtrim($newLongitude, '0.');
        }

        $newLatitude .= '°';
        $newLongitude .= '°';

        return static::getFormattedLatitudeLongitude(
            $newLatitude,
            $newLongitude,
            static::$parameter->getCardinalPointForLatitude(),
            static::$parameter->getCardinalPointForLongitude(),
            static::$parameter->getCardinalPointsPosition(),
            static::$parameter->getDelimiter()
        );
    }

    protected static function getDegreeMinutesNotation(): string
    {
        $latitudeDegrees = abs((int)static::$parameter->getLatitude());
        $latitudeMinutes = number_format(
            abs((static::$parameter->getLatitude() - (int)static::$parameter->getLatitude()) * 60),
            static::$parameter->getNumberOfDecimals()
        );

        $longitudeDegrees = abs((int)static::$parameter->getLongitude());
        $longitudeMinutes = number_format(
            abs((static::$parameter->getLongitude() - (int)static::$parameter->getLongitude()) * 60),
            static::$parameter->getNumberOfDecimals()
        );

        if (static::$parameter->shouldTrailingZerosBeRemoved()) {
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

        return static::getFormattedLatitudeLongitude(
            $newLatitude,
            $newLongitude,
            static::$parameter->getCardinalPointForLatitude(),
            static::$parameter->getCardinalPointForLongitude(),
            static::$parameter->getCardinalPointsPosition(),
            static::$parameter->getDelimiter()
        );
    }

    protected static function getDegreeMinutesSecondsNotation(): string
    {
        $latitudeDegrees = abs((int)static::$parameter->getLatitude());
        $latitudeMinutes = abs((static::$parameter->getLatitude() - (int)static::$parameter->getLatitude()) * 60);
        $latitudeSeconds = number_format(
            abs(($latitudeMinutes - (int)$latitudeMinutes) * 60),
            static::$parameter->getNumberOfDecimals()
        );
        $latitudeMinutes = (int)$latitudeMinutes;

        $longitudeDegrees = abs((int)static::$parameter->getLongitude());
        $longitudeMinutes = abs((static::$parameter->getLongitude() - (int)static::$parameter->getLongitude()) * 60);
        $longitudeSeconds = number_format(
            abs(($longitudeMinutes - (int)$longitudeMinutes) * 60),
            static::$parameter->getNumberOfDecimals()
        );
        $longitudeMinutes = (int)$longitudeMinutes;

        $newLatitude = $latitudeDegrees . '°';
        $newLongitude = $longitudeDegrees . '°';

        if (static::$parameter->shouldTrailingZerosBeRemoved()) {
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

        return static::getFormattedLatitudeLongitude(
            $newLatitude,
            $newLongitude,
            static::$parameter->getCardinalPointForLatitude(),
            static::$parameter->getCardinalPointForLongitude(),
            static::$parameter->getCardinalPointsPosition(),
            static::$parameter->getDelimiter()
        );
    }

    protected static function getUTMNotation(): string
    {
        return UtmUtility::getUtmFromLatitudeLongitude(
            static::$parameter->getLatitude(),
            static::$parameter->getLongitude()
        );
    }

    protected static function getFormattedLatitudeLongitude(
        string $latitude,
        string $longitude,
        string $northOrSouth,
        string $eastOrWest,
        string $cardinalPointPosition,
        string $delimiter
    ): string {
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