<?php
declare (strict_types=1);

namespace services;

class RewardCardService
{
    //           hyphen, en dash, em dash, space, new line, carriage return
    const SANITIZE_CHARS = ["-", "–", "—", " ", "\n", "\r"];

    const REWARD_CARD_CODE_CHARS = "2346789ABCDEFGHJKMNPQRTUVWXYZ";
    const REWARD_CARD_CODE_FORMAT_SPLIT_LENGTH = 4;
    const REWARD_CARD_CODE_REGENERATE_LIMIT = 5;
    const REWARD_CARD_CODE_LENGTH = 12;

    const REDEEM_STATUS_SUCCESSFUL = "successful";
    const REDEEM_STATUS_USED = "used";
    const REDEEM_STATUS_INVALID = "invalid";
    const TEXT_MESSAGE = "You just redeemed your reward card!";

    const PDF_FILE_NAME = "reward-cards.pdf";
    private $pdfTemplateFilePath;

    private $csUserId;
    private $shardConfigId;
    private $memberId;
    private $studentId;

    private $rewardCardDbGateway;
    private $qrCodeService;
    private $pdfService;

    public function __construct (?int $csUserId, ?int $shardConfigId, ?int $memberId, ?int $studentId)
    {
        $this->pdfTemplateFilePath = $_ENV['ROOT_WWW_PATH'] . "/html/shared/content/qr-code-templates/reward-card-pdf.html";

        $this->csUserId = $csUserId;
        $this->shardConfigId = $shardConfigId;
        $this->memberId = $memberId;
        $this->studentId = $studentId;
        $this->rewardCardDbGateway = new RewardCardDbGateway ($shardConfigId, $studentId);
        $this->qrCodeService = new QrCodeService ();
        $this->pdfService = new PdfService ($shardConfigId);
    }

    public function generateRewardCardCode (): string
    {
        $counter = 0;
        do
        {
            $rewardCardCode = "";
            for ($i = 0; $i < self::REWARD_CARD_CODE_LENGTH; ++$i)
            {
                $rewardCardCode .= self::REWARD_CARD_CODE_CHARS[mt_rand (0, strlen (self::REWARD_CARD_CODE_CHARS) - 1)];
            }
            ++$counter;
        } while ($counter < self::REWARD_CARD_CODE_REGENERATE_LIMIT && !empty ($this->rewardCardDbGateway->getRewardCard ($rewardCardCode)));

        return $rewardCardCode;
    }

    public function registerRewardCardCode (string $rewardCardCode, int $starAmount): void
    {
        $generatedAt = $this->now ();
        $this->rewardCardDbGateway->createRewardCard ($this->csUserId, $this->memberId, $rewardCardCode, $starAmount, $generatedAt);
    }

    public function formatRewardCardCode (string $rewardCardCode): string
    {
        return implode ("-", str_split ($rewardCardCode, self::REWARD_CARD_CODE_FORMAT_SPLIT_LENGTH));
    }

    public function getQrCodeSource (string $rewardCardCode): string
    {

        $qrCodeSource = $this->qrCodeService->generateQrCode ($rewardCardCode);
        return $qrCodeSource;
    }

    public function getHtml (array $rewardCards): string
    {
        $html = $this->pdfService->getHtml ($this->pdfTemplateFilePath, $rewardCards);
        return $html;
    }

    public function generatePdf (string $html)
    {
        $this->pdfService->generatePdf ($html, self::PDF_FILE_NAME);
    }

    public function sanitizeRewardCardCode (string $rewardCardCode): string
    {
        $sanitizedInputCode = str_replace (self::SANITIZE_CHARS, "", $rewardCardCode);
        $sanitizedInputCode = strtoupper ($sanitizedInputCode);

        return $sanitizedInputCode;
    }

    public function getRedeemStatusAndStarAmount (string $sanitizedRewardCardCode): array
    {
        $rewardCard = $this->rewardCardDbGateway->getRewardCard($sanitizedRewardCardCode);
        $starAmount = 0;

        $sharedStudentDbGateway = new SharedStudentDbGateway ($this->shardConfigId);
        if (empty ($rewardCard) ||
            ($rewardCard["member_id"] !== null && (int) $rewardCard["member_id"] !== $this->memberId &&
            !$sharedStudentDbGateway->isStudentShared ((int) $rewardCard["member_id"], $this->studentId)))
        {
            $redeemStatus = self::REDEEM_STATUS_INVALID;
        }
        else if ($rewardCard["redeemed_at"] !== null)
        {
            $redeemStatus = self::REDEEM_STATUS_USED;
        }
        else
        {
            $redeemed_at = $this->now ();
            $this->rewardCardDbGateway->updateRewardCard ((int) $rewardCard["reward_card_id"], $redeemed_at);
            $this->rewardCardDbGateway->createRewardCardRedemption ($this->studentId, (int) $rewardCard["reward_card_id"], $redeemed_at);

            $redeemStatus = self::REDEEM_STATUS_SUCCESSFUL;
            $starAmount = (int) $rewardCard["star_amount"];
        }

        return ["redeemStatus" => $redeemStatus, "starAmount" => $starAmount];
    }

    public function sendMessageAndAwardBonusStars (int $starAmount): void
    {
        $studentIds = [$this->studentId];
        $message = ["text_message" => self::TEXT_MESSAGE, "bonus_stars" => $starAmount, "student_ids" => $studentIds, "has_audio" => false];
        $messagesService = new MessagesService ($this->shardConfigId);
        $messagesService->sendStudentMessage ($studentIds, $this->memberId, $message);
    }

    private function now (): string
    {
        return date ("Y-m-d H:i:s");
    }
}