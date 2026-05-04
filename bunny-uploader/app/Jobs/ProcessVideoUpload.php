<?php

namespace App\Jobs;

use App\Models\Video;
use App\Services\BunnyVideoService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Queue\Attributes\Timeout;
use Illuminate\Queue\Attributes\Tries;
use Illuminate\Support\Facades\Log;
use Throwable;

#[Backoff(60)]
#[Tries(3)]
#[Timeout(300)]
class ProcessVideoUpload implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private Video $video, private string $tempPath, private string $collection_id) {}

    /**
     * Execute the job.
     */
    public function handle(BunnyVideoService $service): void
    {
        $this->video->update(['status' => Video::STATUS_PROCESSING]);

        $content = file_get_contents($this->tempPath);

        $data = $service->createVideo($this->video->name, $this->collection_id);
        $service->uploadVideo($data['guid'], $content);

        $this->video->update(['status' => Video::STATUS_DONE, 'bunny_video_id' => $data['guid']]);
    }


    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        $this->video->update(['status' => Video::STATUS_FAILED]);
        Log::error('Something went wrong while process an video.', [
            'exception' => $exception->getMessage()
        ]);
    }
}