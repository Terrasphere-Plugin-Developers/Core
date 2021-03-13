<?php

namespace Terrasphere\Core\Admin\Controller;

use Terrasphere\Core\Entity\Mastery;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class Masteries extends AbstractController
{
    /**
     * Default for terrasphere-core/masteries should be a redirect to mastery-list. You can't actually click on
     * the link for /masteries, but if you COULD, this would fix it. 10/10; solutions to non-problems.
     *
     * @return \XF\Mvc\Reply\Redirect
     */
    public function actionIndex(): View
    {
        $viewParams = [];

        /** @var \Terrasphere\Core\Repository\Mastery $masteryRepo */
        $masteryRepo = $this->repository('Terrasphere\Core:Mastery');

        $viewParams['masteryGroups'] = $masteryRepo->getMasteryListGroupedByClassification();

        return $this->view('Terrasphere\Core:Mastery', 'terrasphere_core_mastery_list', $viewParams);
    }

    public function actionAddOrEdit(Mastery $mastery): \XF\Mvc\Reply\View
    {
        $viewParams = [
            'mastery' => $mastery,
            'masteryTypes' => $this->finder('Terrasphere\Core:MasteryType')->fetch(),
            'roleTypes' => $this->finder('Terrasphere\Core:MasteryRole')->fetch(),
            'saveTypes' => $this->finder('Terrasphere\Core:MasterySave')->fetch(),
            'expertiseTypes' => $this->finder('Terrasphere\Core:MasteryExpertise')->fetch(),
        ];

        return $this->view('Terrasphere\Core:Mastery\Edit', 'terrasphere_core_mastery_edit', $viewParams);
    }

    public function actionAdd(): \XF\Mvc\Reply\View
    {
        $newMastery = $this->em()->create('Terrasphere\Core:Mastery');
        return $this->actionAddOrEdit($newMastery);
    }

    public function actionEdit(ParameterBag $params): \XF\Mvc\Reply\View
    {
        $mastery = $this->assertRecordExists('Terrasphere\Core:Mastery', $params->mastery_id);
        return $this->actionAddOrEdit($mastery);
    }

    public function actionSave(ParameterBag $params): \XF\Mvc\Reply\Redirect
    {
        $this->assertPostOnly();

        if ($params->mastery_id)
            $mastery = $this->assertRecordExists('Terrasphere\Core:Mastery', $params->mastery_id);
        else
            $mastery = $this->em()->create('Terrasphere\Core:Mastery');

        $this->save($mastery)->run();

        return $this->redirect($this->buildLink('terrasphere-core/masteries'));
    }

    public function save(Mastery $mastery): \XF\Mvc\FormAction
    {
        $form = $this->formAction();

        $input = $this->filter([
            'display_name' => 'str',

            'mastery_type_id' => 'uint',
            'role_id' => 'uint',
            'save_id' => 'uint',
            'expertise_id' => 'uint',

            'icon_url' => 'str',
            'thumbnail_url' => 'str',
        ]);

        $form->basicEntitySave($mastery, $input);

        return $form;
    }
}
