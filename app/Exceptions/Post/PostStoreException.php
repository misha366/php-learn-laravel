<?php

namespace App\Exceptions\Post;

use Exception;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\Pure;
use Throwable;

class PostStoreException extends Exception
{
    #[Pure] public function __construct(string $message = "Failed to store post",
                                        int $code = 0,
                                        ?Throwable $previous = null)
    {

        parent::__construct($message, $code, $previous);
        Log::channel("post")->error("Caused PostStoreException by " . get_class($previous) . ".\n Message: "
            . $this->getMessage(), ['errorCode' => $code]);
    }

}
