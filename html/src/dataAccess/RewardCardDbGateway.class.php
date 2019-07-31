<?php
declare (strict_types=1);

namespace dataAccess;

use Exception;
use util\SQLUtil;

class RewardCardDbGateway
{
    private $rkActivityMasterDm;
    private $accountsMasterDm;

    public function __construct(?int $shardConfigId, ?int $studentId)
    {
        if (isset ($studentId))
        {
            $this->rkActivityMasterDm = new DataManager(DataManager::DB_RK_ACTIVITY, DataManager::LOC_MASTER, $shardConfigId);
        }
        $this->accountsMasterDm = new DataManager (DataManager::DB_ACCOUNTS, DataManager::LOC_MASTER);
    }

    public function getRewardCard (string $rewardCardCode): array
    {
        $rewardCardCode = SQLUtil::escapeString ($rewardCardCode);

        $sql = "SELECT reward_card_id, cs_user_id, member_id, reward_card_code, star_amount, generated_at, redeemed_at 
                FROM reward_card 
                WHERE reward_card_code = '$rewardCardCode'";

        $this->accountsMasterDm->query ($sql);
        $result = $this->accountsMasterDm->fetch ();

        if($result)
        {
            return $result;
        }
        return [];
    }

    public function createRewardCard (?int $csUserId, ?int $memberId, string $rewardCardCode, int $starAmount, string $generated_at): int
    {
        if ($csUserId === null && $memberId === null)
        {
            throw new Exception ("Both csUserId and memberId are null");
        }

        $rewardCardCode = SQLUtil::escapeString ($rewardCardCode);
        $csUserId = $csUserId ?? "NULL";
        $memberId = $memberId ?? "NULL";

        $sql = "INSERT INTO reward_card 
                (cs_user_id, member_id, reward_card_code, star_amount, generated_at, redeemed_at) 
                VALUES 
                ($csUserId, $memberId, '$rewardCardCode', $starAmount, '$generated_at', null)";

        $this->accountsMasterDm->query ($sql);
        return $this->accountsMasterDm->lastId ();
    }

    public function updateRewardCard (int $rewardCardId, string $redeemed_at): void
    {
        $sql = "UPDATE reward_card 
                SET redeemed_at = '$redeemed_at' 
                WHERE reward_card_id = $rewardCardId";

        $this->accountsMasterDm->query ($sql);
    }

    public function createRewardCardRedemption (int $studentId, int $rewardCardId, string $redeemed_at): int
    {
        $sql = "INSERT INTO reward_card_redemption 
                (student_id, reward_card_id, redeemed_at) 
                VALUES 
                ($studentId, $rewardCardId, '$redeemed_at')";

        $this->rkActivityMasterDm->query ($sql);
        return $this->rkActivityMasterDm->lastId ();
    }
}