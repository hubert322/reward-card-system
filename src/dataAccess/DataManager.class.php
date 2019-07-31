<?php
declare (strict_types=1);

namespace dataAccess;

use mysqli;
use Exception;

class DataManager
{
    const DB_ACCOUNTS = "accounts";
    const DB_RK_ACTIVITY = "rk_activity";

    const LOC_MASTER = "master";

    private $conn;
    private $result;
    private $lastInsertedId;

    public function __construct(string $database, string $location, int $shardConfigurationId = null)
    {
        if (!$this->parametersValid ($database, $location))
        {
            throw new Exception ("Invalid parameters for DataManager");
        }

        $this->conn = new mysqli ($_ENV["SERVER_NAME"], $_ENV["USERNAME"], $_ENV["PASSWORD"]);
        if ($this->conn->connect_error)
        {
            die ("Connection failed: " . $this->conn->connect_error);
        }
        $this->conn->select_db ($database);
    }

    public function __destruct()
    {
        $this->conn->close ();
    }

    public function query (string $sql): void
    {
        $this->result = $this->conn->query ($sql);
        $this->lastInsertedId = $this->conn->insert_id;
    }

    public function fetch (): array
    {
        return $this->result->fetch_assoc ();
    }

    public function lastId (): int
    {
        return $this->lastInsertedId;
    }

    private function parametersValid (string $database, string $location)
    {
        if ($database !== self::DB_ACCOUNTS && $database !== self::DB_RK_ACTIVITY)
            return false;
        if ($location !== self::LOC_MASTER)
            return false;
        return true;
    }
}