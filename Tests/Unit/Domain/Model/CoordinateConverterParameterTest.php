<?php
declare(strict_types=1);

namespace Brotkrueml\BytCoordconverter\Tests\Unit\Domain\Model;

use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter as Parameter;
use PHPUnit\Framework\TestCase;

/**
 * This file is part of the "byt_coordconverter" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
class CoordinateConverterParameterTest extends TestCase
{
    /**
     * @test
     */
    public function parameterLatitudeSetCorrectly()
    {
        $parameter = new Parameter(
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ', '
        );

        $this->assertSame(49.487111, $parameter->getLatitude());
    }

    /**
     * @test
     */
    public function parameterLongitudeSetCorrectly()
    {
        $parameter = new Parameter(
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ', '
        );

        $this->assertSame(8.466278, $parameter->getLongitude());
    }

    /**
     * @test
     */
    public function parameterOutputFormatSetCorrectly()
    {
        $allowedOutputFormats = [
            'degree',
            'degreeMinutes',
            'degreeMinutesSeconds',
            'UTM',
        ];

        foreach ($allowedOutputFormats as $outputFormat) {
            $parameter = new Parameter(
                49.487111,
                8.466278,
                $outputFormat,
                'N|S|E|W',
                'before',
                5,
                false,
                ', '
            );

            $this->assertSame($outputFormat, $parameter->getOutputFormat());
        }
    }

    /**
     * Data provider for cardinal points
     *
     * @return array [latitude, longitude, cardinalPoints, expectedNorthSouth, expectedEastWest]
     */
    public function matchingCardinalPointsDataProvider(): array
    {
        return [
            'north' => [49.487111, 8.466278, 'NORTH|SOUTH|EAST|WEST', 'NORTH', 'EAST'],
            'south' => [-53.163494, -70.905071, 'NORTH|SOUTH|EAST|WEST', 'SOUTH', 'WEST'],
        ];
    }

    /**
     * @test
     * @dataProvider matchingCardinalPointsDataProvider
     *
     * @param float $latitude
     * @param float $longitude
     * @param string $cardinalPoints
     * @param string $expectedNorthSouthValue
     */
    public function parameterCardinalPointsForLatitudeSetCorrectly(
        float $latitude,
        float $longitude,
        string $cardinalPoints,
        string $expectedNorthSouthValue
    ) {
        $parameter = new Parameter(
            $latitude,
            $longitude,
            'degree',
            $cardinalPoints,
            'before',
            5,
            false,
            ', '
        );

        $this->assertSame($expectedNorthSouthValue, $parameter->getCardinalPointForLatitude());
    }

    /**
     * @test
     */
    public function parameterCardinalPointsPositionSetCorrectly()
    {
        $allowedPositions = [
            'after',
            'before',
        ];

        foreach ($allowedPositions as $position) {
            $parameter = new Parameter(
                49.487111,
                8.466278,
                'degree',
                'N|S|E|W',
                $position,
                5,
                false,
                ', '
            );

            $this->assertSame($position, $parameter->getCardinalPointsPosition());
        }
    }

    /**
     * @test
     */
    public function parameterNumberOfDecimalsSetCorrectly()
    {
        $parameter = new Parameter(
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            3,
            true,
            ', '
        );

        $this->assertSame(3, $parameter->getNumberOfDecimals());
    }

    /**
     * @test
     */
    public function parameterShowTrailingZerosSetCorrectly()
    {
        $parameter = new Parameter(
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            5,
            true,
            ', '
        );

        $this->assertTrue($parameter->shouldTrailingZerosBeRemoved());

        $parameter = new Parameter(
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ', '
        );

        $this->assertFalse($parameter->shouldTrailingZerosBeRemoved());
    }

    /**
     * @test
     */
    public function parameterDelimiterZerosSetCorrectly()
    {
        $parameter = new Parameter(
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ' / '
        );

        $this->assertSame(' / ', $parameter->getDelimiter());
    }

    /**
     * @test
     * @dataProvider dataProviderForInvalidParameters
     *
     * @param float $latitude
     * @param float $longitude
     * @param string $outputFormat
     * @param string $cardinalPoints
     * @param string $cardinalPointsPosition
     * @param int $numberOfDecimals
     * @param bool $removeTrailingZeros
     * @param string $delimiter
     * @param int $expectedExceptionCode
     */
    public function invalidParametersThrowInvalidArgumentException(
        float $latitude,
        float $longitude,
        string $outputFormat,
        string $cardinalPoints,
        string $cardinalPointsPosition,
        int $numberOfDecimals,
        bool $removeTrailingZeros,
        string $delimiter,
        int $expectedExceptionCode
    ) {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode($expectedExceptionCode);

        new Parameter(
            $latitude,
            $longitude,
            $outputFormat,
            $cardinalPoints,
            $cardinalPointsPosition,
            $numberOfDecimals,
            $removeTrailingZeros,
            $delimiter
        );
    }

    public function dataProviderForInvalidParameters(): array
    {
        return [
            'latitude is too high' => [
                90.01,
                8.466278,
                'degree',
                'N|S|E|W',
                'before',
                5,
                false,
                ' / ',
                1562698303
            ],
            'latitude is too low' => [
                -90.01,
                8.466278,
                'degree',
                'N|S|E|W',
                'before',
                5,
                false,
                ' / ',
                1562698303
            ],
            'longitude is too high' => [
                49.487111,
                180.01,
                'degree',
                'N|S|E|W',
                'before',
                5,
                true,
                ', ',
                1562698344
            ],
            'longitude is too low' => [
                49.487111,
                -180.01,
                'degree',
                'N|S|E|W',
                'before',
                5,
                true,
                ', ',
                1562698344
            ],
            'degree is invalid' => [
                49.487111,
                8.466278,
                'somethingElse',
                'N|S|E|W',
                'before',
                5,
                true,
                ', ',
                1562698411
            ],
            'cardinal points number is too low' => [
                49.487111,
                8.466278,
                'degree',
                'N|S|E',
                'before',
                5,
                true,
                ', ',
                1562698459
            ],
            'cardinal points number is too high' => [
                49.487111,
                8.466278,
                'degree',
                'N|S|E|W|Z',
                'before',
                5,
                true,
                ', ',
                1562698459
            ],
            'cardinal points position is invalid' => [
                49.487111,
                8.466278,
                'degree',
                'N|S|E|W',
                'middle',
                5,
                true,
                ', ',
                1562698511
            ],
            'number of decimals is negative' => [
                49.487111,
                8.466278,
                'degree',
                'N|S|E|W',
                'before',
                -5,
                true,
                ', ',
                1562698555
            ],
        ];
    }
}
