<?php

namespace App\Domains\Styles\Dto;

use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

class Embellishments extends DataTransferObject
{
    public ?int $id;
    public ?array $type;
    public ?string $position;
    public ?string $image_url;
    public ?UploadedFile $image;
    public ?Bool $already_uploaded;
}

