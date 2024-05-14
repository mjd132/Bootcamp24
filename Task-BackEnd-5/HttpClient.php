<?php
class HTTPClient
{
    const TIMEOUT = 30;
    const LOAD_WAIT_TIME = 300;

    public function multiGet(array $urls)
    {
        $curlHandlers = [];
        $multiHandler = curl_multi_init();
        foreach ($urls as $url) {
            $ch = curl_init($url);

            $curlHandlers[$url] = $ch;
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::TIMEOUT);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FAILONERROR, false);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            // $streamVerboseHandle = fopen('php://temp', 'w+');
            // curl_setopt($currentHandler, CURLOPT_STDERR, $streamVerboseHandle);

            curl_multi_add_handle($multiHandler, $ch);
        }
        $isRun = null;
        do {
            curl_multi_exec($multiHandler, $isRun);
            usleep(self::LOAD_WAIT_TIME);
        } while ($isRun);

        $results = [];

        foreach ($urls as $url) {
            $ch = $curlHandlers[$url];
            $results[$url] = curl_multi_getcontent($ch);
            curl_multi_remove_handle($multiHandler, $ch);
        }


        curl_multi_close($multiHandler);

        // rewind($streamVerboseHandle);
        // $verboseLog = stream_get_contents($streamVerboseHandle);
        // echo "cUrl verbose information:\n",
        //     "<pre>", htmlspecialchars($verboseLog), "</pre>\n";
        return $results;
    }

}
