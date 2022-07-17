<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Bank;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BankRepository
{
    /**
     * Get member collection paginate.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return Bank::orderBy('id', 'desc');
    }

    public function getBank($id)
    {
        return Bank::find($id);
    }

    public function create($request)
    {
        $bank = new Bank();
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            $img_name = 'upload/banks/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/banks/img/' . $date);
            $img->move($destinationPath, $img_name);

            $bank->image = $img_name;
        }
        $bank->account_name = $request->account_name;
        $bank->account_number = $request->account_number;
        $bank->bank_name = $request->bank_name;
        $bank->branch = $request->branch;
        $bank->save();
    }

    public function update($request, $id)
    {
        $bank = Bank::find($id);
        $date = Carbon::now()->format('d-m-Y');
        $img = $request->image;
        if (isset($img)) {
            if (isset($bank->image)) {
                unlink(public_path($bank->image));
            }
            $img_name = 'upload/banks/img/' . $date . '/' . Str::random(10) . rand() . '.' . $img->getClientOriginalExtension();
            $destinationPath = public_path('upload/banks/img/' . $date);
            $img->move($destinationPath, $img_name);

            $bank->image = $img_name;
        }

        $bank->account_name = $request->account_name;
        $bank->account_number = $request->account_number;
        $bank->bank_name = $request->bank_name;
        $bank->branch = $request->branch;
        $bank->save();
    }

    public function destroy($id)
    {
        $bank = Bank::find($id);
        if (isset($bank->image)) {
            unlink(public_path($bank->image));
        }
        $bank->delete();
    }

}
