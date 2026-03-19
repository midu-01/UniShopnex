<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:pending,processing,shipped,completed,cancelled'],
            'payment_status' => ['required', 'in:unpaid,paid,refunded'],
        ];
    }
}
