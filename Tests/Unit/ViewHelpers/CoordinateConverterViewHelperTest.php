<?php
namespace Byterror\BytCoordconverter\Tests\Unit\ViewHelpers;

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


class CoordinateConverterViewHelperTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

    /**
     * @test
     */
    public function viewHelperFormatsDegreeCorrectly() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278'
        );

        $this->assertEquals('N 49.487111°, E 8.466278°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesCorrectly() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degreeMinutes'
        );
        $this->assertEquals('N 49°29.227\', E 8°27.977\'', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesSecondsCorrectly() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degreeMinutesSeconds'
        );
        $this->assertEquals('N 49° 29\' 13.60", E 8° 27\' 58.60"', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsUtmCorrectly() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'UTM'
        );
        $this->assertEquals('32U 461344 5481745', $actualResult);
    }



    /**
     * @test
     */
    public function viewHelperUsesDelimiterCorrectly() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            ' / '
        );
        $this->assertEquals('N 49.487111° / E 8.466278°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperUsesCardinalPointsNorthAndEastCorrectly() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'North|South|East|West'
        );
        $this->assertEquals('North 49.487111°, East 8.466278°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperUsesCardinalPointsSouthAndWestCorrectly() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '-53.163494',
            '-70.905071',
            'degree',
            'North|South|East|West'
        );
        $this->assertEquals('South 53.163494°, West 70.905071°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperUsesCardinalPointsPositionBeforeCorrectly() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before'
        );
        $this->assertEquals('N 49.487111°, E 8.466278°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperUsesCardinalPointsPositionAfterCorrectly() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'after'
        );
        $this->assertEquals('49.487111° N, 8.466278° E', $actualResult);
    }




    /**
     * @test
     */
    public function viewHelperUsesCardinalPointsPositionAndOutputsErrorOnWrongParameter() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'not-defined',
            '',
            TRUE
        );
        $this->assertContains('wrong cardinal points position', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLatitudeExceedsPlus90DegreeAndErrorsShouldBeShown() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '90.01',
            '0.0',
            'degree',
            'N|S|E|W',
            'before',
            ', ',
            TRUE
        );
        $this->assertContains('wrong latitude', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLatitudeExceedsPlus90DegreeAndErrorsShouldBeSuppressed() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '90.01',
            '0.0',
            'degree',
            'N|S|E|W',
            'before',
            ', ',
            FALSE
        );
        $this->assertEmpty($actualResult);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLatitudeExceedsMinus90DegreeAndErrorsShouldBeShown() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '-90.01',
            '0.0',
            'degree',
            'N|S|E|W',
            'before',
            ', ',
            TRUE
        );
        $this->assertContains('wrong latitude', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLatitudeExceedsMinus90DegreeAndErrorsShouldBeSuppressed() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '-90.01',
            '0.0',
            'degree',
            'N|S|E|W',
            'before',
            ', ',
            FALSE
        );
        $this->assertEmpty($actualResult);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLongitudeExceedsPlus180DegreeAndErrorsShouldBeShown() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '0.0',
            '180.01',
            'degree',
            'N|S|E|W',
            'before',
            ', ',
            TRUE
        );
        $this->assertContains('wrong longitude', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLongitudeExceedsPlus180DegreeAndErrorsShouldBeSuppressed() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '0.0',
            '180.01',
            'degree',
            'N|S|E|W',
            'before',
            ', ',
            FALSE
        );
        $this->assertEmpty($actualResult);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLongitudeExceedsMinus180DegreeAndErrorsShouldBeShown() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '0.0',
            '-180.01',
            'degree',
            'N|S|E|W',
            'before',
            ', ',
            TRUE
        );
        $this->assertContains('wrong longitude', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLongitudeExceedsMinus180DegreeAndErrorsShouldBeSuppressed() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '0.0',
            '-180.01',
            'degree',
            'N|S|E|W',
            'before',
            ', ',
            FALSE
        );
        $this->assertEmpty($actualResult);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenFormatIsWrongAndErrorsShouldBeShown() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'not existing',
            'N|S|E|W',
            'before',
            ', ',
            TRUE
        );
        $this->assertContains('wrong output format', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenFormatIsWrongAndErrorsShouldBeSuppressed() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'not existing',
            'N|S|E|W',
            'before',
            ', ',
            FALSE
        );
        $this->assertEmpty($actualResult);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenNumberOfParametersInCardinalPointsAreWrongAndErrorsShouldBeShown() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'only|three|parameters',
            'before',
            ', ',
            TRUE
        );
        $this->assertContains('wrong number', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenNumberOfParametersInCardinalPointsAreWrongAndErrorsShouldBeSuppressed() {
        $viewHelper = new \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'only|three|parameters',
            'before',
            ', ',
            FALSE
        );
        $this->assertEmpty($actualResult);
    }

}