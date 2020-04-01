/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$('.check-all').click(function() {
	let target = $(this).data('target'),
		me = $(this);

	me.addClass('checked-all');

	$(target).find(':checkbox').each(function() {
		this.checked = true;
	});

	return false;
});

$('.uncheck-all').click(function() {
	let target = $(this).data('target'),
		me = $(this);

	me.removeClass('checked-all');
	
	$(target).find(':checkbox').each(function() {
		this.checked = false;
	});

	return false;
});