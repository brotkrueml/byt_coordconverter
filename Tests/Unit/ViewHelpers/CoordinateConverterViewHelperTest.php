<?php
namespace Byterror\BytCoordconverter\Tests\Unit\ViewHelpers;

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

use \Byterror\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper;

class CoordinateConverterViewHelperTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {

    /**
     * @test
     */
    public function viewHelperFormatsDegreeCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278'
        );
        $this->assertEquals('N 49.48711°, E 8.46628°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degreeMinutes'
        );
        $this->assertEquals('N 49° 29.22666\', E 8° 27.97668\'', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesSecondsCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degreeMinutesSeconds'
        );
        $this->assertEquals('N 49° 29\' 13.59960&quot;, E 8° 27\' 58.60080&quot;', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsUtmCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();
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
    public function viewHelperFormatsDegreeWithNumberOfDecimalsCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            3
        );
        $this->assertEquals('N 49.487°, E 8.466°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesWithNumberOfDecimalsCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degreeMinutes',
            'N|S|E|W',
            'before',
            3
        );
        $this->assertEquals('N 49° 29.227\', E 8° 27.977\'', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesSecondsWithNumberOfDecimalsCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degreeMinutesSeconds',
            'N|S|E|W',
            'before',
            1
        );
        $this->assertEquals('N 49° 29\' 13.6&quot;, E 8° 27\' 58.6&quot;', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeWithRemovingTrailingZerosCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487000',
            '8.466201',
            'degree',
            'N|S|E|W',
            'before',
            5,
            TRUE
        );
        $this->assertEquals('N 49.487°, E 8.4662°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeWithRemovingTrailingZerosCorrectlyAvoidingDotAtEnd() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.000',
            '8.000',
            'degree',
            'N|S|E|W',
            'before',
            5,
            TRUE
        );
        $this->assertEquals('N 49°, E 8°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesWithRemovingTrailingZerosCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487',
            '8.466',
            'degreeMinutes',
            'N|S|E|W',
            'before',
            3,
            TRUE
        );
        $this->assertEquals('N 49° 29.22\', E 8° 27.96\'', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesWithRemovingTrailingZerosCorrectlyAvoidingDotAtEnd() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.483333',
            '8.45',
            'degreeMinutes',
            'N|S|E|W',
            'before',
            3,
            TRUE
        );
        $this->assertEquals('N 49° 29\', E 8° 27\'', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesWithRemovingTrailingZerosCorrectlyAvoidingDegreeAtEnd() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.000',
            '8.000',
            'degreeMinutes',
            'N|S|E|W',
            'before',
            3,
            TRUE
        );
        $this->assertEquals('N 49°, E 8°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesSecondsWithRemovingTrailingZerosCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degreeMinutesSeconds',
            'N|S|E|W',
            'before',
            2,
            TRUE
        );
        $this->assertEquals('N 49° 29\' 13.6&quot;, E 8° 27\' 58.6&quot;', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesWithSecondsRemovingTrailingZerosCorrectlyAvoidingDotAtEnd() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.486944',
            '8.466111',
            'degreeMinutesSeconds',
            'N|S|E|W',
            'before',
            2,
            TRUE
        );
        $this->assertEquals('N 49° 29\' 13&quot;, E 8° 27\' 58&quot;', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesWithSecondsRemovingTrailingZerosCorrectlyAvoidingEmptySeconds() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.48333334',
            '8.450001',
            'degreeMinutesSeconds',
            'N|S|E|W',
            'before',
            2,
            TRUE
        );
        $this->assertEquals('N 49° 29\', E 8° 27\'', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesWithSecondsRemovingTrailingZerosCorrectlyAvoidingEmptyMinutesAndSeconds() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.0',
            '8.0',
            'degreeMinutesSeconds',
            'N|S|E|W',
            'before',
            2,
            TRUE
        );
        $this->assertEquals('N 49°, E 8°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperFormatsDegreeMinutesWithSecondsRemovingTrailingZerosCorrectlyWithZeroMinutes() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.003778',
            '8.016278',
            'degreeMinutesSeconds',
            'N|S|E|W',
            'before',
            2,
            TRUE
        );
        $this->assertEquals('N 49° 0\' 13.6&quot;, E 8° 0\' 58.6&quot;', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperUsesDelimiterCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();
        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ' / '
        );
        $this->assertEquals('N 49.48711° / E 8.46628°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperUsesCardinalPointsNorthAndEastCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'North|South|East|West'
        );
        $this->assertEquals('North 49.48711°, East 8.46628°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperUsesCardinalPointsSouthAndWestCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '-53.163494',
            '-70.905071',
            'degree',
            'North|South|East|West'
        );
        $this->assertEquals('South 53.16349°, West 70.90507°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperUsesCardinalPointsPositionBeforeCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'before'
        );
        $this->assertEquals('N 49.48711°, E 8.46628°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperUsesCardinalPointsPositionAfterCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'after'
        );
        $this->assertEquals('49.48711° N, 8.46628° E', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperOutputIsHtmlspecialchardCorrectly() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            '<North>|South|"East&|West'
        );
        $this->assertEquals('&lt;North&gt; 49.48711°, &quot;East&amp; 8.46628°', $actualResult);
    }


    /**
     * @test
     */
    public function viewHelperUsesCardinalPointsPositionAndOutputsErrorOnInvalidParameter() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'N|S|E|W',
            'not-defined',
            5,
            FALSE,
            '',
            TRUE
        );
        $this->assertContains('invalid cardinal points position', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLatitudeExceedsPlus90DegreeAndErrorsShouldBeShown() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '90.01',
            '0.0',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ', ',
            TRUE
        );
        $this->assertContains('invalid latitude', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLatitudeExceedsPlus90DegreeAndErrorsShouldBeSuppressed() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '90.01',
            '0.0',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ', ',
            FALSE
        );
        $this->assertEmpty($actualResult);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLatitudeExceedsMinus90DegreeAndErrorsShouldBeShown() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '-90.01',
            '0.0',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ', ',
            TRUE
        );
        $this->assertContains('invalid latitude', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLatitudeExceedsMinus90DegreeAndErrorsShouldBeSuppressed() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '-90.01',
            '0.0',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ', ',
            FALSE
        );
        $this->assertEmpty($actualResult);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLongitudeExceedsPlus180DegreeAndErrorsShouldBeShown() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '0.0',
            '180.01',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ', ',
            TRUE
        );
        $this->assertContains('invalid longitude', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLongitudeExceedsPlus180DegreeAndErrorsShouldBeSuppressed() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '0.0',
            '180.01',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ', ',
            FALSE
        );
        $this->assertEmpty($actualResult);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLongitudeExceedsMinus180DegreeAndErrorsShouldBeShown() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '0.0',
            '-180.01',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ', ',
            TRUE
        );
        $this->assertContains('invalid longitude', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenLongitudeExceedsMinus180DegreeAndErrorsShouldBeSuppressed() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '0.0',
            '-180.01',
            'degree',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ', ',
            FALSE
        );
        $this->assertEmpty($actualResult);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenFormatIsInvalidAndErrorsShouldBeShown() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'not existing',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ', ',
            TRUE
        );
        $this->assertContains('invalid output format', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenFormatIsInvalidAndErrorsShouldBeSuppressed() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'not existing',
            'N|S|E|W',
            'before',
            5,
            FALSE,
            ', ',
            FALSE
        );
        $this->assertEmpty($actualResult);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenNumberOfParametersInCardinalPointsAreInvalidAndErrorsShouldBeShown() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'only|three|parameters',
            'before',
            5,
            FALSE,
            ', ',
            TRUE
        );
        $this->assertContains('invalid number', $actualResult, '', TRUE);
    }


    /**
     * @test
     */
    public function viewHelperOutputsErrorWhenNumberOfParametersInCardinalPointsAreInvalidAndErrorsShouldBeSuppressed() {
        $viewHelper = new CoordinateConverterViewHelper();

        $actualResult = $viewHelper->render(
            '49.487111',
            '8.466278',
            'degree',
            'only|three|parameters',
            'before',
            5,
            FALSE,
            ', ',
            FALSE
        );
        $this->assertEmpty($actualResult);
    }
}