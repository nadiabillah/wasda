<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsnSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('asn')->insert([
            [
                'name' => 'Budi Santoso',
                'phone' => '6281234567890',
                'email' => 'budi@sidoarjokab.go.id',
            ],
            [
                'name' => 'Siti Aminah',
                'phone' => '6282234567890',
                'email' => 'siti@sidoarjokab.go.id',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'phone' => '6283134567890',
                'email' => 'ahmad@sidoarjokab.go.id',
            ],
            [
                'name' => 'Dewi Lestari',
                'phone' => '6284234567890',
                'email' => 'dewi@sidoarjokab.go.id',
            ],
            [
                'name' => 'Agus Pratama',
                'phone' => '6285234567890',
                'email' => 'agus@sidoarjokab.go.id',
            ],
            [
                'name' => 'Nurul Hidayah',
                'phone' => '6286234567890',
                'email' => 'nurul@sidoarjokab.go.id',
            ],
            [
                'name' => 'Hendra Wijaya',
                'phone' => '6287234567890',
                'email' => 'hendra@sidoarjokab.go.id',
            ],
            [
                'name' => 'Ratna Sari',
                'phone' => '6288234567890',
                'email' => 'ratna@sidoarjokab.go.id',
            ],
            [
                'name' => 'Fajar Nugroho',
                'phone' => '6289234567890',
                'email' => 'fajar@sidoarjokab.go.id',
            ],
            [
                'name' => 'Indah Puspita',
                'phone' => '6281334567891',
                'email' => 'indah@sidoarjokab.go.id',
            ],
        ]);
    }
}