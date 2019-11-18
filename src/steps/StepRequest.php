<?php

namespace drlenux\codePenLoader\steps;

/**
 * Class StepRequest
 * @package drlenux\codePenLoader\step
 */
class StepRequest
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $dirPath;

    /**
     * @var string;
     */
    private $name;

    /**
     * StepRequest constructor.
     * @param string $url
     * @param string $dirPath
     * @param string $name
     */
    public function __construct(string $url, string $dirPath, string $name)
    {
        $this->url = $url;
        $this->dirPath = $dirPath;
        $this->name = $name;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getDirPath(): string
    {
        return $this->dirPath;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
