<?php

/**
 * Helpers globaux de l'application Kelasi.
 */

function app_config($key = null)
{
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/../config/config.php';
    }
    return $key === null ? $config : ($config[$key] ?? null);
}

/**
 * Génère une URL absolue basée sur la base_url de l'application.
 */
function url($path = '')
{
    return rtrim(app_config('base_url'), '/') . '/' . ltrim($path, '/');
}

/**
 * Génère l'URL d'une ressource statique (dossier assets/).
 */
function asset($path)
{
    return url('assets/' . ltrim($path, '/'));
}
