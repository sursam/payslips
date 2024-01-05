<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxValueWhen implements Rule
{

    protected $maxValue;
        protected $fieldToCheck;
        protected $valueToTrigger;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($maxValue, $fieldToCheck, $valueToTrigger)
    {
        $this->maxValue = $maxValue;
        $this->fieldToCheck = $fieldToCheck;
        $this->valueToTrigger = $valueToTrigger;
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

        $otherFieldValue = request()->input($this->fieldToCheck);

        if ($otherFieldValue == $this->valueToTrigger) {
            return $value <= $this->maxValue;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ":attribute must be less than or equal to $this->maxValue when $this->fieldToCheck is $this->valueToTrigger.";
    }
}
