<?php
 
/*
    Simple php udp socket client
*/
 
//Reduce errors
error_reporting(~E_WARNING);
 function e($str) {
    global $debug;
    if($debug) { echo($str . "\n"); }
}
$server = 'vectronics.co.za';
$txport = 44601;
$rxport = 44602;
 
if(!($txsock = socket_create(AF_INET, SOCK_DGRAM, 0)))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Couldn't create socket: [$errorcode] $errormsg \n");
}
 
echo "Socket created \n";
 
//Communication loop
while(1)
{
    //Take some input to send
    echo 'Enter a message to send : ';
    $input2 = fgets(STDIN);
     var_dump($input2);
     $start_byte = 0x7E;
    $code = null;
    $value = null;
    $data2 = [];

    if($input2 == "0\n")   // Ack
    {
       // $packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x49,0x44,0x45,0x65,0x65,0x28,0x92];    // key 
        $code = 0x00;
        $value = 0x01;
        $data2 = null;

    }elseif ($input2 == "1\n") {  // Nack
        //$packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x50,0x44,0x45,0x65,0x65,0x84,0xB4];   // test
        $code = 0x01;
        $value = 0x02;
        $data2 = null;
    }
    elseif($input2 == "2\n")   //Ping
    {
       // $packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x49,0x44,0x45,0x65,0x65,0x28,0x92];    // key 
        $code = 0x02;
        $value = null;
        $data2 = null;

    }elseif ($input2 == "48\n") {   //Conn Request
        //$packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x50,0x44,0x45,0x65,0x65,0x84,0xB4];   // test
        $code = 0x48;
        $value = null;
        $data2 = null;
    }elseif($input2 == "49\n")   // Key
    {
       // $packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x49,0x44,0x45,0x65,0x65,0x28,0x92];    // key 
        $code = 0x49;
        $value = null;
        $data2 = [0x44,0x45,0x65,0x65,0x44,0x45,0x65,0x65];

    }elseif ($input2 == "50\n") {   //Status reply
        //$packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x50,0x44,0x45,0x65,0x65,0x84,0xB4];   // test
        $code = 0x50;
        $value = null;
        $data2 = [0x12,0x23,0x54,0x54,0x25,0x32,0x33,0x23,0x95,0x65,0x69,0x95,0x01,0x78,0x32,0x88,0x23,0x23,0x78,0x32,0x88,0x23];
    }elseif($input2 == "51\n")   // Alarm status reply
    {
       // $packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x49,0x44,0x45,0x65,0x65,0x28,0x92];    // key 
        $code = 0x51;
        $value = null;
        $data2 = [0x12,0x23,0x54,0x54,0x25,0x32,0x33,0x23,0x95,0x65,0x69,0x95];

    }elseif ($input2 == "52\n") {   // firmware status reply
        //$packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x50,0x44,0x45,0x65,0x65,0x84,0xB4];   // test
        $code = 0x52;
        $value = null;
        $data2 = [0x44,0x45,0x65,0x65];
    }elseif($input2 == "53\n")     // speed location update
    {
       // $packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x49,0x44,0x45,0x65,0x65,0x28,0x92];    // key 
        $code = 0x53;
        $value = null;
        $data2 = [0x81,0x42,0x88,0x25,0x83,0x98,0x32,0x88,0x28];

    }elseif ($input2 == "54\n") {   // alarm event
        //$packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x50,0x44,0x45,0x65,0x65,0x84,0xB4];   // test
        $code = 0x54;
        $value = 0x03;
        $data2 = [0x12,0x23];
    }elseif($input2 == "55\n")     // fault event
    {
       // $packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x49,0x44,0x45,0x65,0x65,0x28,0x92];    // key 
        $code = 0x55;
        $value = 0x01;
        $data2 = [0x44];

    }elseif ($input2 == "56\n") {    // ignition event
        //$packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x50,0x44,0x45,0x65,0x65,0x84,0xB4];   // test
        $code = 0x56;
        $value = null;
        $data2 = [0x00];
    }elseif ($input2 == "57\n") {    // Driver tag event
        //$packet = [0x7E,0xF4,0x21,0x05,0x02,0x01,0x4F,0x50,0x44,0x45,0x65,0x65,0x84,0xB4];   // test
        $code = 0x57;
        $value = null;
        $data2 = [0x01,0x45,0x65,0x65,0x44,0x45,0x65,0x65,0x44,0x45,0x65,0x65,0x44,0x45,0x65,0x65,0x44,0x45,0x65,0x65,0x44,0x45,0x65,0x65,0x44,0x45,0x65,0x65,0x44,0x45,0x65,0x65];
    }
   //
    $TXdata = [$start_byte,0x00,0x00,0x01,0x02,0x01,0x4F,$code];
        $length = 5;

   

            if($value)
            {
                
                array_push($TXdata, $value);                                //add $value to data if applicable
                $length++;
            }

            if($data2)
            {
                for($i = 0; $i < sizeof($data2) ; $i++)                     //add data to the data packet
                {
                    array_push($TXdata, $data2[$i]);    
                    $length++;
                }
            }


            $TXdata[1] = $length >> 8;                                      //calculate upper byte of length
            $TXdata[2] = $length & 0xFF;                                    //calculate lower byte of length

            

            $crc = crc_calc(hexToStr($TXdata));               //calculate crc for thw whole packet

            array_push($TXdata, $crc >> 8);                                 //add upper byte of crc to packet
            array_push($TXdata, $crc & 0xFF);                               //add lower byte of crc to packet

var_dump($TXdata);


   $input = hexToStr($TXdata);
  
   //var_dump($input);
    //Send the message to the server
    if( ! socket_sendto($txsock, $input , strlen($input) , 0 , $server , $txport))
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
         
        die("Could not send data: [$errorcode] $errormsg \n");
    }
         
    //Now receive reply from server and print it
    if(socket_recv ( $txsock , $reply , 2045 , MSG_WAITALL ) === FALSE)
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
         
        die("Could not receive data: [$errorcode] $errormsg \n");
    }
    $data = unpack("H*",$reply);                   //unpack the binary data
            //e("two");
            //var_dump($data[1]);
            $hex = strToHex($data[1]);   
     var_dump($hex);
    echo "Reply : $reply";
}


function hexToStr($hex){
    $string='';
    //var_dump($hex);
    for ($i=0; $i < sizeof($hex) ; $i++){
      $string .= chr($hex[$i]);
    }
   // e($string);
    return $string;
}

 function strToHex($string){ 
            $hex = [];
            
            for ($i=0; $i<strlen($string); $i+=2){
                $hexCode = "0x"  .strToUpper($string[$i]) .strToUpper($string[$i+1]);
                array_push($hex, $hexCode);
            }

            
            var_dump($hex);
            return $hex;
}

function crc_calc($data)
{
    var_dump($data);
   $crc = 0x1021;
   for ($i = 0; $i < strlen($data); $i++)
   {
     $x = (($crc >> 8) ^ ord($data[$i])) & 0xFF;
     $x ^= $x >> 4;
     $crc = (($crc << 8) ^ ($x << 12) ^ ($x << 5) ^ $x) & 0xFFFF;
   }
   var_dump($crc);
   return $crc;

}

