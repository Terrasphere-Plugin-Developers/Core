<?php


namespace Terrasphere\Core\Admin\Controller;


use Terrasphere\Core\Entity\RankSchema;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\Redirect;
use XF\Mvc\Reply\View;

class RankSchemas extends \XF\Admin\Controller\AbstractController
{

    public function actionIndex(): View
    {
        $rankSchemas = $this->finder('Terrasphere\Core:RankSchema')->fetch();
        $viewParams = [
            'rankSchemas' => $rankSchemas
        ];
        return $this->view('Terrasphere\Core:RankSchema', 'terrasphere_core_rank_schema_list', $viewParams);
    }

    public function actionAddOrEdit(RankSchema $rankSchema): View
    {
        $viewParams = [
            "rankSchema" => $rankSchema,
            "currencies" => $this->finder("DBTech\Credits:Currency")->fetch()
        ];

        return $this->view("Terrasphere\Core:RankSchema\Edit", "terrasphere_core_rank_schema_edit", $viewParams);
    }

    public function actionAdd(): View
    {
        $newRankSchema = $this->em()->create("Terrasphere\Core:RankSchema");
        return $this->actionAddOrEdit($newRankSchema);
    }

    public function actionEdit(ParameterBag $params): View
    {
        $rankSchema = $this->assertRecordExists("Terrasphere\Core:RankSchema", $params->rank_schema_id);
        return $this->actionAddOrEdit($rankSchema);
    }

    public function actionSave(ParameterBag $params) : Redirect{
        $this->assertPostOnly();

        if($params->rank_schema_id)
            $rankSchema = $this->assertRecordExists("Terrasphere\Core:RankSchema",$params->rank_schema_id);
        else
            $rankSchema = $this->em()->create("Terrasphere\Core:RankSchema");

        $this->save($rankSchema)->run();

        return $this->redirect($this->buildLink('terrasphere-core/rank-schemas'));
    }
    public function actionDelete(ParameterBag $params)
    {
        $rankSchema = $this->assertRecordExists("Terrasphere\Core:RankSchema",$params->rank_schema_id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $rankSchema,
            $this->buildLink('terrasphere-core/rank-schemas/delete', $rankSchema),
            $this->buildLink('terrasphere-core/rank-schemas/edit', $rankSchema),
            $this->buildLink('terrasphere-core/rank-schemas/'),
            $rankSchema->rank_schema_id
        );
    }

    public function save(RankSchema $rankSchema):FormAction{
        $form = $this->formAction();

        $input = $this->filter([
            'name' => 'str',
            'rank_d' => 'uint',
            'rank_c' => 'uint',
            'rank_b' => 'uint',
            'rank_a' => 'uint',
            'rank_s' => 'uint',
            'currency_type' => 'uint'
        ]);

        $form->basicEntitySave($rankSchema,$input);

        return $form;
    }

}