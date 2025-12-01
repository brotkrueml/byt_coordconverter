<?php

declare(strict_types=1);

/*
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\BytCoordconverter\Tests\Unit\Formatter;

use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter;
use Brotkrueml\BytCoordconverter\Formatter\DegreeMinutesFormatter;
use PHPUnit\Framework\TestCase;

final class DegreeMinutesFormatterTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function formatConvertsGivenCoordinatesCorrectly(array $arguments, string $expected): void
    {
        $subject = new DegreeMinutesFormatter();
        $parameter = new CoordinateConverterParameter(...\array_values($arguments));

        self::assertSame($expected, $subject->format($parameter));
    }

    public function dataProvider(): \Generator
    {
        yield 'uses default values' => [
            [
                'latitude' => 49.487111,
                'longitude' => 8.466278,
                'outputFormat' => 'degreeMinutes',
            ],
            'N 49° 29.22666\', E 8° 27.97668\'',
        ];

        yield 'uses numberOfDecimals correctly' => [
            [
                'latitude' => 49.487111,
                'longitude' => 8.466278,
                'outputFormat' => 'degreeMinutes',
                'cardinalPoints' => 'N|S|E|W',
                'cardinalPointsPosition' => 'before',
                'numberOfDecimals' => 3,
            ],
            'N 49° 29.227\', E 8° 27.977\'',
        ];

        yield 'uses removeTrailingZeros correctly' => [
            [
                'latitude' => 49.487,
                'longitude' => 8.466,
                'outputFormat' => 'degreeMinutes',
                'cardinalPoints' => 'N|S|E|W',
                'cardinalPointsPosition' => 'before',
                'numberOfDecimals' => 5,
                'removeTrailingZeros' => true,
            ],
            'N 49° 29.22\', E 8° 27.96\'',
        ];

        yield 'uses removeTrailingZeros and avoiding dot at the end correctly' => [
            [
                'latitude' => 49.4833333333,
                'longitude' => 8.45,
                'outputFormat' => 'degreeMinutes',
                'cardinalPoints' => 'N|S|E|W',
                'cardinalPointsPosition' => 'before',
                'numberOfDecimals' => 5,
                'removeTrailingZeros' => true,
            ],
            'N 49° 29\', E 8° 27\'',
        ];

        yield 'uses removeTrailingZeros and avoiding degree at the end correctly' => [
            [
                'latitude' => 49.0,
                'longitude' => 8.0,
                'outputFormat' => 'degreeMinutes',
                'cardinalPoints' => 'N|S|E|W',
                'cardinalPointsPosition' => 'before',
                'numberOfDecimals' => 5,
                'removeTrailingZeros' => true,
            ],
            'N 49°, E 8°',
        ];
    }
}
