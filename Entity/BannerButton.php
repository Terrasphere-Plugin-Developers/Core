<?php

namespace Terrasphere\Core\Entity;

use Terrasphere\Charactermanager\XF\Entity\User;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class BannerButton extends Entity
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_banner_button';
        $structure->shortName = 'Terrasphere\Core:BannerButton';
        $structure->primaryKey = 'banner_button_id';
        $structure->columns = [
            'banner_button_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'name' => ['type' => self::STR, 'required' => true],
            'icon_url' => ['type' => self::STR,'required' => true],
            'url' => ['type' => self::STR,'required' => true],
            'behavior' => ['type' => self::UINT,'required' => true],
        ];

        $structure->getters = [];
        $structure->relations = [];

        return  $structure;
    }

    public function getParsedURL($user)
    {
        $url = $this['url'];
        if(preg_match("/\{player_stats}/i", $url))
        {
            $replaceString = $this->getBuildEditorParamsString($user);
            $url = str_replace("{player_stats}", $replaceString, $url);
        }

        return $url;
    }


    private function getBuildEditorParamsString(User $user) : string
    {
        $masteryNames = "";
        $masteryRanks = "";

        $masteries = $user->getMasteries();

        foreach ($masteries as $mastery)
        {
            // Make sure each mastery display name is formatted as expected, using single dashes as word separators.
            $masteryString = strtolower($mastery->Mastery['display_name']);
            $masteryString = str_replace(' ', '-', $masteryString);
            $masteryString = str_replace('_', '-', $masteryString);

            $masteryRanks .= $mastery->Rank['tier'];

            // Add comma separators.
            $masteryNames .= $masteryString . ',';
            $masteryRanks .= ',';
        }

        // Remove last comma for both names and ranks.
        $masteryNames = substr($masteryNames, 0, -1);
        $masteryRanks = substr($masteryRanks, 0, -1);

        $weapon = $user->getOrInitiateWeapon();
        $weaponRank = $this->finder('Terrasphere\Core:Rank')->whereId($weapon['rank_id'])->fetchOne();

        $armor = $user->getOrInitiateArmor();
        $armorRank = $this->finder('Terrasphere\Core:Rank')->whereId($armor['rank_id'])->fetchOne();

        return $masteryNames . '.' .
            $masteryRanks .'..' .
            $weaponRank['tier'] . '.' .
            $armorRank['tier'] . '.' .
            str_replace(' ', '_', $user->username);
    }
}