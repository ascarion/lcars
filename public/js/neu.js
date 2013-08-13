jQuery(document).ready(function($) {


	$('#char-rang').typeahead({
		source: function (query, process) {
			raenge = [];
			map = {};

			$.get('/spieler/json/raenge', function(data) {
				$.each(data, function(i, rang) {
					map[rang.name] = rang;
					raenge.push(rang.name);
				});

				process(raenge);
			});
		},
		updater: function(item) {
			$('#char-rang-id').val(map[item].id);
			return item;
		}
	});
});