<?php

namespace App\Exceptions;

use Exception;

class FailedResponse extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        // Additional logic to report the exception, if needed
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'status' => false,
            'message' => json_decode($this->getMessage()) ? json_decode($this->getMessage()) : $this->getMessage(),
        ], $this->getCode());
    }
}
