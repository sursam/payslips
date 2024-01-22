<?php

namespace App\Rules;

use Closure;
use ReCaptcha\ReCaptcha;
use Illuminate\Contracts\Validation\ValidationRule;

class RecaptchaRule implements ValidationRule
{

    private $errorMsg;
    private $action;

    /**
     * Create a new rule instance.
     *
     * @param $action
     */
    public function __construct($action)
    {
        $this->action = $action;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // dd($value);
        if (empty($value)) {
            $this->errorMsg = ':attribute field is required.';
            $fail(':attribute field is required.');
        }

        $recaptcha = new ReCaptcha(config('captcha.secret'));
        $resp = $recaptcha->setExpectedHostname(config('captcha.host_server'))
            ->setScoreThreshold(config('captcha.score'))
            ->setExpectedAction($this->action)
            ->verify($value, request()->getClientIp());
            // dd($resp);
        if (!$resp->isSuccess()) {
            $this->errorMsg = 'ReCaptcha field is required.';
            $fail('ReCaptcha field is required.');
        }

        if ($resp->getScore() < config('captcha.score')) {
            $this->errorMsg = 'Failed to validate captcha.';
            $fail('Failed to validate captcha.');
        }
    }

    public function message()
    {
        return $this->errorMsg;
    }
}
