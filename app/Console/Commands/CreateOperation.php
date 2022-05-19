<?php

namespace App\Console\Commands;

use App\Jobs\CreateOperationJob;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class CreateOperation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'excdev:create-op
                                {email : existing user email}
                                {type : "put" - for deposit, "take" - for withdraw }
                                {amount : can be positive and negative}
                                {description : transaction description, max 255 symbols}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create operation';

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
        $CLIargs = Arr::only($this->arguments(), ['email', 'type', 'amount', 'description']);

        $this->validateCLIArgs($CLIargs);

        list($email, $type, $amount, $description) = array_values($CLIargs);

        $user = User::where('email', $email)->first();

        $amount = ($type === 'take') ? -$amount : $amount;

        $newBalance = $user->balance + $amount;

        if ($newBalance <= 0) {

            $this->error('Operation was not created. Error: user balance must be > 0 after transaction.');

            return 1;

        }

        dispatch(new CreateOperationJob($user, $newBalance, $amount, $description));

        $this->info('Success. Operation was added to queue.');
    }

    /**
     * Валидация аргументов команды
     */
    private function validateCLIArgs (array $CLIargs) : void {

        $validator = Validator::make(
            $CLIargs,
            [
                'email' => ['required', 'email', 'exists:users,email'],
                'type' => ['required', 'in:put,take'],
                'amount' => ['required', 'numeric', 'min:0.01', 'max:99999999'],
                'description' => ['required', 'string', 'min:1', 'max:255'],
            ],
            [
                'type.in' => 'Type may be: "put" (for deposit) or "take" (for withdraw)',
                'email.exists' => "Email doesn't exist in DB",
            ]
        );

        if ($validator->fails()) {

            $this->error('Operation was not created. Error list:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            exit(1);
        }

    }
}
