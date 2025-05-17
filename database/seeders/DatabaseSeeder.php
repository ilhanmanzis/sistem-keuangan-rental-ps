<?php

namespace Database\Seeders;

use App\Models\Devices;
use App\Models\Makanans;
use App\Models\Members;
use App\Models\Minumans;
use App\Models\Profile;
use App\Models\Shifts;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'foto' => '1747275830d0482836-9ef5-42af-a238-9d642d861b68.png'
        ]);
        User::factory()->create([
            'name' => 'ilhan',
            'email' => 'ilhan@gmail.com',
            'username' => 'ilhan',
            'password' => Hash::make('ilhan'),
            'role' => 'karyawan',
            'foto' => '1747275848bc3b55e9-fb7c-4b93-ab8f-54cd4517095d.jpg'
        ]);
        Devices::factory()->create();
        Minumans::factory()->create();
        Members::factory()->create();
        Makanans::factory()->create();
        $shifts = [
            [
                'id_shift' => 1,
                'name' => 'Pagi',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '16:00:00'
            ],
            [
                'id_shift' => 2,
                'name' => 'Sore',
                'jam_mulai' => '16:00:00',
                'jam_selesai' => '00:00:00'
            ],
            [
                'id_shift' => 3,
                'name' => 'Malam',
                'jam_mulai' => '00:00:00',
                'jam_selesai' => '08:00:00'
            ]
        ];

        foreach ($shifts as $shift) {
            Shifts::factory()->create($shift);
        }
        Profile::factory()->create();
    }
}
