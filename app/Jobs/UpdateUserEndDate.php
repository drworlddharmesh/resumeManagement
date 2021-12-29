<?php

namespace App\Jobs;

use App\Models\Resume_allow;
use App\Models\User;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateUserEndDate implements ShouldQueue {
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
       $User =  User::where('IsRemoved', 0)
            ->get();
           
        foreach($User as $us)
        {
            $ResumeFailCount = Resume_allow::where('IsRemoved', 0)
            ->where('ResumeAllowUserId', $us->UserId)
            ->where('ResumeStatus', 0)
            ->count();
            
            User::where('UserId', $us->UserId)
        ->update([
            'ResumeFailCount' => $ResumeFailCount ,
        ]);
        }
        
            
    }
}
