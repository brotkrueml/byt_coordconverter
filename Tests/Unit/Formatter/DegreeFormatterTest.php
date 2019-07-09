<?php
declare(strict_types = 1);

namespace Brotkrueml\BytCoordconverter\Tests\Unit\Formatter;

/**
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter;
use Brotkrueml\BytCoordconverter\Formatter\DegreeFormatter;
use PHPUnit\Framework\TestCase;

class DegreeFormatterTest extends TestCase
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
        $formatter = new DegreeFormatter();
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
                    'outputFormat' => 'degree',
                ],
                'N 49.48711°, E 8.46628°'
            ],
            'uses non-default numberOfDecimals correctly' => [
                [
                    'latitude' => 49.487111,
                    'longitude' => 8.466278,
                    'outputFormat' => 'degree',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 3,
                ],
                'N 49.487°, E 8.466°'
            ],
            'uses non-default removeTrailingZeros correctly' => [
                [
                    'latitude' => 49.487000,
                    'longitude' => 8.466201,
                    'outputFormat' => 'degree',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 5,
                    'removeTrailingZeros' => true,
                ],
                'N 49.487°, E 8.4662°'
            ],
            'uses non-default removeTrailingZeros and avoiding dot at the end correctly' => [
                [
                    'latitude' => 49.0,
                    'longitude' => 8.0,
                    'outputFormat' => 'degree',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 5,
                    'removeTrailingZeros' => true,
                ],
                'N 49°, E 8°'
            ],
            'uses delimiter correctly' => [
                [
                    'latitude' => 49.487111,
                    'longitude' => 8.466278,
                    'outputFormat' => 'degree',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before',
                    'numberOfDecimals' => 5,
                    'removeTrailingZeros' => false,
                    'delimiter' => ' / ',
                ],
                'N 49.48711° / E 8.46628°'
            ],
            'uses cardinal points north and east correctly' => [
                [
                    'latitude' => 49.487111,
                    'longitude' => 8.466278,
                    'outputFormat' => 'degree',
                    'cardinalPoints' => 'North|South|East|West'
                ],
                'North 49.48711°, East 8.46628°'
            ],
            'uses cardinal points south and west correctly' => [
                [
                    'latitude' => -53.163494,
                    'longitude' => -70.905071,
                    'outputFormat' => 'degree',
                    'cardinalPoints' => 'North|South|East|West'
                ],
                'South 53.16349°, West 70.90507°'
            ],
            'uses cardinal points position set to before correctly' => [
                [
                    'latitude' => 49.487111,
                    'longitude' => 8.466278,
                    'outputFormat' => 'degree',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'before'
                ],
                'N 49.48711°, E 8.46628°'
            ],
            'uses cardinal points position set to after correctly' => [
                [
                    'latitude' => 49.487111,
                    'longitude' => 8.466278,
                    'outputFormat' => 'degree',
                    'cardinalPoints' => 'N|S|E|W',
                    'cardinalPointsPosition' => 'after'
                ],
                '49.48711° N, 8.46628° E'
            ],
        ];
    }
}
