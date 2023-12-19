<!-- Content Area -->
<div class="container mx-auto mt-5 p-6 bg-white shadow-md rounded-md">

    <h2 class="text-2xl font-semibold mb-4">Product Management</h2>

    <!-- Product Table -->

    <div>
        <h3 class="text-lg font-semibold mb-2">Product List</h3>
        <table class="w-full border">
            <thead>
                <tr>
                    <th class="border p-2">Product ID</th>
                    <th class="border p-2">Reference</th>
                    <th class="border p-2">Image</th>
                    <th class="border p-2">Barcode</th>
                    <th class="border p-2">Product Name</th>
                    <th class="border p-2">Purchase Price</th>
                    <th class="border p-2">Final Price</th>
                    <th class="border p-2">Price Offer</th>
                    <th class="border p-2">Description</th>
                    <th class="border p-2">Min Quantity</th>
                    <th class="border p-2">Stock Quantity</th>
                    <th class="border p-2">Category</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Retrieve products from the database and display them in the table
                $productDAO = new ProductDAO(); // Replace with your actual ProductDAO class
                $products = $productDAO->getAllProducts();

                foreach ($products as $product) {
                    echo "<tr>";
                    echo "<td class='border p-2'>{$product->getProductId()}</td>";
                    echo "<td class='border p-2'>{$product->getReference()}</td>";
                    echo "<td class='border p-2'><img src='{$product->getImage()}' alt='{$product->getLabel()}' class='w-16 h-16'></td>";
                    echo "<td class='border p-2'>{$product->getBarcode()}</td>";
                    echo "<td class='border p-2'>{$product->getLabel()}</td>";
                    echo "<td class='border p-2'>{$product->getPurchasePrice()}</td>";
                    echo "<td class='border p-2'>{$product->getFinalPrice()}</td>";
                    echo "<td class='border p-2'>{$product->getPriceOffer()}</td>";
                    echo "<td class='border p-2'>{$product->getDescription()}</td>";
                    echo "<td class='border p-2'>{$product->getMinQuantity()}</td>";
                    echo "<td class='border p-2'>{$product->getStockQuantity()}</td>";
                    echo "<td class='border p-2'>{$product->getCategoryId()}</td>";
                    $disabledText = ($product->isDisabled()) ? 'Yes' : 'No';
                    echo "<td class='border p-2'>{$disabledText}</td>";
                    echo "<td class='border p-2'>";
                    echo "<a href='edit_product.php?id={$product->getProductId()}' class='text-blue-500'>Edit</a>";
                    echo " | ";
                    echo "<a href='delete_product.php?id={$product->getProductId()}' class='text-red-500'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>

            </tbody>
        </table>
    </div>

</div>