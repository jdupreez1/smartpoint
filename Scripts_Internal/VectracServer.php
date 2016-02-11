<?php
 
require_once '../Core/init.php';

$_db = db::getInstance();
$date = new DateTime();
        

        
 
//Reduce errors
error_reporting(~E_WARNING);
 $debug = true;
function e($str) {
    global $debug;
    if($debug) { echo($str . "\n"); }
}


$server = '127.0.0.1';
$unitPort = 44602;
 
$rxsocket = connectRemoteDataSocket($server,$unitPort);



//Communication loop
$buf = '';
$done = false;

do {

    $chunk = socket_read($rxsocket, 512);
    if($chunk === false) {
        $error = socket_last_error($rxsocket);
        if($error != 11 && $error != 115) {
            e(socket_strerror($error));
            $done = true;
        }
        break;
    } elseif($chunk == '') {
        $done = true;
        break;
    } else { 
        $buf .= $chunk;
        e($buf);
       // logUnitData($buf);
        $buf = '';

        
        //var_dump($buf);
    }

   // echo 'Enter a message to send : ';
    //$input = fgets(STDIN);


    /* if( ! socket_send($rxsocket, $input , strlen($input) , 0 ))
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
         
        die("Could not send data: [$errorcode] $errormsg \n");
    }*/
} while(true);






function connectRemoteDataSocket($server,$port){


    if(!($rxsocket = socket_create(AF_INET, SOCK_STREAM, 0)))
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
         
        die("Couldn't create socket: [$errorcode] $errormsg \n");
    }
     
      
     



    if(!socket_connect($rxsocket, $server, $port)){
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
         
        die("Couldn't connect socket: [$errorcode] $errormsg \n");
    }

    echo "Socket connected on port $port \n";
     
    //if(socket_send($rxsocket,"register",10,0) === false){
    //    die("Couldn't send socket: \n");
    //}

     return $rxsocket;
    }

function logUnitData($data){
     $obj = json_decode($data,true);
    // var_dump($obj["Unit_Id"]);
    $fields = array(
        'Unit_Id' => $obj['Unit_Id'],
        'Lat' => $obj['Lat'],
        'Lon' => $obj['Lon'],
        'Speed' => $obj['Speed']
        //'Time' => $date->getTimestamp()
    );

//var_dump($fields);
    if(!$GLOBALS['_db']->insert('Unit_Position',$fields))
    {
       // throw new Exception('There was a problem saving data.');
        e('There was a problem saving data.');
    }  

    return;
}

?>