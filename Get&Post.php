
<?php 
//Specify for utf8
header('Content-Type: text/html; charset=utf-8');





// GET REQUEST

$url = "https://www.google.com";

$result = file_get_contents($url);

//echo htmlspecialchars($result);
echo "GET successful.";




// POST REQUEST 

$postdata = http_build_query(
    array(
        'name' => 'Robert',
        'id' => '1'
    )
);
$opts = array('http' =>
    array(
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);
$context = stream_context_create($opts);
$result = file_get_contents('https://hookb.in/Oe0GaYXEqMCqOdYYOyxX', false, $context);
print_r($result);
echo "<br/> POST Successful.";








// CURL OPTION :

/*
//open connection
$ch = curl_init();
//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
//curl_setopt($ch,CURLOPT_POST, true);
//curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_HTTPGET, $url);
//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
//execute post
$result = curl_exec($ch);
*/

//$result = strip_tags($result);
//$result = utf8_decode($result);
//echo htmlspecialchars($result);








?>








