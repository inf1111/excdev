<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'excdev:create-user
                                {email : login of new user - must be email}
                                {password : password new user - must be from 4 to 8 symbols}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

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
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $validator = Validator::make(
            [
                'email' => $email,
                'password' => $password,
            ],
            [
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:4', 'max:8'],
            ]
        );

        if ($validator->fails()) {

            $this->error('User was not created. Error list:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return 1;

        } else {

            User::create([
                'email' => $email,
                'password' => Hash::make($password)
            ]);

            $this->info('Success. User was created.');

            return 0;

        }
    }
}
