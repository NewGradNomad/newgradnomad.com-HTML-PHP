SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
--

CREATE DATABASE IF NOT EXISTS `newgradnomad` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `newgradnomad`;
GRANT SELECT, INSERT, DELETE, UPDATE ON newgradnomad.* TO ngn@localhost IDENTIFIED BY 'password';
--
-- Table structure for table `jobListings`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobListings`
--

CREATE TABLE IF NOT EXISTS `jobListings` (
  `listingID` char(10) NOT NULL,
  `companyName` varchar(256) NOT NULL,
  `positionName` varchar(256) NOT NULL,
  `positionType` varchar(256) NOT NULL,
  `primaryTag` varchar(256) NOT NULL,
  `keywords` varchar(512) NOT NULL,
  `24hrSupport` int(128) NOT NULL,
  `pin` int(128) NOT NULL,
  `url` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `jobDescription` varchar(1028) NOT NULL,
  `postedDate` datetime NOT NULL,
  `paymentStatus` int(10) NOT NULL,
  PRIMARY KEY (`listingID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobListings`
--

INSERT INTO `jobListings` (`listingID`, `companyName`, `positionName`, `positionType`, `primaryTag`, `keywords`, `24hrSupport`, `pin`, `url`, `email`, `jobDescription`, `postedDate`, `paymentStatus`) VALUES
('1107946366', 'Sporting Goods Emporium', 'Sheep Watcher', 'Full Time', 'Human Resource', 'Non Technical;Boring;', -1, -1, 'https://www.google.com/search?q=Sporting%20Goods%20Emporium', '-1', 'You will watch our sheep to ensure they don\'t take over the world.', '2023-08-13 01:52:20', 1),
('2449970057', 'NewGradNomad', 'Associate Software Engineer', 'Part Time', 'Software Development', 'Developer;Engineer;Full Stack;', -1, 349, 'mailto:test@test.com', 'test@test.com', 'This is a job description for NewGradNomad.', '2023-08-13 01:35:18', 1)
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
