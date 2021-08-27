<?php


namespace Terrasphere\Core\Admin\Controller;


use Terrasphere\Core\Entity\RankSchema;
use XF\Mvc\Entity\Entity;
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

        //find the rankSchemaMap associated with the rankSchema if there are any
        $rankSchemaMap = $this->finder("Terrasphere\Core:RankSchemaMap")->where('rank_schema_id', $rankSchema->rank_schema_id)->fetch();

        //load all ranks we have
        $ranks = $this->finder("Terrasphere\Core:Rank")->fetch();

        //empty array to push values into
        $paramThing = [];

        ///for each rank in ranks we check if the ID is already present in the rankSchemaMap (that has been pre-filtered with the rankSchemaID)
        /// if an entry exists, we use that cost
        /// if it doesn't, we use 0 as a cost
        foreach ($ranks as $rank) {
            $cost = 0;
            foreach ($rankSchemaMap as $schema) {
                if ($rank->rank_id == $schema->rank_id) $cost = $schema->cost;
            }

            //Pre-format the rank information we need to populate the loop field
            //TODO: Maybe a repo is better, but we don't use this anywhere else
            array_push($paramThing, [
                'rank_id' => $rank->rank_id,
                'schema_id' => $rankSchema->rank_schema_id,
                'rank_name' => $rank->name,
                'cost' => $cost
            ]);
        }

        $viewParams = [
            "rankSchema" => $rankSchema,
            "rankParams" => $paramThing,
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

    public function actionSave(ParameterBag $params): Redirect
    {
        $this->assertPostOnly();

        ///---------------------
        /// Save the rankSchema
        /// --------------------
        if ($params->rank_schema_id)
            $rankSchema = $this->assertRecordExists("Terrasphere\Core:RankSchema", $params->rank_schema_id);
        else
            $rankSchema = $this->em()->create("Terrasphere\Core:RankSchema");

        $this->saveSchema($rankSchema)->run();

        ///---------------------
        /// Save the rankSchemaMap
        /// --------------------
        $ranks = $this->finder("Terrasphere\Core:Rank")->fetch();

        //loop through every rank to save an entry in the rank SchemaMap
        //todo better way to bulk save stuff...?
        foreach ($ranks as $rank) {
            $rankSchemaMapRecord = $this->finder("Terrasphere\Core:RankSchemaMap")->where('rank_schema_id', $rankSchema->rank_schema_id)->where('rank_id',$rank->rank_id)->fetchOne();
            //todo assertRecord exists throws an alternate route to go to if it doesn't exist, but in this case what would be better is
            if($rankSchemaMapRecord)
                $rankSchemaMap = $this->assertRecordExists("Terrasphere\Core:RankSchemaMap",[$params->rank_schema_id,$rank->rank_id]);
            else
                $rankSchemaMap = $this->em()->create("Terrasphere\Core:RankSchemaMap");

            $this->saveMaping($rankSchemaMap, $rank->rank_id,$rankSchema->rank_schema_id)->run();
        }

        return $this->redirect($this->buildLink('terrasphere-core/rank-schemas'));
    }

    public function actionDelete(ParameterBag $params)
    {
        $rankSchema = $this->assertRecordExists("Terrasphere\Core:RankSchema", $params->rank_schema_id);
        /** @var \XF\ControllerPlugin\Delete $plugin */

        $randEqui = $this->finder("Terrasphere\Core:Equipment")->fetchOne();
        if($rankSchema->rank_schema_id == $randEqui->rank_schema_id){
            return $this->error('Do not delete the Equipment Schema. For more help ask your local dev.');
        }
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $rankSchema,
            $this->buildLink('terrasphere-core/rank-schemas/delete', $rankSchema),
            $this->buildLink('terrasphere-core/rank-schemas/edit', $rankSchema),
            $this->buildLink('terrasphere-core/rank-schemas/'),
            $rankSchema->name
        );
    }

    private function saveSchema(RankSchema $rankSchema): FormAction
    {
        $form = $this->formAction();

        $input = $this->filter([
            'name' => 'str',
            'currency_id' => 'uint'
        ]);

        $form->basicEntitySave($rankSchema, $input);

        return $form;
    }

    private function saveMaping($rankSchemaMap, $rank_id,$rank_schema_id): FormAction
    {
        $form = $this->formAction();

        $cost = $this->filter($rank_id, 'uint');
        $input = [
            'rank_id' => $rank_id,
            'rank_schema_id' => $rank_schema_id,
            'cost' => $cost
        ];

        $form->basicEntitySave($rankSchemaMap,$input);

        return $form;

    }

}