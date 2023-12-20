<?php
// Define DAO classes for each entity
class User
{
    private $user_id;
    private $username;
    private $email;
    private $password;
    private $role;
    private $verified;
    private $full_name;
    private $phone_number;
    private $address;
    private $disabled;
    private $city;

    // Constructor with optional parameters
    public function __construct(
        $user_id,
        $username,
        $email,
        $password,
        $role,
        $verified,
        $full_name,
        $phone_number,
        $address,
        $disabled,
        $city
    ) {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->verified = $verified;
        $this->full_name = $full_name;
        $this->phone_number = $phone_number;
        $this->address = $address;
        $this->disabled = $disabled;
        $this->city = $city;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function getVerified()
    {
        return $this->verified;
    }
    public function getFullName()
    {
        return $this->full_name;
    }
    public function  getphoneNumber()
    {
        return $this->phone_number;
    }
    public function getAddress()
    {
        return $this->address;
    }
    public function getDisabled()
    {
        return $this->disabled;
    }
    public function getCity()
    {
        return $this->city;
    }
    // setter methods
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setRole($role)
    {
        $this->role = $role;
    }
    public function setVerified($verified)
    {
        $this->verified = $verified;
    }
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }
}

class UserDAO extends BaseDAO
{
    public function authenticateUser($username, $password)
    {

        // Assuming your users table has columns 'username', 'password', 'disabled', 'verified', and 'role'
        $query = "SELECT * FROM users WHERE username = :username AND password = :password";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->execute();

        // Check if a matching user is found
        if ($statement->rowCount() > 0) {
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            // Extract user data
            $disabled = $user['disabled'];
            $verified = $user['verified'];
            $role = $user['role'];

            if (!$disabled) {
                // Check if the user is verified
                if ($verified) {
                    if ($role == 'admin') {
                        // Redirect to a dashboard for admin
                        header('Location: dashboard.php');
                        exit();
                    } else {
                        // Redirect to index for regular user
                        header('Location: ../index.php');
                        exit();
                    }
                } else {
                    // Redirect to unverified page
                    header('Location: unverified.php');
                    exit();
                }
            } else {
                // Redirect to disabled page
                header('Location: disabled.php');
                exit();
            }
        } else {
            return false; // Authentication failed (no matching user)
        }
    }
    public function getAllUsers()
    {

        $query = "SELECT * FROM Users";
        $statement = $this->db->prepare($query);
        $statement->execute();

        // Fetch all users
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $users;
    }
    public function getUserById($userId)
    {
        $query = "SELECT * FROM Users WHERE user_id = :userId";
        $statement = $this->db->prepare($query);
        $statement->execute([':userId' => $userId]);

        // Fetch the user data as an associative array
        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        // Check if user data is fetched
        if ($userData) {
            // Create a new User object with the fetched data
            $user = new User(
                $userData['user_id'],
                $userData['username'],
                $userData['email'],
                $userData['password'],
                $userData['role'],
                $userData['verified'],
                $userData['full_name'],
                $userData['phone_number'],
                $userData['address'],
                $userData['disabled'],
                $userData['city']
            );

            return $user;
        } else {
            return null; // User not found
        }
    }

    // Method to enable a user
    public function enableUser($userId)
    {
        // Update the 'disabled' column in the database to 0 (enabled)
        $sql = "UPDATE users SET disabled = 0 WHERE user_id = :userId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Method to disable a user
    public function disableUser($userId)
    {
        // Update the 'disabled' column in the database to 1 (disabled)
        $sql = "UPDATE users SET disabled = 1 WHERE user_id = :userId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateUser(User $user)
    {
        $query = "UPDATE Users 
            SET username = :username, 
                email = :email, 
                password = :password, 
                role = :role, 
                verified = :verified, 
                full_name = :full_name, 
                phone_number = :phone_number, 
                address = :address, 
                disabled = :disabled, 
                city = :city 
            WHERE user_id = :user_id";

        $stmt = $this->db->prepare($query);

        // Assign values to variables
        $userId = $user->getUserId();
        $username = $user->getUsername();
        $email = $user->getEmail();
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $role = $user->getRole();
        $verified = $user->getVerified();
        $fullName = $user->getFullName();
        $phoneNumber = $user->getPhoneNumber();
        $address = $user->getAddress();
        $disabled = $user->getDisabled();
        $city = $user->getCity();

        // Bind variables
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword); // Password hashing
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':verified', $verified, PDO::PARAM_BOOL);
        $stmt->bindParam(':full_name', $fullName);
        $stmt->bindParam(':phone_number', $phoneNumber);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':disabled', $disabled, PDO::PARAM_BOOL);
        $stmt->bindParam(':city', $city);

        return $stmt->execute();
    }

    public function getUser($username)
    {

        // Fetch user data from the database
        $query = "SELECT * FROM users WHERE username = :username";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->execute();

        // Check if a matching user is found
        if ($statement->rowCount() > 0) {
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            // Return user data
            return $user;
        } else {
            return null; // User not found
        }
    }
}

class Category
{
    private $category_id;
    private $category_name;
    private $imag_category;
    private $is_disabled;

    // Constructor with optional parameters
    public function __construct($category_id, $category_name, $imag_category, $is_disabled = false)
    {
        $this->category_id = $category_id;
        $this->category_name = $category_name;
        $this->imag_category = $imag_category;
        $this->is_disabled = $is_disabled;
    }

    // Getter methods for retrieving private properties

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function getCategoryName()
    {
        return $this->category_name;
    }

    public function getImagCategory()
    {
        return $this->imag_category;
    }

    public function isDisabled()
    {
        return $this->is_disabled;
    }

    // Setter methods for updating private properties
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }
}

class CategoryDAO extends BaseDAO
{
    public function getAllCategories()
    {
        $query = "SELECT * FROM Categories"; // Replace 'categories' with your actual table name
        $statement = $this->db->prepare($query);
        $statement->execute();

        // Fetch all categories
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Convert the associative array to an array of Category objects
        $categoryObjects = [];
        foreach ($categories as $category) {
            $categoryObjects[] = new Category(
                $category['category_id'],
                $category['category_name'],
                $category['imag_category'],
            );
        }

        return $categoryObjects;
    }
    public function addCategory(Category $category)
    {
        $query = "INSERT INTO Categories (category_name, imag_category, is_disabled) 
                  VALUES (:category_name, :imag_category, :is_disabled)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':category_name', $category->getCategoryName());
        $stmt->bindParam(':imag_category', $category->getImagCategory());
        $stmt->bindParam(':is_disabled', $category->isDisabled(), PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    public function updateCategory(Category $category)
    {
        $query = "UPDATE Categories SET 
                  category_name = :category_name,
                  imag_category = :imag_category,
                  is_disabled = :is_disabled
                  WHERE category_id = :category_id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':category_name', $category->getCategoryName());
        $stmt->bindParam(':imag_category', $category->getImagCategory());
        $stmt->bindParam(':is_disabled', $category->isDisabled(), PDO::PARAM_BOOL);
        $stmt->bindParam(':category_id', $category->getCategoryId());

        return $stmt->execute();
    }

    public function disableCategory($categoryId)
    {

        // Update the 'disabled' status of the category
        $query = "UPDATE categories SET is_disabled = 1 WHERE id = :categoryId";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $statement->execute();

        // Check if the category was successfully disabled
        if ($statement->rowCount() > 0) {
            return true; // Category disabled successfully
        } else {
            return false; // Category not found or not disabled
        }
    }

    public function getCategoryById($category_id)
    {
        $query = "SELECT * FROM Categories WHERE category_id = :category_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();

        $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);
        // Check if user data is fetched
        if ($categoryData) {
            // Create a new User object with the fetched data
            $category = new Category(
                $categoryData['category_id'],
                $categoryData['category_name'],
                $categoryData['imag_category'],
                $categoryData['is_disabled'],

            );

            return $category;
        } else {
            return null; // User not found
        }
    }
}


class Product
{
    private $product_id;
    private $reference;
    private $image;
    private $barcode;
    private $label;
    private $purchase_price;
    private $final_price;
    private $price_offer;
    private $description;
    private $min_quantity;
    private $stock_quantity;
    private $category_id;
    private $disabled;

    // Constructor with optional parameters
    public function __construct(
        $product_id,
        $reference,
        $image,
        $barcode,
        $label,
        $purchase_price,
        $final_price,
        $price_offer,
        $description,
        $min_quantity,
        $stock_quantity,
        $category_id,
        $disabled = false
    ) {
        $this->product_id = $product_id;
        $this->reference = $reference;
        $this->image = $image;
        $this->barcode = $barcode;
        $this->label = $label;
        $this->purchase_price = $purchase_price;
        $this->final_price = $final_price;
        $this->price_offer = $price_offer;
        $this->description = $description;
        $this->min_quantity = $min_quantity;
        $this->stock_quantity = $stock_quantity;
        $this->category_id = $category_id;
        $this->disabled = $disabled;
    }

    // Getter methods for retrieving private properties
    public function getProductId()
    {
        return $this->product_id;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getBarcode()
    {
        return $this->barcode;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getPurchasePrice()
    {
        return $this->purchase_price;
    }

    public function getFinalPrice()
    {
        return $this->final_price;
    }

    public function getPriceOffer()
    {
        return $this->price_offer;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getMinQuantity()
    {
        return $this->min_quantity;
    }

    public function getStockQuantity()
    {
        return $this->stock_quantity;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

    public function isDisabled()
    {
        return $this->disabled;
    }

    // Setter methods for updating private properties
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }
}

class ProductDAO extends BaseDAO
{
    public function addProduct(Product $product)
    {
        $query = "INSERT INTO Products (reference, image, barcode, label, purchase_price, final_price, price_offer, description, min_quantity, stock_quantity, category_id, disabled) 
                  VALUES (:reference, :image, :barcode, :label, :purchase_price, :final_price, :price_offer, :description, :min_quantity, :stock_quantity, :category_id, :disabled)";

        $stmt = $this->db->prepare($query);

        $reference = $product->getReference();
        $image = $product->getImage();
        $barcode = $product->getBarcode();
        $label = $product->getLabel();
        $purchase_price = $product->getPurchasePrice();
        $final_price = $product->getFinalPrice();
        $price_offer = $product->getPriceOffer();
        $description = $product->getDescription();
        $min_quantity = $product->getMinQuantity();
        $stock_quantity = $product->getStockQuantity();
        $category_id = $product->getCategoryId();
        $disabled = $product->isDisabled();

        $stmt->bindParam(':reference', $reference);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':barcode', $barcode);
        $stmt->bindParam(':label', $label);
        $stmt->bindParam(':purchase_price', $purchase_price);
        $stmt->bindParam(':final_price', $final_price);
        $stmt->bindParam(':price_offer', $price_offer);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':min_quantity', $min_quantity);
        $stmt->bindParam(':stock_quantity', $stock_quantity);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':disabled', $disabled, PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    public function updateProduct(Product $product)
    {
        $query = "UPDATE Products SET 
                  reference = :reference,
                  image = :image,
                  barcode = :barcode,
                  label = :label,
                  purchase_price = :purchase_price,
                  final_price = :final_price,
                  price_offer = :price_offer,
                  description = :description,
                  min_quantity = :min_quantity,
                  stock_quantity = :stock_quantity,
                  category_id = :category_id,
                  disabled = :disabled
                  WHERE product_id = :product_id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':reference', $product->getReference());
        $stmt->bindParam(':image', $product->getImage());
        $stmt->bindParam(':barcode', $product->getBarcode());
        $stmt->bindParam(':label', $product->getLabel());
        $stmt->bindParam(':purchase_price', $product->getPurchasePrice());
        $stmt->bindParam(':final_price', $product->getFinalPrice());
        $stmt->bindParam(':price_offer', $product->getPriceOffer());
        $stmt->bindParam(':description', $product->getDescription());
        $stmt->bindParam(':min_quantity', $product->getMinQuantity());
        $stmt->bindParam(':stock_quantity', $product->getStockQuantity());
        $stmt->bindParam(':category_id', $product->getCategoryId());
        $stmt->bindParam(':disabled', $product->isDisabled(), PDO::PARAM_BOOL);
        $stmt->bindParam(':product_id', $product->getProductId());

        return $stmt->execute();
    }


    public function disableProduct($productId)
    {

        // Update the 'disabled' status of the product
        $query = "UPDATE products SET disabled = 1 WHERE id = :productId";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':productId', $productId, PDO::PARAM_INT);
        $statement->execute();

        // Check if the product was successfully disabled
        if ($statement->rowCount() > 0) {
            return true; // Product disabled successfully
        } else {
            return false; // Product not found or not disabled
        }
    }


    public function getProductById($product_id)
    {
        $query = "SELECT * FROM Products WHERE product_id = :product_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        $productData = $stmt->fetch(PDO::FETCH_ASSOC);
        // Check if user data is fetched
        if ($productData) {
            // Create a new User object with the fetched data
            $product = new Product(
                $productData['product_id'],
                $productData['reference'],
                $productData['image'],
                $productData['barcode'],
                $productData['label'],
                $productData['purchase_price'],
                $productData['final_price'],
                $productData['price_offer'],
                $productData['description'],
                $productData['min_quantity'],
                $productData['stock_quantity'],
                $productData['category_id'],
                $productData['disabled']

            );

            return $product;
        } else {
            return null; // User not found
        }
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM products"; // Replace 'products' with your actual table name
        $statement = $this->db->prepare($query);
        $statement->execute();

        // Fetch all products
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Convert the associative array to an array of Product objects
        $productObjects = [];
        foreach ($products as $product) {
            $productObjects[] = new Product(
                $product['product_id'],
                $product['reference'],
                $product['image'],
                $product['barcode'],
                $product['label'],
                $product['purchase_price'],
                $product['final_price'],
                $product['price_offer'],
                $product['description'],
                $product['min_quantity'],
                $product['stock_quantity'],
                $product['category_id'],
                $product['disabled']
            );
        }

        return $productObjects;
    }
}


class Order
{

    private $order_date;
    private $send_date;
    private $delivery_date;
    private $total_price;
    private $order_status;

    // Constructor with optional parameters
    public function __construct($user_id, $order_date, $send_date, $delivery_date, $total_price, $order_status = 'Pending')
    {

        $this->send_date = $send_date;
        $this->delivery_date = $delivery_date;
        $this->total_price = $total_price;
        $this->order_status = $order_status;
    }

    // Getter methods for retrieving private properties

    public function getOrderDate()
    {
        return $this->order_date;
    }

    public function getSendDate()
    {
        return $this->send_date;
    }

    public function getDeliveryDate()
    {
        return $this->delivery_date;
    }

    public function getTotalPrice()
    {
        return $this->total_price;
    }

    public function getOrderStatus()
    {
        return $this->order_status;
    }

    // Setter methods for updating private properties
}

class OrderDAO extends BaseDAO
{
    public function addOrder(Order $order)
    {
        $query = "INSERT INTO Orders (user_id, order_date, send_date, delivery_date, total_price, order_status) 
                  VALUES (:user_id, :order_date, :send_date, :delivery_date, :total_price, :order_status)";

        $stmt = $this->db->prepare($query);


        $stmt->bindParam(':order_date', $order->getOrderDate());
        $stmt->bindParam(':send_date', $order->getSendDate());
        $stmt->bindParam(':delivery_date', $order->getDeliveryDate());
        $stmt->bindParam(':total_price', $order->getTotalPrice());
        $stmt->bindParam(':order_status', $order->getOrderStatus());

        return $stmt->execute();
    }

    public function updateOrder(Order $order)
    {
        $query = "UPDATE Orders SET 
                  user_id = :user_id,
                  order_date = :order_date,
                  send_date = :send_date,
                  delivery_date = :delivery_date,
                  total_price = :total_price,
                  order_status = :order_status
                  WHERE order_id = :order_id";

        $stmt = $this->db->prepare($query);


        $stmt->bindParam(':order_date', $order->getOrderDate());
        $stmt->bindParam(':send_date', $order->getSendDate());
        $stmt->bindParam(':delivery_date', $order->getDeliveryDate());
        $stmt->bindParam(':total_price', $order->getTotalPrice());
        $stmt->bindParam(':order_status', $order->getOrderStatus());


        return $stmt->execute();
    }

    public function deleteOrder($order_id)
    {
        $query = "DELETE FROM Orders WHERE order_id = :order_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $order_id);

        return $stmt->execute();
    }

    public function getOrderById($order_id)
    {
        $query = "SELECT * FROM Orders WHERE order_id = :order_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add more methods as needed, such as getOrderByUser, getAllOrders, etc.
}

class OrderDetail
{
    private $order_detail_id;
    private $user_id;
    private $order_id;
    private $product_id;
    private $quantity;
    private $unit_price;
    private $total_price;

    // Constructor with optional parameters
    public function __construct($user_id, $order_id, $product_id, $quantity, $unit_price, $total_price)
    {
        $this->user_id = $user_id;
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
        $this->unit_price = $unit_price;
        $this->total_price = $total_price;
    }

    // Getter methods for retrieving private properties
    public function getOrderDetailId()
    {
        return $this->order_detail_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getUnitPrice()
    {
        return $this->unit_price;
    }

    public function getTotalPrice()
    {
        return $this->total_price;
    }

    // Setter methods for updating private properties
    public function setOrderDetailId($order_detail_id)
    {
        $this->order_detail_id = $order_detail_id;
    }
}

class OrderDetailDAO extends BaseDAO
{
    public function addOrderDetail(OrderDetail $orderDetail)
    {
        $query = "INSERT INTO OrderDetails (user_id, order_id, product_id, quantity, unit_price, total_price) 
                  VALUES (:user_id, :order_id, :product_id, :quantity, :unit_price, :total_price)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':user_id', $orderDetail->getUserId());
        $stmt->bindParam(':order_id', $orderDetail->getOrderId());
        $stmt->bindParam(':product_id', $orderDetail->getProductId());
        $stmt->bindParam(':quantity', $orderDetail->getQuantity());
        $stmt->bindParam(':unit_price', $orderDetail->getUnitPrice());
        $stmt->bindParam(':total_price', $orderDetail->getTotalPrice());

        return $stmt->execute();
    }

    public function updateOrderDetail(OrderDetail $orderDetail)
    {
        $query = "UPDATE OrderDetails SET 
                  user_id = :user_id,
                  order_id = :order_id,
                  product_id = :product_id,
                  quantity = :quantity,
                  unit_price = :unit_price,
                  total_price = :total_price
                  WHERE order_detail_id = :order_detail_id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':user_id', $orderDetail->getUserId());
        $stmt->bindParam(':order_id', $orderDetail->getOrderId());
        $stmt->bindParam(':product_id', $orderDetail->getProductId());
        $stmt->bindParam(':quantity', $orderDetail->getQuantity());
        $stmt->bindParam(':unit_price', $orderDetail->getUnitPrice());
        $stmt->bindParam(':total_price', $orderDetail->getTotalPrice());
        $stmt->bindParam(':order_detail_id', $orderDetail->getOrderDetailId());

        return $stmt->execute();
    }

    public function deleteOrderDetail($order_detail_id)
    {
        $query = "DELETE FROM OrderDetails WHERE order_detail_id = :order_detail_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_detail_id', $order_detail_id);

        return $stmt->execute();
    }

    public function getOrderDetailById($order_detail_id)
    {
        $query = "SELECT * FROM OrderDetails WHERE order_detail_id = :order_detail_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_detail_id', $order_detail_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add more methods as needed, such as getOrderDetailsByOrderId, getAllOrderDetails, etc.
}

class UserState
{
    private $client_state_id;

    private $state;

    // Constructor with optional parameters
    public function __construct($user_id, $state)
    {

        $this->state = $state;
    }

    // Getter methods for retrieving private properties
    public function getClientStateId()
    {
        return $this->client_state_id;
    }



    public function getState()
    {
        return $this->state;
    }

    // Setter methods for updating private properties
    public function setClientStateId($client_state_id)
    {
        $this->client_state_id = $client_state_id;
    }
}

class UserStateDAO extends BaseDAO
{
    public function addUserState(UserState $userState)
    {
        $query = "INSERT INTO UserStates (user_id, state) 
                  VALUES (:user_id, :state)";

        $stmt = $this->db->prepare($query);


        $stmt->bindParam(':state', $userState->getState());

        return $stmt->execute();
    }

    public function updateUserState(UserState $userState)
    {
        $query = "UPDATE UserStates SET 
                  user_id = :user_id,
                  state = :state
                  WHERE client_state_id = :client_state_id";

        $stmt = $this->db->prepare($query);


        $stmt->bindParam(':state', $userState->getState());
        $stmt->bindParam(':client_state_id', $userState->getClientStateId());

        return $stmt->execute();
    }

    public function deleteUserState($client_state_id)
    {
        $query = "DELETE FROM UserStates WHERE client_state_id = :client_state_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':client_state_id', $client_state_id);

        return $stmt->execute();
    }

    public function getUserStateById($client_state_id)
    {
        $query = "SELECT * FROM UserStates WHERE client_state_id = :client_state_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':client_state_id', $client_state_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add more methods as needed, such as getUserStateByUserId, getAllUserStates, etc.
}


class OrderState
{
    private $order_state_id;
    private $order_id;
    private $state;

    // Constructor with optional parameters
    public function __construct($order_id, $state)
    {
        $this->order_id = $order_id;
        $this->state = $state;
    }

    // Getter methods for retrieving private properties
    public function getOrderStateId()
    {
        return $this->order_state_id;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getState()
    {
        return $this->state;
    }

    // Setter methods for updating private properties
    public function setOrderStateId($order_state_id)
    {
        $this->order_state_id = $order_state_id;
    }
}

class OrderStateDAO extends BaseDAO
{
    public function addOrderState(OrderState $orderState)
    {
        $query = "INSERT INTO OrderStates (order_id, state) 
                  VALUES (:order_id, :state)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':order_id', $orderState->getOrderId());
        $stmt->bindParam(':state', $orderState->getState());

        return $stmt->execute();
    }

    public function updateOrderState(OrderState $orderState)
    {
        $query = "UPDATE OrderStates SET 
                  order_id = :order_id,
                  state = :state
                  WHERE order_state_id = :order_state_id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':order_id', $orderState->getOrderId());
        $stmt->bindParam(':state', $orderState->getState());
        $stmt->bindParam(':order_state_id', $orderState->getOrderStateId());

        return $stmt->execute();
    }

    public function deleteOrderState($order_state_id)
    {
        $query = "DELETE FROM OrderStates WHERE order_state_id = :order_state_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_state_id', $order_state_id);

        return $stmt->execute();
    }

    public function getOrderStateById($order_state_id)
    {
        $query = "SELECT * FROM OrderStates WHERE order_state_id = :order_state_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_state_id', $order_state_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add more methods as needed, such as getOrderStateByOrderId, getAllOrderStates, etc.
}
class ImageUploader
{
    public static function uploadImage()
    {
        $targetDirectory = "../imgs"; // Change this to your desired directory
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            return false; // Not an image
        }

        // Check file size (adjust as needed)
        if ($_FILES["image"]["size"] > 500000) {
            return false; // File size too large
        }

        // Allow certain file formats (adjust as needed)
        if ($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg" && $imageFileType !== "gif") {
            return false; // Unsupported file format
        }

        // Move the file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            return $targetFile; // Return the path to the uploaded image
        } else {
            return false; // Failed to move the file
        }
    }
}
