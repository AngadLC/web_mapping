<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokhara hospital</title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
   <style>
   #mapid { 
       margin-top:50px;
       height: 380px; }
   </style>
 <script src="../dist/leaflet.customsearchbox.min.js"></script>
<link href="../dist/searchbox.min.css" rel="stylesheet" />
<link href="https://google.github.io/material-design-icons/">
<link href="../dist/searchbox.css" rel="stylesheet" />
</head>
<link rel="stylesheet" href="./leaflet-control-osm-geocoder-master/Control.OSMGeocoder.css">
<script src="./leaflet-control-osm-geocoder-master/Control.OSMGeocoder.js"></script>
<body>

    <div id="mapid"></div>
    <script>
      var map = L.map('mapid').setView([28.2096, 83.9856], 11);
      L.tileLayer('https://api.maptiler.com/maps/basic/{z}/{x}/{y}.png?key=gAWMvq9FjPXEk2IN9TQf',{
        tileSize: 512,
        zoomOffset: -1,
        minZoom: 1,
        attribution: "\u003ca href=\"https://www.maptiler.com/copyright/\" target=\"_blank\"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e",
        crossOrigin: true
      }).addTo(map);

      </script>
      <?php
      $dbconnection = pg_connect("host=localhost port=5432 dbname=Real-world user=postgres password=angad") or die('connpt connecr'.pg_last_error());
      $query = 'SELECT ST_X(geom), ST_Y(geom) FROM pokharahospital';
      $result = pg_query($query) or die("failed");
      while($line = pg_fetch_row($result)){
          $longitudeview = $line[0];
          $latitudeview = $line[1];
          echo "<script> L.marker([$latitudeview, $longitudeview]).addTo(map)</script>";
      }
      
      
      ?>
    <script >
     

var osmGeocoder = new L.Control.OSMGeocoder();

map.addControl(osmGeocoder);
var options = {
    collapsed: true, /* Whether its collapsed or not */
    position: 'topright', /* The position of the control */
    text: 'Locate', /* The text of the submit button */
    placeholder: '', /* The text of the search input placeholder */
    bounds: null, /* a L.LatLngBounds object to limit the results to */
    email: null, /* an email string with a contact to provide to Nominatim. Useful if you are doing lots of queries */
    callback: function (results) {
			var bbox = results[0].boundingbox,
				first = new L.LatLng(bbox[0], bbox[2]),
				second = new L.LatLng(bbox[1], bbox[3]),
				bounds = new L.LatLngBounds([first, second]);
			this._map.fitBounds(bounds);
    }
};

    </script>
</body>
</html>