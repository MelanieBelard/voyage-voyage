<!DOCTYPE html>
<html>
<head>
    <title>Voyage, voyage</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style/bootstrap.css">
    <style type="text/css">
        body {
            background: linear-gradient(to bottom right, #fefefe 0%, #efefef 100%);
        }
        footer {
            margin-bottom: 20px;
        }
        td {
            min-width: 37%;
        }
        .container {
            margin-top: 40px;
        }
        .city {
            margin-left: 5px;
        }
    </style>
</head>

<?php 

    if (isset($_POST['cities'])) {
        $display = $_POST['cities'];
    } else {
        $display = array();
        for ($i=0; $i < 15; $i++) {
            array_push($display, $i);
        }
    }

    include('init_var.php');
    $unit = "kilomètres";
    if (isset($_POST['unit'])) {
        $unit = $_POST['unit'];
    }
    $u    = substr(strtoupper($unit), 0, 1);

    $threshold = 2222; // Par défaut en miles
    if (isset($_POST['threshold'])) {
        $threshold = $_POST['threshold'];
        if (empty($threshold)) {
            $threshold = 2222;
            if ($u == 'K') {
                $threshold *= 1.609344;
            } elseif ($u == 'N') {
                $threshold *= 0.8684;
            }
        }
    }
    if (!isset($_POST['threshold'])) {
        if ($u == 'K') {
            $threshold *= 1.609344;
        } elseif ($u == 'N') {
            $threshold *= 0.8684;
        }
    }
?>

<body class="container">

    <div class="row">
        <div class="col">
            <div class="text-center text-primary"><h1>Voyage, voyage</h1></div>
            <hr><br>
            <p class="text-center">
                <b>Bienvenue sur le calculateur de distance !</b><br>
                Ici, vous pouvez calculer la distance totale minimale du trajet que vous souhaiteriez faire entre toutes les villes présentes ci-dessous. Choisissez les villes par lesquelles vous souhaitez passer et nous calculerons l'itinéraire le plus court <b>à vol d'oiseau</b> !<br>
                De plus, vous avez la possibilité de choisir un <b>seuil de tolérence</b> (c'est-à-dire la distance totale maximale que vous tolérez) ou bien la distance totale minimale absolue.<br>
                Bon voyage ! (｀･ω･´)ゞ
            </p>
        </div>
    </div>
    <hr><br>

    <div class="row">
        <form action='' class="col-xs col-md-6 text-center" method='post'>
            <div>
                <div class='alert alert-warning'>
                    <input type="radio" name="unit" <?php if($u=='M'){ echo 'checked'; } ?> value="miles" id="miles" /> <label for="miles" >Miles /</label>
                    <input type="radio" name="unit" <?php if($u=='N'){ echo 'checked'; } ?> value="nautic miles" id="nautic miles" /> <label for="nautic miles" >Nautic miles /</label>
                    <input type="radio" name="unit" <?php if($u=='K'){ echo 'checked'; } ?> value="kilomètres" id="kilomètres" /> <label for="kilomètres" >Kilomètres</label>
                    <br><br>
                    <label><b>Distance totale minimale acceptable :</b> </label>
                    <br>
                    <input id="threshold" type="number" name="threshold" <?php if(isset($threshold)) { echo "value='".intval($threshold)."'"; } ?> >
                    <div class="row">
                        <div class="col">
                            <input id="shorter" onclick="thresholdToggle()" type="checkbox" name="shorter" value='1' <?php if($shorter){ echo 'checked'; } ?>> <label for="shorter">Itinéraire le plus court</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-left">
                            <hr>
                            <input type="checkbox" id="select-all"> <label for="select-all">Toutes les villes</label>
                            <hr>
                            <?php echo City::displayPartForm($citiesToDisplay, $display); ?>
                            <hr>
                        </div>
                    </div>
                    <br>
                    <input type="submit" value="Calculer le trajet" class='btn btn-primary'>
                </div>
            </div>
        </form>


        <?php include('core.php') ?>

    </div>

    <hr>
    <footer class="text-center">
        <a href="https://github.com/MelanieBelard/voyage-voyage" target="_blank">
            <svg width="50" height="50" viewBox="0 0 1024 1024" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8C0 11.54 2.29 14.53 5.47 15.59C5.87 15.66 6.02 15.42 6.02 15.21C6.02 15.02 6.01 14.39 6.01 13.72C4 14.09 3.48 13.23 3.32 12.78C3.23 12.55 2.84 11.84 2.5 11.65C2.22 11.5 1.82 11.13 2.49 11.12C3.12 11.11 3.57 11.7 3.72 11.94C4.44 13.15 5.59 12.81 6.05 12.6C6.12 12.08 6.33 11.73 6.56 11.53C4.78 11.33 2.92 10.64 2.92 7.58C2.92 6.71 3.23 5.99 3.74 5.43C3.66 5.23 3.38 4.41 3.82 3.31C3.82 3.31 4.49 3.1 6.02 4.13C6.66 3.95 7.34 3.86 8.02 3.86C8.7 3.86 9.38 3.95 10.02 4.13C11.55 3.09 12.22 3.31 12.22 3.31C12.66 4.41 12.38 5.23 12.3 5.43C12.81 5.99 13.12 6.7 13.12 7.58C13.12 10.65 11.25 11.33 9.47 11.53C9.76 11.78 10.01 12.26 10.01 13.01C10.01 14.08 10 14.94 10 15.21C10 15.42 10.15 15.67 10.55 15.59C13.71 14.53 16 11.53 16 8C16 3.58 12.42 0 8 0Z" transform="scale(64)" fill="#1B1F23"/>
            </svg>
        </a>
    </footer>

</body>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js" /></script>

<script type="text/javascript">
    var s = document.getElementById('shorter');
    var t = document.getElementById('threshold');
    console.log(s.checked);
    thresholdToggle();
    $("#select-all").click(function(event) {
        var checked = false;
        if (this.checked) {
            checked = true;
        } else {
            checked = false;
        }
        $(".city").each(function() {
            this.checked = checked;
        });
    });
    function thresholdToggle() {
        if (s.checked == true) {
            t.disabled = true;

        } else {
            t.disabled = false;
        }
    }
</script>

</html>