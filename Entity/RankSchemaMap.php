<?php
namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class RankSchemaMap extends Entity
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_rank_schema_map';
        $structure->shortName = 'Terrasphere\Core:RankSchemaMap';
        $structure->primaryKey = ['rank_schema_id','rank_id'];

        $structure->columns = [
            'rank_schema_id' => ['type' => self::UINT],
            'rank_id' => ['type' => self::UINT],
            'cost' => ['type' => self::UINT, 'default' => 0]
        ];

        $structure->relations = [
            "Rank" => [
                'entity' => 'Terrasphere\Core:Rank',
                'type' => SELF::TO_ONE,
                'conditions' => "rank_id",
                'primary' => true
             ],
            "RankSchema" => [
                'entity' => 'Terrasphere\Core:RankSchema',
                'type' => SELF::TO_ONE,
                'conditions' => "rank_schema_id",
                'primary' => true
            ]
        ];
        return  $structure;
    }
}