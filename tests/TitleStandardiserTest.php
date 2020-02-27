<?php

namespace DigiTicketsTests\NameStandardiser;

use DigiTickets\NameStandardiser\TitleStandardiser;
use PHPUnit\Framework\TestCase;

class TitleStandardiserTest extends TestCase
{
    public function provideTitles()
    {
        return [
            [null, null], // Null maps to null
            ['Miss', 'Miss'], // No change expected
            ['Mr.', 'Mr'],
            ['  some whitespace   ', 'Some Whitespace'], // leading/trailing whitespace; capitalisation
            ['don\'t know, I\'m sure!', 'Dont Know Im Sure'], // Punctuation.
            ["A\t\t\ttab   and  a space", 'A Tab And A Space'], // Convert whitespace to single spaces
            ['KING OF THE WORLD', 'King Of the World'], // Lower case "the"
            ['You there', 'You There'], // "the" at the start of a word (ie make sure it doesn't set the "t" to lower case)
        ];
    }

    /**
     * @param string $initialTitle
     * @param string $expectedTitle
     * @dataProvider provideTitles
     */
    public function testStandardisationOfTitle(string $initialTitle = null, string $expectedTitle = null)
    {
        $this->assertSame($expectedTitle, TitleStandardiser::standardiseTitle($initialTitle));
    }
}
