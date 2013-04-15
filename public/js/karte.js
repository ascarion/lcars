var map;
var popup;
var Karte = {
	LoadMap: function () {
		map = L.map('map').setView([-70,-70], 3);
		L.tileLayer('img/map/{z}/{x}/{y}.png', {
			minZoom: 3,
			maxZoom: 6,
			tms: true,
			continuousWorld: true
		}).addTo(map);
		popup = L.popup();
		map.on('click', Karte.onMClick);
	},

	onMClick: function(e) {
		popup.setLatLng(e.latlng)
	    .setContent("Koordinaten hier: " + e.latlng.toString())
	    .openOn(map);
	}
}

$(document).ready(Karte.LoadMap);