-- MySQL dump 10.13  Distrib 5.6.10, for FreeBSD9.1 (amd64)
--
-- Host: 10.10.10.10    Database: eva_dev
-- ------------------------------------------------------
-- Server version	5.6.10-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `h1` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `commit` tinyint(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `type` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `content`
--

LOCK TABLES `content` WRITE;
/*!40000 ALTER TABLE `content` DISABLE KEYS */;
INSERT INTO `content` VALUES (1,'Правила конкурсу','<h3 style=\"text-align:center\">Короткі правила</h3>\r\n\r\n<p style=\"text-align:center\">&nbsp;</p>\r\n\r\n<h3>Премія &laquo;Мама року&raquo; проводиться у 4 етапи:</h3>\r\n\r\n<p><strong>11 червня - 02 липня 2015 року</strong>&nbsp; &ndash;&nbsp; подання&nbsp; Заявок на участь в Конкурсі;</p>\r\n\r\n<p><strong>06 - 27 липня 2015 року</strong> &ndash; голосування в премії &laquo;Мама року&raquo;; одночасно &ndash; експертне журі обирає кращих мам у своїй категорії</p>\r\n\r\n<p><strong>29 липня 2015 року</strong> &ndash; визначення переможців Конкурсу;</p>\r\n\r\n<p><strong>15 - 16 серпня 2015</strong> &ndash; проведення урочистих заходів з нагородження переможців Конкурсу.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3>Подання заявок</h3>\r\n\r\n<p>Для подання заявки на участь у конкурсі необхідно зареєструватися на сайті. Заявку можуть подати громадяни України віком від 18 років, які постійно проживають на території України.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Заявку не можуть подавати працівники Організатора/Виконавця і будь-яких інших осіб, які беруть участь у підготовці та проведенні Конкурсу, та їх близькі родичі (чоловік/дружина, діти, брати/сестри, батьки).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Після подання історії вона проходить модерацію на відповідність правилам конкурсу. Модерація може тривати до 7 днів. У разі відповідності правилам конкурсу, історія з&#39;являється на сайті.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3>Участь у премії</h3>\r\n\r\n<p>Брати участь у конкурсі &laquo;Мама року&raquo; можуть повнолітні громадянки України, які постійно проживають на території України та мають дитину чи дітей (у тому числі прийомних).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Номінантом не можуть бути працівники Організатора/Виконавця і будь-яких інших осіб, які беруть участь у підготовці та проведенні Конкурсу, та їх близькі родичі (чоловік/дружина, діти, брати/сестри, батьки).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;Учасник може бути номінований тільки в одній із 6 категорій: &laquo;Натхнення&raquo;, &laquo;Велике серце&raquo;, &laquo;Успіх&raquo;, &laquo;Сімейний затишок&raquo;, &laquo;Стиль&raquo;, &laquo;Супербабуся&raquo;.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3>Голосування та визначення переможниць</h3>\r\n\r\n<p>Переможців премії &laquo;Мама року&raquo; будуть обирати дві ради журі: це користувачі сайту та експертне журі.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Користувачі сайту мають право голосувати за обраного учасника, натиснувши кнопку &laquo;Проголосувати&raquo;, розміщену біля&nbsp; відповідної&nbsp; історії. Проголосувати можна лише за одного номінанта в кожній категорії та лише один раз.&nbsp;&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Експертне журі не обирає одного учасника категорії, а ставить оцінку кожній історії по 100-бальній шкалі. Експерти&nbsp; оцінюють номінантів лише в тих номінаціях, які відповідають їх фаховій спеціалізації (тільки основні&nbsp; 5 категорій).&nbsp; За результатами&nbsp; оцінювання&nbsp; журі формується&nbsp; рейтинг&nbsp; номінантів&nbsp; відповідно до загальної кількості балів, яку отримав кожен номінант.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Таким чином обирається 11 переможців:</p>\r\n\r\n<p>&nbsp; &nbsp;- 6 переможців за версією голосування відвідувачами сайту: 5 мам року, кожна у своїй номінації та 1 супербабуся;</p>\r\n\r\n<p>&nbsp; &nbsp;- ще 5 переможців &ndash; мам року &ndash; за версією нашого експертного журі.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>У разі відмови Переможця&nbsp; від&nbsp; участі у проведенні урочистих заходів з нагородження переможців конкурсу, учасник&nbsp; втрачає статус переможця&nbsp; і ним автоматично визнається&nbsp; номінант, який&nbsp; згідно голосування&nbsp; Користувачів або оцінювання членами журі є наступним в порядку черговості.</p>\r\n');
/*!40000 ALTER TABLE `content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq`
--

LOCK TABLES `faq` WRITE;
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
INSERT INTO `faq` VALUES (1,'Коли завершується прийом заявок на участь у конкурсі?','<p>Прийом заявок на участь у премії &laquo;Мама року&raquo; починається 11 червня і завершується 2 липня.</p>\r\n',1),(4,'Як я можу дізнатись, чи прийнята моя історія?','<p>На адресу пошти, яку ви вказали у контактних даних прийде лист зі сповіщенням про те, що ваша заявка прийнята і розглядається.&nbsp;</p>\r\n',1),(2,'Чи може мама приймати участь у премії в кількох категоріях?','<p>Учасник премії може бути номінований тільки в одній категорії.&nbsp;&nbsp;</p>\r\n',1),(3,'Чи можна надсилати історію мами, яка не живе в Україні?','<p>За правилами премії номінантами можуть ставати громадянки України, які постійно проживають на території України.&nbsp;</p>\r\n',1),(5,'Коли моя історія з’явиться на сайті?  ','<p>Перед публікацією історія проходить модерацію на відповідність правилам конкурсу. Модерація може тривати до 7 днів.</p>\r\n',1),(6,'Фотографія до історії не завантажується. В чому може бути причина?','<p>Фото може не завантажитись , якщо файл перевищує максимально дозволений розмір &ndash; 5 Мб.</p>\r\n',1),(7,'Як я можу внести правку в історію, що вже опублікована?','<p>Вносити правки в історію, яку ви вже подали, неможливо.</p>\r\n',1),(8,'Чи можу я надіслати кілька історій?','<p>За умовами конкурсу один учасник може подавати одну заявку в одну з основних номінацій та одну заявку на участь у спеціальній&nbsp;номінації.&nbsp;</p>\r\n',1),(9,'Як довго продовжуватиметься голосування?','<p>Голосування триватиме з 6 по 27 липня 2015 року включно.&nbsp;</p>\r\n',1),(10,'Як я можу проголосувати ще раз, якщо я змінив свою думку?','<p>На жаль, голосувати у премії можна лише один раз у кожній номінації.&nbsp;</p>\r\n',1),(11,'За якими критеріями відбуватиметься голосування? ','<p>Організатори премії не можуть впливати на особистий вибір людини, що голосує. Але ми рекомендуємо робити свій вибір, зважаючи на такі критерії:</p>\r\n\r\n<p>- ступінь відповідності Номінанта обраній номінації;</p>\r\n\r\n<p>- ступінь позитивного впливу Номінанта на життя своїх дітей, інших людей, суспільства;</p>\r\n\r\n<p>- ступінь унікальності та неординарності впливу Номінанта на життя дітей, інших людей, суспільства.</p>\r\n',1);
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `getdata` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedback`
--

LOCK TABLES `feedback` WRITE;
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1432676816),('m150526_214731_user',1432677021);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (1,2,'Yura Glushakov','','');
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seo`
--

DROP TABLE IF EXISTS `seo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seo`
--

LOCK TABLES `seo` WRITE;
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
INSERT INTO `seo` VALUES (1,'Ева - Мама року','Ева - Мама року','');
/*!40000 ALTER TABLE `seo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `story`
--

DROP TABLE IF EXISTS `story`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `story` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nomination` varchar(255) NOT NULL,
  `name_story` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `about` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `type` tinyint(1) NOT NULL,
  `like` tinyint(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `story`
--

LOCK TABLES `story` WRITE;
/*!40000 ALTER TABLE `story` DISABLE KEYS */;
INSERT INTO `story` VALUES (1,2,'Юра','Глушаков','+380 6342 40 480','yuriy@gmail.com','Сімейний затишок','Мамамама','photo2_1433963494.jpg','Мамамамамамаомраомармоарм','','2015-06-10 22:11:34',1,0,2);
/*!40000 ALTER TABLE `story` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `auth_key` varchar(32) DEFAULT NULL,
  `email_confirm_token` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `social_id` varchar(255) DEFAULT NULL,
  `role` tinyint(1) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_user_username` (`username`),
  KEY `idx_user_email` (`email`),
  KEY `idx_user_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,1432679847,1432769848,'developer','-rQPR8Dp-eD0Yn8mxSimDSAkCPC5SF5V',NULL,'$2y$13$p7oASpfTYkqGf4HtVAn0RO03zdHlYHD1kU8oeVO7m7t89hm2X7MFG',NULL,'holly_nix@mail.ru',NULL,2,1),(2,1433930824,1433930824,NULL,'jqUtl-1yIMPpd7MY_aEi2owHkWTA4au0',NULL,'$2y$13$IQe7af7y.E9oULLAxGi.i.8MM9Q3xI3X2v0FNZ92NWOPyxNf36cSe',NULL,'facebook-957351184288146@site.com','facebook-957351184288146',1,1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vote`
--

DROP TABLE IF EXISTS `vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `story_id` int(11) NOT NULL,
  `like` tinyint(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vote`
--

LOCK TABLES `vote` WRITE;
/*!40000 ALTER TABLE `vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `vote` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-10 19:30:57
