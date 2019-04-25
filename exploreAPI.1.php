<?php
$connect = mysqli_connect("data.landchecks.com:3303","devroads","4roaDs#12","sameer");
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{
    $url ="https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/Road_Ready_Projects_(In_Progress)/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    // echo $result;
    curl_close($ch);
    $JsonData = json_decode($result);
    foreach($JsonData->features as $chunk ){
    $PLC_Project_Number=$chunk->attributes->PLC_Project_Number;
    $SHA_Project_Number =$chunk->attributes->SHA_Project_Number;
    $Project_Name=$chunk->attributes->Project_Name;
    $Location=$chunk->attributes->Location;
    $MD_Route_Number=$chunk->attributes->MD_Route_Number;
    $Road_Name=$chunk->attributes->Road_Name;
    $City_Town=$chunk->attributes->City_Town;
    $County=$chunk->attributes->County;
    $Work_Type=$chunk->attributes->Work_Type;
    $What_to_Expect=$chunk->attributes->What_to_Expect;
    $From_Road=$chunk->attributes->From_Road;
    $To_Road=$chunk->attributes->To_Road;
    $Direction=$chunk->attributes->Direction;
    $long=$chunk->geometry->x;
    $lats=$chunk->geometry->y;
    $sql = "INSERT INTO APIExplorer(PLC_Project_Number,sha_project_number,Project_name,Location,MD_Route_Number,Road_Name,
    City,Work_type,what_to_expect,from_road,to_road,Direction,longs,lats)
    VALUES('$PLC_Project_Number','$SHA_Project_Number','$Project_Name','$Location','$MD_Route_Number','$Road_Name',
    '$City_Town','$Work_Type','$What_to_Expect','$From_Road','$To_Road','$Direction','$long','$lats')";
    if (mysqli_query($connect, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($connect);
    } 

    }
}
?>