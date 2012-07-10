-- phpMyAdmin SQL Dump
-- version 3.4.11
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 07 月 03 日 09:27
-- 服务器版本: 5.5.23
-- PHP 版本: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `d1_blog`
--

-- --------------------------------------------------------

--
-- 表的结构 `blog_category`
--

CREATE TABLE IF NOT EXISTS `blog_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_category_name` varchar(20) NOT NULL,
  `blog_category_description` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `blog_comment`
--

CREATE TABLE IF NOT EXISTS `blog_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` varchar(15) DEFAULT '匿名游客',
  `post_id` int(10) unsigned DEFAULT '0',
  `comment_email` varchar(255) DEFAULT NULL,
  `comment_url` text,
  `comment_content` text NOT NULL,
  `comment_floor` int(10) unsigned NOT NULL DEFAULT '1',
  `comment_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `blog_image`
--

CREATE TABLE IF NOT EXISTS `blog_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `img_description` varchar(255) DEFAULT '',
  `img_url` varchar(255) NOT NULL,
  `img_category_id` int(10) unsigned NOT NULL,
  `img_upload_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `blog_image_category`
--

CREATE TABLE IF NOT EXISTS `blog_image_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_category_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `blog_link`
--

CREATE TABLE IF NOT EXISTS `blog_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_name` varchar(30) NOT NULL,
  `link_url` text NOT NULL,
  `link_description` varchar(255) DEFAULT NULL,
  `link_email` varchar(255) NOT NULL,
  `link_status` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `blog_options`
--

CREATE TABLE IF NOT EXISTS `blog_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meta` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `blog_posts`
--

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL,
  `post_title` varchar(30) NOT NULL,
  `post_content` text NOT NULL,
  `post_category_id` int(10) unsigned DEFAULT '0',
  `post_time` datetime NOT NULL,
  `post_editime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `post_views` int(10) unsigned DEFAULT '0',
  `set_head` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `blog_tag`
--

CREATE TABLE IF NOT EXISTS `blog_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_tag_name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `blog_tag_relationship`
--

CREATE TABLE IF NOT EXISTS `blog_tag_relationship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `blog_usr`
--

CREATE TABLE IF NOT EXISTS `blog_usr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usr_account` varchar(255) NOT NULL,
  `usr_email` varchar(255) DEFAULT NULL,
  `usr_email_pwd` text,
  `usr_email_account` varchar(255) DEFAULT NULL,
  `usr_email_smtp` varchar(255) NOT NULL,
  `usr_email_port` int(10) unsigned DEFAULT '25',
  `is_smtp` tinyint(3) unsigned DEFAULT '0',
  `usr_nickname` varchar(30) NOT NULL,
  `usr_pwd` text NOT NULL,
  `usr_reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
