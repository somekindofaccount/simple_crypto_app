<?php

namespace App\Http\Coinmarket;

class CoinMarketLib
{
    private $endpoint = "https://pro-api.coinmarketcap.com/v1/";
    private $api_key =  "4eff43a7-aae9-4fe6-873d-df5abde2513b";

    public function __construct($start=1, $limit=5000, $convert='USD'){
        $this->start = $start;
        $this->limit = $limit;
        $this->convert = $convert;
    }
    
    public function cryptocurrency_listings_latest(){

        $parameters = [
            'start' => $this->start,
            'limit' => $this->limit,
            'convert' => $this->convert
        ];
        
        $parameters =http_build_query($parameters);
        
        
        $this->endpoint = $this->endpoint . str_replace('_','/',__FUNCTION__) . '?' . $parameters; 


        $data = $this->curlData(
            $this->endpoint,
            NULL,
            [
                'X-CMC_PRO_API_KEY' => $this->api_key,
                'Accept' => 'Application/json',
            ]
        );
        return json_decode($data);
        
    }

   // This Should not be here
   private function  curlData($url, $post_fields = null, $headers = null) {
       
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($post_fields && !empty($post_fields)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        }
        if ($headers && !empty($headers)) {
            $_headers = [];
            foreach($headers as $k=>$v){
                $_headers[] = "$k:$v";
            }
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, $_headers);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $data;
    }

   
}
