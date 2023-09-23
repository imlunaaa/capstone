<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ProgramRule implements Rule
{
    protected $campus_id;
    protected $program_id;
    protected $campus_val;
    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($campus_id, $program_id, $campus_val)
    {
        //
        $this->campus_id = $campus_id;
        $this->program_id = $program_id;
        $this->campus_val = $campus_val;
        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //

        return  $this->program_id != $value || $this->campus_val != $this->campus_id;
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Program Already Exist in Campus';
    }
}
