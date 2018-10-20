<?php

namespace Asanbar\Notifier\Jobs;

use Asanbar\Notifier\Traits\SmsTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use SmsTrait;

    private $message;
    private $numbers;
    private $datetime;
    private $options;

    /**
     * Create a new job instance.
     *
     * @param string $message
     * @param array $numbers
     * @param array $options
     */
    public function __construct(string $message, array $numbers, array $options = [])
    {
        $this->message = $message;
        $this->numbers = $numbers;
        $this->options = $options;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendSms();
    }
}
