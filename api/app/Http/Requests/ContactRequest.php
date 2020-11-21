<?php

namespace App\Http\Requests;

use App\Repository\ContactRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * @var ContactRepositoryInterface
     */
    protected $contactRepository;

    /**
     * @param ContactRepositoryInterface $contactRepository
     */
    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param int $userId
     * @return User
     */
    public function persist($userId = null)
    {
        $user = null;

        if ($this->method() == "POST") {
            $user = $this->contactRepository->create($this->all());
        }

        return $user;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'team_id' => 'required',
            // 'name' => 'required',
            'phone' => 'required',
            // 'email' => 'required',
            // 'sticky_phone_number_id' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'team_id' => 'Team ID',
        ];
    }
}
