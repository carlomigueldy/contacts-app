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

    /**
     * @param string $path
     * @return bool
     */
    public function import(string $path): bool
    {
        // get the csv file to import in
        $csvData = collect(array_map('str_getcsv', file($path)));

        // fixed headers for Contact model
        $headers = ['team_id', 'name', 'phone', 'email', 'sticky_phone_number_id'];
        $csvHeaders = $csvData[0];

        // check if has same headers, if not return false
        // then throw error abort() in Controller
        if (!$this->hasSameHeaders($headers, $csvHeaders)) return false;

        // map the array with corresponding key-value pairs
        $filteredData = $csvData->filter(function ($item, $key) {
            return $key != 0;
        });

        if (! (count($filteredData) > 0)) return false;

        $mappedData = $filteredData
            ->map(function ($item, $key) use ($csvHeaders) {
                $data = [];

                foreach ($csvHeaders as $index => $csvHeader) {
                    $data[Str::snake(Str::lower($csvHeader))] = $item[$index];
                }

                return $data;
            }) ?? [];

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

            // filter the array keys only getting custom attributes
            // if no custom attributes return empty array
            $customAttributes = array_filter(array_keys($item), function ($value) use ($headers) {
                return !in_array($value, $headers);
            }) ?? [];

            // create records for custom attributes associated to
            // the Contact model
            foreach ($customAttributes as $customAttribute) {
                $contact->customAttributes()->create([
                    'key' => $customAttribute,
                    'value' => $item[$customAttribute]
                ]);
            }
        }

        return true;
    }

    /**
     * Checks if the `needle` has at least the same match with provided `headers`.
     *
     * @return bool
     */
    private function hasSameHeaders(array $headers, array $needle): bool
    {
        $match = 0;

        foreach ($needle as $csvHeader) {
            if (in_array(Str::snake(Str::lower($csvHeader)), $headers)) $match++;
        }

        return $match != 0;
    }
}
