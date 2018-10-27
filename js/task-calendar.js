$(function() {

	var calendarOptions = {
			events_source: 'ajax/task-calendar-feed.php',
			view: calendarView,
			tmpl_path: tmpl_path,
			tmpl_cache: false,
			onAfterEventsLoad: function(events) {
				if(!events) {
					return;
				}
				var list = $('#eventlist');
				list.html('');

				$.each(events, function(key, val) {
					$(document.createElement('li'))
						.html('<a href="' + val.url + '">' + val.title + '</a>')
						.appendTo(list);
				});
			},
			onAfterViewLoad: function(view) {
				$('.page-header h3').text(this.getTitle());
				$('.btn-group button').removeClass('active');
				$('button[data-calendar-view="' + view + '"]').addClass('active');
			},
			classes: {
				months: {
					general: 'label'
				}
			},
			views: {
				month: {
					slide_events: 1,
					enable: 1
				},
				week: {
					enable: 1
				},
				day: {
					enable: 1
				}
			}
		};

	var taskCalendar = $("#task-calendar-div").calendar(calendarOptions);

	$('.btn-group button[data-calendar-nav]').each(function() {
		$(this).click(function() {
			taskCalendar.navigate($(this).data('calendar-nav'));
		});
	});

	$('.btn-group button[data-calendar-view]').each(function() {
		$(this).click(function() {
			taskCalendar.view($(this).data('calendar-view'));
			$.get("ajax/session-update-calendar-view.php?calendar_view="+$(this).data('calendar-view'));
		});
	});

});