let ChartView = {
	dom_container: null,
	chart: null,
	number_of_refresh: 0,
	x_data: [],
	y_data: [],

	// Init dom_container, prevent form submission, set onchange event, refresh
	init: function (dom_container_id) {
		this.dom_container = $("#" + dom_container_id);

		this.dom_container.find(".form-select-stats").submit(function (e) {
			e.preventDefault();
			e.stopPropagation();
		});

		this.dom_container.find(".stats_type").on("change", () => {
			// Hide sensor select when looking for people, and not noise
			if (this.get_stats_type() == "people") {
				this.dom_container.find(".container-select-sensor").hide();
			} else {
				this.dom_container.find(".container-select-sensor").show();
			}
			this.refresh();
		});

		this.dom_container.find(".sensor_id").on("change", () => {
			this.refresh();
		});

		this.dom_container.find(".session_id").on("change", () => {
			this.refresh();
		});

		this.dom_container.find(".max_points").on("change", () => {
			this.refresh();
		});

		this.refresh();
	},

	// Fetch (x, y), update (x, y)
	fetch_data: function () {
		return new Promise((resolve, reject) => {
			let sensor_id = this.get_sensor_id();
			let session_id = this.get_session_id();
			let max_points = this.get_max_points();

			// Check user form data
			let msg = "";
			if (!sensor_id && !session_id) {
				msg =
					"Merci de sélectionner au moins une session (ou un capteur).";
			} else if (max_points < 0 || max_points > 500) {
				msg =
					"Merci de sélectionner un nombre de points entre 0 et 500.";
			} else {
				this.dom_container.find(".form-select-stats-feedback").text("");
			}

			if (msg) {
				this.dom_container
					.find(".form-select-stats-feedback")
					.text(msg);
				if (this.number_of_refresh > 1) {
					create_popup("red", msg);
				}
			}

			let get_params = {
				stats_type: this.get_stats_type(),
				max_points: max_points,
			};
			if (sensor_id && this.get_stats_type() == "noise")
				get_params.sensor_id = sensor_id;
			if (session_id) get_params.session_id = session_id;

			$.get(DOMAIN_NAME + "/stats/get", get_params)
				.done((data) => {
					this.x_data = data.x;
					this.y_data = data.y;
					resolve();
				})
				.fail((data) => {
					create_popup("red", "Error: " + data["message"]);
					this.dom_container
						.find(".form-select-stats-feedback")
						.text("");
					reject();
				});
		});
	},

	// Reset (x, y), clear canvas
	clear: function () {
		this.x_data = [];
		this.y_data = [];

		let canvas = this.dom_container.find(".show-stats-canvas");
		let ctx = canvas[0].getContext("2d");
		ctx.clearRect(0, 0, canvas.width(), canvas.height());
	},

	// Apply (x, y) to the chart
	refresh: async function () {
		// console.log("refreshing...");

		this.number_of_refresh += 1;

		this.clear();
		await this.fetch_data();

		if (this.chart) {
			this.chart.destroy();
		}

		let dom_canvas = this.dom_container.find(".show-stats-canvas");

		let ctx = dom_canvas[0].getContext("2d");
		this.chart = new Chart(ctx, {
			type: "line",
			data: {
				labels: this.x_data,
				datasets: [
					{
						label: "Niveau sonore",
						data: this.y_data,
						backgroundColor: "rgba(75, 192, 192, 0.5)",
						borderColor: "rgba(75, 192, 192, 1)",
						borderWidth: 1,
					},
				],
			},
			options: {
				scales: {
					y: {
						beginAtZero: true,
						title: {
							display: true,
							text: "Niveau sonore (dB)",
						},
					},
					x: {
						title: {
							display: true,
							text: "Instants de mesure (espacés d'une heure)",
						},
					},
				},
			},
		});
	},

	// Read from the form
	get_stats_type: function () {
		return this.dom_container.find(".stats_type:checked").val();
	},

	// Read from the form
	get_sensor_id: function () {
		return this.dom_container.find(".sensor_id").val();
	},

	// Read from the form
	get_session_id: function () {
		return this.dom_container.find(".session_id").val();
	},

	// Read from the form
	get_max_points: function () {
		return this.dom_container.find(".max_points").val();
	},
};

// It is a hashmap, for random access deletion, back insertion
let mycharts = {};
function create_new_chart() {
	let chart = Object.create(ChartView);
	let number = Object.keys(mycharts).length + 1;
	let dom_container_id = "canvas-container-" + number;
	console.log("container_id:", dom_container_id);

	// Clone the dialog template
	let dom_container = $("#sample-dialog").clone();
	dom_container.attr("title", "Graphique " + number);
	// Append number to the id and for label of the radio button
	// get input radio with name="stats_type"
	dom_container.find(".stats_type").each(function () {
		$(this).attr("id", $(this).attr("id") + "-" + number);
		// same for the label
		$(this)
			.next()
			.attr("for", $(this).next().attr("for") + "-" + number);
	});

	// Change the dom to turn it into a dialog
	dom_container.dialog({
		width: $(window).width() / 2,
		height: $(window).height() / 2,

		close: function () {
			$(this).dialog("destroy").remove();
		},
	});
	// Change from #sample-dialog to #canvas-container-n
	dom_container.attr("id", dom_container_id);
	// Because display: none in the template
	dom_container.show();

	// debugger;

	chart.init(dom_container_id);
	// Hashmap insertion
	mycharts[dom_container_id] = chart;
	console.log("mycharts:", mycharts);
}

$(function () {
	$("#btn-new-stats-dialog").click(function () {
		create_new_chart();
	});

	create_new_chart();
});
