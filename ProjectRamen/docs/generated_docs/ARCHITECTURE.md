# Architecture Diagram - Kitchen Inventory System

## System Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                    CUSTOMER PLACES ORDER                         │
│                                                                   │
│  Frontend: Order Form (Order Quantity for Products)              │
│  Example: 2x Ramen, 1x Chicken                                  │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│           JavaScript: Prepare Order Data                         │
│                                                                   │
│  items: [                                                        │
│    {product_id: 1, quantity: 2, price: 120, subtotal: 240},    │
│    {product_id: 2, quantity: 1, price: 150, subtotal: 150}     │
│  ],                                                              │
│  total: 390                                                      │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│              POST /orders (Inventory Deduction)                  │
│                                                                   │
│  OrderController::store()                                        │
│  ├─ Validate request data                                        │
│  ├─ Start Database Transaction                                   │
│  │  ├─ Create Order record {total: 390}                         │
│  │  └─ For each item:                                           │
│  │      ├─ Create OrderItem record                              │
│  │      └─ Find ProductRecipes for product_id                   │
│  │          └─ For each recipe ingredient:                      │
│  │              ├─ Get InventoryItem                            │
│  │              ├─ Validate sufficient stock exists             │
│  │              ├─ Deduct: quantity_needed × order_qty          │
│  │              └─ Save to inventory_items table                │
│  └─ Return success or error                                      │
│                                                                   │
│  Example Deduction:                                              │
│  Ramen (qty 2) needs [0.3kg noodles, 1L broth, 2 eggs]         │
│  Deduct: 0.6kg noodles, 2L broth, 4 eggs                       │
│                                                                   │
│  Chicken (qty 1) needs [0.2kg meat, 1L broth, 3 herbs]         │
│  Deduct: 0.2kg meat, 1L broth, 3 herbs                         │
└──────────────────────────┬──────────────────────────────────────┘
                           │
                 ┌─────────┴─────────┐
                 │                   │
                 ▼                   ▼
            SUCCESS (201)       ERROR (422)
            {success: true,     {success: false,
             order_id: 5}        message: "..."}
                 │                   │
                 ▼                   ▼
         ┌───────────────┐   ┌──────────────────┐
         │POST /save-sale│   │Show Error to User│
         │Create Sale    │   │Order NOT created │
         │Record         │   │Stock unchanged   │
         └───────┬───────┘   └──────────────────┘
                 │
                 ▼
         ┌─────────────────┐
         │Display Receipt  │
         └─────────────────┘
```

## Database Relationship Diagram

```
                    ┌─────────────────┐
                    │   Products      │
                    │   (product)     │
                    │                 │
                    │ id   (PK)       │
                    │ name            │
                    │ price           │
                    └────────┬────────┘
                             │
            ┌────────────────┼────────────────┐
            │                │                │
            ▼                ▼                ▼
   ┌────────────────┐  ┌──────────────┐  ┌────────────┐
   │ ProductRecipes │  │ OrderItems   │  │  Orders    │
   │                │  │              │  │            │
   │ id    (PK)     │  │ id   (PK)    │  │ id  (PK)   │
   │ product_id(FK) │  │ order_id(FK) │  │ total      │
   │ invent_id  (FK)│  │ product_id(FK)  │timestamps │
   │ qty_needed     │  │ qty          │  └────────────┘
   │ timestamps     │  │ price        │
   └────────┬───────┘  │ subtotal     │
            │          │ timestamps   │
            │          └──────────────┘
            │
            ▼
   ┌──────────────────────┐
   │  InventoryItems      │
   │                      │
   │ id         (PK)      │
   │ name                 │
   │ category             │
   │ quantity  ◄─── DEDUCTS HERE
   │ unit                 │
   │ min_stock            │
   │ unit_price           │
   │ supplier             │
   │ timestamps           │
   └──────────────────────┘
```

## OrderItem Deduction Process

```
For each item in order:

Product 1 (Quantity: 2)
    │
    ├─→ Get recipes for Product 1
    │
    ├─ Recipe 1: Noodles (qty_needed: 0.3)
    │   Deduct: 0.3 × 2 = 0.6kg from inventory_items
    │
    ├─ Recipe 2: Broth (qty_needed: 1.0)
    │   Deduct: 1.0 × 2 = 2.0L from inventory_items
    │
    ├─ Recipe 3: Eggs (qty_needed: 2)
    │   Deduct: 2 × 2 = 4 pieces from inventory_items
    │
    └─ Recipe 4: Topping (qty_needed: 1)
        Deduct: 1 × 2 = 2 toppings from inventory_items

If ANY deduction fails → ENTIRE ORDER FAILS & ROLLS BACK
```

## Data Flow Example

```
BEFORE ORDER:
┌─────────────────────────────────────┐
│        Inventory (inventory_items)   │
├────────────┬──────────┬──────────────┤
│Name        │Quantity  │Unit          │
├────────────┼──────────┼──────────────┤
│Noodles     │50        │kg            │
│Broth       │30        │liters        │
│Eggs        │100       │pieces        │
│Topping     │50        │pieces        │
└────────────┴──────────┴──────────────┘

ORDER: 2x Ramen (needs 0.3kg noodles, 1L broth, 2 eggs, 1 topping each)

AFTER ORDER PROCESSES:
┌─────────────────────────────────────┐
│        Inventory (inventory_items)   │
├────────────┬──────────┬──────────────┤
│Name        │Quantity  │Unit          │
├────────────┼──────────┼──────────────┤
│Noodles     │49.4      │kg  (-0.6)   │
│Broth       │28        │liters (-2)   │
│Eggs        │96        │pieces (-4)  │
│Topping     │48        │pieces (-2)  │
└────────────┴──────────┴──────────────┘

┌──────────────────────────────┐
│      orders table            │
├─────┬──────────┬────────┬────┤
│ id  │  total   │ created│...│
├─────┼──────────┼────────┼────┤
│  5  │   240    │ 2025.. │... │
└─────┴──────────┴────────┴────┘

┌───────────────────────────────────────────────┐
│         order_items table                     │
├────┬──────────┬────────────┬───────┬──────────┤
│ id │order_id  │ product_id │ qty   │subtotal  │
├────┼──────────┼────────────┼───────┼──────────┤
│ 7  │    5     │      1     │   2   │   240    │
└────┴──────────┴────────────┴───────┴──────────┘
```

## Error Handling Flow

```
POST /orders
    │
    ├─ Request Validation
    │   ├─ If invalid → Return 422 validation error
    │   └─ If valid → Continue
    │
    ├─ Create Order & OrderItems
    │   └─ If error → Rollback transaction, return error
    │
    └─ Deduct Inventory
        ├─ For each ingredient:
        │   ├─ Check stock available
        │   │   ├─ If insufficient → Throw exception
        │   │   └─ If sufficient → Deduct
        │   │
        │   └─ If deduction fails → Rollback entire transaction
        │
        └─ If ALL successful → Commit transaction & return 201

Transaction Rollback Scenario:
┌──────────────────────────────┐
│ Order Created (Order #5)     │
│ OrderItem 1 Created          │
│ Deduct Noodles ✓             │
│ Deduct Broth ✓               │
│ Check Eggs: Need 4, Have 2 ✗ │  ← FAIL HERE
│ ROLLBACK ENTIRE TRANSACTION  │
├──────────────────────────────┤
│ Order #5 deleted             │
│ OrderItem deleted            │
│ Noodles quantity restored    │
│ Broth quantity restored      │
│ Return error: "Insufficient" │
└──────────────────────────────┘
```

## Frontend to Backend Communication

```
Frontend (JavaScript)
    │
    ├─ Collect order items
    │  {id, name, qty, price, etc}
    │
    ├─ Transform to API format
    │  {product_id, quantity, price, subtotal}
    │
    ├─ Send POST /orders
    │  Headers: Content-Type: application/json, X-CSRF-TOKEN
    │
    └─ Handle response
       ├─ Success: Proceed to /save-sale, show receipt
       └─ Error: Display error message, don't proceed

Backend (Laravel)
    │
    ├─ OrderController::store()
    │  ├─ Validate
    │  ├─ Database::transaction()
    │  ├─ Create Order
    │  ├─ Create OrderItems
    │  ├─ Deduct Inventory
    │  └─ Commit/Rollback
    │
    └─ Return JSON
       ├─ 201: {success: true, order_id: 5}
       └─ 422: {success: false, message: "..."}
```

## Model Relationships

```
Product::recipes()
  Returns: hasMany(ProductRecipe)
  Usage: $product->recipes
  Gets: All recipes for this product

Product::inventoryItems()
  Returns: belongsToMany(InventoryItem)
  Pivot: quantity_needed
  Usage: $product->inventoryItems
  Gets: All ingredients for this product with qty needed

Product::orderItems()
  Returns: hasMany(OrderItem)
  Usage: $product->orderItems
  Gets: All orders for this product

Order::items()
  Returns: hasMany(OrderItem)
  Usage: $order->items
  Gets: All items in this order

OrderItem::order()
  Returns: belongsTo(Order)
  Usage: $orderItem->order
  Gets: Which order this item belongs to

OrderItem::product()
  Returns: belongsTo(Product)
  Usage: $orderItem->product
  Gets: Which product was ordered

ProductRecipe::product()
  Returns: belongsTo(Product)
  Usage: $recipe->product
  Gets: Which product has this recipe

ProductRecipe::inventoryItem()
  Returns: belongsTo(InventoryItem)
  Usage: $recipe->inventoryItem
  Gets: Which ingredient is needed

InventoryItem::productRecipes()
  Returns: hasMany(ProductRecipe)
  Usage: $item->productRecipes
  Gets: Which products need this ingredient
```

---

This architecture ensures:
- ✅ Atomic transactions (all or nothing)
- ✅ Data consistency
- ✅ Stock integrity
- ✅ Audit trail via order history
- ✅ Prevention of overselling
