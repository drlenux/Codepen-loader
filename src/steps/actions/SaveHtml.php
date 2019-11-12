<?php

namespace drlenux\codePenLoader\steps\actions;

use drlenux\codePenLoader\steps\StepAbstract;
use drlenux\codePenLoader\steps\StepRequest;

/**
 * Class SaveHtml
 * @package drlenux\codePenLoader\steps\actions
 */
class SaveHtml extends StepAbstract
{
    /**
     * @param StepRequest $request
     * @return bool
     */
    public function run(StepRequest $request): bool
    {
        $body = $request->getBody();
        file_put_contents($request->getDirPath() . '/' . $request->getName() . '/index.html', $body);
        return true;
    }
}