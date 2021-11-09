<?php
echo "<h1>Processing........</h1>";
ini_set('max_execution_time', 0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function debug($arr, $exit = true)
{
     print "<pre>";
     print_r($arr);
     print "</pre>";
     if($exit)
      exit;
}

$servername = "localhost";
$username = "u338287402_pcr";
$password = "o6S+gLoxy";
$dbname = "u338287402_pcr";

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "pcr";

############# Create connection #############
$conn = new mysqli($servername, $username, $password, $dbname);

############# Check connection #############
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "select * from patient_tests where api_sent = '3'";
$query = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($query)){
	$sql2 = "select * from tests where id = '".$row['test_id']."'";
    $query2 = mysqli_query($conn, $sql2);
    $result = mysqli_fetch_array($query2);
    if(!empty($result) && $result['is_api']==1){
        api_request($row['patient_id']);
    }
}

function api_request($patient_id = 0)
{
    global $conn;

    $sql = "select * from patients where id = '".$patient_id."'";
    $patient = mysqli_query($conn, $sql);
    $patient = mysqli_fetch_array($patient);
    if(empty($patient['id'])){
        return false;
    }

    $sql = "select * from passengers where patient_id = '".$patient_id."'";
    $passenger = mysqli_query($conn, $sql);
    $passenger = mysqli_fetch_array($passenger);
    if(empty($passenger['id'])){
        return false;
    }    

    $curl = curl_init();
    $user_name = "rtladmin";
    $API_Secret_Key = "a19a0323fd1f94992bdb8b3822da41746qmqv0PzLnTKEY";
    $parameters = array(
        "pcode" => "pat-".$patient['id'], 
        "pname" => $patient['name'],
        "ppass" => $passenger['passport_no'],
        "pcnic" => $patient['cnic'], 
        "sampt" => $patient['created_at'],
        "pres" => "", 
        "rept" => "",
        "tname" => "COVID"
    );
    $url = "https://app.arham.services/api/v1/pushdata?";
    foreach($parameters as $key=>$value){
        $url .= urlencode($key)."=".urlencode($value)."&";
    }
    $url = substr($url, 0, -1);
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
        "Authorization: Basic ".base64_encode($user_name.":".$API_Secret_Key)
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response_decoded = json_decode($response);
    if(!empty($response_decoded->code) && $response_decoded->code == 1){

        $sql = "select * from patient_tests where patient_id = '".$patient_id."' AND type = 2 AND test_id = 760 order by id DESC";
        $result = mysqli_query($conn, $sql);
        $result = mysqli_fetch_array($result);
        if(!empty($result['id'])){
            $id = $result['id'];
            $sql = "UPDATE patient_tests SET api_sent = 1 WHERE id = '".$id."'";
            mysqli_query($conn, $sql);
            return true;
        }
    }
    return false;
}

echo "<h1>Done</h1>";
echo "<hr>";

?>