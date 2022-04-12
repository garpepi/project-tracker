<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Access_menu;
use App\Models\Menu;
use Illuminate\Support\Facades\Route;

class ViewServiceProvider extends ServiceProvider
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
        //
        View::composer('includes.sidebar', function( $view )
        {
            // Hardcoded!!
            $group = (object)[
                "operational" => [
                    'contract-po', 
                    'operational-cost', 
                    'create.contract',
                    'operational-cost',
                    'create.contract',
                    'contracts.index',
                    'contracts.store',
                    'contracts.create',
                    'contracts.show',
                    'contracts.update',
                    'contracts.history',
                    'contracts.destroy',
                    'contracts.upammend',
                    'contracts.ammend',
                    'contracts.edit',
                    'contracts.destroyDoc'
                ],
                "contract" => [
                    'contract-po',
                    'create.contract',
                    'contracts.index',
                    'contracts.store',
                    'contracts.create',
                    'contracts.show',
                    'contracts.update',
                    'contracts.history',
                    'contracts.destroy',
                    'contracts.upammend',
                    'contracts.ammend',
                    'contracts.edit',
                    'contracts.destroyDoc'
                ],
                "opncost" => [
                    'operational-cost'
                ],
            ];

            $operational_group = $this->access_menu(1);
            
            $configuration_group = $this->access_menu(2);
            
            $monitoring_group = $this->access_menu(3);
            
            $data = (object)[
                "groups" => $group,
                "operational_group" => $operational_group,
                "configuration_group" => $configuration_group,
                "monitoring_group" => $monitoring_group
            ];

            //pass the data to the view
            $view->with( 'sidebar', $data );
        });
    }

    private function access_menu($header_id){
        $available_menus = [];
        $access_menu = Access_menu::with('menu','role')
                ->where('active',1)
                ->where('role_id',session()->get('token')['user']['role_id'])
                ->whereHas('menu', function($q) use ($header_id){
                    $q->where('menu_header_id', $header_id);
                })->orderBy('menu_id', 'asc')->get();
        foreach ($access_menu as $menu) {
            $available_menus[] = $menu->menu->url;
        }
        return $available_menus;
    }
}
