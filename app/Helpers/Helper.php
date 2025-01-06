<?php

namespace App\Helpers;

class Helper
{
    /**
     * Function to generate random code
     */
    public static function generateRandomCode($limit)
    {
        /** Define the character set for the random code */
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        /** Get the length of the character set */
        $charactersLength = strlen($characters);

        /** Initialize an empty string to store the random code*/
        $randomCode = '';

        /** Generate random characters until the code reaches the specified length*/
        for ($i = 0; $i < $limit; $i++) {
            /** Select a random character from the character set */
            $randomCharacter = $characters[rand(0, $charactersLength - 1)];

            /** Append the random character to the random code string */
            $randomCode .= $randomCharacter;
        }

        /** Return the generated random code */
        return $randomCode;
    }
}