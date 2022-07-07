<?php

namespace App\Http\Controllers\Api\v1\Loan;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Http\Requests\Loan\LoanFormRequest;
use App\Models\User;
use App\Services\LoanService;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Create a loan request.
     *
     * @return \Illuminate\Http\Response
     */
    public function createLoan(LoanFormRequest $request, LoanService $loanService)
    {
        $loan = $loanService->create($request);

        return (new ApiResponse(
            data: $loan->toArray(),
            message: __('settings.model_saved', ['model' => 'loan request'])
        ))->asSuccessful();
    }

    /**
     * Update a loan request.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateLoan(LoanFormRequest $request, LoanService $loanService, $id)
    {
        $loan = $loanService->update($request, $id);

        return (new ApiResponse(
            message: __('settings.model_updated', ['model' => 'loan request'])
        ))->asSuccessful();
    }

    /**
     * View a loan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewLoan(LoanService $loanService, $id)
    {
        $loan = $loanService->find($id);

        if (!$loan) {
            return (new ApiResponse(
                message: __('settings.model_not_exist', ['model' => 'loan request'])
            ))->asBadRequest();
        }

        $loan = Loan::with('user')->where('id', $id)->first();

        return (new ApiResponse(
            data: $loan->toArray()
        ))->asSuccessful();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function listLoan(Request $request, LoanService $loanService)
    {
        $loan = $loanService->list($request);

        return (new ApiResponse(
            data: $loan->toArray()
        ))->asSuccessful();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function deleteLoan(LoanService $loanService, $id)
    {
        $loan = $loanService->find($id);

        if (!$loan) {
            return (new ApiResponse(
                message: __('settings.model_not_exist', ['model' => 'loan request'])
            ))->asBadRequest();
        }

        $delete_loan = $loanService->delete($id);

        return (new ApiResponse(
            message: __('settings.model_deleted', ['model' => 'loan request'])
        ))->asSuccessful();
    }

    /**
     * Approve a loan.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function approveLoan(Request $request, LoanService $loanService)
    {
        $loan = $loanService->pendingLoan($request);

        if (!$loan) {

            return (new ApiResponse(
                message: __('settings.model_not_exist', ['model' => 'loan request'])
            ))->asNotFound();
        }

        $loan_requester = $loan->user_id;
        $user_id = Auth::id();
        $check_id = User::where('id', $loan_requester)->first()->id;
        if ($user_id == $check_id) {
            return (new ApiResponse(
                message: __('settings.model_cannot_approve_self', ['model' => 'loan request'])
            ))->asNotFound();
        }
        
        $loan = $loanService->approve($request);

        return (new ApiResponse(
            message: __('settings.model_approved', ['model' => 'loan request'])
        ))->asSuccessful();
    }

    /**
     * Decline a loan
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function declineLoan(Request $request, LoanService $loanService)
    {
        $loan = $loanService->pendingLoan($request);

        if (!$loan) {

            return (new ApiResponse(
                message: __('settings.model_not_exist', ['model' => 'loan request'])
            ))->asNotFound();
        }

        $loan_requester = $loan->user_id;
        $user_id = Auth::id();
        $check_id = User::where('id', $loan_requester)->first()->id;
        if ($user_id == $check_id) {
            return (new ApiResponse(
                message: __('settings.model_cannot_decline_self', ['model' => 'loan request'])
            ))->asNotFound();
        }

        $loan = $loanService->decline($request);

        return (new ApiResponse(
            message: __('settings.model_declined', ['model' => 'loan request'])
        ))->asSuccessful();
    }
}
