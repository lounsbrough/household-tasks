$(function() {

	$(".fa-task-option").click(function() {
		if ($(this).prop("id") == "fa-task-complete") {
			$("#task-action-button").html('Complete <i class="fa fa-check"></i>').addClass("btn-success").removeClass("btn-warning");
		} else {
			$("#task-action-button").html('Snooze <i class="fa fa-clock-o"></i>').addClass("btn-warning").removeClass("btn-success");
		}
		$(".fa-task-option").each(function() {
			$(this).removeClass("fa-selected").addClass("fa-unselected");
			$(this).closest(".task-action-div").find("input,select").prop("disabled",true).css({opacity:"0.3"});
		});
		$(this).removeClass("fa-unselected").addClass("fa-selected");
		$(this).closest(".task-action-div").find("input,select").prop("disabled",false).css({opacity:"1"});
	});

	$("#select-person").change(function() {
		$.get("ajax/session-update-person-key.php?person_key="+$(this).val());
	});

	$("#task-action-button").click(function() {

		if ($("#fa-task-complete").hasClass("fa-selected")) {

			swal({
			    title: "Complete Task?",
				text: "",
				showCancelButton: true,
				confirmButtonColor: "#5cb85c",
				confirmButtonText: "Complete",
				animation: "slide-from-top",
				closeOnConfirm: false
			}, function(isConfirm) {
				if (isConfirm) {
					$.get("ajax/complete-task.php?"+$("#task-details-form").serialize())
					.done(function() {
						window.location.replace("task-calendar.php");
					})
					.fail(function() {
						swal({
							title: "Error",
							text: "",
							type: "error"
						});
					});
					swal({
						title: "Complete",
						text: "",
						type: "success",
						showConfirmButton: false
					});
					$(".sweet-alert .sa-icon.sa-success").css({"border-color":"#5cb85c"});
					$(".sweet-alert .sa-icon.sa-success .sa-line").css({"background-color":"#5cb85c"});
					$(".sweet-alert .sa-icon.sa-success .sa-placeholder").css({"border":"4px solid rgba(92,184,92,0.5)"});
				}
			});

		} else {

			swal({
			    title: "Snooze Task?",
				text: "",
				showCancelButton: true,
				confirmButtonColor: "#f0ad4e",
				confirmButtonText: "Snooze",
				animation: "slide-from-top",
				closeOnConfirm: false
			}, function(isConfirm) {
				if (isConfirm) {
					$.get("ajax/snooze-task.php?"+$("#task-details-form").serialize())
					.done(function() {
						window.location.replace("task-calendar.php");
					})
					.fail(function() {
						swal({
							title: "Error",
							text: "",
							type: "error"
						});
					});
					swal({
						title: "Snoozed",
						text: "",
						type: "success",
						showConfirmButton: false
					});
					$(".sweet-alert .sa-icon.sa-success").css({"border-color":"#f0ad4e"});
					$(".sweet-alert .sa-icon.sa-success .sa-line").css({"background-color":"#f0ad4e"});
					$(".sweet-alert .sa-icon.sa-success .sa-placeholder").css({"border":"4px solid rgba(240,173,78,0.5)"});
				}
			});

		}

	});

});