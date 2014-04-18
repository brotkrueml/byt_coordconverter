<?php
namespace Byterror\BytCoordconverter\Tests\Unit\Utility;

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

use Byterror\BytCoordconverter\Utility\UtmUtility;


class UtmUtilityTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

    /**
     * @test
     */
    public function eccentricityOfEarthIsCorrectlyCalculated() {
        $actualResult = UtmUtility::getEccentricityOfReferenceEllipsoid();

        $this->assertEquals(0.0066943800667647, $actualResult);
    }


    /**
     * Data provider for longitudinal zones
     *
     * @return array [north, south, west, east, expectedZone]
     */
    public function matchingLongitudinalZoneDataProvider() {
        return array(
            'zone 1'  => array(0.0, 0.0, -180.0, -174.0001,  1),
            'zone 2'  => array(0.0, 0.0, -174.0, -168.0001,  2),
            'zone 3'  => array(0.0, 0.0, -168.0, -162.0001,  3),
            'zone 4'  => array(0.0, 0.0, -162.0, -156.0001,  4),
            'zone 5'  => array(0.0, 0.0, -156.0, -150.0001,  5),
            'zone 6'  => array(0.0, 0.0, -150.0, -144.0001,  6),
            'zone 7'  => array(0.0, 0.0, -144.0, -138.0001,  7),
            'zone 8'  => array(0.0, 0.0, -138.0, -132.0001,  8),
            'zone 9'  => array(0.0, 0.0, -132.0, -126.0001,  9),
            'zone 10' => array(0.0, 0.0, -126.0, -120.0001, 10),
            'zone 11' => array(0.0, 0.0, -120.0, -114.0001, 11),
            'zone 12' => array(0.0, 0.0, -114.0, -108.0001, 12),
            'zone 13' => array(0.0, 0.0, -108.0, -102.0001, 13),
            'zone 14' => array(0.0, 0.0, -102.0,  -96.0001, 14),
            'zone 15' => array(0.0, 0.0,  -96.0,  -90.0001, 15),
            'zone 16' => array(0.0, 0.0,  -90.0,  -84.0001, 16),
            'zone 17' => array(0.0, 0.0,  -84.0,  -78.0001, 17),
            'zone 18' => array(0.0, 0.0,  -78.0,  -72.0001, 18),
            'zone 19' => array(0.0, 0.0,  -72.0,  -66.0001, 19),
            'zone 20' => array(0.0, 0.0,  -66.0,  -60.0001, 20),
            'zone 21' => array(0.0, 0.0,  -60.0,  -54.0001, 21),
            'zone 22' => array(0.0, 0.0,  -54.0,  -48.0001, 22),
            'zone 23' => array(0.0, 0.0,  -48.0,  -42.0001, 23),
            'zone 24' => array(0.0, 0.0,  -42.0,  -36.0001, 24),
            'zone 25' => array(0.0, 0.0,  -36.0,  -30.0001, 25),
            'zone 26' => array(0.0, 0.0,  -30.0,  -24.0001, 26),
            'zone 27' => array(0.0, 0.0,  -24.0,  -18.0001, 27),
            'zone 28' => array(0.0, 0.0,  -18.0,  -12.0001, 28),
            'zone 29' => array(0.0, 0.0,  -12.0,   -6.0001, 29),
            'zone 30' => array(0.0, 0.0,   -6.0,   -0.0001, 30),
            'zone 31' => array(0.0, 0.0,    0.0,    5.9999, 31),
            'zone 32' => array(0.0, 0.0,    6.0,   11.9999, 32),
            'zone 33' => array(0.0, 0.0,   12.0,   17.9999, 33),
            'zone 34' => array(0.0, 0.0,   18.0,   23.9999, 34),
            'zone 35' => array(0.0, 0.0,   24.0,   29.9999, 35),
            'zone 36' => array(0.0, 0.0,   30.0,   35.9999, 36),
            'zone 37' => array(0.0, 0.0,   36.0,   41.9999, 37),
            'zone 38' => array(0.0, 0.0,   42.0,   47.9999, 38),
            'zone 39' => array(0.0, 0.0,   48.0,   53.9999, 39),
            'zone 40' => array(0.0, 0.0,   54.0,   59.9999, 40),
            'zone 41' => array(0.0, 0.0,   60.0,   65.9999, 41),
            'zone 42' => array(0.0, 0.0,   66.0,   71.9999, 42),
            'zone 43' => array(0.0, 0.0,   72.0,   77.9999, 43),
            'zone 44' => array(0.0, 0.0,   78.0,   83.9999, 44),
            'zone 45' => array(0.0, 0.0,   84.0,   89.9999, 45),
            'zone 46' => array(0.0, 0.0,   90.0,   95.9999, 46),
            'zone 47' => array(0.0, 0.0,   96.0,  101.9999, 47),
            'zone 48' => array(0.0, 0.0,  102.0,  107.9999, 48),
            'zone 49' => array(0.0, 0.0,  108.0,  113.9999, 49),
            'zone 50' => array(0.0, 0.0,  114.0,  119.9999, 50),
            'zone 51' => array(0.0, 0.0,  120.0,  125.9999, 51),
            'zone 52' => array(0.0, 0.0,  126.0,  131.9999, 52),
            'zone 53' => array(0.0, 0.0,  132.0,  137.9999, 53),
            'zone 54' => array(0.0, 0.0,  138.0,  143.9999, 54),
            'zone 55' => array(0.0, 0.0,  144.0,  149.9999, 55),
            'zone 56' => array(0.0, 0.0,  150.0,  155.9999, 56),
            'zone 57' => array(0.0, 0.0,  156.0,  161.9999, 57),
            'zone 58' => array(0.0, 0.0,  162.0,  167.9999, 58),
            'zone 59' => array(0.0, 0.0,  168.0,  173.9999, 59),
            'zone 60' => array(0.0, 0.0,  174.0,  179.9999, 60),

            'zone 31 (exception for norway)' => array(63.9999, 56.0, 0.0,  2.9999, 31),
            'zone 32 (exception for norway)' => array(63.9999, 56.0, 3.0, 11.9999, 32),

            'zone 31 (exception for svalbard)' => array(83.9999, 72.0,  0.0,  8.9999, 31),
            'zone 33 (exception for svalbard)' => array(83.9999, 72.0,  9.0, 20.9999, 33),
            'zone 35 (exception for svalbard)' => array(83.9999, 72.0, 21.0, 32.9999, 35),
            'zone 37 (exception for svalbard)' => array(83.9999, 72.0, 33.0, 41.9999, 37),
        );
    }


    /**
     * @test
     * @dataProvider matchingLongitudinalZoneDataProvider
     */
    public function longitudinalZonesAreCorrectlyCalculated($north, $south, $west, $east, $expectedZone) {
        $west = UtmUtility::getLongitudinalZone($north, $west);
        $east = UtmUtility::getLongitudinalZone($south, $east);

        $this->assertEquals($expectedZone, $west);
        $this->assertEquals($expectedZone, $east);
    }


    /**
     * Data provider for latitudinal zones
     *
     * @return array [north, south, expectedZone]
     */
    public function matchingLatitudinalZoneDataProvider() {
        return array(
            'zone c'  => array(-72.0001, -80.0, 'C'),
            'zone d'  => array(-64.0001, -72.0, 'D'),
            'zone e'  => array(-56.0001, -64.0, 'E'),
            'zone f'  => array(-48.0001, -56.0, 'F'),
            'zone g'  => array(-40.0001, -48.0, 'G'),
            'zone h'  => array(-32.0001, -40.0, 'H'),
            'zone j'  => array(-24.0001, -32.0, 'J'),
            'zone k'  => array(-16.0001, -24.0, 'K'),
            'zone l'  => array( -8.0001, -16.0, 'L'),
            'zone m'  => array( -0.0001,  -8.0, 'M'),
            'zone n'  => array(  7.9999,   0.0, 'N'),
            'zone p'  => array( 15.9999,   8.0, 'P'),
            'zone q'  => array( 23.9999,  16.0, 'Q'),
            'zone r'  => array( 31.9999,  24.0, 'R'),
            'zone s'  => array( 39.9999,  32.0, 'S'),
            'zone t'  => array( 47.9999,  40.0, 'T'),
            'zone u'  => array( 55.9999,  48.0, 'U'),
            'zone v'  => array( 63.9999,  56.0, 'V'),
            'zone w'  => array( 71.9999,  64.0, 'W'),
            'zone x'  => array( 84.0   ,  72.0, 'X'),
        );
    }


    /**
     * @test
     * @dataProvider matchingLatitudinalZoneDataProvider
     */
    public function latitudinalZonesAreCorrectlyCalculated($north, $south, $expectedZone) {
        $west = UtmUtility::getLatitudinalZone($north, 0.0);
        $east = UtmUtility::getLatitudinalZone($south, 0.0);

        $this->assertEquals($expectedZone, $west);
        $this->assertEquals($expectedZone, $east);
    }



    /**
     * Data provider for some coordinates
     *
     * @return array [latitude, longitude, expectedResult]
     */
    public function matchingCoordinatesDataProvider() {
        return array(
            'paradeplatz, mannheim'             => array( 49.487111,   8.466278, '32U 461344 5481745'),
            'empire state building, new york'   => array( 40.748440, -73.984559, '18T 585725 4511328'),
            'statue of christ, rio de janeiro'  => array(-22.951910, -43.210790, '23K 683447 7460687'),
            'ayers rock, australia'             => array(-25.345200, 131.032400, '52J 704540 7195275'),
        );
    }


    /**
     * @test
     * @dataProvider matchingCoordinatesDataProvider
     */
    public function coordinatesAreCorrectlyCalculated($latitude, $longitude, $expectedResult) {
        $actualResult = UtmUtility::getUtmFromLatitudeLongitude(
            $latitude,
            $longitude
        );

        $this->assertEquals($expectedResult, $actualResult);
    }
}