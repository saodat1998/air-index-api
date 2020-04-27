<?php

namespace App\Services\EntityService;

use Prettus\Repository\Eloquent\BaseRepository;
use Exception;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Response;
use Illuminate\Log\Logger;
use Illuminate\Support\Arr;

/**
 * Class BaseService
 * @package App\Services\EntityService
 */
abstract class BaseService
{
    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    /**
     * @var string
     */
    protected $error;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var BaseRepository
     */
    protected $repository;

    /**
     * BaseService constructor.
     *
     * @param DatabaseManager $databaseManager
     * @param Logger $logger
     * @param BaseRepository $repository
     */
    public function __construct(DatabaseManager $databaseManager, Logger $logger, BaseRepository $repository)
    {
        $this->databaseManager = $databaseManager;
        $this->logger          = $logger;
        $this->repository      = $repository;
    }

    /**
     * Start a new database transaction.
     *
     * @return void
     * @throws Exception
     * @throws \Throwable
     */
    protected function beginTransaction()
    {
        $this->databaseManager->beginTransaction();
    }

    /**
     * Rollback the active database transaction.
     *
     * @param \Exception $e
     * @param string $message
     * @param array $context
     * @return mixed
     * @throws Exception
     * @throws \Throwable
     */
    protected function rollback(Exception $e, $message = '', $context = [])
    {
        $this->databaseManager->rollBack();
        $this->logError($e, $message, $context);

        $status = $e->getCode();

        if (Arr::get(Response::$statusTexts, $status))
        {
            if (!app()->environment(['production', 'prod'])) $message = $e->getMessage();
        } else {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        throw new Exception($message, $status);
    }

    /**
     * Write occurred error to logs.
     *
     * @param  Exception $e
     * @param  string $message
     * @param  array $context
     * @return void
     */
    protected function logError(Exception $e, $message = '', $context = []): void
    {
        $this->logger->error($message, $context);
        $this->logger->error($e);
    }

    /**
     * Commit the active database transaction.
     *
     * @return void
     * @throws \Throwable
     */
    protected function commit()
    {
        $this->databaseManager->commit();
    }

    /**
     * Set error for user.
     * For example, can be used in controllers.
     *
     * @param  string  $error
     */
    protected function error($error)
    {
        $this->logger->error($error);
        $this->error = $error;
    }

    /**
     * Get last error message.
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set message.
     *
     * @param string $message
     */
    protected function message($message)
    {
        $this->logger->info('Added message', [
            'message' => $message,
        ]);
        $this->message = $message;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Calling model's default functions.
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->repository, $method], $args);
    }
}
