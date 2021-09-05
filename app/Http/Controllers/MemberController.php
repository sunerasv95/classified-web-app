<?php

namespace App\Http\Controllers;

use App\Http\Requests\Member\GetMembersRequest;
use App\Http\Requests\Member\UpdateMemberRequest;
use App\Services\Contracts\MemberServiceInterface;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private $memberService;

    public function __construct(MemberServiceInterface $memberService)
    {
        $this->memberService = $memberService;
    }

    public function getAll(GetMembersRequest $request)
    {
        $validatedData = $request->validated();
        return $this->memberService->getAllMembers($validatedData);
    }

    public function getOne(string $memberCode)
    {
        return $this->memberService->getMemberByCode($memberCode);
    }

    public function search(GetMembersRequest $request)
    {
        $validatedData = $request->validated();
        //dd($validatedData);
        return $this->memberService->filterMembers($validatedData);
    }

    // public function create(CreateRoleRequest $request)
    // {
    //     $validatedData = $request->validated();
    //     return $this->roleService->createRole($validatedData);
    // }

    public function update(string $memberCode, UpdateMemberRequest $request)
    {
        $validatedData = $request->validated();
        return $this->memberService->updateMemberByCode($memberCode, $validatedData);
    }

    // public function delete(string $memberCode)
    // {
    //     return $this->roleService->deleteMemberByMemberCode($memberCode);
    // }
}
