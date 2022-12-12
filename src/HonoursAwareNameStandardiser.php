<?php

namespace DigiTickets\NameStandardiser;

/**
 * Special version of the name standardiser that is aware that people can have honours, and it doesn't change the case
 * of them when it detects them.
 */
class HonoursAwareNameStandardiser extends NameStandardiser
{
    /**
     * A list of honours. We may need to make this larger in future, if the we are informed of more of them.
     *
     * @var string[]
     */
    private $honours = ['mbe', 'obe', 'cbe', 'kbe', 'dbe', 'ma', 'prof', 'mfa', 'mba', 'llm', 'lpc', 'gdl', 'mim', 'msw', 'pgce', 'pgde'];

    protected function shouldProcess(string $namePart): bool
    {
        // Sometimes you don't want any honours in the your customers' names to be converted to initial caps.
        // So if the name part is a case-insensitive match for an honour, then don't process it at all
        // (leave it exactly as it is).
        // Otherwise, do whatever the "standard" standard would do.
        // We ignore dots, because sometimes people enter "CBE" and sometimes "C.B.E" and possibly "C.B.E".
        return !in_array(strtolower(str_replace('.', '', $namePart)), $this->honours)
            && parent::shouldProcess($namePart);
    }
}
