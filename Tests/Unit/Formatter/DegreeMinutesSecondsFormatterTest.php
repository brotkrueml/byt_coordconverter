<?php
declare(strict_types=1);

namespace Brotkrueml\BytCoordconverter\Tests\Unit\Formatter;

use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter;
use Brotkrueml\BytCoordconverter\Formatter\DegreeMinutesSecondsFormatter;
use PHPUnit\Framework\TestCase;

/**
 * This file is part of the "byt_coordconverter" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with non-default this source code.
 */
class DegreeMinutesSecondsFormatterTest extends TestCase
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
        $formatter = new DegreeMinutesSecondsFormatter();
        $parameter = new CoordinateConverterParameter(...array_values($arguments));

        $this->assertSame($expected, $formatter->format($parameter));
    }

    public function dataProvider(): array
    {
        return [
            'uses default values' => [
                [
                    'latitude' => 49.487111,
                    'longitude' => 8.466278,
                    'outputFormat' => 'degreeMinutesSeconds',
                ],
                'N 49° 29\' 13.59960", E 8° 27\' 58.60080"'
            ],
            'uses numberOfDecimals correctly' => [
                [
                    'latitude' => 49.487111,
                    'longitude' => 8.466278,
                    'outputFormat' => 'degreeMinutesSeconds',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 1,
                ],
                'N 49° 29\' 13.6", E 8° 27\' 58.6"'
            ],
            'uses removeTrailingZeros correctly' => [
                [
                    'latitude' => 49.0,
                    'longitude' => 8.0,
                    'outputFormat' => 'degreeMinutesSeconds',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 5,
                    'removeTrailingZeros' => true,
                ],
                'N 49°, E 8°'
            ],
            'uses removeTrailingZeros and avoiding dot at the end correctly' => [
                [
                    'latitude' => 49.486944,
                    'longitude' => 8.466111,
                    'outputFormat' => 'degreeMinutesSeconds',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 2,
                    'removeTrailingZeros' => true,
                ],
                'N 49° 29\' 13", E 8° 27\' 58"'
            ],
            'uses removeTrailingZeros and avoiding empty seconds correctly' => [
                [
                    'latitude' => 49.48333334,
                    'longitude' => 8.450001,
                    'outputFormat' => 'degreeMinutesSeconds',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 2,
                    'removeTrailingZeros' => true,
                ],
                'N 49° 29\', E 8° 27\''
            ],
            'uses removeTrailingZeros and avoiding empty minutes and seconds correctly' => [
                [
                    'latitude' => 49.0,
                    'longitude' => 8.0,
                    'outputFormat' => 'degreeMinutesSeconds',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 2,
                    'removeTrailingZeros' => true,
                ],
                'N 49°, E 8°'
            ],
            'uses removeTrailingZeros and zero minutes correctly' => [
                [
                    'latitude' => 49.003778,
                    'longitude' => 8.016278,
                    'outputFormat' => 'degreeMinutesSeconds',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 2,
                    'removeTrailingZeros' => true,
                ],
                'N 49° 0\' 13.6", E 8° 0\' 58.6"'
            ],
        ];
    }
}