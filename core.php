    <?php

    if (count($cities) > 1) {

        $journeys    = array();
        $jourDistMin = array();
        for ($k=0; $k < count($cities) ; $k++) {
            $newJourney = array();
            for ($n=0; $n < count($cities)-1; $n++) { 
                $findMin = array();
                if ($n != 0 && isset($nextCity)) {
                    $start = $nextCity;
                } else {
                    array_push($newJourney, $cities[$k]);
                    $start = $cities[$k];
                }
                for ($j=0; $j < count($cities); $j++) {
                    if (!in_array($cities[$j], $newJourney)) {
                        $distance = $start->distanceWith($cities[$j]);
                        if ($distance != 0) {
                            array_push($findMin, $distance);
                            if ($distance == min($findMin)) {
                                if ($n != 0) {
                                    if (!in_array($cities[$j], $newJourney)) {
                                        $nextCity = $cities[$j];
                                    }
                                } else {
                                    $nextCity = $cities[$j];
                                }
                            }
                        }
                    }
                }
                array_push($newJourney, $nextCity);
            }
            $totalDist = City::totalDist($newJourney, $u);
            if ($shorter) {
                array_push($journeys, [$newJourney, $totalDist]);
                array_push($jourDistMin, $totalDist);
            } elseif (!$shorter) {
                if ($totalDist <= $threshold) {
                    echo "<div class='col-xs col-md-6'><div class='alert alert-success'>";
                        $journey = "<strong>Nouveau trajet pour une distance de moins de ".intval($threshold)." ".$unit." :</strong><br><br>";
                        $journey .= City::showJourney($newJourney);
                        echo $journey."<br><br>";
                        echo "La distance totale pour ce trajet est de <strong>".intval($totalDist)." ".$unit."</strong> en vol d'oiseau !";
                        echo '<br><br><a href="'.City::displayMaps($newJourney).'" target="_blank">Allez voir le trajet !</a>';
                    echo "</div></div>";
                    break;
                } elseif ($totalDist > $threshold && $k == count($cities)-1) {
                    echo "<div class='col-xs col-md-6'><div class='alert alert-danger'><b>Aucun trajet trouvé pour une distance totale minimale de ".intval($threshold)." ".$unit.".</b></div></div>";
                }
            }
        }
        if ($shorter) {
            $count = 0;
            $jourFound = false;
            foreach ($journeys as $jour) {
                $count++;
                if (min($jourDistMin) == $jour[1] && !$jourFound) {

                    $jourFound = true;            
                    echo "<div class='col-xs col-md-6'><div class='alert alert-success'>";
                        $journey = "<strong>Nouveau trajet avec la distance la plus courte :</strong><br><br>";
                        $journey .= City::showJourney($jour[0]);
                        echo $journey."<br><br>";
                        echo "La distance totale pour ce trajet est de <strong>".intval($jour[1])." ".$unit."</strong> en vol d'oiseau !";
                        echo '<br><br><a href="'.City::displayMaps($jour[0]).'" target="_blank">Allez voir le trajet sur Google Maps !</a>';
                        echo "</div></div>";
                }
            }
        }

    } else {
        $emoji = [
            '￣_￣；',
            '(ｰ ｰ;)',
            '(´･_･｀)',
            '(눈_눈)',
            '-`д´-'
        ];            
        echo "<div class='col-xs col-md-6'><div class='alert alert-danger text-center'>";
        echo $emoji[random_int(0, count($emoji)-1)];
        echo "<br><span>Choisissez donc un vrai trajet !</span>";
        echo "</div></div>";
    }