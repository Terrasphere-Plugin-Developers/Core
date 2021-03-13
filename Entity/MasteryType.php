<?php
namespace Terrasphere\Core\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
use Terrasphere\Core\Helpers;

class MasteryType extends Entity implements iTraitCommon
{
    public static function getStructure(Structure $structure) : Structure
    {
        $structure->table = 'xf_terrasphere_core_mastery_type';
        $structure->shortName = 'Terrasphere\Core:MasteryType';
        $structure->primaryKey = 'mastery_type_id';

        $structure->columns = [
            'mastery_type_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'name' => ['type' => self::STR,'maxLength' => 50,'required' => true],
            'cap_per_character' => ['type' => self::UINT, 'default' => 9999],
            'icon_url' => ['type' => self::STR,'maxLength' => 999],
            'system_type' => ['type' => ENTITY::BOOL, 'default' => false],
            'cost_modifier' => ['type' => self::FLOAT, 'default' => 1.0]
        ];

        $structure->getters = [
            'id' => true,
            'entityHelperName' => true,
            'formStructure' => true
        ];

        return $structure;
    }


    public function getID()
    {
        return $this->mastery_type_id;
    }

    public function getEntityHelperName(): string
    {
        $secondBit = explode(":",$this->structure()->shortName);
        return $secondBit[1];
    }

    public function getFormStructure(): array
    {
        $returnValue = [
            ['xfComponent' => 'textboxrow',
                'name' => 'name',
                'value'=> $this->name,
                'label'=> "Name",
                'explain' => "Moo"
            ],
            ['xfComponent' => 'icon_url', //should be something different
                'name' => 'icon_url',
                'value' => $this->icon_url,
                'label' => 'Icon URL',
            ],
            ['xfComponent' => 'numberboxrow',
                'name' => 'cap_per_character',
                'value'=> $this->cap_per_character,
                'label'=> "Maximum per Character",
                'min' => 1,
                'max' => 9999,
                'step' => 0.1,
                'explain' => "The maximum of this special type of mastery a character can have at one time."
            ],
            ['xfComponent' => 'textboxrow',
            'name' => 'cost_modifier',
            'value'=> $this->cost_modifier,
            'label'=> "Cost Modifier",
            'explain' => "The modifier to the rank-up cost of masteries of this type. Numbers only!"
        ],
        ];

        return $returnValue;
    }
}