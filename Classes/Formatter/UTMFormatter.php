<?php
declare(strict_types=1);

namespace Brotkrueml\BytCoordconverter\Formatter;

/**
 * This file is part of the "byt_coordconverter" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter;

class UTMFormatter implements FormatterInterface
{
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
     * The scaling factor of central meridian
     *
     * @var float
     */
    const SCALING_FACTOR = 0.9996;

    /** @var float */
    private $latitude;

    /** @var float */
    private $longitude;

    /** @var string */
    private $utmZone;

    /** @var int */
    private $longitudinalZone;

    /** @var float */
    private $eccentricity;

    /** @var float */
    private $eccentricityPrimeSquared;

    /** @var float */
    private $latitudeRad;

    /** @var float */
    private $longitudeRad;

    /** @var float */
    private $a;

    /** @var float */
    private $c;

    /** @var float */
    private $m;

    /** @var float */
    private $n;

    /** @var float */
    private $t;

    public function format(CoordinateConverterParameter $parameter): string
    {
        $this->latitude = $parameter->getLatitude();
        $this->longitude = $parameter->getLongitude();

        $this->utmZone = static::getLatitudinalZone($this->latitude);
        $this->longitudinalZone = $this->getLongitudinalZone($this->latitude, $this->longitude);

        return $this->getUtmFromLatitudeLongitude();
    }

    /**
     * Get the longitudinal zone
     * @see http://www.dmap.co.uk/utmworld.htm
     *
     * @param float $latitude
     * @param float $longitude
     * @return int
     */
    private function getLongitudinalZone(float $latitude, float $longitude): int
    {
        if (($latitude >= 56.0) && ($latitude < 64.0)
            && ($longitude >= 3.0) && ($longitude < 12.0)) {
            return 32;
        }

        // Special zones for Svalbard
        if (($latitude >= 72.0) && ($latitude < 84.0)) {
            if (($longitude >= 0.0) && ($longitude < 9.0)) {
                return 31;
            }

            if (($longitude >= 9.0) && ($longitude < 21.0)) {
                return 33;
            }

            if (($longitude >= 21.0) && ($longitude < 33.0)) {
                return 35;
            }

            if (($longitude >= 33.0) && ($longitude < 42.0)) {
                return 37;
            }
        }

        return (int)(($longitude + 180.0) / 6.0) + 1;
    }

    private function getLatitudinalZone(float $latitude): string
    {
        return 'CDEFGHJKLMNPQRSTUVWXX'[(int)(($latitude + 80) / 8)];
    }

    private function getUtmFromLatitudeLongitude(): string
    {
        $this->calculateInterimValues();

        $utmEasting =
            (double)(static::SCALING_FACTOR
                * $this->n
                * ($this->a
                    + (1 - $this->t + $this->c) * \pow($this->a, 3.0) / 6
                    + (5 - 18 * $this->t + $this->t * $this->t + 72 * $this->c - 58 * $this->eccentricityPrimeSquared)
                    * \pow($this->a, 5.0)
                    / 120)
                + 500000.0);

        $utmNorthing =
            (double)(static::SCALING_FACTOR
                * ($this->m
                    + $this->n
                    * \tan($this->latitudeRad)
                    * ($this->a * $this->a / 2
                        + (5 - $this->t + (9 * $this->c) + (4 * $this->c * $this->c)) * \pow($this->a, 4.0) / 24
                        + (61 - (58 * $this->t) + ($this->t * $this->t) + (600 * $this->c) - (330 * $this->eccentricityPrimeSquared))
                        * \pow($this->a, 6.0)
                        / 720)));

        // Adjust for the southern hemisphere
        if ($this->latitude < 0) {
            $utmNorthing += 10000000.0;
        }

        return $this->longitudinalZone . $this->utmZone . ' ' . \round($utmEasting) . ' ' . \round($utmNorthing);
    }

    private function calculateInterimValues()
    {
        $this->eccentricity = ((static::ELLIPSOID_MAJOR_AXIS * static::ELLIPSOID_MAJOR_AXIS) - (static::ELLIPSOID_MINOR_AXIS * static::ELLIPSOID_MINOR_AXIS)) / (static::ELLIPSOID_MAJOR_AXIS * static::ELLIPSOID_MAJOR_AXIS);
        $this->eccentricityPrimeSquared = ($this->eccentricity) / (1 - $this->eccentricity);

        $this->latitudeRad = $this->latitude * (\pi() / 180.0);
        $this->longitudeRad = $this->longitude * (\pi() / 180.0);

        $this->n = static::ELLIPSOID_MAJOR_AXIS / \sqrt(1 - $this->eccentricity * \sin($this->latitudeRad) * \sin($this->latitudeRad));
        $this->t = \tan($this->latitudeRad) * \tan($this->latitudeRad);
        $this->c = $this->eccentricityPrimeSquared * \cos($this->latitudeRad) * \cos($this->latitudeRad);

        $longitudeOrigin = ($this->longitudinalZone - 1) * 6 - 180 + 3;
        $longitudeOriginRad = $longitudeOrigin * (\pi() / 180.0);

        $this->a = \cos($this->latitudeRad) * ($this->longitudeRad - $longitudeOriginRad);

        $this->m =
            static::ELLIPSOID_MAJOR_AXIS
            * ((1
                    - $this->eccentricity / 4
                    - 3 * $this->eccentricity * $this->eccentricity / 64
                    - 5 * $this->eccentricity * $this->eccentricity * $this->eccentricity / 256)
                * $this->latitudeRad
                - (3 * $this->eccentricity / 8
                    + 3 * $this->eccentricity * $this->eccentricity / 32
                    + 45 * $this->eccentricity * $this->eccentricity * $this->eccentricity / 1024)
                * \sin(2 * $this->latitudeRad)
                + (15 * $this->eccentricity * $this->eccentricity / 256
                    + 45 * $this->eccentricity * $this->eccentricity * $this->eccentricity / 1024)
                * \sin(4 * $this->latitudeRad)
                - (35 * $this->eccentricity * $this->eccentricity * $this->eccentricity / 3072)
                * \sin(6 * $this->latitudeRad));
    }
}
