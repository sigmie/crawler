<?php

declare(strict_types=1);

namespace Sigmie\Crawler;

class Config
{
    public array $ignoreList;

    public string $navigationSelector;

    public string $contentSelector;

    public string $url;

    public string $file;

    public string $delimiter;

    public function __construct()
    {

    }

    /**
     * Get the value of delimiter
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * Set the value of delimiter
     */
    public function setDelimiter($delimiter): self
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * Get the value of file
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * Set the value of file
     */
    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get the value of url
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set the value of url
     */
    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of contentSelector
     */
    public function getContentSelector(): string
    {
        return $this->contentSelector;
    }

    /**
     * Set the value of contentSelector
     */
    public function setContentSelector($contentSelector): self
    {
        $this->contentSelector = $contentSelector;

        return $this;
    }

    /**
     * Get the value of navigationSelector
     */
    public function getNavigationSelector(): string
    {
        return $this->navigationSelector;
    }

    /**
     * Set the value of navigationSelector
     */
    public function setNavigationSelector($navigationSelector): self
    {
        $this->navigationSelector = $navigationSelector;

        return $this;
    }

    /**
     * Get the value of ignoreList
     */
    public function getIgnoreList()
    {
        return $this->ignoreList;
    }

    /**
     * Set the value of ignoreList
     *
     * @return  self
     */
    public function setIgnoreList($ignoreList)
    {
        $this->ignoreList = $ignoreList;

        return $this;
    }
}
