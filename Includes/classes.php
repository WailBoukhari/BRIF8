<?php

class User extends Database
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

    public function __construct($conn, $user_id, $username, $email, $password, $role, $verified, $full_name, $phone_number, $address, $disabled, $city)
    {
        parent::__construct($conn);
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

    // User Management
    public function addUser($username, $email, $password, $role, $verified, $full_name, $phone_number, $address, $disabled, $city)
    {
        $query = "INSERT INTO Users (username, email, password, role, verified, full_name, phone_number, address, disabled, city) 
                  VALUES (:username, :email, :password, :role, :verified, :full_name, :phone_number, :address, :disabled, :city)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':verified', $verified);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':disabled', $disabled);
        $stmt->bindParam(':city', $city);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser($username)
    {
        $query = "SELECT * FROM Users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($username, $email, $password, $role, $verified, $full_name, $phone_number, $address, $disabled, $city)
    {
        $query = "UPDATE Users SET email = :email, password = :password, role = :role, verified = :verified, full_name = :full_name, phone_number = :phone_number, address = :address, disabled = :disabled, city = :city WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':verified', $verified);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':disabled', $disabled);
        $stmt->bindParam(':city', $city);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser($username)
    {
        $query = "DELETE FROM Users WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
class Category extends Database
{

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function addCategory($category_name, $imag_category, $is_desaybelsd)
    {
        $query = "INSERT INTO Categories (category_name, imag_category, is_desaybelsd) VALUES (:category_name, :imag_category, :is_desaybelsd)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_name', $category_name);
        $stmt->bindParam(':imag_category', $imag_category);
        $stmt->bindParam(':is_desaybelsd', $is_desaybelsd);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCategory($categoryId)
    {
        $query = "SELECT * FROM Categories WHERE id = :categoryId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateCategory($categoryId, $category_name, $imag_category, $is_desaybelsd)
    {
        $query = "UPDATE Categories SET category_name = :category_name, imag_category = :imag_category, is_desaybelsd = :is_desaybelsd WHERE id = :categoryId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':categoryId', $categoryId);
        $stmt->bindParam(':category_name', $category_name);
        $stmt->bindParam(':imag_category', $imag_category);
        $stmt->bindParam(':is_desaybelsd', $is_desaybelsd);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteCategory($categoryId)
    {
        $query = "DELETE FROM Categories WHERE id = :categoryId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':categoryId', $categoryId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

class Product extends Database
{


    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function addProduct($reference, $image, $barcode, $label, $purchase_price, $final_price, $price_offer, $description, $min_quantity, $stock_quantity, $category_id, $disabled)
    {
        $query = "INSERT INTO Products (reference, image, barcode, label, purchase_price, final_price, price_offer, description, min_quantity, stock_quantity, category_id, disabled) 
                  VALUES (:reference, :image, :barcode, :label, :purchase_price, :final_price, :price_offer, :description, :min_quantity, :stock_quantity, :category_id, :disabled)";
        $stmt = $this->conn->prepare($query);
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
        $stmt->bindParam(':disabled', $disabled);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getProduct($productId)
    {
        $query = "SELECT * FROM Products WHERE id = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProduct($productId, $reference, $image, $barcode, $label, $purchase_price, $final_price, $price_offer, $description, $min_quantity, $stock_quantity, $category_id, $disabled)
    {
        $query = "UPDATE Products 
                  SET reference = :reference, image = :image, barcode = :barcode, label = :label, 
                      purchase_price = :purchase_price, final_price = :final_price, price_offer = :price_offer, 
                      description = :description, min_quantity = :min_quantity, stock_quantity = :stock_quantity, 
                      category_id = :category_id, disabled = :disabled 
                  WHERE id = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId);
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
        $stmt->bindParam(':disabled', $disabled);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteProduct($productId)
    {
        $query = "DELETE FROM Products WHERE id = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

class Order extends Database
{

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function addOrder($user_id, $order_state_id, $total_price, $date)
    {
        $query = "INSERT INTO Orders (user_id, order_state_id, total_price, date) VALUES (:user_id, :order_state_id, :total_price, :date)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':order_state_id', $order_state_id);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':date', $date);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getOrder($orderId)
    {
        $query = "SELECT * FROM Orders WHERE id = :orderId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOrder($orderId, $user_id, $order_state_id, $total_price, $date)
    {
        $query = "UPDATE Orders SET user_id = :user_id, order_state_id = :order_state_id, total_price = :total_price, date = :date WHERE id = :orderId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':order_state_id', $order_state_id);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':date', $date);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteOrder($orderId)
    {
        $query = "DELETE FROM Orders WHERE id = :orderId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderId', $orderId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}


class OrderDetail extends Database
{
    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function addOrderDetail($order_id, $product_id, $quantity, $price)
    {
        $query = "INSERT INTO OrderDetails (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getOrderDetail($orderDetailId)
    {
        $query = "SELECT * FROM OrderDetails WHERE id = :orderDetailId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderDetailId', $orderDetailId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOrderDetail($orderDetailId, $order_id, $product_id, $quantity, $price)
    {
        $query = "UPDATE OrderDetails SET order_id = :order_id, product_id = :product_id, quantity = :quantity, price = :price WHERE id = :orderDetailId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderDetailId', $orderDetailId);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteOrderDetail($orderDetailId)
    {
        $query = "DELETE FROM OrderDetails WHERE id = :orderDetailId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderDetailId', $orderDetailId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

class UserState extends Database
{
    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function addUserState($state_name)
    {
        $query = "INSERT INTO UserStates (state_name) VALUES (:state_name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':state_name', $state_name);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserState($userStateId)
    {
        $query = "SELECT * FROM UserStates WHERE id = :userStateId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userStateId', $userStateId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUserState($userStateId, $state_name)
    {
        $query = "UPDATE UserStates SET state_name = :state_name WHERE id = :userStateId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userStateId', $userStateId);
        $stmt->bindParam(':state_name', $state_name);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUserState($userStateId)
    {
        $query = "DELETE FROM UserStates WHERE id = :userStateId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userStateId', $userStateId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

class OrderState extends Database
{
    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function addOrderState($state_name)
    {
        $query = "INSERT INTO OrderStates (state_name) VALUES (:state_name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':state_name', $state_name);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getOrderState($orderStateId)
    {
        $query = "SELECT * FROM OrderStates WHERE id = :orderStateId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderStateId', $orderStateId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOrderState($orderStateId, $state_name)
    {
        $query = "UPDATE OrderStates SET state_name = :state_name WHERE id = :orderStateId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderStateId', $orderStateId);
        $stmt->bindParam(':state_name', $state_name);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteOrderState($orderStateId)
    {
        $query = "DELETE FROM OrderStates WHERE id = :orderStateId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':orderStateId', $orderStateId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}