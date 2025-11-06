<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form method="post" action="{{route('product.update', ['product' => $product])}}">
        @csrf
        @method('put')
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required value="{{ $product->name }}">
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required value="{{ $product->description }}"></textarea>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" step="0.01" id="price" name="price" required value="{{ $product->price }}">
        </div>
        <button type="submit">Update</button>
</body>
</html>