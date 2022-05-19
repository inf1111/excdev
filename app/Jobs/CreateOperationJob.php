<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateOperationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

    private $newBalance;

    private $amount;

    private $description;

    public function __construct(User $user, float $newBalance, float $amount, string $description)
    {
        $this->user = $user;

        $this->newBalance = $newBalance;

        $this->amount = $amount;

        $this->description = $description;
    }

    public function handle()
    {
        DB::beginTransaction();

        try
        {
            $this->user->update(['balance' => $this->newBalance]);

            $this->user->operations()->create([
                'user_id' => $this->user->id,
                'amount' => $this->amount,
                'description' => $this->description,
                'date' => now(),
            ]);

            DB::commit();

        }
        catch (\Throwable $e)
        {
            DB::rollback();

            throw new \Exception('Operation was not created. Transaction error.');
        }
    }

}
