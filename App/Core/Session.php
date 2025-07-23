<?php

namespace App\Core;

class Session {


    private static ?Session $instance = null;

    public static function getInstance(): Session {
        if (self::$instance === null) {
            self::$instance = new Session();
        }
        return self::$instance;
    }

    private function __construct() {
        session_start();
    }

    public function set(string $key, $data): void {
        $_SESSION[$key] = $data;
    }
    public function get(string $key) {
        return $_SESSION[$key] ?? null;
    }

    public function empty(string $key): bool {
        return empty($_SESSION[$key] ?? null);
    }   

    public function destroy(): void {
        session_unset();
        session_destroy();
        self::$instance = null;
    }


}