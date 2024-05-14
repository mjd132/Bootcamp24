<?php

class WordProcessor
{
    const STOP_WORDS = ['با', 'به', 'برای', 'و', 'دیگر', 'از', 'بر', 'در', 'تا', 'بی', 'مگر', 'الا', 'چون'];

    public string $pText;
    public array $pWords;
    public function __construct($html)
    {

        $text = strip_tags($html);
        preg_match_all('/\p{Arabic}+/u', $text, $words);
        $words = array_unique($words[0]);
        $words = array_diff($words, self::STOP_WORDS);

        $this->pText = $text;
        $this->pWords = $words;
    }


}


