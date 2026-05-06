<?php

namespace App\Services;

use App\Models\Video;

class ExportService
{
    public function generate(): array
    {
        $videos = Video::with('collection')->where('status', Video::STATUS_DONE)->get();
        $result = [];
        foreach ($videos as $video) {
            // https://{pull_zone}.b-cdn.net/{bunny_video_id}/play_1080p.mp4
            $url = 'https://' . config('bunny.pull_zone') . '.b-cdn.net/' . $video->bunny_video_id . '/play_1080p.mp4';
            $result[] = [
                'name' => $video->name,
                'url' => $url
            ];
        }

        return $result;
    }
}