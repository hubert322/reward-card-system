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
    const DATABASE = "heroku_2898c1ca244b3dc";

    private $conn;
    private $result;
    private $lastInsertedId;

    public function __construct(string $database, string $location, int $shardConfigurationId = null)
    {
        if (!$this->parametersValid ($database, $location))
        {
            throw new Exception ("Invalid parameters for DataManager");
        }

        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
        $this->conn = new mysqli ($url["host"], $url["user"], $url["pass"]);
        if ($this->conn->connect_error)
        {
            die ("Connection failed: " . $this->conn->connect_error);
        }

        // Migrating to heroku only allowed one datbase
        $database = self::DATABASE;
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

    public function fetch (): ?array
    {
        if ($this->result)
            return $this->result->fetch_assoc ();
        return null;
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