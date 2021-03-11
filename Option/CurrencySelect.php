<?php

namespace Terrasphere\Core\Option;

use XF\Option\AbstractOption;

class CurrencySelect extends AbstractOption
{
    public static function renderOption(\XF\Entity\Option $option, array $htmlParams)
    {
        /** @var \DBTech\Credits\Repository\Currency $creditRepo */
        $creditRepo = $option->repository("DBTech\Credits:Currency");

        return self::getSelectRow($option, $htmlParams, $creditRepo->getCurrencyTitlePairs());
    }
}