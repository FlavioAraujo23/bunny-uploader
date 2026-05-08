<?php

namespace App\Exceptions;

use Exception;

class VideoUploadException extends Exception
{
    public function __construct(string $message = "Video upload failed")
    {
        parent::__construct($message);
    }
}
