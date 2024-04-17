DROP DATABASE IF EXISTS `coffee_db`;
CREATE DATABASE IF NOT EXISTS `coffee_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `coffee_db`;


-- Tạo bảng users
CREATE TABLE `users` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `name` nvarchar(255),
  `password` varchar(255),
  `created_at` timestamp
);

-- Tạo bảng roles
CREATE TABLE `roles` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `name` nvarchar(255),
  `description` nvarchar(255),
  `created_at` timestamp
);

-- Tạo bảng role_info
CREATE TABLE `role_info` (
  `role_id` integer,
  `user_id` integer,
  `created_at` timestamp,
  CONSTRAINT `fk_role_info_role_id_roles_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `fk_role_info_user_id_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

-- Tạo bảng foods
CREATE TABLE `foods` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `name` nvarchar(255),
  `recipe_id` integer,
  `description` nvarchar(255),
  `price` integer,
  `category_id` nvarchar(50),
  `created_at` TIMESTAMP,
  CONSTRAINT `fk_foods_categorys_id` FOREIGN KEY (`category_id`) REFERENCES `categorys` (`id`),
  CONSTRAINT `fk_foods_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`)
);

-- Tạo bảng drinks
CREATE TABLE `drinks` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `name` nvarchar(255),
  `recipe_id` integer,
  `description` nvarchar(255),
  `price` integer,
  `category_id` integer,
  `created_at` timestamp,
  CONSTRAINT `fk_drinks_category_id_categorys_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `fk_drinks_recipe_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`)
);

-- Tạo bảng categorys
CREATE TABLE `categories` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `name` nvarchar(255),
  `description` nvarchar(255),
  `created_at` timestamp
);

-- Tạo bảng customers
CREATE TABLE `customers` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `name` nvarchar(255),
  `phone` nvarchar(12),
  `password` varchar(255),
  `point` integer,
  `created_at` timestamp
);

-- Tạo bảng orders
CREATE TABLE `orders` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `customer_id` integer,
  `users_id` integer,
  `status` integer,
  `created_at` timestamp,
  CONSTRAINT `fk_orders_customer_id_customers_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  CONSTRAINT `fk_orders_users_id_users_id` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
);

-- Tạo bảng order_info
CREATE TABLE `order_info` (
  `order_id` integer,
  `menu_item_id` integer,
  `real_price` integer,
  `note` nvarchar(255),
  `status` integer,
  CONSTRAINT `fk_order_info_menu_item_id_foods_id` FOREIGN KEY (`menu_item_id`) REFERENCES `foods` (`id`),
  CONSTRAINT `fk_order_info_menu_item_id_drinks_id` FOREIGN KEY (`menu_item_id`) REFERENCES `drinks` (`id`),
  CONSTRAINT `fk_order_info_order_id_orders_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
);

-- Tạo bảng ingredients
CREATE TABLE `ingredients` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `name` nvarchar(255),
  `price` integer,
  `quantity` integer,
  `unit` nvarchar(50)
);

-- Tạo bảng recipes
CREATE TABLE `recipes` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `name` nvarchar(255),
  `created_at` timestamp
);

-- Tạo bảng recipe_info
CREATE TABLE `recipe_info` (
  `recipe_id` integer,
  `ingredient_id` integer,
  `quantity` integer,
  CONSTRAINT `fk_recipe_info_recipe_id_recipes_id` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`),
  CONSTRAINT `fk_recipe_info_ingredient_id_ingredients_id` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`)
);

-- Tạo bảng import_ingredients
CREATE TABLE `import_ingredients` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `user_id` integer,
  `name` nvarchar(255),
  `created_at` TIMESTAMP,
  CONSTRAINT `fk_import_ingr_info_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

-- Tạo bảng import_ingredient_info
CREATE TABLE `import_ingredient_info` (
  `import_ingredient_id` integer,
  `ingredient_id` integer,
  `quantity` integer,
  `real_price` integer,
  CONSTRAINT `fk_import_ingr_info_import_ingr_id_import_ingr_id` FOREIGN KEY (`import_ingredient_id`) REFERENCES `import_ingredients` (`id`),
  CONSTRAINT `fk_import_ingr_info_ingr_id_ingr_id` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`)
);
