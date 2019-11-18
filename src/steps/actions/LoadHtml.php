<?php

namespace drlenux\codePenLoader\steps\actions;

use drlenux\codePenLoader\steps\StepAbstract;
use drlenux\codePenLoader\steps\StepRequest;
use GuzzleHttp\Client;
use drlenux\codePenLoader\helpers\DirHelper;

/**
 * Class Load
 * @package drlenux\codePenLoader\steps\actions
 */
class LoadHtml extends StepAbstract
{
    /**
     * @param StepRequest $request
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function run(StepRequest $request): bool
    {
        DirHelper::mkDir($request->getDirPath() . '/' . $request->getName());

        $client = new Client();
        $options = [
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
            'user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36'
        ];
        $response = $client->request('GET', $request->getUrl(), $options);

        if ($response->getStatusCode() !== 200) {
            return false;
        }

        preg_match('/srcdoc="(?P<html>[a-zA-Z<!>\ \r\n=&;\-0-9\/:\.#@()?+,|{}*%_\'$[\]\\\^\`\t~]+)"/i', $response->getBody(), $srcdoc);
        $html = str_replace('&quot;', '"', $srcdoc['html']);
        $request->setBody($html);

        return true;
    }
}
