<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Contracts\Events\Dispatcher;

use App\Menu;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
      $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
        $main_menu = Menu::where('parent_id','')->select([
          'id',
          'text',
          'label',
          'can',
          'url',
          'icon'])->get();
        $result = array();
        foreach($main_menu as $menu){
          $result = $menu->toArray();
          if($menu->submenu->count() > 0){
            foreach($menu->submenu as $submenu){
              $result['submenu'][] = $submenu->toArray();
            }

          }
        }
        $event->menu->add($result);
        $event->menu->add([
          'text' => 'Setting',
          'icon' => 'wrench',
          'can' => 'permissions_manage',
          'submenu' => [
            [
            'text' => 'Menu',
            'icon' => 'list',
            'url' => 'admin/menus',
            'can' => 'menus_manage',
            ],
            [
            'text' => 'Permissions',
            'icon' => 'lock',
            'url' => 'admin/permissions',
            'can' => 'permissions_manage',
            ],
            [
                'text' => 'Roles',
                'icon' => 'briefcase',
                'url' => 'admin/roles',
                'can' => 'roles_manage',
            ],
            [
                'text' => 'Users',
                'icon' => 'users',
                'url' => 'admin/users',
                'can' => 'users_manage',
            ]
          ]
        ]);
      });
      Schema::defaultStringLength(191);
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
