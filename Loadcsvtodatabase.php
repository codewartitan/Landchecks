<?php
// $connect = mysqli_connect("localhost","root","","test");
$connect = mysqli_connect("71.140.148.117","sameer","sameer","sameer");
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{
$files = glob('F:/Datascience/Brownfields/*.csv');
foreach ($files as $file ) {   
    // print_r($file);
    $sql = "LOAD DATA LOCAL INFILE '".$file."' INTO TABLE `listtopublish`
    FIELDS TERMINATED BY ','  ENCLOSED BY '\"'    
    LINES TERMINATED BY '\r'  
    IGNORE 1 LINES
   (@dummy,PUB_Address_NoCity,PUB_Address_Full,@dummy,@dummy,@dummy,Pub_Other_Type1,PUB_Status,Pub_Other_Type1)
    set PUB_State ='GA',PUB_TypeofDepartment='Brownfields',PUB_TypeofRecord='Excel',Pub_M_add=''";       
}
if (mysqli_query($connect, $sql)) {
    echo "record inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($connect);
}
}
?>