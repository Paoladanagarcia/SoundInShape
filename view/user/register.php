<?php
$GLOBALS['PAGE_TITLE'] = 'Inscrivez-vous';
global $captcha_image;
addCSS('register.css');
require_view('view/header.php');
?>

<h1>S'inscrire à SoundInShape</h1>

<div class="cadre form-container">

    <!-- Submission via AJAX (POST) -->
    <form action="post-register-user">
        <h2>Inscrivez-vous maintenant !</h2>
        <div>
            <label for="last_name"><span><i class="material-icons">person</i> Nom</span></label>
            <input name="last_name" id="last_name" type="text" placeholder="Doe" value="Doe" required />
        </div>

        <div>
            <label for="first_name"><span><i class="material-icons">person</i> Prénom</span></label>
            <input name="first_name" id="first_name" type="text" placeholder="Joe" value="Joe" required />
        </div>

        <div>
            <label for="birthdate"><span><i class="material-icons">calendar_today</i> Date de naissance</span></label>
            <input name="birthdate" id="birthdate" type="date" value="2000-01-01" required />
        </div>

        <div>
            <label for="address"><span><i class="material-icons">location_on</i> Adresse</span></label>
            <input name="address" id="address" type="text" placeholder="10 Rue de Vanves" value="10 Rue de Vanves" required />
        </div>

        <div>
            <label for="mail"><span><i class="material-icons">email</i> Adresse e-mail</span></label>
            <input name="mail" id="mail" type="text" placeholder="james.chaintron@gmail.com" value="james.chaintron@gmail.com" required />
        </div>

        <div>
            <label for="city"><span><i class="material-icons">location_city</i> Ville</span></label>
            <input name="city" id="city" type="text" placeholder="Issy-les-Moulineaux" value="Issy-les-Moulineaux" required />
        </div>

        <div>
            <label for="postal_code"><span><i class="material-icons">location_city</i> Code Postal</span></label>
            <input name="postal_code" id="postal_code" type="number" placeholder="92170 " value="92170" required />
        </div>

        <div>
            <label for="password1"><span><i class="material-icons">lock</i> Choisissez votre mot de passe</span></label>
            <input name="password1" id="password1" type="password" placeholder="********" value="abcdefA1!" required />
        </div>

        <div>
            <label for="password2"><span><i class="material-icons">lock</i> Confirmez votre mot de passe</span></label>
            <input name="password2" id="password2" type="password" placeholder="********" value="abcdefA1!" required />
        </div>



        <div class="captcha">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
            <p>Captcha</p>

            <img id="captcha_img" src="" alt="CAPTCHA" />

            <button type=button class="refresh">
                <i class="fa-solid fa-rotate-right"></i>
            </button>
            <div class="captcha_input">
                <input type="text" placeholder="Entrer le Captcha" name="user_captcha" />
            </div>
            <div class="commentaireVF"></div>
        </div>

        <input name="erjerjireji" type="submit" class="BigButton btn" id="form-submit" value="S'inscrire" />
    </form>

    <div id="feedback"></div>
</div>

<script src="view/js/captcha.js"></script>

<?php
require_view('view/footer.php');
?>