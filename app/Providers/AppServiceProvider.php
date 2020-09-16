<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {  
        //
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Way\Generators\GeneratorsServiceProvider::class);
            $this->app->register(\Xethron\MigrationsGenerator\MigrationsGeneratorServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        View::composer('*', function($view){
             $cant_productos_escaz = [
                 'url' => route('productos_escasez'),
                 'description' => 'productos en escazes',
                 'producto' => \App\Producto::join('subcategorias', 'subcategorias.id', '=', 'productos.subcategoria_id')
                                              ->where('se_almacena', 1)
                                              ->whereColumn('stock', '<', 'stock_minimo')
                                              ->count()
             ];
             $view->with('cant_productos_escaz',$cant_productos_escaz);
            
        });
       
    }
}
