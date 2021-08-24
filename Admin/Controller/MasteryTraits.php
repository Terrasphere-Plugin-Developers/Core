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
    //TODO: find a better way to compare the shortName - some sort of get_class, or a static thing getShortName...?
    private $typeShortName = "Terrasphere\Core:MasteryType";
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
        if($shortName == $this->typeShortName){
            $templateName = "terrasphere_core_mastery_trait_type_edit";
        }
        $viewParams = [
            'trait' => $trait,
            'rankSchemas' => $this->finder('Terrasphere\Core:RankSchema')->fetch(),
        ];

        return $this->view('Terrasphere\Core:Mastery\Traits\Edit', $templateName, $viewParams);
    }

    public function actionAdd(ParameterBag $params): View
    {
        $type = $this->filter('type','str');
        $newTrait = $this->em()->create("Terrasphere\Core:Mastery".$type);

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

        //Type has different values than the other traits, so different save functions
        if($entityShortName == $this->typeShortName){
            $this->saveTypeTrait($trait)->run();
        }else{
            $this->saveBaseTrait($trait)->run();
        }


        return $this->redirect($this->buildLink('terrasphere-core/masteries/traits'));
    }

    protected function getRouteRepo()
    {
        return $this->repository('XF:Route');
    }

    public function saveBaseTrait($trait): \XF\Mvc\FormAction
    {
        $form = $this->formAction();

        $input = $this->filter([
            'name' => 'str',
            'css_classes' => 'str',
            'hex_color' => 'str',
        ]);

        $form->basicEntitySave($trait, $input);

        return $form;
    }

    public function saveTypeTrait($trait): \XF\Mvc\FormAction
    {
        $form = $this->formAction();

        $input = $this->filter([
            'name' => 'str',
            'icon_url' => 'str',
            'cap_per_character' => 'uint',
            'rank_schema_id' => 'uint',
        ]);

        $form->basicEntitySave($trait, $input);

        return $form;
    }
}