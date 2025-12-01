<?php

declare(strict_types=1);

/*
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\BytCoordconverter\ViewHelpers;

use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter as Parameter;
use Brotkrueml\BytCoordconverter\Formatter\FormatterInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

class CoordinateConverterViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        parent::initializeArguments();

        $this->registerArgument(
            'latitude',
            'string',
            'The latitude to be converted (in decimal notation)',
            true,
        );
        $this->registerArgument(
            'longitude',
            'string',
            'The longitude to be converted (in decimal notation)',
            true,
        );
        $this->registerArgument(
            'outputFormat',
            'string',
            'The format of the coordinates for the output (possible values: degree, degreeMinutes, degreeMinutesSeconds, UTM',
            false,
            'degree',
        );
        $this->registerArgument(
            'cardinalPoints',
            'string',
            'The naming of the cardinal points (North, South, East, West) separated by | character',
            false,
            'N|S|E|W',
        );
        $this->registerArgument(
            'cardinalPointsPosition',
            'string',
            'The position of the cardinal points (possible values: before, after)',
            false,
            'before',
        );
        $this->registerArgument(
            'numberOfDecimals',
            'int',
            'The number of decimals to be shown',
            false,
            5,
        );
        $this->registerArgument(
            'removeTrailingZeros',
            'bool',
            'Should trailing zeros be removed',
            false,
            false,
        );
        $this->registerArgument(
            'delimiter',
            'string',
            'The delimiter of the coordinates',
            false,
            ', ',
        );
    }

    public function render(): string
    {
        /**
         * @var array{
         *     latitude: string,
         *     longitude: string,
         *     outputFormat?: 'degree'|'degreeMinutes'|'degreeMinutesSeconds'|'UTM',
         *     cardinalPoints?: string,
         *     cardinalPointsPosition?: 'before'|'after',
         *     numberOfDecimals?: positive-int,
         *     removeTrailingZeros?: bool,
         *     delimiter?: string
         * } $arguments
         */
        $arguments = $this->arguments;

        try {
            $parameter = new Parameter(
                (float) $arguments['latitude'],
                (float) $arguments['longitude'],
                $arguments['outputFormat'] ?? 'degree',
                $arguments['cardinalPoints'] ?? 'N|S|E|W',
                $arguments['cardinalPointsPosition'] ?? 'before',
                (int) ($arguments['numberOfDecimals'] ?? 5),
                (bool) ($arguments['removeTrailingZeros'] ?? false),
                $arguments['delimiter'] ?? ', ',
            );
        } catch (\InvalidArgumentException $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        $className = \sprintf(
            'Brotkrueml\BytCoordconverter\Formatter\%sFormatter',
            \ucfirst($parameter->getOutputFormat()),
        );

        /** @var FormatterInterface $formatter */
        $formatter = new $className();

        return $formatter->format($parameter);
    }
}
