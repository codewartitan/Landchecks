<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<form method="post" enctype = 'multipart/form-data'>
<p><label for="Csv Formate">Please Select File(only CSV Formate)</label>
<br/>
<input type="file" name ="Product_file"value=""></p>
<button type="submit" name = "upload" class="btn btn-info">Upload</button>
</form>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
<?php
$connect = mysqli_connect("localhost","root","","test");
if(isset($_POST['upload'])){
    $uploaddir = 'C:\Users\hp\Downloads';
    $uploadfile = $uploaddir.'/'.basename($_FILES['Product_file']['name']);
    if($_FILES['Product_file']['name']){
        $filename = explode(".",$_FILES['Product_file']['name']);       
            $handle = fopen($uploadfile,"r");
            while(($data= fgetcsv($handle,1000,","))!==FALSE)
            {
                $Number= $data[1];
                $SiteName = $data[2]; 
                $started = $data[3];                
                $City = $data[4];
                $City = $data[5];
                $Latitude = $data[6] .$data[7].$data[8];
                $Longitude = $data[9].$data[10].$data[11];
                $depart = $data[8];
                $agenda = mysqli_real_escape_string($connect,$data[9]);
                $notes = $data[10];
                $public = $data[11];
                // echo 'City '.$City.'<br>'; 
                // echo 'Longitude '.$Longitude.'<br>';
                // echo 'Latitude1 '.$Latitude1.'<br>';  
             $sql = "INSERT INTO listtopublish(PUB_ID,PUB_CFG_ID,PUB_Status,PUB_State,PUB_County,PUB_City,PUB_TypeofDepartment,PUB_TypeofRecord,PUB_Geo_Long,PUB_GEO_Lat)VALUES ('','','','MS','$data[5]','$data[4]','','','$Longitude','$Latitude')";           
            if (mysqli_query($connect, $sql)) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($connect);
            }    
        }
            
    }
    else{
        $message = '<label class ="text-danger">Please Select the file</label>';
    }
}

        // $connect = mysqli_connect("localhost","root","","test");
        // $filename = "C:\Users\hp\Downloads\Brownfields.csv";
        // $the_csv_data = [];
        // if(($h =fopen("{$filename}","r")) !== FALSE)
        // {
        //     while(($data= fgetcsv($h,1000,","))!==FALSE){                         
        //         $FederalDept= $data[1];
        //         $statecode = $data[2];   
        //         // echo 'Federal Dept '.$FederalDept.'<br>';
        //         // echo 'State Code '.$statecode.'<br>';          
        //     }  
        //         fclose($h);
        // }
?> 

