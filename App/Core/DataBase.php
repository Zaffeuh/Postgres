<?php
namespace App\Core;

use PDO;
use PDOException;
use Dotenv\Dotenv;
use App\Src\Enums\SuccessEnum;
use App\Src\Enums\ErrorEnum;

class DataBase
{
    private static ?DataBase $instance = null;
    private ?PDO $pdo = null;
    private ?PDO $pdoServer = null;
    private array $config;

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->loadEnvironment();
        $this->initializeDatabaseParams();
    }

    private function loadEnvironment(): void
    {
        $databaseUrl = getenv('DATABASE_URL') ?: ($_ENV['DATABASE_URL'] ?? null);
        if ($databaseUrl) {
            $parts = parse_url($databaseUrl);

            // Sécurise chaque clé
            putenv('DB_DRIVER=pgsql');
            putenv('DB_HOST=' . ($parts['host'] ?? ''));
            putenv('DB_PORT=' . ($parts['port'] ?? '5432'));
            putenv('DB_USER=' . ($parts['user'] ?? ''));
            putenv('DB_PASS=' . ($parts['pass'] ?? ''));
           
            putenv('DB_NAME=' . (isset($parts['path']) ? ltrim($parts['path'], '/') : ''));
            return;
        }

        if (file_exists(__DIR__ . '/../../.env')) {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();
        }
    }

    private function initializeDatabaseParams(): void
    {
        $this->config = [
            'host' => getenv('DB_HOST') ?: $_ENV['DB_HOST'] ?? null,
            'port' => getenv('DB_PORT') ?: $_ENV['DB_PORT'] ?? null,
            'user' => getenv('DB_USER') ?: $_ENV['DB_USER'] ?? null,
            'password' => getenv('DB_PASS') ?: $_ENV['DB_PASS'] ?? null,
            'driver' => getenv('DB_DRIVER') ?: $_ENV['DB_DRIVER'] ?? 'pgsql',
            'dbname' => getenv('DB_NAME') ?: $_ENV['DB_NAME'] ?? null
        ];
    }

    public function getConnection(): PDO
    {
        if ($this->pdo === null) {
            // Vérifier que le nom de la base de données est défini
            if (empty($this->config['dbname'])) {
                throw new \Exception("Nom de base de données non défini. Exécutez d'abord la migration.");
            }
            $this->pdo = $this->createConnection($this->config['dbname']);
        }
        return $this->pdo;
    }

    public function getServerConnection(): PDO
    {
        if ($this->pdoServer === null) {
            $this->pdoServer = $this->createConnection('postgres');
        }
        return $this->pdoServer;
    }

    private function createConnection(string $dbname): PDO
    {
        $dsn = sprintf('%s:host=%s;port=%s;dbname=%s',
            $this->config['driver'],
            $this->config['host'],
            $this->config['port'],
            $dbname
        );

        try {
            $pdo = new PDO($dsn, $this->config['user'], $this->config['password']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo SuccessEnum::SUCCESS_CONNECTION->value . " ($dbname)\n";
            return $pdo;
        } catch (PDOException $e) {
            exit(ErrorEnum::ECHEC_CONNEXION->value . $e->getMessage() . "\n");
        }
    }

    public function setDatabaseName(string $dbname): void
    {
        $this->config['dbname'] = $dbname;
        $this->pdo = null; 
    }
}