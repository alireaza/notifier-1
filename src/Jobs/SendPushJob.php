<?php

namespace Asanbar\Notifier\Jobs;

use Asanbar\Notifier\Traits\PushTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPushJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use PushTrait;

    private $heading;
    private $content;
    private $player_ids;
    private $data;
    private $options;

    /**
     * Create a new job instance.
     *
     * @param string $heading
     * @param string $content
     * @param array $player_ids
     * @param array $extra
     * @param array $options
     */
    public function __construct(string $heading, string $content, array $player_ids, array $extra = NULL, array $options = [])
    {
        $this->heading    = $heading;
        $this->content    = $content;
        $this->player_ids = $player_ids;
        $this->data       = $extra;
        $this->options    = $options;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendPush();
    }
}
