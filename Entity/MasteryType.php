<?php
namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
use Terrasphere\Core\Helpers;

class MasteryType extends Entity implements iTraitCommon
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_mastery_type';
        $structure->shortName = 'Terrasphere\Core:MasteryType';
        $structure->primaryKey = 'mastery_type_id';

        $structure->columns = [
            'mastery_type_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'name' => ['type' => self::STR,'maxLength' => 50,'required' => true],
            'cap_per_character' => ['type' => self::UINT, 'default' => 9999]
        ];

        $structure->getters = [
            'id' => true,
            'entityHelperName' => true,
            'formStructure' => true
        ];

        return $structure;
    }


    public function getID()
    {
        return $this->mastery_type_id;
    }

    public function getEntityHelperName(): string
    {
        $secondBit = explode(":",$this->structure()->shortName);
        return $secondBit[1];
    }

    public function getFormStructure(): array
    {
        $returnValue = [
            'textboxrow' => [
                'name' => 'name',
                'value'=> $this->name,
                'label'=> "Name"

            ]
        ];

        return $returnValue;
    }
}