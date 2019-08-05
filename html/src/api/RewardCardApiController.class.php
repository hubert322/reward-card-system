<?php

declare (strict_types=1);

namespace api;

use services\SessionInfoCacheService;
use services\RewardCardService;

class RewardCardApiController
{
    private $rewardCardService;
    private $resource;

    public function __construct ()
    {
        $csUserId = (int) (SessionInfoCacheService::getCsUserId ()) ?: null;
        $shardConfigId = (int) (SessionInfoCacheService::getShardConfigId ()) ?: null;
        $memberId = (int) (SessionInfoCacheService::getMemberId ()) ?: null;
        $studentId = (int) (SessionInfoCacheService::getStudentId ()) ?: null;
        $this->rewardCardService = new RewardCardService ($csUserId, $shardConfigId, $memberId, $studentId);

        $this->setResource ();
    }

    public function generate (): void
    {
        $queryParams = $this->getQueryParams ();
        if ($queryParams["rewardCardAmount"] === null || $queryParams["starAmount"] === null)
        {
            return;
        }
        $rewardCardAmount = (int) $queryParams["rewardCardAmount"];
        $starAmount = (int) $queryParams["starAmount"];
        $rewardCards = [];
        for ($i = 0; $i < $rewardCardAmount; ++$i)
        {
            $inputCode = $this->rewardCardService->generateRewardCardCode ();
            $this->rewardCardService->registerRewardCardCode ($inputCode, $starAmount);

            $formattedInputCode = $this->rewardCardService->formatRewardCardCode ($inputCode);
            $qrCodeSource = $this->rewardCardService->getQrCodeSource ($inputCode);
            $rewardCard = ["formattedInputCode" => $formattedInputCode, "qrCodeSource" => $qrCodeSource, "starAmount" => $starAmount];
            $rewardCards[] = $rewardCard;
        }

        $html = $this->rewardCardService->getHtml ($rewardCards);
        $this->rewardCardService->generatePdf ($html);
    }

    public function redeem (): array
    {
        $rewardCardCode = $this->resource["inputCode"];
        $sanitizedRewardCardCode = $this->rewardCardService->sanitizeRewardCardCode ($rewardCardCode);
        ["redeemStatus" => $redeemStatus, "starAmount" => $starAmount] = $this->rewardCardService->getRedeemStatusAndStarAmount ($sanitizedRewardCardCode);
        if ($redeemStatus === "successful")
        {
            $this->rewardCardService->sendMessageAndAwardBonusStars ($starAmount);
        }

        return ["redeemStatus" => $redeemStatus, "starAmount" => $starAmount];
    }

    // These two functions are created for demo purpose. The actual code is extremely involved with the router system,
    // thus abstracted from this demo.
    private function getQueryParams (): array
    {
        return $_GET;
    }

    private function setResource (): void
    {
        $this->resource = json_decode (file_get_contents ("php://input"), true);
    }
}
