$(document).ready(function () {
	"use strict";

	$("form").each(function () {
		$(this)
			.off("submit")
			.submit((event) => {
				event.preventDefault();
				event.stopPropagation();

				const targetUrl = $(this).attr("action");
				const formContents = {};

				console.log("Form submitted to", targetUrl);

				$(this)
					.find(":input")
					.each(function () {
						if (
							$(this).attr("type") !== "submit" &&
							$(this).attr("type") !== "button"
						) {
							let value;
							if ($(this).attr("type") === "checkbox") {
								value = $(this).prop("checked") ? 1 : 0;
							} else if ($(this).is("select")) {
								value = $(this).find("option:selected").val();
							} else {
								value = $(this).val();
							}
							formContents[$(this).attr("name")] = value;
						}
					});

				$.post(targetUrl, formContents, "json").done(
					({ message, status, redirect_to }) => {
						console.log("[Status] ", status);
						console.log("[Message] ", message);
						console.log("[Redirect to] ", redirect_to);

						$("#feedback").text(message);
						if (status === "success") {
							console.info("Success: " + message);
							create_popup("green", "Success: " + message);
						} else {
							console.error("Error: " + message);
							create_popup("red", "Error: " + message);
						}

						if (redirect_to) {
							window.location.href = redirect_to;
						}
					}
				);
			});
	});
});
