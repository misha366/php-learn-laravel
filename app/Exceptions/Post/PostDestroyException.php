<?php

namespace App\Exceptions\Post;

use Exception;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\Pure;
use Throwable;

class PostDestroyException extends Exception
{
    #[Pure] public function __construct(string $message = "Failed to destroy post",
                                        int $code = 0,
                                        ?Throwable $previous = null)
    {

        parent::__construct($message, $code, $previous);
        Log::channel("post")->error("Caused PostDestroyException by " . get_class($previous) . ".\n Message: "
            . $this->getMessage(), ['errorCode' => $code]);
    }

}
