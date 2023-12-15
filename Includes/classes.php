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
}

class UserDAO extends BaseDAO
{
    public function authenticateUser($username, $password)
    {
        try {
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
        } catch (PDOException $e) {
            // Handle database errors here
            // You might want to log the error or show a generic error message to the user
            return false;
        }
    }
    public function addUser(User $user)
    {
        $query = "INSERT INTO Users (username, email, password, role, verified, full_name, phone_number, address, disabled, city) 
                  VALUES (:username, :email, :password, :role, :verified, :full_name, :phone_number, :address, :disabled, :city)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':username', $user->getUsername());
        $stmt->bindParam(':email', $user->getEmail());
        $stmt->bindParam(':password', $user->getPassword()); // Note: Password hashing should be implemented.
        $stmt->bindParam(':role', $user->getRole());
        $stmt->bindParam(':verified', $user->getVerified(), PDO::PARAM_BOOL);
        $stmt->bindParam(':full_name', $user->getFullName());
        $stmt->bindParam(':phone_number', $user->getPhoneNumber());
        $stmt->bindParam(':address', $user->getAddress());
        $stmt->bindParam(':disabled', $user->getDisabled(), PDO::PARAM_BOOL);
        $stmt->bindParam(':city', $user->getCity());

        return $stmt->execute();
    }

    public function updateUser(User $user)
    {
        $query = "UPDATE Users SET (username, email, password, role, verified, full_name, phone_number, address, disabled, city) 
                  VALUES (:username, :email, :password, :role, :verified, :full_name, :phone_number, :address, :disabled, :city)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':username', $user->getUsername());
        $stmt->bindParam(':email', $user->getEmail());
        $stmt->bindParam(':password', $user->getPassword()); // Note: Password hashing should be implemented.
        $stmt->bindParam(':role', $user->getRole());
        $stmt->bindParam(':verified', $user->getVerified(), PDO::PARAM_BOOL);
        $stmt->bindParam(':full_name', $user->getFullName());
        $stmt->bindParam(':phone_number', $user->getPhoneNumber());
        $stmt->bindParam(':address', $user->getAddress());
        $stmt->bindParam(':disabled', $user->getDisabled(), PDO::PARAM_BOOL);
        $stmt->bindParam(':city', $user->getCity());

        return $stmt->execute();
    }
}

class Category
{
    private $category_id;
    private $category_name;
    private $imag_category;
    private $is_disabled;

    // Constructor with optional parameters
    public function __construct($category_name, $imag_category, $is_disabled = false)
    {
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

    public function deleteCategory($category_id)
    {
        $query = "DELETE FROM Categories WHERE category_id = :category_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $category_id);

        return $stmt->execute();
    }

    public function getCategoryById($category_id)
    {
        $query = "SELECT * FROM Categories WHERE category_id = :category_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add more methods as needed, such as getCategoryByName, getAllCategories, etc.
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
}

class ProductDAO extends BaseDAO
{
    public function addProduct(Product $product)
    {
        $query = "INSERT INTO Products (reference, image, barcode, label, purchase_price, final_price, price_offer, description, min_quantity, stock_quantity, category_id, disabled) 
                  VALUES (:reference, :image, :barcode, :label, :purchase_price, :final_price, :price_offer, :description, :min_quantity, :stock_quantity, :category_id, :disabled)";

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

    public function deleteProduct($product_id)
    {
        $query = "DELETE FROM Products WHERE product_id = :product_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id);

        return $stmt->execute();
    }

    public function getProductById($product_id)
    {
        $query = "SELECT * FROM Products WHERE product_id = :product_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add more methods as needed, such as getProductByBarcode, getAllProducts, etc.
}


class Order
{
    private $order_id;
    private $user_id;
    private $order_date;
    private $send_date;
    private $delivery_date;
    private $total_price;
    private $order_status;

    // Constructor with optional parameters
    public function __construct($user_id, $order_date, $send_date, $delivery_date, $total_price, $order_status = 'Pending')
    {
        $this->user_id = $user_id;
        $this->order_date = $order_date;
        $this->send_date = $send_date;
        $this->delivery_date = $delivery_date;
        $this->total_price = $total_price;
        $this->order_status = $order_status;
    }

    // Getter methods for retrieving private properties
    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

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
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }
}

class OrderDAO extends BaseDAO
{
    public function addOrder(Order $order)
    {
        $query = "INSERT INTO Orders (user_id, order_date, send_date, delivery_date, total_price, order_status) 
                  VALUES (:user_id, :order_date, :send_date, :delivery_date, :total_price, :order_status)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':user_id', $order->getUserId());
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

        $stmt->bindParam(':user_id', $order->getUserId());
        $stmt->bindParam(':order_date', $order->getOrderDate());
        $stmt->bindParam(':send_date', $order->getSendDate());
        $stmt->bindParam(':delivery_date', $order->getDeliveryDate());
        $stmt->bindParam(':total_price', $order->getTotalPrice());
        $stmt->bindParam(':order_status', $order->getOrderStatus());
        $stmt->bindParam(':order_id', $order->getOrderId());

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
    private $user_id;
    private $state;

    // Constructor with optional parameters
    public function __construct($user_id, $state)
    {
        $this->user_id = $user_id;
        $this->state = $state;
    }

    // Getter methods for retrieving private properties
    public function getClientStateId()
    {
        return $this->client_state_id;
    }

    public function getUserId()
    {
        return $this->user_id;
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

        $stmt->bindParam(':user_id', $userState->getUserId());
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

        $stmt->bindParam(':user_id', $userState->getUserId());
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
