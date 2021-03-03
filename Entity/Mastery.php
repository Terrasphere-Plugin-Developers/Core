<?php

namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Mastery extends Entity
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_mastery';
        $structure->shortName = 'TS:Mastery';
        $structure->primaryKey = 'mastery_id';
        $structure->columns = [
            'save_id' => ['type' => self::UINT, 'required' => true],
            'role_id' => ['type' => self::UINT,'required' => true],
            'expertise_id' => ['type' => self::UINT,'required' => true],
            'type_id' => ['type' => self::UINT,'required' => true],
            'display_name' => ['type' => self::STR, 'required' => true],
            'icon_url' => ['type' => self::STR],
            'thumbnail_url' => ['type' => self::STR]
        ];

        $structure->getters = [];

        $structure->relations = [
            'MasteryExpertise' => [
                'entity' => 'TS:MasteryExpertise',
                'type' => SELF::TO_ONE,
                'conditions' => 'save_id',
                'primary' => true //TODO: Does this mean its the primary key of the other table?
            ],
            'MasteryRole' => [
                'entity' => 'TS:MasteryRole',
                'type' => SELF::TO_ONE,
                'conditions' => 'role_id',
                'primary' => true
            ],
            'MasterySave' => [
                'entity' => 'TS:MasterySave',
                'type' => SELF::TO_ONE,
                'conditions' => 'save_id',
                'primary' => true
            ],
            'MasteryType' => [
                'entity' => 'TS:MasteryType',
                'type' => SELF::TO_ONE,
                'conditions' => 'type_id',
                'primary' => true
            ],
        ];

        return  $structure;
    }
}