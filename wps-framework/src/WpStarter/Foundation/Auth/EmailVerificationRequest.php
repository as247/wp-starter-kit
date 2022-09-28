<?php

namespace WpStarter\Foundation\Auth;

use WpStarter\Auth\Events\Verified;
use WpStarter\Foundation\Http\FormRequest;

class EmailVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (! hash_equals((string) $this->route('id'),
                          (string) $this->user()->getKey())) {
            return false;
        }

        if (! hash_equals((string) $this->route('hash'),
                          sha1($this->user()->getEmailForVerification()))) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Fulfill the email verification request.
     *
     * @return void
     */
    public function fulfill()
    {
        if (! $this->user()->hasVerifiedEmail()) {
            $this->user()->markEmailAsVerified();

            ws_event(new Verified($this->user()));
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param  \WpStarter\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        return $validator;
    }
}
