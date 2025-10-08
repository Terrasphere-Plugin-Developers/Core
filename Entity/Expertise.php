<?php

namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Expertise extends Entity
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_expertise';
        $structure->shortName = 'Terrasphere\Core:Expertise';
        $structure->primaryKey = 'expertise_id';
        $structure->columns = [
            'expertise_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'role_id' => ['type' => self::UINT,'required' => true],
            'display_name' => ['type' => self::STR, 'required' => true],
            'icon_url' => ['type' => self::STR],
            'thumbnail_url' => ['type' => self::STR],
            'wiki_url' => ['type' => self::STR],
            'color' => ['type' => self::STR]
        ];

        $structure->getters = [];

        $structure->relations = [
            'ExpertiseRole' => [
                'entity' => 'Terrasphere\Core:MasteryRole', // Not a typo; reusing mastery role entity
                'type' => SELF::TO_ONE,
                'conditions' => 'role_id',
                'primary' => true
            ]
        ];

        return $structure;
    }

    public function getRankSchema() : RankSchema
    {
        $expertiseRankSchemaID = $this->app()->options()->terrasphereExpertiseRankSchema;
        /** @var RankSchema $rankSchema */
        $rankSchema = $this->finder('Terrasphere\Core:RankSchema')->with('Currency')->where('rank_schema_id', $expertiseRankSchemaID)->fetchOne();
        return $rankSchema;
    }
}