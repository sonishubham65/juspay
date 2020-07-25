<?php
function create_customer($customerId,$params){
    
    $params ['object_reference_id'] = $params ['mobile_country_code']+$params ['mobile_number'];
    $response = curl_call("/customers",$params,"POST");

    /**
     * If customer is already created in Juspay account.
     */
    if(isset($response['status']) && $response['status']=='invalid_request_error'){
        if($response['error_code']=='unique'){
            /**
             * Get that customer Id first;
             */
            $response = curl_call("/customers/".$params ['object_reference_id'],[
                "mobile_country_code"=>$params ['mobile_country_code'],
                "mobile_number"=>$params ['mobile_number']
            ],"POST");

            $customer = $response;

        }else{
            echo 'We are down for now.';
        }
    }else{
        $customer = $response;
    }

    return $customer;
}
?>