<?php
declare(strict_types=1);

namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\CustomizedStyle;
use App\Domains\Styles\Dto\Style;
use App\Models\EmbellishmentStyle;
use App\Models\Style as StyleModel;

class CreateStyle
{
    private AttachSizeToStyle $attachSizeToStyle;
    private AttachCategoryToStyle $attachCategoryToStyle;
    private AttachFactoriesToStyle $attachFactoriesToStyle;
    private AttachPanelToStyle $attachPanelToStyle;
    private AttachPanelToCustomStyle $attachPanelToCustomStyle;

    public function __construct(
        AttachSizeToStyle $attachSizeToStyle,
        AttachCategoryToStyle $attachCategoryToStyle,
        AttachFactoriesToStyle $attachFactoriesToStyle,
        AttachPanelToStyle $attachPanelToStyle,
        AttachPanelToCustomStyle $attachPanelToCustomStyle
    ) {
        $this->attachSizeToStyle = $attachSizeToStyle;
        $this->attachCategoryToStyle = $attachCategoryToStyle;
        $this->attachFactoriesToStyle = $attachFactoriesToStyle;
        $this->attachPanelToStyle = $attachPanelToStyle;
        $this->attachPanelToCustomStyle = $attachPanelToCustomStyle;
    }

    public function execute(Style|CustomizedStyle $styleDto): StyleModel
    {
        /** @var StyleModel $style */
        $style = StyleModel::create([
            'code' => $styleDto->code,
            'name' => $styleDto->name,
            'production_time' => $styleDto->production_time,
            'item_type_id' => $styleDto->item_type->id,
            'styles_type' => $styleDto->styles_type,
            'description' => $styleDto->description,
            'belongs_to' => $styleDto->belongs_to,
            'status' => $styleDto->status,
            'customer_id' => optional($styleDto->customer)->id,
            'parent_style_id' => optional($styleDto->parent_style)->id,
            'style_image' => $styleDto->style_image
        ]);

        foreach ($styleDto->sizes as $size) {
            $this->attachSizeToStyle->execute($style, $size);
        }

        foreach ($styleDto->categories as $category) {
            $this->attachCategoryToStyle->execute($style, $category);
        }

        foreach ($styleDto->factories as $factory) {
            $this->attachFactoriesToStyle->execute($style, $factory);
        }

        if ($styleDto->styles_type != StyleModel::CUSTOMIZED) {
            if (!is_null($styleDto->panels)) {
                foreach ($styleDto->panels as $panel) {
                    $this->attachPanelToStyle->execute($style, $panel);
                }
            }
        }  else {
            if (!is_null($styleDto->customized_panels)) {
                foreach ($styleDto->customized_panels as $panel) {
                    $this->attachPanelToCustomStyle->execute($style, $panel);
                }
            }
        }

        if ($styleDto->embellishments_form) {
            foreach ($styleDto->embellishments_form as $embellishments) {
                $embellishmentStyle = new EmbellishmentStyle();
                $image_path = $embellishments->image->store('style_images', 'public');
                $embellishmentStyle->image_path = $image_path;
                $embellishmentStyle->embellishment_id = $embellishments->type['id'];
                $embellishmentStyle->position = $embellishments->position['value'];

                $style->embellishments()->save($embellishmentStyle);
            }
        }


        $style->refresh();

        return $style;
    }
}
