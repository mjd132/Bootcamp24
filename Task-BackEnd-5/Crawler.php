<?php
require_once 'WordProcessing.php';
require_once 'HttpClient.php';

class Crawler
{

    protected array $data = [];
    private $domDoc;
    private $aBody;
    private $wordProcessor;
    public function __construct($page)
    {

        if (!$page) {
            throw new InvalidArgumentException('No page content provided');
        }

        $this->domDoc = new DOMDocument('1.0', 'UTF-8');
        @$this->domDoc->loadHTML(mb_convert_encoding($page, 'HTML-ENTITIES', 'UTF-8'));
        $this->RemoveChildTags($this->domDoc, 'script');
        // get elemnet with root id (in yjc.ir #root is article body)
        $articleBody = $this->findById('root') ?: $this->findByTagName('body')->item(0);
        $articleBody = $this->domDoc->saveHTML($articleBody);

        $this->wordProcessor = new \WordProcessor($articleBody);
        $this->aBody = $articleBody;
    }
    private function RemoveChildTags($parentTag, $childTagName)
    {
        $tags = $parentTag->getElementsByTagName($childTagName);
        foreach ($tags as $tag) {
            $tag->parentNode->removeChild($tag);
        }
    }

    function CountWordInPage()
    {
        $wordCount = count($this->wordProcessor->pWords);
        return $wordCount;
    }
    function GetTitle()
    {
        return $this->domDoc->getElementsByTagName('title')->item(0)->textContent;
    }

    function searchWordInHTML($keywords)
    {
        $text = $this->wordProcessor->pText;

        foreach ($keywords as $kw) {
            $res = strpos($text, $kw);
            if ($res) {
                return true;
            }
        }
        return false;

    }
    public function findByTagName($tagName)
    {
        return $this->domDoc->getElementsByTagName($tagName);
    }
    public function findById($id)
    {
        return $this->domDoc->getElementById($id);
    }
    public function countArticleBodyTags($tagName)
    {
        return $this->findByTagName($tagName)->length;
    }

    public function findUrlsOfDomain($baseDomain, $keywordLink = null)
    {
        $urls = [];
        $linkTags = $this->findByTagName('a');

        foreach ($linkTags as $linkTag) {
            $url = $linkTag->getAttribute('href');
            if ($keywordLink && strpos($url, $keywordLink) === false)
                continue;
            if (strpos($url, '/') === 0)
                $url = $baseDomain . $url;
            if (filter_var($url, FILTER_VALIDATE_URL) && parse_url($url, PHP_URL_HOST) === parse_url($baseDomain, PHP_URL_HOST))
                $urls[] = $url;
        }

        return array_unique($urls);
    }

}

