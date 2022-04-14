<?php

namespace Terrasphere\Core\Admin\Controller;

use Terrasphere\Core\Entity\BannerButton;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\Exception;
use XF\Mvc\Reply\View;

class BannerButtons extends AbstractController
{
    public function actionIndex(): View
    {
        $bannerButtons = $this->finder('Terrasphere\Core:BannerButton')->fetch()->toArray();
        return $this->view('Terrasphere/Core:BannerButton/List', 'terrasphere_core_banner_buttons', [ 'bannerButtons' => $bannerButtons ]);
    }

    public function actionAddOrEdit(BannerButton $button): View
    {
        return $this->view('Terrasphere\Core:BannerButton\Edit', 'terrasphere_core_banner_button_edit', [ 'button' => $button ]);
    }

    public function actionAdd(): View
    {
        $newButton = $this->em()->create('Terrasphere\Core:BannerButton');
        return $this->actionAddOrEdit($newButton);
    }

    public function actionEdit(ParameterBag $params): View
    {
        $newButton = $this->assertRecordExists('Terrasphere\Core:BannerButton', $params->banner_button_id);
        return $this->actionAddOrEdit($newButton);
    }

    public function actionDelete(ParameterBag $params)
    {
        $bannerButton = $this->assertRecordExists("Terrasphere\Core:BannerButton", $params->banner_button_id);

        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $bannerButton,
            $this->buildLink('terrasphere-core/banner-buttons/delete', $bannerButton),
            $this->buildLink('terrasphere-core/banner-buttons/edit', $bannerButton),
            $this->buildLink('terrasphere-core/banner-buttons/'),
            $bannerButton['name']
        );
    }

    public function actionSave(ParameterBag $params)
    {
        try {
            $this->assertPostOnly();

            if ($params->banner_button_id) $button = $this->assertRecordExists('Terrasphere\Core:BannerButton', $params->banner_button_id);
            else $button = $this->em()->create('Terrasphere\Core:BannerButton');

        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }

        $this->save($button)->run();

        return $this->redirect($this->buildLink('terrasphere-core/banner-buttons'));
    }

    public function save(BannerButton $button): \XF\Mvc\FormAction
    {
        $form = $this->formAction();

        $input = $this->filter([
            'name' => 'str',
            'icon_url' => 'str',
            'url' => 'str',
            'behavior' => 'uint',
        ]);

        $form->basicEntitySave($button, $input);

        return $form;
    }
}