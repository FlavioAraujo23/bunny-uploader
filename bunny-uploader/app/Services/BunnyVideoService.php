<?php

namespace App\Services;

use App\Exceptions\BunnyApiException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
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
        Log::info('BunnyVideoService config recebido', $config);
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
                'response' => $response->body(),
                'exception' => $e->getMessage()
            ]);
            throw BunnyApiException::fromResponse($this->baseUrl(), $response->status(), $response->body());
        })->post($this->baseUrl(), [
            'title' => $title,
            'collectionId' => $collectionId,
            'thumbnailTime' => 3000 // 3s em ms para gerar a thumb do video
        ]);

        $data = $response->json();

        return $data;
    }

    public function generateTusCredentials(string $bunnyVideoId): array
    {
        $expirationTime = time() + 86400;
        $signature = $this->generateSignature($bunnyVideoId, $expirationTime);
        return [
            'videoId' => $bunnyVideoId,
            'libraryId' => (int) $this->library_educacao_digital_id,
            'expirationTime' => $expirationTime,
            'signature' => $signature,
        ];
    }

    private function generateSignature(string $bunnyVideoId, int $expirationTime)
    {
        $concatValue = $this->library_educacao_digital_id . $this->api_key . $expirationTime . $bunnyVideoId;

        $signature = hash('sha256', $concatValue);

        return $signature;
    }

    private function baseUrl()
    {
        return $this->base_url . "/library/" . $this->library_educacao_digital_id . "/videos";
    }
}