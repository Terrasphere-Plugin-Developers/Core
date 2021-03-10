<?php
namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class MasteryRole extends Entity{

    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_mastery_role';
        $structure->shortName = 'Terrasphere\Core:MasteryRole';
        $structure->primaryKey = 'role_id';

        $structure->columns = [
            'role_id' => ['type' => self::UINT, 'required' => true],
            'name' => ['type' => self::STR,'maxLength' => 50,'required' => true]
        ];

        return  $structure;
    }
}