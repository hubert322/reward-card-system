<?php
declare (strict_types=1);

namespace dataAccess;

class DataManager
{
    const DB_ACCOUNTS = "accounts";
    const DB_RK_ACTIVITY = "rk_activity";

    const LOC_MASTER = "master";

    private const SERVER_NAME = "159.89.86.178";
    private const USERNAME = "root";
    private const PASSWORD = "zcadqe13";

    private $database;
    private $location;
    private $shardConfigurationId;
    private $conn;

    public function __construct(string $database, string $location, int $shardConfigurationId = null)
    {
        $this->conn = new mysqli (self::SERVER_NAME, self::USERNAME, self::PASSWORD);
    }
}