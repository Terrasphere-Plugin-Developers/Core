<?php

namespace Terrasphere\Core\Option;

use XF\Option\AbstractOption;

class MasteryTypeSelect extends AbstractOption
{
    public static function renderOption(\XF\Entity\Option $option, array $htmlParams)
    {
        return self::getSelectRow($option, $htmlParams, $option->finder('Terrasphere\Core:MasteryType')->fetch()->pluckNamed('name', 'mastery_type_id'));
    }
}