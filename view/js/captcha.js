// Sélection DOM (Document Object Model)
let CaptchaCadre = document.querySelector(".captcha_cadre");
const BoutonRefresh = document.querySelector(".refresh");
const CaptchaInput = document.querySelector(".captcha_input input");
const commentaireVF = document.querySelector(".commentaireVF");
const BoutonEnvoyer = document.querySelector(".captcha_button button");
const BoutonEnvoyerForm = document.querySelector(".BigButton.btn");
let captchaText = "";

function generateCaptcha() {
	const randomString = Math.random().toString(36).substring(2, 7);
	const randomStringArray = randomString.split("");
	const changeString = randomStringArray.map((char) =>
		Math.random() > 0.5 ? char.toUpperCase() : char
	);
	captchaText = changeString.join("   ");
	// CaptchaCadre.value = captchaText;
	console.log(captchaText);

	$.get(DOMAIN_NAME + "/register-captcha", function (data) {
		$("#captcha_img").attr("src", "data:image/png;base64," + data);
	});
}

function RefreshCaptcha(event) {
	event.preventDefault();
	generateCaptcha();
	CaptchaInput.value = "";
	captchaValidation();
}

function captchaReponseValidation(event) {
	event.preventDefault();
	let cleanedCaptchaText = captchaText.split(" ").join("");
	commentaireVF.classList.add("active");
	//Verfier si la saisie est correcte
	if (CaptchaInput.value === cleanedCaptchaText) {
		commentaireVF.innerText = "Le captcha est correct";
		commentaireVF.style.color = "green";
		// BoutonEnvoyerForm.disabled = false;
	} else {
		commentaireVF.innerText = "Le captcha est incorrect";
		commentaireVF.style.color = "red";
		// BoutonEnvoyerForm.disabled = true;
	}
}

function captchaValidation() {
	// Active/désactive le bouton en fonction de la présence de texte dans le champ CAPTCHA
	// BoutonEnvoyer.disabled = !CaptchaInput.value;
	// Montre/Cache le message d'erreur en fonction de la présence de texte dans le champ CAPTCHA
	commentaireVF.style.visibility = "visible";
}

// Declancher les fonctions au click/relachement touche generateur captcha
BoutonRefresh.addEventListener("click", RefreshCaptcha);
CaptchaInput.addEventListener("keyup", captchaValidation);
// BoutonEnvoyer.addEventListener("click", captchaReponseValidation);

//generer le captcha au chargement de la page
window.addEventListener("load", () => {
	generateCaptcha();
});

$(function () {
	// BoutonEnvoyerForm.disabled = true;
});
