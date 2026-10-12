<?php

namespace App\Modules\Recruitment\Providers;

use Illuminate\Support\ServiceProvider;

class RecruitmentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}
