<?php

namespace App\Http\Requests\Auth;

use App\Repositories\Contracts\MemberRepositoryInterface;
use App\Rules\MemberEmailExists;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    private $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            "first_name"    => "required|string",
            "last_name"     => "required|string",
            "email"         => ["required","email","string",new MemberEmailExists($this->memberRepository)],
            "password"      => "required|string",
            "avatar"        => "nullable|string"
        ];
    }
}
