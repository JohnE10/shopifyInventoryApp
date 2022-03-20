<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use log;
use App\Models;
use App\Models\Product;

class ProductController extends Controller
{
    
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

    // Get Item from inventory file and store it in DB
    public function store(){

        //Get item Id from POST request
        $itemId = request('itemId');
        $supplier = request('supplier');

        if ($supplier == 'CWR') {
            $inventFile = 'cwrCSVFile.csv'; // Inventory file name for CWR                                           
            $searchCol = 'CWR Part Number'; // for now, hard code search column in
                                            //in the future, it'll come from the post request 
        } elseif($supplier == 'TWH') {
            $inventFile = 'twHouseCSVFile.csv';  // Inventory file name for TWH    
            $searchCol = 'itemcode'; // for now, hard code search column in
                                     //in the future, it'll come from the post request   
        }

        $identifer = $itemId; // Inventory Item to search for

        // Remove spaces and dots, otherwise a MySQL database error is thrown
        $searchCol = str_replace(' ', '_', $searchCol);
        $searchCol = str_replace('.','', $searchCol);

        try {
            // Get item data from inventroy file
            $itemData = itemData($inventFile);

            // // if wrong item id entered, prompt user to enter valid item id
            // if(!isset($itemData)) {
            //     $errors[] = "The item id you entered is not valid. Enter a valid item id.";
            //     return view('/welcome', ['errors' => $errors]);
            //     exit;
            // }

            $arr = $itemData[0];
            $headers = $itemData[1];

            //Replace spaces with underscores and dot's with nothing in all of the headers      
            $count = count($arr);
            for ($i=0; $i < $count; $i++){
                foreach($arr[$i] as $key => $value) {
                    $newKey = str_replace(' ', '_', $key);
                    $newKey = str_replace('.','', $newKey);
                    $arr[$i][$newKey] = $arr[$i][$key];        
                }
            }

            $headers = str_replace(' ', '_', $headers);
            $headers = str_replace('.','', $headers);

            // Instantiate Model
            $Product = new Product();
            
            // Insert into Model
            $check = array();
            foreach($arr as $e){
                if ($e[$searchCol] == $identifer){
                    $check[] = $identifer;
                    foreach($headers as $header){
                        $Product->$header = $e[$header];              
                    }
                    $Product->save();                         
                }                      
            }
            
        } catch(\Exception $e) {
            $errors[] = $e->getMessage();
            return redirect('/')->with('errors', $errors);
        }  
        
        if (count($check) > 0) {
            return redirect('/')->with('success', 'Product added to database.');
        } else {
            $errors[] = "The item id you entered is not valid. Enter a valid item id.";
            return redirect('/')->with('errors', $errors);
        }
        
        // return redirect('/')->with('success', 'Product added to database.');
    }
    
    // List item on shopift store
    public function create() {
        // Get product identifier and supplier name from post request
        $itemId = request('itemId');
        $supplier = request('supplier');

        if ($supplier == 'CWR') {
            $inventFile = 'cwrCSVFile.csv'; // Inventory file name for CWR                                             
            $searchCol = 'CWR Part Number'; // for now, hard code search column in
                                            //in the future, it'll come from the post request 
        } elseif($supplier == 'TWH') {
            $inventFile = 'twHouseCSVFile.csv';  // Inventory file name for TWH 
            $searchCol = 'itemcode'; // for now, hard code search column in
                                     //in the future, it'll come from the post request   
        }

        // Set Variables for shopify request
        $shop = env('APP_SHOP');
        $token = env('APP_TOKEN');
        $query = array(
        "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );

        try {
            // Build the product object
            $createData = productObj($inventFile, $searchCol, $itemId);

            // Run API call to create the product
            $createProduct = $this->shopify_call($token, $shop, "/admin/products.json", $createData, 'POST');
 
            // Convert JSON to array
            $product = json_decode($createProduct['response'], TRUE);

            //Prompt user to enter valid item id
            if(!isset($product) or array_key_exists('errors', $product)) {
                $errors[] = "The item id you entered is not valid. Enter a valid item id.";
                return view('/welcome', ['errors' => $errors]);
                exit;
            }

            $productId = $product['product']['id']; // Get the shopify product ID from the response
            $image = $createData['product']['images']['src']; // Get the shopify product ID from the response

            // Image is not uploaded initially... Use new product's ID to upload image
            $imageData = array(
                "id" => $productId,
                "image" => array("src" => $image)
            );
        
            // API call to upload image
            $createImage = $this->shopify_call($token, $shop, "/admin/products/" . $productId . "/images.json", $imageData, 'POST');     

            // build array for supplier inventory item id
            $metafieldData = array("metafield"=> array("namespace" => "inventory", "key" => "supplierItemId", 
                            "value" => $itemId, "value_type" => "string"));

            // API call to upload supplier inventory item id as metafield
            $createMetafield = $this->shopify_call($token, $shop, "/admin/products/" . $productId . "/metafields.json", $metafieldData, 'POST');

        } catch(\Exception $e) {
            $errors[] = $e->getMessage();
            return view('/welcome', ['errors' => $errors]);
        }
        return redirect('/')->with('success', 'Product added.');
    }

    // Update item on shopift store
    public function update() {

        // Get product identifier and supplier name from post request
        $productId = request('itemId');
        $supplier = request('supplier');
        $inventFile = '';
        $searchCol = '';

        if ($supplier == 'CWR') {
            $inventFile = 'cwrCSVFile.csv'; // Inventory file name for CWR                                          
            $searchCol = 'CWR Part Number'; // for now, hard code search column in
                                            //in the future, it'll come from the post request 
        } elseif($supplier == 'TWH') {
            $inventFile = 'twHouseCSVFile.csv'; // Inventory file name for TWH 
            $searchCol = 'itemcode'; // for now, hard code search column in
                                     //in the future, it'll come from the post request   
        }

        // Set Variables for shopify request
        $shop = env('APP_SHOP');
        $token = env('APP_TOKEN');
        $query = array(
        "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );

        try {
            // Retrieve product metadata in order to get the supplier's item id
            $getMetafields = $this->shopify_call($token, $shop, "/admin/products/" . $productId . 
                            "/metafields.json", array(), 'GET');

            $metafields = json_decode($getMetafields['response'], TRUE);

            // Prompt user to enter valid item id
            if(!isset($metafields) or array_key_exists('errors', $metafields)) {
                $errors[] = "The item id you entered is not valid. Enter a valid item id.";
                return view('/welcome', ['errors' => $errors]);
                exit;
            }

            // Get the supplier's item id
            $itemId = $metafields['metafields'][0]['value'];

            // Build the product object
            $modifyData = productObj($inventFile, $searchCol, $itemId);
            $image = $modifyData['product']['images']['src'];

            // Run API call to modify the product
            $modifyProduct = $this->shopify_call($token, $shop, "/admin/products/" . $productId . ".json", 
                    $modifyData, 'PUT');

            // Convert JSON to array
            $product = json_decode($modifyProduct['response'], TRUE);

            // If there's an existing image, get image id
            if(isset($product['product']['images'][0]['id'])){
            $imageId = $product['product']['images'][0]['id']; 

            // Delete current product image
            $deleteImage = $this->shopify_call($token, $shop, "/admin/products/" . $productId . 
            "/images/" . $imageId . ".json", array(), 'DELETE');
            }

            // Data for new image to be uploaded
            $imageData = array('image' => array(
            "id" => $productId,
            "src" => $image
            ));

            // API call to post new image
            $replaceImage = shopify_call($token, $shop, "/admin/products/" . 
                $productId . "/images.json", $imageData, 'POST');

            // $imageResponse = json_decode($replaceImage['response'], TRUE);
        } catch(\Exception $e) {
            $errors[] = $e->getMessage();
            return view('/welcome', ['errors' => $errors]);
        }
 
        return redirect('/')->with('success', 'Product updated.');
    } 

    // Delete item from shopift store
    public function delete() {
        //Get itemId from URL
        $itemId = request('itemId');

        // Set Variables for shopify request
        $shop = env('APP_SHOP');
        $token = env('APP_TOKEN');
        $query = array(
        "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );

        // Run API call to delete the product

        $product = $this->shopify_call($token, $shop, "/admin/products/" . $itemId . ".json", array(), 'DELETE');
        $product = json_decode($product['response'], TRUE);

        if(isset($product) and !array_key_exists('errors', $product)) {

            return redirect('/')->with('success', 'Product deleted.');

        } else { // Show wrong item id error
            $errors[] = 'The item id you entered is not valid. Enter a valid item id.';
            return redirect('/')->with('errors', $errors);
        } 
     }

        // Display single item
        public function show() {
            // Set variables for our request
            $shop = env('APP_SHOP');
            $token = env('APP_TOKEN');
            $query = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
            );
    
            // Get item id from POST Request
            $itemId = request('id');
    
            // Run API call to fetch product
            Try{
                $products = $this->shopify_call($token, $shop, "/admin/products/" . $itemId . ".json", array(), 'GET');


            // Convert product JSON to an array
            $product = json_decode($products['response'], TRUE);

            // Parse product and fetch pertinent info
                if(isset($product) and !array_key_exists('errors', $product)) {
                    $productId = $product['product']['id'];
                    $handle = $product['product']['handle'];
                    $productUrl = 'https://' . $shop . '.myshopify.com/' . $handle;
                    $title = $product['product']['title'];
    
                    return view('/show', ['product_id' => $productId, 'product_url' => $productUrl, 
                            'title' => $title, 'errors'=> 0]);
     
                } else { // Show wrong item id error
                     return view('/show', ['errors'=> 1]);
                }   
            // Show any exception
            } catch(\Exception $e) {
                $errors[] = $e->getMessage();
                return view('/welcome', ['errors' => $errors]);
            }              
        }
    
    // Get all items in store display
    public function index() {
        // Set variables for our request
        $shop = env('APP_SHOP');
        $token = env('APP_TOKEN');
        $limit = 250;
        $query = array(
	    "Content-type" => "application/json", "limit" => $limit // Tell Shopify that we're expecting a response in JSON format
        );

        // Run API call to get products
        try{
            $products = $this->shopify_call($token, $shop, "/admin/products.json", array(), 'GET');
        } catch(\Exception $e) {
            $errors[] = $e->getMessage();
            return view('/welcome', ['errors' => $errors]);
        }
        

        // Convert product JSON to an array
        $products = json_decode($products['response'], TRUE);

        // Show error If products is null, then exit script
        if(!isset($products['products'])){
            $errors[] = "There are no products to display.";
            return view('/welcome', ['errors' => $errors]);
            exit;
        }

        // product count
        $x = count($products['products']);

        return view('/index', ['products' => $products, 'x' => $x, 'shop' => $shop]);
        
    }

}


