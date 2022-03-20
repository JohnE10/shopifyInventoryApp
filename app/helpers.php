<?php

// Make shopify call
function shopify_call($token, $shop, $api_endpoint, $query = array(), $method = 'GET', $request_headers = array()) {
    
    // Build URL
    $url = "https://" . $shop . ".myshopify.com" . $api_endpoint;
    if (!is_null($query) && in_array($method, array('GET', 	'DELETE'))) $url = $url . "?" . http_build_query($query);

    // Configure cURL
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 3);
    // curl_setopt($curl, CURLOPT_SSLVERSION, 3);
    curl_setopt($curl, CURLOPT_USERAGENT, 'My New Shopify App v.1');
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

    // Setup headers
    $request_headers[] = "";
    if (!is_null($token)) $request_headers[] = "X-Shopify-Access-Token: " . $token;
    curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);

    if ($method != 'GET' && in_array($method, array('POST', 'PUT'))) {
        if (is_array($query)) $query = http_build_query($query);
        curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
    }
    
    // Send request to Shopify and capture any errors
    $response = curl_exec($curl);
    $error_number = curl_errno($curl);
    $error_message = curl_error($curl);

    // Close cURL to be nice
    curl_close($curl);

    // Return an error is cURL has a problem
    if ($error_number) {
        return $error_message;
    } else {

        // No error, return Shopify's response by parsing out the body and the headers
        $response = preg_split("/\r\n\r\n|\n\n|\r\r/", $response, 2);

        // Convert headers into an array
        $headers = array();
        $header_data = explode("\n",$response[0]);
        $headers['status'] = $header_data[0]; // Does not contain a key, have to explicitly set
        array_shift($header_data); // Remove status, we've already set it above
        foreach($header_data as $part) {
            $h = explode(":", $part);
            $headers[trim($h[0])] = trim($h[1]);
        }

        // Return headers and Shopify's response
        return array('headers' => $headers, 'response' => $response[1]);

    }
}

// Get all data from supplier's inventory file
function itemData($inventFile) {
    // $inventFile is the supplier's Inventory file

    // Make sure file exists, if not stop code
    if (!file_exists($inventFile)) {
        print('File not found.');
        exit;
    }
    
    // Open file
    $file = fopen($inventFile,'r');
    
    // Declare headers array to store the headers from the CSV inventory file
    $headers = array();

    // Only get the first row of the CSV file, this is where the headers are
    while(($row = fgetcsv($file)) !== FALSE) {
        $headers = $row;
        break;
    }
    
    // Declare inventory array and get all inventory
    $arr = array();
    
    while(($row = fgetcsv($file)) !== FALSE) {
        $arr[] = array_combine($headers, $row);
    }

    // Close open file
    fclose($file);

    return array($arr, $headers);
}

// Build the shopify product object for a particular product
function productObj($inventFile, $searchCol, $identifier){
    // $inventFile is the supplier's inventory file
    // $searchCol is the column in the inventory file that we'd like to search
    // $identifier is the identifier of the product for which we'd like to create the product object
    
    // Get all inventory from supplier's inventory file
    $itemData = itemData($inventFile);
    
    // Get inventory and inventory csv headers in separate arrays
    $arr = $itemData[0];
    $headers = $itemData[1];

    // Shopify's product object elements
    $product=array('title'=>'Title', 'body_html'=>'Full Description', 'vendor'=>'Manufacturer Name',	
    'product_type'=>'Category Name', 'tags'=>'Category Name', 'status'=>'active');
    
    $variant = array('title' => 'Default Title', 'price'=>'List Price',	'sku'=>'Manufacturer Part Number', 'barcode' => 'UPC Code',	
    'inventory_policy'=>'deny',	'compare_at_price'=>'M.R.P. Price',	'fulfillment_service'=>'manual', 
    'inventory_management'=>'shopify', 'option1'=>'Default Title', 'weight'=>'Shipping Weight', 
    'weight_unit'=>'lb', 'currency_code'=>'USD');

    $images = array('src' => 'Image (1000x1000) Url');
    
    // Populate the elements with the corresponding values
    foreach($arr as $e){
        if ($e[$searchCol] == $identifier){
            foreach($headers as $header){
                // Populate the product element of the product object
                if(in_array($header, $product)) {
                    $key = array_search($header, $product);
                    $product[$key] = $e[$header];  
                } 
                // Populate the variants element of the product object
                if(in_array($header, $variant)) {
                    $key = array_search($header, $variant);
                    $variant[$key] = $e[$header];  
                }  
                // Populate the images element of the product object
                if(in_array($header, $images)) {
                    $key = array_search($header, $images);
                    $images[$key] = $e[$header];  
                }  
            }
        }                      
    }
    
    // Assemble the product object
    $product['variant'] = $variant;
    $product['images'] = $images;
    $object = array();
    $object['product'] = $product;
    
    return $object;
}

?>