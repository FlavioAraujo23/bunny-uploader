<?php

namespace App\Exceptions;

use Exception;

class CollectionNotFoundException extends Exception
{

   public function __construct(string $message = "Collection not found")
   {
      parent::__construct($message);
   }
}
