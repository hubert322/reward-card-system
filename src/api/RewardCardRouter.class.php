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

    public function request (string $requestMethod): void
    {
        switch ($requestMethod)
        {
            case "GET":
                $this->rewardCardApiController->generate ();
                break;
            case "PATCH":
                $this->rewardCardApiController->redeem ();
                break;
            default:
                break;
        }
    }
}
