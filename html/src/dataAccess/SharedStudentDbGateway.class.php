<?php
declare (strict_types=1);

namespace dataAccess;


class SharedStudentDbGateway
{
    public function __construct(int $shardConfigId)
    {

    }

    public function isStudentShared (int $memberid, int $studentId): bool
    {
        return true;
    }
}