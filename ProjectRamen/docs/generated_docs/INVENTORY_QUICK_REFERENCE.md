# Quick Reference - Kitchen Inventory System

## Files Modified/Created

### New Model Files
- `app/Models/Order.php` - Order model with items relationship
- `app/Models/OrderItem.php` - Individual order item model
- `app/Models/ProductRecipe.php` - Product ingredient mapping model

### Updated Model Files
- `app/Models/Product.php` - Added recipes(), inventoryItems(), orderItems() relationships

### Controller Files
- `app/Http/Controllers/OrderController.php` - Updated store() method with:
  - Request validation
  - Transaction support
  - Inventory deduction logic
  - Error handling for insufficient stock

### Migration Files
- `database/migrations/2025_11_27_000000_create_orders_table.php`
- `database/migrations/2025_11_27_000001_create_order_items_table.php`
- `database/migrations/2025_11_18_103433_create_product_recipes_table.php` (Updated)

### Route Files
- `routes/web.php` - Added POST /orders route

### View Files
- `resources/views/Order/order.blade.php` - Updated order submission logic

## Database Schema

### orders table
```
id (bigint, PK)
total (decimal 10,2)
created_at (timestamp)
updated_at (timestamp)
```

### order_items table
```
id (bigint, PK)
order_id (bigint, FK → orders.id)
product_id (bigint, FK → product.id)
quantity (integer)
price (decimal 10,2)
subtotal (decimal 10,2)
created_at (timestamp)
updated_at (timestamp)
```

### product_recipes table
```
id (bigint, PK)
product_id (bigint, FK → product.id)
inventory_item_id (bigint, FK → inventory_items.id)
quantity_needed (decimal 10,2)
created_at (timestamp)
updated_at (timestamp)
```

## How Deduction Works

1. User places order with items
2. Frontend sends: `POST /orders` with items array
3. OrderController.store():
   - Validates request
   - Starts transaction
   - Creates Order record
   - For each ordered item:
     - Creates OrderItem record
     - Finds product recipes
     - For each recipe:
       - Gets inventory item
       - Calculates deduction: recipe.quantity_needed × item.quantity
       - Validates sufficient stock exists
       - Deducts from inventory using decrement()
   - If any error: transaction rolls back (no changes)
   - Returns success or error response
4. Frontend then creates Sale record via /save-sale
5. User is redirected to receipt

## Important Gotchas

1. **ProductRecipe MUST exist** - If no recipes defined, nothing gets deducted
2. **Inventory must have stock** - Orders fail if insufficient ingredients
3. **Quantity types** - Can use decimals: 0.5, 1.5, 2.3 etc.
4. **Transactions matter** - If ANY ingredient fails, entire order fails
5. **Product ID linking** - Product in order.blade.php must use correct product_id from database

## Example Usage

### Adding a Recipe (via Laravel Tinker or Seeder)
```php
App\Models\ProductRecipe::create([
    'product_id' => 1,
    'inventory_item_id' => 3,
    'quantity_needed' => 2
]);
```

### Checking Inventory
```php
App\Models\InventoryItem::find(3)->quantity;  // Returns current stock
```

### Viewing Orders Created
```php
App\Models\Order::with('items')->latest()->get();
```

### Testing Stock Deduction
1. Check inventory before order: `select quantity from inventory_items where id=3;`
2. Place order requiring that ingredient
3. Check inventory after: quantity should be reduced
4. Try ordering more than available: should fail with error message

## Common SQL Queries

### See all recipes for a product
```sql
SELECT pr.id, ii.name, pr.quantity_needed 
FROM product_recipes pr
JOIN inventory_items ii ON pr.inventory_item_id = ii.id
WHERE pr.product_id = 1;
```

### Check inventory levels
```sql
SELECT name, quantity, min_stock, 
       CASE WHEN quantity = 0 THEN 'Out of Stock'
            WHEN quantity <= min_stock THEN 'Low Stock'
            ELSE 'In Stock'
       END as status
FROM inventory_items
ORDER BY quantity ASC;
```

### See all orders with items
```sql
SELECT o.id, o.total, oi.product_id, oi.quantity, oi.subtotal
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
ORDER BY o.created_at DESC;
```

## API Response Examples

### Successful Order
```
POST /orders
Status: 201
{
    "success": true,
    "order_id": 5
}
```

### Failed Order (Insufficient Stock)
```
POST /orders
Status: 422
{
    "success": false,
    "message": "Insufficient stock for Eggs. Required: 6, Available: 3"
}
```

### Failed Order (Validation Error)
```
POST /orders
Status: 422
{
    "message": "The given data was invalid.",
    "errors": {
        "items.0.product_id": ["The selected product id is invalid."]
    }
}
```
