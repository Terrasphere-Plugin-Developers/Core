<?php

namespace Terrasphere\Core;

use Terrasphere\Core\Entity\MasteryExpertise;

trait DBTableFill
{

    protected function fillMasteryEnumTables(Setup $setup): void
    {
        $this->populateMasteryExpertiseTable($setup);
        $this->populateMasterySaveTable($setup);
        $this->populateMasteryTypeTable($setup);
        $this->populateMasteryRoleTable($setup);
        $this->populateRankingTables($setup);
    }

    private function populateMasteryExpertiseTable(Setup $setup): void
    {
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_expertise',
            [
                ['name' => 'Nothing'],
                ["name" => 'Knack'],
                ["name" => 'Fitness'],
                ["name" => 'Awareness'],
                ["name" => 'Knowledge'],
                ["name" => 'Presence']
            ]);
    }

    private function populateMasterySaveTable(Setup $setup): void
    {
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_save',
            [
                ['name' => 'Nothing'],
                ["name" => 'Will'],
                ["name" => 'Fortitude'],
                ["name" => 'Reflex'],
            ]);
    }

    private function populateMasteryRoleTable(Setup $setup): void
    {
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_role',
            [
                ["name" => 'Defense'],
                ["name" => 'Offense'],
                ["name" => 'Support'],
            ]);
    }

    private function populateMasteryTypeTable(Setup $setup): void
    {
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_type',
            [
                ["name" => 'DEFAULT',
                    "cap_per_character" => 9999,
                    "system_type" => 1,
                    "cost_modifier" => 1],
                ["name" => 'Alter',
                    "cap_per_character" => 1,
                    "system_type" => 0,
                    "cost_modifier" => 1.5]
            ]);
    }

    private function populateRankingTables(Setup $setup): void
    {
        //TODO Change the name blu with actuaL values
        $setup->db()->insertBulk('xf_terrasphere_core_rank',
        [
            ["name" => "E",
                "color" => "blu",
                "tier" => 1],
            ["name" => "D",
                "color" => "blu",
                "tier" => 2],
            ["name" => "C",
                "color" => "blu",
                "tier" => 3],
            ["name" => "B",
                "color" => "blu",
                "tier" => 4],
            ["name" => "A",
                "color" => "blu",
                "tier" => 5],
            ["name" => "S",
                "color" => "blu",
                "tier" => 6]
        ]);
    }
}