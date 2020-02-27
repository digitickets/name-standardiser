<?php

namespace DigiTickets\NameStandardiser;

class TitleStandardiser
{
    public static function standardiseTitle(string $title = null)
    {
        if (is_null($title)) {
            return $title;
        }

        // Remove/convert any unwanted characters first.
        $title = strtolower(trim($title));
        $title = preg_replace('/\s{1,}/', ' ', $title); // Convert all whitespace to single spaces.
        $title = preg_replace('/[^a-z` ]/', '', $title); // Remove anything that's not alphabetic, apostrophe or space.

        // Set the capitalisation.
        $title = ucwords($title); // It is already all lower case.

        // Explicitly convert " The " to " the " (note the spaces either side).
        $title = str_replace(' The ', ' the ', $title);

        return $title;
    }
}
