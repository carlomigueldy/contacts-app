<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Repository\ContactRepositoryInterface;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::factory(50)->create();
    }
}
