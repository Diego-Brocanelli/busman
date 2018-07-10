<?php

namespace Busman\Financial\Http\Controllers;

use Busman\Financial\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('account_list');

        if ($request->q) {
            $accounts = Account::search($request->q)->get();
        } else {
            $accounts = Account::all();
        }

        $accountsPag = $accounts->paginate($request);

        return $accountsPag->toArray();
    }

    public function store(Request $request)
    {
        $this->authorize('account_store');

        $account = Account::create($request->only([]));

        return $account->toArray();
    }

    public function show(Account $account)
    {
        $this->authorize('account_list');

        return $account->toArray();
    }

    public function update(Request $request, Account $account)
    {
        $this->authorize('account_update');

        $account->update($request->only([]));

        return $account->toArray();
    }

    public function destroy(Request $request, Account $account)
    {
        $this->authorize('account_destroy');

        $account->delete();

        return "Account deleted successfully";
    }
}
