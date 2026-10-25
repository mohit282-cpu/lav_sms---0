<?php

namespace App\Jobs;

use App\Services\PwaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWebPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Bounded retry parameters
     */
    public $tries = 3;
    public $backoff = [10, 30, 60];

    protected $userIds;
    protected $title;
    protected $body;
    protected $targetUrl;

    /**
     * Create a new job instance.
     *
     * @param int|array $userIds
     * @param string $title
     * @param string $body
     * @param string|null $targetUrl
     */
    public function __construct($userIds, string $title, string $body, ?string $targetUrl = null)
    {
        $this->userIds = is_array($userIds) ? $userIds : [$userIds];
        $this->title = $title;
        $this->body = $body;
        $this->targetUrl = $targetUrl;
    }

    /**
     * Execute the job.
     *
     * @param PwaService $pwaService
     * @return array
     */
    public function handle(PwaService $pwaService)
    {
        return $pwaService->sendToUsers($this->userIds, $this->title, $this->body, $this->targetUrl);
    }

    /**
     * Handle a job failure.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        Log::warning('SendWebPushNotification job failed permanently: ' . $exception->getMessage(), [
            'recipients_count' => count($this->userIds),
            'title' => $this->title,
        ]);
    }
}
