<?php
$connect = mysqli_connect("data.landchecks.com:3303","devroads","4roaDs#12","sameer");
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
else{
$url ="https://services1.arcgis.com/O1JpcwDW8sjYuddV/arcgis/rest/services/FY17_Adopted_Work_Program_2022/FeatureServer/0/query?outFields=*&where=1%3D1&f=json";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
// echo $result;
curl_close($ch);
// $response = json_decode($result);
// var_dump($response);
$JsonData = json_decode($result);
foreach($JsonData->features as $chunk )
{
    $COUNTY_NAM=$chunk->attributes->COUNTY_NAM;
    $descriptio=mysqli_real_escape_string($connect,$chunk->attributes->DESCRIPTIO);
    $BEGIN_MILE=$chunk->attributes->BEGIN_MILE;
    $END_MILE=$chunk->attributes->END_MILE;
    $PROJECT_TY=mysqli_real_escape_string($connect,$chunk->attributes->PROJECT_TY);
    $PHASE_NAME=mysqli_real_escape_string($connect,$chunk->attributes->PHASE_NAME);
    $CATEGORY=mysqli_real_escape_string($connect,$chunk->attributes->CATEGORY);
    $FISCAL_YEA=$chunk->attributes->FISCAL_YEA;
    $WPITEM_SEG=$chunk->attributes->WPITEM_SEG;
    $PHASE_YEAR=$chunk->attributes->PHASE_YEAR;
    $PHASE=$chunk->attributes->PHASE;
    $DESCRIPT=$chunk->attributes->DESCRIPT;
    $Shape_Leng=$chunk->attributes->Shape_Leng;
    $Shape__Length=$chunk->attributes->Shape__Length;
    $geo = [];
    // $geo1;
    //  echo '<pre>'.$COUNTY_NAM.'</pre>';
    foreach($chunk->geometry->paths[0] as $geometry )
    {
        $geo =$geometry;
        // echo '<pre>'.$geo[0].'</pre>';
        // echo '<pre>'.$geo[1].'</pre>';

        $geo1=$geo[0].' '.$geo[1];
    $geocode = mysqli_real_escape_string($connect,$geo1);

        // echo '<pre>'.$geo1.'</pre>';
        $sql = "INSERT INTO APIExplorer1(COUNTY_NAM,DESCRIPTIO,BEGIN_MILE,END_MILE,PROJECT_TY,
        PHASE_NAME,CATEGORY,FISCAL_YEA,WPITEM_SEG,PHASE_YEAR,PHASE,DESCRIPT,Shape_Leng,Shape__Length,shape,state)
        values('$COUNTY_NAM','$descriptio',$BEGIN_MILE,'$END_MILE','$PROJECT_TY','$PHASE_NAME',
        '$CATEGORY','$FISCAL_YEA','$WPITEM_SEG','$PHASE_YEAR','$PHASE','$DESCRIPT','$Shape_Leng',
        '$Shape__Length',POINTFROMTEXT('POINT($geo1)'),'NC')";
        if (mysqli_query($connect, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connect);
        }     
        
    }
    ?>