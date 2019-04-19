<?php
$connect = mysqli_connect("71.140.148.117","sameer","sameer","sameer");

if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{
    $sql_select = "SELECT * from listtopublish where PUB_State='CT'";
    $result = mysqli_query($connect, $sql_select);
    if(mysqli_num_rows($result) > 0){             
        while($row =@mysqli_fetch_assoc($result)){
            $lats =$row['PUB_GEO_Lat'];
            $longs=$row['PUB_Geo_Long'];
            if($row['updateStatus']==1){  
            $url ="http://dev.virtualearth.net/REST/v1/Locations/$lats,$longs?o=json&key=At12iL8CuyxxiX47w_p_Q_O0x-cUeuhpRnQ6XENJHg0qLY5EIMq2_YG1RJ7QNM06";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            // echo $result;
            curl_close($ch);
            $JsonData = json_decode($result);
            $address1=$JsonData->resourceSets[0]->resources[0]->address->addressLine;
            $zipcode=$JsonData->resourceSets[0]->resources[0]->address->postalCode;	
            $county=$JsonData->resourceSets[0]->resources[0]->address->adminDistrict2;
            $address=$JsonData->resourceSets[0]->resources[0]->address->formattedAddress;
            $p=explode(",",$address);
            $City= ($p[1]);
            $a=preg_replace('/\W\w+\s*(\W*)$/','$1',$county);
            echo "Zipcodes".$zipcode;
            //  echo "County".$a;      
            //  echo "City".$City;    
            $sql = "UPDATE listtopublish SET PUB_County='$a',updateStatus=2 WHERE PUB_GEO_Lat='$lats' and PUB_Geo_Long='$longs' and PUB_State='CT' ";
            if ($connect->query($sql) === TRUE) {
                echo "Record updated successfully";
                echo "<script>window.location.reload()</script>";
            } else {
                echo "Error updating record: " . $connect->error;
            }
            
        }
    }
}else{
    echo "All the records are update";
}
}
    

