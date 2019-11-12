<?php

namespace drlenux\codePenLoader\steps\actions;

use drlenux\codePenLoader\CodePenLoader;
use drlenux\codePenLoader\steps\StepAbstract;
use drlenux\codePenLoader\steps\StepRequest;
use drlenux\codePenLoader\helpers\DirHelper;
use KubAT\PhpSimple\HtmlDomParser;
use simple_html_dom\simple_html_dom;
use simple_html_dom\simple_html_dom_node;
use Yangqi\Htmldom\Htmldom;


/**
 * Class ParserJs
 * @package drlenux\codePenLoader\steps\actions
 */
class ParserJs extends StepAbstract
{
    /**
     * @param StepRequest $request
     * @return bool
     */
    public function run(StepRequest $request): bool
    {
        $dirPath = CodePenLoader::getDirPath() . '/' . $request->getName() . '/js/';
        DirHelper::mkDir($dirPath);

        /** @var simple_html_dom $dom */
        $dom = HtmlDomParser::str_get_html($request->getBody());
        $scripts = $dom->find('script');
        $id = 0;

        /** @var simple_html_dom_node $script */
        foreach ($scripts as $script) {
            $url = $script->getAttribute('src');
            @$name = end(explode('/', $url));
            if (strlen($url)) {
                file_put_contents($dirPath . $name, file_get_contents($url));
                $script->setAttribute('src', './js/' . $name);
            } else {
                $js = $script->innertext();
                file_put_contents($dirPath . (++$id) . '.js', $js);
                $script->innertext = '';
                $script->setAttribute('src', './js/' . $id . '.js');
            }
        }

        $request->setBody($dom);

        return true;
    }
}