<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankAccountTransactionRequest;
use App\Http\Resources\BankAccountTransaction as BankAccountTransactionResource;
use App\Models\BankAccount;
use App\Models\BankAccountTransaction;
use Illuminate\Http\Request;

class BankAccountTransactionController extends Controller
{
    public function __construct()
    {
        parent::generateAllMiddlewareByPermission('bankAccountTransactions');
    }

    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = BankAccountTransactionResource::collection(BankAccountTransaction::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(BankAccountTransactionRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $bankAccountTransaction = new BankAccountTransaction($values);
            $bankAccountTransaction->save();
            $bankAccount = BankAccount::findOrFail($bankAccountTransaction->account_id);
            if($bankAccountTransaction->transaction_type == 'CR') {
                $bankAccount->total_balance = $bankAccount->total_balance + $bankAccountTransaction->transaction_amount;
                $bankAccount->current_balance = $bankAccount->current_balance + $bankAccountTransaction->transaction_amount;
            }else{
                $bankAccount->total_balance = $bankAccount->total_balance - $bankAccountTransaction->transaction_amount;
                $bankAccount->current_balance = $bankAccount->current_balance - $bankAccountTransaction->transaction_amount;
            }
            $bankAccount->save();
            event(new ActivityLogEvent('Add', 'Bank Account Transaction', $bankAccountTransaction->id));
            $data['message'] = "Bank Account Transaction added successfully.";
            $data['data'] = new BankAccountTransactionResource($bankAccountTransaction);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function show($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = new BankAccountTransactionResource(BankAccountTransaction::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, BankAccountTransactionRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $bankAccountTransaction = BankAccountTransaction::findOrFail($id);
            $values = $request->all();
            $bankAccount = BankAccount::findOrFail($bankAccountTransaction->account_id);
            if ((($bankAccountTransaction->account_id == $request->account_id) or ($request->account_id === null)) && ($request->transaction_amount !== null)) {
                $bankAccount->changeBalance($request->transaction_amount, $bankAccountTransaction->transaction_amount, true);
            } elseif (($bankAccountTransaction->account_id != $request->account_id) && ($request->account_id !== null)) {
                $bankAccount1 = BankAccount::findOrFail($request->account_id);
                $bankAccount->subBalance($bankAccountTransaction->transaction_amount, true);
                if ($request->transaction_amount !== null) {
                    $bankAccount1->addBalance($request->transaction_amount, true);
                } else {
                    $bankAccount1->addBalance($bankAccountTransaction->transaction_amount, true);
                }
                $bankAccount1->save();
            }
            $bankAccount->save();
            $bankAccountTransaction->update($values);
            event(new ActivityLogEvent('Edit', 'Bank Account Transaction', $bankAccountTransaction->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new BankAccountTransactionResource($bankAccountTransaction);
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function destroy($id)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $signature = BankAccountTransaction::findOrFail($id);
            $signature->delete();
            event(new ActivityLogEvent('Delete', 'Bank Account Transaction', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
