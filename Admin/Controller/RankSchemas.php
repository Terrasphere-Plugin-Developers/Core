<?php


namespace Terrasphere\Core\Admin\Controller;


use XF\Mvc\Reply\View;

class RankSchemas extends \XF\Admin\Controller\AbstractController
{

    public function actionIndex(): View
    {
        $viewParams = ["Hi","Moo"];
        return $this->view('Terrasphere\Core:RankSchema', 'terrasphere_core_rank_schema_list', $viewParams);
    }

}