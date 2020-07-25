<?php
if(isset($_POST['submit'])){
    include("config.php");
    include("curl.php");
    include("customer.php");


    $customerId = uniqid ();

    /**
     * Basic information filled by the user within a form
     */

    $params = array(
        "first_name"=>$_POST['first_name'],
        "last_name"=>$_POST['last_name'],
        "mobile_country_code"=>$_POST['mobile_country_code'],
        "mobile_number"=>$_POST['mobile_number'],
        "email_address"=>$_POST['email_address']
    );

    /**
     * Get Customer
     */
    $customer = create_customer($customerId,$params);
    

    /**
     * Process for an Order
     */


    $productId = 1;
    $description = "Admission fee";
    $orderId = uniqid ();
    $params = array (
        "order_id"=>$orderId,
        "amount"=>$_POST['amount'],
        "currency"=>$_POST['currency'],
        "customer_id"=>$customer['id'],
        "product_id"=>$productId,
        "return_url"=>RETURN_URL,
        "description"=>$description
    );

    $order = curl_call("/order/create", $params,"POST");
    if($order['status']=='CREATED'){
        //Redirect to Axis Bank
        header("location:".$order['payment_links']['web']);
        exit();
    }
}
?>
<style>

</style>
<form method="POST">
<h3>CSMU Admission form</h3>
<hr/>
<table>
    <tbody>
        <tr>
            <td>First Name</td>
            <td><input name="first_name" required/></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input name="last_name" required/></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>
                <select name="mobile_country_code" required>
                    <option value="1">+1</option>   
                    <option selected value="91">+91</option>
                </select>
                <input name="mobile_number"/>
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input name="email_address" required/></td>
        </tr>
        <tr>
            <td>Amount</td>
            <td>
                <select name="currency" required>
                    <option value="USD">USD</option>   
                    <option selected value="INR">INR</option>
                </select>
                <input name="amount" type="number" required min="1"/>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input name="submit" type="submit"/></td>
        </tr>
    </tbody>
</table>
</form>