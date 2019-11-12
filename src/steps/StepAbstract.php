<?php

namespace drlenux\codePenLoader\steps;

/**
 * Class StepAbstract
 * @package drlenux\codePenLoader\step
 */
abstract class StepAbstract implements StepInterface
{
    /**
     * @var StepInterface
     */
    private $next;

    /**
     * @param StepInterface $step
     * @return StepInterface
     */
    public function setNext(StepInterface $step): StepInterface
    {
        $this->next = $step;
        return $step;
    }

    /**
     * @param StepRequest $request
     * @return bool
     */
    public function handle(StepRequest $request): bool
    {
        try {
            $status = $this->run($request);
        } catch (\Throwable $exception) {
            $status = false;
            dump($exception);
        }

        if ($status && null !== $this->next) {
            return $this->next->handle($request);
        }

        return $status;
    }

    /**
     * @param StepRequest $request
     * @return bool
     */
    abstract public function run(StepRequest $request): bool;
}