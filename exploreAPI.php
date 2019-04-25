<?php
$connect = mysqli_connect("localhost","root","","test");

$url ="https://services.arcgis.com/njFNhDsUCentVYJW/arcgis/rest/services/Road_Ready_Projects_(In_Progress)/FeatureServer/0/query?where=1%3D1&outFields=*&outSR=4326&f=json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
// echo $result;
curl_close($ch);
$JsonData = json_decode($result);
// print_r($JsonData);
// $address1=$JsonData->resourceSets[0]->resources[0]->address->addressLine;
// foreach($JsonData['fields'] as $chunk)
// {
//    $a = $chunk['codedValues']['name'];

//    echo $a;
// }
$fieldName = $JsonData->fields[1]->name;
$ProjectNumber = $JsonData->fields[2]->name;
$alias = $JsonData->fields[2]->alias;
$County = array(
                $JsonData->fields[8]->domain->codedValues[0]->name,
                $JsonData->fields[8]->domain->codedValues[1]->name,
                $JsonData->fields[8]->domain->codedValues[2]->name,
                $JsonData->fields[8]->domain->codedValues[3]->name
            );
$plan = array(
             $JsonData->fields[10]->domain->codedValues[0]->name,
             $JsonData->fields[10]->domain->codedValues[1]->name,
             $JsonData->fields[10]->domain->codedValues[2]->name,
             $JsonData->fields[10]->domain->codedValues[3]->name
            );
 $season= array(
                $JsonData->fields[11]->domain->codedValues[0]->name,
                $JsonData->fields[11]->domain->codedValues[1]->name,
                $JsonData->fields[11]->domain->codedValues[2]->name,
                $JsonData->fields[11]->domain->codedValues[3]->name
             );
$On_Schedule = array(
                    $JsonData->fields[15]->domain->codedValues[0]->name,
                    $JsonData->fields[15]->domain->codedValues[1]->name,
                    $JsonData->fields[15]->domain->codedValues[2]->name
                );
$Speed_Limit =array(
                    $JsonData->fields[17]->domain->codedValues[0]->name,
                    $JsonData->fields[17]->domain->codedValues[1]->name,
                    $JsonData->fields[17]->domain->codedValues[2]->name
                );
$direction=array(
                 $JsonData->fields[21]->domain->codedValues[0]->name,
                 $JsonData->fields[21]->domain->codedValues[1]->name,
                 $JsonData->fields[21]->domain->codedValues[2]->name,
                 $JsonData->fields[21]->domain->codedValues[3]->name,
                 $JsonData->fields[21]->domain->codedValues[4]->name,
                 $JsonData->fields[21]->domain->codedValues[5]->name,
                 $JsonData->fields[21]->domain->codedValues[6]->name
                );
$direction=array(
                 $JsonData->fields[31]->domain->codedValues[0]->name,
                 $JsonData->fields[31]->domain->codedValues[1]->name,
                 $JsonData->fields[31]->domain->codedValues[2]->name
                );
// $a = $JsonData->features[0]->geometry->x;
// $a = $JsonData->features[0]->geometry->x;
// echo $a;
// $insertValue = implode(',',$County);
// echo $insertValue;
//  $sql = "INSERT INTO testingapi(alias,County)VALUES('$alias','$insertValue')";           
// if (mysqli_query($connect, $sql)) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($connect);
// } 
$PLC_Project_Number =$JsonData->features[0]->attributes->PLC_Project_Number;
$SHA_Project_Number = $JsonData->features[0]->attributes->SHA_Project_Number;
$Project_Name=$JsonData->features[0]->attributes->Project_Name;
$Location=$JsonData->features[0]->attributes->Location;
$MD_Route_Number=$JsonData->features[0]->attributes->MD_Route_Number;
$Road_Name=$JsonData->features[0]->attributes->Road_Name;
$City_Town=$JsonData->features[0]->attributes->City_Town;
$County=$JsonData->features[0]->attributes->County;
$Work_Type=$JsonData->features[0]->attributes->Work_Type;
$Phase=$JsonData->features[0]->attributes->Phase;
$Estimated_Start_Season=$JsonData->features[0]->attributes->Estimated_Start_Season;
$Estimated_Completion_Season=$JsonData->features[0]->attributes->Estimated_Completion_Season;
$Estimated_Project_Start_Year=$JsonData->features[0]->attributes->Estimated_Project_Start_Year;
$Estimated_Project_Completion_Ye=$JsonData->features[0]->attributes->Estimated_Project_Completion_Ye;
$What_to_Expect=$JsonData->features[0]->attributes->What_to_Expect;
$From_Road =$JsonData->features[0]->attributes->From_Road;
$To_Road=$JsonData->features[0]->attributes->To_Road;
$Direction=$JsonData->features[0]->attributes->Direction;
$long = $JsonData->features[0]->attributes->geometry->x;
$lats =$JsonData->features[0]->attributes->geometry->y;
?>