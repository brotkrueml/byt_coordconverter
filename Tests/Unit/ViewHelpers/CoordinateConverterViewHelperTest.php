<?php

namespace Brotkrueml\BytCoordconverter\Tests\Unit\ViewHelpers;

use Brotkrueml\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;

/**
 * This file is part of the "byt_coordconverter" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
class CoordinateConverterViewHelperTest extends TestCase
{
    /**
     * @var CoordinateConverterViewHelper
     */
    private $viewHelper;

    /**
     * @var RenderingContext
     */
    private $renderingContextMock;

    protected function setUp()
    {
        $this->viewHelper = $this->getMockBuilder(CoordinateConverterViewHelper::class);

        $this->renderingContextMock = $this->getMockBuilder(RenderingContext::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @test
     */
    public function argumentsAreRegisteredCorrectly()
    {
        /** @var MockObject|CoordinateConverterViewHelper $viewHelper */
        $viewHelper = $this->getMockBuilder(CoordinateConverterViewHelper::class)
            ->setMethods(['registerArgument'])
            ->getMock();

        $viewHelper
            ->expects($this->exactly(8))
            ->method('registerArgument')
            ->withConsecutive(
                [
                    'latitude',
                    'string',
                    $this->anything(),
                    true,
                ],
                [
                    'longitude',
                    'string',
                    $this->anything(),
                    true,
                ],
                [
                    'outputFormat',
                    'string',
                    $this->anything(),
                    false,
                    'degree',
                ],
                [
                    'cardinalPoints',
                    'string',
                    $this->anything(),
                    false,
                    'N|S|E|W',
                ],
                [
                    'cardinalPointsPosition',
                    'string',
                    $this->anything(),
                    false,
                    'before',
                ],
                [
                    'numberOfDecimals',
                    'int',
                    $this->anything(),
                    false,
                    5,
                ],
                [
                    'removeTrailingZeros',
                    'bool',
                    $this->anything(),
                    false,
                    false,
                ],
                [
                    'delimiter',
                    'string',
                    $this->anything(),
                    false,
                    ', ',
                ]
            );

        $viewHelper->initializeArguments();
    }

    /**
     * @test
     * @dataProvider provider
     *
     * @param array $arguments
     * @param string $expected
     */
    public function renderReturnCorrectCoordinatesFormat(array $arguments, string $expected)
    {
        $viewHelper = new CoordinateConverterViewHelper();
        $actual = $viewHelper->renderStatic(
            $arguments,
            function () {
            },
            $this->renderingContextMock
        );

        $this->assertEquals($expected, $actual);
    }

    public function provider(): array
    {
        return [
            'view helper converts given coordinates to format degree correctly' => [
                [
                    'latitude' => '49.487111',
                    'longitude' => '8.466278',
                ],
                'N 49.48711°, E 8.46628°'
            ],
            'view helper converts given coordinates to format degreeMinutes correctly' => [
                [
                    'latitude' => '49.487111',
                    'longitude' => '8.466278',
                    'outputFormat' => 'degreeMinutes',
                ],
                'N 49° 29.22666\', E 8° 27.97668\''
            ],
            'view helper converts given coordinates to format degreeMinutesSeconds correctly' => [
                [
                    'latitude' => '49.487111',
                    'longitude' => '8.466278',
                    'outputFormat' => 'degreeMinutesSeconds',
                ],
                'N 49° 29\' 13.59960", E 8° 27\' 58.60080"'
            ],
            'view helper converts given coordinates to format UTM correctly' => [
                [
                    'latitude' => '49.487111',
                    'longitude' => '8.466278',
                    'outputFormat' => 'UTM',
                ],
                '32U 461344 5481745'
            ],
            'view helper converts given coordinates to format degree with numberOfDecimals correctly' => [
                [
                    'latitude' => '49.487111',
                    'longitude' => '8.466278',
                    'outputFormat' => 'degree',
                    'numberOfDecimals' => 3,
                ],
                'N 49.487°, E 8.466°'
            ],
            'view helper converts given coordinates to format degreeMinutes with numberOfDecimals correctly' => [
                [
                    'latitude' => '49.487111',
                    'longitude' => '8.466278',
                    'outputFormat' => 'degreeMinutes',
                    'numberOfDecimals' => 3,
                ],
                'N 49° 29.227\', E 8° 27.977\''
            ],
            'view helper converts given coordinates to format degreeMinutesSeconds with numberOfDecimals correctly' => [
                [
                    'latitude' => '49.487111',
                    'longitude' => '8.466278',
                    'outputFormat' => 'degreeMinutesSeconds',
                    'numberOfDecimals' => 1,
                ],
                'N 49° 29\' 13.6", E 8° 27\' 58.6"'
            ],
            'view helper converts given coordinates to format degree with removeTrailingZeros correctly' => [
                [
                    'latitude' => '49.487000',
                    'longitude' => '8.466201',
                    'outputFormat' => 'degree',
                    'removeTrailingZeros' => true,
                ],
                'N 49.487°, E 8.4662°'
            ],
            'view helper converts given coordinates to format degree with removeTrailingZeros and avoiding dot at the end correctly' => [
                [
                    'latitude' => '49.000',
                    'longitude' => '8.000',
                    'outputFormat' => 'degree',
                    'removeTrailingZeros' => true,
                ],
                'N 49°, E 8°'
            ],
            'view helper converts given coordinates to format degreeMinutes with removeTrailingZeros correctly' => [
                [
                    'latitude' => '49.487',
                    'longitude' => '8.466',
                    'outputFormat' => 'degreeMinutes',
                    'removeTrailingZeros' => true,
                ],
                'N 49° 29.22\', E 8° 27.96\''
            ],
            'view helper converts given coordinates to format degreeMinutes with removeTrailingZeros and avoiding dot at the end correctly' => [
                [
                    'latitude' => '49.4833333333',
                    'longitude' => '8.45',
                    'outputFormat' => 'degreeMinutes',
                    'removeTrailingZeros' => true,
                ],
                'N 49° 29\', E 8° 27\''
            ],
            'view helper converts given coordinates to format degreeMinutes with removeTrailingZeros and avoiding degree at the end correctly' => [
                [
                    'latitude' => '49.000',
                    'longitude' => '8.000',
                    'outputFormat' => 'degreeMinutes',
                    'removeTrailingZeros' => true,
                ],
                'N 49°, E 8°'
            ],
            'view helper converts given coordinates to format degreeMinutesSeconds with removeTrailingZeros correctly' => [
                [
                    'latitude' => '49.000',
                    'longitude' => '8.000',
                    'outputFormat' => 'degreeMinutesSeconds',
                    'removeTrailingZeros' => true,
                ],
                'N 49°, E 8°'
            ],
            'view helper converts given coordinates to format degreeMinutesSeconds with removeTrailingZeros and avoiding dot at the end correctly' => [
                [
                    'latitude' => '49.486944',
                    'longitude' => '8.466111',
                    'outputFormat' => 'degreeMinutesSeconds',
                    'numberOfDecimals' => 2,
                    'removeTrailingZeros' => true,
                ],
                'N 49° 29\' 13", E 8° 27\' 58"'
            ],
            'view helper converts given coordinates to format degreeMinutesSeconds with removeTrailingZeros and avoiding empty seconds correctly' => [
                [
                    'latitude' => '49.48333334',
                    'longitude' => '8.450001',
                    'outputFormat' => 'degreeMinutesSeconds',
                    'numberOfDecimals' => 2,
                    'removeTrailingZeros' => true,
                ],
                'N 49° 29\', E 8° 27\''
            ],
            'view helper converts given coordinates to format degreeMinutesSeconds with removeTrailingZeros and avoiding empty minutes and seconds correctly' => [
                [
                    'latitude' => '49.0',
                    'longitude' => '8.0',
                    'outputFormat' => 'degreeMinutesSeconds',
                    'numberOfDecimals' => 2,
                    'removeTrailingZeros' => true,
                ],
                'N 49°, E 8°'
            ],
            'view helper converts given coordinates to format degreeMinutesSeconds with removeTrailingZeros and zero minutes correctly' => [
                [
                    'latitude' => '49.003778',
                    'longitude' => '8.016278',
                    'outputFormat' => 'degreeMinutesSeconds',
                    'numberOfDecimals' => 2,
                    'removeTrailingZeros' => true,
                ],
                'N 49° 0\' 13.6", E 8° 0\' 58.6"'
            ],
            'view helper uses delimiter correctly' => [
                [
                    'latitude' => '49.487111',
                    'longitude' => '8.466278',
                    'outputFormat' => 'degree',
                    'delimiter' => ' / ',
                ],
                'N 49.48711° / E 8.46628°'
            ],
            'view helper uses cardinal points north and east correctly' => [
                [
                    'latitude' => '49.487111',
                    'longitude' => '8.466278',
                    'outputFormat' => 'degree',
                    'cardinalPoints' => 'North|South|East|West'
                ],
                'North 49.48711°, East 8.46628°'
            ],
            'view helper uses cardinal points south and west correctly' => [
                [
                    'latitude' => '-53.163494',
                    'longitude' => '-70.905071',
                    'outputFormat' => 'degree',
                    'cardinalPoints' => 'North|South|East|West'
                ],
                'South 53.16349°, West 70.90507°'
            ],
            'view helper uses cardinal points position set to before correctly' => [
                [
                    'latitude' => '49.487111',
                    'longitude' => '8.466278',
                    'outputFormat' => 'degree',
                    'cardinalPointsPosition' => 'before'
                ],
                'N 49.48711°, E 8.46628°'
            ],
            'view helper uses cardinal points position set to after correctly' => [
                [
                    'latitude' => '49.487111',
                    'longitude' => '8.466278',
                    'outputFormat' => 'degree',
                    'cardinalPointsPosition' => 'after'
                ],
                '49.48711° N, 8.46628° E'
            ],
        ];
    }

    /**
     * @test
     * @expectedException \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function renderThrowsViewHelperExceptionOnError()
    {
        (new CoordinateConverterViewHelper())->renderStatic(
            [
                'latitude' => '200',
                'longitude' => '8',
            ],
            function () {
            },
            $this->renderingContextMock
        );
    }
}
