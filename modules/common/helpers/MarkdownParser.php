<?php

namespace common\helpers;

use user\models\User;

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
            return [
                'extent' => strlen($matches[0]),
                'element' => [
                    'name' => 'span',
                    'text' => $matches[2],
                    'attributes' => [
                        'style' => 'color: '.$matches[1],
                    ],
                ],
            ];
        }
    }

    protected function inlineUserMention($Excerpt)
    {
        if (preg_match('/\B@([a-zA-Z][\w-]+)/', $Excerpt['context'], $matches)) {
            /** @var User $user */
            $user = User::findByUsername($matches[1]);
            if ($user) {
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
            } else {
                return [
                    'markup' => $matches[0],
                    'extent' => strlen($matches[0]),
                ];
            }
        }
    }
}