<?php

namespace App\Http\Controllers\Api;

use App\Events\ActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\Expense as ExpenseResource;
use App\Models\BankAccount;
use App\Models\BankAccountTransaction;
use App\Models\Expense;
use App\Models\File;
use Illuminate\Http\Request;
use Samundra\File\SamundraFileHelper;

class ExpenseController extends Controller
{
    public function index()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $data['data'] = ExpenseResource::collection(Expense::all());
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function create()
    {

    }

    public function store(ExpenseRequest $request)
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $values = $request->all();
            $values['created_by'] = auth('api')->user()->id;
            if ($request->hasFile('file')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->file, 'budget');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                $newFile = new File();
                $newFile->extension = $file['data']['extension'];
                $newFile->original_name = $file['data']['original_filename'];
                $newFile->name = $file['data']['filename'];
                $newFile->type = $file['data']['mime_type'];
                $newFile->path = $file['data']['link'];
                $newFile->save();
                $values['file_id'] = $newFile->id;
            }
            $expense = new Expense($values);
            $expense->save();
            if (($expense->transaction_type == 'Cheque') or ($expense->transaction_type == 'OnlineTransaction')) {
                $bankAccount = BankAccount::findOrFail($expense->bank_account_id);
                $bankAccount->subBalance($expense->amount);
            }
            event(new ActivityLogEvent('Add', 'Expense', $expense->id));
            $data['message'] = "Expense added successfully.";
            $data['data'] = new ExpenseResource($expense);
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
            $data['data'] = new ExpenseResource(Expense::findOrFail($id));
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }

    public function edit($id)
    {

    }

    public function update($id, ExpenseRequest $request)
    {
        $hasdata = 0;
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['success'] = true;
            $expense = Expense::findOrFail($id);
            $values = $request->all();

            if (($expense->transaction_type != $request->transaction_type) && ($request->transaction_type !== null)) {
                if ((($expense->transaction_type == 'Cheque') or ($expense->transaction_type == 'OnlineTransaction')) && (($request->transaction_type == 'Cheque') or ($request->transaction_type == 'OnlineTransaction'))) {
                    if (($expense->bank_account_id != $request->bank_account_id) && ($request->bank_account_id !== null)) {
                        $bankAccount = BankAccount::findOrFail($expense->bank_account_id);
                        $bankAccount->addBalance($expense->amount);
                        $bankAccount1 = BankAccount::findOrFail($request->bank_account_id);
                        if ($request->amount !== null) {
                            $bankAccount1->subBalance($request->amount);
                        } else {
                            $bankAccount1->subBalance($expense->amount);
                        }
                    }
                } elseif ($request->transaction_type == 'Cash') {
                    $bankAccount = BankAccount::findOrFail($expense->bank_account_id);
                    $bankAccount->addBalance($expense->amount);
                }
            } else {
                if (($expense->transaction_type == 'Cheque') or ($expense->transaction_type == 'OnlineTransaction')) {
                    if (($expense->bank_account_id != $request->bank_account_id) && ($request->bank_account_id !== null)) {
                        $bankAccount = BankAccount::findOrFail($expense->bank_account_id);
                        $bankAccount->addBalance($expense->amount);
                        $bankAccount1 = BankAccount::findOrFail($request->bank_account_id);
                        if ($request->amount !== null) {
                            $bankAccount1->subBalance($request->amount);
                        } else {
                            $bankAccount1->subBalance($expense->amount);
                        }
                    }
                }
            }
            if ($request->hasFile('file')) {
                $fileHelper = new SamundraFileHelper();
                $file = $fileHelper->saveFile($request->file, 'budget');
                if ($file['success'] !== true) {
                    return response(['success' => false, 'message' => 'Data could not be saved at the moment', "data" => null], 400);
                }
                if ($expense->file_id === null) {
                    $newFile = new File();
                } else {
                    $newFile = File::where('id', $expense->file_id)->first();
                    if ($newFile === null) {
                        $newFile = new File();
                    } else {
                        $hasdata = 1;
                        $fileHelper->deleteFile($newFile->path);
                    }
                }

                $newFile->extension = $file['data']['extension'];
                $newFile->original_name = $file['data']['original_filename'];
                $newFile->name = $file['data']['filename'];
                $newFile->type = $file['data']['mime_type'];
                $newFile->path = $file['data']['link'];
                if ($hasdata === 1) {
                    $newFile->update();
                } else {
                    $newFile->save();
                }
                $values['file_id'] = $newFile->id;
            }
            $expense->update($values);
            event(new ActivityLogEvent('Edit', 'Expense', $expense->id));
            $data['message'] = "Updated successfully.";
            $data['data'] = new ExpenseResource($expense);
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
            $expense = Expense::findOrFail($id);
            $expense->delete();
            event(new ActivityLogEvent('Delete', 'Expense', $id));
            $data['message'] = "Deleted successfully.";
        } catch (\Exception $e) {
            return response(['success' => false, "message" => trans('messages.error_server'), "data" => $e], 500);
        }
        return $data;
    }
}
