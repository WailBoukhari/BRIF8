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

        return $stmt->execute();
    }

    public function modifyUser($user_id, $username, $email, $password, $role, $verified, $full_name, $phone_number, $address, $disabled, $city)
    {
        $query = "UPDATE Users SET username = :username, 
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

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
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

        return $stmt->execute();
    }

    public function deleteUser($user_id)
    {
        $query = "DELETE FROM Users WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);

        return $stmt->execute();
    }
    public function login(
        $username,
        $password,
        $role = '',
        $verified = false
    ) {
        $query = 'SELECT * FROM Users WHERE username = :username AND password = :password AND disabled = 0';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role); // Assuming $role is a variable you want to bind
        $stmt->bindParam(':verified', $verified); // Assuming $verified is a variable you want to bind
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
class Order extends Database
{
    // Order Management
    public function addOrder($user_id, $creationDate, $shippingDate, $deliveryDate, $totalPrice, $orderStatus)
    {
        $query = "INSERT INTO Orders (user_id, CreationDate, ShippingDate, DeliveryDate, TotalPrice, OrderStatus) 
                  VALUES (:user_id, :creationDate, :shippingDate, :deliveryDate, :totalPrice, :orderStatus)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':creationDate', $creationDate);
        $stmt->bindParam(':shippingDate', $shippingDate);
        $stmt->bindParam(':deliveryDate', $deliveryDate);
        $stmt->bindParam(':totalPrice', $totalPrice);
        $stmt->bindParam(':orderStatus', $orderStatus);

        return $stmt->execute();
    }

    // Other order management methods...
}

class Product extends Database
{
    // Product Management
    public function addProduct($reference, $image, $barcode, $label, $purchase_price, $final_price, $price_offer, $description, $min_quantity, $stock_quantity, $category_id)
    {
        $query = "INSERT INTO Products (reference, image, barcode, label, purchase_price, final_price, price_offer, description, min_quantity, stock_quantity, category_id) 
                  VALUES (:reference, :image, :barcode, :label, :purchase_price, :final_price, :price_offer, :description, :min_quantity, :stock_quantity, :category_id)";

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

        return $stmt->execute();
    }

    public function modifyProduct($product_id, $productName, $price)
    {
        $query = "UPDATE Products SET ProductName = :productName, Price = :price WHERE ProductID = :product_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':price', $price);

        return $stmt->execute();
    }

    public function deleteProduct($product_id)
    {
        $query = "DELETE FROM Products WHERE ProductID = :product_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);

        return $stmt->execute();
    }

    // Other product management methods...
}

class Category extends Database
{
    // Category Management
    public function addCategory($category_name, $imag_category, $is_desaybelsd)
    {
        $query = "INSERT INTO Categories (category_name, imag_category, is_desaybelsd) VALUES (:category_name, :imag_category, :is_desaybelsd)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_name', $category_name);
        $stmt->bindParam(':imag_category', $imag_category);
        $stmt->bindParam(':is_desaybelsd', $is_desaybelsd);

        return $stmt->execute();
    }

    public function modifyCategory($category_id, $category_name, $imag_category, $is_desaybelsd)
    {
        $query = "UPDATE Categories SET category_name = :category_name, imag_category = :imag_category, is_desaybelsd = :is_desaybelsd WHERE category_id = :category_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':category_name', $category_name);
        $stmt->bindParam(':imag_category', $imag_category);
        $stmt->bindParam(':is_desaybelsd', $is_desaybelsd);

        return $stmt->execute();
    }

    public function deleteCategory($category_id)
    {
        $query = "DELETE FROM Categories WHERE category_id = :category_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);

        return $stmt->execute();
    }

    // Other category management methods...
}

class Admin extends Database
{
    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    // Admin-specific functionalities

    public function addUserByAdmin($username, $email, $password, $role, $verified, $full_name, $phone_number, $address, $disabled, $city)
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

        return $stmt->execute();
    }

    public function modifyUserByAdmin($user_id, $username, $email, $password, $role, $verified, $full_name, $phone_number, $address, $disabled, $city)
    {
        $query = "UPDATE Users SET username = :username, 
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

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
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

        return $stmt->execute();
    }

    public function deleteUserByAdmin($user_id)
    {
        $query = "DELETE FROM Users WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);

        return $stmt->execute();
    }

    // Other admin-specific functionalities...
}
