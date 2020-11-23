<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContactTest extends TestCase
{
    public function testImportCsvWithoutCustomAttributes()
    {
        // $this->withoutExceptionHandling();

        Storage::fake('uploads');

        $header = 'id,team_id,name,phone,email,sticky_phone_number_id,created_at,updated_at';
        $row1 = '1,430525,Alene Cassin,(772) 363-8718,silas21@klein.com,665,22/11/2020 00:51,22/11/2020 00:51';
        $row2 = '2,567816,Winfield Baumbach,285-219-6267 x53717,harrison78@yahoo.com,788,22/11/2020 00:51,22/11/2020 00:51';


        $content = implode("\n", [$header, $row1, $row2]);

        $inputs = [
            'file' =>
            UploadedFile::fake()->createWithContent(
                    'test.csv',
                    $content
                )
        ];


        $response = $this->postJson(
            'api/contacts',
            $inputs
        );

        $response->assertOk();
    }

    /**
     * @return void
     */
    public function testImportCsvWithCustomAttributes()
    {
        $this->withoutExceptionHandling();

        Storage::fake('uploads');

        $header = 'id,team_id,name,phone,email,sticky_phone_number_id,created_at,updated_at,company_name,home_address,group';
        $row1 = '3,479867,Mona Considine,282.829.8550 x97543,aditya.abshire@murphy.com,247,22/11/2020 00:51,22/11/2020 00:51,XYZ Company,P2 Somewhere Place,Friends';
        $row2 = '4,507220,Ramon Kertzmann,640.613.2390 x677,sbarrows@brakus.com,884,22/11/2020 00:51,22/11/2020 00:51,ABC Llc,Bravo 3-1 Place,Family';


        $content = implode("\n", [$header, $row1, $row2]);

        $inputs = [
            'file' =>
            UploadedFile::fake()->createWithContent(
                    'test.csv',
                    $content
                )
        ];


        $response = $this->postJson(
            'api/contacts',
            $inputs
        );

        $response->assertOk();
    }

    /**
     * @return void
     */
    public function testPreventImportCsvWithHeadersOnly()
    {
        // $this->withoutExceptionHandling();

        Storage::fake('uploads');

        $header = 'id,team_id,name,phone,email,sticky_phone_number_id,created_at,updated_at,company_name,home_address,group';


        $content = implode("\n", [$header]);

        $inputs = [
            'file' =>
            UploadedFile::fake()->createWithContent(
                    'test.csv',
                    $content
                )
        ];


        $response = $this->postJson(
            'api/contacts',
            $inputs
        );

        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testPreventImportCsvWithDifferentHeadersOrDataset()
    {
        // $this->withoutExceptionHandling();

        Storage::fake('uploads');

        $header = 'facility,total_incursions,total_operations,incursion_rate';
        $row1 = 'ABE,255,334,0.535';
        $row2 = 'ATL,145,201,0.222';

        $content = implode("\n", [$header, $row1, $row2]);

        $inputs = [
            'file' =>
            UploadedFile::fake()->createWithContent(
                    'test.csv',
                    $content
                )
        ];


        $response = $this->postJson(
            'api/contacts',
            $inputs
        );

        $response->assertStatus(422);
    }
}
