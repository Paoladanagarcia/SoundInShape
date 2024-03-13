<?php

const FORM_RULES = [
    'name'          => 'min:3|max:20',
    'mail'          => 'mail',
    'age'           => 'numeric|min:18|max:60',
    'date'          => 'date',
    'datetime'      => 'datetime',
    'time'          => 'time',
    'address'       => 'min:3|max:50',
    'city'          => 'min:3|max:50',
    'postal_code'   => 'min:3|max:10',
    'password'      => 'min:6|max:20|password_strength',
    'token'         => 'min:1',
    'id'            => 'numeric|min:1',
    'checkbox'      => 'numeric',
];

function validateFormData($data, $rules)
{
    $errors = '';

    foreach ($rules as $field => $rule) {
        $ruleParts = explode('|', $rule);

        if ($ruleParts[0] === 'optional' && $data[$field] === '') {
            // Ignore optional fields
            // echo 'Skipping optional field ' . $field . '. ';
            unset($data[$field]);
            continue;
        }

        foreach ($ruleParts as $r) {
            $r = explode(':', $r);

            if (in_array('checkbox', $ruleParts)) {
                if (!isset($data[$field])) {
                    $data[$field] = 0; // Default unchecked value
                } else {
                    $data[$field] = 1; // Checked value
                }
                continue;
            }

            if ($r[0] === 'required' && empty($data[$field])) {
                $errors .= '[' . htmlspecialchars($field) . '] is required. ';
            }

            if ($r[0] === 'numeric' && !is_numeric($data[$field])) {
                // To int conversion
                echo 'Converting ' . $data[$field] . ' to int. ';
                $data[$field] = (int)$data[$field];
                $errors .= '[' . htmlspecialchars($field) . '] must be numeric. ';
            }

            if ($r[0] === 'mail' && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                $errors .= '[' . htmlspecialchars($field) . '] must be a valid mail. ';
            }

            if ($r[0] === 'datetime') {
                $format = 'Y-m-d\TH:i:s';
                $d = DateTime::createFromFormat($format, $data[$field]);
                if ($d === false || $d->format($format) !== $data[$field]) {
                    $errors .= '[' . htmlspecialchars($field) . '] must be a valid datetime. ';
                }
            }

            if ($r[0] === 'time') {
                $format = 'H:i:s';
                $d = DateTime::createFromFormat($format, $data[$field]);
                if ($d === false || $d->format($format) !== $data[$field]) {
                    $errors .= '[' . htmlspecialchars($field) . '] must be a valid time. ';
                }
            }

            if ($r[0] === 'password_strength') {
                $pwd = $data[$field];
                $n_lower = 0;
                $n_upper = 0;
                $n_number = 0;
                $n_special = 0;

                // Each character
                for ($i = 0; $i < strlen($pwd); $i++) {
                    $c = $pwd[$i];
                    // lower
                    if (preg_match('/[a-z]/', $c)) {
                        $n_lower++;
                    }
                    // upper
                    if (preg_match('/[A-Z]/', $c)) {
                        $n_upper++;
                    }
                    // digit
                    if (preg_match('/[0-9]/', $c)) {
                        $n_number++;
                    }
                    // special
                    if (preg_match('/[^a-zA-Z0-9]/', $c)) {
                        $n_special++;
                    }
                }

                $safe_field = htmlspecialchars($field);
                if ($n_lower == 0) {
                    $errors .= "[$safe_field] must contain at least 1 lowercase letter. ";
                }
                if ($n_upper == 0) {
                    $errors .= "[$safe_field] must contain at least 1 uppercase letter. ";
                }
                if ($n_number == 0) {
                    $errors .= "[$safe_field] must contain at least 1 number. ";
                }
                if ($n_special == 0) {
                    $errors .= "[$safe_field] must contain at least 1 special character. ";
                }
            }
        }
    }

    return [$data, $errors];
}
