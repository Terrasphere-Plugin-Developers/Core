<?php
namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class MasteryType extends Entity
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_mastery_type';
        $structure->shortName = 'TS:MasteryType';
        $structure->primaryKey = 'type_id';

        $structure->columns = [
            'type_id' => ['type' => self::UINT, 'required' => true],
            'name' => ['type' => self::STR,'maxLength' => 50,'required' => true]
        ];

        return $structure;
    }
}