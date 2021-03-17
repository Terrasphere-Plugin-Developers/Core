<?php
namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class RankSchema extends Entity{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_rank_schema';
        $structure->shortName = 'Terrasphere\Core:RankSchema';
        $structure->primaryKey = 'rank_schema_id';

        $structure->columns = [
            'rank_schema_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'rank_d' => ['type' => self::UINT],
            'rank_c' => ['type' => self::UINT],
            'rank_b' => ['type' => self::UINT],
            'rank_a' => ['type' => self::UINT],
            'rank_s' => ['type' => self::UINT],
            'currency_type' => ['type' => self::UINT]
        ];

        $structure->relations = [
            'Currency' => [
                'entity' => 'DBTech\Credits:Currency',
                'type' => SELF::TO_ONE,
                'conditions' => 'currency_type',
                'primary' => true //TODO: Does this mean its the primary key of the other table?
            ]];
        return  $structure;
    }

}