<?php 
ini_set('error_log', 'ussd-app-error.log');

require 'libs/MoUssdReceiver.php';
require 'libs/MtUssdSender.php';
require 'class/operationsClass.php';
require 'log.php';
require 'db.php';
require 'connect.php';

$ussdserverurl = "https://api.dialog.lk/ussd/send";

$receiver 	= new UssdReceiver();
$sender 	= new UssdSender($ussdserverurl,'APP_000001','password');
$operations = new Operations();

$receiverSessionId 	= $receiver->getSessionId();
$content 			= 	$receiver->getMessage(); // get the message content
$address 			= 	$receiver->getAddress(); // get the sender's address
$requestId 			= 	$receiver->getRequestID(); // get the request ID
$applicationId 		= 	$receiver->getApplicationId(); // get application ID
$encoding 			=	$receiver->getEncoding(); // get the encoding value
$version 			= 	$receiver->getVersion(); // get the version
$sessionId 			= 	$receiver->getSessionId(); // get the session ID;
$ussdOperation 		= 	$receiver->getUssdOperation(); // get the ussd operation

$responseMsg = array(
"main" =>  
    "Keth-Net
1. Sinhala
2. English

99. Exit",
"Sinhala" =>  
    "Keth-Net
1. Ganudenu Karuweku sandaha visthara laba ganima
2. Wagahimiyeku sandaha visthara laba ganima

99. Exit",
"English" =>  
    "Keth-Net
1. Information about farmers
2. Information about buyers

99. Exit",
"Pradeshaya" =>  
    "Keth-Net
1. Oba Pradeshaye
2. Wenath Pradeshayaka

99. Exit",
"Province" =>  
    "Keth-Net
1. Of your Province
2. Of another Province

99. Exit",
"PalathList" =>
	"Keth-Net
1.Uthuru mada
2.Madyama
3.Uthura
4.Basnahira
5.Dakuna
6.Nagenahira
7.Sabaragabuwa
8.Wayamba
9.Uva

99. Exit",
"ProvinceList" =>
	"Keth-Net
1.North Central
2.Central
3.North
4.Western
5.Sourthern
6.Earstern
7.Sabaragabuwa
8.North Western
9.Uva

99. Exit"	
);


if ($ussdOperation  == "mo-init") { 
   
	try {
		
		$sessionArrary=array( "sessionid"=>$sessionId,"tel"=>$address,"menu"=>"main","pg"=>"","others"=>"");

  		$operations->setSessions($sessionArrary);

		$sender->ussd($sessionId, $responseMsg["main"],$address );

	} catch (Exception $e) {
			$sender->ussd($sessionId, 'Sorry error occured try again',$address );
	}
	
}else {

	$flag=0;

  	$sessiondetails=  $operations->getSession($sessionId);
  	$cuch_menu=$sessiondetails['menu'];
  	$operations->session_id=$sessiondetails['sessionsid'];

		switch($cuch_menu ){
		
			case "main": 	// Following is the main menu
					switch ($receiver->getMessage()) {
						case "1":
							$operations->session_menu="Sinhala";
							$operations->saveSesssion();
							$sender->ussd($sessionId,$responseMsg["Sinhala"],$address );
							break;
						case "2":
							$operations->session_menu="English";
							$operations->saveSesssion();
							$sender->ussd($sessionId,$responseMsg["English"],$address );
							break;
					
						default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
					break;
			case "Sinhala":
					switch ($receiver->getMessage()) {
						case "1":
							$operations->session_menu="Pradeshaya";
							$operations->saveSesssion();
							$sender->ussd($sessionId,$responseMsg["Pradeshaya"],$address );
							break;

						case "2":
							$operations->session_menu="Pradeshaya";
							$operations->saveSesssion();
							$sender->ussd($sessionId,$responseMsg["Pradeshaya"],$address );
							break;
						
						default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
					break;
			case "English":
					switch ($receiver->getMessage()) {
						case "1":
							$operations->session_menu="Province";
							$operations->saveSesssion();
							$sender->ussd($sessionId,$responseMsg["Province"],$address );
							break;

						case "2":
							$operations->session_menu="Province";
							$operations->saveSesssion();
							$sender->ussd($sessionId,$responseMsg["Province"],$address );
							break;
						
						default:
							$operations->session_menu="main";
							$operations->saveSesssion();
							$sender->ussd($sessionId, $responseMsg["main"],$address );
							break;
					}
					break;

			case "Pradeshaya":
					switch ($receiver->getMessage()) {
						case "1":
							$operations->session_menu="Pradeshaya";
							$operations->saveSesssion();
							$lol = get_data($receiver->getAddress());
							$data = "Name: ".$lol['fname']."\nCity: ".$lol['city']."\nContact No: ".$lol['phone'];
							$sender->ussd($sessionId,$data,$address );
							break;
						case "2":
							$operations->session_menu="Pradeshaya";
							$operations->saveSesssion();
							$sender->ussd($sessionId,$responseMsg["PalathList"],$address );
							break;
						}
				break;
			case "Province":
					switch ($receiver->getMessage()) {
						case "1":
							$operations->session_menu="Province";
							$operations->saveSesssion();
							$lol = get_data($receiver->getAddress());
							$data = "Name: ".$lol['fname']."\nCity: ".$lol['city']."\nContact No: ".$lol['phone'];
							$sender->ussd($sessionId,$data,$address );
							break;
						case "2":
							$operations->session_menu="Province";
							$operations->saveSesssion();
							$sender->ussd($sessionId,$responseMsg["ProvinceList"],$address );
							break;
						}
						break;

			
		}
	
}


 ?>