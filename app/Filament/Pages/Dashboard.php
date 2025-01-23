<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    /**
     * Ubah label navigasi (di sidebar)
     */
    public static function getNavigationLabel(): string
    {
        return 'Dashboard';
    }

    /**
     * Ubah judul halaman utama dashboard
     */
    public function getTitle(): string
    {
        return 'Dashboard'; // Paksa tetap menggunakan "Dashboard"
    }
}
