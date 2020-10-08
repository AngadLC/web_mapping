<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP web data base</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
   <script src="./pokharahospital.js"></script>
   <!-- adding atms -->
   <script src="./atm11.js"></script>
   <!-- cluster -->
   <link rel="stylesheet" href="./Leaflet.markercluster-master/dist/MarkerCluster.css">
   <link rel="stylesheet" href="./Leaflet.markercluster-master/dist/MarkerCluster.Default.css">
   <script src="./Leaflet.markercluster-1.4.1/dist/leaflet.markercluster.js"></script>
   <!-- switching to different layers -->
   <style>
   #mapid { 
        
       margin-top:50px;
       height: 380px;
       width: 80%;
       align-item:center; }
   </style>
    <style>
   #map2 { 
        
       margin-top:50px;
       height: 380px;
       width: 80%;
       align-item:center; }
   </style>
</head>
<body>
<div id="mapid"></div>

<div id="map2"></div>
<script>
      var map = L.map('mapid').setView([28.2096, 83.9856], 11);
      L.tileLayer('https://api.maptiler.com/maps/basic/{z}/{x}/{y}.png?key=gAWMvq9FjPXEk2IN9TQf',{
        tileSize: 512,
        zoomOffset: -1,
        minZoom: 1,
        attribution: "\u003ca href=\"https://www.maptiler.com/copyright/\" target=\"_blank\"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e",
        crossOrigin: true
      }).addTo(map);
      // for base maps
      // adding clustring
      var markers = L.markerClusterGroup();

      //adding the atms
      var atmpkr = L.geoJSON(atm123, {
        onEachFeature:function(feature, layer){
            layer.bindPopup(feature.properties.tags.name)
        }
      }
        
      );
      // clustring fro atm
      atmpkr.addTo(markers);
      map.addLayer(markers);
      //adding json file
      var geo = L.geoJSON(dataview, {
        onEachFeature:function(feature, layer){
            layer.bindPopup(feature.properties.tags.name)
        }
      }
        
      )
      geo.addTo(markers);
map.addLayer(markers);
var map21 = L.map('map2').setView([28.2096, 83.9856], 11);
L.tileLayer('https://api.maptiler.com/maps/basic/{z}/{x}/{y}.png?key=gAWMvq9FjPXEk2IN9TQf',{
        tileSize: 512,
        zoomOffset: -1,
        minZoom: 1,
        attribution: "\u003ca href=\"https://www.maptiler.com/copyright/\" target=\"_blank\"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e",
        crossOrigin: true
      }).addTo(map21)   
     
       </script>
       <!-- lets switch to the different layers in just the click -->
       
       <?php
    /*lets connect the data base*/

    $dbconnection = pg_connect("host=localhost port=5432 dbname=pokhara user=postgres password=angad") or die('connpt connecr'.pg_last_error());
   /* $query = 'SELECT gid, osm_id, code, fclass, name, ST_X(geom), ST_Y(geom) FROM atm';
    $result = pg_query($query)  or die('query failed');
    while($line = pg_fetch_row($result)){
        $longitudeview = $line[5];
        $latitudeview = $line[6];
        $address = $line[3]. ",". $line[4];
        echo "<script> var abc=  L.marker([$latitudeview, $longitudeview]).bindPopup('<b>".$address."');</script>";
       echo "<script> abc.addTo(markers);</script>";
       echo "<script> map.addLayer(markers);</script>";
    
    };*/
    /*
   # <!-- get the latitude and longation of the user  -->
    require_once('geoplugin.class.php');

$geoplugin = new geoPlugin();
$geoplugin->locate();

  $lat = $geoplugin->latitude;
  $long = $geoplugin->longitude;
  echo $lat;
  echo $long;*/
  #this is comment because laptop does not have any particular location 
#finding atm within the distance
?>
<script>
  var marker = L.markerClusterGroup();
</script>
<?php
$query2 = 'SELECT name, ST_X(geom), ST_Y(geom) FROM atm WHERE ST_DWithin(geom, ST_MakePoint(83.9453,28.2154)::geography,2000)';
$result2 = pg_query($query2)  or die('query failed');

while($line2 = pg_fetch_row($result2)){
  
  $longitude = $line2[1];
  $latitude = $line2[2];
  $name=  $line2[0];
#  echo $longitude;
 # echo $latitude;
 # echo $name;
  echo "<script> var a =  L.marker([$latitude,$longitude]).bindPopup('<b>".$name."');</script>";
  echo "<script> a.addTo(marker);</script>";
  echo "<script> map21.addLayer(marker);</script>";
};
    pg_close($dbconnection);
    ?>
   
  
    
</body>
</html>