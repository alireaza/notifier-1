<?php

namespace Asanbar\Notifier\Jobs;

use Asanbar\Notifier\Traits\SmsTrait;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use SmsTrait;

    private $message;
    private $numbers;
    private $datetime;
    private $expire_at;
    private $expire_at_carbon;
    private $options;

    /**
     * Create a new job instance.
     *
     * @param string $message
     * @param array $numbers
     * @param int $expire_at
     * @param array $options
     */
    public function __construct(string $message, array $numbers, int $expire_at = 0, array $options = [])
    {
        $this->message          = $message;
        $this->numbers          = $numbers;
        $this->expire_at        = $expire_at;
        $this->expire_at_carbon = $expire_at > 0 ? Carbon::now()->addSeconds($expire_at) : 0;
        $this->options          = $options;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->expire_at === 0 || !Carbon::now()->gt($this->expire_at_carbon)) { //if expire_at is zero or now not greater than expire_at
            $this->sendSms();
        }
    }
}