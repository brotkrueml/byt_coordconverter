<?php
declare(strict_types=1);

namespace Brotkrueml\BytCoordconverter\Tests\Unit\Formatter;

/**
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter;
use Brotkrueml\BytCoordconverter\Formatter\DegreeMinutesFormatter;
use PHPUnit\Framework\TestCase;

class DegreeMinutesFormatterTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param array $arguments
     * @param string $expected
     */
    public function formatConvertsGivenCoordinatesCorrectly(array $arguments, string $expected)
    {
        $subject = new DegreeMinutesFormatter();
        $parameter = new CoordinateConverterParameter(...array_values($arguments));

        $this->assertSame($expected, $subject->format($parameter));
    }

    public function dataProvider(): array
    {
        return [
            'uses default values' => [
                [
                    'latitude' => 49.487111,
                    'longitude' => 8.466278,
                    'outputFormat' => 'degreeMinutes',
                ],
                'N 49° 29.22666\', E 8° 27.97668\''
            ],
            'uses numberOfDecimals correctly' => [
                [
                    'latitude' => 49.487111,
                    'longitude' => 8.466278,
                    'outputFormat' => 'degreeMinutes',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 3,
                ],
                'N 49° 29.227\', E 8° 27.977\''
            ],
            'uses removeTrailingZeros correctly' => [
                [
                    'latitude' => 49.487,
                    'longitude' => 8.466,
                    'outputFormat' => 'degreeMinutes',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 5,
                    'removeTrailingZeros' => true,
                ],
                'N 49° 29.22\', E 8° 27.96\''
            ],
            'uses removeTrailingZeros and avoiding dot at the end correctly' => [
                [
                    'latitude' => 49.4833333333,
                    'longitude' => 8.45,
                    'outputFormat' => 'degreeMinutes',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 5,
                    'removeTrailingZeros' => true,
                ],
                'N 49° 29\', E 8° 27\''
            ],
            'uses removeTrailingZeros and avoiding degree at the end correctly' => [
                [
                    'latitude' => 49.0,
                    'longitude' => 8.0,
                    'outputFormat' => 'degreeMinutes',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 5,
                    'removeTrailingZeros' => true,
                ],
                'N 49°, E 8°'
            ],
        ];
    }
}
