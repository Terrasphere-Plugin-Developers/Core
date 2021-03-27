<?php

namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Rank extends Entity
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_rank';
        $structure->shortName = 'Terrasphere\Core:Rank';
        $structure->primaryKey = 'rank_id';

        $structure->columns = [
            'rank_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'name' => ['type' => self::STR, 'required' => true],
            'color' => ['type' => self::STR, 'required' => true],
            'tier' => ['type' => self::UINT, 'required' => true],
            'cost' => ['type' => self::UINT, 'required' => true],
            'currency_id' => ['type' => self::UINT, 'required' => true],
        ];

        $structure->relations = [
            'Currency' => [
                'entity' => 'DBTech\Credits:Currency',
                'type' => SELF::TO_ONE,
                'conditions' => 'currency_id',
                'primary' => true
            ],
            'MasteryType' => [
                'entity' => 'Terrasphere\Core:MasteryType',
                'type' => SELF::TO_MANY,
                'conditions' => 'mastery_type_id',
                'primary' => true
            ],
        ];
        return  $structure;
    }
}