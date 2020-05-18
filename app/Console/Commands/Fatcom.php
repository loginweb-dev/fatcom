<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use TCG\Voyager\VoyagerServiceProvider;

class Fatcom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fatcom:install {--with-registers}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize FATCOM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('key:generate');
        $this->call('migrate');
        $this->call('db:seed');
        $this->call('storage:link');
        if($this->option('with-registers')){
            // Agregar los seeder de datos de prueba
        }
        $this->call('vendor:publish', ['--provider' => VoyagerServiceProvider::class, '--tag' => ['config', 'voyager_avatar']]);

        $this->info('
            ███████╗░█████╗░████████╗░█████╗░░█████╗░███╗░░░███╗
            ██╔════╝██╔══██╗╚══██╔══╝██╔══██╗██╔══██╗████╗░████║
            █████╗░░███████║░░░██║░░░██║░░╚═╝██║░░██║██╔████╔██║
            ██╔══╝░░██╔══██║░░░██║░░░██║░░██╗██║░░██║██║╚██╔╝██║
            ██║░░░░░██║░░██║░░░██║░░░╚█████╔╝╚█████╔╝██║░╚═╝░██║
            ╚═╝░░░░░╚═╝░░╚═╝░░░╚═╝░░░░╚════╝░░╚════╝░╚═╝░░░░░╚═╝
        ');
        $this->info('Gracias por instalar FATCOM.');
    }
}
