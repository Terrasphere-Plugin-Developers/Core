<?php

namespace Terrasphere\Core;

trait DBTableFill
{

    protected function fillMasteryEnumTables(Setup $setup)
    {
        $this->populateMasteryExpertiseTable($setup);
        $this->populateMasterySaveTable($setup);
        $this->populateMasteryTypeTable($setup);
        $this->populateMasteryRoleTable($setup);
        $this->populateRankingTables($setup);
    }

    private function populateMasteryExpertiseTable(Setup $setup)
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

    private function populateMasterySaveTable(Setup $setup)
    {
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_save',
            [
                ['name' => 'Nothing'],
                ["name" => 'Will'],
                ["name" => 'Fortitude'],
                ["name" => 'Reflex'],
            ]);
    }

    private function populateMasteryRoleTable(Setup $setup)
    {
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_role',
            [
                ["name" => 'Defense'],
                ["name" => 'Offense'],
                ["name" => 'Support'],
            ]);
    }

    private function populateMasteryTypeTable(Setup $setup)
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

    private function populateRankingTables(Setup $setup)
    {
        $setup->db()->insertBulk('xf_terrasphere_core_rank',
        [
            ["name" => "E",
                "color" => "#777777",
                "tier" => 1],
            ["name" => "D",
                "color" => "#4786c7",
                "tier" => 2],
            ["name" => "C",
                "color" => "#41b4ae",
                "tier" => 3],
            ["name" => "B",
                "color" => "#eabb0f",
                "tier" => 4],
            ["name" => "A",
                "color" => "#bc2b3d",
                "tier" => 5],
            ["name" => "S",
                "color" => "#d44499",
                "tier" => 6]
        ]);
    }
}