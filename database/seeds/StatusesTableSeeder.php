<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = factory(Status::class, 50)->make()->each(function ($status) {
            $status->user_id = rand(1,3);
        });
        Status::insert($statuses->toArray());
    }
}
