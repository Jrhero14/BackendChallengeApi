-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for backendchallange
DROP DATABASE IF EXISTS `backendchallange`;
CREATE DATABASE IF NOT EXISTS `backendchallange` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `backendchallange`;

-- Dumping structure for table backendchallange.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table backendchallange.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table backendchallange.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table backendchallange.migrations: ~6 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(39, '2014_10_12_000000_create_users_table', 1),
	(40, '2014_10_12_100000_create_password_resets_table', 1),
	(41, '2019_08_19_000000_create_failed_jobs_table', 1),
	(42, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(43, '2024_10_04_063205_create_products_table', 1),
	(44, '2024_10_04_063217_create_reviews_table', 1);

-- Dumping structure for table backendchallange.password_resets
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table backendchallange.password_resets: ~0 rows (approximately)

-- Dumping structure for table backendchallange.personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table backendchallange.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table backendchallange.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `imageurl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_user_id_foreign` (`user_id`),
  CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table backendchallange.products: ~8 rows (approximately)
INSERT INTO `products` (`id`, `user_id`, `imageurl`, `nama`, `slug`, `deskripsi`, `harga`, `stok`, `created_at`, `updated_at`) VALUES
	(1, 1, '8HExSLtNhbw4TETXExCKjp9HKmHL3R-metaMF9jYWNoZTk4LnBuZw==-.png', 'INDOMIE MI GORENG RASA RENDANG 91GR', 'indomie-mi-goreng-rasa-rendang-91gr', '<h3>SELAMAT DATANG DI Toko SUKAMURAH</h3><p>KAMI menjual semua BARANG yang terjamin 100 % =<br>* keaslian barangnya<br>* higienis<br>* aman dari kadaluwarsa ( karena QC kita SUPER ketat )<br>* harga yang murah</p><h3>INDOMIE MI GORENG RASA RENDANG 91GR</h3><p>Indomie Mie Goreng Rasa Rendang, Indomie Goreng Rendang terinspirasi dari cita rasa khas kuliner lokal Indonesia asal Padang. Aroma bumbu rendang yang khas berpadu bawang goreng renyah hadirkan rasa mie goreng yang unik dan menggoda. Indomie Goreng Rendang terbuat dari tepung terigu berkualitas dengan paduan rempah-rempah pilihan terbaik, serta diproses dengan higienis menggunakan standar internasional dan teknologi berkualitas tinggi. Juga dilengkapi tambahan fortifikasi mineral dan vitamin A, B1, B6, B12, Niasin, Asam Folat &amp; Mineral Zat Besi yang dibutuhkan tubuh.</p><p><strong>BPOM RI MD 231509011002</strong></p>', 3000, 100, '2024-10-04 02:09:56', '2024-10-04 02:09:56'),
	(2, 2, 'hz5VVPaKB45Kn3xYQFsso02kbQ5HCk-metaOGUwYzVkMGUtMmI5Ny00MGYwLWIxMTktYjZkMWRhZTVmNzc4LmpwZw==-.jpg', '1 KARTON FILMA MINYAK GORENG 2L ISI 6PCS', '1-karton-filma-minyak-goreng-2l-isi-6pcs', '<h3>SELAMAT DATANG DI Toko SUKAMURAHCOM</h3><p>KAMI Menjual semua bahan makanan dan minuman yang terjamin 100 % =<br>* keaslian barang krn kita adalah partner dr pabrikan<br>* higienis<br>* aman dari kadaluarsa ( karena QC kita super ketat )<br>* harga yang murah</p><p>1 KARTON FILMA MINYAK GORENG 2L ISI 6PCS</p><p>Filma minyak goreng pouch merupakan minyak goreng non kolesterol yang terbuat dari buah sawit segar pilihan, diproduksi dengan sistem pemurnian terintegrasi dan pengawasan mutu ekstra ketat, sehingga menghasilkan minyak goreng yang jernih bernutrisi. Filma minyak goreng mengandung asam lemak tak jenuh yang dapat membantu menjaga kadar kolesterol, Omega 6 &amp; Omega 9 yang merupakan asam lemak esensial yang diperlukan oleh tubuh, Vitamin D yang baik untuk membantu pembentukan dan pemeliharaan tulang, serta Vitamin E sebagai anti oksidan alami. Warna kuning keemasannya berasal dari kandungan Beta Karoten alami (Pro Vitamin A).</p><p><strong>BPOM RI MD 208113182013</strong></p>', 215000, 50, '2024-10-04 02:17:15', '2024-10-04 02:17:15'),
	(3, 2, '8e163evSP15SNfVZXqyNjLSPkb2m31-metaYmVuZy1iZW5nLTIwZ3ItMS1ib3gtd2ViLmpwZw==-.jpg', '1 BOX BENG BENG WAFER CARAMEL 25GR ISI 17PCS', '1-box-beng-beng-wafer-caramel-25gr-isi-17pcs', '<h3>SELAMAT DATANG DI Toko SUKAMURAHCOM</h3><p>KAMI menjual semua bahan makanan yang terjamin 100 % =</p><p>* keaslian barangnya dari pabrik</p><p>* higienis</p><p>* aman dari kadaluwarsa ( karena QC kita super ketat )</p><p>* harga yang murah</p><p>1 BOX BENG BENG WAFER CARAMEL 20GR ISI 20PCS</p><p>Beng-Beng, snack coklat-combo, menggabungkan beberapa lapisan elemen lezat di luar sekadar makanan lezat coklat lezat. Hanya Beng Beng yang memegang kombinasi yang menarik, lebih dari sekadar cokelat atau wafer.</p>', 32000, 20, '2024-10-04 02:18:45', '2024-10-04 02:18:45'),
	(4, 3, 'fR82JYAUUiKJmwPo7vvVxMfINNqO1K-metaZG93bmxvYWQtMzkuanBn-.jpg', 'ABC SARDEN TOMAT 425GR', 'abc-sarden-tomat-425gr', '<h3>SELAMAT DATANG DI Toko SUKAMURAHCOM</h3><p>KAMI Menjual semua bahan makanan dan minuman yang terjamin 100 % =<br>* keaslian barang krn kita adalah partner dr pabrikan<br>* higienis<br>* aman dari kadaluarsa ( karena QC kita super ketat )<br>* harga yang murah</p><p>ABC SARDEN TOMAT 425GR</p><p>Sardines ABC dibuat dengan ikan Sardines segar dan Dilengkapi dengan saus CABAI Khas ABC yang terbuat dari bahan- bahan pilihan.</p><p>Sardines ABC mengandung Omega 3 &amp; 6 yang baik bagi anda.</p><p>Berikan Sardines ABC sebagai menu yang lezat dan praktis untuk keluarga Anda Setiap hari</p><p>EXP : 06/03/24</p><p><strong>BPOM RI MD 543909108013</strong></p>', 22500, 10, '2024-10-04 02:24:55', '2024-10-04 02:24:55'),
	(5, 4, 'Eb2uaNxVysO9Hoah5YBNUyTeQUWLq1-metaMV9BODAyMTM5MDAwMjE2N18yMDIzMTAzMTEzMzYxMjAxM19iYXNlLmpwZw==-.jpg', 'SPHP Beras Bulog 5 kg', 'sphp-beras-bulog-5-kg', '<p>Deskripsi</p><ul><li>SPHP Beras Bulog</li><li>Kemasan 5 kg</li><li>Kualitas medium</li></ul><p>SPHP Beras Bulog 5 kg<br>Beras kualitas medium merk SPHP bulog. Hadir dalam kemasan pack 5 kilogram atau kurang lebih 6.2 liter. Beras ini cocok dimasak dengan kadar air sedang (cendrung agak lebih banyak dibandingkan beras lainnya). Cocok untuk penggunaan sehari-hari.<br><br></p>', 55000, 10, '2024-10-04 03:31:31', '2024-10-04 03:31:31'),
	(6, 4, 'RIjgAq9tzQqKfjXQBsQS2qHvLF9Bep-metaMV9BNzkzNDAyMDAwMjE2N18yMDIzMDMyOTE2MzYzNjkyNl9iYXNlLmpwZw==-.jpg', 'Racik Tepung Bumbu Serbaguna 210 g', 'racik-tepung-bumbu-serbaguna-210-g', '<p><strong>Deskripsi</strong></p><ul><li>Racik Tepung Bumbu Serbaguna 210 g</li><li>Dapat digunakan untuk memasak berbagai macam hidangan</li><li>Dapat mempertahankan kerenyahan hingga 5 jam</li><li>Racikan bumbu berkualitas</li><li>Tepung serbaguna</li></ul><p><strong>Racik Tepung Bumbu Serbaguna 210 g</strong> merupakan solusi praktis untuk menciptakan hidangan lezat dengan cepat. Terbuat dari campuran tepung terigu, beras, dan tapioka yang berkualitas tinggi, ditambah dengan sentuhan khas dari beragam rempah pilihan. Produk ini menghasilkan tekstur renyah yang tahan lama hingga 5 jam, serta cita rasa gurih yang kaya. Cocok untuk berbagai masakan keluarga dan sangat mudah digunakan, menjadikannya pilihan ideal untuk memperkaya menu sehari-hari.</p>', 5000, 200, '2024-10-04 03:32:51', '2024-10-04 03:32:51'),
	(7, 3, 'P8KwG9be7DTfPKYySJJEV57uoYgX6M-metaMV9BNzQyMzk3MDAwMTEzNF8yMDI0MDcyNDE3MjQzOTg2M19iYXNlLmpwZw==-.jpg', 'Sari Roti Tawar Jumbo 555 g', 'sari-roti-tawar-jumbo-555-g', '<p><strong>Deskripsi</strong></p><ul><li>Roti tawar</li><li>Teksturnya rotinya lembut dan diperkaya dengan kalsium</li><li>Cocok disantap sebagai menu sarapan</li><li>Tersedia dalam kemasan jumbo 555 g</li></ul><p><strong>SARI ROTI Roti Tawar Jumbo 555 g</strong> adalah roti tawar siap santap yang memiliki tekstur lembut dengan pingiran kulit luar roti yang utuh yang hadir dalam ukuran lebih besar. Roti tawar dapat disantap langsung atau diberikan olesan selai favorit anda untuk menambah cita rasa.&nbsp; Dibuat dengan bahan utama pilihan berkualitas seperti tepung, susu, mentega, dan ragi hingga menghasilkan roti tawar dengan kualitas yang segar dan berkualitas. Memiliki tekstur yang empuk dan lembut saat digigit. Dengan kandungan kalsium, vitamin B1 &amp; B2, vitamin D, dan mineral didalamnya. Dapat dijadikan berbagai macam bahan dasar makanan seperti roti lapis, roti bakar, dan kreasi lainnya. Ukurannya yang lebih besar cocok dinikmati bersama keluarga atau teman. Jadikan menu sarapan semakin spesial dengan mengkreasikan SARI ROTI Roti Tawar Jumbo 555 g<strong>.</strong></p>', 18000, 20, '2024-10-04 03:34:28', '2024-10-04 03:34:28'),
	(8, 3, '6sGCTHioIrgLVXOjUDaxz9deZ4s8sl-metaMV9BMTAxNjAwMDAwODFfMjAyNDA1MjExNTUxMTk4NzlfYmFzZS5qcGc=-.jpg', 'Roma Sari Gandum Biskuit Sandwich Susu & Cokelat 108 g', 'roma-sari-gandum-biskuit-sandwich-susu-cokelat-108-g', '<p><strong>Deskripsi</strong></p><ul><li>Biskuit sandwich gandum</li><li>Rasa susu dan cokelat</li><li>Mengandung fiber, antioksidan, beberapa vitamin, selenium, zinc, dan magnesium</li><li>Kemasannya praktis dan mudah dibawa ke mana saja</li><li>Tersedia dalam kemasan 108 g</li></ul><p><strong>Roma Sari Gandum Sandwich Biskuit Susu &amp; Cokelat 108 g</strong> adalah makanan camilan berupa biskuit yang terbuat dari gandum dan dipenuhi susu bergizi. Biskuit gandum ini dapat memberi banyak manfaat bagi siapa saja yang mengonsumsinya karena biji gandumnya mengandung fiber, antioksidan, beberapa vitamin, selenium, zinc, dan magnesium yang dapat mendukung kebutuhan gizi Anda. Disempurnakan juga dengan tambahan rasa cokelat dan susu bergizi yang menambah kenikmatan dari biskuit gandum itu sendiri. Roma Sari Gandum Sandwich Biskuit Susu &amp; Cokelat 108 g cocok untuk dijadikan menu camilan diet.</p>', 10000, 50, '2024-10-04 03:38:36', '2024-10-04 03:38:36');

-- Dumping structure for table backendchallange.reviews
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `rating` int NOT NULL,
  `body` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table backendchallange.reviews: ~8 rows (approximately)
INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `body`, `created_at`, `updated_at`) VALUES
	(1, 3, 5, 5, 'Beras super kualitasnya baik', '2024-10-04 03:54:51', '2024-10-04 03:54:51'),
	(2, 4, 1, 5, 'Barang bagus, harga murah terbaik', '2024-10-04 03:57:00', '2024-10-04 03:57:00'),
	(3, 2, 8, 5, 'Ga pernah gagal beli di sini selalu oke', '2024-10-04 03:58:24', '2024-10-04 03:58:24'),
	(4, 3, 3, 4, 'Barangnya bagus, cuma saat packing ada kerusakan dikit', '2024-10-04 03:59:05', '2024-10-04 03:59:24'),
	(5, 2, 4, 1, 'Barang saat sampai hancur, packingnya tidak rapih', '2024-10-04 03:59:57', '2024-10-04 03:59:57'),
	(6, 3, 1, 5, 'Pembelian kedua kali, asli bagus dan expired masih lama', '2024-10-04 04:00:44', '2024-10-04 04:00:44'),
	(7, 4, 1, 3, 'Packing bocor, mienya hilang 1 pcs', '2024-10-04 04:01:18', '2024-10-04 04:01:18'),
	(8, 2, 1, 4, 'Humm barangnya bagus tapi packing kurang baik', '2024-10-04 04:54:04', '2024-10-04 04:54:04');

-- Dumping structure for table backendchallange.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table backendchallange.users: ~4 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Jeremi Herodian Abednigo', 'admin@jeremi.com', '2024-10-06 12:58:50', '$2y$10$2wbF1yOPnVhu8VjIS07VvOSOQ3kjREHTv4w14UtcS8Z5EbCC9VlCG', NULL, '2024-10-04 01:56:48', '2024-10-04 01:56:48'),
	(2, 'Budiman', 'budiman@email.com', NULL, '$2y$10$Ff3eNP63ERrN1vXHiVvj9OBmadz4rnt/boeEVMnMfd6eB5X78Skd6', NULL, '2024-10-04 02:15:51', '2024-10-06 06:26:09'),
	(3, 'Harianto', 'Harianto@email.com', NULL, '$2y$10$FrV4nSMSOBB8iQmF6bFo6uQ9odYxUT33SCg4fjcodJyk9hv0Dvszm', NULL, '2024-10-04 02:24:08', '2024-10-06 06:17:33'),
	(4, 'Udiana', 'udinana@email.com', NULL, '$2y$10$cmVhCWLs.4jLwh9CUfXhw.W2ZFLcRJOPMsnXQsfFI5rMjE4/az4KC', NULL, '2024-10-04 03:29:35', '2024-10-06 06:17:43');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
