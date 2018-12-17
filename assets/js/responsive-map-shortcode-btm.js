(function ($) {
	
	$(function () {
		/**
		 * Added a button for entering a shortcode for responsive-map on the visual tab of the post entry screen.
		 */
		tinymce.create('tinymce.plugins.responsive_map_original_tinymce_button', {
			init: function (ed, url) {
				url = url.replace(/\/js/g, "");
				
				ed.addButton('responsive_map_recommended', {
					title: 'shortcode to display Google Maps.',
					image: url + '/images/googlemap-icon.png',
					cmd: 'responsive_map_recommended_cmd'
				});
				ed.addCommand('responsive_map_recommended_cmd', function () {
					var return_text = `[responsive_map width=${WIDTH} height=${HEIGHT} address=${ADDRESS} zoom=${ZOOM} border=${BORDER}]`;
					ed.execCommand('mceInsertContent', 0, return_text);
				});
			},
			createControl: function (n, cm) {
				return null;
			},
		});
		tinymce.PluginManager.add('responsive_map_original_tinymce_button_plugin', tinymce.plugins.responsive_map_original_tinymce_button);
	});
	
}(jQuery));
