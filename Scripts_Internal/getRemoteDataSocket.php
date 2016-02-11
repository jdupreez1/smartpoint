<?php
 require_once '../Core/init.php';
 $authok = false;
 $authDevices = [];
$ary = array();
 

//$_db = db::getInstance();


//Reduce errors

error_reporting(~E_WARNING);

 $max_clients = 20;


$debug = true;
function e($str) {
    global $debug;
    if($debug) { echo($str . "\n"); }
}

//create UDP socket

if(!($rxsocket = socket_create(AF_INET, SOCK_DGRAM, 0)))            // create the socket for receiving data from RTU
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Couldn't create socket: [$errorcode] $errormsg \n");
}
echo "RX Socket created \n";
 
 if( !socket_bind($rxsocket, "0.0.0.0" , 44601) )                 //bind the socket to the port for any incoming IP
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Could not bind socket : [$errorcode] $errormsg \n");
}
 
echo "RX Socket bind OK \n";



do {
    

    $authok = false;                                            //set authentication to default
    
    $r = socket_recvfrom($rxsocket, $buf, 512,0, $remote_ip, $remote_port);   // check data on socket

  
     if($r > 0)
     {                                                      //wait for data to be received
      $r = 0;   
      /* Setup socket pair */
      if (socket_create_pair(AF_UNIX, SOCK_STREAM, 0, $ary) === false)        //create socket for inter process comms between child and parent
      {
          echo "socket_create_pair() failed. Reason: ".socket_strerror(socket_last_error());
      }

      $pid = pcntl_fork();                                            // fork process on new data received into child and parent
 
        if ($pid == -1) {
             die('could not fork');
        } else if ($pid) {

            // I am parent do not do anything and return to top $r = .....

            socket_close($ary[0]);
            
            if (($data = socket_read($ary[1], strlen($remote_ip), PHP_BINARY_READ)) === $remote_ip)   //check for data from the child
            {
              array_push($authDevices, $data);                                                        //add the ip address to the array of authenticated devices
              // e('Unit authenticated ok ');
            }

            socket_close($ary[1]);                                                
        }else{

           // I am child  - do stuff required and then die

          //var_dump($remote_ip);

          //var_dump($authDevices);

          if(in_array($remote_ip, $authDevices) == true)
          {
            $authok = true;                                             //check that the IP address has been authenticated
                    
             //var_dump($authok); 

          }else
          {
            $authok = false;
            
            //var_dump($authok); 
          }
       
          $comms = new comms();
          
         $RXData = $comms->unPack($buf,$rxsocket, $remote_ip , $remote_port,$authok);
          if($RXData == "AuthOK")      //unpack received data and interpret commands  - if command was authentication key, the authentication has to be noted in the array
          {
            
            socket_close($ary[1]);
            if (socket_write($ary[0], $remote_ip, strlen($remote_ip)) === false)                //write the IP address of authenticated RTU to the parent process
            {
                echo "socket_write() failed. Reason: ".socket_strerror(socket_last_error($ary[0]));
            }
            socket_close($ary[0]);

            e('Unit authenticated ok ');
            
          }

          die();                                                                                  //kill child process
        }

      } 

       
} while (true);
    
 socket_close($rxsocket);


?>
