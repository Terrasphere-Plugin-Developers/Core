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
        $this->populateBannerButtons($setup);
    }

    private function populateMasteryExpertiseTable(Setup $setup)
    {
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_expertise',
            [
                [
                    'name' => 'Nothing',
                    "css_classes" => "fas fa-bolt",
                    "hex_color" => "#6436b1",
                ],
                [
                    "name" => 'Knack',
                    "css_classes" => "fas fa-hand-paper",
                    "hex_color" => "#389c44",
                ],
                [
                    "name" => 'Fitness',
                    "css_classes" => "fas fa-running",
                    "hex_color" => "#d02222",
                ],
                [
                    "name" => 'Awareness',
                    "css_classes" => "far fa-eye",
                    "hex_color" => "#de6e47",
                ],
                [
                    "name" => 'Knowledge',
                    "css_classes" => "fas fa-books",
                    "hex_color" => "#6e51cb",
                ],
                [
                    "name" => 'Presence',
                    "css_classes" => "fas fa-users-crown",
                    "hex_color" => "#e2427b",
                ]
            ]);
    }

    private function populateMasterySaveTable(Setup $setup)
    {
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_save',
            [
                [
                    'name' => 'Nothing',
                    "css_classes" => "fas fa-bolt",
                    "hex_color" => "#6436b1",
                ],
                [
                    "name" => 'Will',
                    "css_classes" => "fas fa-head-side-brain",
                    "hex_color" => "#9f5cce",
                ],
                [
                    "name" => 'Fortitude',
                    "css_classes" => "fas fa-heartbeat",
                    "hex_color" => "#df6135",
                ],
                [
                    "name" => 'Reflex',
                    "css_classes" => "fad fa-shoe-prints",
                    "hex_color" => "#68b435",
                ],
            ]);
    }

    private function populateMasteryRoleTable(Setup $setup)
    {
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_role',
            [
                [
                    "name" => 'Defense',
                    "css_classes" => "far fa-shield-alt",
                    "hex_color" => "#ce832c",
                ],
                [
                    "name" => 'Offense',
                    "css_classes" => "fas fa-swords",
                    "hex_color" => "#ce2c2c",
                ],
                [
                    "name" => 'Support',
                    "css_classes" => "fas fa-hand-holding-medical",
                    "hex_color" => "#67a3d8",
                ],
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

    protected function populateBannerButtons(Setup $setup)
    {
        $setup->db()->insertBulk('xf_terrasphere_core_banner_button',
            [
                [
                    'name' => 'Unanswered Threads',
                    'icon_url' => '',
                    'url' => 'find-threads/unanswered',
                    'behavior' => 0,
                ],
                [
                    'name' => 'Shop',
                    'icon_url' => '',
                    'url' => 'dbtech-shop',
                    'behavior' => 0,
                ],
                [
                    'name' => 'Inventory',
                    'icon_url' => '',
                    'url' => 'dbtech-shop/inventory',
                    'behavior' => 0,
                ],
                [
                    'name' => 'Build Editor',
                    'icon_url' => '',
                    'url' => 'https://e-foead.github.io/app.html#{player_stats}',
                    'behavior' => 1,
                ],
            ]);
    }
}