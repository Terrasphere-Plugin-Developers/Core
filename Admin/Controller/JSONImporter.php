<?php

namespace Terrasphere\Core\Admin\Controller;

use Terrasphere\Core\Repository\Mastery;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\Reply\View;

class JSONImporter extends AbstractController
{
    public function actionIndex(): View
    {
        return $this->view('Terrasphere\Core:JSONImporter', 'terrasphere_core_json_importer', []);
    }

    public function actionMasteryImport()
    {
        $params = [];
        $rawJson = $this->filter('content', 'str');
        $content = json_decode($rawJson, true);

        $roles = $this->finder('Terrasphere\Core:MasteryRole')->fetch();
        $saves = $this->finder('Terrasphere\Core:MasterySave')->fetch();
        $expertises = $this->finder('Terrasphere\Core:MasteryExpertise')->fetch();
        $types = $this->finder('Terrasphere\Core:MasteryType')->fetch();

        $notAdded = [];

        $insertSQL = [];
        foreach ($content as $mastery) {
            $item = [];

            // Find and add save.
            $found = -1;
            foreach ($saves as $save)
            {
                if(strtolower($mastery['save']) == strtolower($save['name']))
                {
                    $found = $save['save_id'];
                    break;
                }
                if(strtolower($mastery['save']) == '-')
                {
                    $found = 1;
                    break;
                }
            }
            if($found == -1)
            {
                array_push($notAdded, $this->notFoundString($mastery, "Save ".$mastery['save']." not found\n"));
                continue;
            }
            $item['save_id'] = $found;

            // Find and add role.
            $found = -1;
            foreach ($roles as $role)
            {
                if(strtolower($mastery['role']) == strtolower($role['name']))
                {
                    $found = $role['role_id'];
                    break;
                }
            }
            if($found == -1)
            {
                if($mastery['role'] == 'alter')
                {
                    $found = 1;
                    array_push($notAdded, "WARNING: Alter mastery's role defaulted to ID 1.\n");
                }
                else
                {
                    array_push($notAdded, $this->notFoundString($mastery, "Role ".$mastery['role']." not found\n"));
                    continue;
                }
            }
            $item['role_id'] = $found;

            // Find and add expertise.
            $found = -1;
            foreach ($expertises as $exp)
            {
                if(strtolower($mastery['expertise']) == strtolower($exp['name']))
                {
                    $found = $exp['expertise_id'];
                    break;
                }
                if(strtolower($mastery['expertise']) == '-')
                {
                    $found = 1;
                    break;
                }
            }
            if($found == -1)
            {
                array_push($notAdded, $this->notFoundString($mastery, "Expertise ".$mastery['expertise']." not found\n"));
                continue;
            }
            $item['expertise_id'] = $found;

            // Find and add type.
            $found = -1;
            foreach ($types as $type)
            {
                if(trim(strtolower($mastery['role'])) == trim(strtolower($type['name'])))
                {
                    $found = $type['mastery_type_id'];
                    break;
                }
            }
            if($found == -1)
            {
                $found = 1;
            }
            $item['mastery_type_id'] = $found;
            $item['display_name'] = $mastery['name'];
            $item['icon_url'] = $mastery['image'];
            $item['color'] = $mastery['color'];

            array_push($insertSQL, $item);
        }

        /** @var Mastery $masteryRepo */
        $masteryRepo = $this->repository('Terrasphere\Core:Mastery');
        var_dump($notAdded);
        $masteryRepo->massInsert($insertSQL);
        return $this->view('Terrasphere\Core:JSONImporter', 'terrasphere_core_json_importer', $params);
    }

    private function notFoundString($mastery, $reason): string
    {
        return $mastery['name'] . ": " . $reason;
    }
}