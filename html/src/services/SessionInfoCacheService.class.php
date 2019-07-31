<?php

declare (strict_types=1);

namespace services;

class SessionInfoCacheService
{
    static function getCsUserId (): string
    {
        return "1";
    }

    static function getShardConfigId (): string
    {
        return "2";
    }

    static function getMemberId (): string 
    {
        return "3";
    }

    static function getStudentId (): string
    {
        return "4";
    }
}