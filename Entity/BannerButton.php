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

        while(str_contains($url, "{id}"))
        {
            $replaceString = $user->user_id;
            $url = str_replace("{id}", $replaceString, $url);
        }

        return $url;
    }
}