<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EnergySection;

class EnergySectionSeeder extends Seeder
{
    public function run(): void
    {
        if (EnergySection::count() === 0) {
            EnergySection::create([
                'is_active' => true,
                'title' => 'The energy I put into aliquet cursus er integer urna, vestibulum cras bibendum diam sem eros amet malesuada.',
                'text_1' => 'Imperdiet quis sollicitudin vulputate velit id eget donec sed adipiscing turpis tristique aenean nulla dolor eu in habitasse vestibulum, blandit sem sed tempus.',
                'text_2' => 'Malesuada id lorem non magna tortor duis sit blandit pulvinar enim turpis dui purus augue nec, eget sit sapien aliquam iaculis at erat sit porttitor massa tristique feugiat aliquam pellentesque vulputate tincidunt augue at duis mauris dictum urna amet ut quisque.',
                'read_more_url' => '#',
                'instagram_count' => '1.8M+',
                'tumblr_count' => '800K+',
                'facebook_count' => '1.2M+',
            ]);
        }
    }
}
