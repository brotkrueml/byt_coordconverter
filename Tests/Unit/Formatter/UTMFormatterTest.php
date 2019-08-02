<?php
declare(strict_types = 1);

namespace Brotkrueml\BytCoordconverter\Formatter;

/**
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter;
use PHPUnit\Framework\TestCase;

class UTMFormatterTest extends TestCase
{
    /** @var UTMFormatter */
    private $subject;

    public function setUp()
    {
        $this->subject = new UTMFormatter();
    }

    /**
     * @test
     * @dataProvider dataProviderForLongitudinalZone
     *
     * @param float $north
     * @param float $south
     * @param float $east
     * @param float $west
     * @param string $expectedZone
     */
    public function longitudinalZoneIsCorrectlyCalculated(
        float $north,
        float $south,
        float $east,
        float $west,
        string $expectedZone
    ) {
        $northWestParameter = new CoordinateConverterParameter($north, $west, 'UTM');
        $southEastParameter = new CoordinateConverterParameter($south, $east, 'UTM');

        $this->assertStringStartsWith($expectedZone, $this->subject->format($northWestParameter));
        $this->assertStringStartsWith($expectedZone, $this->subject->format($southEastParameter));
    }

    public function dataProviderForLongitudinalZone(): array
    {
        return [
            'zone 1' => [0.0, 0.0, -180.0, -174.0001, '1'],
            'zone 2' => [0.0, 0.0, -174.0, -168.0001, '2'],
            'zone 3' => [0.0, 0.0, -168.0, -162.0001, '3'],
            'zone 4' => [0.0, 0.0, -162.0, -156.0001, '4'],
            'zone 5' => [0.0, 0.0, -156.0, -150.0001, '5'],
            'zone 6' => [0.0, 0.0, -150.0, -144.0001, '6'],
            'zone 7' => [0.0, 0.0, -144.0, -138.0001, '7'],
            'zone 8' => [0.0, 0.0, -138.0, -132.0001, '8'],
            'zone 9' => [0.0, 0.0, -132.0, -126.0001, '9'],
            'zone 10' => [0.0, 0.0, -126.0, -120.0001, '10'],
            'zone 11' => [0.0, 0.0, -120.0, -114.0001, '11'],
            'zone 12' => [0.0, 0.0, -114.0, -108.0001, '12'],
            'zone 13' => [0.0, 0.0, -108.0, -102.0001, '13'],
            'zone 14' => [0.0, 0.0, -102.0, -96.0001, '14'],
            'zone 15' => [0.0, 0.0, -96.0, -90.0001, '15'],
            'zone 16' => [0.0, 0.0, -90.0, -84.0001, '16'],
            'zone 17' => [0.0, 0.0, -84.0, -78.0001, '17'],
            'zone 18' => [0.0, 0.0, -78.0, -72.0001, '18'],
            'zone 19' => [0.0, 0.0, -72.0, -66.0001, '19'],
            'zone 20' => [0.0, 0.0, -66.0, -60.0001, '20'],
            'zone 21' => [0.0, 0.0, -60.0, -54.0001, '21'],
            'zone 22' => [0.0, 0.0, -54.0, -48.0001, '22'],
            'zone 23' => [0.0, 0.0, -48.0, -42.0001, '23'],
            'zone 24' => [0.0, 0.0, -42.0, -36.0001, '24'],
            'zone 25' => [0.0, 0.0, -36.0, -30.0001, '25'],
            'zone 26' => [0.0, 0.0, -30.0, -24.0001, '26'],
            'zone 27' => [0.0, 0.0, -24.0, -18.0001, '27'],
            'zone 28' => [0.0, 0.0, -18.0, -12.0001, '28'],
            'zone 29' => [0.0, 0.0, -12.0, -6.0001, '29'],
            'zone 30' => [0.0, 0.0, -6.0, -0.0001, '30'],
            'zone 31' => [0.0, 0.0, 0.0, 5.9999, '31'],
            'zone 32' => [0.0, 0.0, 6.0, 11.9999, '32'],
            'zone 33' => [0.0, 0.0, 12.0, 17.9999, '33'],
            'zone 34' => [0.0, 0.0, 18.0, 23.9999, '34'],
            'zone 35' => [0.0, 0.0, 24.0, 29.9999, '35'],
            'zone 36' => [0.0, 0.0, 30.0, 35.9999, '36'],
            'zone 37' => [0.0, 0.0, 36.0, 41.9999, '37'],
            'zone 38' => [0.0, 0.0, 42.0, 47.9999, '38'],
            'zone 39' => [0.0, 0.0, 48.0, 53.9999, '39'],
            'zone 40' => [0.0, 0.0, 54.0, 59.9999, '40'],
            'zone 41' => [0.0, 0.0, 60.0, 65.9999, '41'],
            'zone 42' => [0.0, 0.0, 66.0, 71.9999, '42'],
            'zone 43' => [0.0, 0.0, 72.0, 77.9999, '43'],
            'zone 44' => [0.0, 0.0, 78.0, 83.9999, '44'],
            'zone 45' => [0.0, 0.0, 84.0, 89.9999, '45'],
            'zone 46' => [0.0, 0.0, 90.0, 95.9999, '46'],
            'zone 47' => [0.0, 0.0, 96.0, 101.9999, '47'],
            'zone 48' => [0.0, 0.0, 102.0, 107.9999, '48'],
            'zone 49' => [0.0, 0.0, 108.0, 113.9999, '49'],
            'zone 50' => [0.0, 0.0, 114.0, 119.9999, '50'],
            'zone 51' => [0.0, 0.0, 120.0, 125.9999, '51'],
            'zone 52' => [0.0, 0.0, 126.0, 131.9999, '52'],
            'zone 53' => [0.0, 0.0, 132.0, 137.9999, '53'],
            'zone 54' => [0.0, 0.0, 138.0, 143.9999, '54'],
            'zone 55' => [0.0, 0.0, 144.0, 149.9999, '55'],
            'zone 56' => [0.0, 0.0, 150.0, 155.9999, '56'],
            'zone 57' => [0.0, 0.0, 156.0, 161.9999, '57'],
            'zone 58' => [0.0, 0.0, 162.0, 167.9999, '58'],
            'zone 59' => [0.0, 0.0, 168.0, 173.9999, '59'],
            'zone 60' => [0.0, 0.0, 174.0, 179.9999, '60'],

            'zone 31 (exception for norway)' => [63.9999, 56.0, 0.0, 2.9999, '31'],
            'zone 32 (exception for norway)' => [63.9999, 56.0, 3.0, 11.9999, '32'],

            'zone 31 (exception for svalbard)' => [83.9999, 72.0, 0.0, 8.9999, '31'],
            'zone 33 (exception for svalbard)' => [83.9999, 72.0, 9.0, 20.9999, '33'],
            'zone 35 (exception for svalbard)' => [83.9999, 72.0, 21.0, 32.9999, '35'],
            'zone 37 (exception for svalbard)' => [83.9999, 72.0, 33.0, 41.9999, '37'],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderForLatitudinalZone
     *
     * @param float $north
     * @param float $south
     * @param string $expectedZone
     */
    public function latitudinalZoneIsCorrectlyCalculated(float $north, float $south, string $expectedZone)
    {
        $northParameter = new CoordinateConverterParameter($north, 0.0, 'UTM');
        $southParameter = new CoordinateConverterParameter($south, 0.0, 'UTM');

        $this->assertContains($expectedZone . ' ', $this->subject->format($northParameter));
        $this->assertContains($expectedZone . ' ', $this->subject->format($southParameter));
    }

    public function dataProviderForLatitudinalZone(): array
    {
        return [
            'zone c' => [-72.0001, -80.0, 'C'],
            'zone d' => [-64.0001, -72.0, 'D'],
            'zone e' => [-56.0001, -64.0, 'E'],
            'zone f' => [-48.0001, -56.0, 'F'],
            'zone g' => [-40.0001, -48.0, 'G'],
            'zone h' => [-32.0001, -40.0, 'H'],
            'zone j' => [-24.0001, -32.0, 'J'],
            'zone k' => [-16.0001, -24.0, 'K'],
            'zone l' => [-8.0001, -16.0, 'L'],
            'zone m' => [-0.0001, -8.0, 'M'],
            'zone n' => [7.9999, 0.0, 'N'],
            'zone p' => [15.9999, 8.0, 'P'],
            'zone q' => [23.9999, 16.0, 'Q'],
            'zone r' => [31.9999, 24.0, 'R'],
            'zone s' => [39.9999, 32.0, 'S'],
            'zone t' => [47.9999, 40.0, 'T'],
            'zone u' => [55.9999, 48.0, 'U'],
            'zone v' => [63.9999, 56.0, 'V'],
            'zone w' => [71.9999, 64.0, 'W'],
            'zone x' => [84.0, 72.0, 'X'],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderForSomeCoordinates
     *
     * @param float $latitude
     * @param float $longitude
     * @param $expectedCoordinates
     */
    public function someCoordinates(float $latitude, float $longitude, $expectedCoordinates)
    {
        $parameter = new CoordinateConverterParameter($latitude, $longitude, 'UTM');

        $this->assertSame($expectedCoordinates, $this->subject->format($parameter));
    }

    public function dataProviderForSomeCoordinates()
    {
        return [
            'paradeplatz, mannheim' => [49.487111, 8.466278, '32U 461344 5481745'],
            'empire state building, new york' => [40.748440, -73.984559, '18T 585725 4511328'],
            'statue of christ, rio de janeiro' => [-22.951910, -43.210790, '23K 683447 7460687'],
            'ayers rock, australia' => [-25.345200, 131.032400, '52J 704540 7195275'],
        ];
    }
}
