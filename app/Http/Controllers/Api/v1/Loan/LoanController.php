<?php

namespace App\Http\Controllers\Api\v1\Loan;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Http\Requests\Loan\LoanFormRequest;
use App\Services\LoanService;

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
            message: __('settings.model_saved', ['model' =>'Loan'])
        ))->asSuccessful();
    }

    /**
     * Update a loan request.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateLoan(Request $request, $id)
    {
        //
    }

    /**
     * View a loan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewLoan(Request $request, $id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function listLoan(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function deleteLoan(Request $request, $id)
    {
        //
    }

        /**
     * Approve a loan.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function approveLoan(Request $request)
    {
        //
    }

    /**
     * Decline a loan
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function declineLoan(Request $request)
    {
        //
    }
}
