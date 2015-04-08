<?php

namespace app\helpers;

use app\models\User;

class MarkdownParser extends \Parsedown
{
    function __construct()
    {
        $this->InlineTypes['['][]= 'ColoredText';
        $this->InlineTypes['@'][]= 'UserMention';

        $this->inlineMarkerList .= '[';
        $this->inlineMarkerList .= '@';
    }

    public function parse($text)
    {
        $text = $this->setBreaksEnabled(true)
            ->setMarkupEscaped(true)
            ->text($text);

        return $text;
    }

    protected function inlineColoredText($Excerpt)
    {
        if (preg_match('/\[color=([a-zA-Z]{3,20}|\#[0-9a-fA-F]{6}|\#[0-9a-fA-F]{3})](.*?)\[\/color\]/', $Excerpt['text'], $matches))
        {
            return array(
                'extent' => strlen($matches[0]),
                'element' => [
                    'name' => 'span',
                    'text' => $matches[2],
                    'attributes' => [
                        'style' => 'color: '.$matches[1],
                    ],
                ],
            );
        }
    }

    protected function inlineUserMention($Excerpt)
    {
        if (preg_match('/\B@([a-zA-Z][\w-]+)/', $Excerpt['context'], $matches)) {
            /** @var User $user */
            $user = User::findByUsername($matches[1]);
            if (!$user) {
                return;
            }

            return [
                'extent' => strlen($matches[0]),
                'element' => [
                    'name' => 'a',
                    'text' => $matches[0],
                    'attributes' => [
                        'href' => '/user/' . $user->id,
                        'class' => 'user-mention',
                    ],
                ],
            ];
        }
    }

    public static function findMentions($text)
    {
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