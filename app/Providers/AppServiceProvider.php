<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Model\workerAccessModel;

use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view) {
            if (Auth::check()) {
                $workerAccessModel = new workerAccessModel();
                $employeeSn = Auth::user()->employee_sn;
                $mainClass = $workerAccessModel->getLeftMenuMainClass($employeeSn);
                $subclass = $workerAccessModel->getLeftMenuSubclass($employeeSn);

                $view->with('mainClass', $mainClass)->with('subClass', $subclass);
            };
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
