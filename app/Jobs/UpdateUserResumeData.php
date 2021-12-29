<?php

namespace App\Jobs;

use App\Models\Resume_allow;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateUserResumeData implements ShouldQueue {
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

        $user = User::where('IsRemoved', 0)->whereNotNull('UserEndDate')->get();

        foreach ($user as $usr) {
            $totalCount = Resume_allow::where('ResumeAllowUserId', $usr->UserId)
                ->where('IsRemoved', 0)
                ->count();

            $submitCount = Resume_allow::where('ResumeAllowUserId', $usr->UserId)
                ->where(function ($q) {
                    $q->where('ResumeStatus', 3);
                    $q->orWhere('MoveOnSubmit', 2);
                })
                ->where('IsRemoved', 0)
                ->count();

            $exactSubmitCount = Resume_allow::where('ResumeAllowUserId', $usr->UserId)
                ->where('ResumeStatus', 3)
                ->where('IsRemoved', 0)
                ->count();

            $failCount = Resume_allow::where('ResumeAllowUserId', $usr->UserId)
                ->where('ResumeStatus', 0)
                ->where('IsRemoved', 0)
                ->count();

            $resumePassFailCount = Resume_allow::where('IsRemoved', 0)
                ->where('ResumeAllowUserId', $usr->UserId)
                ->whereIn('ResumeStatus', [0, 1])
                ->count();

            User::where('UserId', $usr->UserId)->update([
                'ResumeSubmitCount' => $exactSubmitCount,
                'ResumeTotalCount'  => $totalCount,
            ]);

            if ($submitCount >= $totalCount) {
                $failLimit = round($exactSubmitCount * 12 / 100);

                if ($failCount >= $failLimit && $failCount > 0) {
                    // Resume_allow::where('ResumeAllowUserId', $usr->UserId)
                    //     ->update([
                    //         'ResumeStatus' => 0,
                    //     ]);

                    User::where('UserId', $usr->UserId)->update([
                        'ResumeSubmitStatus' => 4,
                    ]);
                } else if ($exactSubmitCount <= $resumePassFailCount) {
                    User::where('UserId', $usr->UserId)->update([
                        'ResumeSubmitStatus' => 3,
                    ]);
                } else {
                    User::where('UserId', $usr->UserId)->update([
                        'ResumeSubmitStatus' => 2,
                    ]);
                }
            } else {
                User::where('UserId', $usr->UserId)->update([
                    'ResumeSubmitStatus' => 1,
                ]);
            }

            // $userData = User::where('UserId', $usr->UserId)->first();

            // $FailLimit = round($userData->ResumeSubmitCount * 12 / 100);
            // if ($failCount >= $FailLimit) {
            //     User::where('UserId', $userData->UserId)
            //         ->update([
            //             'ResumeSubmitStatus' => 4,
            //         ]);
            // } else {
            //     $ResumePassFailCount = Resume_allow::where('IsRemoved', 0)
            //         ->where('ResumeAllowUserId', $userData->UserId)
            //         ->whereIn('ResumeStatus', [0, 1])
            //         ->count();
            //     if ($userData->ResumeSubmitCount <= $ResumePassFailCount) {
            //         User::where('UserId', $userData->UserId)
            //             ->update([
            //                 'ResumeSubmitStatus' => 3,
            //             ]);
            //     }
            // }
        }
    }
}
