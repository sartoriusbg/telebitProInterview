CREATE TABLE `users` (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(30),
  password VARCHAR(30),
  email VARCHAR(50) UNIQUE,
  active tinyint(1) DEFAULT 0,
  activation_code varchar(255) NOT NULL
);
