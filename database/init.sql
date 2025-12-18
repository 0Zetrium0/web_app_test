CREATE DATABASE IF NOT EXISTS web_app;

CREATE TABLE web_app.fruits (
	id INT AUTO_INCREMENT PRIMARY KEY,
	nom_fruit VARCHAR(255) UNIQUE NOT NULL,
	stock INT UNSIGNED NOT NULL DEFAULT 0
);

INSERT INTO web_app.fruits (nom_fruit, stock) VALUES ("pomme", 0);
