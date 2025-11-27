# Kitchen Inventory System Implementation Guide

## Overview
Your kitchen inventory system is now fully implemented with automatic stock deduction when orders are placed. This system prevents overselling and keeps track of ingredients across all menu items.

## Database Structure

### Tables Created
1. **orders** - Stores completed orders
   - id, total, timestamps

2. **order_items** - Individual items within each order
   - id, order_id, product_id, quantity, price, subtotal, timestamps

3. **product_recipes** - Links products to their required ingredients
   - id, product_id, inventory_item_id, quantity_needed, timestamps

4. **inventory_items** - Kitchen ingredients/stock
   - id, name, category, quantity, unit, min_stock, unit_price, supplier, timestamps

## Models Created/Updated

### New Models
- `App\Models\Order` - Represents a complete order
- `App\Models\OrderItem` - Represents individual items in an order
- `App\Models\ProductRecipe` - Links products to inventory items with quantities needed

### Updated Models
- `App\Models\Product` - Added relationships for recipes and order items
- `App\Models\InventoryItem` - Already had relationships set up

## How the System Works

### 1. Setting Up Product Recipes
You need to define which ingredients are needed for each product. Use the product_recipes table:

```php
// Example: Creating a recipe for a ramen dish
ProductRecipe::create([
    'product_id' => 1,           // Ramen product
    'inventory_item_id' => 5,    // Egg ingredient
    'quantity_needed' => 2       // Need 2 eggs per ramen
]);

ProductRecipe::create([
    'product_id' => 1,
    'inventory_item_id' => 8,    // Noodles
    'quantity_needed' => 0.3     // Need 0.3 kg of noodles
]);
```

### 2. Creating an Order
When a customer places an order, the frontend sends:

```javascript
{
    items: [
        {
            product_id: 1,
            quantity: 2,        // Order 2 portions of ramen
            price: 120,
            subtotal: 240
        }
    ],
    total: 240
}
```

### 3. Inventory Deduction Process
The OrderController automatically:

1. **Creates an Order record** with the total
2. **Creates OrderItem records** for each item ordered
3. **For each ordered item**:
   - Finds all recipes for that product
   - For each ingredient in the recipe:
     - Calculates: `quantity_to_deduct = quantity_needed × order_quantity`
     - Example: If recipe needs 2 eggs per ramen, and customer orders 3 ramens
     - Deduction = 2 × 3 = 6 eggs
   - Checks if sufficient stock exists
   - If enough: Deducts the amount from inventory
   - If not enough: Throws error and rolls back entire transaction

## API Endpoints

### POST /orders
Creates an order and automatically deducts inventory.

**Request:**
```json
{
    "items": [
        {
            "product_id": 1,
            "quantity": 2,
            "price": 120,
            "subtotal": 240
        }
    ],
    "total": 240
}
```

**Success Response (201):**
```json
{
    "success": true,
    "order_id": 5
}
```

**Error Response (422):**
```json
{
    "success": false,
    "message": "Insufficient stock for Eggs. Required: 6, Available: 3"
}
```

### POST /save-sale
Records the sale (existing endpoint - kept for backward compatibility)

## Frontend Integration

The order form in `/Order/order.blade.php` has been updated to:

1. Collect order items with product_id, quantity, price
2. Call POST /orders to deduct inventory
3. If successful, then call POST /save-sale to record sale
4. If failed, show error message and don't proceed to receipt

## Step-by-Step Setup

### 1. Run Migrations
```bash
php artisan migrate
```

This creates the required tables.

### 2. Define Your Product Recipes
In your application, add recipes for each product. You can do this via:

**Option A: Database Seeder**
```php
// database/seeders/ProductRecipeSeeder.php
use App\Models\ProductRecipe;

ProductRecipe::create([
    'product_id' => 1,
    'inventory_item_id' => 1,
    'quantity_needed' => 2
]);
```

**Option B: Admin Interface (Create one)**
Create a form to let administrators add recipes for products.

**Option C: Raw SQL/Laravel Tinker**
```bash
php artisan tinker
> App\Models\ProductRecipe::create(['product_id' => 1, 'inventory_item_id' => 1, 'quantity_needed' => 2])
```

### 3. Set Initial Inventory
Make sure your inventory_items table has initial stock:

```php
InventoryItem::create([
    'name' => 'Eggs',
    'category' => 'Proteins',
    'quantity' => 100,
    'unit' => 'pieces',
    'min_stock' => 10,
    'unit_price' => 5,
    'supplier' => 'Local Farm'
]);
```

### 4. Test the System

1. Place a test order from the order page
2. Check inventory levels before and after
3. Verify inventory_items.quantity has been reduced correctly

## Troubleshooting

### Issue: Inventory not deducting
**Solution:** Ensure ProductRecipe records exist linking products to ingredients

### Issue: Error "Insufficient stock"
**Solution:** Either:
- Increase inventory levels in inventory_items table
- Reduce the quantity needed in product_recipes table
- Don't accept orders for out-of-stock items

### Issue: Orders not created
**Solution:** 
- Check order_items table has foreign key constraint satisfied
- Ensure product_id exists in products table
- Check database permissions

## Database Relationships

```
Product (1) ──→ (Many) ProductRecipe ──→ (1) InventoryItem
           ─→ (Many) OrderItem

Order (1) ──→ (Many) OrderItem ──→ (1) Product

InventoryItem (1) ──→ (Many) ProductRecipe ──→ (1) Product
```

## Key Features

✅ Automatic inventory deduction when orders are placed
✅ Transaction-based - all or nothing (prevents partial stock updates)
✅ Stock validation before deduction (prevents negative stock)
✅ Detailed error messages if stock is insufficient
✅ Support for decimal quantities (e.g., 0.5 kg, 2.5 liters)
✅ Product can have multiple ingredients in various quantities
✅ Complete audit trail via order_items table

## Security Notes

- All inventory deductions happen in database transactions
- If an error occurs midway, entire order is rolled back
- Users cannot manually bypass inventory checks (happens server-side)
- CSRF tokens protect all POST requests

## Next Steps

1. Create an admin panel to manage ProductRecipes
2. Add inventory alerts for low stock items
3. Create reports showing inventory usage over time
4. Implement automatic purchase orders when stock is low
5. Add expiration date tracking for perishables
