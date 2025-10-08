<?php

namespace Terrasphere\Core\Admin\Controller;

use Terrasphere\Core\Entity\Expertise;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class Expertises extends AbstractController
{
    /**
     * Default for terrasphere-core/expertise should be a redirect to expertise-list. You can't click on
     * the link for /expertise, but if you COULD, this would fix it.
     *
     * @return \XF\Mvc\Reply\Redirect
     */
    public function actionIndex(): View
    {
        $viewParams = [];

        /** @var \Terrasphere\Core\Repository\Expertise $expertiseRepo */
        $expertiseRepo = $this->repository('Terrasphere\Core:Expertise');

        $viewParams['expertiseGroups'] = $expertiseRepo->getExpertiseList();

        return $this->view('Terrasphere\Core:Expertises', 'terrasphere_core_expertise_list', $viewParams);
    }

    public function actionAddOrEdit(Expertise $expertise): \XF\Mvc\Reply\View
    {
        $viewParams = [
            'expertise' => $expertise,
            'roleTypes' => $this->finder('Terrasphere\Core:MasteryRole')->fetch(), // Not a typo, we're using this
        ];

        return $this->view('Terrasphere\Core:Expertise\Edit', 'terrasphere_core_expertise_edit', $viewParams);
    }

    public function actionAdd(): \XF\Mvc\Reply\View
    {
        $newExpertise = $this->em()->create('Terrasphere\Core:Expertise');
        return $this->actionAddOrEdit($newExpertise);
    }

    public function actionEdit(ParameterBag $params): \XF\Mvc\Reply\View
    {
        $expertise = $this->assertRecordExists('Terrasphere\Core:Expertise', $params->expertise_id);
        return $this->actionAddOrEdit($expertise);
    }

    public function actionSave(ParameterBag $params): \XF\Mvc\Reply\Redirect
    {
        $this->assertPostOnly();

        if ($params->expertise_id)
            $expertise = $this->assertRecordExists('Terrasphere\Core:Expertise', $params->expertise_id);
        else
            $expertise = $this->em()->create('Terrasphere\Core:Expertise');

        $this->save($expertise)->run();

        return $this->redirect($this->buildLink('terrasphere-core/expertise'));
    }

    public function save(Expertise $expertise): \XF\Mvc\FormAction
    {
        $form = $this->formAction();

        $input = $this->filter([
            'display_name' => 'str',

            'role_id' => 'uint',

            'icon_url' => 'str',
            'thumbnail_url' => 'str',
            'wiki_url' => 'str',

            'color' => 'str',
        ]);

        $form->basicEntitySave($expertise, $input);

        return $form;
    }

    public function actionDelete(ParameterBag $params){
        $expertise = $this->assertRecordExists('Terrasphere\Core:Expertise', $params->expertise_id);
        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');

        return $plugin->actionDelete(
            $expertise,
            $this->buildLink('terrasphere-core/expertise/delete', $expertise),
            $this->buildLink('terrasphere-core/expertise/edit', $expertise),
            $this->buildLink('terrasphere-core/expertise'),
            $expertise->display_name
        );
    }
}
