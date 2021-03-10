<?php

namespace Terrasphere\Core\Admin\Controller;

use Terrasphere\Core\Entity\MasterySave;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class MasteryTraitsSave extends AbstractController
{
    public function actionIndex(): \XF\Mvc\Reply\Redirect
    {
        return $this->redirect($this->buildLink('terrasphere-core/masteries/traits'));
    }

    public function actionAddOrEdit(MasterySave $save): \XF\Mvc\Reply\View
    {
        $viewParams = [
            'save' => $save,
        ];

        return $this->view('Terrasphere\Core:MasterySave\Edit', 'terrasphere_core_save_edit', $viewParams);
    }

    public function actionAdd(): \XF\Mvc\Reply\View
    {
        $newSave = $this->em()->create('Terrasphere\Core:MasterySave');
        return $this->actionAddOrEdit($newSave);
    }

    public function actionEdit(ParameterBag $params): \XF\Mvc\Reply\View
    {
        $save = $this->assertRecordExists('Terrasphere\Core:MasterySave', $params->save_id);
        return $this->actionAddOrEdit($save);
    }

    public function actionSave(ParameterBag $params): \XF\Mvc\Reply\Redirect
    {
        $this->assertPostOnly();

        if ($params->save_id)
            $save = $this->assertRecordExists('Terrasphere\Core:MasterySave', $params->save_id);
        else
            $save = $this->em()->create('Terrasphere\Core:MasterySave');

        $this->save($save)->run();

        return $this->actionIndex();
    }

    public function save(MasterySave $save): \XF\Mvc\FormAction
    {
        $form = $this->formAction();

        $input = $this->filter([
            'name' => 'str',

            //'icon_url' => 'str',
            //'thumbnail_url' => 'str',
        ]);

        $form->basicEntitySave($save, $input);

        return $form;
    }
}