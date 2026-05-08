<?php

namespace App\Exceptions;

use Exception;

class BunnyApiException extends Exception
{
    public function __construct(string $message, private int $statusCode, private array $context = [])
    {
        parent::__construct($message);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public static function fromResponse(string $endpoint, int $statusCode, string $responseBody): self
    {
        return new BunnyApiException(
            'Bunny API returned ' . $statusCode . ' on ' . $endpoint,
            $statusCode,
            [
                'endpoint' => $endpoint,
                'response_body' => $responseBody
            ]
        );
    }
}