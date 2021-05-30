<?php

namespace App\Rules;

use App\Repositories\Contracts\MemberRepositoryInterface;
use App\Util\HttpMessages;
use Illuminate\Contracts\Validation\Rule;

class MemberEmailExists implements Rule
{
    private $memberRepository;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
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
        $member = $this->memberRepository->getMemberByEmail($value); //todo: check whether user account is active/blocked/not email verified
        if(!isset($member)) return true;
        else return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return HttpMessages::EMAIL_IS_ALREADY_EXISTS;
    }
}
