<?php

namespace App\Exceptions;

use Exception;

class Debug extends Exception
{
    private $data;
    public function __construct($data = null, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->data = $data;
    }

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
            'message' => "Debugging Error",
            'data' => $this->data
        ], $this->getCode());
    }
}
