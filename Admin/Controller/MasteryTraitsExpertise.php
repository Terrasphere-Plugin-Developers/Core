<?php

namespace Terrasphere\Core\Admin\Controller;

use Terrasphere\Core\Entity\MasteryExpertise;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class MasteryTraitsExpertise extends AbstractController
{
    public function actionIndex(): \XF\Mvc\Reply\Redirect
    {
        return $this->redirect($this->buildLink('terrasphere-core/masteries/traits'));
    }

    public function actionAddOrEdit(MasteryExpertise $expertise): \XF\Mvc\Reply\View
    {
        $viewParams = [
            'expertise' => $expertise,
        ];

        return $this->view('Terrasphere\Core:MasteryExpertise\Edit', 'terrasphere_core_expertise_edit', $viewParams);
    }

    public function actionAdd(): \XF\Mvc\Reply\View
    {
        $newExpertise = $this->em()->create('Terrasphere\Core:MasteryExpertise');
        return $this->actionAddOrEdit($newExpertise);
    }

    public function actionEdit(ParameterBag $params): \XF\Mvc\Reply\View
    {
        $expertise = $this->assertRecordExists('Terrasphere\Core:MasteryExpertise', $params->expertise_id);
        return $this->actionAddOrEdit($expertise);
    }

    public function actionSave(ParameterBag $params): \XF\Mvc\Reply\Redirect
    {
        $this->assertPostOnly();

        if ($params->expertise_id)
            $expertise = $this->assertRecordExists('Terrasphere\Core:MasteryExpertise', $params->expertise_id);
        else
            $expertise = $this->em()->create('Terrasphere\Core:MasterOhyExpertise');

        $this->save($expertise)->run();

        return $this->actionIndex();
    }

    public function save(MasteryExpertise $expertise): \XF\Mvc\FormAction
    {
        $form = $this->formAction();

        $input = $this->filter([
            'name' => 'str',

            //'icon_url' => 'str',
            //'thumbnail_url' => 'str',
        ]);

        $form->basicEntitySave($expertise, $input);

        return $form;
    }
}