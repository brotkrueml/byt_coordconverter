<?php

declare(strict_types=1);

/*
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\BytCoordconverter\Tests\Unit\Formatter;

use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter;
use Brotkrueml\BytCoordconverter\Formatter\UTMFormatter;
use PHPUnit\Framework\TestCase;

final class UTMFormatterTest extends TestCase
{
    private UTMFormatter $subject;

    protected function setUp(): void
    {
        $this->subject = new UTMFormatter();
    }

    /**
     * @test
     * @dataProvider dataProviderForLongitudinalZone
     */
    public function longitudinalZoneIsCorrectlyCalculated(
        float $north,
        float $south,
        float $east,
        float $west,
        string $expectedZone
    ): void {
        $northWestParameter = new CoordinateConverterParameter($north, $west, 'UTM');
        $southEastParameter = new CoordinateConverterParameter($south, $east, 'UTM');

        self::assertStringStartsWith($expectedZone, $this->subject->format($northWestParameter));
        self::assertStringStartsWith($expectedZone, $this->subject->format($southEastParameter));
    }

    public function dataProviderForLongitudinalZone(): \Generator
    {
        yield 'zone 1' => [0.0, 0.0, -180.0, -174.0001, '1'];
        yield 'zone 2' => [0.0, 0.0, -174.0, -168.0001, '2'];
        yield 'zone 3' => [0.0, 0.0, -168.0, -162.0001, '3'];
        yield 'zone 4' => [0.0, 0.0, -162.0, -156.0001, '4'];
        yield 'zone 5' => [0.0, 0.0, -156.0, -150.0001, '5'];
        yield 'zone 6' => [0.0, 0.0, -150.0, -144.0001, '6'];
        yield 'zone 7' => [0.0, 0.0, -144.0, -138.0001, '7'];
        yield 'zone 8' => [0.0, 0.0, -138.0, -132.0001, '8'];
        yield 'zone 9' => [0.0, 0.0, -132.0, -126.0001, '9'];
        yield 'zone 10' => [0.0, 0.0, -126.0, -120.0001, '10'];
        yield 'zone 11' => [0.0, 0.0, -120.0, -114.0001, '11'];
        yield 'zone 12' => [0.0, 0.0, -114.0, -108.0001, '12'];
        yield 'zone 13' => [0.0, 0.0, -108.0, -102.0001, '13'];
        yield 'zone 14' => [0.0, 0.0, -102.0, -96.0001, '14'];
        yield 'zone 15' => [0.0, 0.0, -96.0, -90.0001, '15'];
        yield 'zone 16' => [0.0, 0.0, -90.0, -84.0001, '16'];
        yield 'zone 17' => [0.0, 0.0, -84.0, -78.0001, '17'];
        yield 'zone 18' => [0.0, 0.0, -78.0, -72.0001, '18'];
        yield 'zone 19' => [0.0, 0.0, -72.0, -66.0001, '19'];
        yield 'zone 20' => [0.0, 0.0, -66.0, -60.0001, '20'];
        yield 'zone 21' => [0.0, 0.0, -60.0, -54.0001, '21'];
        yield 'zone 22' => [0.0, 0.0, -54.0, -48.0001, '22'];
        yield 'zone 23' => [0.0, 0.0, -48.0, -42.0001, '23'];
        yield 'zone 24' => [0.0, 0.0, -42.0, -36.0001, '24'];
        yield 'zone 25' => [0.0, 0.0, -36.0, -30.0001, '25'];
        yield 'zone 26' => [0.0, 0.0, -30.0, -24.0001, '26'];
        yield 'zone 27' => [0.0, 0.0, -24.0, -18.0001, '27'];
        yield 'zone 28' => [0.0, 0.0, -18.0, -12.0001, '28'];
        yield 'zone 29' => [0.0, 0.0, -12.0, -6.0001, '29'];
        yield 'zone 30' => [0.0, 0.0, -6.0, -0.0001, '30'];
        yield 'zone 31' => [0.0, 0.0, 0.0, 5.9999, '31'];
        yield 'zone 32' => [0.0, 0.0, 6.0, 11.9999, '32'];
        yield 'zone 33' => [0.0, 0.0, 12.0, 17.9999, '33'];
        yield 'zone 34' => [0.0, 0.0, 18.0, 23.9999, '34'];
        yield 'zone 35' => [0.0, 0.0, 24.0, 29.9999, '35'];
        yield 'zone 36' => [0.0, 0.0, 30.0, 35.9999, '36'];
        yield 'zone 37' => [0.0, 0.0, 36.0, 41.9999, '37'];
        yield 'zone 38' => [0.0, 0.0, 42.0, 47.9999, '38'];
        yield 'zone 39' => [0.0, 0.0, 48.0, 53.9999, '39'];
        yield 'zone 40' => [0.0, 0.0, 54.0, 59.9999, '40'];
        yield 'zone 41' => [0.0, 0.0, 60.0, 65.9999, '41'];
        yield 'zone 42' => [0.0, 0.0, 66.0, 71.9999, '42'];
        yield 'zone 43' => [0.0, 0.0, 72.0, 77.9999, '43'];
        yield 'zone 44' => [0.0, 0.0, 78.0, 83.9999, '44'];
        yield 'zone 45' => [0.0, 0.0, 84.0, 89.9999, '45'];
        yield 'zone 46' => [0.0, 0.0, 90.0, 95.9999, '46'];
        yield 'zone 47' => [0.0, 0.0, 96.0, 101.9999, '47'];
        yield 'zone 48' => [0.0, 0.0, 102.0, 107.9999, '48'];
        yield 'zone 49' => [0.0, 0.0, 108.0, 113.9999, '49'];
        yield 'zone 50' => [0.0, 0.0, 114.0, 119.9999, '50'];
        yield 'zone 51' => [0.0, 0.0, 120.0, 125.9999, '51'];
        yield 'zone 52' => [0.0, 0.0, 126.0, 131.9999, '52'];
        yield 'zone 53' => [0.0, 0.0, 132.0, 137.9999, '53'];
        yield 'zone 54' => [0.0, 0.0, 138.0, 143.9999, '54'];
        yield 'zone 55' => [0.0, 0.0, 144.0, 149.9999, '55'];
        yield 'zone 56' => [0.0, 0.0, 150.0, 155.9999, '56'];
        yield 'zone 57' => [0.0, 0.0, 156.0, 161.9999, '57'];
        yield 'zone 58' => [0.0, 0.0, 162.0, 167.9999, '58'];
        yield 'zone 59' => [0.0, 0.0, 168.0, 173.9999, '59'];
        yield 'zone 60' => [0.0, 0.0, 174.0, 179.9999, '60'];

        yield 'zone 31 (exception for norway)' => [63.9999, 56.0, 0.0, 2.9999, '31'];
        yield 'zone 32 (exception for norway)' => [63.9999, 56.0, 3.0, 11.9999, '32'];

        yield 'zone 31 (exception for svalbard)' => [83.9999, 72.0, 0.0, 8.9999, '31'];
        yield 'zone 33 (exception for svalbard)' => [83.9999, 72.0, 9.0, 20.9999, '33'];
        yield 'zone 35 (exception for svalbard)' => [83.9999, 72.0, 21.0, 32.9999, '35'];
        yield 'zone 37 (exception for svalbard)' => [83.9999, 72.0, 33.0, 41.9999, '37'];
    }

    /**
     * @test
     * @dataProvider dataProviderForLatitudinalZone
     */
    public function latitudinalZoneIsCorrectlyCalculated(float $north, float $south, string $expectedZone): void
    {
        $northParameter = new CoordinateConverterParameter($north, 0.0, 'UTM');
        $southParameter = new CoordinateConverterParameter($south, 0.0, 'UTM');

        self::assertStringContainsString($expectedZone . ' ', $this->subject->format($northParameter));
        self::assertStringContainsString($expectedZone . ' ', $this->subject->format($southParameter));
    }

    public function dataProviderForLatitudinalZone(): \Generator
    {
        yield 'zone c' => [-72.0001, -80.0, 'C'];
        yield 'zone d' => [-64.0001, -72.0, 'D'];
        yield 'zone e' => [-56.0001, -64.0, 'E'];
        yield 'zone f' => [-48.0001, -56.0, 'F'];
        yield 'zone g' => [-40.0001, -48.0, 'G'];
        yield 'zone h' => [-32.0001, -40.0, 'H'];
        yield 'zone j' => [-24.0001, -32.0, 'J'];
        yield 'zone k' => [-16.0001, -24.0, 'K'];
        yield 'zone l' => [-8.0001, -16.0, 'L'];
        yield 'zone m' => [-0.0001, -8.0, 'M'];
        yield 'zone n' => [7.9999, 0.0, 'N'];
        yield 'zone p' => [15.9999, 8.0, 'P'];
        yield 'zone q' => [23.9999, 16.0, 'Q'];
        yield 'zone r' => [31.9999, 24.0, 'R'];
        yield 'zone s' => [39.9999, 32.0, 'S'];
        yield 'zone t' => [47.9999, 40.0, 'T'];
        yield 'zone u' => [55.9999, 48.0, 'U'];
        yield 'zone v' => [63.9999, 56.0, 'V'];
        yield 'zone w' => [71.9999, 64.0, 'W'];
        yield 'zone x' => [84.0, 72.0, 'X'];
    }

    /**
     * @test
     * @dataProvider dataProviderForSomeCoordinates
     *
     * @param $expectedCoordinates
     */
    public function someCoordinates(float $latitude, float $longitude, string $expectedCoordinates): void
    {
        $parameter = new CoordinateConverterParameter($latitude, $longitude, 'UTM');

        self::assertSame($expectedCoordinates, $this->subject->format($parameter));
    }

    public function dataProviderForSomeCoordinates(): \Generator
    {
        yield 'paradeplatz, mannheim' => [49.487111, 8.466278, '32U 461344 5481745'];
        yield 'empire state building, new york' => [40.748440, -73.984559, '18T 585725 4511328'];
        yield 'statue of christ, rio de janeiro' => [-22.951910, -43.210790, '23K 683447 7460687'];
        yield 'ayers rock, australia' => [-25.345200, 131.032400, '52J 704540 7195275'];
    }
}
