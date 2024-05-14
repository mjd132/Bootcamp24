<?php
require_once "Crawler.php";
require_once "output.php";
ob_implicit_flush(true);

const LIMIT_PAGES_PROCESSING = 10, LIMIT_RETRIEVE_TIMES = 6;

$baseUrl = "https://www.yjc.ir/";
// $url = "https://www.yjc.ir/fa/news/8733226/%D9%85%D8%AD%D9%85%D9%88%D8%AF-%D8%AD%D8%B3%DB%8C%D9%86%DB%8C%E2%80%8C%D9%BE%D9%88%D8%B1-%D9%85%D8%B9%D8%A7%D9%88%D9%86-%D9%BE%D8%A7%D8%B1%D9%84%D9%85%D8%A7%D9%86%DB%8C-%D8%B1%D8%A6%DB%8C%D8%B3%E2%80%8C%D8%AC%D9%85%D9%87%D9%88%D8%B1-%D8%B4%D8%AF";
$keywords = array("رئیس جمهور", "رئیس‌جمهور");
$linkKey = "/news/";
$resultData = [];

$newUrls = [$baseUrl];
$pUrls = [];
$baseUrl = rtrim($baseUrl, '/');

for ($i = 0; $i < LIMIT_RETRIEVE_TIMES; $i++) {
    $pPage = [];

    $pages = loadPages($newUrls);
    Output::Iecho("Crawling <b>" . count($pages) . "</b> pages . . .</br>");

    foreach ($pages as $url => $page) {

        $crawler = new \Crawler($page);
        //Add new urls and search for link keywords
        $urls = $crawler->findUrlsOfDomain($baseUrl, $linkKey);
        $newUrls = array_merge($newUrls, $urls);

        //search for keywords
        $searchResult = $crawler->searchWordInHTML($keywords);
        if ($searchResult) {
            $title = $crawler->GetTitle();
            $countWords = $crawler->CountWordInPage();
            $countImgTags = $crawler->countArticleBodyTags('img');
            $resultData[] = array('Title' => $title, 'Link' => $url, 'Count of image' => $countImgTags, 'Count of words' => $countWords);
        }

        //add url to processed urls
        $pUrls[] = $url;
    }
    Output::Iecho("Crawled <b>" . count($pages) . "</b> pages.  Count of result: " . count($resultData) . "</br>");
    //remove processed urls from new urls
    $newUrls = array_unique(array_diff($newUrls, $pUrls));

}



function loadPages($pageUrls, $countPage = LIMIT_PAGES_PROCESSING)
{


    $webClient = new HTTPClient();
    $slicedUrls = array_slice($pageUrls, 0, $countPage);

    Output::Iecho("Loading <b>" . count($slicedUrls) . "</b> pages . . .</br>");
    $allPages = $webClient->multiGet($slicedUrls);
    Output::Iecho("Loaded <b>" . count($slicedUrls) . "</b> pages.</br>");

    return $allPages;
}

