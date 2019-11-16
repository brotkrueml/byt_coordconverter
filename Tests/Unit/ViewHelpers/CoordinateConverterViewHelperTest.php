<?php
declare(strict_types=1);

namespace Brotkrueml\BytCoordconverter\Tests\Unit\ViewHelpers;

/**
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Brotkrueml\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContext;

class CoordinateConverterViewHelperTest extends TestCase
{
    /**
     * @var CoordinateConverterViewHelper
     */
    private $subject;

    /**
     * @var RenderingContext
     */
    private $renderingContextMock;

    protected function setUp()
    {
        $this->subject = $this->createMock(CoordinateConverterViewHelper::class);
        $this->renderingContextMock = $this->createMock(RenderingContext::class);
    }

    /**
     * @test
     */
    public function argumentsAreRegisteredCorrectly()
    {
        /** @var MockObject|CoordinateConverterViewHelper $subject */
        $subject = $this->getMockBuilder(CoordinateConverterViewHelper::class)
            ->setMethods(['registerArgument'])
            ->getMock();

        $subject
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

        $subject->initializeArguments();
    }

    /**
     * @test
     */
    public function renderThrowsViewHelperExceptionWhenOnOutOfBoundsCoordinatesAreGiven()
    {
        $this->expectException(\TYPO3Fluid\Fluid\Core\ViewHelper\Exception::class);

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

    /**
     * @test
     */
    public function renderThrowsViewHelperExceptionWhenInvalidOutputFormatIsGiven()
    {
        $this->expectException(\TYPO3Fluid\Fluid\Core\ViewHelper\Exception::class);

        (new CoordinateConverterViewHelper())->renderStatic(
            [
                'latitude' => '49',
                'longitude' => '8',
                'outputFormat' => 'formatIsInvalid',
            ],
            function () {
            },
            $this->renderingContextMock
        );
    }

    /**
     * @test
     * @dataProvider dataProviderForFormatter
     *
     * @param array $arguments
     * @param string $expectedCoordinates
     */
    public function correctFormatterIsCalled(
        array $arguments,
        string $expectedCoordinates
    ) {
        $actualCoordinates = (new CoordinateConverterViewHelper())->renderStatic(
            $arguments,
            function () {
            },
            $this->renderingContextMock
        );

        $this->assertSame($expectedCoordinates, $actualCoordinates);
    }

    public function dataProviderForFormatter()
    {
        return [
            'degree' => [
                [
                    'latitude' => '-49.3',
                    'longitude' => '-8.4',
                    'outputFormat' => 'degree',
                ],
                'S 49.30000°, W 8.40000°',
            ],
            'degreeMinutes' => [
                [
                    'latitude' => '-49.3',
                    'longitude' => '-8.4',
                    'outputFormat' => 'degreeMinutes',
                ],
                'S 49° 18.00000\', W 8° 24.00000\'',
            ],
            'degreeMinutesSeconds' => [
                [
                    'latitude' => '-49.3',
                    'longitude' => '-8.4',
                    'outputFormat' => 'degreeMinutesSeconds',
                ],
                'S 49° 17\' 60.00000", W 8° 24\' 0.00000"',
            ],
            'UTM' => [
                [
                    'latitude' => '-49.3',
                    'longitude' => '-8.4',
                    'outputFormat' => 'UTM',
                ],
                '29F 543621 4539021',
            ],
        ];
    }
}
