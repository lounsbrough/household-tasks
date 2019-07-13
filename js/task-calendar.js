$(() => {

	var calendarEl = document.getElementById('task-calendar-div');

	var calendar = new FullCalendar.Calendar(calendarEl, {
		plugins: [ 'list', 'dayGrid' ],
		editable: true,
		eventLimit: true,
		defaultView: calendarView,
		events: {
		url: 'ajax/task-calendar-feed.php',
		method: 'GET'
		}
	});

	calendar.render();

	$("#set-list-view").click(() => {
		const view = 'listWeek';
		calendar.changeView(view);
		$.get(`ajax/session-update-calendar-view.php?calendar_view=${view}`);
	});

	$("#set-month-view").click(() => {
		const view = 'dayGridMonth';
		calendar.changeView(view);
		$.get(`ajax/session-update-calendar-view.php?calendar_view=${view}`);
	});

});