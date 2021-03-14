<?php

namespace Terrasphere\Core\Admin\Controller;

use Terrasphere\Core\Entity\MasteryExpertise;
use Terrasphere\Core\Entity\MasteryType;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\Entity\Structure;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class MasteryTraits extends AbstractController
{
    public function actionIndex(): View
    {
        $masteryType = $this->finder('Terrasphere\Core:MasteryType')->where('system_type',false)->fetch();
        $masteryRole = $this->finder('Terrasphere\Core:MasteryRole')->fetch();
        $masterySave = $this->finder('Terrasphere\Core:MasterySave')->fetch();
        $masteryExpertise = $this->finder('Terrasphere\Core:MasteryExpertise')->fetch();


        //currently the add-mastery stuff is populated by the names of this, and the names corrospond with the proper shortNames
        //so please don't change them to plural until you(or I) found out how one can access an array in the html templates by index without
        //having to write a loop
        $traitTypes = [
            "Type" => $masteryType,
            "Role" => $masteryRole,
            "Save" => $masterySave,
            "Expertise" => $masteryExpertise
        ];

        $viewParams = [
            'traitTypes' => $traitTypes,
        ];

        return $this->view('Terrasphere\Core:Mastery\Traits', 'terrasphere_core_mastery_traits', $viewParams);
    }

    public function actionAddOrEdit($trait): View
    {

        $shortName = $trait->entityShortName;
        $templateName = "terrasphere_core_mastery_trait_basic_edit";


        //Redirect to proper template depending on what type of trait it is
        //TODO: find a better way to compare the shortName - some sort of get_class, or a static thing getShortName...?
        if($shortName == "Terrasphere\Core:MasteryType"){
            $templateName = "terrasphere_core_mastery_trait_type_edit";
        }
        $viewParams = [
            'trait' => $trait
        ];

        return $this->view('Terrasphere\Core:Mastery\Traits\Edit', $templateName, $viewParams);
    }

    public function actionAdd(ParameterBag $params): View
    {
        $type = $this->filter('type','str');
        $newTrait = $this->em()->create($type);

        return $this->actionAddOrEdit($newTrait);
    }

    public function actionEdit(ParameterBag $params): \XF\Mvc\Reply\View
    {
        $category = $this->filter("traitCategory","string");
        $trait = $this->assertRecordExists($category, $params->id);

        return $this->actionAddOrEdit($trait);
    }



    //It's called dumb because for some reason the save route doesn't work
    public function actionDumb(ParameterBag $params): \XF\Mvc\Reply\Redirect
    {
        $this->assertPostOnly();
        $category = $this->filter("traitCategory","string");
        $entityShortName = $category;

       if ($params->id)
            $trait = $this->assertRecordExists($entityShortName, $params->id);
        else
            $trait = $this->em()->create($entityShortName);

        $this->save($trait)->run();

        return $this->redirect($this->buildLink('terrasphere-core/masteries/traits'));
    }


    protected function getRouteRepo()
    {
        return $this->repository('XF:Route');
    }

    public function save($expertise): \XF\Mvc\FormAction
    {
        $form = $this->formAction();

        $input = $this->filter([
            'name' => 'str',
            'icon_url' => 'str',
            //'thumbnail_url' => 'str',
        ]);

        $form->basicEntitySave($expertise, $input);

        return $form;
    }
}