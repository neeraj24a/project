<?php
/* @var $this CompaniesController */
/* @var $model Companies */
/* @var $form CActiveForm */
?>
<style>
/* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      .map {
        height: 400px;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      .map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input, #kc-pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
		margin-top: 10px;
      }

      #pac-input:focus,, #kc-pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 345px;
      }
	  #mapCanvas, #kcMapCanvas {
		height: 400px;
		float: left;
		width: 100%;
	  }
      #infoPanel, #kcPanel {
		float: left;
		margin-left: 10px;
      }
	  #infoPanel div, #kcPanel div {
		margin-bottom: 5px;
	  }
</style>
<div class="panel panel-default">
    <div class="panel-heading">Company Addition Form</div>
    <div class="panel-body">
        <div class="row">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'companies-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>true,
			)); ?>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'first_name'); ?>
						<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'first_name'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'last_name'); ?>
						<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'last_name'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<h3>Search & Place Your Marker in map for exact address location of your company</h3>
				<input id="pac-input" class="form-control" type="text" placeholder="Search Box">
				<div class="row" id="map">
					<div id="mapCanvas"></div>
					  <div id="infoPanel">
						<b>Closest matching address:</b>
						<div id="address"></div>
					  </div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-12">
					<div class="form-group">
						<?php echo $form->labelEx($model,'profile_pic'); ?>
						<?php echo $form->fileField($model,'profile_pic',array('class'=>'form-control')); ?>
						<?php echo $form->error($model,'profile_pic'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'jewish'); ?>
						<?php echo $form->dropDownList($model,'jewish',array('yes' => 'Yes','no' => 'No', 'unknown' => 'Unknown'),array('empty' => 'Select Jewish','class'=>'form-control')); ?>
						<?php echo $form->error($model,'jewish'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'url'); ?>
						<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'url'); ?>
					</div>
				</div>
				
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'address'); ?>
						<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'address'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'address2'); ?>
						<?php echo $form->textField($model,'address2',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'address2'); ?>
					</div>
				</div>
				
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'city'); ?>
						<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'city'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'state'); ?>
						<?php echo $form->textField($model,'state',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'state'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'country'); ?>
						<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'country'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'zip'); ?>
						<?php echo $form->textField($model,'zip',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'zip'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'lat'); ?>
						<?php echo $form->textField($model,'lat',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'lat'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'lng'); ?>
						<?php echo $form->textField($model,'lng',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'lng'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'email'); ?>
						<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'email'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'email2'); ?>
						<?php echo $form->textField($model,'email2',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'email2'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'phone'); ?>
						<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>12,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'phone'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'phone2'); ?>
						<?php echo $form->textField($model,'phone2',array('size'=>60,'maxlength'=>12,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'phone2'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'phone3'); ?>
						<?php echo $form->textField($model,'phone3',array('size'=>60,'maxlength'=>12,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'phone3'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'contract_type'); ?>
						<?php echo $form->dropDownList($model,'contract_type',array('R'=>'Regular','PL'=>'Private'),array('class'=>'form-control')); ?>
						<?php echo $form->error($model,'contract_type'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<h3>Search & Place Your Marker in map for exact address location of your KC</h3>
				<input id="kc-pac-input" class="form-control" type="text" placeholder="Search Box">
				<div class="row map">
					<div id="kcMapCanvas"></div>
					  <div id="kcPanel">
						<b>Closest matching address:</b>
						<div id="kc-address"></div>
					  </div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'kc_address'); ?>
						<?php echo $form->textField($model,'kc_address',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'kc_address'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'kc_address2'); ?>
						<?php echo $form->textField($model,'kc_address2',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'kc_address2'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'kc_city'); ?>
						<?php echo $form->textField($model,'kc_city',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'kc_city'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'kc_state'); ?>
						<?php echo $form->textField($model,'kc_state',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'kc_state'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'kc_country'); ?>
						<?php echo $form->textField($model,'kc_country',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'kc_country'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'kc_zip'); ?>
						<?php echo $form->textField($model,'kc_zip',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'kc_zip'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'kc_lat'); ?>
						<?php echo $form->textField($model,'kc_lat',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'kc_lat'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'kc_lng'); ?>
						<?php echo $form->textField($model,'kc_lng',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'kc_lng'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-12">
					<div class="form-group">
						<?php echo $form->labelEx($model,'kc_comp_notes'); ?>
						<?php echo $form->textArea($model,'kc_comp_notes',array('class'=>'form-control')); ?>
						<?php echo $form->error($model,'kc_comp_notes'); ?>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="form-group">
						<?php echo $form->labelEx($model,'overview'); ?>
						<?php echo $form->textArea($model,'overview',array('class'=>'form-control')); ?>
						<?php echo $form->error($model,'overview'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'ar'); ?>
						<?php echo $form->textField($model,'ar',array('class'=>'form-control')); ?>
						<?php echo $form->error($model,'ar'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'rc'); ?>
						<?php echo $form->textField($model,'rc',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'rc'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'admin'); ?>
						<?php echo $form->textField($model,'admin',array('class'=>'form-control')); ?>
						<?php echo $form->error($model,'admin'); ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<?php echo $form->labelEx($model,'active'); ?>
						<?php echo $form->dropDownList($model,'active',array('yes'=>'Yes','no'=>'No'),array('class'=>'form-control')); ?>
						<?php echo $form->error($model,'active'); ?>
					</div>
				</div>
			</div>
			<div class="col-lg-12 m-t-20">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class' => 'mb-sm btn btn-info')); ?>
				<a href="<?php echo Yii::app()->createUrl("admin/companies"); ?>" class="mb-sm btn btn-warning pull-right">Back</a>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDuOw50IlupgaDKE9tvEBMgvxMed9qli4M&sensor=false&libraries=places"></script>
<script type="text/javascript">
var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
		//updateMarkerAddress(responses[0].formatted_address);
		$("#Companies_lat").val(pos.lat());
		$("#Companies_lng").val(pos.lng());
		$.each(responses[0].address_components, function(key,val){
			$.each(val.types, function(k,v){
				if(v == "route"){
					$("#Companies_address").val(val.long_name);
				} else if (v == "sublocality_level_3" && $("#Companies_address").val() == "") {
					$("#Companies_address").val(val.long_name);
				} else if(v == "sublocality_level_3" && $("#Companies_address").val() != "") {
					$("#Companies_address2").val(val.long_name);
				} else if (v == "sublocality_level_2" && $("#Companies_address").val() == "") {
					$("#Companies_address").val(val.long_name);
				} else if (v == "sublocality_level_2" && $("#Companies_address").val() != "") {
					$("#Companies_address2").val(val.long_name);
				} else if (v == "sublocality_level_1" && $("#Companies_address").val() == "") {
					$("#Companies_address").val(val.long_name);
				} else if (v == "sublocality_level_1" && $("#Companies_address").val() != "") {
					$("#Companies_address2").val(val.long_name);
				} else if(v === "administrative_area_level_2"){
					$("#Companies_city").val(val.long_name);
				} else if(v === "administrative_area_level_1"){
					$("#Companies_state").val(val.long_name);
				} else if(v === "country"){
					$("#Companies_country").val(val.long_name);
				} else if(v === "postal_code"){
					$("#Companies_zip").val(val.long_name);
				}
			});
		});
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function updateMarkerStatus(str) {
  document.getElementById('markerStatus').innerHTML = str;
}

function geocodeKcPosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
		//updateMarkerAddress(responses[0].formatted_address);
		$("#Companies_kc_lat").val(pos.lat());
		$("#Companies_kc_lng").val(pos.lng());
		$.each(responses[0].address_components, function(key,val){
			$.each(val.types, function(k,v){
				if(v == "route"){
					$("#Companies_kc_address").val(val.long_name);
				} else if (v == "sublocality_level_3" && $("#Companies_kc_address").val() == "") {
					$("#Companies_kc_address").val(val.long_name);
				} else if(v == "sublocality_level_3" && $("#Companies_kc_address").val() != "") {
					$("#Companies_kc_address2").val(val.long_name);
				} else if (v == "sublocality_level_2" && $("#Companies_kc_address").val() == "") {
					$("#Companies_kc_address").val(val.long_name);
				} else if (v == "sublocality_level_2" && $("#Companies_kc_address").val() != "") {
					$("#Companies_kc_address2").val(val.long_name);
				} else if (v == "sublocality_level_1" && $("#Companies_kc_address").val() == "") {
					$("#Companies_kc_address").val(val.long_name);
				} else if (v == "sublocality_level_1" && $("#Companies_kc_address").val() != "") {
					$("#Companies_kc_address2").val(val.long_name);
				} else if(v === "administrative_area_level_2"){
					$("#Companies_kc_city").val(val.long_name);
				} else if(v === "administrative_area_level_1"){
					$("#Companies_kc_state").val(val.long_name);
				} else if(v === "country"){
					$("#Companies_kc_country").val(val.long_name);
				} else if(v === "postal_code"){
					$("#Companies_kc_zip").val(val.long_name);
				}
			});
		});
    } else {
      updateKcMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function updateKcMarkerAddress(str) {
  document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {
  document.getElementById('info').innerHTML = [
    latLng.lat(),
    latLng.lng()
  ].join(', ');
}

function updateMarkerAddress(str) {
  document.getElementById('address').innerHTML = str;
}
function updateKcMarkerAddress(str) {
  document.getElementById('kc-address').innerHTML = str;
}

function initialize() {
  var latLng = new google.maps.LatLng(42.86878055608344, -76.10512355781253);
  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 7,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  //var marker = '';
  var marker = new google.maps.Marker({
    position: latLng,
    title: 'Point A',
    map: map,
    draggable: true
  });

  // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });
		google.maps.event.addListener(map, 'click', function(event) {
			if (marker && marker.setMap) {
				marker.setMap(null);
			}
			marker = new google.maps.Marker({position: event.latLng, map: map, draggable: true});
			//updateMarkerPosition(event.latLng);
			geocodePosition(event.latLng);
		});
		google.maps.event.addListener(marker, 'dragend', function() {
			geocodePosition(marker.getPosition());
		});
		var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          marker.setMap(null);
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
		});
 }

 function kcInitialize() {
  var latLng = new google.maps.LatLng(42.86878055608344, -76.10512355781253);
  var map = new google.maps.Map(document.getElementById('kcMapCanvas'), {
    zoom: 7,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  //var marker = '';
  var marker = new google.maps.Marker({
    position: latLng,
    title: 'Point A',
    map: map,
    draggable: true
  });

  // Create the search box and link it to the UI element.
        var input = document.getElementById('kc-pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });
		google.maps.event.addListener(map, 'click', function(event) {
			if (marker && marker.setMap) {
				marker.setMap(null);
			}
			marker = new google.maps.Marker({position: event.latLng, map: map, draggable: true});
			//updateMarkerPosition(event.latLng);
			geocodeKcPosition(event.latLng);
		});
		google.maps.event.addListener(marker, 'dragend', function() {
			geocodeKcPosition(marker.getPosition());
		});
		var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          marker.setMap(null);
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
		});
 }
// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
google.maps.event.addDomListener(window, 'load', kcInitialize);
</script>