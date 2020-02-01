<?php

/**
 * Check if valid json format 
 * @author Sandip Baikare
 * @since 31-01-2020
 * @module google_finance
 */
function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

/**
 * Get the Google Finance market data 
 * @author Sandip Baikare
 * @since 31-01-2020
 */
function get_google_finance_data(){
    //include_once('../wordpress/wp-load.php');
    $url = 'http://www.google.com/async/finance_wholepage_price_updates?ei=sRU1Xv-SMsHt9QP7uZ_wCw&yv=3&async=mids:%2Fm%2F046k_p%7C%2Fm%2F04t5sp%7C%2Fg%2F1hbvn54mt%7C%2Fg%2F1dv1hhgx%7C%2Fg%2F1dv294zm%7C%2Fm%2F016yss%7C%2Fm%2F02853rl%7C%2Fm%2F04zvfw%7C%2Fm%2F0877z%7C%2Fm%2F02hl6w%7C%2Fm%2F04ww1p,currencies:%2Fm%2F02l6h%2B%2Fm%2F09nqf%7C%2Fm%2F09nqf%2B%2Fm%2F088n7%7C%2Fm%2F01nv4h%2B%2Fm%2F09nqf%7C%2Fm%2F09nqf%2B%2Fm%2F0ptk_%7C%2Fm%2F09nqf%2B%2Fm%2F02nb4kq%7C%2Fm%2F09nqf%2B%2Fm%2F0hn4_%7C%2Fm%2F0kz1h%2B%2Fm%2F09nqf,_fmt:json';

    $response = array('status'=> false, 'data'=> '');
    // cURL initilization
    $ch = curl_init();
    
    curl_setopt($ch,CURLOPT_URL,$url );
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 

    // Execute the cURL
    $data = curl_exec($ch);
    // Check if responce is false
    if ($data === FALSE) {
        $response = array( 'status' => false, 'message' => "Curl failed: " . curL_error($ch) );
        return $response;
    }
    // Close cURL connection
    curl_close($ch);
    //var_dump($data);

    // Check if it is valid json data returns.
    // Because with this API I was getting some of the wired characters at the very first 
    if( !isJson($data)  ){
        // If Json has those characyers Remove that, In this Case I have 4 extra characters 
        $data = substr($data, 4);
    }
    $data = json_decode($data, true);
    $result = $data['PriceUpdate']['entities'];
    return $result;
}
//print_r(get_google_finance_data());

function get_financial_entity(){
    $financial_entity = array();
    $market_data = get_google_finance_data();
    if(count($market_data) > 0){
        foreach($market_data as $key => $stock ){
            //echo isset($stock['financial_entity']['common_entity_data']);
            
            if(isset($stock['financial_entity']) && isset($stock['financial_entity']['common_entity_data']) ){
                $entity = $stock['financial_entity'];
                $market = new stdClass();
                $market->symbol         = $entity['common_entity_data']['symbol']; 
                $market->name           = $entity['common_entity_data']['name']; 
                $market->value_change   = $entity['common_entity_data']['value_change']; 
                $market->percent_change = $entity['common_entity_data']['percent_change']; 
                $market->change         = $entity['common_entity_data']['change']; 
                $market->exchange       = $entity['exchange']; 
                $market->currency_code  = isset($entity['currency_code']) ? $entity['currency_code'] : ''; 
                $market->last_value     = $entity['common_entity_data']['last_value']; 
                $market->type           = $stock['financial_entity']['type']; 
                $market->last_updated_time = $entity['common_entity_data']['last_updated_time']; 
                $financial_entity[] = $market;
            }
            
        }
    }
    return $financial_entity;
}