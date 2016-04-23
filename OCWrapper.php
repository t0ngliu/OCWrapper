<?php

class OCWrapper
{
    private $OC_APP_ID = null;

    private $OC_API_KEY = null;

    private $OC_options = array();

    private $HTTP_PREFIX = 'https://api.octranspo1.com/v1.2/';

    public function __construct($data = null)
    {
        try {
            if (is_array($data)) {
                foreach ($data as $key => $value) {
                    $this->OC_options = $value;
                }
            } else {
                return false;
            }

            if (isset($OC_options['appid']) && isset($OC_options['apikey'])) {
                $this->OC_APP_ID  = $OC_options['appid'];
                $this->OC_API_KEY = $OC_options['apikey'];
            } else {
                return false;
            }

            if (isset($OC_options['http'])) {
                $this->HTTP_PREFIX = $OC_options['http'];
            }
        }
        catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    public function GetRouteSummaryForStop($data = null, $options = null)
    {
        if (is_null($data)) {
            return false;
        }
        $method = 'GetRouteSummaryForStop';
        $req_data = array(
            'stopNo' => $data
        );
        return $this->retrieve_curl_info($method, $req_data, $options);
    }

    public function GetNextTripsForStop($data = null, $options = null)
    {
        if (!is_null($data)) {
            return false;
        }
        $method = 'GetNextTripsForStop';
        $req_data = $data;
        return $this->retrieve_curl_info($method, $req_data, $options);
    }

    public function GetNextTripsForStopAllRoutes($data = null, $options = null)
    {
        if (is_null($data)) {
            return false;
        }
        $method = 'GetNextTripsForStopAllRoutes';
        $req_data = array(
            'stopNo' => $data
        );
        return $this->retrieve_curl_info($method, $req_data, $options);
    }

    public function GTFS($data = null, $options = null)
    {
        if (is_null($data)) {
            return false;
        }
        $method = 'GTFS';
        $req_data = $data;
        return $this->retrieve_curl_info($method, $req_data, $options);
    }

    private function retrieve_curl_info($method, $data, $options)
    {
        if (is_null($data)) {
            return false;
        }

        $format = 'json';
        if (isset($options['format'])) {
            $format = preg_match("/^xml$/", $options['format']) ? 'xml' : null;
        }
        
        $return_arr = true;
        if (isset($options['returnArray'])) {
            $return_arr = boolval($options['returnArray']);
        }

        $http_arr = array(
            'GetRouteSummaryForStop' => $this->HTTP_PREFIX . 'GetRouteSummaryForStop',
            'GetNextTripsForStop' => $this->HTTP_PREFIX . 'GetNextTripsForStop',
            'GetNextTripsForStopAllRoutes' => $this->HTTP_PREFIX . 'GetNextTripsForStopAllRoutes',
            'GTFS' => $this->HTTP_PREFIX . 'Gtfs'
        );

        if (!array_key_exists($method, $http_arr)) {
            return false;
        }

        $credentials = array(
            'appID' => $this->OC_APP_ID,
            'apiKey' => $this->OC_API_KEY,
            'format' => $format
        );
        $post_data = array_merge($credentials, $data);
        $ch = curl_init();
        curl_setopt_array($ch, array(
            // CURLOPT_CAINFO => OC_SSL_CAINFO,
            CURLOPT_URL => $http[$method],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $post_data
        ));
        $output = curl_exec($ch);
        curl_close($ch);

        $result = null;
        if ($return_arr) {
            switch ($format) {
                case 'json':
                    $result = json_decode($output, true);
                    break;
                case 'xml':
                    $xml    = simplexml_load_string($output);
                    $json   = json_encode($xml);
                    $result = json_decode($json, true);
                    break;
                default:
                    return false;
            }
        }

        $result = $output;
        return $result;
    }
}