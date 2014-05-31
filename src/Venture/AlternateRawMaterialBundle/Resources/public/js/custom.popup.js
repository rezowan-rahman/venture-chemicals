jQuery(document).ready(function(e) {
	jQuery('button.popUpButton').on('click', function(e) {
		e.preventDefault();
		jQuery('div#popUp').bPopup({
			contentContainer:'.popUpContent',
		});
	});
});