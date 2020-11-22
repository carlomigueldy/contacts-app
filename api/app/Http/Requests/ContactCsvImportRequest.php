<?php

namespace App\Http\Requests;

use App\Repository\ContactRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class ContactCsvImportRequest extends FormRequest
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
     * @param int $contactId
     * @return Contact
     */
    public function persist($contactId = null)
    {
        $contact = null;

        if ($this->method() == "POST") {
            $contact = $this->contactRepository->import(
                $this->file('file')->getRealPath()
            );
        }

        return $contact;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|file',
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
            //
        ];
    }
}
