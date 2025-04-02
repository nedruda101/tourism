-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 02, 2025 at 07:28 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tourism_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `book_list`
--

CREATE TABLE `book_list` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `package_id` int(30) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=pending,1=confirm, 2=cancelled\r\n',
  `schedule` date DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_list`
--

INSERT INTO `book_list` (`id`, `user_id`, `package_id`, `status`, `schedule`, `date_created`) VALUES
(2, 4, 8, 3, '2021-06-21', '2021-06-19 08:37:59'),
(3, 5, 8, 3, '2021-06-18', '2021-06-19 11:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `inquiry`
--

CREATE TABLE `inquiry` (
  `id` int(30) NOT NULL,
  `name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `subject` varchar(250) NOT NULL,
  `message` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `video` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiry`
--

INSERT INTO `inquiry` (`id`, `name`, `email`, `subject`, `message`, `status`, `date_created`, `video`) VALUES
(6, 'asdasd', 'asdasd@asdasd.com', 'asdasd', 'asdasd', 1, '2021-06-19 10:19:27', NULL),
(8, 'rey', 'Nedrudarey101@gmaill.com', '123123', '1231231231', 1, '2025-03-26 14:40:06', NULL),
(9, 'rey', 'Nedrudarey101@gmaill.com', 'PASALI SA HIGHLIGHTS', 'please', 1, '2025-04-02 13:01:26', NULL),
(13, 'asdasd', 'asdasd', 'asdasd', 'asdasd', 1, '2025-04-02 13:11:00', 'uploads/videos1743570660_123123123123aaaaa.mp4'),
(14, 'qweqwe', 'qweqwe', 'qweqweqwe', 'qweqweqwe', 0, '2025-04-02 13:16:14', 'uploads/videos/1743570974_1743556784_sg5.mp4'),
(15, '', '', '', '', 0, '2025-04-02 13:16:17', NULL),
(16, 'rey', 'rewrqw', 'qwerqwerweqr', 'qwerwqer', 0, '2025-04-02 13:24:23', 'uploads/videos/1743571463_1743556784_sg5.mp4'),
(17, 'qweqwe', 'qweqwe', 'qweqwe', 'qweqwe', 0, '2025-04-02 13:26:19', '/Applications/XAMPP/xamppfiles/htdocs/tourism/classes/uploads/videos/1743571579_123123123123aaaaa.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(30) NOT NULL,
  `title` text DEFAULT NULL,
  `tour_location` text DEFAULT NULL,
  `cost` text NOT NULL,
  `description` text DEFAULT NULL,
  `upload_path` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 =active ,2 = Inactive',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `opening_hours` varchar(50) DEFAULT NULL COMMENT 'Opening hours in format like "9:00 AM - 5:00 PM"',
  `upload_path_video` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `title`, `tour_location`, `cost`, `description`, `upload_path`, `status`, `date_created`, `opening_hours`, `upload_path_video`) VALUES
(9, 'SG Farm', '6.339855, 125.037044\r\nGlandang Rd, Tupi, South Cotabato', 'Paid entry', '&lt;p&gt;&lt;strong&gt;SG Farm - Glandang Rd, Tupi, South Cotabato, Philippines&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;SG Farm, located in the serene hills of &lt;strong&gt;Glandang, Tupi, South Cotabato&lt;/strong&gt;, is a popular agri-tourism destination known for its &lt;strong&gt;picturesque landscapes, cool climate, and vibrant flower gardens&lt;/strong&gt;. Perched on the foothills of Mt. Matutum, the farm offers a stunning panoramic view of the lush greenery and surrounding mountains, making it a perfect getaway for nature lovers and photography enthusiasts.&lt;/p&gt;&lt;h3&gt;🌸 &lt;strong&gt;Key Highlights:&lt;/strong&gt;&lt;/h3&gt;&lt;ul&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Flower Gardens:&lt;/strong&gt; SG Farm is famous for its vibrant flower beds featuring a variety of colorful blooms, including sunflowers, celosias, and other ornamental plants. These gardens serve as perfect photo spots, attracting visitors for both leisure and social media-worthy snapshots.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Scenic View Decks:&lt;/strong&gt; Multiple viewing decks provide breathtaking views of Mt. Matutum and the surrounding countryside, making it an ideal spot to relax and appreciate nature&rsquo;s beauty.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Camping and Glamping Options:&lt;/strong&gt; For those seeking a unique overnight stay, SG Farm offers &lt;strong&gt;camping and glamping&lt;/strong&gt; facilities, allowing visitors to enjoy the cool breeze and stargaze at night.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Instagram-Worthy Spots:&lt;/strong&gt; The farm boasts several creative and picturesque installations such as colorful benches, swings, and heart-shaped flower arches that serve as great backdrops for memorable photos.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Caf&eacute; and Refreshments:&lt;/strong&gt; A cozy caf&eacute; on-site serves local delicacies and refreshments, allowing guests to enjoy delicious food while taking in the tranquil atmosphere.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Events and Gatherings:&lt;/strong&gt; SG Farm is also a great venue for hosting events, such as pre-nuptial shoots, family gatherings, and intimate celebrations.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3&gt;📍 &lt;strong&gt;Location and Accessibility:&lt;/strong&gt;&lt;/h3&gt;&lt;ul&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Address:&lt;/strong&gt; Glandang Rd, Tupi, South Cotabato, Philippines&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;&lt;strong&gt;Access:&lt;/strong&gt; Easily accessible by private vehicle or local transportation from General Santos City or Koronadal City. The farm is approximately 30-40 minutes away from the town proper of Tupi.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3&gt;⏰ &lt;strong&gt;Operating Hours:&lt;/strong&gt;&lt;/h3&gt;&lt;ul&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;Typically open daily from &lt;strong&gt;7:00 AM to 6:00 PM&lt;/strong&gt;. Operating hours may vary depending on weather conditions or special events.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3&gt;🎟️ &lt;strong&gt;Entrance Fee:&lt;/strong&gt;&lt;/h3&gt;&lt;ul&gt;\r\n&lt;li&gt;\r\n&lt;p&gt;Affordable entrance fee, with discounts available for children and senior citizens. Camping and glamping rates vary depending on the package.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;p&gt;SG Farm is a must-visit destination for anyone looking to unwind, capture beautiful memories, and experience the charm of Tupi&rsquo;s countryside. 🌿✨&lt;/p&gt;', 'uploads/package_9', 1, '2025-04-01 11:32:02', '7:00 AM - 6:00 PM', 'uploads/video_9'),
(10, 'Mariano’s Blooming Agri-Tourism Park', '6.342676, 124.952415\r\nLinan, Tupi, South Cotabato', 'Free entry', '&lt;p data-start=&quot;211&quot; data-end=&quot;672&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;211&quot; data-end=&quot;251&quot;&gt;Mariano&rsquo;s Blooming Agri-Tourism Park&lt;/strong&gt; is a breathtaking floral paradise nestled in &lt;strong data-start=&quot;297&quot; data-end=&quot;321&quot;&gt;Tupi, South Cotabato&lt;/strong&gt;. Spanning &lt;strong data-start=&quot;332&quot; data-end=&quot;347&quot;&gt;13 hectares&lt;/strong&gt;, this vibrant attraction is best known for its &lt;strong data-start=&quot;395&quot; data-end=&quot;483&quot;&gt;expansive sunflower fields, intricate flower mandalas, and diverse botanical gardens&lt;/strong&gt;. Offering a serene escape with scenic views of &lt;strong data-start=&quot;531&quot; data-end=&quot;546&quot;&gt;Mt. Matutum&lt;/strong&gt;, the park is a perfect destination for nature lovers, photography enthusiasts, and families looking for a relaxing getaway.&lt;/p&gt;&lt;h3 data-start=&quot;674&quot; data-end=&quot;702&quot; class=&quot;&quot;&gt;🌸 &lt;strong data-start=&quot;681&quot; data-end=&quot;700&quot;&gt;Key Highlights:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;704&quot; data-end=&quot;1793&quot;&gt;\r\n&lt;li data-start=&quot;704&quot; data-end=&quot;915&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;706&quot; data-end=&quot;915&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;706&quot; data-end=&quot;744&quot;&gt;Sunflower Fields &amp; Flower Mandalas&lt;/strong&gt; 🌻&lt;br data-start=&quot;747&quot; data-end=&quot;750&quot;&gt;\r\nExperience the beauty of &lt;strong data-start=&quot;777&quot; data-end=&quot;804&quot;&gt;thousands of sunflowers&lt;/strong&gt; in full bloom, along with &lt;strong data-start=&quot;831&quot; data-end=&quot;867&quot;&gt;intricately designed flower beds&lt;/strong&gt; that create a mesmerizing tapestry of colors.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;917&quot; data-end=&quot;1180&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;919&quot; data-end=&quot;1180&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;919&quot; data-end=&quot;957&quot;&gt;Scenic Viewpoints &amp; Photo Spots 📷&lt;/strong&gt;&lt;br data-start=&quot;957&quot; data-end=&quot;960&quot;&gt;\r\nThe park offers &lt;strong data-start=&quot;978&quot; data-end=&quot;1012&quot;&gt;panoramic views of Mt. Matutum&lt;/strong&gt;, providing stunning backdrops for &lt;strong data-start=&quot;1047&quot; data-end=&quot;1074&quot;&gt;Instagram-worthy photos&lt;/strong&gt;. Don&rsquo;t miss the &lt;strong data-start=&quot;1091&quot; data-end=&quot;1144&quot;&gt;wooden bridges, flower arches, and rustic benches&lt;/strong&gt; scattered throughout the gardens!&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1182&quot; data-end=&quot;1386&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1184&quot; data-end=&quot;1386&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1184&quot; data-end=&quot;1202&quot;&gt;Mirasol Caf&eacute; ☕&lt;/strong&gt;&lt;br data-start=&quot;1202&quot; data-end=&quot;1205&quot;&gt;\r\nEnjoy &lt;strong data-start=&quot;1213&quot; data-end=&quot;1262&quot;&gt;locally inspired dishes and refreshing drinks&lt;/strong&gt; at the park&rsquo;s cozy caf&eacute;. Try their &lt;strong data-start=&quot;1298&quot; data-end=&quot;1328&quot;&gt;butterfly pea flower salad&lt;/strong&gt; or the signature &lt;strong data-start=&quot;1346&quot; data-end=&quot;1383&quot;&gt;chicken binakol served in coconut&lt;/strong&gt;.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1388&quot; data-end=&quot;1580&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1390&quot; data-end=&quot;1580&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1390&quot; data-end=&quot;1438&quot;&gt;Bird Sanctuary &amp; Eco-Friendly Environment 🦜&lt;/strong&gt;&lt;br data-start=&quot;1438&quot; data-end=&quot;1441&quot;&gt;\r\nAside from its floral attractions, the park also houses a &lt;strong data-start=&quot;1501&quot; data-end=&quot;1519&quot;&gt;bird sanctuary&lt;/strong&gt;, making it a haven for nature conservation and relaxation.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1582&quot; data-end=&quot;1793&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1584&quot; data-end=&quot;1793&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1584&quot; data-end=&quot;1623&quot;&gt;Perfect for Events &amp; Photoshoots 🎉&lt;/strong&gt;&lt;br data-start=&quot;1623&quot; data-end=&quot;1626&quot;&gt;\r\nThe park is a popular venue for &lt;strong data-start=&quot;1660&quot; data-end=&quot;1718&quot;&gt;pre-nuptial shoots, family outings, and special events&lt;/strong&gt;. Visitors can also rent &lt;strong data-start=&quot;1743&quot; data-end=&quot;1759&quot;&gt;picnic areas&lt;/strong&gt; for a more intimate experience.&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;1795&quot; data-end=&quot;1833&quot; class=&quot;&quot;&gt;📍 &lt;strong data-start=&quot;1802&quot; data-end=&quot;1831&quot;&gt;Location &amp; Accessibility:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;1834&quot; data-end=&quot;2202&quot;&gt;\r\n&lt;li data-start=&quot;1834&quot; data-end=&quot;1914&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1836&quot; data-end=&quot;1914&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1836&quot; data-end=&quot;1848&quot;&gt;Address:&lt;/strong&gt; Purok 3A, Barangay Poblacion, Tupi, South Cotabato, Philippines&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;1915&quot; data-end=&quot;2202&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1917&quot; data-end=&quot;1940&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;1917&quot; data-end=&quot;1938&quot;&gt;How to Get There:&lt;/strong&gt;&lt;/p&gt;\r\n&lt;ul data-start=&quot;1943&quot; data-end=&quot;2202&quot;&gt;\r\n&lt;li data-start=&quot;1943&quot; data-end=&quot;2021&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;1945&quot; data-end=&quot;2021&quot; class=&quot;&quot;&gt;From &lt;strong data-start=&quot;1950&quot; data-end=&quot;1968&quot;&gt;Koronadal City&lt;/strong&gt;: 30-minute drive via the &lt;strong data-start=&quot;1994&quot; data-end=&quot;2019&quot;&gt;Tupi National Highway&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2024&quot; data-end=&quot;2098&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2026&quot; data-end=&quot;2098&quot; class=&quot;&quot;&gt;From &lt;strong data-start=&quot;2031&quot; data-end=&quot;2054&quot;&gt;General Santos City&lt;/strong&gt;: 45-minute drive via &lt;strong data-start=&quot;2076&quot; data-end=&quot;2096&quot;&gt;Digos-Makar Road&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2101&quot; data-end=&quot;2202&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2103&quot; data-end=&quot;2202&quot; class=&quot;&quot;&gt;Public transport is available from Tupi town proper via &lt;strong data-start=&quot;2159&quot; data-end=&quot;2200&quot;&gt;tricycles or habal-habal (motorbikes)&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;2204&quot; data-end=&quot;2232&quot; class=&quot;&quot;&gt;⏰ &lt;strong data-start=&quot;2210&quot; data-end=&quot;2230&quot;&gt;Operating Hours:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;2233&quot; data-end=&quot;2315&quot;&gt;\r\n&lt;li data-start=&quot;2233&quot; data-end=&quot;2268&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2235&quot; data-end=&quot;2268&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2235&quot; data-end=&quot;2248&quot;&gt;Weekdays:&lt;/strong&gt; 7:00 AM &ndash; 5:30 PM&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2269&quot; data-end=&quot;2315&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2271&quot; data-end=&quot;2315&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2271&quot; data-end=&quot;2295&quot;&gt;Weekends &amp; Holidays:&lt;/strong&gt; 7:00 AM &ndash; 6:00 PM&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;2317&quot; data-end=&quot;2344&quot; class=&quot;&quot;&gt;🎟️ &lt;strong data-start=&quot;2325&quot; data-end=&quot;2342&quot;&gt;Entrance Fee:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;2345&quot; data-end=&quot;2474&quot;&gt;\r\n&lt;li data-start=&quot;2345&quot; data-end=&quot;2377&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2347&quot; data-end=&quot;2377&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2347&quot; data-end=&quot;2360&quot;&gt;Weekdays:&lt;/strong&gt; ₱50 per person&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2378&quot; data-end=&quot;2421&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2380&quot; data-end=&quot;2421&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2380&quot; data-end=&quot;2404&quot;&gt;Weekends &amp; Holidays:&lt;/strong&gt; ₱70 per person&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2422&quot; data-end=&quot;2474&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2424&quot; data-end=&quot;2474&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2424&quot; data-end=&quot;2472&quot;&gt;Discounts available for seniors and children&lt;/strong&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;h3 data-start=&quot;2476&quot; data-end=&quot;2509&quot; class=&quot;&quot;&gt;📞 &lt;strong data-start=&quot;2483&quot; data-end=&quot;2507&quot;&gt;Contact Information:&lt;/strong&gt;&lt;/h3&gt;&lt;ul data-start=&quot;2510&quot; data-end=&quot;2706&quot;&gt;\r\n&lt;li data-start=&quot;2510&quot; data-end=&quot;2541&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2512&quot; data-end=&quot;2541&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2512&quot; data-end=&quot;2522&quot;&gt;Phone:&lt;/strong&gt; +63 997 204 2560&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2542&quot; data-end=&quot;2590&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2544&quot; data-end=&quot;2590&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2544&quot; data-end=&quot;2571&quot;&gt;Mirasol Caf&eacute; Inquiries:&lt;/strong&gt; +63 910 547 0020&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;li data-start=&quot;2591&quot; data-end=&quot;2706&quot; class=&quot;&quot;&gt;\r\n&lt;p data-start=&quot;2593&quot; data-end=&quot;2706&quot; class=&quot;&quot;&gt;&lt;strong data-start=&quot;2593&quot; data-end=&quot;2606&quot;&gt;Facebook:&lt;/strong&gt; &lt;a data-start=&quot;2607&quot; data-end=&quot;2704&quot; rel=&quot;noopener&quot; target=&quot;_new&quot; class=&quot;&quot; href=&quot;https://www.facebook.com/bloomingagritourismparkofficial/&quot;&gt;Mariano&rsquo;s Blooming Agri-Tourism Park&lt;/a&gt;&lt;/p&gt;\r\n&lt;/li&gt;\r\n&lt;/ul&gt;&lt;p&gt;🌿 Whether you&rsquo;re looking for a &lt;strong data-start=&quot;2740&quot; data-end=&quot;2809&quot;&gt;relaxing retreat, a romantic getaway, or a fun-filled family trip&lt;/strong&gt;, Mariano&rsquo;s Blooming Agri-Tourism Park promises a &lt;strong data-start=&quot;2859&quot; data-end=&quot;2897&quot;&gt;blooming experience like no other!&lt;/strong&gt; 🌸✨&lt;/p&gt;', 'uploads/package_10', 1, '2025-04-01 16:11:15', '7:00 AM - 6:00 PM', 'uploads/video_10'),
(11, 'Brittannika Golf Course', '6.381255, 124.982023\r\nKipalbig, South Cotabato', 'Paid entry', '<p data-start=\"191\" data-end=\"535\" class=\"\"><strong data-start=\"191\" data-end=\"218\">Brittannika Golf Course</strong>, nestled in the lush greenery of <strong data-start=\"252\" data-end=\"292\">Barangay Linan, Tupi, South Cotabato</strong>, is a premier destination for golf enthusiasts and nature lovers alike. With its <strong data-start=\"374\" data-end=\"457\">expansive fairways, breathtaking views of Mt. Matutum, and cool highland breeze</strong>, this golf course offers a <strong data-start=\"485\" data-end=\"532\">relaxing and world-class golfing experience</strong>.</p><h3 data-start=\"537\" data-end=\"564\" class=\"\">⛳ <strong data-start=\"543\" data-end=\"562\">Key Highlights:</strong></h3><ul data-start=\"566\" data-end=\"1594\">\r\n<li data-start=\"566\" data-end=\"771\" class=\"\">\r\n<p data-start=\"568\" data-end=\"771\" class=\"\"><strong data-start=\"568\" data-end=\"604\">Challenging &amp; Scenic Fairways 🌿</strong><br data-start=\"604\" data-end=\"607\">\r\nThe golf course boasts <strong data-start=\"632\" data-end=\"690\">well-manicured greens and strategically placed hazards</strong>, making it a thrilling experience for both <strong data-start=\"734\" data-end=\"768\">beginners and seasoned golfers</strong>.</p>\r\n</li>\r\n<li data-start=\"773\" data-end=\"981\" class=\"\">\r\n<p data-start=\"775\" data-end=\"981\" class=\"\"><strong data-start=\"775\" data-end=\"816\">Breathtaking Views of Mt. Matutum 🏔️</strong><br data-start=\"816\" data-end=\"819\">\r\nLocated in the foothills of <strong data-start=\"849\" data-end=\"886\">South Cotabato’s most iconic peak</strong>, Brittannika offers a <strong data-start=\"909\" data-end=\"928\">tranquil escape</strong> with <strong data-start=\"934\" data-end=\"978\">panoramic mountain and countryside views</strong>.</p>\r\n</li>\r\n<li data-start=\"983\" data-end=\"1218\" class=\"\">\r\n<p data-start=\"985\" data-end=\"1218\" class=\"\"><strong data-start=\"985\" data-end=\"1011\">Clubhouse &amp; Dining 🍽️</strong><br data-start=\"1011\" data-end=\"1014\">\r\nEnjoy <strong data-start=\"1022\" data-end=\"1066\">delicious local and international dishes</strong> at the clubhouse while overlooking the scenic course. The restaurant serves a <strong data-start=\"1145\" data-end=\"1190\">variety of refreshments and gourmet meals</strong> for golfers and visitors.</p>\r\n</li>\r\n<li data-start=\"1220\" data-end=\"1413\" class=\"\">\r\n<p data-start=\"1222\" data-end=\"1413\" class=\"\"><strong data-start=\"1222\" data-end=\"1258\">Driving Range &amp; Golf Lessons 🏌️</strong><br data-start=\"1258\" data-end=\"1261\">\r\nWhether you\'re a <strong data-start=\"1280\" data-end=\"1324\">beginner or looking to refine your swing</strong>, Brittannika offers <strong data-start=\"1345\" data-end=\"1410\">professional golf lessons and a well-maintained driving range</strong>.</p>\r\n</li>\r\n<li data-start=\"1415\" data-end=\"1594\" class=\"\">\r\n<p data-start=\"1417\" data-end=\"1594\" class=\"\"><strong data-start=\"1417\" data-end=\"1448\">Event &amp; Tournament Venue 🎉</strong><br data-start=\"1448\" data-end=\"1451\">\r\nThe golf course is a prime location for <strong data-start=\"1493\" data-end=\"1558\">corporate events, private tournaments, and special gatherings</strong>, offering full-service amenities.</p>\r\n</li>\r\n</ul><h3 data-start=\"1596\" data-end=\"1634\" class=\"\">📍 <strong data-start=\"1603\" data-end=\"1632\">Location &amp; Accessibility:</strong></h3><ul data-start=\"1635\" data-end=\"1982\">\r\n<li data-start=\"1635\" data-end=\"1716\" class=\"\">\r\n<p data-start=\"1637\" data-end=\"1716\" class=\"\"><strong data-start=\"1637\" data-end=\"1649\">Address:</strong> Purok Pag-asa, Barangay Linan, Tupi, South Cotabato, Philippines</p>\r\n</li>\r\n<li data-start=\"1717\" data-end=\"1982\" class=\"\">\r\n<p data-start=\"1719\" data-end=\"1742\" class=\"\"><strong data-start=\"1719\" data-end=\"1740\">How to Get There:</strong></p>\r\n<ul data-start=\"1745\" data-end=\"1982\">\r\n<li data-start=\"1745\" data-end=\"1820\" class=\"\">\r\n<p data-start=\"1747\" data-end=\"1820\" class=\"\"><strong data-start=\"1747\" data-end=\"1771\">From Koronadal City:</strong> ~40-minute drive via <strong data-start=\"1793\" data-end=\"1818\">Tupi National Highway</strong></p>\r\n</li>\r\n<li data-start=\"1823\" data-end=\"1898\" class=\"\">\r\n<p data-start=\"1825\" data-end=\"1898\" class=\"\"><strong data-start=\"1825\" data-end=\"1854\">From General Santos City:</strong> ~50-minute drive via <strong data-start=\"1876\" data-end=\"1896\">Digos-Makar Road</strong></p>\r\n</li>\r\n<li data-start=\"1901\" data-end=\"1982\" class=\"\">\r\n<p data-start=\"1903\" data-end=\"1982\" class=\"\">Accessible by <strong data-start=\"1917\" data-end=\"1980\">private vehicle, taxis, or motorbike services (habal-habal)</strong></p>\r\n</li>\r\n</ul>\r\n</li>\r\n</ul><h3 data-start=\"1984\" data-end=\"2012\" class=\"\">⏰ <strong data-start=\"1990\" data-end=\"2010\">Operating Hours:</strong></h3><ul data-start=\"2013\" data-end=\"2055\">\r\n<li data-start=\"2013\" data-end=\"2055\" class=\"\">\r\n<p data-start=\"2015\" data-end=\"2055\" class=\"\"><strong data-start=\"2015\" data-end=\"2035\">Monday – Sunday:</strong> 6:00 AM – 6:00 PM</p>\r\n</li>\r\n</ul><h3 data-start=\"2057\" data-end=\"2084\" class=\"\">🎟️ <strong data-start=\"2065\" data-end=\"2082\">Rates &amp; Fees:</strong></h3><ul data-start=\"2085\" data-end=\"2258\">\r\n<li data-start=\"2085\" data-end=\"2160\" class=\"\">\r\n<p data-start=\"2087\" data-end=\"2160\" class=\"\"><strong data-start=\"2087\" data-end=\"2102\">Green Fees:</strong> Vary based on weekdays, weekends, and membership status</p>\r\n</li>\r\n<li data-start=\"2161\" data-end=\"2208\" class=\"\">\r\n<p data-start=\"2163\" data-end=\"2208\" class=\"\"><strong data-start=\"2163\" data-end=\"2206\">Golf Cart &amp; Equipment Rentals Available</strong></p>\r\n</li>\r\n<li data-start=\"2209\" data-end=\"2258\" class=\"\">\r\n<p data-start=\"2211\" data-end=\"2258\" class=\"\"><strong data-start=\"2211\" data-end=\"2256\">Special Rates for Group Packages &amp; Events</strong></p>\r\n</li>\r\n</ul><h3 data-start=\"2260\" data-end=\"2293\" class=\"\">📞 <strong data-start=\"2267\" data-end=\"2291\">Contact Information:</strong></h3><ul data-start=\"2294\" data-end=\"2461\">\r\n<li data-start=\"2294\" data-end=\"2365\" class=\"\">\r\n<p data-start=\"2296\" data-end=\"2365\" class=\"\"><strong data-start=\"2296\" data-end=\"2306\">Phone:</strong> +63 998 456 7890 (For tee time reservations &amp; inquiries)</p>\r\n</li>\r\n<li data-start=\"2366\" data-end=\"2461\" class=\"\">\r\n<p data-start=\"2368\" data-end=\"2461\" class=\"\"><strong data-start=\"2368\" data-end=\"2381\">Facebook:</strong> <a data-start=\"2382\" data-end=\"2459\" rel=\"noopener\" target=\"_new\" class=\"\" href=\"https://www.facebook.com/brittannikagolf/\">Brittannika Golf Course Official</a></p>\r\n</li>\r\n</ul><p>🌿 Whether you\'re looking to <strong data-start=\"2492\" data-end=\"2582\">sharpen your golfing skills, enjoy a relaxing day outdoors, or host an exclusive event</strong>, Brittannika Golf Course offers an <strong data-start=\"2618\" data-end=\"2658\">elegant and unforgettable experience</strong> in the heart of <strong data-start=\"2675\" data-end=\"2710\">South Cotabato’s natural beauty</strong>. 🏌️‍♀️✨</p>', 'uploads/package_11', 1, '2025-04-01 16:33:21', '6:00 AM - 6:00 PM', NULL),
(12, 'Magsangyaw Land of Praise', '6.394910, 125.035914\r\nMiasong, Tupi, South Cotabato', 'Paid entry', '<p data-start=\"169\" data-end=\"535\" class=\"\"><strong data-start=\"169\" data-end=\"198\">Magsangyaw Land of Praise</strong> is a <strong data-start=\"204\" data-end=\"232\">serene spiritual retreat</strong> located in the cool highlands of <strong data-start=\"266\" data-end=\"299\">Miasong, Tupi, South Cotabato</strong>. Nestled at an <strong data-start=\"315\" data-end=\"385\">elevation with breathtaking views of Mt. Matutum and lush greenery</strong>, this peaceful sanctuary is a popular destination for <strong data-start=\"440\" data-end=\"486\">pilgrims, prayer groups, and nature lovers</strong> seeking <strong data-start=\"495\" data-end=\"532\">tranquility and spiritual renewal</strong>.</p><h3 data-start=\"537\" data-end=\"564\" class=\"\">✨ <strong data-start=\"543\" data-end=\"562\">Key Highlights:</strong></h3><ul data-start=\"566\" data-end=\"1581\">\r\n<li data-start=\"566\" data-end=\"770\" class=\"\">\r\n<p data-start=\"568\" data-end=\"770\" class=\"\"><strong data-start=\"568\" data-end=\"607\">Scenic Prayer &amp; Meditation Spots 🌿</strong><br data-start=\"607\" data-end=\"610\">\r\nThe area features <strong data-start=\"630\" data-end=\"694\">picturesque landscapes, prayer gardens, and open-air chapels</strong>, providing visitors with a <strong data-start=\"722\" data-end=\"767\">peaceful place for reflection and worship</strong>.</p>\r\n</li>\r\n<li data-start=\"772\" data-end=\"980\" class=\"\">\r\n<p data-start=\"774\" data-end=\"980\" class=\"\"><strong data-start=\"774\" data-end=\"817\">Giant Cross &amp; Biblical Installations ✝️</strong><br data-start=\"817\" data-end=\"820\">\r\nThe site is adorned with <strong data-start=\"847\" data-end=\"925\">religious symbols, a towering cross, and various Bible-inspired sculptures</strong>, perfect for <strong data-start=\"939\" data-end=\"977\">pilgrimages and spiritual journeys</strong>.</p>\r\n</li>\r\n<li data-start=\"982\" data-end=\"1223\" class=\"\">\r\n<p data-start=\"984\" data-end=\"1223\" class=\"\"><strong data-start=\"984\" data-end=\"1025\">Breathtaking Views of Mt. Matutum 🏔️</strong><br data-start=\"1025\" data-end=\"1028\">\r\nPositioned on the slopes of <strong data-start=\"1058\" data-end=\"1073\">Mt. Matutum</strong>, the location offers <strong data-start=\"1095\" data-end=\"1165\">panoramic views of the mountains, rolling hills, and vast farmland</strong>, creating a perfect backdrop for prayer and meditation.</p>\r\n</li>\r\n<li data-start=\"1225\" data-end=\"1408\" class=\"\">\r\n<p data-start=\"1227\" data-end=\"1408\" class=\"\"><strong data-start=\"1227\" data-end=\"1273\">Ideal for Retreats &amp; Worship Gatherings 🙏</strong><br data-start=\"1273\" data-end=\"1276\">\r\nMagsangyaw Land of Praise hosts <strong data-start=\"1310\" data-end=\"1356\">retreats, Bible studies, and church events</strong>, providing a <strong data-start=\"1370\" data-end=\"1405\">spiritual escape from city life</strong>.</p>\r\n</li>\r\n<li data-start=\"1410\" data-end=\"1581\" class=\"\">\r\n<p data-start=\"1412\" data-end=\"1581\" class=\"\"><strong data-start=\"1412\" data-end=\"1440\">Hiking &amp; Nature Walks 🚶</strong><br data-start=\"1440\" data-end=\"1443\">\r\nVisitors can <strong data-start=\"1458\" data-end=\"1492\">explore the surrounding trails</strong>, breathe in the <strong data-start=\"1509\" data-end=\"1531\">fresh mountain air</strong>, and immerse themselves in <strong data-start=\"1559\" data-end=\"1578\">nature’s beauty</strong>.</p>\r\n</li>\r\n</ul><h3 data-start=\"1583\" data-end=\"1621\" class=\"\">📍 <strong data-start=\"1590\" data-end=\"1619\">Location &amp; Accessibility:</strong></h3><ul data-start=\"1622\" data-end=\"1987\">\r\n<li data-start=\"1622\" data-end=\"1668\" class=\"\">\r\n<p data-start=\"1624\" data-end=\"1668\" class=\"\"><strong data-start=\"1624\" data-end=\"1636\">Address:</strong> Miasong, Tupi, South Cotabato</p>\r\n</li>\r\n<li data-start=\"1669\" data-end=\"1714\" class=\"\">\r\n<p data-start=\"1671\" data-end=\"1714\" class=\"\"><strong data-start=\"1671\" data-end=\"1687\">Coordinates:</strong> <strong data-start=\"1688\" data-end=\"1712\">6.394814, 125.035</strong></p>\r\n</li>\r\n<li data-start=\"1715\" data-end=\"1987\" class=\"\">\r\n<p data-start=\"1717\" data-end=\"1740\" class=\"\"><strong data-start=\"1717\" data-end=\"1738\">How to Get There:</strong></p>\r\n<ul data-start=\"1743\" data-end=\"1987\">\r\n<li data-start=\"1743\" data-end=\"1811\" class=\"\">\r\n<p data-start=\"1745\" data-end=\"1811\" class=\"\"><strong data-start=\"1745\" data-end=\"1771\">From Tupi Town Proper:</strong> ~20-minute drive via <strong data-start=\"1793\" data-end=\"1809\">Miasong Road</strong></p>\r\n</li>\r\n<li data-start=\"1814\" data-end=\"1889\" class=\"\">\r\n<p data-start=\"1816\" data-end=\"1889\" class=\"\"><strong data-start=\"1816\" data-end=\"1840\">From Koronadal City:</strong> ~40-minute drive via <strong data-start=\"1862\" data-end=\"1887\">Tupi National Highway</strong></p>\r\n</li>\r\n<li data-start=\"1892\" data-end=\"1987\" class=\"\">\r\n<p data-start=\"1894\" data-end=\"1987\" class=\"\">Accessible via <strong data-start=\"1909\" data-end=\"1985\">private vehicles, motorbikes (habal-habal), and local transport services</strong></p>\r\n</li>\r\n</ul>\r\n</li>\r\n</ul><h3 data-start=\"1989\" data-end=\"2017\" class=\"\">⏰ <strong data-start=\"1995\" data-end=\"2015\">Operating Hours:</strong></h3><ul data-start=\"2018\" data-end=\"2069\">\r\n<li data-start=\"2018\" data-end=\"2069\" class=\"\">\r\n<p data-start=\"2020\" data-end=\"2069\" class=\"\"><strong data-start=\"2020\" data-end=\"2067\">Typically open daily from 6:00 AM – 6:00 PM</strong></p>\r\n</li>\r\n</ul><h3 data-start=\"2071\" data-end=\"2098\" class=\"\">🎟️ <strong data-start=\"2079\" data-end=\"2096\">Entrance Fee:</strong></h3><ul data-start=\"2099\" data-end=\"2179\">\r\n<li data-start=\"2099\" data-end=\"2179\" class=\"\">\r\n<p data-start=\"2101\" data-end=\"2179\" class=\"\"><strong data-start=\"2101\" data-end=\"2118\">Free entrance</strong> (Donations for maintenance and development are encouraged)</p>\r\n</li>\r\n</ul><h3 data-start=\"2181\" data-end=\"2214\" class=\"\">📞 <strong data-start=\"2188\" data-end=\"2212\">Contact Information:</strong></h3><ul data-start=\"2215\" data-end=\"2262\">\r\n<li data-start=\"2215\" data-end=\"2262\" class=\"\">\r\n<p data-start=\"2217\" data-end=\"2262\" class=\"\"><strong data-start=\"2217\" data-end=\"2260\">Local Church or Management Office (TBA)</strong></p>\r\n</li>\r\n</ul><p>🌿 Whether you\'re looking for a <strong data-start=\"2296\" data-end=\"2355\">place to pray, reflect, or simply enjoy nature’s beauty</strong>, Magsangyaw Land of Praise is a <strong data-start=\"2388\" data-end=\"2426\">peaceful and uplifting destination</strong> in <strong data-start=\"2430\" data-end=\"2454\">Tupi, South Cotabato</strong>. 🙌✨</p>', 'uploads/package_12', 1, '2025-04-01 18:02:29', '6:00 AM - 6:00 PM', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rate_review`
--

CREATE TABLE `rate_review` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `package_id` int(30) NOT NULL,
  `rate` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rate_review`
--

INSERT INTO `rate_review` (`id`, `user_id`, `package_id`, `rate`, `review`, `date_created`) VALUES
(3, 5, 8, 5, '<p>Sample</p>', '2021-06-19 11:53:16'),
(4, 5, 8, 3, '&lt;p&gt;Sample feedback only&lt;/p&gt;', '2021-06-19 13:49:26'),
(5, 7, 8, 1, '123123', '2025-04-01 10:39:44'),
(6, 7, 1, 5, 'asdfadfasdf', '2025-03-24 18:59:41'),
(7, 7, 7, 3, '1232132', '2025-03-24 14:06:13'),
(8, 7, 9, 5, 'GOOD', '2025-04-01 11:57:31'),
(9, 7, 10, 3, 'wowoow', '2025-04-01 18:12:30'),
(10, 7, 11, 4, 'qwerweqrwer', '2025-04-01 18:17:10'),
(11, 7, 12, 5, '123123', '2025-04-01 18:07:17');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Tupi Spot Information System'),
(6, 'short_name', 'TSIS-PH'),
(11, 'logo', 'uploads/1743502200_1623978900_masskara.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/tupi2.jpeg'),
(15, 'policy', '                                &lt;h3&gt;&lt;strong&gt;Tupi Local Laws and Regulations&lt;/strong&gt;&lt;/h3&gt;\n&lt;p&gt;Tupi, a vibrant town nestled in the heart of South Cotabato, has laws and regulations in place to ensure the safety, well-being, and harmonious living of its residents and visitors. The local government of Tupi is committed to preserving its natural beauty, agricultural growth, and cultural heritage while maintaining peace and order.&lt;/p&gt;\n&lt;ul&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Environmental Protection&lt;/strong&gt;: The community emphasizes environmental conservation, ensuring that the natural beauty of Tupi, from its fertile soils to its rich flora, is preserved for future generations. Visitors should respect local flora and fauna, including the abundant flowers and fruits grown in the area, and avoid littering in natural spaces.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Agricultural Regulations&lt;/strong&gt;: As Tupi is a major agricultural hub, visitors are encouraged to respect farming lands. Activities like hiking and exploring should be done with care to avoid damaging crops or property. Local farms also regulate the use of pesticides and fertilizers to maintain the health of the land.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Respect for Indigenous Cultures&lt;/strong&gt;: Tupi is home to indigenous groups, including the Blaan tribe, whose cultural practices should be respected. Visitors should refrain from engaging in activities that disrespect or harm the local communities&#039; traditions.&lt;/p&gt;\n&lt;/li&gt;\n&lt;/ul&gt;\n&lt;h3&gt;&lt;strong&gt;Emergency Contacts in Tupi&lt;/strong&gt;&lt;/h3&gt;\n&lt;p&gt;In case of any emergency, it is essential to have the right contacts available to ensure swift assistance:&lt;/p&gt;\n&lt;ul&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Police&lt;/strong&gt;: 911&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Medical Emergency&lt;/strong&gt;: 112&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Fire Department&lt;/strong&gt;: 911&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Local Government Office&lt;/strong&gt;: (083) 226-2800&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Barangay Poblacion&lt;/strong&gt;: For local concerns and immediate assistance, you can contact the nearest barangay office.&lt;/p&gt;\n&lt;/li&gt;\n&lt;/ul&gt;\n&lt;h3&gt;&lt;strong&gt;Dos and Don&rsquo;ts in Tupi&lt;/strong&gt;&lt;/h3&gt;\n&lt;p&gt;When visiting Tupi, it&#039;s essential to adhere to the following dos and don&#039;ts to maintain a respectful and safe experience:&lt;/p&gt;\n&lt;h4&gt;&lt;strong&gt;Dos&lt;/strong&gt;:&lt;/h4&gt;\n&lt;ul&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Respect Local Customs&lt;/strong&gt;: Follow local customs and practices, especially when interacting with indigenous communities like the Blaan tribe.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Support Local Farmers&lt;/strong&gt;: If visiting farms, be sure to support local businesses by purchasing their fresh produce or products.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Observe Environmental Etiquette&lt;/strong&gt;: Dispose of trash responsibly and refrain from disturbing the natural environment, including plants and wildlife.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Use Local Services&lt;/strong&gt;: Engage with local businesses, eateries, and guides to promote sustainable tourism and support the local economy.&lt;/p&gt;\n&lt;/li&gt;\n&lt;/ul&gt;\n&lt;h4&gt;&lt;strong&gt;Don&rsquo;ts&lt;/strong&gt;:&lt;/h4&gt;\n&lt;ul&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Don&rsquo;t Litter&lt;/strong&gt;: Keep Tupi clean by disposing of waste properly, particularly in agricultural and natural areas.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Don&rsquo;t Disturb Wildlife&lt;/strong&gt;: Avoid disturbing or harming animals, especially in protected areas like the Linan Tarsier Sanctuary.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Don&rsquo;t Engage in Illegal Activities&lt;/strong&gt;: Abide by local laws, including regulations about farming, fishing, and hunting in protected areas.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Don&rsquo;t Ignore Local Guidelines&lt;/strong&gt;: Always follow safety guidelines provided by local authorities, especially when hiking or participating in adventure activities.&lt;/p&gt;\n&lt;/li&gt;\n&lt;/ul&gt;\n&lt;h3&gt;&lt;strong&gt;Safety Tips for Tourists in Tupi&lt;/strong&gt;&lt;/h3&gt;\n&lt;p&gt;To ensure a safe and enjoyable visit, follow these essential safety tips:&lt;/p&gt;\n&lt;ul&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Stay Aware of Your Surroundings&lt;/strong&gt;: Tupi is generally a safe destination, but it&#039;s always best to stay alert, especially when exploring remote areas.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Secure Personal Belongings&lt;/strong&gt;: Keep personal items like wallets, phones, and cameras secure, especially in crowded or tourist-heavy areas.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Follow Local Guidance&lt;/strong&gt;: Always listen to local authorities or tour guides, especially in areas where there may be hazards or unfamiliar terrain, such as hiking Mount Matutum.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Be Prepared for the Weather&lt;/strong&gt;: Tupi&rsquo;s cool climate is a major attraction, but visitors should bring appropriate clothing for varying weather conditions, including rain gear during the wet season.&lt;/p&gt;\n&lt;/li&gt;\n&lt;li&gt;\n&lt;p&gt;&lt;strong&gt;Know Your Route&lt;/strong&gt;: When traveling to remote attractions like the Linan Tarsier Sanctuary or Kablon Farms, make sure you have reliable transportation or a guide.&lt;/p&gt;\n&lt;/li&gt;\n&lt;/ul&gt;\n&lt;p&gt;By following these local laws, safety tips, and respecting Tupi&rsquo;s rich heritage, you can enjoy an unforgettable experience in this beautiful municipality of South Cotabato.&lt;/p&gt;                ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/1620201300_avatar.png', NULL, 1, '2021-01-20 14:02:37', '2021-06-18 16:47:05'),
(4, 'John', 'Smith', 'jsmith', '1254737c076cf867dc53d60a0364f38e', NULL, NULL, 0, '2021-06-19 08:36:09', '2021-06-19 10:53:12'),
(5, 'Claire', 'Blake', 'cblake', '4744ddea876b11dcb1d169fadf494418', NULL, NULL, 0, '2021-06-19 10:01:51', '2021-06-19 12:03:23'),
(6, 'rey', 'nedruda', 'nedruda101', 'd2b3ea2dfddc40efdc6941359436c847', NULL, NULL, 0, '2025-03-17 13:02:17', NULL),
(7, 'rey', 'rey', 'rey', 'd2b3ea2dfddc40efdc6941359436c847', NULL, NULL, 0, '2025-03-24 10:03:25', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book_list`
--
ALTER TABLE `book_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiry`
--
ALTER TABLE `inquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rate_review`
--
ALTER TABLE `rate_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book_list`
--
ALTER TABLE `book_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `inquiry`
--
ALTER TABLE `inquiry`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rate_review`
--
ALTER TABLE `rate_review`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
