;(function(panor) {
	var time_animation = 500;
	class Search
	{
		constructor()
		{
			this.savedSearchLoaded = false;

			this.settings = {
				form: null,

				deleteSearchContainer: '._delete_search',
				saveSearch: '._save_search',
				savedSearch: '._saved_search',
				savedSearchDelete: '._saved_search_delete',
				savedSearchApply: '._saved_search_apply',
				savedSearchContainer: '._saved_search_container',
			}

			this.isExtendHandler = function() {
				throw new Error("Not implemented");
			}
			this.toggleExtendHandler = function() {
				throw new Error("Not implemented");
			}
		}
		// расширенный поиск
		isExtend()
		{
			return this.isExtendHandler.call(this);
		}
		// переключить режим поиска
		toggleExtend()
		{
			return this.toggleExtendHandler.call(this);
		}
		// получить данный формы поиска
		getFormData()
		{
			var data;
			data = this.settings.form.serializeArray();
	        data = data.filter(function(item){
	            return item.value;
	        });
			if (this.isExtend()) {
				data.push({
					name: 'extend',
					value: '1',
				});
			}
			return data;
		}
		// загрузить сохраненные поиски
		loadSavedSearch()
		{
			var _this = this;
			if (!this.savedSearchLoaded) {
		        load(
		        	'/search/save',
		        	this.settings.savedSearchContainer,
		        	function() {
		            	_this.savedSearchLoaded = true;
		        	}
		        );
		    }
		}
		// показать сохранение поиска
		showSearchSave()
		{
			$(this.settings.saveSearch).show();
		    this.hideSearchDelete();
		}
		// скрыть сохранение поиска 
		hideSearchSave()
		{
			$(this.settings.saveSearch).hide();
		}
		// показать удаление поиска
		showSearchDelete(id)
		{
			$(this.settings.deleteSearchContainer).data('id', id).show();
		    this.settings.form.find('[name=searchID]').val(id);
		   	this.hideSearchSave();
		}
		// скрыть удаление поиска
		hideSearchDelete(){
			$(this.settings.deleteSearchContainer).find('[name=searchID]').val('');
			$(this.settings.deleteSearchContainer).data('id', '').hide();
		}
		// сбросить форму
		resetForm()
		{
			this.settings.form.find('input').each(function(i,item) {
		        if (['checkbox', 'radio'].indexOf($(item).attr('type')) != -1) {
		            $(item).removeAttr('checked');
		        } else {
		            $(item).val('');
		        }
		    });
		    this.settings.form.find('select').each(function(i,item) {
		        $(item).find('option').removeAttr('selected');
		    });

		    this.hideSearchSave();
		    this.hideSearchDelete();
		}
		// удалить сохраненный поиск
		deleteSavedSearch(id)
		{
		    var savedSearch = $(this.settings.savedSearch+'[data-id='+id+']');
		    var btn = savedSearch.find(this.settings.savedSearchDelete);
		    var data = {
		        action: 'delete',
		        id: id,
		    };
		    var _this= this;
		    ajax('/search/delete', data, function(res){
		        if (res.ids) {
		            res.ids.forEach(function(id){
		                var savedSearch = $(_this.settings.savedSearch+'[data-id='+id+']');
		                savedSearch.slideUp(time_animation, function(){
		                    savedSearch.remove();
		                });
		            });
		        } else {
		            savedSearch.slideUp(time_animation, function(){
		                savedSearch.remove();
		            });
		        }
		        _this.hideSearchDelete();
		    }, 
		    function(msg){
		    	alert('smth like error happens');
		        // notice(msg, 'error', btn, {position: 'right middle'});
		    });
		}
		// применить сохраненный поиск
		applySavedSearch(id)
		{
		    this.resetForm();

		    var savedSearch = $(this.settings.savedSearch+'[data-id='+id+']');
		    var data = savedSearch.data();
		    console.log(data);
		    for(var key in data) {
		        if (key == 'extend') {
		            if (!this.isExtend()) this.toggleExtend();
		        } else {
		            var elem = this.settings.form.find('[name='+key+']');
		            if (!elem.length) continue;
		            if (elem.attr('type') == 'checkbox' || elem.attr('type') == 'radio') {
		                elem = this.settings.form.find('[name='+key+'][value='+data[key]+']');
		                elem.prop('checked', true);
		            } else if (elem.get(0).tagName == 'SELECT') {
		                elem.val(data[key]);
		            } else {
		                elem.val(data[key]);
		            }
		        }
		    }
		    // notice(
		    // 	MESS.FILTER_APPLIED,
		    // 	'success',
		    // 	savedSearch.find(this.settings.savedSearchApply),
		    // 	{position: 'bottom left'}
		    // );
		    this.hideSearchSave();
		    this.showSearchDelete(id);
		}
		// сохранить поиск
		saveSearch()
		{
		    var data = {
		        action: 'save',
		        data: this.getFormData(),
		    }
		    var _this = this;
		    ajax(
		    	'save-search',
		    	data, 
		    	function(res) 
		    	{
		    		alert('Поиск упешно сохранен');
			        _this.savedSearchLoaded = false;

			        _this.hideSearchSave();
			        _this.showSearchDelete(res.ID);

			        // notice(
			        // 	MESS.SEARCH_SAVED,
			        // 	'success',
			        // 	$(_this.settings.deleteSearchContainer),
			        // 	{
			        // 		position: 'bottom left',
			        // 	}
			        // );
			    },
		    	function(msg) 
		    	{
		        	// notice(msg, 'error', $(_this.settings.saveSearch), {position: 'bottom center'});
		    	}
		    );
		}

	}

	panor.search = new Search();
})(window.P);
