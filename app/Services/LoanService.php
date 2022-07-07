<?php

namespace App\Services;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class LoanService extends BaseService
{
    public function create(Request $request): Loan
    {

        $loan = Loan::create([
            'user_id' => Auth::id(),
            'loan_amount' => $request->loan_amount,
            'status' => $request->status,
            'loan_type' => $request->loan_type,
            'duration' => $request->duration,
        ]);


        return $loan;
    }


    public function update(Request $request, $id)
    {

        $loan = Loan::find($id)->update(
            [
                'loan_amount' => $request->loan_amount,
                'status' => $request->status,
                'loan_type' => $request->loan_type,
                'duration' => $request->duration,
            ]
        );

        return $loan;
    }


    public function list(Request $request, $model = '')
    {
        $loan = Loan::with('user');

        if ($request->q) {
            $loan = $loan->where('name', 'LIKE', "%{$request->q}%");
        }

        if ($request->paginated == 'true') {
            $loan = $loan->paginate(20);
        } else {
            $loan = $loan->get();
        }

        return $loan;
    }

    public function find($modelId)
    {
        return Loan::with('user')->find($modelId);
    }

    public function delete($modelId)
    {
        $loan = Loan::find($modelId);
        if ($loan) {
            $loan->delete();
        }
    }
}
