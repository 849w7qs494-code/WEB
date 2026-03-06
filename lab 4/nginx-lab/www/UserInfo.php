<?php
class UserInfo {
    public static function getInfo(): array {
        return [
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Неизвестно',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Неизвестно',
            'time' => date('Y-m-d H:i:s'),
            'browser' => self::detectBrowser(),
            'os' => self::detectOS()
        ];
    }

    private static function detectBrowser(): string {
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        if (strpos($ua, 'Chrome') !== false) return 'Chrome';
        if (strpos($ua, 'Firefox') !== false) return 'Firefox';
        if (strpos($ua, 'Safari') !== false) return 'Safari';
        if (strpos($ua, 'Edge') !== false) return 'Edge';
        if (strpos($ua, 'MSIE') !== false) return 'Internet Explorer';
        
        return 'Неизвестно';
    }

    private static function detectOS(): string {
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        if (strpos($ua, 'Windows') !== false) return 'Windows';
        if (strpos($ua, 'Linux') !== false) return 'Linux';
        if (strpos($ua, 'Mac') !== false) return 'macOS';
        if (strpos($ua, 'iPhone') !== false) return 'iOS';
        if (strpos($ua, 'Android') !== false) return 'Android';
        
        return 'Неизвестно';
    }

    public static function getLastSubmission(): ?string {
        return $_COOKIE['last_submission'] ?? null;
    }
}