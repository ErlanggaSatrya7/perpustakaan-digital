<?php

namespace App\Providers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Policies\PeminjamanPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Sesuaikan storage path ke /tmp di Vercel agar tidak gagal tulis view/cache
        if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL'])) {
            $this->app->useStoragePath('/tmp');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Mendaftarkan Policy untuk model Peminjaman
        Gate::policy(Peminjaman::class, PeminjamanPolicy::class);

        // Gate kelola-buku: hanya admin dan petugas yang berhak
        Gate::define('kelola-buku', function (User $user) {
            return $user->hasRole(['admin', 'petugas']);
        });
    }
}
