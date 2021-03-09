<?php

namespace Terrasphere\Core\Admin\Controller;

use XF\Admin\Controller\AbstractController;

class Masteries extends AbstractController
{
    /**
     * Default for terrasphere-core/masteries should be a redirect to mastery-list. You can't actually click on
     * the link for /masteries, but if you COULD, this would fix it. 10/10; solutions to non-problems.
     *
     * @return \XF\Mvc\Reply\Redirect
     */
    public function actionIndex(): \XF\Mvc\Reply\Redirect
    {
        return $this->redirect($this->buildLink('terrasphere-core/masteries/mastery-list'));
    }
}
