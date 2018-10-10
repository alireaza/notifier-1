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

    protected $heading;
    protected $content;
    protected $player_ids;
    protected $data;
    protected $expire_at;

    /**
     * Create a new job instance.
     *
     * @param $heading
     * @param string $content
     * @param array $player_ids
     * @param array $extra
     * @param int $expire_at
     */
    public function __construct($heading, $content, $player_ids, $extra = null, int $expire_at = 0)
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
        if($this->expire_at === 0 || !Carbon::now()->gt($this->expire_at)) {
            $this->sendPush();
        }
    }
}
