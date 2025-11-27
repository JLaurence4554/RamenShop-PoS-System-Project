<?php

namespace Database\Seeders;

use App\Models\Addon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample add-ons without inventory linking (set inventory_item_id to null for now)
        // You can manually link them to inventory items via the admin panel
        Addon::create([
            'name' => 'Ajitama Egg',
            'description' => 'Soft-boiled marinated egg',
            'price' => 25.00,
            'inventory_item_id' => null,
        ]);

        Addon::create([
            'name' => 'Nori Seaweed',
            'description' => 'Crispy seaweed sheet',
            'price' => 20.00,
            'inventory_item_id' => null,
        ]);

        Addon::create([
            'name' => 'Pork Chashu (3 pcs)',
            'description' => 'Tender braised pork slices',
            'price' => 65.00,
            'inventory_item_id' => null,
        ]);
    }
}
