<?php

namespace App\Http\Controllers\Api;

use App\Helpers\SystemUtils;
use App\Http\Controllers\Controller;
use App\Models\Version;

class VersionController extends Controller
{
    public $system_utils;

    public function __construct(SystemUtils $system_utils)
    {
        $this->system_utils = $system_utils;
    }

    public function index()
    {
        $versions = $this->system_utils->cacheForever('versions', function() {
            return Version::all();
        });

        return response()->json($versions);
    }
}
