<?php

namespace App\Services\Contracts;

interface MemberServiceInterface
{

    public function getAllMembers(array $reqParams);

    public function filterMembers(array $reqParams);

    // public function getMemberById(int $memberId);

    public function getMemberByCode(string $memberCode);

    // public function createMember(array $payload);

    public function updateMemberByCode(string $memberCode, array $payload);

    //public function deleteMemberByMemberCode(string $memberCode);

}
