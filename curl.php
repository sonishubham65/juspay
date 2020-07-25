<?php
function get_body_from_curl_response($result){
    list($headers,$body) = explode("\r\n\r\n", $result, 2);
    return json_decode($body,true);
}
function curl_call($path,$params,$method){
    
    $url = BASE_URL.$path;
    $curlObject = curl_init ();
    curl_setopt ( $curlObject, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $curlObject, CURLOPT_HEADER, true );
    curl_setopt ( $curlObject, CURLOPT_NOBODY, false );
    curl_setopt ( $curlObject, CURLOPT_USERPWD, APIKEY );
    curl_setopt ( $curlObject, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
    curl_setopt ( $curlObject, CURLOPT_USERAGENT, "v1.0.4" );
    curl_setopt ( $curlObject, CURLOPT_TIMEOUT, GetReadTimeout );
    curl_setopt ( $curlObject, CURLOPT_CONNECTTIMEOUT, ConnectTimeout );

    $headers = array('version: ' . "2018-10-25");

    array_push( $headers, 'Content-Type: application/x-www-form-urlencoded' );
    curl_setopt ( $curlObject, CURLOPT_HTTPHEADER, $headers);
    curl_setopt ( $curlObject, CURLOPT_POST, 1 );
    if ($params == null) {
        curl_setopt ( $curlObject, CURLOPT_POSTFIELDSIZE, 0 );
    } else {
        curl_setopt ( $curlObject, CURLOPT_POSTFIELDS, http_build_query($params) );
    }
    curl_setopt ( $curlObject, CURLOPT_URL, $url );
    $result = curl_exec ( $curlObject );
    $result = get_body_from_curl_response($result);
    return $result;
}