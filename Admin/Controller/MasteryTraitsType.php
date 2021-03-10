<?php

namespace Terrasphere\Core\Admin\Controller;

use Terrasphere\Core\Entity\MasteryType;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class MasteryTraitsType extends AbstractController
{
    public function actionIndex(): \XF\Mvc\Reply\Redirect
    {
        return $this->redirect($this->buildLink('terrasphere-core/masteries/traits'));
    }

    public function actionAddOrEdit(MasteryType $masteryType): \XF\Mvc\Reply\View
    {
        $viewParams = [
            'masteryType' => $masteryType,
        ];

        return $this->view('Terrasphere\Core:MasteryType\Edit', 'terrasphere_core_mastery_type_edit', $viewParams);
    }

    public function actionAdd(): \XF\Mvc\Reply\View
    {
        $newType = $this->em()->create('Terrasphere\Core:MasteryType');
        return $this->actionAddOrEdit($newType);
    }

    public function actionEdit(ParameterBag $params): \XF\Mvc\Reply\View
    {
        $masteryType = $this->assertRecordExists('Terrasphere\Core:MasteryType', $params->mastery_type_id);
        return $this->actionAddOrEdit($masteryType);
    }

    public function actionSave(ParameterBag $params): \XF\Mvc\Reply\Redirect
    {
        $this->assertPostOnly();

        if ($params->mastery_type_id)
            $masteryType = $this->assertRecordExists('Terrasphere\Core:MasteryType', $params->mastery_type_id);
        else
            $masteryType = $this->em()->create('Terrasphere\Core:MasteryType');

        $this->save($masteryType)->run();

        return $this->actionIndex();
    }

    public function save(MasteryType $masteryType): \XF\Mvc\FormAction
    {
        $form = $this->formAction();

        $input = $this->filter([
            'name' => 'str',
            'cap_per_character' => 'uint',

            //'icon_url' => 'str',
            //'thumbnail_url' => 'str',
        ]);

        $form->basicEntitySave($masteryType, $input);

        return $form;
    }
}