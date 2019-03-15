<?php
declare(strict_types=1);

namespace Brotkrueml\BytCoordconverter\Domain\Model;

/**
 * This file is part of the "byt_coordconverter" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */
class CoordinateConverterParameter
{
    private $allowedOutputFormats = [
        'degree',
        'degreeMinutes',
        'degreeMinutesSeconds',
        'UTM',
    ];

    private $allowedCardinalPointsPositions = [
        'after',
        'before',
    ];

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var string
     */
    private $outputFormat;

    /**
     * @var array
     */
    private $cardinalPointsList;

    /**
     * @var string
     */
    private $cardinalPointsPosition;

    /**
     * @var int
     */
    private $numberOfDecimals;

    /**
     * @var bool
     */
    private $removeTrailingZeros;

    /**
     * @var string
     */
    private $delimiter;

    public function __construct(
        float $latitude,
        float $longitude,
        string $outputFormat,
        string $cardinalPoints = 'N|S|E|W',
        string $cardinalPointsPosition = 'before',
        int $numberOfDecimals = 5,
        bool $removeTrailingZeros = false,
        string $delimiter = ', '
    ) {
        $this
            ->setLatitude($latitude)
            ->setLongitude($longitude)
            ->setOutputFormat($outputFormat)
            ->setCardinalPoints($cardinalPoints)
            ->setCardinalPointsPosition($cardinalPointsPosition)
            ->setNumberOfDecimals($numberOfDecimals)
            ->setRemoveTrailingZeros($removeTrailingZeros)
            ->setDelimiter($delimiter);
    }

    protected function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        if (($this->latitude > 90.0) || ($this->latitude < -90.0)) {
            throw new \InvalidArgumentException(
                'Invalid latitude: must be a value between 90.0 and -90.0 (given: ' . $this->latitude . ')'
            );
        }

        return $this;
    }

    private function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        if (($this->longitude > 180.0) || ($this->longitude < -180.0)) {
            throw new \InvalidArgumentException(
                'Invalid longitude: must be a value between 180.0 and -180.0 (given: ' . $this->longitude . ')'
            );
        }

        return $this;
    }

    private function setOutputFormat(string $outputFormat): self
    {
        $this->outputFormat = $outputFormat;

        if (!in_array($this->outputFormat, $this->allowedOutputFormats)) {
            throw new \InvalidArgumentException(
                'Invalid output format: must be one of [' . implode(
                    '|',
                    $this->allowedOutputFormats
                ) . '] (given: ' . $this->longitude . ')'
            );
        }

        return $this;
    }

    private function setCardinalPoints(string $cardinalPoints): self
    {
        $this->cardinalPointsList = explode('|', $cardinalPoints);

        if (count($this->cardinalPointsList) !== 4) {
            throw new \InvalidArgumentException(
                'Invalid number of parameters for cardinal points: must be 4 (separated by |, given: ' . $cardinalPoints . ')'
            );
        }

        return $this;
    }

    private function setCardinalPointsPosition(string $cardinalPointsPosition): self
    {
        $this->cardinalPointsPosition = $cardinalPointsPosition;

        if (!in_array($this->cardinalPointsPosition, $this->allowedCardinalPointsPositions)) {
            throw new \InvalidArgumentException(
                'Invalid cardinal points position: must be one of [' . implode(
                    '|',
                    $this->allowedCardinalPointsPositions
                ) . '] (given: ' . $cardinalPointsPosition . ')'
            );
        }

        return $this;
    }

    private function setNumberOfDecimals(int $numberOfDecimals): self
    {
        $this->numberOfDecimals = $numberOfDecimals;

        if ($numberOfDecimals < 0) {
            throw new \InvalidArgumentException(
                'The number of decimals cannot be negative'
            );
        }

        return $this;
    }

    private function setRemoveTrailingZeros(bool $removeTrailingZeros): self
    {
        $this->removeTrailingZeros = $removeTrailingZeros;

        return $this;
    }

    private function setDelimiter(string $delimiter): self
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getOutputFormat(): string
    {
        return $this->outputFormat;
    }

    public function getCardinalPointForLatitude(): string
    {
        if ($this->latitude >= 0.0) {
            return $this->cardinalPointsList[0];
        }

        return $this->cardinalPointsList[1];
    }

    public function getCardinalPointForLongitude(): string
    {
        if ($this->longitude >= 0.0) {
            return $this->cardinalPointsList[2];
        }

        return $this->cardinalPointsList[3];
    }

    public function getCardinalPointsPosition(): string
    {
        return $this->cardinalPointsPosition;
    }

    public function getNumberOfDecimals(): int
    {
        return $this->numberOfDecimals;
    }

    public function shouldTrailingZerosBeRemoved(): bool
    {
        return $this->removeTrailingZeros;
    }

    public function getDelimiter(): string
    {
        return $this->delimiter;
    }
}
