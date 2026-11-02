<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Pārtika',
            'Dzērieni',
            'Saldumi',
            'Piena produkti',
            'Gaļa',
            'Dārzeņi',
            'Augļi',
            'Saldēti produkti',
            'Organisks',
            'Bez glutēna',
            'Bez laktozes',
            'Akcija',
            'Populārs',
            'Jaunums',
            'Ātri bojājošs',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate([
                'name' => $tag,
            ]);
        }
    }
}
