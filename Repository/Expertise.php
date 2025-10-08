<?php

namespace Terrasphere\Core\Repository;

use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Expertise extends Repository
{
    /**
     * Groups all expertise and returns these groups in an array.
     *
     * First, normal expertise are grouped by role. Then, remaining non-normal typed expertise are grouped by type.
     *
     * Return value is an array of unordered sets of 2:
     * 'name' => String containing the role/type's name.
     * 'experts' => An array of Expertise entities.
     *
     * @return array
     */
    public function getExpertiseList(): array
    {
        // Get normal-type expertise.
        $queryResults = $this
            ->finder('Terrasphere\Core:Expertise')
            ->with(["ExpertiseRole"])
            ->order('role_id', 'ASC')
            ->fetch();

        $expertiseGroups = $queryResults->groupBy('role_id');

        // Changes group array from an array of expertise arrays, to an array of 3-tuples matching return structure.
        foreach ($expertiseGroups as $roleID => $expertiseList)
        {
            if(count($expertiseList) == 0)
                continue; // Should never happen, but just in case.

            $firstExpertiseIndex = array_keys($expertiseList)[0];

            $expertiseGroups[$roleID] = [
                'name' => $expertiseList[$firstExpertiseIndex]->ExpertiseRole->name,
                'isNormal' => true,
                'expertises' => $expertiseList,
            ];
        }

        // Useful trick for printing formatted array structure.
        /*print "<pre>";
        print_r($expertiseGroups);
        print "</pre>";*/

        return $expertiseGroups;
    }

    /**
     * @param int $masteryID
     * @return \Terrasphere\Core\Entity\Mastery || null
     */
    public function getExpertiseByID(int $masteryID)
    {
        return $this
            ->finder('Terrasphere\Core:Mastery')
            ->where('mastery_id', $masteryID)
            ->fetchOne();
    }

    /**
     * @param int $expertiseID
     * @return \Terrasphere\Core\Entity\Expertise
     */
    public function getExpertiseWithTraitsByID(int $expertiseID): \Terrasphere\Core\Entity\Expertise
    {
        return $this
        ->finder('Terrasphere\Core:Expertise')
        //->with(["MasteryType", "MasteryRole", "MasteryExpertise", "MasterySave"])
        ->with(["ExpertiseRole"])
        ->where('expertise_id', $expertiseID)
        ->fetchOne();
    }

    public function massInsert(array $sql)
    {
        $this->db()->insertBulk("xf_terrasphere_core_expertise", $sql);
    }
}