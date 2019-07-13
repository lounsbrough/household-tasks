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

});