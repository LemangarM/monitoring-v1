-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2015 at 08:20 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `2phpoopcrudlevel3`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created`, `modified`) VALUES
(1, 'Fashion', 'New fashion trends? We surely have those products here!', '2014-06-01 00:35:07', '2014-05-30 17:34:33'),
(2, 'Electronics', 'This covers products like gadgets and electronic accessories.', '2014-06-01 00:35:07', '2014-05-30 17:34:33'),
(3, 'Motors', 'These are products for your motor needs.', '2014-06-01 00:35:07', '2014-05-30 17:34:54');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category_id`, `created`, `modified`) VALUES
(1, 'LG Optimus 4X HD P880 Black', 'Display - True HD-IPS LCD - 720 x 1280 pixels, 4.7 inches. Internal Memory - 16 GB storage (12 GB user available), 1 GB RAM. Camera - 8 MP, 3264x2448 pixels, autofocus, LED flash', '309.00', 2, '2015-08-01 01:12:26', '2015-07-31 17:12:26'),
(2, 'Motorola Google Nexus 6, Midnight Blue 32GB', 'The stunning 6 inch Quad HD display is great for movies, videos, gaming, e-books, and surfing the Web, and the Nexus 6 provides exceptional battery life.', '400.00', 2, '2015-08-02 01:12:26', '2015-08-01 17:12:26'),
(3, 'Samsung Galaxy S4 i9500 16GB', 'Make your life richer, simpler, and more fun. As a real life companion, the new Samsung GALAXY S4 helps bring us closer and captures those fun moments when we are together. Each feature was designed to simplify our daily lives. Furthermore, it cares enough to monitor our health and well being.', '600.00', 2, '2015-08-03 01:12:26', '2015-08-02 17:12:26'),
(6, 'Bench Men''s Bench Spokes Slim T-Shirt', 'Make their heads spin by rollin'' through with swag to spare. Cotton-poly heather blend provides for a soft, comfortable wear. Screen printed Bench graphics on front. Slim fitting for modern appeal. Contrast topstitching along shoulders. Ribbed crew neck. Short sleeves', '14.00', 1, '2015-08-04 01:12:26', '2015-08-03 17:12:26'),
(8, 'Samsung Galaxy Tab 4', 'Ideal for watching HD movies, playing games, browsing the web, or reading, the Samsung Galaxy Tab 4 features a 10.1-inch, 1280x800 resolution screen, so you experience rich graphics, bright colors, and crisp text.', '210.00', 2, '2015-08-05 01:12:26', '2015-08-04 17:12:26'),
(9, 'Spalding Men''s SP6000-101 Digital Display Quartz Black Watch', 'Right from the beginning, it was all about being first, being the bestâ€¦being what others could only dream of becoming. Founded by Boston Red Stockings pitcher A.G. Spalding in 1876, Spalding has become a leader of innovation and quality in the sporting goods industry.', '49.00', 1, '2015-08-06 01:12:26', '2015-08-05 17:12:26'),
(10, 'Sony Smart Watch 3', 'Contextually aware and smart, Android Wear gives you useful information at a glance and responds to your voice, feeding you relevant and specific information as you move.', '194.00', 2, '2015-08-07 01:12:26', '2015-08-06 17:12:26'),
(11, 'Huawei SnapTo', 'Support all GSM 4G LTE Networks ( T-Mobile, AT&T, Straight Talk, NET10, etc.). 75% screen-body ratio and a stylish, leather-texture finish battery cover with a slim design make the phone compac', '179.00', 2, '2015-08-08 01:12:26', '2015-08-07 17:12:26'),
(12, 'Abercrombie Men''s Lake Arnold Blazer', '100% Gabardine wool imported from Italy. Classic collegiate blazer with heritage A&F crest at left chest pocket. Front pockets with fold-over flaps.							', '250.00', 1, '2015-08-09 01:12:26', '2015-08-08 17:12:26'),
(13, 'Xiaxian Womens Casual Summer Canvas Shoes', 'Kindly check the size chart on the left and make sure that you choose the right size to fit to your foot. Thank you! Rubber sole. Manmade sole. Imported material.', '36.00', 1, '2015-08-10 01:12:26', '2015-08-09 17:12:26'),
(25, 'Flash V-Neck Short Sleeve Tee Shirts For Lady', '100% Cotton T-shirt. Custom Women V-Neck T-Shirt. Brand New &High Quality. Flash Women Shirts. Custom Women Shirts.', '25.00', 1, '2015-08-11 01:12:26', '2015-08-10 17:12:26'),
(26, 'Samsung Galaxy S6, Black Sapphire 32GB', 'The Samsung Galaxy S6 embodies the best of form and function â€“ packing incredible performance into a beautifully sleek frame and lightning-fast 64 bit, Octa-core processor.', '199.00', 2, '2015-08-12 01:12:26', '2015-08-11 17:12:26'),
(27, 'Adidas Team Speed Duffel Bag', '100% Polyester. Imported. Matches to Adidas footwear & apparel colors. One interior zip pocket. Three exterior pockets.', '45.00', 1, '2015-08-13 01:12:26', '2015-08-12 17:12:26'),
(28, 'Alpine Swiss Mens Leather Flipout ID Wallet', 'Genuine Leather. Bifold Wallet with a trifold flip out with ID and Card Slots. 12 Card Slots, 3 Additional Card or receipt Pockets, ID Window.', '45.00', 1, '2015-08-14 01:12:26', '2015-08-13 17:12:26'),
(30, 'Don''t Rush Me I Get Paid By The Hour Graphic T-Shirt', 'Front of the shirt features funny saying. 100% Cotton. Adult men size.', '16.75', 1, '2015-08-15 01:12:26', '2015-08-14 17:12:26'),
(31, 'Amanda Uprichard Women''s Morrissey Silk Cross Over Tank Top', 'Sleeveless silk blouse featuring surplice bodice with front keyhole and shirttail hem. Made in USA.', '107.00', 1, '2014-12-13 00:52:54', '2014-12-12 01:52:54'),
(32, 'Panda Small Compact Portable Washing Machine', 'Small Portable washing machine goes anywhere with only 28lbs weight. Easy to operate, and powerful Just fill with water and set timer.', '199.99', 2, '2015-01-08 22:44:15', '2015-01-07 23:44:15'),
(49, 'Sena SMH10D-11 Motorcycle Bluetooth Headset', 'Wireless Bluetooth 3.0 headset and intercom. Multi-pair with up to four other headsets.', '158.00', 3, '2015-05-26 17:56:34', '2015-05-26 09:56:34'),
(50, 'GMax GM54S Modular Street Helmet', 'Optional L.E.D. Brake Light Kit Transmits your bikes brake light wirelessly and activates L.E.D. light on helmet, sold separately', '124.99', 3, '2015-05-26 17:59:53', '2015-05-26 09:59:53');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
