(function(window,$){
	window.LaravelDataTables=window.LaravelDataTables||{};
	String.prototype.asId = function() {
	  var th = $(%1$s).find('thead th');
	  for (var i=0, l=th.length; i<l; i++) {
	    if (th[i].textContent == this.toString()) return i;
	  }
	}
	window.LaravelDataTables["%1$s"]=$("#%1$s").DataTable(Object.assign(%2$s, {
		order: [['Created At'.asId(), 'asc']]
	}));
	window.LaravelDataTables["%1$s"].on('draw', function(e) {
		confirm_dialog();
	});
	window.LaravelDataTables["%1$s"].one('draw', function(e) {
		let wrapper = $(e.currentTarget).parent(),
			card = wrapper.closest('.card'),
			buttons = wrapper.find('.dt-buttons'),
			filter = wrapper.find('.dataTables_filter'),
			info = wrapper.find('.dataTables_info'),
			paging = wrapper.find('.dataTables_paginate');

		buttons.find('.btn-group button').unwrap();
		buttons.find('.btn').addClass('mr-1 btn-dark shadow-none');
		buttons.find('.btn').removeClass('btn-secondary');
		buttons.removeClass('btn-group');

		wrapper.prepend($('<div/>', {
			class: 'p-3 row align-items-center'
		})
			.append(buttons.addClass('col-lg-6'))
			.append(filter.addClass('col-lg-6'))
		);

		wrapper.append($('<div/>', {
			class: 'p-3 row align-items-center'
		})
			.append(info.addClass('col-lg-6'))
			.append(paging.addClass('col-lg-6'))
		);
	});
})(window,jQuery);
