<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Disposisi;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();

                $jumlahSuratInboxBelumDilihat = Disposisi::where('ke_user_id', $userId)
                    ->whereIn('tipe_aksi', ['Teruskan', 'Revisi'])
                    ->where('status', 'Menunggu')
                    ->count();

                $jumlahSuratDitolakBelumDilihat = Disposisi::where('ke_user_id', $userId)
                    ->where('tipe_aksi', 'Kembalikan')
                    ->where('status', 'Menunggu')
                    ->count();

                $view->with([
                    'jumlahSuratInboxBelumDilihat' => $jumlahSuratInboxBelumDilihat,
                    'jumlahSuratDitolakBelumDilihat' => $jumlahSuratDitolakBelumDilihat,
                ]);
            }
        });
    }
}
