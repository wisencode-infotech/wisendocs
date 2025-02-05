<?php

namespace App\Console;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Register your custom commands here
        Commands\FreshInstallWisendoc::class
    ];

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
