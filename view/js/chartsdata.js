$(function () {
	"use strict";

	let initialize_charts = [
		{
			dom_id: "statsChart1",
			url: DOMAIN_NAME + "/stats/get",
			get_params: {
				stats_type: "noise",
				session_id: 3,
				max_points: 100,
			},
		},
		{
			dom_id: "statsChart2",
			url: DOMAIN_NAME + "/stats/get",
			get_params: {
				stats_type: "noise",
				session_id: 4,
				max_points: 100,
			},
		},
		{
			dom_id: "statsChart3",
			url: DOMAIN_NAME + "/stats/get",
			get_params: {
				stats_type: "noise",
				session_id: 5,
				max_points: 50,
			},
		},
		{
			dom_id: "statsChart4",
			url: DOMAIN_NAME + "/stats/get",
			get_params: {
				stats_type: "people",
				session_id: 3,
				max_points: 10,
			},
		},
	];

	// Initialize charts
	for (let chart_info of initialize_charts) {
		let dom_id = chart_info.dom_id;
		let url = chart_info.url;
		let get_params = chart_info.get_params;

		$.get(url, get_params).done((data) => {
			console.log(dom_id);
			let canvas = document.getElementById(dom_id);
			let ctx = canvas.getContext("2d");
			console.log(get_params);
			this.chart = new Chart(ctx, {
				type: "line",
				data: {
					labels: data.x,
					datasets: [
						{
							label:
								get_params.stats_type == "noise"
									? "Niveau sonore"
									: "Nombre de personnes",
							data: data.y,
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
								text:
									get_params.stats_type == "noise"
										? "Niveau sonore (dB)"
										: "Nombre de personnes",
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
		});
	}
});
