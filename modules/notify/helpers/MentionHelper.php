<?php

namespace notify\helpers;

class MentionHelper
{
    public static function find($text)
    {
        //(^|\s)@([a-zA-Z][\w-]+)
        $pattern = '/\B@([a-zA-Z][\w-]+)/';

        if (preg_match_all($pattern, $text)) {
            $text = str_replace(["\r\n", "\r"], "\n", $text);
            $text = trim($text, "\n");
            $lines = explode("\n", $text);

            $mentions = [];
            $isBlockCode = false;
            foreach ($lines as $line) {
                if (empty($line)) {
                    continue;
                }

                if (($l = $line[0]) === '`' && strncmp($line, '```', 3) === 0 || $l === '~' && strncmp($line, '~~~', 3) === 0) {
                    if ($isBlockCode === false) {
                        $isBlockCode = true;
                    } else {
                        $isBlockCode = false;
                    }
                    continue;
                } elseif ($isBlockCode === true) {
                    continue;
                } elseif (($l = $line[0]) === ' ' && $line[1] === ' ' && $line[2] === ' ' && $line[3] === ' ' || $l === "\t") {
                    continue;
                } elseif (preg_match('/^`(.+?)`/s', $line)) {
                    continue;
                } else {
                    if (preg_match_all($pattern, $line, $matches)) {
                        $mentions = array_merge($mentions, $matches[1]);
                    }
                }
            }

            return array_unique($mentions);
        }

        return null;
    }
}