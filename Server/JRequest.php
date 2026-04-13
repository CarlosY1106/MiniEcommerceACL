<?php
namespace Server;

class JRequest {

    // Sanitizador genérico
    private static function sanitize($value) {
        if (is_array($value)) {
            return array_map([self::class, 'sanitize'], $value);
        }
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    public static function get($key){
        return isset($_GET[$key]) ? self::sanitize($_GET[$key]) : null;
    }

    public static function post($key){
        return isset($_POST[$key]) ? self::sanitize($_POST[$key]) : null;
    }

    // Extra: obtener todo el array ya sanitizado
    public static function allGet() {
        return self::sanitize($_GET);
    }

    public static function allPost() {
        return self::sanitize($_POST);
    }
}
