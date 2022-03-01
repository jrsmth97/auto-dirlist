<?php

class fetch {
    public static function get($url) {
        return self::curl($url, 'GET');
    }

    public static function post($url, $data) {
        return self::curl($url, 'POST', $data);
    }

    public static function put($url, $data) {
        return self::curl($url, 'PUT', $data);
    }

    public static function patch($url, $data) {
        return self::curl($url, 'PATCH', $data);
    }

    public static function delete($url, $data) {
        return self::curl($url, 'DELETE', $data);
    }

    // private static function get_contents($url, $method, $data = []) {
    //     $postdata = http_build_query($data);
    //     $opts = array('http' =>
    //         array(
    //             'method'  => $method,
    //             'header'  => 'Content-type: application/x-www-form-urlencoded',
    //             'content' => $postdata
    //         )
    //     );

    //     $context  = stream_context_create($opts);
    //     return file_get_contents($url, false, $context);  
    // }

    private static function curl($url, $method, $data = null) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($method != 'GET') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        curl_getinfo($ch, CURLINFO_HTTP_CODE);
   
        return curl_exec($ch);

        curl_close($ch);  
    }

    public static function httpCode($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        return curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);  
    }
}
