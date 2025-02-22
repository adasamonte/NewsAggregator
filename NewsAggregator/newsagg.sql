-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2025 at 01:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newsagg`
--

-- --------------------------------------------------------

--
-- Table structure for table `saved_articles`
--

CREATE TABLE `saved_articles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `published_at` datetime NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved_articles`
--

INSERT INTO `saved_articles` (`id`, `user_id`, `title`, `url`, `published_at`, `description`) VALUES
(1, 1, 'Game Developers Are Getting Fed Up With Their Boss\' AI Initiatives', 'https://www.wired.com/story/video-game-industry-artificial-intelligence-developers/', '2025-01-21 17:00:00', 'A survey of video game developers released Tuesday indicates that a growing number of developers fear artificial intelligence will have a negative impact on the industry as a whole.'),
(2, 1, 'Luka deal improves Lakers\' title odds dramatically', 'https://www.espn.com/nba/story/_/id/43665047/lakers-title-odds-improve-dramatically-luka-doncic-trade', '2025-02-02 16:40:14', 'The trade that sent Luka Doncic to the Lakers and Anthony Davis to the Mavericks had swift, drastic implications on the sports betting markets.'),
(3, 3, 'U.S.-Canadian Hockey Match Devolves Into Fights After Trump Tariffs', 'https://www.tmz.com/2025/02/16/united-states-canada-hockey-fight-over-trump-tariffs/', '2025-02-16 12:59:19', 'Canadians are pissed at Americans over President Trump imposing tariffs on our ally to the north — and nowhere is this more evident than in the hockey rink. Three fights broke out in a manner of 9 seconds during Saturday’s USA-Canada 4 Nations…'),
(4, 3, 'The Vision Pro NBA app turns some games into a miniature 3D diorama', 'https://www.theverge.com/news/613796/nba-tabletop-ar-vision-pro-app-league-pass', '2025-02-15 15:32:50', 'The NBA has introduced a new AR feature for its Vision Pro app this week called Tabletop, which places a floating render of a basketball court in your space during “select” live games, according to an NBA help page describing the feature. On the court, digita…'),
(5, 3, 'Elon Musk: agent of chaos', 'https://www.theverge.com/the-vergecast/612923/elon-musk-doge-openai-vergecast', '2025-02-14 14:25:55', 'Itâs hard to think of a time when a single figure has been so central to seemingly everything in the way that Elon Musk is right now. Musk is overseeing and overhauling the federal government, while bending it toward his own financial gain. Heâs also ubiq…'),
(6, 1, 'Today\'s NYT Connections: Sports Edition Hints and Answers for Feb. 19, #149', 'https://www.cnet.com/tech/gaming/todays-nyt-connections-sports-edition-hints-and-answers-for-feb-19-149/', '2025-02-18 21:00:06', 'Here\'s today\'s Connections: Sports Edition answer and hints for groups. These clues will help you solve The New York Times\' popular puzzle game, Connections: Sports Edition, every day.'),
(7, 1, 'Paramount and YouTube TV finalize deal keeping CBS, CBS Sports available', 'https://www.androidcentral.com/streaming-tv/paramount-and-youtube-tv-finalize-deal-keeping-cbs-cbs-sports-available', '2025-02-17 18:47:59', 'YouTube and Paramount were struggling to reach \"a fair deal,\" potentially causing all 30+ Paramount channels to disappear. That crisis was avoided.'),
(8, 1, 'Carbon removal is the next big fossil fuel boom, oil company says', 'https://www.theverge.com/news/616662/carbon-removal-dac-oil-gas-occidental', '2025-02-20 22:33:06', 'Occidental, the oil giant that has tried to fashion itself as a climate tech leader, is being real clear now about capturing carbon dioxide emissions, which it sees as the next big thing for fossil fuel production. That shouldn’t be surprising coming from a p…');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `is_admin` int(1) NOT NULL,
  `username` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `is_admin`, `username`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 0, 'boggart', 'boggart', 'boga', 'boggart@gmail.com', 'boggart'),
(3, 0, 'John Marry', 'John', 'Marston', 'john@gmail.com', 'samonte3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `saved_articles`
--
ALTER TABLE `saved_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `saved_articles`
--
ALTER TABLE `saved_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `saved_articles`
--
ALTER TABLE `saved_articles`
  ADD CONSTRAINT `saved_articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
