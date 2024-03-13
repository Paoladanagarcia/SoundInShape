<?php

#echo __FILE__ . '<br>';


global $PDO;
require_once 'model/db-connection.php';

function get_all_users()
{
    global $PDO;
    return $PDO->query('SELECT * FROM user')->fetchAll();
}

function get_user($user_id)
{
    global $PDO;

    $query = $PDO->prepare('SELECT * FROM user WHERE user_id = :user_id');
    $query->execute(array(
        'user_id' => $user_id
    ));

    return $query->fetch();
}

function post_user(array $fields)
{
    // $field is a dictionary with the field name as key and the value as value
    global $PDO;

    $query = $PDO->prepare('INSERT INTO user (
        last_name,
        first_name,
        birthdate,
        address,
        city,
        postal_code,
        mail,
        password_hash) VALUES (
        :last_name,
        :first_name,
        :birthdate,
        :address,
        :city,
        :postal_code,
        :mail,
        :password_hash)');
    $result = $query->execute($fields);

    return (bool)$result;
}

function get_hash_by_mail($mail)
{
    global $PDO;

    $query = $PDO->prepare('SELECT password_hash FROM user WHERE mail = :mail');
    $query->execute(array(
        'mail' => $mail
    ));

    $result = $query->fetch();

    return $result ? $result[0] : false;
}

function get_id_by_mail($mail): int|false
{
    global $PDO;

    $query = $PDO->prepare('SELECT user_id FROM user WHERE mail = :mail');
    $query->execute(array(
        'mail' => $mail
    ));

    $result = $query->fetch();

    return $result ? $result[0] : false;
}

function update_token_if_mail_exists($mail, $new_token)
{
    global $PDO;

    // Vérifier si l'e-mail existe dans la base de données
    $query = $PDO->prepare('SELECT user_id FROM user WHERE mail = :mail');
    $query->execute(array(
        'mail' => $mail
    ));

    $result = $query->fetch();

    if ($result) {
        // L'e-mail existe, mettez à jour le jeton
        $user_id = $result[0];

        $update_query = $PDO->prepare('UPDATE user SET password_recovery_token = :token WHERE user_id = :user_id');
        $update_query->execute(array(
            'token' => $new_token,
            'user_id' => $user_id
        ));

        return true; // Succès de la mise à jour du jeton
    } else {
        return false; // L'e-mail n'existe pas dans la base de données
    }
}

function update_password_if_token_exists($token, $new_password)
{
    global $PDO;

    // Vérifier si le jeton existe dans la base de données
    $query = $PDO->prepare('SELECT user_id FROM user WHERE password_recovery_token = :token');
    $query->execute(array(
        'token' => $token
    ));

    $result = $query->fetch();

    if ($result) {
        // Le jeton existe, mettez à jour le mot de passe
        $user_id = $result[0];

        $update_query = $PDO->prepare('UPDATE user SET password_hash = :password_hash WHERE user_id = :user_id');
        $update_query->execute(array(
            'password_hash' => password_hash($new_password, PASSWORD_DEFAULT),
            'user_id' => $user_id
        ));

        # Clear token
        $update_query = $PDO->prepare('UPDATE user SET password_recovery_token = NULL WHERE user_id = :user_id');
        $update_query->execute(array(
            'user_id' => $user_id
        ));

        return true; // Succès de la mise à jour du mot de passe
    } else {
        return false; // Le jeton n'existe pas dans la base de données
    }
}

function is_admin_by_id($user_id)
{
    global $PDO;

    $query = $PDO->prepare('SELECT admin_id FROM admin WHERE admin_id = :user_id');
    $query->execute(array(
        'user_id' => $user_id
    ));

    $result = $query->fetch();

    return $result ? true : false;
}

function get_user_field_by_id($user_id, $field)
{
    // Accepted fields:, first_name, last_name, email, birthdate, address, city, postal_code, register_date
    // password_hash, password_recovery_token, registration_approved, club_id

    global $PDO;
    $field = htmlspecialchars($field);

    $query = $PDO->prepare('SELECT :field FROM user WHERE user_id = :user_id');
    $query->execute(array(
        'field' => $field,
        'user_id' => $user_id
    ));

    $result = $query->fetch();

    return $result ? $result[0] : false;
}

function update_user_field_by_id($user_id, $field, $value)
{
    // Accepted fields:, first_name, last_name, email, birthdate, address, city, postal_code, register_date
    // password_hash, password_recovery_token, registration_approved, club_id

    global $PDO;
    $field = htmlspecialchars($field);

    $query = $PDO->prepare('UPDATE user SET :field = :value WHERE user_id = :user_id');
    $query->execute(array(
        'field' => $field,
        'value' => $value,
        'user_id' => $user_id
    ));

    return $query->rowCount() > 0;
}

function partial_update_fields_by_id($user_id, $fields)
{
    // Accepted fields:
    // first_name, last_name, email, birthdate, address, city, postal_code, register_date
    // password_hash, password_recovery_token, registration_approved, club_id

    // Update the fields from $fields with the specified values at the right user_id
    // The fields is a dictionary with the field name as key and the value as value
    // Make a SQL request that combines the fields and values.


    global $PDO;

    $sql = 'UPDATE user SET ';
    $i = 0;
    foreach ($fields as $field => $value) {
        $field = trim($field);
        $sql .= $field . ' =:' . $field;
        if ($i < count($fields) - 1) {
            $sql .= ', ';
        }
        $i++;
    }
    $sql .= ' WHERE user_id =:user_id';

    // echo "\nsql: ";
    // print_r($sql);
    $query = $PDO->prepare($sql);
    $query->execute(array_merge($fields, ['user_id' => $user_id]));

    return $query->rowCount() > 0;
}

function get_unconfirmed_users(): bool|array
{
    global $PDO;

    $query = $PDO->prepare('SELECT * FROM user WHERE registration_approved = 0');
    $query->execute();

    return $query->fetchAll();
}

function confirm_user(int $user_id, int $admin_approving): bool
{
    global $PDO;

    $query = $PDO->prepare('UPDATE user 
        SET registration_approved = 1, admin_approving = :admin_approving 
        WHERE user_id = :user_id');
    return $query->execute([
        'user_id' => $user_id,
        'admin_approving' => $admin_approving
    ]);
}

function delete_user_by_id($user_id)
{
    global $PDO;

    // Check foreign keys

    $query = $PDO->prepare('DELETE FROM user WHERE user_id = :user_id');
    return $query->execute([
        'user_id' => $user_id
    ]);
}

function is_mail_confirmed($user_id)
{
    global $PDO;

    $query = $PDO->prepare('SELECT is_mail_confirmed FROM user WHERE user_id = :user_id');
    $query->execute([
        'user_id' => $user_id
    ]);

    return (bool)$query->fetch()[0];
}

function update_verify_mail_token($user_mail, $verify_mail_token)
{
    global $PDO;

    $query = $PDO->prepare('UPDATE user SET verify_mail_token = :verify_mail_token WHERE mail = :mail');
    $res = $query->execute([
        'verify_mail_token' => $verify_mail_token,
        'mail' => $user_mail
    ]);

    return (bool)$res;
}

function get_token_by_mail($user_mail)
{
    global $PDO;

    $query = $PDO->prepare('SELECT verify_mail_token FROM user WHERE mail = :mail');
    $query->execute([
        'mail' => $user_mail
    ]);

    return $query->fetch()[0];
}

function set_mail_confirmed($user_mail)
{
    global $PDO;

    $query = $PDO->prepare('UPDATE user SET is_mail_confirmed = 1 WHERE mail = :mail');
    $res = $query->execute([
        'mail' => $user_mail
    ]);

    return (bool)$res;
}

function calculateAverageNoise()
{
    global $PDO;

    $TableNoise = 'noise_recording';

    $query = "SELECT session_id, AVG(noise_level) AS average_noise FROM $TableNoise GROUP BY session_id";

    $statement = $PDO->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function prefNoiseLevel($user_id)
{
    global $PDO;

    $stmt = $PDO->prepare('SELECT pref_noise_level FROM user WHERE user_id = :user_id');
    $stmt->execute([
        'user_id' => $user_id
    ]);

    return $stmt->fetch()[0];
}

function update_pref_noise($user_id, $pref_noise_level)
{
    global $PDO;

    $stmt = $PDO->prepare('UPDATE user SET pref_noise_level = :pref_noise_level WHERE user_id = :user_id');
    $res = $stmt->execute([
        'pref_noise_level' => $pref_noise_level,
        'user_id' => $user_id
    ]);

    return (bool)$res;
}
