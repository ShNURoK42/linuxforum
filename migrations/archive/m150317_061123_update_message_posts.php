<?php

use yii\db\Schema;
use yii\db\Migration;

class m150317_061123_update_message_posts extends Migration
{
    public function up()
    {
        $posts = $this->db->createCommand('SELECT id, message FROM posts');
        $posts = $posts->queryAll();
        $count = sizeof($posts);

        $i = 1;
        foreach ($posts as $post) {
            $new_post = $this->bbcode($post['message']);
            $command = $this->db->createCommand('UPDATE posts SET message=:message WHERE id=:id');
            $command->bindParam(':id', $post['id']);
            $command->bindParam(':message', $new_post);
            $command->execute();

            if ($i % 1000 == 0) {
                echo "Post number: $i from $count\n";
            }
            $i++;
        }
    }

    protected function bbcode($bbcode)
    {
        $bbcode = str_replace("\n", "  \n", $bbcode);

        $bbcode = str_replace("[b]", "**", $bbcode);
        $bbcode = str_replace("[/b]", "**", $bbcode);

        $bbcode = str_replace("[i]", "*", $bbcode);
        $bbcode = str_replace("[/i]", "*", $bbcode);

        $bbcode = str_replace("[s]", "", $bbcode);
        $bbcode = str_replace("[/s]", "", $bbcode);

        $bbcode = str_replace("[u]", "", $bbcode);
        $bbcode = str_replace("[/u]", "", $bbcode);

        // [email]
        $bbcode = preg_replace_callback('/\[email\](.*?)\[\/email\]/s',
            function ($matches) {
                return $matches[1];
            },
            $bbcode
        );
        $bbcode = preg_replace_callback('/\[email\s*=\s*(.*?)\](.*?)\[\/email\]/s',
            function ($matches) {
                return $matches[1];
            },
            $bbcode
        );
        // [color]
        $bbcode = preg_replace_callback('/\[color=([a-zA-Z]{3,20}|\#[0-9a-fA-F]{6}|\#[0-9a-fA-F]{3})](.*?)\[\/color\]/s',
            function ($matches) {
                return $matches[2];
            },
            $bbcode
        );
        // [url]
        $bbcode = preg_replace_callback('/\[url\](.*?)\[\/url\]/s',
            function ($matches) {
                return "<" . $matches[1] . ">";
            },
            $bbcode
        );
        $bbcode = preg_replace_callback('/\[url\=(.*?)\](.*?)\[\/url\]/s',
            function ($matches) {
                return "[" . $matches[2] . "](" . $matches[1] . ")";
            },
            $bbcode
        );
        // [spoiler]
        $bbcode = preg_replace_callback('/\[spoiler\](.*?)\[\/spoiler\]/s',
            function ($matches) {
                return $matches[1];
            },
            $bbcode
        );
        $bbcode = preg_replace_callback('/\[spoiler\=(.*?)\](.*?)\[\/spoiler\]/s',
            function ($matches) {
                return $matches[2];
            },
            $bbcode
        );
        // [img]
        $bbcode = preg_replace_callback('/\[img\](.*?)\[\/img\]/s',
            function ($matches) {
                return PHP_EOL . "![]" . "(" . $matches[1] . ")" . PHP_EOL;
            },
            $bbcode
        );
        $bbcode = preg_replace_callback('/\[img\=(.*?)\](.*?)\[\/img\]/s',
            function ($matches) {
                return PHP_EOL . "![".$matches[2]."]" . "(" . $matches[1] . ")" . PHP_EOL;
            },
            $bbcode
        );

        $bbcode = $this->replaceLists($bbcode);
        $bbcode = $this->replaceQuotes($bbcode);
        $bbcode = $this->replaceCode($bbcode);
        $bbcode = $this->replaceConsole($bbcode);

        return $bbcode;
    }

    protected function replaceLists($text)
    {
        if (strpos($text,'[list') !== false) {
            $text = preg_replace_callback(
                '%\[list(?:=([1a*]))?+\]((?:[^\[]*+(?:(?!\[list(?:=[1a*])?+\]|\[/list\])\[[^\[]*+)*+|(?R))*)\[/list\]%i',
                function($matches) {
                    return $this->replaceLists($matches[2]);
                },
                $text
            );
        }
        $text = preg_replace('#\s*\[\*\](.*?)\[/\*\]\s*#s', '- $1'.PHP_EOL, trim($text));

        return PHP_EOL . $text . PHP_EOL;
    }


    protected function replaceQuotes($text) {
        $text = preg_replace("~\G(?<!^)(?>(\[quote\b[^]]*](?>[^[]++|\[(?!/?quote)|(?1))*\[/quote])|(?<!\[)(?>[^[]++|\[(?!/?quote))+\K)|\[quote\b[^]]*]\K~", '', $text);

        return preg_replace_callback('%\[quote\b[^]]*\]((?>[^[]++|\[(?!/?quote))*)\[/quote\]%i',
            function($matches) {
                $quote = preg_replace('/^\s*/mu', '', trim($matches[1]));
                return "> ".$quote . PHP_EOL . PHP_EOL;
            },
            $text
        );
    }

    protected function replaceCode($text)
    {
        return preg_replace_callback('%\[code\]([\W\D\w\s]*?)\[\/code\]%iu',
            function ($matches) {
                return PHP_EOL . "```" . PHP_EOL . trim($matches[1]) . PHP_EOL . "```" . PHP_EOL;
            },
            $text
        );
    }

    protected function replaceConsole($text)
    {
        $text = preg_replace("~\G(?<!^)(?>(\[console\b[^]]*](?>[^[]++|\[(?!/?console)|(?1))*\[/console])|(?<!\[)(?>[^[]++|\[(?!/?console))+\K)|\[console\b[^]]*]\K~", '', $text);

        return preg_replace_callback('%\[console\b[^]]*\]((?>[^[]++|\[(?!/?console))*)\[/console\]%i',
            function($matches) {
                $console = preg_replace('/^\s*/mu', '', trim($matches[1]));
                return PHP_EOL . "```" . PHP_EOL . $console . PHP_EOL . "```" . PHP_EOL;
            },
            $text
        );
    }
}
