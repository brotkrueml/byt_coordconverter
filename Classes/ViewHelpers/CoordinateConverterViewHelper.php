<?php

namespace Brotkrueml\BytCoordconverter\ViewHelpers;

/**
 * This file is part of the "byt_coordconverter" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter as Parameter;
use Brotkrueml\BytCoordconverter\Formatter\FormatterInterface;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper;

class CoordinateConverterViewHelper extends ViewHelper\AbstractViewHelper
{
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
            $parameter = new Parameter(
                (float)$arguments['latitude'],
                (float)$arguments['longitude'],
                $arguments['outputFormat'] ?? 'degree',
                $arguments['cardinalPoints'] ?? 'N|S|E|W',
                $arguments['cardinalPointsPosition'] ?? 'before',
                (int)($arguments['numberOfDecimals'] ?? 5),
                (bool)($arguments['removeTrailingZeros'] ?? false),
                $arguments['delimiter'] ?? ', '
            );
        } catch (\InvalidArgumentException $e) {
            throw new ViewHelper\Exception($e->getMessage(), $e->getCode(), $e);
        }

        $className = 'Brotkrueml\\BytCoordconverter\\Formatter\\' . ucfirst($parameter->getOutputFormat()) . 'Formatter';

        /** @var FormatterInterface $formatter */
        $formatter = new $className();

        return $formatter->format($parameter);
    }
}
