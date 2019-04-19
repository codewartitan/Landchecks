<?php
$connect = mysqli_connect("71.140.148.117","sameer","sameer","sameer");
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else
{
    $sql_select =  "select * from listtopublish where PUB_State='MD'";
    $result = mysqli_query($connect, $sql_select);
    if(mysqli_num_rows($result) > 0){
        while ($row =@mysqli_fetch_assoc($result)) {
            $address=mysqli_real_escape_string($connect,$row['PUB_Address_Full']);
            $city=$row['PUB_City'];
            $options = array(
                'street' => $address,
                    'city' =>$city,
                    'state' => 'MD',
                    'zip' => '',
                    'benchmark' => 'Public_AR_Current',
                    'format' => 'json'
            );
            if($row['updateStatus']=='' && $row['updateStatus'] = 3 )
            {
                $url = 'https://geocoding.geo.census.gov/geocoder/locations/address?'.http_build_query($options);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch,CURLOPT_TIMEOUT,30);
                $result = curl_exec($ch);
                echo "the result for the address-".$address."-".$result;
                curl_close($ch);
                $JsonData = json_decode($result,true);
                if (empty($JsonData['result']['addressMatches'])){
                    $Updatestatus3 = "UPDATE listtopublish SET updateStatus=3 WHERE PUB_State='MD' and PUB_Address_Full ='$address' and PUB_City='$city'";
                    if ($connect->query($Updatestatus3) === TRUE) {
                        echo "updated with status code 3";
                        echo "<script>window.location.reload()</script>";
                    }
                }
                else{
                    foreach($JsonData['result']['addressMatches'] as $chunk)
                        {
                        $addressComponents=$chunk['addressComponents'];
                        $coordinates = $chunk['coordinates'];
                        $zipcode =  $addressComponents['zip'];
                        // echo print_r($coordinates);
                        $longs = $coordinates['x'];
                        $LAts =$coordinates['y'];             
                        $sql = "UPDATE listtopublish SET PUB_GEO_Lat='$LAts',PUB_Geo_Long='$longs',updateStatus=1 WHERE PUB_State='MD' and PUB_Address_Full ='$address' and PUB_City='$city'";
                        if ($connect->query($sql) === TRUE) {
                            echo "Record updated successfully".$row['PUB_City'];
                            echo "<script>window.location.reload()</script>";
                        } else {
                        echo "records are updated successfully completed";
                        exit();
                        }
                    }
                }
                // echo "<script>window.location.reload()</script>";
                // echo 'Address '.$address."<br>";
                // echo 'City '.$city."<br>";
            }
        }
    }
}
?>
