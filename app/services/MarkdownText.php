<?php
namespace App\Services;
use League\CommonMark\CommonMarkConverter;

class MarkdownText {

    public function convert($markdownText){
        $converter = new CommonMarkConverter();
        $renderedText =  $converter->convert($markdownText);

        return $renderedText;
    }
}