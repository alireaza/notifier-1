<?php

namespace Asanbar\Notifier\Jobs;

use Asanbar\Notifier\Traits\PushTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

class SendPushJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use PushTrait;

    private $heading;
    private $content;
    private $player_ids;
    private $data;
    private $expire_at;

    /**
     * Create a new job instance.
     *
     * @param string $heading
     * @param string $content
     * @param array $player_ids
     * @param array $extra
     * @param int $expire_at
     */
    public function __construct(string $heading, string $content, array $player_ids, array $extra = null, int $expire_at = 0)
    {
        $this->heading = $heading;
        $this->content = $content;
        $this->player_ids = $player_ids;
        $this->data = $extra;
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
            $this->sendPush();
        }
    }
}
