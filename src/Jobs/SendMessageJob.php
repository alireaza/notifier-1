<?php

namespace Asanbar\Notifier\Jobs;

use Asanbar\Notifier\Traits\MessageTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use MessageTrait;

    protected $title;
    protected $body;
    protected $user_ids;
    protected $expire_at;

    /**
     * Create a new job instance.
     *
     * @param $title
     * @param $body
     * @param $user_ids
     * @param int $expire_at
     */
    public function __construct($title, $body, $user_ids, int $expire_at = 0)
    {
        $this->title = $title;
        $this->body = $body;
        $this->user_ids = $user_ids;
        $this->expire_at = $expire_at > 0 ? Carbon::now()->addSeconds($expire_at) : 0;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->expire_at === 0 || !Carbon::now()->gt($this->expire_at)) {
            $this->sendMessage();
        }
    }
}
