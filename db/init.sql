CREATE TABLE `logement` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `type_id` int,
  `adresse_id` int UNIQUE,
  `proprietaire_id` int,
  `price` decimal(10,2),
  `date_added` datetime,
  `image` varchar(255),
  `description` text,
  `nb_rooms` decimal(10,2),
  `surface` decimal(10,2)
);

CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `email` varchar(100) UNIQUE,
  `password` varchar(128),
  `firstname` varchar(50),
  `lastname` varchar(50),
  `phone_number` varchar(20),
  `role_id` int
);

CREATE TABLE `rentals` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `logement_id` int,
  `rental_date` datetime,
  `end_date` datetime
);

CREATE TABLE `roles` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `role_name` varchar(50)
);

CREATE TABLE `type_logement` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `label` varchar(100)
);

CREATE TABLE `equipements` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nom` varchar(100),
);

CREATE TABLE `logement_equipements` (
  `logement_id` int,
  `equipement_id` int
);

CREATE TABLE `adresse` (
  `adresse_id` int PRIMARY KEY AUTO_INCREMENT,
  `pays` varchar(100),
  `ville` varchar(100),
  `adresse` varchar(255),
  `code_postal` varchar(20)
);

ALTER TABLE `logement` ADD FOREIGN KEY (`type_id`) REFERENCES `type_logement` (`id`);

ALTER TABLE `logement` ADD FOREIGN KEY (`adresse_id`) REFERENCES `adresse` (`adresse_id`);

ALTER TABLE `logement` ADD FOREIGN KEY (`proprietaire_id`) REFERENCES `users` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

ALTER TABLE `rentals` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `rentals` ADD FOREIGN KEY (`logement_id`) REFERENCES `logement` (`id`);

ALTER TABLE `logement_equipements` ADD FOREIGN KEY (`logement_id`) REFERENCES `logement` (`id`);

ALTER TABLE `logement_equipements` ADD FOREIGN KEY (`equipement_id`) REFERENCES `equipements` (`id`);

