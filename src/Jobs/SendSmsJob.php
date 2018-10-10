<?php

namespace Asanbar\Notifier\Jobs;

use Asanbar\Notifier\Traits\SmsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use SmsTrait;

    private $message;
    private $numbers;
    private $datetime;
    private $expire_at;

    /**
     * Create a new job instance.
     *
     * @param string $message
     * @param array $numbers
     * @param int $expire_at
     */
    public function __construct(string $message, array $numbers, int $expire_at = 0)
    {
        $this->message = $message;
        $this->numbers = $numbers;
        $this->expire_at = $expire_at > 0 ? Carbon::now()->addSeconds($expire_at) : 0;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->expire_at === 0 || !Carbon::now()->gt($this->expire_at)) { //if expire_at is zero or now not greater than expire_at
            $this->sendSms();
        }
    }
}
