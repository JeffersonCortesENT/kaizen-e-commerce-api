<?php

namespace App\Repositories;

use App\Models\Account;
use App\Repositories\Contracts\AccountRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AccountRepository implements AccountRepositoryInterface
{
    public function all()
    {
        return Account::all();
    }

    public function find(int $id)
    {
        return Account::findOrFail($id);
    }

    public function create(array $data)
    {
        return Account::create($data);
    }

    public function update(int $id, array $data)
    {
        $account = Account::findOrFail($id);
        $account->update($data);
        return $account;
    }

    public function delete(int $id)
    {
        return Account::destroy($id);
    }

    public function findByEmail(string $email)
    {
        return account::where('email', $email)->first();
    }
}
