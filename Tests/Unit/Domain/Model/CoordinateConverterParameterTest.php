<?php

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
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ', '
        );

        $this->assertEquals(49.487111, $parameter->getLatitude());
    }

    /**
     * @test
     */
    public function parameterLongitudeSetCorrectly()
    {
        $parameter = new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ', '
        );

        $this->assertEquals(8.466278, $parameter->getLongitude());
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
                '49.487111',
                '8.466278',
                $outputFormat,
                'N|S|E|W',
                'before',
                5,
                false,
                ', '
            );

            $this->assertEquals($outputFormat, $parameter->getOutputFormat());
        }
    }

    /**
     * Data provider for cardinal points
     *
     * @return array [latitude, longitude, cardinalPoints, expectedNorthSouth, expectedEastWest]
     */
    public function matchingCardinalPointsDataProvider()
    {
        return [
            'north' => [49.487111, 8.466278, 'NORTH|SOUTH|EAST|WEST', 'NORTH', 'EAST'],
            'south' => [-53.163494, -70.905071, 'NORTH|SOUTH|EAST|WEST', 'SOUTH', 'WEST'],
        ];
    }

    /**
     * @test
     * @dataProvider matchingCardinalPointsDataProvider
     */
    public function parameterCardinalPointsForLatitudeSetCorrectly(
        $latitude,
        $longitude,
        $cardinalPoints,
        $expectedNorthSouthValue
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

        $this->assertEquals($expectedNorthSouthValue, $parameter->getCardinalPointForLatitude());
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
                '49.487111',
                '8.466278',
                'degree',
                'N|S|E|W',
                $position,
                5,
                false,
                ', '
            );

            $this->assertEquals($position, $parameter->getCardinalPointsPosition());
        }
    }

    /**
     * @test
     */
    public function parameterNumberOfDecimalsSetCorrectly()
    {
        $parameter = new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            3,
            true,
            ', '
        );

        $this->assertEquals(3, $parameter->getNumberOfDecimals());
    }

    /**
     * @test
     */
    public function parameterShowTrailingZerosSetCorrectly()
    {
        $parameter = new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            true,
            ', '
        );

        $this->assertTrue($parameter->shouldTrailingZerosBeRemoved());

        $parameter = new Parameter(
            '49.487111',
            '8.466278',
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
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ' / '
        );

        $this->assertEquals(' / ', $parameter->getDelimiter());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterLatitudeIsToHigh()
    {
        new Parameter(
            '90.01',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ' / '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterLatitudeIsToLow()
    {
        new Parameter(
            '-90.01',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ' / '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterLongitudeIsToHigh()
    {
        new Parameter(
            '49.487111',
            '180.01',
            'degree',
            'N|S|E|W',
            'before',
            5,
            true,
            ', '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterLongitudeIsToLow()
    {
        new Parameter(
            '49.487111',
            '-180.01',
            'degree',
            'N|S|E|W',
            'before',
            5,
            true,
            ', '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterDegreeIsInvalid()
    {
        new Parameter(
            '49.487111',
            '8.466278',
            'somethingElse',
            'N|S|E|W',
            'before',
            5,
            true,
            ', '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterCardinalPointsNumberIsToLow()
    {
        new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E',
            'before',
            5,
            true,
            ', '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterCardinalPointsNumberIsToHigh()
    {
        new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W|Z',
            'before',
            5,
            true,
            ', '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterCardinalPointsPositionIsInvalid()
    {
        new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'middle',
            5,
            true,
            ', '
        );
    }
}
