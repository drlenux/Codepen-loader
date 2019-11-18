<?php

namespace drlenux\codePenLoader\steps\actions;

use drlenux\codePenLoader\CodePenLoader;
use drlenux\codePenLoader\steps\StepAbstract;
use drlenux\codePenLoader\steps\StepRequest;
use KubAT\PhpSimple\HtmlDomParser;
use simple_html_dom\simple_html_dom;
use simple_html_dom\simple_html_dom_node;

/**
 * Class ParserCss
 * @package drlenux\codePenLoader\steps\actions
 */
class ParserCss extends StepAbstract
{

    /**
     * @param StepRequest $request
     * @return bool
     */
    public function run(StepRequest $request): bool
    {
        $dirPath = CodePenLoader::getDirPath() . '/' . $request->getName() . '/css/';

        /** @var simple_html_dom $dom */
        $dom = HtmlDomParser::str_get_html($request->getBody());
        if ($dom === false) {
            return true;
        }
        $styles = $dom->find('style');
        $id = 0;

        /** @var simple_html_dom_node $style */
        foreach ($styles as $style) {
            $id++;
            file_put_contents($dirPath . $id . '.css', $style->innertext());
            $style->innertext = '';
        }

        $links = $dom->find('link');

        /** @var simple_html_dom_node $link */
        foreach ($links as $link)
        {
            $url = $link->getAttribute('href');
            $name = @end(explode('/', $url));
            file_put_contents($dirPath . $name, file_get_contents($url));
            $link->setAttribute('href', './css/' . $name);
        }

        /** @var simple_html_dom_node $head */
        $head = $dom->find('head')[0];

        for ($i = 0; $i <= $id; ++$i) {
            $link = $dom->createElement('link');
            $link->setAttribute('href', './css/' . $i . '.css');
            $link->setAttribute('rel', 'stylesheet');
            $link->setAttribute('type', 'text/css');
            $head->appendChild($link);
        }

        $request->setBody($dom);
        return true;
    }
}
