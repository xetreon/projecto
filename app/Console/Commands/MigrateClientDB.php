<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateClientDB extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:clientdb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        //Get all the client
        $clients = \App\Models\v1\Common\Client::all();

        foreach ($clients as $value) {
            $dbname = env('APP_NAME') . "_client_" . $value['uniquename'];

            echo $dbname;
            $new_connection = 'client' . $value['id'];
            DB::disconnect();
            config(["database.connections.$new_connection" => [
                "driver"   => "mysql",
                "host"     => env('DB_HOST', '127.0.0.1'),
                "port"     => env('DB_PORT', '3306'),
                'username' => env('DB_USERNAME', 'forge'),
                'password' => env('DB_PASSWORD', ''),
                "database" => $dbname,
            ]]);
            DB::reconnect();
            Artisan::call('migrate', ['--database' => $new_connection, '--path' => 'database/migrations/client']);
        }

    }
}
