<?php
namespace Byterror\BytCoordconverter\Tests\Unit\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Chris Müller <byt3error@web.de>
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
     * @test
     */
    public function longitudinalZone1IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 1;

        $west = UtmUtility::getLongitudinalZone(0.0, -180.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -174.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone2IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 2;

        $west = UtmUtility::getLongitudinalZone(0.0, -174.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -168.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone3IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 3;

        $west = UtmUtility::getLongitudinalZone(0.0, -168.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -162.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone4IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 4;

        $west = UtmUtility::getLongitudinalZone(0.0, -162.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -156.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone5IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 5;

        $west = UtmUtility::getLongitudinalZone(0.0, -156.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -150.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone6IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 6;

        $west = UtmUtility::getLongitudinalZone(0.0, -150.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -144.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone7IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 7;

        $west = UtmUtility::getLongitudinalZone(0.0, -144.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -138.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone8IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 8;

        $west = UtmUtility::getLongitudinalZone(0.0, -138.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -132.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone9IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 9;

        $west = UtmUtility::getLongitudinalZone(0.0, -132.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -126.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone10IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 10;

        $west = UtmUtility::getLongitudinalZone(0.0, -126.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -120.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone11IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 11;

        $west = UtmUtility::getLongitudinalZone(0.0, -120.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -114.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone12IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 12;

        $west = UtmUtility::getLongitudinalZone(0.0, -114.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -108.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone13IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 13;

        $west = UtmUtility::getLongitudinalZone(0.0, -108.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -102.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone14IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 14;

        $west = UtmUtility::getLongitudinalZone(0.0, -102.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -96.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone15IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 15;

        $west = UtmUtility::getLongitudinalZone(0.0, -96.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -90.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone16IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 16;

        $west = UtmUtility::getLongitudinalZone(0.0, -90.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -84.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone17IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 17;

        $west = UtmUtility::getLongitudinalZone(0.0, -84.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -78.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone18IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 18;

        $west = UtmUtility::getLongitudinalZone(0.0, -78.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -72.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone19IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 19;

        $west = UtmUtility::getLongitudinalZone(0.0, -72.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -66.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone20IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 20;

        $west = UtmUtility::getLongitudinalZone(0.0, -66.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -60.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone21IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 21;

        $west = UtmUtility::getLongitudinalZone(0.0, -60.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -54.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone22IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 22;

        $west = UtmUtility::getLongitudinalZone(0.0, -54.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -48.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone23IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 23;

        $west = UtmUtility::getLongitudinalZone(0.0, -48.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -42.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone24IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 24;

        $west = UtmUtility::getLongitudinalZone(0.0, -42.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -36.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone25IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 25;

        $west = UtmUtility::getLongitudinalZone(0.0, -36.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -30.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone26IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 26;

        $west = UtmUtility::getLongitudinalZone(0.0, -30.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -24.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone27IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 27;

        $west = UtmUtility::getLongitudinalZone(0.0, -24.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -18.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone28IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 28;

        $west = UtmUtility::getLongitudinalZone(0.0, -18.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -12.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone29IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 29;

        $west = UtmUtility::getLongitudinalZone(0.0, -12.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -6.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone30IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 30;

        $west = UtmUtility::getLongitudinalZone(0.0, -6.0);
        $east = UtmUtility::getLongitudinalZone(0.0, -0.0001);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone31IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 31;

        $west = UtmUtility::getLongitudinalZone(0.0, 0.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 5.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone32IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 32;

        $west = UtmUtility::getLongitudinalZone(0.0, 6.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 11.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone33IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 33;

        $west = UtmUtility::getLongitudinalZone(0.0, 12.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 17.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone34IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 34;

        $west = UtmUtility::getLongitudinalZone(0.0, 18.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 23.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone35IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 35;

        $west = UtmUtility::getLongitudinalZone(0.0, 24.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 29.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone36IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 36;

        $west = UtmUtility::getLongitudinalZone(0.0, 30.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 35.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone37IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 37;

        $west = UtmUtility::getLongitudinalZone(0.0, 36.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 41.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone38IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 38;

        $west = UtmUtility::getLongitudinalZone(0.0, 42.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 47.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone39IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 39;

        $west = UtmUtility::getLongitudinalZone(0.0, 48.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 53.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone40IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 40;

        $west = UtmUtility::getLongitudinalZone(0.0, 54.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 59.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone41IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 41;

        $west = UtmUtility::getLongitudinalZone(0.0, 60.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 65.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone42IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 42;

        $west = UtmUtility::getLongitudinalZone(0.0, 66.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 71.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone43IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 43;

        $west = UtmUtility::getLongitudinalZone(0.0, 72.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 77.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone44IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 44;

        $west = UtmUtility::getLongitudinalZone(0.0, 78.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 83.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone45IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 45;

        $west = UtmUtility::getLongitudinalZone(0.0, 84.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 89.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone46IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 46;

        $west = UtmUtility::getLongitudinalZone(0.0, 90.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 95.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone47IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 47;

        $west = UtmUtility::getLongitudinalZone(0.0, 96.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 101.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone48IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 48;

        $west = UtmUtility::getLongitudinalZone(0.0, 102.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 107.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone49IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 49;

        $west = UtmUtility::getLongitudinalZone(0.0, 108.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 113.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone50IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 50;

        $west = UtmUtility::getLongitudinalZone(0.0, 114.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 119.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone51IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 51;

        $west = UtmUtility::getLongitudinalZone(0.0, 120.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 125.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone52IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 52;

        $west = UtmUtility::getLongitudinalZone(0.0, 126.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 131.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone53IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 53;

        $west = UtmUtility::getLongitudinalZone(0.0, 132.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 137.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone54IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 54;

        $west = UtmUtility::getLongitudinalZone(0.0, 138.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 143.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone55IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 55;

        $west = UtmUtility::getLongitudinalZone(0.0, 144.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 149.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone56IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 56;

        $west = UtmUtility::getLongitudinalZone(0.0, 150.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 155.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone57IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 57;

        $west = UtmUtility::getLongitudinalZone(0.0, 156.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 161.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone58IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 58;

        $west = UtmUtility::getLongitudinalZone(0.0, 162.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 167.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone59IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 59;

        $west = UtmUtility::getLongitudinalZone(0.0, 168.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 173.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone60IsCorrectlyCalculated() {
        $expectedLongitudinalZone = 60;

        $west = UtmUtility::getLongitudinalZone(0.0, 174.0);
        $east = UtmUtility::getLongitudinalZone(0.0, 179.9999);

        $this->assertEquals($expectedLongitudinalZone, $west);
        $this->assertEquals($expectedLongitudinalZone, $east);
    }


    /**
     * @test
     */
    public function longitudinalZone31ExceptionForNorwayIsCorrectlyCalculated() {
        $expectedLongitudinalZone = 31;

        $northwest = UtmUtility::getLongitudinalZone(63.9999, 0.0);
        $southeast = UtmUtility::getLongitudinalZone(56.0, 2.9999);

        $this->assertEquals($expectedLongitudinalZone, $northwest);
        $this->assertEquals($expectedLongitudinalZone, $southeast);
    }


    /**
     * @test
     */
    public function longitudinalZone32ExceptionForNorwayIsCorrectlyCalculated() {
        $expectedLongitudinalZone = 32;

        $northwest = UtmUtility::getLongitudinalZone(63.9999, 3.0);
        $southeast = UtmUtility::getLongitudinalZone(56.0, 11.9999);

        $this->assertEquals($expectedLongitudinalZone, $northwest);
        $this->assertEquals($expectedLongitudinalZone, $southeast);
    }


    /**
     * @test
     */
    public function longitudinalZone31ExceptionForSvalbardIsCorrectlyCalculated() {
        $expectedLongitudinalZone = 31;

        $northwest = UtmUtility::getLongitudinalZone(83.9999, 0.0);
        $southeast = UtmUtility::getLongitudinalZone(72.0, 8.9999);

        $this->assertEquals($expectedLongitudinalZone, $northwest);
        $this->assertEquals($expectedLongitudinalZone, $southeast);
    }


    /**
     * @test
     */
    public function longitudinalZone33ExceptionForSvalbardIsCorrectlyCalculated() {
        $expectedLongitudinalZone = 33;

        $northwest = UtmUtility::getLongitudinalZone(83.9999, 9.0);
        $southeast = UtmUtility::getLongitudinalZone(72.0, 20.9999);

        $this->assertEquals($expectedLongitudinalZone, $northwest);
        $this->assertEquals($expectedLongitudinalZone, $southeast);
    }


    /**
     * @test
     */
    public function longitudinalZone35ExceptionForSvalbardIsCorrectlyCalculated() {
        $expectedLongitudinalZone = 35;

        $northwest = UtmUtility::getLongitudinalZone(83.9999, 21.0);
        $southeast = UtmUtility::getLongitudinalZone(72.0, 32.9999);

        $this->assertEquals($expectedLongitudinalZone, $northwest);
        $this->assertEquals($expectedLongitudinalZone, $southeast);
    }


    /**
     * @test
     */
    public function longitudinalZone37ExceptionForSvalbardIsCorrectlyCalculated() {
        $expectedLongitudinalZone = 37;

        $northwest = UtmUtility::getLongitudinalZone(83.9999, 33.0);
        $southeast = UtmUtility::getLongitudinalZone(72.0, 41.9999);

        $this->assertEquals($expectedLongitudinalZone, $northwest);
        $this->assertEquals($expectedLongitudinalZone, $southeast);
    }


    /**
     * @test
     */
    public function latitudinalZoneCIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'C';

        $north = UtmUtility::getLatitudinalZone(-72.0001, 0.0);
        $south = UtmUtility::getLatitudinalZone(-80.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneDIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'D';

        $north = UtmUtility::getLatitudinalZone(-64.0001, 0.0);
        $south = UtmUtility::getLatitudinalZone(-72.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneEIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'E';

        $north = UtmUtility::getLatitudinalZone(-56.0001, 0.0);
        $south = UtmUtility::getLatitudinalZone(-64.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneFIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'F';

        $north = UtmUtility::getLatitudinalZone(-48.0001, 0.0);
        $south = UtmUtility::getLatitudinalZone(-56.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneGIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'G';

        $north = UtmUtility::getLatitudinalZone(-40.0001, 0.0);
        $south = UtmUtility::getLatitudinalZone(-48.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneHIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'H';

        $north = UtmUtility::getLatitudinalZone(-32.0001, 0.0);
        $south = UtmUtility::getLatitudinalZone(-40.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneJIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'J';

        $north = UtmUtility::getLatitudinalZone(-24.0001, 0.0);
        $south = UtmUtility::getLatitudinalZone(-32.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneKIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'K';

        $north = UtmUtility::getLatitudinalZone(-16.0001, 0.0);
        $south = UtmUtility::getLatitudinalZone(-24.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneLIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'L';

        $north = UtmUtility::getLatitudinalZone(-8.0001, 0.0);
        $south = UtmUtility::getLatitudinalZone(-16.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneMIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'M';

        $north = UtmUtility::getLatitudinalZone(-0.0001, 0.0);
        $south = UtmUtility::getLatitudinalZone(-8.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneNIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'N';

        $north = UtmUtility::getLatitudinalZone(7.9999, 0.0);
        $south = UtmUtility::getLatitudinalZone(0.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZonePIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'P';

        $north = UtmUtility::getLatitudinalZone(15.9999, 0.0);
        $south = UtmUtility::getLatitudinalZone(8.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneQIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'Q';

        $north = UtmUtility::getLatitudinalZone(23.9999, 0.0);
        $south = UtmUtility::getLatitudinalZone(16.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneRIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'R';

        $north = UtmUtility::getLatitudinalZone(31.9999, 0.0);
        $south = UtmUtility::getLatitudinalZone(24.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneSIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'S';

        $north = UtmUtility::getLatitudinalZone(39.9999, 0.0);
        $south = UtmUtility::getLatitudinalZone(32.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneTIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'T';

        $north = UtmUtility::getLatitudinalZone(47.9999, 0.0);
        $south = UtmUtility::getLatitudinalZone(40.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneUIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'U';

        $north = UtmUtility::getLatitudinalZone(55.9999, 0.0);
        $south = UtmUtility::getLatitudinalZone(48.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneVIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'V';

        $north = UtmUtility::getLatitudinalZone(63.9999, 0.0);
        $south = UtmUtility::getLatitudinalZone(56.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneWIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'W';

        $north = UtmUtility::getLatitudinalZone(71.9999, 0.0);
        $south = UtmUtility::getLatitudinalZone(64.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function latitudinalZoneXIsCorrectlyCalculated() {
        $expectedLatitudinalZone = 'X';

        $north = UtmUtility::getLatitudinalZone(84.0, 0.0);
        $south = UtmUtility::getLatitudinalZone(72.0, 0.0);

        $this->assertEquals($expectedLatitudinalZone, $north);
        $this->assertEquals($expectedLatitudinalZone, $south);
    }


    /**
     * @test
     */
    public function UtmFromLatitudeLongitudeForParadeplatzMannheimIsCorrectlyCalculated() {
        $expectedResult = '32U 461344 5481745';

        $actualResult = UtmUtility::getUtmFromLatitudeLongitude(
            '49.487111',
            '8.466278'
        );

        $this->assertEquals($expectedResult, $actualResult);
    }


    /**
     * @test
     */
    public function UtmFromLatitudeLongitudeForEmpireStateBuildingIsCorrectlyCalculated() {
        $expectedResult = '18T 585725 4511328';

        $actualResult = UtmUtility::getUtmFromLatitudeLongitude(
            '40.74844',
            '-73.984559'
        );

        $this->assertEquals($expectedResult, $actualResult);
    }


    /**
     * @test
     */
    public function UtmFromLatitudeLongitudeForStatueOfChristInRioDeJaneiroIsCorrectlyCalculated() {
        $expectedResult = '23K 683447 7460687';

        $actualResult = UtmUtility::getUtmFromLatitudeLongitude(
            '-22.95191',
            '-43.21079'
        );

        $this->assertEquals($expectedResult, $actualResult);
    }


    /**
     * @test
     */
    public function UtmFromLatitudeLongitudeForAyersRockIsCorrectlyCalculated() {
        $expectedResult = '52J 704540 7195275';

        $actualResult = UtmUtility::getUtmFromLatitudeLongitude(
            '-25.3452',
            '131.0324'
        );

        $this->assertEquals($expectedResult, $actualResult);
    }

}