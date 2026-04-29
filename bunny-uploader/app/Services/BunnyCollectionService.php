<?php

namespace App\Services;

use App\Models\Collection;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class BunnyCollectionService
{
    private string $api_key;
    private array $library_educacao_digital_id;
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

    public function create(string $name): Collection
    {

        $response = Http::withHeaders([
            'AccessKey' => $this->api_key,
            'Content-Type' => 'application/json',
        ])->throw(function (Response $response, RequestException $e) {
            Log::error('Something went wrong while create an collection.', [
                'response' => $response->getContent(),
                'exception' => $e->getMessage()
            ]);
            return null;
        })->post($this->baseUrl(), [
            'name' => $name,
        ]);

        $data = $response->json();
        return Collection::create([
            'name' => $data['name'],
            'bunny_id' => $data['guid']
        ]);
    }

    public function list()
    {
        return Collection::all();
    }

    private function baseUrl()
    {

        return $this->base_url . "/library/" . $this->library_educacao_digital_id . "/collections";
    }
}