-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 09, 2025 at 10:29 AM
-- Server version: 5.6.51
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `landk`
--
use `landk`;
-- --------------------------------------------------------

--
-- Table structure for table `about`
--
DROP TABLE IF EXISTS `about`;
CREATE TABLE `about` (
  `id` bigint(20) NOT NULL,
  `img` longtext,
  `title` longtext NOT NULL,
  `content` longtext NOT NULL,
  `author` longtext NOT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `guess`
--
DROP TABLE IF EXISTS `guess`;
CREATE TABLE `guess` (
  `id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `ranswer` longtext NOT NULL,
  `answers` longtext NOT NULL,
  `time` datetime NOT NULL,
  `shows` int(11) NOT NULL,
  `answert` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `title` varchar(600) CHARACTER SET utf8mb4 NOT NULL,
  `time` datetime NOT NULL,
  `imageUrl` varchar(600) CHARACTER SET utf8mb4 NOT NULL,
  `show` tinyint(1) NOT NULL DEFAULT '0',
  `content` varchar(1000) CHARACTER SET utf8mb4 NOT NULL,
  `date` datetime NOT NULL COMMENT '添加这条记录的时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--
DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `usr` varchar(999) NOT NULL,
  `pwd` varchar(2000) NOT NULL,
  `sort` char(2) NOT NULL DEFAULT '用户',
  `time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `usr`, `pwd`, `sort`, `time`) VALUES
(1,'admin','e10adc3949ba59abbe56e057f20f883e','管理','2023-02-01 17:02:41');
-- --------------------------------------------------------

--
-- Table structure for table `paper`
--
DROP TABLE IF EXISTS `paper`;
CREATE TABLE `paper` (
  `id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `pwd` bigint(255) NOT NULL,
  `date` datetime NOT NULL,
  `look` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `personal`
--
DROP TABLE IF EXISTS `personal`;
CREATE TABLE `personal` (
  `uid` int(11) NOT NULL,
  `nickname` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `sex` varchar(1) CHARACTER SET utf8mb4 NOT NULL DEFAULT '无',
  `age` int(11) NOT NULL,
  `birth` date NOT NULL,
  `birthday` varchar(20) NOT NULL,
  `horo` varchar(5) CHARACTER SET utf8mb4 DEFAULT NULL,
  `description` varchar(64) CHARACTER SET utf8mb4 NOT NULL DEFAULT '介个人hen懒喔，什么都没写',
  `headsolt` varchar(500) DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `point` int(11) NOT NULL DEFAULT '0',
  `see` int(100) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `personal`
--

INSERT INTO `personal` (`uid`, `nickname`, `sex`, `age`, `birth`, `birthday`, `horo`, `description`, `headsolt`, `level`, `point`, `see`) VALUES
(1,'2kailsy','无', 18, '2008-12-29', '12-29', '摩羯座', '介个人hen懒喔，什么都没写', '/static/img/uploads/user/k.png', 1, 0, 0);
-- --------------------------------------------------------

--
-- Table structure for table `ques`
--
DROP TABLE IF EXISTS `ques`;
CREATE TABLE `ques` (
  `quen` longtext NOT NULL,
  `id` int(11) NOT NULL,
  `quea` longtext,
  `quet` datetime DEFAULT NULL,
  `queaa` mediumtext,
  `queact` int(11) NOT NULL,
  `queso` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sayme`
--
DROP TABLE IF EXISTS `sayme`;
CREATE TABLE `sayme` (
  `id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `says`
--
DROP TABLE IF EXISTS `says`;
CREATE TABLE `says` (
  `id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `saysth`
--
DROP TABLE IF EXISTS `saysth`;
CREATE TABLE `saysth` (
  `id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `k` varchar(200) CHARACTER SET utf8 NOT NULL,
  `v` longtext,
  `hide` int(11) NOT NULL DEFAULT '0',
  `template` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `k`, `v`, `hide`, `template`) VALUES
(0, 'title', 'NZK 💕 LSY', 0, NULL),
(1, 'subTitle', '', 0, NULL),
(2, 'maincol', 'rgba(187,213,221,0.8)', 0, NULL),
(3, 'secocol', 'rgba(184,189,204,0.6)', 0, NULL),
(4, 'lazyImg', '/static/img/lan.gif', 0, NULL),
(5, 'html', '', 0, '[{"value":"<script src=''/static/js/rain.js''></script>","name":"下雨"},{"value":"<canvas id=''snow''></canvas><script src=''/static/js/snow.js''></script>","name":"下雪"},{"value":"<!-- 灯笼1 --> <div class=''deng-box''>     <div class=''deng''>         <div class=''xian''></div>         <div class=''deng-a''>             <div class=''deng-b''>                 <div class=''deng-t''>节</div>             </div>         </div>         <div class=''shui shui-a''>             <div class=''shui-c''></div>             <div class=''shui-b''></div>         </div>     </div> </div> <!-- 灯笼2 --> <div class=''deng-box1''>     <div class=''deng''>         <div class=''xian''></div>         <div class=''deng-a''>             <div class=''deng-b''>                 <div class=''deng-t''>春</div>             </div>         </div>         <div class=''shui shui-a''>             <div class=''shui-c''></div>             <div class=''shui-b''></div>         </div>     </div> </div>","name":"灯笼"}]'),
(6, 'css', '', 0, '[{"value":".ln_search,.ln_box,.ln_btn.radius{border-radius:8px;} .ln_form.radius>.ln_input{border-radius: 8px 8px 0 0;} .ln_form.radius>.ln_btn{border-radius: 0 0 8px 8px;}","name":"圆角"},{"value":"#snow{pointer-events: none;position: fixed;top: 0;left: 0;z-index: 999;}","name":"雪"},{"value":".deng-box {pointer-events: none;                         position: fixed;                         top: -40px;                         right: -20px;                         z-index: 9999;}                     .deng-box1 {                         position: fixed;                         top: -30px;                         right: 10px;                         z-index: 9999;                         pointer-events: none;                     }                     .deng-box1 .deng {                         position: relative;                         width: 120px;                         height: 90px;                         margin: 50px;                         background: #d8000f;                         background: rgba(216, 0, 15, 0.8);                         border-radius: 50% 50%;                         -webkit-transform-origin: 50% -100px;                         -webkit-animation: swing 5s infinite ease-in-out;                         box-shadow: -5px 5px 30px 4px rgba(252, 144, 61, 1);                     }                     .deng {                         position: relative;                         width: 120px;                         height: 90px;                         margin: 50px;                         background: #d8000f;                         background: rgba(216, 0, 15, 0.8);                         border-radius: 50% 50%;                         -webkit-transform-origin: 50% -100px;                         -webkit-animation: swing 3s infinite ease-in-out;                         box-shadow: -5px 5px 50px 4px rgba(250, 108, 0, 1);                     }                     .deng-a {                         width: 100px;                         height: 90px;                         background: #d8000f;                         background: rgba(216, 0, 15, 0.1);                         margin: 12px 8px 8px 10px;                         border-radius: 50% 50%;                         border: 2px solid #dc8f03;                     }                     .deng-b {                         width: 45px;                         height: 90px;                         background: #d8000f;                         background: rgba(216, 0, 15, 0.1);                         margin: -2px 8px 8px 26px;                         border-radius: 50% 50%;                         border: 2px solid #dc8f03;                     }                     .xian {                         position: absolute;                         top: -20px;                         left: 60px;                         width: 2px;                         height: 20px;                         background: #dc8f03;                     }                     .shui-a {                         position: relative;                         width: 5px;                         height: 20px;                         margin: -5px 0 0 59px;                         -webkit-animation: swing 4s infinite ease-in-out;                         -webkit-transform-origin: 50% -45px;                         background: #ffa500;                         border-radius: 0 0 5px 5px;                     }                     .shui-b {                         position: absolute;                         top: 14px;                         left: -2px;                         width: 10px;                         height: 10px;                         background: #dc8f03;                         border-radius: 50%;                     }                     .shui-c {                         position: absolute;                         top: 18px;                         left: -2px;                         width: 10px;                         height: 35px;                         background: #ffa500;                         border-radius: 0 0 0 5px;                     }                     .deng:before {                         position: absolute;                         top: -7px;                         left: 29px;                         height: 12px;                         width: 60px;                         content: '' '';                         display: block;                         z-index: 999;                         border-radius: 5px 5px 0 0;                         border: solid 1px #dc8f03;                         background: #ffa500;                         background: linear-gradient(to right, #dc8f03, #ffa500, #dc8f03, #ffa500, #dc8f03);                     }                     .deng:after {                         position: absolute;                         bottom: -7px;                         left: 10px;                         height: 12px;                         width: 60px;                         content: '' '';                         display: block;                         margin-left: 20px;                         border-radius: 0 0 5px 5px;                         border: solid 1px #dc8f03;                         background: #ffa500;                         background: linear-gradient(to right, #dc8f03, #ffa500, #dc8f03, #ffa500, #dc8f03);                     }                     .deng-t{                         font-family: 华文行楷, Arial, Lucida Grande, Tahoma, sans-serif;                         font-size: 3.2rem;                         color: #dc8f03;                         font-weight: bold;                         line-height: 85px;                         text-align: center;                     }                     .night .deng-t,.night .deng-box,.night .deng-box1{background: transparent !important;}                     @-moz-keyframes swing {                         0%{-moz-transform: rotate(-10deg);}                         50%{-moz-transform: rotate(10deg);}                         100%{-moz-transform: rotate(-10deg);}                     }                     @-webkit-keyframes swing{                         0%{-webkit-transform: rotate(-10deg);}                         50%{-webkit-transform: rotate(10deg);}                         100%{-webkit-transform: rotate(-10deg);}                     }","name":"灯笼"}]'),
(7, 'js', '', 0, '[{"value":"Rain({speed:[2,40],hasBounce:true,wind_direction:340,gravity:0.05,maxNum:80,numLevel:5,drop_chance:0.4,cloud:true});","name":"下雨"},{"value":"makeSnow(document.getElementById(''snow''));","name":"下雪"}]'),
(8, 'mail_admin', 'sxssb123@qq.com', 1, NULL),
(9, 'mail_host', 'smtp.163.com', 1, NULL),
(10, 'mail_username', 'sxssb123@163.com', 1, NULL),
(11, 'mail_password', 'XXXXXXXXXXXXXXXX', 1, NULL),
(12, 'mail_secure', 'ssl', 1, NULL),
(13, 'mail_port', '465', 1, NULL),
(14, 'mail_charset', 'utf8', 1, NULL),
(15, 'mail_fromName', '2k和lsy滴小网站', 1, NULL),
(16, 'establishment', '2025/01/31 21:29:20', 0, NULL),
(17, 'version', '5.2.0', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--
DROP TABLE IF EXISTS `shop`;
CREATE TABLE `shop` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `explanation` varchar(500) DEFAULT '暂无',
  `img` longtext,
  `price` int(11) NOT NULL DEFAULT '1',
  `type` int(11) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品表and购物表';

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`id`, `name`, `explanation`, `img`, `price`, `type`, `time`) VALUES
(1, '见面卡', '一次见面的机会哟', '/static/img/uploads/shops/jianmianka.png', 2, 0, '2023-05-28 01:46:03'),
(2, '原谅卡', '可以让我原谅你呦', '/static/img/uploads/shops/yuanliangka.png', 2, 0, '2023-05-28 01:46:32'),
(3, '愿望卡', '帮你实现一个愿望呦', '/static/img/uploads/shops/yuanwangka.png', 5, 0, '2023-05-28 01:47:09'),
(4, '熬夜卡', '可以熬一次夜呦', '/static/img/uploads/shops/aoyeka.png', 10, 0, '2023-05-28 01:47:21'),
(5, '拒绝卡', '可以拒绝我一次(谨慎使用！！！)', '/static/img/uploads/shops/jujueka.png', 5, 0, '2023-05-28 01:47:40'),
(6, '陪陪卡', '可以让我陪你哟', '/static/img/uploads/shops/peipeika.png', 1, 0, '2023-05-28 01:47:53'),
(7, '惊喜卡', '可以获得一个小小的惊喜呦', '/static/img/uploads/shops/jingxika.png', 10, 0, '2023-05-28 01:48:10'),
(8, '勿扰卡', '可以让我不打扰一段时间', '/static/img/uploads/shops/wuraoka.png', 6, 0, '2023-05-28 01:48:30'),
(9, '分手卡', '凭此卡可以向我提出分手', '/static/img/uploads/shops/fenshouka.png', 2147483647, 0, '2023-05-28 01:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `sign`
--
DROP TABLE IF EXISTS `sign`;
CREATE TABLE `sign` (
  `day` varchar(11) NOT NULL,
  `sign` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `ac` varchar(20) NOT NULL,
  `because` varchar(640) CHARACTER SET utf8mb4 DEFAULT NULL,
  `liu` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guess`
--
ALTER TABLE `guess`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paper`
--
ALTER TABLE `paper`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pwd` (`pwd`);

--
-- Indexes for table `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `nickname` (`nickname`);

--
-- Indexes for table `ques`
--
ALTER TABLE `ques`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sayme`
--
ALTER TABLE `sayme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `says`
--
ALTER TABLE `says`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saysth`
--
ALTER TABLE `saysth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sign`
--
ALTER TABLE `sign`
  ADD PRIMARY KEY (`sign`) USING BTREE,
  ADD UNIQUE KEY `sign` (`sign`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `guess`
--
ALTER TABLE `guess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `paper`
--
ALTER TABLE `paper`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `ques`
--
ALTER TABLE `ques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `sayme`
--
ALTER TABLE `sayme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `says`
--
ALTER TABLE `says`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `saysth`
--
ALTER TABLE `saysth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sign`
--
ALTER TABLE `sign`
  MODIFY `sign` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
