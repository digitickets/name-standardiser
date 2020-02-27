<?php

namespace DigiTicketsTests\NameStandardiser;

use DigiTickets\NameStandardiser\HonoursAwareNameStandardiser;

/**
 * This class runs all the unit tests that the "standard" name standardiser test class runs, but runs them against the
 * "honours-aware" standardiser and has different expectations in certain cases.
 */
class HonoursAwareNameStandardiserTest extends NameStandardiserTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->nameStandardiser = new HonoursAwareNameStandardiser();
    }

    /**
     * This provides certain alternative test values when testing the standardiser.
     *
     * @return array
     */
    protected function bespokeNames()
    {
        return [
            // The honours-aware standardiser will, of course, not mess with honours.
            'honours1' => ['jones OBE', 'Jones OBE'],
            'honours2' => ['mbe evans', 'mbe Evans'],
            'honours3' => ['Cox mBe OBe dbe', 'Cox mBe OBe dbe'],
            'honours4' => ['Dots C.B.E.', 'Dots C.B.E.'],
            'honours5' => ['Dots C.B.E', 'Dots C.B.E'],
        ];
    }
}
