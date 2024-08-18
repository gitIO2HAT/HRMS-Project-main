<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class UpdateUserCredit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-user-credit';



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increment user credits for sick and vacation balances';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Get the current time
            $now = Carbon::now();

            // Find and update all users created at a time where the minutes since creation are a multiple of 5
            $updated = User::whereRaw('TIMESTAMPDIFF(MINUTE, created_at, NOW()) % 5 = 0')
                ->update([
                    'sick_balance' => DB::raw('sick_balance + 1.5'),
                    'vacation_balance' => DB::raw('vacation_balance + 1.5')
                ]);

            if ($updated) {
                $this->info($updated . ' users have been updated successfully.');
            } else {
                $this->info('No users found to update.');
            }
        } catch (\Exception $e) {
            $this->error('Error occurred: ' . $e->getMessage());
        }
    }







}
