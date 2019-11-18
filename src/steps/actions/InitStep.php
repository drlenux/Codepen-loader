<?php

namespace drlenux\codePenLoader\steps\actions;

use drlenux\codePenLoader\CodePenLoader;
use drlenux\codePenLoader\helpers\DirHelper;
use drlenux\codePenLoader\steps\StepAbstract;
use drlenux\codePenLoader\steps\StepRequest;

/**
 * Class InitStep
 * @package drlenux\codePenLoader\steps\actions
 */
class InitStep extends StepAbstract
{

    /**
     * @param StepRequest $request
     * @return bool
     */
    public function run(StepRequest $request): bool
    {
        DirHelper::mkDir(CodePenLoader::getDirPath() . '/' . $request->getName() . '/js/');
        DirHelper::mkDir(CodePenLoader::getDirPath() . '/' . $request->getName() . '/css/');
        return true;
    }
}
