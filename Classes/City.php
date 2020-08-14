<?php

class City {

    public $name;
    public $lan; // Latitude
    public $lng; // Longitude

    public function __construct($name, $lan, $lng) {
        $this->name = $name;
        $this->lan  = $lan;
        $this->lng  = $lng;
    }

    public function distanceBetween($city1, $city2, $unit = 'K') {
        $lng1 = $city1->lng;
        $lan1 = $city1->lan;
        $lng2 = $city2->lng;
        $lan2 = $city2->lan;

        $theta = $lng1 - $lng2;
        $dist = sin(deg2rad($lan1)) * sin(deg2rad($lan2)) + cos(deg2rad($lan1)) * cos(deg2rad($lan2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public function distanceWith($city, $unit = 'K') {
        $lng1 = $this->lng;
        $lan1 = $this->lan;
        $lng2 = $city->lng;
        $lan2 = $city->lan;

        $theta = $lng1 - $lng2;
        $dist = sin(deg2rad($lan1)) * sin(deg2rad($lan2)) + cos(deg2rad($lan1)) * cos(deg2rad($lan2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public function totalDist($citiesArray, $unit = 'K') {
        if (is_array($citiesArray)) {
            $totalDist = 0;
            for ($i=1; $i < count($citiesArray); $i++) { 
                $distance = City::distanceBetween($citiesArray[$i-1], $citiesArray[$i], $unit);
                $totalDist += $distance;
            }
            return $totalDist;
        } else {
            return false;
        }
    }

    public function showJourney($citiesArray) {
        $journey = '';
        for ($i=0; $i < count($citiesArray); $i++) { 
            $journey .= ($i+1).'. '.$citiesArray[$i]->name;
            if ($i != count($citiesArray)-1) {
                $journey .= '<br>';
            }
        }
        return $journey;
    }

    public function displayMaps($citiesArray) {
        if (is_array($citiesArray)) {
            $maps = 'https://www.google.fr/maps/dir/';
            for ($i=0; $i < count($citiesArray) ; $i++) { 
                $maps .= "{$citiesArray[$i]->lan},{$citiesArray[$i]->lng}/";
            }
            $maps .= '@45.2362738,-3.1568526,7z/';
            return $maps;
        } else {
            return false;
        }
    }

    public function displayPartForm($citiesArray, $display = []) {
        if (is_array($citiesArray)) {
            $form = '<table><tr>';
            for ($i=0; $i < count($citiesArray) ; $i++) { 
                if ($i%3==0) {
                    $form.="</tr><tr>";
                }
                $form .= "<td><input type='checkbox' class='city' name='cities[]' id='".$i."' value='".$i."'";
                if (in_array($i, $display)) {
                    $form.="checked";
                }
                $form .= " /><label for='".$i."' class='city'>".$citiesArray[$i]->name."</label></td>";
            }
            $form .= '</tr></table>';
            return $form;
        } else {
            return false;
        }
    }

    public function echoLanLng() {
        echo $this->name.' : '.$this->lan.','.$this->lng.'<br>';
    }
}