<?php
echo "<a target='_blank' href='https://github.com/jmwilliams11/api.git'>GitHub repo</a>";
//covif19api.com
echo "<br>";
main();


function main () {
	
	$apiCall = 'https://api.covid19api.com/summary';
	// line below stopped working on CSIS server
	// $json_string = file_get_contents($apiCall); 
	$json_string = curl_get_contents($apiCall);
	//convert to string
	$obj = json_decode($json_string);

    $arr1 = Array();
    $arr2 = Array();
    //$deaths_arr = Array();
    foreach($obj->Countries as $i){
        array_push($arr1, $i->Country);
        array_push($arr2, $i->TotalDeaths);
    }
    
    array_multisort($arr2, SORT_DESC, $arr1);
    //print_r($arr1); //countries
    //print_r($arr2); //corresponding deaths already sorted
    
    
    $jsonArr = [];
    //loop to get the top 10 highest number of deaths
    for($i = 0; $i<10; $i++){ 
        $jsonObj->country = $arr1[$i];
        $jsonObj->total_deaths = $arr2[$i];
        $myJSON=json_encode($jsonObj);
        array_push($jsonArr, $myJSON);
    }
    //print_r($jsonArr);

    
    echo "<br>";
    echo "<br>";
    //make table now :D
    //table with border
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Country</th>";
    echo "<th>Total Deaths</th>";
    //echo "</tr>";
    //countries
    echo "<tr>";

    for($i=0; $i<10; $i++) {
        $json = $jsonArr[$i];
        $ob = json_decode($json);
        echo "<tr>";
        echo "<td>"
        . $ob->{"country"} .  "</td>";
        echo "<td>" 
        . $ob->{"total_deaths"} . "</td>";
        echo "</tr>";
    }
    



    //echo $data . " <br><br>";
	//reassigning one data element to another name 
	//$data = $obj->Global->NewConfirmed;
	//for tanzania
	
}

#-----------------------------------------------------------------------------
// read data from a URL into a string
function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}