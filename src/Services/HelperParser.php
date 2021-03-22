<?php


namespace App\Services;


use cebe\markdown\Markdown;

class HelperParser
{
    private $parser;

    public function __construct(Markdown $parser)
    {
        $this->parser = $parser;
    }

    public function markdownToHtml(string $text): string
    {
        return $this->parser->parse($text);
    }
}