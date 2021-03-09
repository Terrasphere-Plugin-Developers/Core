<?php

namespace Terrasphere\Core\Admin\Controller;

use XF\Admin\Controller\AbstractController;

class MasteryList extends AbstractController
{
    /**
     * @return \XF\Mvc\Reply\View
     */
    public function actionIndex(): \XF\Mvc\Reply\View
    {
        $viewParams = [];

        /** @var \Terrasphere\Core\Entity\MasteryType[] $masteryTypes */
        $masteryTypes = $this->finder('Terrasphere\Core:MasteryType')->fetch();

        /**
         * For each mastery type, create an array with the type's name and another array populated by the masteries of
         * that mastery type, then add the name|mastery-array pair to $viewParams.
         */
        foreach ($masteryTypes as $masteryType)
        {
            $viewParams[$masteryType['type_id']] = [
                'type_name' => $masteryType['name'],
                'mastery_list' => $this->finder('Terrasphere\Core:Mastery')->where('type_id', $masteryType['type_id'])->fetch()
            ];
        }

        return $this->view('Terrasphere/Core:Mastery/List', 'terrasphere_core_mastery_list', $viewParams);
    }
}