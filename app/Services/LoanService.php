<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LoanApprovalRequestNotification;
use App\Helpers\ApiResponse;
use App\Notifications\LoanApprovedNotification;
use App\Notifications\LoanDeclinedNotification;

class LoanService extends BaseService
{
    public function create(Request $request): Loan
    {
        $loan = Loan::create([
            'user_id' => Auth::id(),
            'loan_amount' => $request->loan_amount,
            'status' => 'pending',
            'loan_type' => $request->loan_type,
            'duration' => $request->duration,
        ]);

        $users = User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'Admin');
            }
        )->get();

        if($users){
            foreach($users as $user){
                Notification::send($user, new LoanApprovalRequestNotification($user));
            }
        }

        return $loan;
    }


    public function update(Request $request, $id)
    {

        $loan = Loan::find($id)->update(
            [
                'loan_amount' => $request->loan_amount,
                'status' => 'pending',
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

    public function approve(Request $request)
    {
        $loan = Loan::where('status', 'pending')->find($request->id);

        if($loan){        
            $loan->update(['status' => 'approved']);

            $loan_requester = $loan->user_id;
            $user = User::where('id', $loan_requester)->first();
            if($user){
                Notification::send($user, new LoanApprovedNotification($user));
            }
            
        }

        return $loan;
    }

    public function decline(Request $request)
    {
        $loan = Loan::where('status', 'pending')->find($request->id);

        if($loan){
            $loan->update(['status' => 'rejected']);

            $loan_requester = $loan->user_id;
            $user = User::where('id', $loan_requester)->first();
            if($user){
                Notification::send($user, new LoanDeclinedNotification($user));
            }
        }

        return $loan;
    }

    public function pendingLoan(Request $request)
    {
        return Loan::where('status', 'pending')->find($request->id);
    }
}
