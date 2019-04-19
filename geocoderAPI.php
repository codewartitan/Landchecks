<?php
// $lats=35.125483;
// $longs=-106.625034;

// $url ="http://dev.virtualearth.net/REST/v1/Locations/$lats,$longs?o=json&key=At12iL8CuyxxiX47w_p_Q_O0x-cUeuhpRnQ6XENJHg0qLY5EIMq2_YG1RJ7QNM06";
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $result = curl_exec($ch);
// //  echo $result;
// curl_close($ch);
// $JsonData = json_decode($result);
// // echo print_r($JsonData);
// $address1=$JsonData->resourceSets[0]->resources[0]->address->addressLine;
// $zipcode=$JsonData->resourceSets[0]->resources[0]->address->postalCode;	
// $county=$JsonData->resourceSets[0]->resources[0]->address->adminDistrict2;
// $address=$JsonData->resourceSets[0]->resources[0]->address->formattedAddress;
// // $p=explode(",",$address);

// // $City= ($p[1]);
//  $a=preg_replace('/\W\w+\s*(\W*)$/','$1',$county);
//   echo "Zipcodes".$zipcode;
//  echo "County:  ".$a; 
//  echo $county;
// // echo "City".$City;
// echo $address1;

// $options = array(
//                     'street' => '1205 Champlain Street',
//                         'city' =>'Toledo',
//                         'state' => 'OH',
//                         'zip' => '',
//                         'benchmark' => 'Public_AR_Current',
//                         'format' => 'json'
//                 ); 
//                 $url = 'https://geocoding.geo.census.gov/geocoder/locations/address?'.http_build_query($options);
//                         $ch = curl_init();
//                         curl_setopt($ch, CURLOPT_URL, $url);
//                         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                         curl_setopt($ch,CURLOPT_TIMEOUT,30);
//                         $result = curl_exec($ch);
//                         echo $result;
//                         curl_close($ch);
//                 	$JsonData = json_decode($result,true);
//                     foreach($JsonData['result']['addressMatches'] as $chunk)
//                     {
//                     $addressComponents=$chunk['addressComponents'];
//                     $coordinates = $chunk['coordinates'];
//                     $zipcode =  $addressComponents['zip'];
//                 //     echo print_r($coordinates);
//                     $longs = $coordinates['x'];
//                     $LAts =$coordinates['y'];
//                     echo "Latitude: ".$LAts."<br>";
//                     echo "Longitude: ".$longs."<br>";
//                     }

$options = array(
                    'street' => '13TH LN',
                        'city' =>'PRESTON TN',
                        'state' => 'WI',
                        'app_id'=>'16JcdWVaEp2SUQd6SQPI',
                        'app_code'=>'bew2DnAA07_QBHZ0BJdl4w',
                        'gen'=>'9'
                ); 

                $url = 'https://geocoder.api.here.com/6.2/geocode.json?'.http_build_query($options);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch,CURLOPT_TIMEOUT,30);
                $result = curl_exec($ch);
                 echo $result;
                curl_close($ch);
                 $JsonData = json_decode($result,true);
                // echo var_dump($JsonData);
                foreach($JsonData['Response']['View'] as $chunk)
                {
                    $addressComponents=$chunk['Result'][0];
                    $DisplayPosition = $addressComponents['Location']['DisplayPosition'];
                    $location = $addressComponents['Location']['Address'];
                    echo '<pre>'."Latitude".$DisplayPosition['Latitude'].'</pr>';
                    echo "Longitude ".$DisplayPosition['Longitude'];                    
                    echo $location['Label'];
                    // $DisplayPosition = $addressComponents['DisplayPosition'];
                    // $lats= $DisplayPosition['Latitude'];
                    // echo $lats;
                }
                // $address1=$JsonData->view[0]->_type;
                // echo  var_dump($result);
                // $address1=$JsonData->Response[0]->View[0]->Result[0]->Relevance;
?>