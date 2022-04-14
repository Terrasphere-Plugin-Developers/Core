<?php

namespace Terrasphere\Core\Util;

use XF\Pub\Controller\AbstractController;

class PostProxyHelper
{
    public static function getPostProxyParams(AbstractController $controller, int $postID)
    {
        $post = $controller->finder("XF:Post")->whereId($postID)->with("Thread")->fetchOne();

        if($post == null) return null;

        return [
            'post' => $post,
            'thread' => $post->Thread,
        ];
    }
}