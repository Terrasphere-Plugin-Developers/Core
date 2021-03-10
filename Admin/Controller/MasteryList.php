<?php

namespace Terrasphere\Core\Admin\Controller;

use XF;
use XF\Admin\Controller\AbstractController;

class MasteryList extends AbstractController
{
    public function actionIndex(): \XF\Mvc\Reply\View
    {
        $viewParams = [];

        /** @var \Terrasphere\Core\Repository\Mastery $masteryRepo */
        $masteryRepo = $this->repository('Terrasphere\Core:Mastery');

        $viewParams['masteryGroups'] = $masteryRepo->getMasteryListGroupedByClassification();

        return $this->view('Terrasphere/Core:Mastery/List', 'terrasphere_core_mastery_list', $viewParams);
    }
}