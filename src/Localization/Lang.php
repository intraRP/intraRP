<?php

namespace App\Localization;

class Lang
{
    protected static $phrases = [];
    protected static $language = 'de';

    public static function setLanguage(string $lang)
    {
        self::$language = $lang;
        $file = __DIR__ . "/../../assets/lang/{$lang}.php";
        if (file_exists($file)) {
            self::$phrases = require $file;
        } else {
            throw new \Exception("Sprach_Datei für Sprache '{$lang}' nicht gefunden.");
        }
    }

    public static function get(string $key, array $values = []): mixed
    {
        $keys = explode('.', $key);
        $phrase = self::$phrases;

        foreach ($keys as $k) {
            if (!is_array($phrase) || !array_key_exists($k, $phrase)) {
                return "<strong style='color:red'>[missing:{$key}]</strong>";
            }
            $phrase = $phrase[$k];
        }

        if (is_array($phrase)) {
            return $phrase;
        }

        return vsprintf($phrase, $values);
    }
}
