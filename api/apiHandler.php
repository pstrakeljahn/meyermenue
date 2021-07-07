<?php

namespace ApiHandler;

class ApiHandlerClass
{
    const APPLICATION_SERVER = 'https://shop.meyer-menue.de/api/v1/';
    const ARR_CURL_CONFIG = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    ];

    /**
     * @deprecated For the future. Currently every request is hardcoded!
     */

    public static function get(string $uri){

        $arrHeaderModify = [
            CURLOPT_URL => self::APPLICATION_SERVER . $uri,
        ];
        $arrCurlConfig = self::ARR_CURL_CONFIG + $arrHeaderModify;
        $curl = curl_init();
        curl_setopt_array($curl, $arrCurlConfig);
        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    /**
     * The payload array should contain the parameters to be passed in the form key => value
     * @deprecated For the future. Currently every request is hardcoded!
     */

    public static function post(string $uri = null, Array $payload, string $token = null) : string
    {
        $payload = json_encode($payload);

        if(isset($token)){
            $arrHeaderModify = [
                CURLOPT_URL => self::APPLICATION_SERVER . $uri,
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => [
                    'Content-Type: text/plain',
                ],
                CURLOPT_HTTPHEADER => array(
                    `access-token: ${$token}`
                  ),
            ];
        } else {
            $arrHeaderModify = [
                CURLOPT_URL => self::APPLICATION_SERVER . $uri,
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => [
                    'Content-Type: text/plain',
                ],
            ];
        }

        $arrCurlConfig = array_merge(self::ARR_CURL_CONFIG, $arrHeaderModify);
        $curl = curl_init();
        curl_setopt_array($curl, $arrCurlConfig);
        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    
    public static function login($payload){
        $payload = json_encode($payload);

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://shop.meyer-menue.de/api/v1/auth/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_HEADER => 1,
        CURLOPT_NOBODY => 0,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$payload,
        CURLOPT_HTTPHEADER => array(
            'authority: shop.meyer-menue.de',
            'sec-ch-ua: " Not;A Brand";v="99", "Google Chrome";v="91", "Chromium";v="91"',
            'accept: application/json, text/plain, */*',
            'sec-ch-ua-mobile: ?1',
            'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Mobile Safari/537.36',
            'content-type: application/json;charset=UTF-8',
            'origin: https://shop.meyer-menue.de',
            'sec-fetch-site: same-origin',
            'sec-fetch-mode: cors',
            'sec-fetch-dest: empty',
            'referer: https://shop.meyer-menue.de/',
            'accept-language: de-DE,de;q=0.9,en-US;q=0.8,en;q=0.7',
            'cookie: PHPSESSID=q2im71al8uruddfme85bh9t047; _ga=GA1.2.1586222032.1625262162; __utma=169593277.1586222032.1625262162.1625422537.1625422537.1; __utmc=169593277; __utmz=169593277.1625422537.1.1.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); _gid=GA1.2.951263465.1625422539; _gat=1; PHPSESSID=gkl6cqc7a4rj0gerk1nunalp70'
        ),
        ));

        $response = curl_exec($curl);

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        $pattern = '/[\n\r].*Access-Token:\s*([^\n\r]*)/i';

        $token = null;
        preg_match($pattern, $header, $token);
        $_SESSION['token'] = $token[1];

        curl_close($curl);
        return $body;
    }

    public static function logout($token){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://shop.meyer-menue.de/api/v1/auth/logout',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'authority: shop.meyer-menue.de',
            'content-length: 0',
            'sec-ch-ua: " Not;A Brand";v="99", "Google Chrome";v="91", "Chromium";v="91"',
            'accept: application/json, text/plain, */*',
            'access-token: '. $token,
            'sec-ch-ua-mobile: ?1',
            'user-agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Mobile Safari/537.36',
            'origin: https://shop.meyer-menue.de',
            'sec-fetch-site: same-origin',
            'sec-fetch-mode: cors',
            'sec-fetch-dest: empty',
            'referer: https://shop.meyer-menue.de/',
            'accept-language: de-DE,de;q=0.9,en-US;q=0.8,en;q=0.7',
            'cookie: PHPSESSID=q2im71al8uruddfme85bh9t047; _ga=GA1.2.1586222032.1625262162; __utma=169593277.1586222032.1625262162.1625422537.1625422537.1; __utmc=169593277; __utmz=169593277.1625422537.1.1.utmcsr=google|utmccn=(organic)|utmcmd=organic|utmctr=(not%20provided); _gid=GA1.2.951263465.1625422539; PHPSESSID=gkl6cqc7a4rj0gerk1nunalp70'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        if($response === 'ok'){
            return true;
        }
        return false;
    }

    public static function getFood(int $year, int $week, string $token): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://shop.meyer-menue.de/api/v1/menue/' . $_SESSION['UserData']['customerId'] . '/year/' . $year . '/week/' . $week,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'access-token: ' . $token,
            'Cookie: PHPSESSID=gkl6cqc7a4rj0gerk1nunalp70'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public static function getInvoices(string $token){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://shop.meyer-menue.de/api/v1/invoices/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'authority: shop.meyer-menue.de',
            'accept: application/json, text/plain, */*',
            'access-token: ' . $token,
            'Cookie: PHPSESSID=gkl6cqc7a4rj0gerk1nunalp70'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }
}
