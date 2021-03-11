<?php


namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class MasteryExpertise extends Entity implements iTraitCommon
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_mastery_expertise';
        $structure->shortName = 'Terrasphere\Core:MasteryExpertise';
        $structure->primaryKey = 'expertise_id';

        $structure->columns = [
            'expertise_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'name' => ['type' => self::STR,'maxLength' => 50,'required' => true],
            'icon_url' => ['type' => self::STR,'maxLength' => 999],
        ];

        $structure->getters = [
            'id' => true,
            'entityHelperName' => true,
            'formStructure' => true
        ];

        return  $structure;
    }

    public function getID()
    {
        return $this->expertise_id;
    }

    public function getEntityHelperName(): string
    {
        $secondBit = explode(":",$this->structure()->shortName);
        return $secondBit[1];
    }

    public function getFormStructure() : array{
        $returnValue = [
            'textboxrow' => [
                'name' => 'name',
                'value'=> $this->name,
                'label'=> "Name",
            ],
            'icon_url' => [
                'name' => 'icon_url',
                'value' => $this->icon_url,
                'label' => 'Icon URL',
            ],
        ];

        return $returnValue;
    }
}