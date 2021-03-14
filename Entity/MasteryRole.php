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
            'name' => ['type' => self::STR,'maxLength' => 50,'required' => true],
            'icon_url' => ['type' => self::STR,'maxLength' => 999],
        ];

        $structure->getters = [
            'id' => true,
            'entityShortName' => true,
            'formStructure' => true
        ];

        return  $structure;
    }

    public function getID()
    {
        return $this->role_id;

    }

    public function getEntityShortName(): string
    {
        return $this->structure()->shortName;
    }

}