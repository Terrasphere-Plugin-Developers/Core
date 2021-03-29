<?php
namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class RankSchema extends Entity
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_rank_schema';
        $structure->shortName = 'Terrasphere\Core:RankSchema';
        $structure->primaryKey = 'rank_schema_id';

        $structure->columns = [
            'rank_schema_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'name' => ['type' => self::STR, 'maxLength' => 50, 'required' => true],
            'currency_id' => ['type' => self::UINT, 'required' => true]
        ];

        $structure->relations = [
            'Currency' => [
                'entity' => 'DBTech\Credits:Currency',
                'type' => SELF::TO_ONE,
                'conditions' => 'currency_id',
                'primary' => true
            ]
        ];
        return  $structure;
    }

    protected function _postDelete()
    {
        //todo: maybe try catch if something screws up? Though it shouldn't... right? Alternatively can do a cascading delete from rank_schema...? Since ranks are 'hard-coded' no need to put a on-post-delete there. Also potentially some better alternative than a direct query?
        $db = \XF::db();
        $db->query('DELETE FROM xf_terrasphere_core_rank_schema_map WHERE rank_schema_id = ?', $this->rank_schema_id);
    }
}