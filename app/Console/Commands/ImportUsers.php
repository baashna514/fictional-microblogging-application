<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:import {url : The URL of the JSON file} {limit : Limit number of users to import}';

    /**
     * php artisan users:import https://jsonplaceholder.typicode.com/users 10
     */

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users from a JSON file.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = $this->argument('url');
        $limit = $this->argument('limit');

        $response = Http::get($url);

        if ($response->successful()) {
            $users = $response->json();

            $this->info("Importing users from $url...");
            $imported = 0;

            foreach ($users as $userData) {
                if ($imported >= $limit) {
                    break;
                }

                User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => \Hash::make('password')
                ]);

                $imported++;
            }

            $this->info("Successfully imported $imported users.");
        } else {
            $this->error("Failed to fetch data from $url.");
        }
    }
}
