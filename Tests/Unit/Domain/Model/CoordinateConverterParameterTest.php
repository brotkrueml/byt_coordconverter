<?php
namespace Byterror\BytCoordconverter\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013-2014 Chris Müller <byt3error@web.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

use Byterror\BytCoordconverter\Domain\Model\CoordinateConverterParameter as Parameter;


class CoordinateConverterParameterTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
    /**
     * @test
     */
    public function parameterLatitudeSetCorrectly() {
        $parameter = new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ', '
        );

        $this->assertEquals(49.487111, $parameter->getLatitude());
    }

    /**
     * @test
     */
    public function parameterLongitudeSetCorrectly() {
        $parameter = new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ', '
        );

        $this->assertEquals(8.466278, $parameter->getLongitude());
    }

    /**
     * @test
     */
    public function parameterOutputFormatSetCorrectly() {
        $allowedOutputFormats = array(
            'degree',
            'degreeMinutes',
            'degreeMinutesSeconds',
            'UTM',
        );

        foreach ($allowedOutputFormats as $outputFormat) {
            $parameter = new Parameter(
                '49.487111',
                '8.466278',
                $outputFormat,
                'N|S|E|W',
                'before',
                5,
                FALSE,
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
    public function matchingCardinalPointsDataProvider() {
        return array(
            'north'  => array(49.487111, 8.466278, 'NORTH|SOUTH|EAST|WEST', 'NORTH', 'EAST'),
            'south'  => array(-53.163494, -70.905071, 'NORTH|SOUTH|EAST|WEST', 'SOUTH', 'WEST'),
        );
    }

    /**
     * @test
     * @dataProvider matchingCardinalPointsDataProvider
     */
    public function parameterCardinalPointsForLatitudeSetCorrectly($latitude, $longitude, $cardinalPoints, $expectedNorthSouthValue) {
        $parameter = new Parameter(
            $latitude,
            $longitude,
            'degree',
            $cardinalPoints,
            'before',
            5,
            FALSE,
            ', '
        );

        $this->assertEquals($expectedNorthSouthValue, $parameter->getCardinalPointForLatitude());
    }

    /**
     * @test
     */
    public function parameterCardinalPointsPositionSetCorrectly() {
        $allowedPositions = array(
            'after',
            'before',
        );

        foreach ($allowedPositions as $position) {
            $parameter = new Parameter(
                '49.487111',
                '8.466278',
                'degree',
                'N|S|E|W',
                $position,
                5,
                FALSE,
                ', '
            );

            $this->assertEquals($position, $parameter->getCardinalPointsPosition());
        }
    }

    /**
     * @test
     */
    public function parameterNumberOfDecimalsSetCorrectly() {
        $parameter = new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            3,
            FALSE,
            ', '
        );

        $this->assertEquals(3, $parameter->getNumberOfDecimals());
    }

    /**
     * @test
     */
    public function parameterShowTrailingZerosSetCorrectly() {
        $parameter = new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            TRUE,
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
            FALSE,
            ', '
        );

        $this->assertFalse($parameter->shouldTrailingZerosBeRemoved());
    }

    /**
     * @test
     */
    public function parameterDelimiterZerosSetCorrectly() {
        $parameter = new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ' / '
        );

        $this->assertEquals(' / ', $parameter->getDelimiter());
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterLatitudeIsToHigh() {
        new Parameter(
            '90.01',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ' / '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterLatitudeIsToLow() {
        new Parameter(
            '-90.01',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ' / '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterLongitudeIsToHigh() {
        new Parameter(
            '49.487111',
            '180.01',
            'degree',
            'N|S|E|W',
            'before',
            5,
            TRUE,
            ', '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterLongitudeIsToLow() {
        new Parameter(
            '49.487111',
            '-180.01',
            'degree',
            'N|S|E|W',
            'before',
            5,
            TRUE,
            ', '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterDegreeIsInvalid() {
        new Parameter(
            '49.487111',
            '8.466278',
            'somethingElse',
            'N|S|E|W',
            'before',
            5,
            TRUE,
            ', '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterCardinalPointsNumberIsToLow() {
        new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E',
            'before',
            5,
            TRUE,
            ', '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterCardinalPointsNumberIsToHigh() {
        new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W|Z',
            'before',
            5,
            TRUE,
            ', '
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function parameterCardinalPointsPositionIsInvalid() {
        new Parameter(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'middle',
            5,
            TRUE,
            ', '
        );
    }
}