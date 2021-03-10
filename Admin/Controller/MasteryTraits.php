<?php

namespace Terrasphere\Core\Admin\Controller;

use XF\Admin\Controller\AbstractController;

class MasteryTraits extends AbstractController
{
    public function actionIndex(): \XF\Mvc\Reply\View
    {
        $viewParams = [
            'specialTypes' => $this->finder('Terrasphere\Core:MasteryType')->fetch(),
            'roles' => $this->finder('Terrasphere\Core:MasteryRole')->fetch(),
            'saves' => $this->finder('Terrasphere\Core:MasterySave')->fetch(),
            'expertises' => $this->finder('Terrasphere\Core:MasteryExpertise')->fetch(),
        ];

        return $this->view('Terrasphere/Core:Mastery/Traits', 'terrasphere_core_mastery_traits', $viewParams);
    }
}