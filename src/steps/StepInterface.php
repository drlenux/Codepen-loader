<?php

namespace drlenux\codePenLoader\steps;

/**
 * Interface StepInterface
 * @package drlenux\codePenLoader\step
 */
interface StepInterface
{
    /**
     * @param StepInterface $step
     * @return StepInterface
     */
    public function setNext(StepInterface $step): StepInterface;

    /**
     * @param StepRequest $request
     * @return bool
     */
    public function handle(StepRequest $request): bool;
}
