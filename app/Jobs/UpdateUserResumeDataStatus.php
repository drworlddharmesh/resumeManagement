<?php

namespace App\Jobs;

use App\Models\Constant;
use App\Models\Resume_allow;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateUserResumeDataStatus implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ResumeAllowId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ResumeAllowId) {
        $this->ResumeAllowId = $ResumeAllowId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $ResumeAllowUserId = Resume_allow::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('ResumeAllowId', $this->ResumeAllowId)->first();

        $ResumeFailCount = Resume_allow::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('ResumeAllowUserId', $ResumeAllowUserId->ResumeAllowUserId)
            ->where('ResumeStatus', 0)
            ->count();

        $ResumeTotalCount = User::where('IsRemoved', Constant::isRemoved['NotRemoved'])
            ->where('UserId', $ResumeAllowUserId->ResumeAllowUserId)->first();

        $FailLimit = round($ResumeTotalCount->ResumeSubmitCount * 12 / 100);

        User::where('UserId', $ResumeAllowUserId->ResumeAllowUserId)
        ->update([
            'ResumeFailCount' => $ResumeFailCount ,
        ]);

        
        if ($ResumeFailCount >= $FailLimit && $ResumeFailCount > 0) {
            // Resume_allow::where('ResumeAllowUserId', $ResumeAllowUserId->ResumeAllowUserId)
            //     ->update([
            //         'ResumeStatus' => 0,
            //     ]);
            User::where('UserId', $ResumeAllowUserId->ResumeAllowUserId)
                ->update([
                    'ResumeSubmitStatus' => Constant::UserResumeStatus['Fail'],
                ]);
        } else {
            $ResumePassFailCount = Resume_allow::where('IsRemoved', Constant::isRemoved['NotRemoved'])
                ->where('ResumeAllowUserId', $ResumeAllowUserId->ResumeAllowUserId)
                ->whereIn('ResumeStatus', [0, 1])
                ->count();
            if ($ResumeTotalCount->ResumeSubmitCount <= $ResumePassFailCount) {
                User::where('UserId', $ResumeAllowUserId->ResumeAllowUserId)
                    ->update([
                        'ResumeSubmitStatus' => Constant::UserResumeStatus['Pass'],
                    ]);
            }
        }
    }
}
