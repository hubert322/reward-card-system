<?php

declare (strict_types=1);

namespace api;

use Exception;

class RewardCardRouter
{
    private $rewardCardApiController;
    public function __construct ()
    {
        $this->rewardCardApiController = new RewardCardApiController ();
    }

    public function request (string $requestMethod): void
    {
        try
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
        catch (Exception $e)
        {
            echo "Caught exception: " . $e->getMessage () . "\n";
        }

    }
}
