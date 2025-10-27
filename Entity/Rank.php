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


        return $structure;
    }

    public static function maxTier($containsFinder): int
    {
        return $containsFinder->finder('Terrasphere\Core:Rank')
            ->order('tier', 'DESC')
            ->fetchOne()['tier'];
    }

    public static function maxRank($containsFinder): Rank
    {
        return $containsFinder->finder('Terrasphere\Core:Rank')
            ->order('tier', 'DESC')
            ->fetchOne();
    }

    public static function minRank($containsFinder): Rank
    {
        return $containsFinder->finder('Terrasphere\Core:Rank')
            ->order('tier','ASC')
            ->fetchOne();
    }

    public function getNextRank() : Rank
    {
        /** @var Rank $ret */
        $ret = $this->finder('Terrasphere\Core:Rank')
            ->where('tier', ($this['tier'])+1)
            ->fetchOne();
        return $ret;
    }

    public function getPreviousRank() : Rank
    {
        /** @var Rank $ret */
        $ret = $this->finder('Terrasphere\Core:Rank')
            ->where('tier', ($this['tier'])-1)
            ->fetchOne();
        return $ret;
    }

    /**
     * Full cost of this rank, including all prerequisites.
     */
    public function getCumulativeCost(RankSchema $rankSchema) : int
    {
        $rankSchemaCost = $this->finder('Terrasphere\Core:RankSchemaMap')
            ->with('Rank')
            ->where([
                ['rank_schema_id', $rankSchema['rank_schema_id']],
                ['Rank.tier', '<=', $this['tier']],
            ])
            ->fetch()->toArray();

        $cost = 0;
        foreach($rankSchemaCost as $value)
            $cost += $value['cost'];

        return $cost;
    }

    public function getRefund(RankSchema $rankSchema) : int
    {
        $fullRefund = $this->getCumulativeCost($rankSchema);

        if(\XF::options()['terrasphereMasteryRefundRankSkips'] > $this['tier'])
            return $fullRefund;

        return ((float) $fullRefund) * 0.01 * (float) (\XF::options()['terrasphereMasteryRefundPercent']);
    }
}