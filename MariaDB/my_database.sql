-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 31, 2024 at 12:59 PM
-- Server version: 11.5.2-MariaDB-ubu2404
-- PHP Version: 8.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `dish`
--

CREATE TABLE `dish` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `picture` varchar(200) DEFAULT NULL,
  `price` decimal(6,2) NOT NULL,
  `dish_day_id` int(11) NOT NULL,
  `dish_menu_id` int(11) NOT NULL,
  `available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dish`
--

INSERT INTO `dish` (`id`, `name`, `description`, `picture`, `price`, `dish_day_id`, `dish_menu_id`, `available`) VALUES
(1, 'macarrones a la boloñesa', 'Suspendisse bibendum velit at ex interdum lacinia. Nam bibendum tortor nisl, vel ultricies risus semper sed. Praesent efficitur tortor in pretium maximus. Sed nec mattis nulla. Donec eleifend in lectus in accumsan. Integer semper finibus sapien, lacinia aliquam leo varius in. Vivamus imperdiet lectus a massa imperdiet sollicitudin. \r\n\r\nSed pellentesque, mauris ut tempor dictum, libero ex malesuada ante, a commodo sem risus non felis. Maecenas venenatis pellentesque turpis eu suscipit.', 'macarrones-bolognesa-6404fe2603f1f.png', 11.75, 4, 2, 0),
(2, 'ensalada catalana', 'Suspendisse bibendum velit at ex interdum lacinia. Nam bibendum tortor nisl, vel ultricies risus semper sed. Praesent efficitur tortor in pretium maximus. Sed nec mattis nulla. \r\n\r\nDonec eleifend in lectus in accumsan. Integer semper finibus sapien, lacinia aliquam leo varius in. Vivamus imperdiet lectus a massa imperdiet sollicitudin. Sed pellentesque, mauris ut tempor dictum, libero ex malesuada ante, a commodo sem risus non felis. Maecenas venenatis pellentesque turpis eu suscipit.', 'ensalada-catalana-640513571a216.png', 8.20, 4, 3, 1),
(3, 'ensalada mixta', 'Integer malesuada pellentesque ligula, ac elementum mi porttitor sed. Vestibulum ullamcorper velit a dui dignissim consectetur. In ut odio sed ex pulvinar condimentum eget et turpis. Nunc felis nunc, venenatis ut dui eu, eleifend lacinia ante. Praesent non pharetra libero. Integer eu pretium nunc, venenatis interdum tellus. Ut pretium ligula vitae mauris dictum lacinia. Aenean malesuada euismod lectus quis volutpat. Suspendisse nec tempor nisi.', 'ensalada-mixta-6408f148d4d27.png', 8.50, 1, 3, 1),
(4, 'paella valenciana', 'Integer malesuada pellentesque ligula, ac elementum mi porttitor sed. Vestibulum ullamcorper velit a dui dignissim consectetur. In ut odio sed ex pulvinar condimentum eget et turpis. Nunc felis nunc, venenatis ut dui eu, eleifend lacinia ante. Praesent non pharetra libero. Integer eu pretium nunc, venenatis interdum tellus. Ut pretium ligula vitae mauris dictum lacinia. Aenean malesuada euismod lectus quis volutpat. Suspendisse nec tempor nisi.', 'paella-valenciana-jpg-6408f190f338b.png', 11.25, 2, 6, 1),
(5, 'bistec con patatas', 'Integer malesuada pellentesque ligula, ac elementum mi porttitor sed. Vestibulum ullamcorper velit a dui dignissim consectetur. In ut odio sed ex pulvinar condimentum eget et turpis. Nunc felis nunc, venenatis ut dui eu, eleifend lacinia ante. Praesent non pharetra libero. Integer eu pretium nunc, venenatis interdum tellus. Ut pretium ligula vitae mauris dictum lacinia. Aenean malesuada euismod lectus quis volutpat. Suspendisse nec tempor nisi.', 'bistec-patatas-6408f2785ab36.png', 9.50, 2, 4, 1),
(6, 'arroz con setas', 'nteger malesuada pellentesque ligula, ac elementum mi porttitor sed. Vestibulum ullamcorper velit a dui dignissim consectetur. In ut odio sed ex pulvinar condimentum eget et turpis. Nunc felis nunc, venenatis ut dui eu, eleifend lacinia ante. Praesent non pharetra libero. Integer eu pretium nunc, venenatis interdum tellus. Ut pretium ligula vitae mauris dictum lacinia. Aenean malesuada euismod lectus quis volutpat. Suspendisse nec tempor nisi.', 'arroz-setas-6408f2c3eac89.png', 12.00, 4, 6, 1),
(7, 'espaguetis a la carbonara', 'Integer malesuada pellentesque ligula, ac elementum mi porttitor sed. Vestibulum ullamcorper velit a dui dignissim consectetur. In ut odio sed ex pulvinar condimentum eget et turpis. Nunc felis nunc, venenatis ut dui eu, eleifend lacinia ante. Praesent non pharetra libero. Integer eu pretium nunc, venenatis interdum tellus. Ut pretium ligula vitae mauris dictum lacinia. Aenean malesuada euismod lectus quis volutpat. Suspendisse nec tempor nisi.', 'espagueti-carbo-6408f30e586cb.png', 8.50, 1, 2, 1),
(8, 'crema catalana', 'Integer malesuada pellentesque ligula, ac elementum mi porttitor sed. Vestibulum ullamcorper velit a dui dignissim consectetur. In ut odio sed ex pulvinar condimentum eget et turpis. Nunc felis nunc, venenatis ut dui eu, eleifend lacinia ante. Praesent non pharetra libero. Integer eu pretium nunc, venenatis interdum tellus. Ut pretium ligula vitae mauris dictum lacinia. Aenean malesuada euismod lectus quis volutpat. Suspendisse nec tempor nisi.', 'crema-catalana-6408f362b203c.png', 6.00, 3, 7, 1),
(9, 'entrecotte a la parrilla', 'Integer malesuada pellentesque ligula, ac elementum mi porttitor sed. Vestibulum ullamcorper velit a dui dignissim consectetur. In ut odio sed ex pulvinar condimentum eget et turpis. Nunc felis nunc, venenatis ut dui eu, eleifend lacinia ante. Praesent non pharetra libero. Integer eu pretium nunc, venenatis interdum tellus. Ut pretium ligula vitae mauris dictum lacinia. Aenean malesuada euismod lectus quis volutpat. Suspendisse nec tempor nisi.', 'entrecote-6408f396812a4.png', 12.30, 4, 4, 1),
(10, 'Jarra de Cerveza', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam at ipsum et enim euismod congue. Cras dictum auctor finibus. Ut et ultrices tellus. Maecenas tempus et ligula a fermentum. Maecenas lacinia ultricies quam ac posuere. Nam placerat lacus suscipit lectus venenatis scelerisque. Quisque tristique faucibus pretium.', 'beer-676535c3d060b.webp', 3.50, 4, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dish_day`
--

CREATE TABLE `dish_day` (
  `id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dish_day`
--

INSERT INTO `dish_day` (`id`, `category_name`) VALUES
(1, 'primero'),
(2, 'segundo'),
(3, 'postre'),
(4, 'carta');

-- --------------------------------------------------------

--
-- Table structure for table `dish_menu`
--

CREATE TABLE `dish_menu` (
  `id` int(11) NOT NULL,
  `menu_category` varchar(50) NOT NULL,
  `menu_emoji` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dish_menu`
--

INSERT INTO `dish_menu` (`id`, `menu_category`, `menu_emoji`) VALUES
(1, 'aperitivos', '&#127839;'),
(2, 'entrantes', '&#127836;'),
(3, 'ensaladas', '&#129367;'),
(4, 'carnes', '&#129385;'),
(5, 'pescados', '&#128031;'),
(6, 'arroces', '&#129368;'),
(7, 'postres', '&#129473;'),
(8, 'cafés', '&#9749;'),
(9, 'tintos', '&#127863;'),
(10, 'blancos', '&#127863;'),
(11, 'rosados', '&#127863;'),
(12, 'cavas', '&#127870;'),
(13, 'champagne', '&#127870;'),
(14, 'bebidas', '&#127866;'),
(15, 'licores', '&#127865;');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230221213930', '2023-02-21 22:40:24', 83),
('DoctrineMigrations\\Version20230227202115', '2023-02-27 21:21:31', 92),
('DoctrineMigrations\\Version20230227202623', '2023-02-27 21:26:36', 33),
('DoctrineMigrations\\Version20230227203003', '2023-02-27 21:30:14', 26),
('DoctrineMigrations\\Version20230227204416', '2023-02-27 21:44:31', 157),
('DoctrineMigrations\\Version20230227205105', '2023-02-27 21:51:18', 154),
('DoctrineMigrations\\Version20230227205548', '2023-02-27 21:56:01', 207),
('DoctrineMigrations\\Version20230227210210', '2023-02-27 22:02:21', 36),
('DoctrineMigrations\\Version20230301212938', '2023-03-01 22:29:48', 64),
('DoctrineMigrations\\Version20230422193808', '2023-04-22 21:38:43', 129),
('DoctrineMigrations\\Version20230423080245', '2023-04-23 10:03:47', 38),
('DoctrineMigrations\\Version20241125195812', '2024-11-25 21:04:26', 166),
('DoctrineMigrations\\Version20241218114904', '2024-12-18 12:49:57', 42),
('DoctrineMigrations\\Version20241221192453', '2024-12-21 20:25:18', 71),
('DoctrineMigrations\\Version20241230101326', '2024-12-30 11:13:42', 32);

-- --------------------------------------------------------

--
-- Table structure for table `menu_day_price`
--

CREATE TABLE `menu_day_price` (
  `id` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_day_price`
--

INSERT INTO `menu_day_price` (`id`, `price`) VALUES
(1, 15.80);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `table_number` smallint(6) NOT NULL,
  `people_qty` smallint(6) NOT NULL,
  `aperitifs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`aperitifs`)),
  `firsts` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`firsts`)),
  `seconds` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`seconds`)),
  `drinks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`drinks`)),
  `desserts` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`desserts`)),
  `coffees` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`coffees`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'ROLE_ADMIN'),
(2, 'ROLE_USER'),
(3, 'ROLE_WAITER');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `email`, `roles`, `password`) VALUES
(1, 'admin', 'admin@admin.com', '[\"ROLE_ADMIN\"]', '$2y$13$bVmNFfFMjVjwv/l5eR6t5.AYjOmUWdZBTmaNNzSEirpFyyCbF8BSG'),
(2, 'pepe', 'pepe@pepe.com', '[\"ROLE_USER\"]', '$2y$13$XSWyywf1abLJtW/zHUwC2.1XpyhF/ZLeAHAX83.DVY.AJajglzNrq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dish`
--
ALTER TABLE `dish`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_957D8CB81C54629` (`dish_day_id`),
  ADD KEY `IDX_957D8CB85C60F384` (`dish_menu_id`);

--
-- Indexes for table `dish_day`
--
ALTER TABLE `dish_day`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dish_menu`
--
ALTER TABLE `dish_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `menu_day_price`
--
ALTER TABLE `menu_day_price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dish`
--
ALTER TABLE `dish`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dish_day`
--
ALTER TABLE `dish_day`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dish_menu`
--
ALTER TABLE `dish_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `menu_day_price`
--
ALTER TABLE `menu_day_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dish`
--
ALTER TABLE `dish`
  ADD CONSTRAINT `FK_957D8CB81C54629` FOREIGN KEY (`dish_day_id`) REFERENCES `dish_day` (`id`),
  ADD CONSTRAINT `FK_957D8CB85C60F384` FOREIGN KEY (`dish_menu_id`) REFERENCES `dish_menu` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
