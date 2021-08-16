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
        $this->populateEquipStuff($setup);
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
                    "cost_modifier" => 1.5,
                    'rank_schema_id' => 2]
            ]);
    }

    private function populateRankingTables(Setup $setup)
    {
        $setup->db()->insertBulk('xf_terrasphere_core_rank',
        [
            ["name" => "E",
                "color" => "#777777",
                "tier" => 0],
            ["name" => "D",
                "color" => "#4786c7",
                "tier" => 1],
            ["name" => "C",
                "color" => "#41b4ae",
                "tier" => 2],
            ["name" => "B",
                "color" => "#eabb0f",
                "tier" => 3],
            ["name" => "A",
                "color" => "#bc2b3d",
                "tier" => 4],
            ["name" => "S",
                "color" => "#d44499",
                "tier" => 5]
        ]);
    }

    protected function populateEquipStuff(Setup $setup){
        $schemaName = 'Equipment Schema';
        $this->populateEquipSchema($setup, $schemaName);
        $this->populateEquipmentTable($setup,$schemaName);
    }

    private function populateEquipSchema(Setup $setup, string $equipSchemaName){
        $currencyId = $setup->db()->fetchRow('SELECT currency_id FROM xf_dbtech_credits_currency')['currency_id'];
        $setup->db()->insert('xf_terrasphere_core_rank_schema',[
            'name' => $equipSchemaName,
            'currency_id' => $currencyId,
        ]);

        $rankSchemaId = $setup->db()->fetchRow('SELECT rank_schema_id FROM xf_terrasphere_core_rank_schema WHERE name = ?', $equipSchemaName)['rank_schema_id'];
        $ranks = $setup->db()->fetchAll('SELECT rank_id from xf_terrasphere_core_rank');
        foreach($ranks as $rank){
            $setup->db()->insert('xf_terrasphere_core_rank_schema_map',[
                'rank_schema_id' => $rankSchemaId,
                'rank_id' => $rank['rank_id'],
                'cost' => 0,
            ]);
        }
    }
    private function populateEquipmentTable(Setup $setup, string $equipSchemaName){

        $rankSchemaId = $setup->db()->fetchRow('SELECT rank_schema_id FROM xf_terrasphere_core_rank_schema WHERE name = ?', $equipSchemaName)['rank_schema_id'];
        $setup->db()->insertBulk('xf_terrasphere_core_equipment',
        [
            [
                'display_name' => 'Weapon',
                'icon_url' => 'styles/default/Terrasphere/Charactermanager/weapon-icon.png',
                'equip_group' => 'Weapon',
                'rank_schema_id' => $rankSchemaId,
            ],
            [
                'display_name' => 'Light Armor',
                'icon_url' => 'styles/default/Terrasphere/Charactermanager/armor-light.png',
                'equip_group' => 'Armor',
                'rank_schema_id' => $rankSchemaId,
            ],
            [
                'display_name' => 'Medium Armor',
                'icon_url' => 'styles/default/Terrasphere/Charactermanager/armor-medium.png',
                'equip_group' => 'Armor',
                'rank_schema_id' => $rankSchemaId,
            ],
            [
                'display_name' => 'Heavy Armor',
                'icon_url' => 'styles/default/Terrasphere/Charactermanager/armor-heavy.png',
                'equip_group' => 'Armor',
                'rank_schema_id' => $rankSchemaId,
            ],

        ]);
    }


}