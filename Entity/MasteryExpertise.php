<?php


namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class MasteryExpertise extends Entity implements iTraitCommon
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_mastery_expertise';
        $structure->shortName = 'Terrasphere\Core:MasteryExpertise';
        $structure->primaryKey = 'expertise_id';

        $structure->columns = [
            'expertise_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'name' => ['type' => self::STR,'maxLength' => 50,'required' => true],
            'css_classes' => ['type' => self::STR, "maxLength" => 999],
            'hex_color' => ['type' => self::STR, "maxLength" => 7],
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
        return $this->expertise_id;
    }

    public function getEntityShortName(): string
    {
        return $this->structure()->shortName;
    }

}