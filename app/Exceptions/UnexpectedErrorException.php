<?php
 
namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Throwable;

class UnexpectedErrorException extends Exception
{
    /*
     * Message text params
     */
    protected $message;
    protected $code;
    protected $previous;

    /**
     * NotFoundException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = "An unexpected error occurred!",
        $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
    }
 
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'type'    => 'error',
            'code'    => $this->code,
            'message' => $this->message,
        ], $this->code);
    }
}