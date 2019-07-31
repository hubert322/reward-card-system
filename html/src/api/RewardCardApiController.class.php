<?php

declare (strict_types=1);

namespace api;

use services\SessionInfoCacheService;
use services\RewardCardService;

class RewardCardApiController
{
    private $rewardCardService;

    public function __construct ()
    {
        $csUserId = (int) (SessionInfoCacheService::getCsUserId ()) ?: null;
        $shardConfigId = (int) (SessionInfoCacheService::getShardConfigId ()) ?: null;
        $memberId = (int) (SessionInfoCacheService::getMemberId ()) ?: null;
        $studentId = (int) (SessionInfoCacheService::getStudentId ()) ?: null;
        $this->rewardCardService = new RewardCardService ($csUserId, $shardConfigId, $memberId, $studentId);
    }

    public function generate ()
    {
        $queryParams = $_GET;
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
        $rewardCardCode = $_POST["inputCode"];
        $sanitizedRewardCardCode = $this->rewardCardService->sanitizeRewardCardCode ($rewardCardCode);
        ["redeemStatus" => $redeemStatus, "starAmount" => $starAmount] = $this->rewardCardService->getRedeemStatusAndStarAmount ($sanitizedRewardCardCode);
        if ($redeemStatus === "successful")
        {
            $this->rewardCardService->sendMessageAndAwardBonusStars ($starAmount);
        }

        return ["redeemStatus" => $redeemStatus, "starAmount" => $starAmount];
    }
}
