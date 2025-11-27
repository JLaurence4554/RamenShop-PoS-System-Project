# 🚀 Quick Start Guide - Kitchen Inventory System

## ⏱️ 5-Minute Setup

### Step 1: Verify Migrations (30 seconds)
```bash
php artisan migrate:status
```
You should see ✅ all migrations ran, including:
- `2025_11_27_000000_create_orders_table`
- `2025_11_27_000001_create_order_items_table`
- `2025_11_18_103433_create_product_recipes_table`

### Step 2: Add Sample Data (2 minutes)
Open your terminal and run:
```bash
php artisan tinker
```

Then paste this code:
```php
// Create inventory items
$noodles = App\Models\InventoryItem::create(['name'=>'Ramen Noodles','category'=>'Noodles','quantity'=>50,'unit'=>'kg','min_stock'=>5,'unit_price'=>200,'supplier'=>'Local']);
$eggs = App\Models\InventoryItem::create(['name'=>'Eggs','category'=>'Proteins','quantity'=>100,'unit'=>'pieces','min_stock'=>20,'unit_price'=>5,'supplier'=>'Farm']);
$broth = App\Models\InventoryItem::create(['name'=>'Broth','category'=>'Broth','quantity'=>30,'unit'=>'liters','min_stock'=>5,'unit_price'=>100,'supplier'=>'Local']);

// Create recipes for product 1 (assuming it exists)
App\Models\ProductRecipe::create(['product_id'=>1,'inventory_item_id'=>$noodles->id,'quantity_needed'=>0.3]);
App\Models\ProductRecipe::create(['product_id'=>1,'inventory_item_id'=>$eggs->id,'quantity_needed'=>2]);
App\Models\ProductRecipe::create(['product_id'=>1,'inventory_item_id'=>$broth->id,'quantity_needed'=>1]);

// Verify
App\Models\ProductRecipe::with('inventoryItem')->get();
```

Exit tinker: `exit`

### Step 3: Test the System (2 minutes)

1. Open your browser: http://localhost/ProjectRamen/order
2. Log in if needed
3. Order some items (e.g., 2x of product 1)
4. Complete the order
5. Check inventory levels decreased

**Done! ✅**

---

## 📊 How to Check If It's Working

### Method 1: Check Database (Easiest)
```sql
-- Check inventory before order
SELECT id, name, quantity FROM inventory_items;

-- Check if order was created
SELECT * FROM orders ORDER BY id DESC;

-- Check order items
SELECT * FROM order_items ORDER BY id DESC;
```

### Method 2: Use Laravel Tinker
```bash
php artisan tinker

# Check inventory for a specific item
App\Models\InventoryItem::find(1)->quantity;

# Check all orders with items
App\Models\Order::with('items')->latest()->first();

# Check product recipes
App\Models\Product::find(1)->recipes;
```

---

## 🎯 Example: Full Order & Inventory Deduction

### Before Order
```
Inventory:
- Ramen Noodles: 50kg
- Eggs: 100 pieces
- Broth: 30 liters
```

### Customer Orders 2x Ramen
- Product 1 (Ramen) × 2
- Total: $240

### System Processes:
1. Creates Order #5 with total $240
2. Creates OrderItem: product_id=1, qty=2, price=120, subtotal=240
3. Looks up recipes for product 1:
   - Noodles (0.3kg per order) → deduct 0.6kg (0.3 × 2)
   - Eggs (2 per order) → deduct 4 (2 × 2)
   - Broth (1L per order) → deduct 2L (1 × 2)

### After Order
```
Inventory:
- Ramen Noodles: 49.4kg ✓ (decreased)
- Eggs: 96 pieces ✓ (decreased)
- Broth: 28 liters ✓ (decreased)
```

---

## ⚠️ Common Issues & Solutions

### "Order creation fails"
**Check:**
1. Product exists: `App\Models\Product::find(1)`
2. ProductRecipes exist: `App\Models\ProductRecipe::where('product_id',1)->count()`
3. Inventory items exist: `App\Models\InventoryItem::count()`

**Solution:** Add them using Step 2 above.

### "Insufficient stock error"
**Expected behavior!** This means:
- You ordered more than available
- System prevented overselling ✅

**Solution:** Increase inventory or order less.

### "Orders table not found"
**Check:**
```bash
php artisan migrate:status
```

**Solution:** Run migrations: `php artisan migrate`

---

## 📚 Need More Details?

- **Complete Guide**: Read `KITCHEN_INVENTORY_GUIDE.md`
- **Setup Options**: See `SAMPLE_DATA_SETUP.md`
- **Architecture**: Check `ARCHITECTURE.md`
- **Quick Reference**: Use `INVENTORY_QUICK_REFERENCE.md`

---

## ✨ What Just Happened

You now have:

✅ **Order Management System**
- Customers place orders
- System tracks who ordered what

✅ **Automatic Inventory Deduction**
- Stock decreases when orders placed
- Works with product recipes
- Prevents overselling

✅ **Stock Validation**
- Checks stock before deducting
- Fails gracefully if insufficient
- Shows error to user

✅ **Complete Audit Trail**
- Every order recorded
- Every item tracked
- Full history available

---

## 🎓 How It Works (30-second version)

1. Customer orders items
2. System checks product recipes (what ingredients needed)
3. For each ingredient:
   - Validates stock available
   - Deducts from inventory
4. If any ingredient fails:
   - Entire order fails
   - Nothing deducted
   - User sees error
5. If all succeed:
   - Order saved
   - Inventory updated
   - User sees receipt

---

## 🔒 Security

All protected by:
- ✅ CSRF tokens
- ✅ Server-side validation
- ✅ Database transactions
- ✅ Foreign key constraints

---

## 🚀 Ready to Use

Your system is production-ready. Start taking orders! 

**Questions?** Check the documentation files in your project root.

**Issues?** Verify migrations ran: `php artisan migrate:status`

---

**Happy selling! 🍜**
