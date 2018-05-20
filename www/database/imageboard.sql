-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-01-2016 a las 20:37:24
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `imageboard`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `th_adverts`
--

CREATE TABLE IF NOT EXISTS `th_adverts` (
  `id` int(16) NOT NULL,
  `title` text NOT NULL,
  `code` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `th_adverts`
--

INSERT INTO `th_adverts` (`id`, `title`, `code`, `type`) VALUES
(1, 'Example', '<div><h3> EXAMPLE ADVERT </h3></div>\n', 'center');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `th_category`
--

CREATE TABLE IF NOT EXISTS `th_category` (
  `id` int(16) NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `extsupport` varchar(256) NOT NULL,
  `ignore` int(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `th_category`
--

INSERT INTO `th_category` (`id`, `name`, `link`, `extsupport`, `ignore`) VALUES
(1, 'Example', 'e', '.jpg,.png,.gif', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `th_comments`
--

CREATE TABLE IF NOT EXISTS `th_comments` (
  `id` int(16) NOT NULL,
  `author` text NOT NULL,
  `auth_addr` varchar(256) NOT NULL,
  `postid` int(16) NOT NULL,
  `message` text NOT NULL,
  `folderid` text NOT NULL,
  `create_date` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `thumb` text NOT NULL,
  `title` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `th_comments`
--

INSERT INTO `th_comments` (`id`, `author`, `auth_addr`, `postid`, `message`, `folderid`, `create_date`, `content`, `thumb`, `title`) VALUES
(1, '', '::1', 1, 'comment testing', '9b9090dda3b1ec473079f9e0bf73188a', '2016-01-11T20:32:42+01:00', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `th_groups`
--

CREATE TABLE IF NOT EXISTS `th_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `permissions` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `th_groups`
--

INSERT INTO `th_groups` (`id`, `name`, `permissions`) VALUES
(1, 'Registers Users', ''),
(2, 'Administrator', '{"admin": 1 }');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `th_page`
--

CREATE TABLE IF NOT EXISTS `th_page` (
  `id` int(16) NOT NULL,
  `title` varchar(256) NOT NULL,
  `subtitle` varchar(256) NOT NULL,
  `description` varchar(256) NOT NULL,
  `tags` varchar(256) NOT NULL,
  `theme` varchar(256) NOT NULL,
  `language` text NOT NULL,
  `logo` varchar(256) NOT NULL,
  `favicon` varchar(256) NOT NULL,
  `ffmpeg` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `th_page`
--

INSERT INTO `th_page` (`id`, `title`, `subtitle`, `description`, `tags`, `theme`, `language`, `logo`, `favicon`, `ffmpeg`) VALUES
(1, 'ImageBoard', '', 'Entertainment', 'images, webm, imageboard', 'default', 'en', 'http://localhost\\public\\default/images\\logo.png', 'http://localhost\\public\\default/images\\favicon.ico', 'C:\\xampp\\ffmpeg\\bin\\ffmpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `th_posts`
--

CREATE TABLE IF NOT EXISTS `th_posts` (
  `id` int(16) NOT NULL,
  `title` text NOT NULL,
  `author` text NOT NULL,
  `auth_addr` varchar(256) NOT NULL,
  `message` text NOT NULL,
  `create_date` varchar(255) NOT NULL,
  `folderid` text NOT NULL,
  `content` text NOT NULL,
  `thumb` text NOT NULL,
  `categoryid` int(16) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `th_posts`
--

INSERT INTO `th_posts` (`id`, `title`, `author`, `auth_addr`, `message`, `create_date`, `folderid`, `content`, `thumb`, `categoryid`) VALUES
(1, '', '', '::1', 'testing thread', '2016-01-11T20:21:39+01:00', '9b9090dda3b1ec473079f9e0bf73188a', '2ed4e243c27b307f74608e6a1102b02b.png', '2ed4e243c27b307f74608e6a1102b02b_thumb.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `th_report`
--

CREATE TABLE IF NOT EXISTS `th_report` (
  `id` int(16) NOT NULL,
  `author_addr` varchar(256) NOT NULL,
  `postid` text NOT NULL,
  `comid` text NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `th_report`
--

INSERT INTO `th_report` (`id`, `author_addr`, `postid`, `comid`, `message`) VALUES
(1, '127.0.0.1', '1', '0', 'example report');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `th_users`
--

CREATE TABLE IF NOT EXISTS `th_users` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL,
  `salt` varchar(32) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `th_users`
--

INSERT INTO `th_users` (`id`, `username`, `password`, `name`, `lastname`, `email`, `joined`, `group`, `salt`) VALUES
(1, 'admin', '5c6e7ec34096df67949a2f2844cc0f66d5792313d4c5d69c85010b0f2a922872', '', '', 'admin@website.com', '2014-08-04 06:20:27', 2, 'LFhk9okEof5TreKiM7LUoWYGdJs9UUJg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `th_users_session`
--

CREATE TABLE IF NOT EXISTS `th_users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `th_adverts`
--
ALTER TABLE `th_adverts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `th_category`
--
ALTER TABLE `th_category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `th_comments`
--
ALTER TABLE `th_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `th_groups`
--
ALTER TABLE `th_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `th_page`
--
ALTER TABLE `th_page`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `th_posts`
--
ALTER TABLE `th_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `th_report`
--
ALTER TABLE `th_report`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `th_users`
--
ALTER TABLE `th_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `th_users_session`
--
ALTER TABLE `th_users_session`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `th_adverts`
--
ALTER TABLE `th_adverts`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `th_category`
--
ALTER TABLE `th_category`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `th_comments`
--
ALTER TABLE `th_comments`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `th_groups`
--
ALTER TABLE `th_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `th_page`
--
ALTER TABLE `th_page`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `th_posts`
--
ALTER TABLE `th_posts`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `th_report`
--
ALTER TABLE `th_report`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `th_users`
--
ALTER TABLE `th_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `th_users_session`
--
ALTER TABLE `th_users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
