<?php


// while($row = mysqli_fetch_array(get_data('0772737414'))){

// 	echo $row['fname'],$row['city'],$row['phone'];
// }
// $lol = get_data('0772737414');
// $data = "Name: ".$lol['fname']."\nCity: ".$lol['city']."\nContact No: ".$lol['phone'];
function get_data($num)
{

$servername = "localhost";
$username = "tharangij";
$password = "+h@rAn9!J";
$dbname = "lol";


// $connect_error = 'Sorry, Technical Difficulties';
$conn = mysqli_connect($servername,$username,$password,$dbname);

// $num = "0772737414";
$sql = "SELECT a.province FROM user_info AS a, telephone AS b WHERE $num=b.phone AND a.userid=b.userid";

$ret = mysqli_query($conn,$sql);

$ow = mysqli_fetch_assoc($ret);
// echo $ow['province'];

$sqlx = "SELECT a.fname,a.adline1,a.adline2,a.city,b.phone FROM user_info AS a, telephone AS b WHERE a.userid=b.userid AND a.province='Western'";

$retrieval = mysqli_query($conn,$sqlx);
// printf("Error: %s\n", mysqli_error($conn));
$row = mysqli_fetch_array($retrieval);

return $row;

}


?>