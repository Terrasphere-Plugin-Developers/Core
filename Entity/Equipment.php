<?php

namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Equipment extends Entity
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_equipment';
        $structure->shortName = 'Terrasphere\Core:Equipment';
        $structure->primaryKey = 'equipment_id';
        $structure->columns = [
            'equipment_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'rank_schema_id' => ['type' => self::UINT, 'required' => true],
            'display_name' => ['type' => self::STR, 'required' => true],
            'icon_url' => ['type' => self::STR],
            'equip_group' => ['type' => self::STR],
        ];

        $structure->getters = [
            'icon_url' => true,
        ];

        $structure->relations = [
            'RankSchema' => [
                'entity' => 'Terrasphere\Core:RankSchema',
                'type' => SELF::TO_ONE,
                'conditions' => 'rank_schema_id',
                'primary' => true //TODO: Does this mean its the primary key of the other table?
            ]
        ];

        return  $structure;
    }


    //getter that overrides icon_url property. To get the underlying actual value gotta work with the _values array
    public function getIconUrl(){
        return \XF::options()->boardUrl . '/' . $this->_values['icon_url'];
    }
}