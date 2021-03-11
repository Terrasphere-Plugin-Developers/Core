<?php
namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class MasteryRole extends Entity implements iTraitCommon {

    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_mastery_role';
        $structure->shortName = 'Terrasphere\Core:MasteryRole';
        $structure->primaryKey = 'role_id';

        $structure->columns = [
            'role_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'name' => ['type' => self::STR,'maxLength' => 50,'required' => true]
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
        return $this->role_id;

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
                'label'=> "Name"

            ]
        ];

        return $returnValue;
    }
}