<?php

namespace DigiTickets\NameStandardiser;

/**
 * This class will take a (person's) name and standardise the case. It has subclasses that have different strategies
 * for determining how to correct the case of a name.
 */
class NameStandardiser
{
    /**
     * Method to return the given string with case appropriate to a contact's name. Examples:
     * smith -> Smith
     * van beethoven -> Van Beethoven
     * o'reilly -> O'Reilly
     * mcdonald -> McDonald
     * macdonald -> Macdonald [We can't handle Mac*, eg Machin -> Machin]
     * van der blashford-mccartney-smith -> Van Der Blashford-McCartney-Smith
     * If a component of the name is mixed case, we leave it as it is - we assume the user
     * has typed it in *their* way. Eg
     * MacDonald -> MacDonald
     * macDonald -> macDonald
     * macdonald -> Macdonald [all lower case, so we know best]
     * We try to leave any honours in the same case, eg
     * jones OBE -> Jones OBE
     *
     * If/when we add more subclasses (or modify existing ones), this method might need to be reworked so that it calls
     * separate methods (which will do different things in the subclasses) or passes more information in to those methods.
     *
     * @param string|null $name
     *
     * @return string|null
     */
    public function standardiseName(string $name = null)
    {
        if (empty($name)) {
            return null;
        }

        // Split the name by space and hyphen. Then treat each part as a simple name.
        $result = [];
        $name = trim($name);
        foreach (explode(' ', $name) as $namesByspace) {
            $subResult = [];
            foreach (explode('-', $namesByspace) as $namePart) {
                if ($this->shouldProcess($namePart)) {
                    // Capitalise the first letter, and set the rest to lower case.
                    $namePart = ucfirst(strtolower($namePart));
                    // See if it has a "funny" start.
                    if (preg_match("/(mc|o\')/i", $namePart, $matches)) {
                        // Capitalise the first letter after the special prefix ("Mc" or "O'").
                        $breakPoint = strlen($matches[0]);
                        $namePart =
                            substr($namePart, 0, $breakPoint).
                            ucfirst(substr($namePart, $breakPoint));
                    }
                }
                $subResult[] = $namePart;
            }
            // Re-join the parts we split on a hyphen.
            $result[] = implode('-', $subResult);
        }
        // Re-join the parts we split on a space.
        $result = implode(' ', $result);

        if (empty($name)) {
            return null;
        }

        return $result;
    }

    protected function shouldProcess(string $namePart): bool
    {
        // Only process this name part if it is not mixed case.
        return $namePart == strtolower($namePart) || $namePart == strtoupper($namePart);
    }
}
