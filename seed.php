<?php
require 'init.php';

// Temporarily disable foreign key checks
query('SET FOREIGN_KEY_CHECKS=0');

query('DELETE FROM users');
query('ALTER TABLE users AUTO_INCREMENT=1');

query('DELETE FROM roles');
query('ALTER TABLE roles AUTO_INCREMENT=1');

// Seed roles
$roles = ['Admin', 'Cashier', 'Accountant', 'Teller'];
foreach ($roles as $role) {
    query('INSERT INTO roles (name) VALUES (?)', [$role]);
}

echo 'Roles seeded successfully.';

// Seed users
$users = [
    ['name' => 'John Doe', 'username' => 'johndoe', 'role_id' => 1, 'phone' => '09962845764', 'email' => 'john@example.com', 'address' => 'meiktila', 'password' => password_hash('password', PASSWORD_BCRYPT), 'gender' => 'male', 'is_active' => 1],
    ['name' => 'Ma Ma', 'username' => 'mama', 'role_id' => 2, 'phone' => '09962845764', 'email' => 'mama@example.com', 'address' => 'yangon', 'password' => password_hash('password', PASSWORD_BCRYPT), 'gender' => 'female', 'is_active' => 1],
];

foreach ($users as $user) {
    query('INSERT INTO users (name, username, role_id, phone, email, address, password, gender, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', 
    [
        $user['name'],
        $user['username'],
        $user['role_id'],
        $user['phone'],
        $user['email'],
        $user['address'],
        $user['password'],
        $user['gender'],
        $user['is_active']
    ]);
}

echo 'Users seeded successfully.';

// Re-enable foreign key checks
query('SET FOREIGN_KEY_CHECKS=1');

echo 'Foreign key checks re-enabled.';
?>