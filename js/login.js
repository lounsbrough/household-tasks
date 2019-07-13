$(() => {

	$("#login-form").submit((e) => {
		e.preventDefault();
		
		$.get(`ajax/session-validate-password.php?password=${$("#password").val()}`);
		location.href = "task-calendar.php";
	});

});