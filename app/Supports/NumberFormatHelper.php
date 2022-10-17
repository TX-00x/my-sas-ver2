<?php
declare(strict_types=1);

namespace App\Supports;

trait NumberFormatHelper
{
    private function floatWith2DecimalPoints($number): string
    {
        return number_format((float) $number, 2, '.', '');
    }
}
