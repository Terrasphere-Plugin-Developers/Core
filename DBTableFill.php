<?php


namespace Terrasphere\Core;


use Terrasphere\Core\Entity\MasteryExpertise;

trait DBTableFill
{

    protected  function fillMasteryEnumTables(Setup $setup) : void{
        $this->populateMasteryExpertiseTable($setup);
        $this->populateMasterySaveTable($setup);
        $this->populateMasteryTypeTable($setup);
        $this->populateMasteryRoleTable($setup);
    }

    private function populateMasteryExpertiseTable(Setup $setup) : void{
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_expertise',
            [
                ["name" => 'Knack'],
                ["name" => 'Fitness'],
                ["name" => 'Awareness'],
                ["name" => 'Knowledge'],
                ["name" =>'Presence']
            ]);
    }

    private function populateMasterySaveTable(Setup $setup) : void{
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_save',
            [
                ["name" => 'Will'],
                ["name" => 'Fortitude'],
                ["name" => 'Reflex'],
            ]);
    }

    private function populateMasteryRoleTable(Setup $setup) : void{
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_role',
            [
                ["name" => 'Defense'],
                ["name" => 'Offense'],
                ["name" => 'Support'],
            ]);
    }

    private function populateMasteryTypeTable(Setup $setup) : void{
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_type',
            [
                ["name" => 'Normal',
                    "cap_per_character" => 9999],
                ["name" => 'Alter',
                    "cap_per_character" => 1]
            ]);
    }

}