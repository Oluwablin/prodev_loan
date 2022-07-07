<?php

namespace App\Http\Requests\Loan;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class LoanFormRequest extends BaseFormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'loan_amount' => 'required|float',
                    'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
                    'loan_type' => ['required', Rule::in(['days', 'months', 'year'])],
                    'duration' => 'required',
                ];
                break;
            case 'PUT':
                return [
                    'loan_amount' => 'required|float',
                    'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
                    'loan_type' => ['required', Rule::in(['days', 'months', 'year'])],
                    'duration' => 'required',
                ];
                break;
        }
    }
}
