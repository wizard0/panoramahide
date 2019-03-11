<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {credits=admin:admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates admin for your site with admin:admin default credentials';

    /**
     * CreateSuperAdmin constructor.
     * Create a new command instance.
     *
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
        $credits = explode(':', $this->argument('credits'));
        $login = $credits[0];
        $password = $credits[1];

        if (User::where('email', $login)->first()) {
            $this->info('User with login:' . $login . ' already exists');
        } else {
            $admin = factory(User::class)->create([
                'email' => $login,
                'password' => Hash::make($password)
            ])->assignRole(User::ROLE_SUPERADMIN);

            $this->info('Created super-admin user#' . $admin->id . ' with login:' . $login .
                ' and password:' . $password);
        }
    }
}
