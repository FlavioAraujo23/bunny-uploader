<?php

namespace App\Services;

use App\Models\Collection;
use App\Models\Video;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class BunnyVideoService
{
    private string $api_key;
    private string $library_educacao_digital_id;
    private string $base_url;
    public function __construct(private array $config)
    {
        if (!isset(
            $config['api_key'],
            $config['library_educacao_digital_id'],
            $config['base_url'],
        )) {
            throw new InvalidArgumentException('Missed options in config');
        };

        $this->api_key = $config['api_key'];
        $this->library_educacao_digital_id = $config['library_educacao_digital_id'];
        $this->base_url = $config['base_url'];
    }

    public function createVideo(string $title, string $collectionId): array
    {

        $response = Http::withHeaders([
            'AccessKey' => $this->api_key,
            'Content-Type' => 'application/json',
        ])->throw(function (Response $response, RequestException $e) {
            Log::error('Something went wrong while create an video.', [
                'response' => $response->getContent(),
                'exception' => $e->getMessage()
            ]);
            return null;
        })->post($this->baseUrl(), [
            'title' => $title,
            'collectionId' => $collectionId,
            'thumbnailTime' => 3000 // 3s em ms para gerar a thumb do video
        ]);

        $data = $response->json();

        return $data;
    }

    public function uploadVideo(string $bunnyVideoId, string $fileContents): array
    {
        $response = Http::withHeaders([
            'AccessKey' => $this->api_key,
            'Content-Type' => 'application/octet-stream',
        ])->throw(function (Response $response, RequestException $e) {
            Log::error('Something went wrong while create an video.', [
                'response' => $response->getContent(),
                'exception' => $e->getMessage()
            ]);
            return null;
        })->put($this->baseUrl() . '/' . $bunnyVideoId, $fileContents);

        $data = $response->json();
        return $data;
    }

    private function baseUrl()
    {
        return $this->base_url . "/library/" . $this->library_educacao_digital_id . "/videos";
    }
}