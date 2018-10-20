<?php

namespace Asanbar\Notifier\Jobs;

use Asanbar\Notifier\Traits\MessageTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use MessageTrait;

    private $title;
    private $body;
    private $user_ids;
    private $options;

    /**
     * Create a new job instance.
     *
     * @param string $title
     * @param string $body
     * @param array $user_ids
     * @param array $options
     */
    public function __construct(string $title, string $body, array $user_ids, array $options = [])
    {
        $this->title    = $title;
        $this->body     = $body;
        $this->user_ids = $user_ids;
        $this->options  = $options;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendMessage();
    }
}
