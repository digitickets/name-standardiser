<?php

namespace DigiTicketsTests\NameStandardiser;

use DigiTickets\NameStandardiser\NameStandardiser;
use PHPUnit\Framework\TestCase;

class NameStandardiserTest extends TestCase
{
    /**
     * @var NameStandardiser
     */
    protected $nameStandardiser;

    protected function setUp()
    {
        parent::setUp();

        $this->nameStandardiser = new NameStandardiser();
    }

    public function nameProvider()
    {
        return array_merge(
            [
                // Simple capitalisation of 1st char.
                'simple1' => ['smith', 'Smith'],
                'simple2' => ['SMITH', 'Smith'],
                '' => ['macdonald', 'Macdonald'],
                // Mixed case names are left untouched.
                'mixed1' => ['Smith', 'Smith'],
                'mixed2' => ['smITh', 'smITh'],
                'mixed3' => ['MacDonald', 'MacDonald'],
                // Names with special prefix.
                'prefix1' => ['mcdonald', 'McDonald'],
                'prefix2' => ['o\'reilly', 'O\'Reilly'],
                // Multiple words (with different separators).
                'multiple1' => ['van beethoven', 'Van Beethoven'],
                'multiple2' => ['van den blashford-mccartney-smith', 'Van Den Blashford-McCartney-Smith'],
                // Multiple words with some different-case parts.
                'parts1' => ['van blashford-MacDonald-smITh machin', 'Van Blashford-MacDonald-smITh Machin'],
            ],
            $this->bespokeNames()
        );
    }

    protected function bespokeNames()
    {
        return [
            // The standard standardiser should not be honours-aware, and will change their case.
            'honours1' => ['jones OBE', 'Jones Obe'],
            'honours2' => ['mbe evans', 'Mbe Evans'],
            'honours3' => ['Cox mBe OBe dbe', 'Cox mBe OBe Dbe'],
            'honours4' => ['Dots C.B.E.', 'Dots C.b.e.'],
            'honours5' => ['Dots C.B.E', 'Dots C.b.e'],
        ];
    }

    /**
     * @dataProvider nameProvider
     */
    public function testStandardisationOfNames($oldValue, $newValue)
    {
        $this->assertEquals($newValue, $this->nameStandardiser->standardiseName($oldValue));
    }

    public function testReturnsNullForEmptyName()
    {
        $this->assertNull($this->nameStandardiser->standardiseName(null));
        $this->assertNull($this->nameStandardiser->standardiseName(''));
        $this->assertNull($this->nameStandardiser->standardiseName(' '));
    }
}
