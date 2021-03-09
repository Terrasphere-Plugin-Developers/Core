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
        //$repo = $this->repository('Terrasphere/Core:Mastery');
        $viewParams = [];
        return $this->view('Terrasphere/Core:Mastery/List', 'terrasphere_core_mastery_list', $viewParams);
    }
}