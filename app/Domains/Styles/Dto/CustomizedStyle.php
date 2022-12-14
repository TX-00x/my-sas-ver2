<?php

declare(strict_types=1);

namespace App\Domains\Styles\Dto;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class CustomizedStyle extends DataTransferObject
{
    public ?int $id;
    public ?string $belongs_to;
    public ?string $code;
    public ?string $name;
    public ?string $styles_type;
    public ?Type $item_type;
    public ?string $description;
    public ?Customer $customer;
    public ?ParentStyle $parent_style;
    public ?string $style_image;
    public ?int $production_time;

    public ?string $status;

    /** @var \App\Domains\Styles\Dto\Category[] */
    #[CastWith(CategoryCaster::class)]
    public ?array $categories;

    /** @var \App\Domains\Styles\Dto\Size[] */
    #[CastWith(SizeCaster::class)]
    public ?array $sizes;

    /** @var \App\Domains\Styles\Dto\Factory[] */
    #[CastWith(FactoryCaster::class)]
    public ?array $factories;

    /** @var \App\Domains\Styles\Dto\Panel[] */
    #[CastWith(PanelCaster::class)]
    public ?array $panels;

    #[CastWith(EmbellishmentCaster::class)]
    public ?array $embellishments_form;

    /** @var \App\Domains\Styles\Dto\CustomizedPanel[] */
    #[CastWith(CustomizedPanelCaster::class)]
    public ?array $customized_panels;
}


