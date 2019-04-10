<?php
$connect = mysqli_connect("localhost","root","","test");
$files = glob('F:/Datascience/Brownfields/*.csv');
foreach ($files as $file ) {
    // $filename = explode('\\',$file);
    // $filename2clean = str_replace('.csv','', $filename[3]);//because my file is under 5 folders on my PC
    // $n = strtolower(str_replace('fileprefix_','', $filename2clean));

    // echo '<br>Create table <b>'.$n.'</b><hr>';

    $sql = "LOAD DATA LOCAL INFILE '".$file."' INTO TABLE `listtopublish`  
    FIELDS TERMINATED BY ','
    LINES TERMINATED BY '\r'  
    IGNORE 1 LINES";
    // echo $sql . "<br>";
    // print_r(basename($file));     
}
if (mysqli_query($connect, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($connect);
} 
// echo print_r($files);
?>