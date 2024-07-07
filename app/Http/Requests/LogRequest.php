<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $logId = $this->route('log'); // Get the log ID from the route if it exists

        return [
            'id_users' => 'required|exists:users,id',
            'tipe_aktivitas' => 'required|string|max:255',
            'tabel_terkait' => 'required|string|max:255',
            'data_sebelum' => 'nullable|string',
            'data_sesudah' => 'nullable|string',
            'email' => [
                'required',
                'email',
                Rule::unique('pegawais', 'email')->ignore($this->user ? $this->user->id : null),
        ];
    }
}
