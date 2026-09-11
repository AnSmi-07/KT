<?php
class Database {
    private $pdo;
    private static $db;

    private function __construct() {
        try {
            $this->pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("SET NAMES utf8mb4");
        } catch (PDOException $e) {
            die('Ошибка подключения к БД: ' . $e->getMessage());
        }
    }

    public static function getDBO() {
        if (!self::$db) self::$db = new Database();
        return self::$db;
    }

    public function getPDO() { return $this->pdo; }

    private function getTableName($table_name) {
        return '`' . DB_PREFIX . $table_name . '`';
    }

    // ---- Базовые методы ----
    public function getRows($table_name, $where = '', $values = array(), $order_by = '') {
        $sql = 'SELECT * FROM ' . $this->getTableName($table_name);
        if ($where) $sql .= " WHERE $where";
        if ($order_by) $sql .= " ORDER BY $order_by";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRowById($table_name, $id) {
        $sql = 'SELECT * FROM ' . $this->getTableName($table_name) . ' WHERE `id` = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : array();
    }

    public function getRowByWhere($table_name, $where, $values = array()) {
        $sql = 'SELECT * FROM ' . $this->getTableName($table_name) . ' WHERE ' . $where;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : array();
    }

    public function insert($table_name, $data) {
        $fields = array_keys($data);
        $placeholders = '?' . str_repeat(',?', count($fields) - 1);
        $sql = 'INSERT INTO ' . $this->getTableName($table_name) . ' (`' . implode('`,`', $fields) . '`) VALUES (' . $placeholders . ')';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return $this->pdo->lastInsertId();
    }

    public function update($table_name, $fields, $values, $where, $where_values = array()) {
        $sql = 'UPDATE ' . $this->getTableName($table_name) . ' SET ';
        foreach ($fields as $field) {
            $sql .= "`$field` = ?,";
        }
        $sql = rtrim($sql, ',');
        $sql .= ' WHERE ' . $where;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_merge($values, $where_values));
    }

    public function delete($table_name, $where, $values = array()) {
        $sql = 'DELETE FROM ' . $this->getTableName($table_name) . ' WHERE ' . $where;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
    }

    public function query($sql, $params = array()) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // ---- Методы для товаров и заказов ----
    public function getProductById($id) {
        return $this->getRowById('products', $id);
    }

    public function createOrder($userId, $productId, $orderDate) {
        $sql = "INSERT INTO " . $this->getTableName('orders') . " (user_id, product_id, order_date) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $productId, $orderDate]);
    }

    public function getUserOrders($userId) {
        $sql = "SELECT o.*, p.name as product_name, p.image, p.price FROM " . $this->getTableName('orders') . " o
                JOIN " . $this->getTableName('products') . " p ON o.product_id = p.id
                WHERE o.user_id = ? ORDER BY o.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrders() {
        $sql = "SELECT o.*, u.login, p.name as product_name, p.image FROM " . $this->getTableName('orders') . " o
                JOIN " . $this->getTableName('users') . " u ON o.user_id = u.id
                JOIN " . $this->getTableName('products') . " p ON o.product_id = p.id
                ORDER BY o.created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderStatus($orderId, $status) {
        $sql = "UPDATE " . $this->getTableName('orders') . " SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $orderId]);
    }

    public function addReview($orderId, $review) {
        $sql = "UPDATE " . $this->getTableName('orders') . " SET review = ?, review_date = NOW() WHERE id = ? AND status = 'completed'";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$review, $orderId]);
    }
    public function addProduct($name, $description, $price, $image) {
        $sql = "INSERT INTO " . $this->getTableName('products') . " (name, description, price, image) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $description, $price, $image]);
    }
    
    public function updateProduct($id, $name, $description, $price, $image) {
        $sql = "UPDATE " . $this->getTableName('products') . " SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$name, $description, $price, $image, $id]);
    }
    
    public function deleteProduct($id) {
        $sql = "DELETE FROM " . $this->getTableName('products') . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>