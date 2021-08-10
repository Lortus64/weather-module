<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/css/ol.css" type="text/css">
    <style>
      .map {
        height: 400px;
        width: 100%;
      }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/build/ol.js"></script>
</head>

<h1>Weather</h1>
<p>Skriv in en ip eller longitud och latitud för att se platsens väder historik.</p>

<form method="post">
    IP: <input type="text" name="ip">
    Longitud: <input type="text" name="lon">
    Latitud: <input type="text" name="lat">
    <input type="submit" value="Validera">
</form>

<div id="map" class="map"></div>

<?php if ($info) : ?>
    <p><?= $info ?></p>
<?php endif; ?>

<?php if ($result) : ?>
    <?php foreach ($result as $key => $value) : ?>

        <h2><?= date('Y-m-d', $value["current"]["dt"]) ?></h2>
        <p>Soluppgång: <?= date('h:i', $value["current"]["sunrise"]) ?> AM</p>
        <p>Solnedgång: <?= date('h:i', $value["current"]["sunset"]) ?> PM</p>
        <p>Temp: <?= $value["current"]["temp"] ?>C</p>
        <p>Väder: <?= $value["current"]["weather"][0]["main"] ?></p>
        
        <br>
    <?php endforeach; ?>
    
<?php endif; ?>

<h1>Ip Validator REST api</h1>

<p>För att få vädret på en plats gör du en call till</p>
<p>POST: http://www.student.bth.se/~adei18/dbwebb-kurser/ramverk1/me/redovisa/htdocs/weatherREST</p>
<p>Body måste antingen ha en ip eller latitud och longitud.</p>
<p>Body ip="ip du vill veta väder på"</p>
<p>Body lon="longitud" lat="latitud"</p>
<p>Om både cordinater och ip är angivna kommer vädret baseras på ip.</p>

<?php if ($result) : ?>
    <script type="text/javascript">
        if ("<?php echo $result[0]['lat']; ?>" != "") {
            var lat = "<?php echo $result[0]['lat']; ?>";
            var lon = "<?php echo $result[0]['lon']; ?>";
            var map = new ol.Map({
                    target: 'map',
                    layers: [
                        new ol.layer.Tile({
                            source: new ol.source.OSM()
                    })
                    ],
                    view: new ol.View({
                        center: ol.proj.fromLonLat([lon, lat]),
                        zoom: 10
                    })
                });
        }
    </script>
<?php endif; ?>
