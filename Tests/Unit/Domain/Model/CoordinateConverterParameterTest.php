<?php

declare(strict_types=1);

/*
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\BytCoordconverter\Tests\Unit\Domain\Model;

use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter as Parameter;
use PHPUnit\Framework\TestCase;

final class CoordinateConverterParameterTest extends TestCase
{
    /**
     * @test
     */
    public function parameterLatitudeSetCorrectly(): void
    {
        $subject = new Parameter(
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ', ',
        );

        self::assertSame(49.487111, $subject->getLatitude());
    }

    /**
     * @test
     */
    public function parameterLongitudeSetCorrectly(): void
    {
        $subject = new Parameter(
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ', ',
        );

        self::assertSame(8.466278, $subject->getLongitude());
    }

    /**
     * @test
     */
    public function parameterOutputFormatSetCorrectly(): void
    {
        $allowedOutputFormats = [
            'degree',
            'degreeMinutes',
            'degreeMinutesSeconds',
            'UTM',
        ];

        foreach ($allowedOutputFormats as $outputFormat) {
            $subject = new Parameter(
                49.487111,
                8.466278,
                $outputFormat,
                'N|S|E|W',
                'before',
                5,
                false,
                ', ',
            );

            self::assertSame($outputFormat, $subject->getOutputFormat());
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
     */
    public function parameterCardinalPointsForLatitudeSetCorrectly(
        float $latitude,
        float $longitude,
        string $cardinalPoints,
        string $expectedNorthSouthValue,
    ): void {
        $subject = new Parameter(
            $latitude,
            $longitude,
            'degree',
            $cardinalPoints,
            'before',
            5,
            false,
            ', ',
        );

        self::assertSame($expectedNorthSouthValue, $subject->getCardinalPointForLatitude());
    }

    /**
     * @test
     */
    public function parameterCardinalPointsPositionSetCorrectly(): void
    {
        $allowedPositions = [
            'after',
            'before',
        ];

        foreach ($allowedPositions as $position) {
            $subject = new Parameter(
                49.487111,
                8.466278,
                'degree',
                'N|S|E|W',
                $position,
                5,
                false,
                ', ',
            );

            self::assertSame($position, $subject->getCardinalPointsPosition());
        }
    }

    /**
     * @test
     */
    public function parameterNumberOfDecimalsSetCorrectly(): void
    {
        $subject = new Parameter(
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            3,
            true,
            ', ',
        );

        self::assertSame(3, $subject->getNumberOfDecimals());
    }

    /**
     * @test
     */
    public function parameterShowTrailingZerosSetCorrectly(): void
    {
        $subject = new Parameter(
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            5,
            true,
            ', ',
        );

        self::assertTrue($subject->shouldTrailingZerosBeRemoved());

        $subject = new Parameter(
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ', ',
        );

        self::assertFalse($subject->shouldTrailingZerosBeRemoved());
    }

    /**
     * @test
     */
    public function parameterDelimiterZerosSetCorrectly(): void
    {
        $subject = new Parameter(
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ' / ',
        );

        self::assertSame(' / ', $subject->getDelimiter());
    }

    /**
     * @test
     * @dataProvider dataProviderForInvalidParameters
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
        int $expectedExceptionCode,
    ): void {
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
            $delimiter,
        );
    }

    public function dataProviderForInvalidParameters(): \Generator
    {
        yield 'latitude is too high' => [
            90.01,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ' / ',
            1562698303,
        ];

        yield 'latitude is too low' => [
            -90.01,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            5,
            false,
            ' / ',
            1562698303,
        ];

        yield 'longitude is too high' => [
            49.487111,
            180.01,
            'degree',
            'N|S|E|W',
            'before',
            5,
            true,
            ', ',
            1562698344,
        ];

        yield 'longitude is too low' => [
            49.487111,
            -180.01,
            'degree',
            'N|S|E|W',
            'before',
            5,
            true,
            ', ',
            1562698344,
        ];

        yield 'degree is invalid' => [
            49.487111,
            8.466278,
            'somethingElse',
            'N|S|E|W',
            'before',
            5,
            true,
            ', ',
            1562698411,
        ];

        yield 'cardinal points number is too low' => [
            49.487111,
            8.466278,
            'degree',
            'N|S|E',
            'before',
            5,
            true,
            ', ',
            1562698459,
        ];

        yield 'cardinal points number is too high' => [
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W|Z',
            'before',
            5,
            true,
            ', ',
            1562698459,
        ];

        yield 'cardinal points position is invalid' => [
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'middle',
            5,
            true,
            ', ',
            1562698511,
        ];

        yield 'number of decimals is negative' => [
            49.487111,
            8.466278,
            'degree',
            'N|S|E|W',
            'before',
            -5,
            true,
            ', ',
            1562698555,
        ];
    }
}
