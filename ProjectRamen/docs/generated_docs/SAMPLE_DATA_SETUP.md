# Sample Data Setup - Kitchen Inventory System

## How to Add Sample Data

You have two options:

### Option 1: Using Laravel Tinker (Interactive)
```bash
php artisan tinker
```

Then run these commands:

#### Add Inventory Items
```php
// Create inventory items
App\Models\InventoryItem::create([
    'name' => 'Ramen Noodles',
    'category' => 'Noodles',
    'quantity' => 50,
    'unit' => 'kg',
    'min_stock' => 5,
    'unit_price' => 200,
    'supplier' => 'Local Supplier'
]);

App\Models\InventoryItem::create([
    'name' => 'Eggs',
    'category' => 'Proteins',
    'quantity' => 100,
    'unit' => 'pieces',
    'min_stock' => 20,
    'unit_price' => 5,
    'supplier' => 'Farm Fresh'
]);

App\Models\InventoryItem::create([
    'name' => 'Chicken Broth',
    'category' => 'Broth',
    'quantity' => 30,
    'unit' => 'liters',
    'min_stock' => 5,
    'unit_price' => 100,
    'supplier' => 'Local Supplier'
]);

App\Models\InventoryItem::create([
    'name' => 'Green Onions',
    'category' => 'Vegetables',
    'quantity' => 20,
    'unit' => 'bundles',
    'min_stock' => 3,
    'unit_price' => 50,
    'supplier' => 'Market'
]);

App\Models\InventoryItem::create([
    'name' => 'Pork Belly',
    'category' => 'Proteins',
    'quantity' => 15,
    'unit' => 'kg',
    'min_stock' => 2,
    'unit_price' => 500,
    'supplier' => 'Butcher Shop'
]);

App\Models\InventoryItem::create([
    'name' => 'Soft Boiled Eggs Topping',
    'category' => 'Toppings',
    'quantity' => 50,
    'unit' => 'pieces',
    'min_stock' => 10,
    'unit_price' => 15,
    'supplier' => 'In-house'
]);
```

#### Verify Inventory was created
```php
App\Models\InventoryItem::all();
```

#### Add Product Recipes
```php
// Assuming product_id 1 is your main Ramen product
// Recipe: 1 Ramen needs 0.3kg noodles, 1L broth, 2 eggs, 1 topping

App\Models\ProductRecipe::create([
    'product_id' => 1,
    'inventory_item_id' => 1,  // Ramen Noodles
    'quantity_needed' => 0.3
]);

App\Models\ProductRecipe::create([
    'product_id' => 1,
    'inventory_item_id' => 3,  // Chicken Broth
    'quantity_needed' => 1
]);

App\Models\ProductRecipe::create([
    'product_id' => 1,
    'inventory_item_id' => 2,  // Eggs
    'quantity_needed' => 2
]);

App\Models\ProductRecipe::create([
    'product_id' => 1,
    'inventory_item_id' => 6,  // Soft Boiled Eggs Topping
    'quantity_needed' => 1
]);
```

#### Verify recipes
```php
App\Models\ProductRecipe::with('inventoryItem')->get();
```

#### Test Inventory Deduction
```php
// Check initial inventory
App\Models\InventoryItem::find(2)->quantity;  // Should be 100 (eggs)

// Create a test order (order 2 ramen)
$order = App\Models\Order::create(['total' => 240]);

App\Models\OrderItem::create([
    'order_id' => $order->id,
    'product_id' => 1,
    'quantity' => 2,
    'price' => 120,
    'subtotal' => 240
]);

// Get recipes for product 1
$recipes = App\Models\ProductRecipe::where('product_id', 1)->get();

foreach ($recipes as $recipe) {
    $ingredient = App\Models\InventoryItem::find($recipe->inventory_item_id);
    $deductQty = $recipe->quantity_needed * 2;  // 2 ramens ordered
    $ingredient->decrement('quantity', $deductQty);
}

// Check inventory after
App\Models\InventoryItem::find(2)->quantity;  // Should be 96 (100 - 4 eggs used)
```

### Option 2: Using a Database Seeder

Create a seeder:
```bash
php artisan make:seeder InventorySeeder
```

Edit `database/seeders/InventorySeeder.php`:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InventoryItem;
use App\Models\ProductRecipe;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create inventory items
        $noodles = InventoryItem::create([
            'name' => 'Ramen Noodles',
            'category' => 'Noodles',
            'quantity' => 50,
            'unit' => 'kg',
            'min_stock' => 5,
            'unit_price' => 200,
            'supplier' => 'Local Supplier'
        ]);

        $eggs = InventoryItem::create([
            'name' => 'Eggs',
            'category' => 'Proteins',
            'quantity' => 100,
            'unit' => 'pieces',
            'min_stock' => 20,
            'unit_price' => 5,
            'supplier' => 'Farm Fresh'
        ]);

        $broth = InventoryItem::create([
            'name' => 'Chicken Broth',
            'category' => 'Broth',
            'quantity' => 30,
            'unit' => 'liters',
            'min_stock' => 5,
            'unit_price' => 100,
            'supplier' => 'Local Supplier'
        ]);

        $greenOnions = InventoryItem::create([
            'name' => 'Green Onions',
            'category' => 'Vegetables',
            'quantity' => 20,
            'unit' => 'bundles',
            'min_stock' => 3,
            'unit_price' => 50,
            'supplier' => 'Market'
        ]);

        $porkBelly = InventoryItem::create([
            'name' => 'Pork Belly',
            'category' => 'Proteins',
            'quantity' => 15,
            'unit' => 'kg',
            'min_stock' => 2,
            'unit_price' => 500,
            'supplier' => 'Butcher Shop'
        ]);

        $eggTopping = InventoryItem::create([
            'name' => 'Soft Boiled Eggs Topping',
            'category' => 'Toppings',
            'quantity' => 50,
            'unit' => 'pieces',
            'min_stock' => 10,
            'unit_price' => 15,
            'supplier' => 'In-house'
        ]);

        // Create recipes for product ID 1 (main ramen)
        ProductRecipe::create([
            'product_id' => 1,
            'inventory_item_id' => $noodles->id,
            'quantity_needed' => 0.3
        ]);

        ProductRecipe::create([
            'product_id' => 1,
            'inventory_item_id' => $broth->id,
            'quantity_needed' => 1
        ]);

        ProductRecipe::create([
            'product_id' => 1,
            'inventory_item_id' => $eggs->id,
            'quantity_needed' => 2
        ]);

        ProductRecipe::create([
            'product_id' => 1,
            'inventory_item_id' => $eggTopping->id,
            'quantity_needed' => 1
        ]);

        // Optional: Create recipes for other products
        // ProductRecipe::create([
        //     'product_id' => 2,  // Different product
        //     'inventory_item_id' => $noodles->id,
        //     'quantity_needed' => 0.25
        // ]);
    }
}
```

Then run the seeder:
```bash
php artisan db:seed --class=InventorySeeder
```

Or update `database/seeders/DatabaseSeeder.php` and run `php artisan db:seed`:

```php
public function run(): void
{
    $this->call([
        InventorySeeder::class,
    ]);
}
```

### Option 3: Direct SQL

If you prefer direct SQL:

```sql
-- Insert inventory items
INSERT INTO inventory_items (name, category, quantity, unit, min_stock, unit_price, supplier, created_at, updated_at) VALUES
('Ramen Noodles', 'Noodles', 50, 'kg', 5, 200, 'Local Supplier', NOW(), NOW()),
('Eggs', 'Proteins', 100, 'pieces', 20, 5, 'Farm Fresh', NOW(), NOW()),
('Chicken Broth', 'Broth', 30, 'liters', 5, 100, 'Local Supplier', NOW(), NOW()),
('Green Onions', 'Vegetables', 20, 'bundles', 3, 50, 'Market', NOW(), NOW()),
('Pork Belly', 'Proteins', 15, 'kg', 2, 500, 'Butcher Shop', NOW(), NOW()),
('Soft Boiled Eggs Topping', 'Toppings', 50, 'pieces', 10, 15, 'In-house', NOW(), NOW());

-- Insert product recipes (assuming product_id 1 exists)
INSERT INTO product_recipes (product_id, inventory_item_id, quantity_needed, created_at, updated_at) VALUES
(1, 1, 0.3, NOW(), NOW()),  -- 0.3kg noodles per ramen
(1, 3, 1, NOW(), NOW()),    -- 1L broth per ramen
(1, 2, 2, NOW(), NOW()),    -- 2 eggs per ramen
(1, 6, 1, NOW(), NOW());    -- 1 topping per ramen
```

## Verification Steps

After adding data, verify everything:

```bash
php artisan tinker

# Check inventory
App\Models\InventoryItem::count();  # Should be >= 6

# Check recipes
App\Models\ProductRecipe::count();  # Should be >= 4

# Check relationships work
$product = App\Models\Product::with('recipes')->find(1);
$product->recipes;  # Should show recipes

# Check inventory items through recipes
$recipes = App\Models\ProductRecipe::where('product_id', 1)->get();
$recipes->each(function($r) { dd($r->inventoryItem->name); });
```

## Ready to Test!

Once you've added sample data:

1. Go to your order page
2. Try ordering a product (e.g., 2 ramen)
3. Complete the order
4. Check inventory_items table - quantities should be reduced
5. Try ordering more than available - should fail with error message

Good luck! 🍜
