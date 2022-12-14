<?php
declare(strict_types=1);

namespace App\Domains\Styles\Actions;

use App\Domains\Styles\Dto\Panel;
use App\Models\Style;
use App\Models\StylePanel;

class AttachPanelToStyle
{
    private AttachConsumptionToPanel $attachConsumptionToPanel;
    private AttachFabricToPanel $attachFabricToPanel;

    public function __construct(
        AttachConsumptionToPanel $attachConsumptionToPanel,
        AttachFabricToPanel $attachFabricToPanel
    ) {
        $this->attachConsumptionToPanel = $attachConsumptionToPanel;
        $this->attachFabricToPanel = $attachFabricToPanel;
    }

    public function execute(Style $style, Panel $panel): void
    {
        if ($panel->id) {
            $stylePanel = $this->updatePanel($panel);
        } else {
            $stylePanel = $this->createPanel($style, $panel);
        }

        $stylePanel->consumption()->delete();

        if ($panel->consumption != null || $panel->consumption != []) {
            foreach ($panel->consumption as $consumption) {
                $this->attachConsumptionToPanel->execute($stylePanel, $consumption, 'm');
            }
        }

        foreach ($panel->fabrics as $fabric) {
            $this->attachFabricToPanel->execute($stylePanel, $fabric);
        }
    }

    private function updatePanel(Panel $panel): StylePanel
    {
        $stylePanel = StylePanel::find($panel->id);
        $stylePanel->update([
            'name' => $panel->name,
            'default_fabric_id' => optional($panel->default_fabric)->id,
            'color_id' => optional($panel->color)->id,
        ]);
        $stylePanel->refresh();
        return $stylePanel;
    }

    private function createPanel(Style $style, Panel $panel): StylePanel
    {
        return StylePanel::create([
            'name' => $panel->name,
            'style_id' => $style->id,
            'default_fabric_id' => optional($panel->default_fabric)->id,
            'color_id' => optional($panel->color)->id,
        ]);
    }
}
