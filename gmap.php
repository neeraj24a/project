<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAxmD29mDTH4lGaO1IueTSmvyxFIFz1YHM'></script>
<div style='overflow:hidden;height:360px;width:1350px;'>
  <div id='gmap_canvas' style='height:360px;width:1350px;'></div>
  <style>
    #gmap_canvas img{max-width:none!important;background:none!important}
  </style>
</div> 
<a href='https://www.add-map.net/'>google maps widget for website</a> 
<script type='text/javascript' src='https://embedmaps.com/google-maps-authorization/script.js?id=cfc08dd02918ab26dc6fdbfc63f6eda9db892306'></script><script type='text/javascript'>function init_map(){var myOptions = {zoom:14,center:new google.maps.LatLng(19.072171139234626,72.9049500589356),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('gmap_canvas'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(19.072171139234626,72.9049500589356)});infowindow = new google.maps.InfoWindow({content:'<strong>Naturaxion</strong><br><br>400098 Mumbai<br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
