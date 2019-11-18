<?php

namespace drlenux\codePenLoader\actions;

use drlenux\codePenLoader\CodePenLoader;
use drlenux\codePenLoader\steps\actions\InitStep;
use drlenux\codePenLoader\steps\actions\ParserCss;
use drlenux\codePenLoader\steps\actions\ParserJs;
use drlenux\codePenLoader\steps\actions\SaveHtml;
use drlenux\codePenLoader\steps\StepInterface;
use drlenux\codePenLoader\steps\StepRequest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use drlenux\codePenLoader\steps\actions\LoadHtml;

/**
 * Class Load
 * @package drlenux\codePenLoader\actions
 */
class Load extends Command
{
    protected static $defaultName = 'src:load';

    const URL = 'https://cdpn.io/{{user}}/fullpage/{{project}}';

    /**
     *
     */
    protected function configure()
    {
        $this
            ->addArgument('user', InputArgument::REQUIRED)
            ->addArgument('project', InputArgument::REQUIRED)
            ->addArgument('name', InputArgument::OPTIONAL);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $input->getArgument('user');
        $project = $input->getArgument('project');
        $name = $input->getArgument('name');

        if (null === $name) {
            $name = $user . '/' . $project;
        }

        $request = new StepRequest($this->getUrl($user, $project), CodePenLoader::getDirPath(), $name);
        $this->getStep()->handle($request);
    }

    /**
     * @return StepInterface
     */
    private function getStep(): StepInterface
    {
        $step = new InitStep();

        $step->setNext(new LoadHtml())
            ->setNext(new ParserJs())
            ->setNext(new ParserCss())
            ->setNext(new SaveHtml());

        return $step;
    }

    /**
     * @param string $user
     * @param string $project
     * @return string
     */
    private function getUrl(string $user, string $project): string
    {
        $url = str_replace('{{user}}', $user, self::URL);
        return str_replace('{{project}}', $project, $url);
    }
}
