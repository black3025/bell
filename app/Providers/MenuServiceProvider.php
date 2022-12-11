<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {

     $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenuUser.json'));

     $verticalMenuDataAdmin= file_get_contents(base_path('resources/menu/verticalMenuAdmin.json'));
  

    $verticalMenuData = json_decode($verticalMenuJson);
    $verticalMenuDataAdmin = json_decode($verticalMenuDataAdmin);
    // Share all menuData to all the views
    \View::share('menuData', [$verticalMenuData]);
    \View::share('AdminMenuData', [$verticalMenuDataAdmin]);
  }
}
