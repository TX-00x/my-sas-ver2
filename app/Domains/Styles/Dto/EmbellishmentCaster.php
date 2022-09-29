<?php

namespace App\Domains\Styles\Dto;

use Exception;
use Spatie\DataTransferObject\Caster;

class EmbellishmentCaster implements Caster
{

    public function cast(mixed $value): mixed
    {
        if (! is_array($value)) {
            throw new Exception("Can only cast arrays to Embellishments");
        }

        return array_map(function (array $data) {
            return new Embellishments($data);
        }, $value);
    }
}
