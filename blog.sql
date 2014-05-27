-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2014 at 09:03 PM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `blog`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id` (`user_id`),
  KEY `comments_post_id` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `text`) VALUES
(1, 2, 2, 'Donec vitae lacus quam. Donec eget lacus auctor, scelerisque arcu at, dignissim ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi felis, ultrices id dui at, volutpat blandit dolor. Aliquam faucibus massa non magna ultrices, sit amet e'),
(2, 1, 2, 'habitasse platea dictumst. Vestibulum porta lobortis tellus tincidunt tincidunt. Vestibulum ante ipsum pri'),
(3, 2, 2, 'consectetur adipiscing elit. Mauris mi felis, ultrices id dui at, volutpat blandit dolor. Aliq'),
(4, 3, 2, 'consectetur adipiscing elit. Mauris mi felis, ultrices id dui at, volutpat blandit dolor. Aliq'),
(5, 4, 3, ' Nunc neque elit, dictum ut egestas vitae, varius non lacus.'),
(6, 2, 3, ' Nunc neque elit, dictum ut egestas vitae, varius non lacus.'),
(7, 1, 3, ' Nunc neque elit, dictum ut egestas vitae, varius non lacus.');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `text`, `created_at`) VALUES
(1, 1, 'This is my first post!', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut nec interdum purus. Pellentesque mollis turpis tortor, id posuere felis pellentesque non. Praesent vestibulum lorem id lorem mollis, in egestas ligula interdum. Quisque posuere, felis eget dignissim ullamcorper, felis velit accumsan nulla, eu ornare tortor est in dui. Vivamus vitae nisi turpis. Nunc ac ipsum varius elit pellentesque porttitor eget eget tortor. Nulla facilisi. Sed ac pharetra purus.\n\nSed pulvinar mauris eu metus rhoncus facilisis. Phasellus imperdiet sollicitudin commodo. Pellentesque feugiat suscipit nulla, non convallis urna ullamcorper in. Quisque at malesuada sem. Fusce laoreet at nisl a venenatis. Praesent lobortis nisl convallis eros bibendum, sed vestibulum eros blandit. Nunc rutrum eget quam nec eleifend. Suspendisse mattis ultricies purus non ullamcorper. Aliquam cursus sollicitudin nisi, id malesuada enim consectetur sit amet.\n\nInterdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ultrices tortor nec diam pulvinar, non iaculis nibh laoreet. Nam interdum luctus mi, ut lobortis justo tempor in. Mauris in risus mollis, bibendum ipsum ut, ultrices est. In hac habitasse platea dictumst. Vestibulum porta lobortis tellus tincidunt tincidunt. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis ullamcorper nibh et tellus elementum, eget scelerisque eros tempus. Nulla facilisi. ', '2014-05-19 13:05:49'),
(2, 1, 'Ut malesuada lorem in nisl vestibulum auctor. Aliquam rhoncus malesuada commodo.', 'Nunc rhoncus, risus vel gravida consectetur, neque urna imperdiet est, eget ultricies ante leo quis odio. Mauris vitae pharetra lorem. Nulla ut laoreet arcu. Nunc placerat nunc ut dolor vulputate, sed dictum nunc dignissim. Nulla porttitor lectus vitae felis dignissim, et aliquam justo venenatis.\n\nInteger convallis congue neque, vitae fringilla erat tempus vel. Mauris id arcu quis tortor ornare consectetur. Donec vitae lacus quam. Donec eget lacus auctor, scelerisque arcu at, dignissim ante. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris mi felis, ultrices id dui at, volutpat blandit dolor. Aliquam faucibus massa non magna ultrices, sit amet egestas arcu hendrerit. Proin quis lectus quis nisl dictum laoreet. Proin non mauris eget mauris mattis placerat ut aliquet tortor. Vestibulum suscipit nibh quis ornare mollis.\n\nSuspendisse vitae mattis odio. Praesent mi diam, mattis ut luctus volutpat, dapibus ac urna. Suspendisse lobortis massa ac ipsum dignissim ultricies.', '2014-05-19 13:06:30'),
(3, 2, 'In nec gravida lacus, ut rhoncus nunc.', 'In nec gravida lacus, ut rhoncus nunc. Fusce varius et nulla ac malesuada. Etiam at velit lobortis, condimentum diam sed, ultricies augue.\n\nMauris suscipit augue et neque eleifend, vitae dictum sapien ullamcorper. Nunc posuere fermentum augue, at vulputate elit aliquam eu. Pellentesque placerat eros a euismod egestas. Vestibulum risus est, laoreet a facilisis eget, vestibulum vitae velit. Praesent et mauris elit. Aenean in accumsan purus. Nunc magna metus, ullamcorper ut molestie sed, adipiscing vitae dolor.\n\nSuspendisse tristique rhoncus sem vel egestas. Vivamus vel purus lacus. Nullam enim arcu, gravida ac tincidunt sed, tempor sit amet nibh.', '2014-05-19 13:08:41'),
(4, 3, ' Nunc neque elit, dictum ut egestas vitae, varius non lacus.', ' Nunc neque elit, dictum ut egestas vitae, varius non lacus.\n\nCurabitur id congue ipsum, ac ultrices risus. Vivamus commodo nisl erat, quis auctor sapien sollicitudin et. Curabitur iaculis, arcu laoreet aliquet pellentesque, arcu sapien tristique felis, eget dictum urna lacus sed nunc. Sed rhoncus lacus a tortor varius accumsan. Sed laoreet, ante a pulvinar placerat, elit odio aliquet turpis, nec faucibus velit lorem in tellus. Quisque laoreet tortor nisi, dapibus scelerisque tortor aliquet vel. Nam tincidunt interdum hendrerit. Mauris nec mattis urna, sed fringilla neque. Nulla purus risus, pretium et augue eu, auctor tincidunt leo. Sed ligula neque, ultricies sit amet enim molestie, ultrices suscipit nunc. Mauris rhoncus id mi id blandit.\n\nFusce ut sem tristique, commodo metus at, placerat mi. Curabitur ut tempor elit. Aliquam non tincidunt arcu, et consectetur metus. Duis vitae tempus lectus. Donec dictum tempor velit, a elementum ligula fringilla nec. Aenean eu tristique ligula. Integer varius dolor blandit auctor sodales. ', '2014-05-19 13:10:14');

-- --------------------------------------------------------

--
-- Table structure for table `posts_tags`
--

DROP TABLE IF EXISTS `posts_tags`;
CREATE TABLE `posts_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_tags_post_id` (`post_id`),
  KEY `posts_tags_tag_id` (`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `posts_tags`
--

INSERT INTO `posts_tags` (`id`, `post_id`, `tag_id`) VALUES
(19, 1, 1),
(20, 1, 2),
(21, 1, 3),
(22, 2, 1),
(23, 2, 4),
(24, 3, 1),
(25, 3, 2),
(26, 3, 3),
(27, 4, 1),
(28, 4, 2),
(29, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `text`) VALUES
(1, 'Lorem'),
(2, 'ipsum'),
(3, 'dolor'),
(4, 'sit');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `token`) VALUES
(1, 'a@example.org', 'GeorgeClooney', '$2y$11$ZDJ1JDlkJW53XkBkMjFzbewnS.MtLNTnVkqi.SCURfJycIVq6KNli', ''),
(2, 'b@example.org', 'MeganFox', '$2y$11$ZDJ1JDlkJW53XkBkMjFzbe4/gTFtie8R26U18SH8wXkShPQ225jGi', ''),
(3, 'c@example.org', 'EricBana', '$2y$11$ZDJ1JDlkJW53XkBkMjFzbefunLjcIiSVtnJBrD6OKK7v3jgGJyNYu', '$2y$10$yyiPh2/5Vxz.9teBV8PzJuDz083muI0YhaQn45cdWIS35tyUK10W.');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts_tags`
--
ALTER TABLE `posts_tags`
  ADD CONSTRAINT `posts_tags_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_tags_post_id` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
