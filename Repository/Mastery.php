<?php

namespace Terrasphere\Core\Repository;

use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Mastery extends Repository
{
    /**
     * Groups all masteries and returns these groups in an array.
     *
     * First, normal masteries are grouped by role. Then, remaining non-normal typed masteries are grouped by type.
     *
     * Return value is an array of unordered sets of 3:
     * 'name' => String containing the role/type's name.
     * 'isNormal' => Boolean. True if this is a normal-type mastery, false otherwise.
     * 'masteries' => An array of Mastery entities.
     *
     * @return array
     */
    public function getMasteryListGroupedByClassification(): array
    {
        // Get normal-type masteries.
        $queryResults = $this
            ->finder('Terrasphere\Core:Mastery')
            ->with(["MasteryType", "MasteryRole"])
            ->where('mastery_type_id', 1)
            ->order('role_id', 'ASC')
            ->fetch();

        // An associative array, mapping role_id values to arrays of mastery entities with matiching role_ids.
        // At this point, this includes only normal-type masteries.
        $masteryGroups = $queryResults->groupBy('role_id');

        // Changes mastery group array from a list of mastery arrays, to a list of 3-tuples matching return structure.
        foreach ($masteryGroups as $roleID => $masteryList)
        {
            if(count($masteryList) == 0)
                continue; // Should never happen, but just in case.

            $firstMasteryIndex = array_keys($masteryList)[0];

            $masteryGroups[$roleID] = [
                'name' => $masteryList[$firstMasteryIndex]->MasteryRole->name,
                'isNormal' => true,
                'masteries' => $masteryList,
            ];
        }

        // Get non-normal-type masteries.
        $queryResults = $this
            ->finder('Terrasphere\Core:Mastery')
            ->with(["MasteryType", "MasteryRole"])
            ->where('mastery_type_id', '!=', 1)
            ->order('role_id', 'ASC')
            ->order('mastery_type_id', 'ASC')
            ->fetch();

        $altTypeGroups = $queryResults->groupBy('mastery_type_id');

        foreach ($altTypeGroups as $typeID => $masteryList)
        {
            if(count($masteryList) == 0)
                continue; // Should never happen, but just in case.

            $firstMasteryIndex = array_keys($masteryList)[0];

            $masteryGroups['type_'.$typeID] = [
                'name' => $masteryList[$firstMasteryIndex]->MasteryType->name,
                'isNormal' => 0, // For some reason, false doesn't show up as 0, so I'm just passing in 0...
                'masteries' => $masteryList,
            ];
        }

        // Useful trick for printing formatted array structure.
        /*print "<pre>";
        print_r($masteryGroups);
        print "</pre>";*/

        return $masteryGroups;
    }
}