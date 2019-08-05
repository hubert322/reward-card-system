<?php

declare (strict_types=1);

namespace api;

class RewardCardRouter
{
    private $rewardCardApiController;
    public function __construct ()
    {
        $this->rewardCardApiController = new RewardCardApiController ();
    }

    public function request (string $requestMethod)
    {
        $content = null;
        switch ($requestMethod)
        {
            case "GET":
                $this->rewardCardApiController->generate ();
                break;
            case "PATCH":
                $content = $this->rewardCardApiController->redeem ();
                break;
            default:
                break;
        }
        
        return $content;
    }
}
