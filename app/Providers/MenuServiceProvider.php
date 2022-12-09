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
    if(Auth::user()){
      if(Auth::user()->role->id > 1)
        $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenuUser.json'));
      else
        $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenuAdmin.json'));
   }else{
      $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenuAdmin.json'));
   }

    $verticalMenuData = json_decode($verticalMenuJson);

    // Share all menuData to all the views
    \View::share('menuData', [$verticalMenuData]);
  }
}
