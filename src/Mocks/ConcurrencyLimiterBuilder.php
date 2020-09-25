<?php


namespace Nbj\Mocks;


use Exception;

class ConcurrencyLimiterBuilder
{
    /**
     * Execute the given callback if a lock is obtained, otherwise call the failure callback.
     *
     * @param callable $callback
     * @param callable|null $failure
     * @return mixed
     *
     * @throws Exception
     */
    public function then(callable $callback, callable $failure = null)
    {
        try {
            return $callback();
        } catch (Exception $exception) {
            if ($failure) {
                return $failure($exception);
            }

            throw $exception;
        }
    }

    // Ignore all building methods, and just return itself.
    public function __call($name, $arguments)
    {
        return $this;
    }
}
