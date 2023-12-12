<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample data for activities table
        $activity = [
            'category_id' => 1, // Replace with your actual category_id
            'user_id' => 1, // Replace with your actual user_id
            'kode_donasi' => 'D123456',
            'judul_activity' => 'Sample Activity',
            'judul_slug' => 'sample-activity',
            'foto_activity' => 'sample_image.jpg',
            'detail_activity' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'batas_waktu' => '2023-12-31', // Replace with your actual deadline
            'waktu_activity' => '2023-01-01 12:00:00', // Replace with your actual date and time
            'lokasi' => 'Sample Location',
            'tipe_activity' => 'Virtual',
            'status_publish' => 'published',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Insert data into the activities table
        DB::table('activities')->insert($activity);
    }
}