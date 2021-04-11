<?php

namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
use XF\Pub\Controller\AbstractController;

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
        ];


        return  $structure;
    }

    public static function maxTier(AbstractController $controller): int
    {
        return $controller->finder('Terrasphere\Core:Rank')
            ->order('tier', 'DESC')
            ->fetchOne()['tier'];
    }

    public static function maxRank(AbstractController $controller): Rank
    {
        return $controller->finder('Terrasphere\Core:Rank')
            ->order('tier', 'DESC')
            ->fetchOne();
    }
}