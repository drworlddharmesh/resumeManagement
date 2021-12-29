<?php

namespace App\Jobs;

use App\Models\Resume_allow;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateUserSubmitedResumeCount implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        date_default_timezone_set('Asia/Kolkata');
        $CurrentDay = date("Y-m-d");

        $user = User::where('IsRemoved', 0)
            ->whereNotNull('UserEndDate')
            ->whereDate('UserEndDate', '>=', $CurrentDay)
            ->where('ResumeSubmitStatus', '!=', 4)
            ->get();

        foreach ($user as $usr) {
            $exactSubmitCount = Resume_allow::where('ResumeAllowUserId', $usr->UserId)
                ->where('ResumeStatus', 3)
                ->where('IsRemoved', 0)
                ->count();

            if ($usr->ResumeSubmitCount != $exactSubmitCount) {
                User::where('UserId', $usr->UserId)->update([
                    'ResumeSubmitCount' => $exactSubmitCount,
                ]);
            }
        }
    }
}
