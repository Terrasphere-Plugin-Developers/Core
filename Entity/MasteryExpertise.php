<?php


namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class MasteryExpertise extends Entity
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_mastery_expertise';
        $structure->shortName = 'TS:MasteryExpertise';
        $structure->primaryKey = 'expertise_id';

        $structure->columns = [
            'expertise_id' => ['type' => self::UINT, 'required' => true],
            'name' => ['type' => self::STR,'maxLength' => 50,'required' => true]
        ];
    }
}