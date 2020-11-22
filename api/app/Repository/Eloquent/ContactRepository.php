<?php

namespace App\Repository\Eloquent;

use App\Models\Contact;
use App\Repository\ContactRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }

    public function get(): Collection
    {
        return $this->model->get();
    }

    public function findById(int $modelId): ?Model
    {
        return $this->model->findOrFail($modelId);
    }

    public function import($path)
    {
        // get the csv file to import in
        $csvData = collect(array_map('str_getcsv', file($path)));

        // fixed headers for Contact model
        $headers = ['team_id', 'name', 'phone', 'email', 'sticky_phone_number_id'];
        $csvHeaders = $csvData[0];

        // map the array with corresponding key-value pairs
        $mappedData = $csvData->filter(function ($item, $key) {
            return $key != 0;
        })
            ->map(function ($item, $key) use ($csvHeaders) {
                $data = [];

                foreach ($csvHeaders as $index => $csvHeader) {
                    $data[Str::lower($csvHeader)] = $item[$index];
                }

                return $data;
            });

        // loop through the mapped array, insert new records for contacts
        // and create records to fields with custom attributes
        foreach ($mappedData as $item) {
            $contact = $this->create([
                'team_id' => $item['team_id'],
                'name' => $item['name'],
                'phone' => $item['phone'],
                'email' => $item['email'],
                'sticky_phone_number_id' => $item['sticky_phone_number_id']
            ]);

            $customAttributes = array_filter(array_keys($item), function ($value) use ($headers) {
                return !in_array($value, $headers);
            }) ?? [];

            foreach ($customAttributes as $customAttribute) {
                $contact->customAttributes()->create([
                    'key' => $customAttribute,
                    'value' => $item[$customAttribute]
                ]);
            }
        }
    }
}
