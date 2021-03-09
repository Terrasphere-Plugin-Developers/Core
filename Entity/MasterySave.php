<?php
namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class MasterySave extends Entity{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_mastery_save';
        $structure->shortName = 'TS:MasterySave';
        $structure->primaryKey = 'save_id';

        $structure->columns = [
            'save_id' => ['type' => self::UINT, 'required' => true],
            'name' => ['type' => self::STR,'maxLength' => 50,'required' => true]
        ];

        return  $structure;
    }
}