# 👨‍🍳 Product Recipe Management - Setup Guide

## What's New

You now have a **Recipe Management Panel** where you can easily define what ingredients each product needs!

Instead of manually adding recipes to the database, you can now:
- ✅ Click "Recipes" button on any product
- ✅ See all ingredients that product needs
- ✅ Add new ingredients with quantities
- ✅ Edit existing ingredient quantities
- ✅ Delete ingredients from recipes

## How to Use It

### Step 1: Go to Products Page
1. Click on "Products" in the navigation
2. You'll see your list of products with a new **"Recipes"** button

### Step 2: Click "Recipes" Button
Click the green "Recipes" button next to any product to see/manage its ingredients.

### Step 3: Add Ingredients
1. Click **"+ Add Ingredient to Recipe"**
2. Select ingredient from dropdown
3. Enter quantity needed (e.g., 0.3 for 0.3kg, 2 for 2 pieces)
4. Click **"Add Ingredient"**

### Step 4: Edit or Delete
- **Edit:** Click "Edit" next to any ingredient to change the quantity
- **Delete:** Click "Delete" to remove an ingredient from the recipe

## Example Setup

**Let's say you want to set up a Ramen product:**

1. Go to Products → Click "Recipes" for Ramen
2. Add ingredients:
   - Noodles: 0.3 (kg)
   - Eggs: 2 (pieces)
   - Broth: 1 (liters)
   - Green Onion: 1 (bundle)

**Then when customer orders 2x Ramen:**
- System automatically deducts:
  - 0.6 kg Noodles (0.3 × 2)
  - 4 Eggs (2 × 2)
  - 2 L Broth (1 × 2)
  - 2 Bundles Green Onion (1 × 2)

## Understanding Quantities

The quantity you enter is **per order**.

| Ingredient | Quantity | Unit | For 1 Order | For 3 Orders |
|-----------|----------|------|-------------|-------------|
| Noodles | 0.3 | kg | 0.3 kg | 0.9 kg |
| Eggs | 2 | pieces | 2 eggs | 6 eggs |
| Broth | 1 | liters | 1 L | 3 L |

## UI Features

### Recipe Index Page
Shows all ingredients for a product with:
- Ingredient name
- Category of ingredient
- Quantity needed
- Unit (kg, L, pieces, etc.)
- Edit & Delete buttons

### Recipe Summary Box
At the bottom, shows what gets deducted per order:
```
When 1 order of [Product Name] is placed, the system will deduct:
• 0.3 kg of Noodles
• 2 pieces of Eggs
• 1 liters of Broth
```

## Key Points

✅ **Easy to Use:** Simple buttons and forms
✅ **Visual Feedback:** See all ingredients at a glance
✅ **Quantity in Units:** Shows units (kg, L, pieces, etc.) from inventory
✅ **Real-time Stock:** Shows current inventory levels when adding
✅ **Prevents Duplicates:** Can't add same ingredient twice
✅ **Confirmation Dialogs:** Asks before deleting

## Common Tasks

### Add New Ingredient to Product
```
Products → Click "Recipes" → "+ Add Ingredient" → Select → Enter qty → Add
```

### Change How Much of Ingredient is Needed
```
Products → Click "Recipes" → "Edit" (next to ingredient) → Change qty → Update
```

### Remove Ingredient from Recipe
```
Products → Click "Recipes" → "Delete" (next to ingredient) → Confirm
```

### See All Products and Their Recipes
```
Products → View all with "Recipes" buttons available
```

## Database Behind the Scenes

The UI updates the `product_recipes` table:
```
product_recipes:
  - product_id: Which product (e.g., Ramen)
  - inventory_item_id: Which ingredient (e.g., Noodles)
  - quantity_needed: How much per order (e.g., 0.3)
```

When order is placed, the OrderController automatically:
1. Finds all recipes for that product
2. For each ingredient, multiplies quantity × order quantity
3. Deducts from inventory

## Validation

The system prevents:
❌ Adding same ingredient twice to one product
❌ Adding invalid quantities (must be > 0)
❌ Selecting ingredient that doesn't exist
❌ Leaving required fields empty

## Next Steps

1. **Go to Products page**
2. **Click "Recipes" on a product**
3. **Click "+ Add Ingredient"**
4. **Select an ingredient and quantity**
5. **Done!** Now orders will automatically deduct that ingredient

---

**Pro Tip:** Set up all your recipes BEFORE taking orders. This way, when customers order, everything deducts automatically and correctly!
