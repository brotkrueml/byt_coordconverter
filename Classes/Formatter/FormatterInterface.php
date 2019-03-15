<?php
declare(strict_types=1);

namespace Brotkrueml\BytCoordconverter\Formatter;

use Brotkrueml\BytCoordconverter\Domain\Model\CoordinateConverterParameter;

interface FormatterInterface
{
    public function format(CoordinateConverterParameter $parameter): string;
}