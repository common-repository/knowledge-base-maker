function YkbSearchBar() {
	this.init();
}

YkbSearchBar.prototype.init = function () {
	this.search();
};

YkbSearchBar.prototype.search = function () {
	var searchButton = jQuery('.ykb-search-button');

	if (!searchButton.length) {
		return false;
	}
	var that = this;

	searchButton.bind('click', function () {
		var searchText = jQuery('.ykb-search-input').val();
		var currentButton = jQuery(this);
		that.searchText(searchText, currentButton);
	});
};

YkbSearchBar.prototype.searchText = function(searchValue, currentButton) {
	var data = {
		action: 'ykb_search_data',
		value: searchValue,
		beforeSend: function () {
			currentButton.text(currentButton.data('progress-label'));
			currentButton.prop('disabled', true);
		},
		nonce: YKB_ARGS.nonce
	};

	jQuery.post(YKB_ARGS.ajaxurl, data, function(response) {
		var searchResult = jQuery('.ykb-search-result');
		if (!searchResult.length) {
			return false;
		}
		currentButton.prop('disabled', false);
		currentButton.text(currentButton.data('label'));
		searchResult.removeClass('ykb-hide');
		searchResult.html(response);
	});
};

jQuery(document).ready(function () {
	new YkbSearchBar();
});