<?php
namespace Byterror\BytCoordconverter\Utility;

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


/**
 * Utility functions for converting in UTM
 *
 * Based on PHPcoord by Jonathan Stott (http://www.jstott.me.uk/phpcoord/)
 *
 * @author Chris Müller <byt3error@web.de>
 * @package Byt_coordconverter
 * @subpackage ViewHelpers\CoordConverter
 */
class UtmUtility {

    /**
     * The major (equitorial) axis
     *
     * @var float
     */
    const ELLIPSOID_MAJOR_AXIS = 6378137.0;


    /**
     * The minor (equitorial) axis
     *
     * @var float
     */
    const ELLIPSOID_MINOR_AXIS = 6356752.314;


    /**
     * The scaling factor
     *
     * @var float
     */
    const SCALING_FACTOR = 0.9996;


    /**
     * Get the UTM notation from latitude/longitude
     *
     * @param float $latitude
     * @param float $longitude
     * @return string
     */
    public static function getUtmFromLatitudeLongitude($latitude, $longitude) {
        $eccentricity = UtmUtility::getEccentricityOfReferenceEllipsoid();

        $latitudeRad = $latitudeRad = $latitude * (pi() / 180.0);
        $longitudeRad = $longitude * (pi() / 180.0);

        $longitudinalZone = UtmUtility::getLongitudinalZone($latitude, $longitude);

        $longitudeOrigin = ($longitudinalZone - 1) * 6 - 180 + 3;
        $longitudeOriginRad = $longitudeOrigin * (pi() / 180.0);

        $utmZone = UtmUtility::getLatitudinalZone($latitude);

        $eccentricityPrimeSquared = ($eccentricity) / (1 - $eccentricity);

        $n = UtmUtility::ELLIPSOID_MAJOR_AXIS / sqrt(1 - $eccentricity * sin($latitudeRad) * sin($latitudeRad));
        $t = tan($latitudeRad) * tan($latitudeRad);
        $c = $eccentricityPrimeSquared * cos($latitudeRad) * cos($latitudeRad);
        $A = cos($latitudeRad) * ($longitudeRad - $longitudeOriginRad);

        $M =
            UtmUtility::ELLIPSOID_MAJOR_AXIS
            * ((1
                    - $eccentricity / 4
                    - 3 * $eccentricity * $eccentricity / 64
                    - 5 * $eccentricity * $eccentricity * $eccentricity / 256)
                * $latitudeRad
                - (3 * $eccentricity / 8
                    + 3 * $eccentricity * $eccentricity / 32
                    + 45 * $eccentricity * $eccentricity * $eccentricity / 1024)
                * sin(2 * $latitudeRad)
                + (15 * $eccentricity * $eccentricity / 256
                    + 45 * $eccentricity * $eccentricity * $eccentricity / 1024)
                * sin(4 * $latitudeRad)
                - (35 * $eccentricity * $eccentricity * $eccentricity / 3072)
                * sin(6 * $latitudeRad));

        $utmEasting =
            (double) (UtmUtility::SCALING_FACTOR
                * $n
                * ($A
                    + (1 - $t + $c) * pow($A, 3.0) / 6
                    + (5 - 18 * $t + $t * $t + 72 * $c - 58 * $eccentricityPrimeSquared)
                    * pow($A, 5.0)
                    / 120)
                + 500000.0);

        $utmNorthing =
            (double) (UtmUtility::SCALING_FACTOR
                * ($M
                    + $n
                    * tan($latitudeRad)
                    * ($A * $A / 2
                        + (5 - $t + (9 * $c) + (4 * $c * $c)) * pow($A, 4.0) / 24
                        + (61 - (58 * $t) + ($t * $t) + (600 * $c) - (330 * $eccentricityPrimeSquared))
                        * pow($A, 6.0)
                        / 720)));

        // Adjust for the southern hemisphere
        if ($latitude < 0) {
            $utmNorthing += 10000000.0;
        }

        return $longitudinalZone . $utmZone . ' ' . round($utmEasting) . ' ' . round($utmNorthing);
    }


    /**
     * Get the eccentricity of the reference ellipsoid
     *
     * @return float
     */
    public static function getEccentricityOfReferenceEllipsoid() {
        return ((self::ELLIPSOID_MAJOR_AXIS * self::ELLIPSOID_MAJOR_AXIS) - (self::ELLIPSOID_MINOR_AXIS * self::ELLIPSOID_MINOR_AXIS)) / (self::ELLIPSOID_MAJOR_AXIS * self::ELLIPSOID_MAJOR_AXIS);
    }


    /**
     * Get the longitudinal zone
     * @see http://www.dmap.co.uk/utmworld.htm
     *
     * @param float $latitude
     * @param float $longitude
     * @return int
     */
    public static function getLongitudinalZone($latitude, $longitude) {
        $longitudeZone = (int) (($longitude + 180.0) / 6.0) + 1;

        if (($latitude >= 56.0) && ($latitude < 64.0)
            && ($longitude >= 3.0) && ($longitude < 12.0)) {
            $longitudeZone = 32;
        }

        // Special zones for Svalbard
        if (($latitude >= 72.0) && ($latitude < 84.0)) {
            if (($longitude >= 0.0) && ($longitude < 9.0)) {
                $longitudeZone = 31;
            } else if (($longitude >= 9.0) && ($longitude < 21.0)) {
                $longitudeZone = 33;
            } else if (($longitude >= 21.0) && ($longitude < 33.0)) {
                $longitudeZone = 35;
            } else if (($longitude >= 33.0) && ($longitude < 42.0)) {
                $longitudeZone = 37;
            }
        }

        return $longitudeZone;
    }



    /**
     *  Work out the UTM latitudinal zone from the latitude
     *
     * @param latitude
     * @return string
     */
    public static function getLatitudinalZone($latitude) {
        if ((84 >= $latitude) && ($latitude >= 72)) {
            return 'X';
        } else if ((72 > $latitude) && ($latitude >= 64)) {
            return 'W';
        } else if ((64 > $latitude) && ($latitude >= 56)) {
            return 'V';
        } else if ((56 > $latitude) && ($latitude >= 48)) {
            return 'U';
        } else if ((48 > $latitude) && ($latitude >= 40)) {
            return 'T';
        } else if ((40 > $latitude) && ($latitude >= 32)) {
            return 'S';
        } else if ((32 > $latitude) && ($latitude >= 24)) {
            return 'R';
        } else if ((24 > $latitude) && ($latitude >= 16)) {
            return 'Q';
        } else if ((16 > $latitude) && ($latitude >= 8)) {
            return 'P';
        } else if ((8 > $latitude) && ($latitude >= 0)) {
            return 'N';
        } else if ((0 > $latitude) && ($latitude >=  -8)) {
            return 'M';
        } else if ((-8 > $latitude) && ($latitude >= -16)) {
            return 'L';
        } else if ((-16 > $latitude) && ($latitude >= -24)) {
            return 'K';
        } else if ((-24 > $latitude) && ($latitude >= -32)) {
            return 'J';
        } else if ((-32 > $latitude) && ($latitude >= -40)) {
            return 'H';
        } else if ((-40 > $latitude) && ($latitude >= -48)) {
            return 'G';
        } else if ((-48 > $latitude) && ($latitude >= -56)) {
            return 'F';
        } else if ((-56 > $latitude) && ($latitude >= -64)) {
            return 'E';
        } else if ((-64 > $latitude) && ($latitude >= -72)) {
            return 'D';
        } else if ((-72 > $latitude) && ($latitude >= -80)) {
            return 'C';
        }

        return 'Z';
    }
}