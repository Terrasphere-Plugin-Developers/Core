<?php


namespace Terrasphere\Core;


use Terrasphere\Core\Entity\MasteryExpertise;

trait DBTableFill
{

    protected  function fillTables(Setup $setup) : void{
        $this->populateExpertise($setup);
    }

    private function populateExpertise(Setup $setup) : void{
        $setup->db()->insertBulk('xf_terrasphere_core_mastery_expertise',
            [
                ["name" => 'Knack'],
                ["name" => 'Fitness'],
                ["name" => 'Awareness'],
                ["name" => 'Knowledge'],
                ["name" =>'Presence']
            ]);
    }


}