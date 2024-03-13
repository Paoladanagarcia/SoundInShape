<?php
global $show_private_fields;
global $user_attr;
$GLOBALS['PAGE_TITLE'] = 'Update My profile';
addCSS('edit-profile.css');
require_view('view/header.php');
?>


<h1>Update My Profile</h1>

<form action="post-edit-profile">
    <label for="last_name">Last Name</label>
    <input type="text" id="last_name" name="last_name" value="<?= $user_attr['last_name'] ?>" required>

    <label for="first_name">First Name</label>
    <input type="text" id="first_name" name="first_name" value="<?= $user_attr['first_name'] ?>" required>

    <label for="birthdate">Birthdate</label>
    <input type="date" id="birthdate" name="birthdate" value="<?= $user_attr['birthdate'] ?>" required>

    <label for="mail">Email address</label>
    <input type="text" id="mail" name="mail" value="<?= $user_attr['mail'] ?>" required>

    <label for="address">Address</label>
    <input type="text" id="address" name="address" value="<?= $user_attr['address'] ?>" required>

    <label for="postal_code">Postal Code</label>
    <input type="number" id="postal_code" name="postal_code" value="<?= $user_attr['postal_code'] ?>" required>

    <label for="city">City</label>
    <input type="text" id="city" name="city" value="<?= $user_attr['city'] ?>" required>

    <p><br>To update your password : logout and click 'password forgotten'.</p>

    <!--    --><?php
                //    if (is_admin_logged())
                //    {
                //        // Print the remaining fields only if the user is an admin like
                //        // id, register_date, password_hash, password_recovery_token, registration_approved and club_id
                //        
                ?>
    <!--        <label for="id">Identifiant</label>-->
    <!--        <input type="number" id="id" name="id" value="--><?php //= $user_attr['user_id'] 
                                                                    ?><!--" required>-->
    <!---->
    <!--        <label for="register_date">Date d'inscription</label>-->
    <!--        <input type="datetime-local" id="register_date" name="register_date" value="--><?php //= $user_attr['register_date'] 
                                                                                                ?><!--" required>-->
    <!---->
    <!--        <label for="password_hash">Mot de passe haché</label>-->
    <!--        <input type="text" id="password_hash" name="password_hash" value="--><?php //= $user_attr['password_hash'] 
                                                                                        ?><!--" required readonly>-->
    <!---->
    <!--        <label for="password_recovery_token">Token de récupération de mot de passe</label>-->
    <!--        <input type="text" id="password_recovery_token" name="password_recovery_token" value="--><?php //= $user_attr['password_recovery_token'] 
                                                                                                            ?><!--" required>-->
    <!---->
    <!--        <label for="registration_approved">Inscription approuvée</label>-->
    <!--        <input type="number" id="registration_approved" name="registration_approved" value="--><?php //= $user_attr['registration_approved'] 
                                                                                                        ?><!--" required>-->
    <!--        --><?php
                    //    }
                    //    
                    ?>

    <input type="submit" class="BigButton" id="submit" value="Update my profile!">

    <div id="feedback"></div>
</form>

<?php
require_view('view/footer.php');
?>