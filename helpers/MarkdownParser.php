<?php

namespace app\helpers;

class MarkdownParser extends \Parsedown
{
    function __construct()
    {
        $this->InlineTypes['['] []= 'ColoredText';

        $this->inlineMarkerList .= '[';
    }

    protected function inlineColoredText($Excerpt)
    {
        if (preg_match('/\[color=([a-zA-Z]{3,20}|\#[0-9a-fA-F]{6}|\#[0-9a-fA-F]{3})](.*?)\[\/color\]/', $Excerpt['text'], $matches))
        {
            return array(
                'extent' => strlen($matches[0]),
                'element' => array(
                    'name' => 'span',
                    'text' => $matches[2],
                    'attributes' => array(
                        'style' => 'color: '.$matches[1],
                    ),
                ),
            );
        }
    }
}