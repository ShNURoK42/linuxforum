<?php

namespace app\helpers;

class MarkdownParser extends \Parsedown
{
    protected function blockHeader($Line)
    {
        return;
    }

    protected function blockSetextHeader($Line, array $Block = null)
    {
        return;
    }
}