<?php

namespace App\Services\Payment\Contracts;

Interface Payment
{
    public function pay($takhtId, $userId, $description, $amount, $raft, $bargasht);

    public function verify($authority);
}
