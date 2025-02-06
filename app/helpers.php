<?php

use App\Models\Version;

if (!function_exists('getVersions')) {
    function getVersions()
    {
        return Version::get();
    }
}
