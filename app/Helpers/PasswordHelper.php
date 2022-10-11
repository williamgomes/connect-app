<?php

namespace App\Helpers;

class PasswordHelper
{
    /**
     * Generate a random password with specific length and characters.
     *
     * @param int   $length         - the length of the generated password
     * @param array $characterTypes - types of characters to be used in the password
     *
     * @return string
     */
    public static function generate(int $length, array $characterTypes): string
    {
        // Set empty strings
        $password = $availableCharacters = '';

        // An array of different character types
        $characters['lower_case'] = 'abcdefghijklmnopqrstuvwxyz';
        $characters['upper_case'] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters['numbers'] = '1234567890';
        $characters['special_symbols'] = '#%-';

        // Build a string with all characters
        foreach ($characterTypes as $key => $value) {
            // Build possible characters
            $availableCharacters .= $characters[$value];

            // Each password must have at least 1 of each type
            $password .= $characters[$value][rand(0, strlen($characters[$value]) - 1)];
        }

        for ($i = strlen($password); $i < $length; $i++) {
            // Get a random character from the string with all characters
            $n = rand(0, strlen($availableCharacters) - 1);
            $password .= $availableCharacters[$n];
        }

        return $password;
    }
}
