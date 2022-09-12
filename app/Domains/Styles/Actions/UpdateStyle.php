<?php
declare(strict_types=1);

namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\CustomizedStyle;
use App\Models\EmbellishmentStyle;
use App\Models\Style as StyleModel;

class UpdateStyle
{
    private AttachSizeToStyle $attachSizeToStyle;
    private AttachCategoryToStyle $attachCategoryToStyle;
    private AttachFactoriesToStyle $attachFactoriesToStyle;
    private AttachPanelToStyle $attachPanelToStyle;

    public function __construct(
        AttachSizeToStyle      $attachSizeToStyle,
        AttachCategoryToStyle  $attachCategoryToStyle,
        AttachFactoriesToStyle $attachFactoriesToStyle,
        AttachPanelToStyle     $attachPanelToStyle,
    )
    {
        $this->attachSizeToStyle = $attachSizeToStyle;
        $this->attachCategoryToStyle = $attachCategoryToStyle;
        $this->attachFactoriesToStyle = $attachFactoriesToStyle;
        $this->attachPanelToStyle = $attachPanelToStyle;
    }

    public function execute(StyleModel $style, CustomizedStyle $styleDto): StyleModel
    {
        /** @var StyleModel $style */
        $style->update([
            'code' => $styleDto->code,
            'name' => $styleDto->name,
            'production_time' => $styleDto->production_time,
            'item_type_id' => $styleDto->item_type->id,
            'styles_type' => $styleDto->styles_type,
            'description' => $styleDto->description,
            'belongs_to' => $styleDto->belongs_to,
            'status' => $styleDto->status,
            'customer_id' => optional($styleDto->customer)->id,
            'parent_style_id' => optional($styleDto->parent_style)->id
        ]);


        if ($styleDto->style_image) {
            $style->update(
                ['style_image' => $styleDto->style_image]
            );
        }

        foreach ($styleDto->sizes as $size) {
            $this->attachSizeToStyle->execute($style, $size);
        }

        foreach ($styleDto->categories as $category) {
            $this->attachCategoryToStyle->execute($style, $category);
        }

        foreach ($styleDto->factories as $factory) {
            $this->attachFactoriesToStyle->execute($style, $factory);
        }

        foreach ($styleDto->panels as $panel) {
            $this->attachPanelToStyle->execute($style, $panel);
        }


        if ($styleDto->embellishments_form) {
            foreach ($styleDto->embellishments_form as $embellishment) {
                $oldEmbellishmentWithSameDetails = $style->embellishments()
                    ->where('embellishment_id', $embellishment->type['id'])
                    ->where('position', $embellishment->position['value']);

                if (!$embellishment->already_uploaded) {
                    if($oldEmbellishmentWithSameDetails->exists()) {
                        $oldEmbellishmentWithSameDetails->delete();
                    }

                    $embellishmentStyle = new EmbellishmentStyle();
                    $image_path = $embellishment->image->store('style_images', 'public');
                    $embellishmentStyle->image_path = $image_path;
                    $embellishmentStyle->embellishment_id = $embellishment->type['id'];
                    $embellishmentStyle->position = $embellishment->position['value'];
                    $style->embellishments()->save($embellishmentStyle);
                }

                if ($embellishment->already_uploaded) {
                    if($oldEmbellishmentWithSameDetails->exists()) {
                        $oldEmbellishmentWithSameDetails->delete();
                    }
                }
            }
        }

        if (!$styleDto->embellishments_form) {
            $style->embellishments()->delete();
        }


        $style->refresh();

        return $style;
    }
}
