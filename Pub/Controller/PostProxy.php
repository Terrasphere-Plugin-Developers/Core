<?php

namespace Terrasphere\Core\Pub\Controller;

use Terrasphere\Core\Util\PostProxyHelper;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;
use XF\Pub\Controller\AbstractController;

class PostProxy extends AbstractController
{
    public function actionIndex(ParameterBag $params): View
    {
        return $this->view(
            'Terrasphere\Core:PostProxy',
            'terrasphere_core_post_proxy_page',
            PostProxyHelper::getPostProxyParams($this, $params->post_id)
        );
    }
}