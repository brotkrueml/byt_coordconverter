<?php

declare(strict_types=1);

/*
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\BytCoordconverter\Tests\Unit\ViewHelpers;

use Brotkrueml\BytCoordconverter\ViewHelpers\CoordinateConverterViewHelper;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CoordinateConverterViewHelperTest extends TestCase
{
    /**
     * @test
     */
    public function argumentsAreRegisteredCorrectly(): void
    {
        /** @var MockObject|CoordinateConverterViewHelper $subject */
        $subject = $this->getMockBuilder(CoordinateConverterViewHelper::class)
            ->onlyMethods(['registerArgument'])
            ->getMock();

        $subject
            ->expects(self::exactly(8))
            ->method('registerArgument')
            ->withConsecutive(
                [
                    'latitude',
                    'string',
                    self::anything(),
                    true,
                ],
                [
                    'longitude',
                    'string',
                    self::anything(),
                    true,
                ],
                [
                    'outputFormat',
                    'string',
                    self::anything(),
                    false,
                    'degree',
                ],
                [
                    'cardinalPoints',
                    'string',
                    self::anything(),
                    false,
                    'N|S|E|W',
                ],
                [
                    'cardinalPointsPosition',
                    'string',
                    self::anything(),
                    false,
                    'before',
                ],
                [
                    'numberOfDecimals',
                    'int',
                    self::anything(),
                    false,
                    5,
                ],
                [
                    'removeTrailingZeros',
                    'bool',
                    self::anything(),
                    false,
                    false,
                ],
                [
                    'delimiter',
                    'string',
                    self::anything(),
                    false,
                    ', ',
                ],
            );

        $subject->initializeArguments();
    }

    /**
     * @test
     */
    public function renderThrowsViewHelperExceptionWhenOnOutOfBoundsCoordinatesAreGiven(): void
    {
        $this->expectException(\TYPO3Fluid\Fluid\Core\ViewHelper\Exception::class);

        $subject = new CoordinateConverterViewHelper();
        $subject->setArguments([
            'latitude' => '200',
            'longitude' => '8',
        ]);
        $subject->render();
    }

    /**
     * @test
     */
    public function renderThrowsViewHelperExceptionWhenInvalidOutputFormatIsGiven(): void
    {
        $this->expectException(\TYPO3Fluid\Fluid\Core\ViewHelper\Exception::class);

        $subject = new CoordinateConverterViewHelper();
        $subject->setArguments([
            'latitude' => '49',
            'longitude' => '8',
            'outputFormat' => 'formatIsInvalid',
        ]);
        $subject->render();
    }

    /**
     * @test
     * @dataProvider dataProviderForFormatter
     */
    public function correctFormatterIsCalled(
        array $arguments,
        string $expectedCoordinates,
    ): void {
        $subject = new CoordinateConverterViewHelper();
        $subject->setArguments($arguments);

        $actualCoordinates = $subject->render();

        self::assertSame($expectedCoordinates, $actualCoordinates);
    }

    public function dataProviderForFormatter(): iterable
    {
        yield 'degree' => [
            [
                'latitude' => '-49.3',
                'longitude' => '-8.4',
                'outputFormat' => 'degree',
            ],
            'S 49.30000°, W 8.40000°',
        ];

        yield 'degreeMinutes' => [
            [
                'latitude' => '-49.3',
                'longitude' => '-8.4',
                'outputFormat' => 'degreeMinutes',
            ],
            'S 49° 18.00000\', W 8° 24.00000\'',
        ];

        yield 'degreeMinutesSeconds' => [
            [
                'latitude' => '-49.3',
                'longitude' => '-8.4',
                'outputFormat' => 'degreeMinutesSeconds',
            ],
            'S 49° 17\' 60.00000", W 8° 24\' 0.00000"',
        ];

        yield 'UTM' => [
            [
                'latitude' => '-49.3',
                'longitude' => '-8.4',
                'outputFormat' => 'UTM',
            ],
            '29F 543621 4539021',
        ];
    }
}
