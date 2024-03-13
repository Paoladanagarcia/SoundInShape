$(function () {
	$("#decrease").click(function () {
		var value = parseInt($("#soundLevel").text());
		if (value > 30) {
			apply_modifier(-5);
		}
	});

	$("#increase").click(function () {
		var value = parseInt($("#soundLevel").text());
		if (value < 90) {
			apply_modifier(5);
		}
	});

	function apply_modifier(modifier) {
		$.post(
			DOMAIN_NAME + "/post-update-user-pref-noise",
			{
				pref_noise_modifier: modifier,
			},
			"json"
		)
			.done(({ message, status, redirect_to }) => {
				console.log("[Status] ", status);
				console.log("[Message] ", message);
				console.log("[Redirect to] ", redirect_to);

				$("#feedback").text(message);

				if (status === "success") {
					create_popup("green", "Success: " + message);
					console.info("Success: " + message);
				} else {
					create_popup("red", "Error: " + message);
					console.error("Error: " + message);
				}

				$("#soundLevel").text(
					parseInt($("#soundLevel").text()) + modifier
				);

				// Fetch new session
				$.get(DOMAIN_NAME + "/get-session-suggestion", (hours) => {
					$("#suggestedTime").text(hours);
				});
			})
			.fail(() => {
				create_popup("red", "Error: " + message);
				console.error("Error: " + message);
			});
	}
});
