<?php

namespace Terrasphere\Core\Admin\Controller;

use Terrasphere\Core\Entity\MasteryRole;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class MasteryTraitsRole extends AbstractController
{
    public function actionIndex(): \XF\Mvc\Reply\Redirect
    {
        return $this->redirect($this->buildLink('terrasphere-core/masteries/traits'));
    }

    public function actionAddOrEdit(MasteryRole $role): \XF\Mvc\Reply\View
    {
        $viewParams = [
            'role' => $role,
        ];

        return $this->view('Terrasphere\Core:MasteryRole\Edit', 'terrasphere_core_role_edit', $viewParams);
    }

    public function actionAdd(): \XF\Mvc\Reply\View
    {
        $newRole = $this->em()->create('Terrasphere\Core:MasteryRole');
        return $this->actionAddOrEdit($newRole);
    }

    public function actionEdit(ParameterBag $params): \XF\Mvc\Reply\View
    {
        $role = $this->assertRecordExists('Terrasphere\Core:MasteryRole', $params->role_id);
        return $this->actionAddOrEdit($role);
    }

    public function actionSave(ParameterBag $params): \XF\Mvc\Reply\Redirect
    {
        $this->assertPostOnly();

        if ($params->role_id)
            $role = $this->assertRecordExists('Terrasphere\Core:MasteryRole', $params->role_id);
        else
            $role = $this->em()->create('Terrasphere\Core:MasteryRole');

        $this->save($role)->run();

        return $this->actionIndex();
    }

    public function save(MasteryRole $role): \XF\Mvc\FormAction
    {
        $form = $this->formAction();

        $input = $this->filter([
            'name' => 'str',

            //'icon_url' => 'str',
            //'thumbnail_url' => 'str',
        ]);

        $form->basicEntitySave($role, $input);

        return $form;
    }
}