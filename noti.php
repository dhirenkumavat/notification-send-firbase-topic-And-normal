function notification($Device_Token,$title,$send_message){
  define('API_ACCESS_KEY', 'AIzaSyBd2IQhnEfsR0pdWr62w3C7XF2aI04CQ90');
$data = array("to" =>$Device_Token,
              "data" => array( "title" => $title, "body" => $send_message,"icon" => "ic_notification","sound" => "default"));  

$data_string = json_encode($data);
$headers = array
(
     'Authorization: key=' . API_ACCESS_KEY,
     'Content-Type: application/json'
);
$ch = curl_init();  
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );                                                                  
curl_setopt( $ch,CURLOPT_POST, true );  
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);                                                                  
$result = curl_exec($ch);
curl_close ($ch);
return notification();
}