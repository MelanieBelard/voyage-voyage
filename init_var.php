<?php 

    include_once('Classes/City.php');

    $filePath = 'cities.json';
    $file = fopen($filePath, "r+") or die("Unable to open file!");
    $json = fread($file, filesize($filePath));
    $data   = json_decode($json, true)['cities'];
    $cities = array();
    $citiesToDisplay = array();

    if (!is_array($data)) {
        echo "Json inccorect.";
    } else {

        $threshold = 2222; // Par défaut en miles
        if (isset($_POST['threshold'])) {
            $threshold = $_POST['threshold'];
        }
        if (isset($_POST['shorter'])) {
            $shorter = $_POST['shorter'];
        } else {
            $shorter = 0;
        }
        $totalDist = 0;
        $journey   = '';

        $c = 0;
        foreach ($data as $city) {
            if (in_array($c, $display)) {
                array_push($cities, new City($city['name'], $city['lan'], $city['lng']));
            } elseif (empty($display)) {
                $cities = [];
            }
            array_push($citiesToDisplay, new City($city['name'], $city['lan'], $city['lng']));
            $c++;
        }
    }