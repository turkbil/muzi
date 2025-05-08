-- --------------------------------------------------------------------------------
-- 
-- @version: zumik.sql Mar 10, 2025 15:55 gewa
-- @yazilim tubi:cms
-- @web adresi turkbilisim.com.tr.
-- @copyright 2014
-- 
-- --------------------------------------------------------------------------------
-- Host: localhost
-- Database: zumik
-- Time: Mar 10, 2025-15:55
-- MySQL version: 8.0.30
-- PHP version: 8.4.2
-- --------------------------------------------------------------------------------

#
# Database: `zumik`
#

SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------
# -- Table structure for table `custom_fields`
-- --------------------------------------------------
DROP TABLE IF EXISTS `custom_fields`;
CREATE TABLE `custom_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(100) NOT NULL,
  `tooltip_tr` varchar(100) NOT NULL,
  `name` varchar(55) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `req` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sorting` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `custom_fields`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `email_templates`
-- --------------------------------------------------
DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE `email_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_tr` varchar(200) NOT NULL,
  `subject_tr` varchar(255) NOT NULL,
  `help_tr` text,
  `body_tr` text,
  `type` enum('news','mailer') DEFAULT 'mailer',
  `typeid` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `email_templates`
-- --------------------------------------------------

INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('1', 'Registration Email', 'Please verify your email', 'This template is used to send Registration Verification Email, when Configuration->Registration Verification is set to YES', '&lt;div align=&quot;center&quot;&gt;\n&lt;table cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; width=&quot;600&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Welcome [NAME]! Thanks for registering.&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;Hello,&lt;br /&gt;\n            &lt;br /&gt;\n            You&#039;re now a member of [SITE_NAME].&lt;br /&gt;\n            &lt;br /&gt;\n            Here are your login details. Please keep them in a safe place:&lt;br /&gt;\n            &lt;br /&gt;\n            Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;         &lt;hr /&gt;\n            The administrator of this site has requested all new accounts&lt;br /&gt;\n            to be activated by the users who created them thus your account&lt;br /&gt;\n            is currently inactive. To activate your account,&lt;br /&gt;\n            please visit the link below and enter the following:&lt;hr /&gt;\n            Token: &lt;strong&gt;[TOKEN]&lt;/strong&gt;&lt;br /&gt;\n            Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;         &lt;hr /&gt;\n            &lt;a href=&quot;[LINK]&quot;&gt;Click here to activate your account&lt;/a&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('2', 'Forgot Password Email', 'Password Reset', 'This template is used for retrieving lost user password', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;New password reset from [SITE_NAME]!&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;Hello, &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            &lt;br /&gt;\n            It seems that you or someone requested a new password for you.&lt;br /&gt;\n            We have generated a new password, as requested:&lt;br /&gt;\n            &lt;br /&gt;\n            Your new password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;br /&gt;\n            &lt;br /&gt;\n            To use the new password you need to activate it. To do this click the link provided below and login with your new password.&lt;br /&gt;\n            &lt;a href=&quot;[LINK]&quot;&gt;[LINK]&lt;/a&gt;&lt;br /&gt;\n            &lt;br /&gt;\n            You can change your password after you sign in.&lt;hr /&gt;\n            Password requested from IP: [IP]&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('3', 'Welcome Mail From Admin', 'You have been registered', 'This template is used to send welcome email, when user is added by administrator', '&lt;div align=&quot;center&quot;&gt;\n&lt;table cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; width=&quot;600&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Welcome [NAME]! You have been Registered.&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;Hello,&lt;br /&gt;\n            &lt;br /&gt;\n            You&#039;re now a member of [SITE_NAME].&lt;br /&gt;\n            &lt;br /&gt;\n            Here are your login details. Please keep them in a safe place:&lt;br /&gt;\n            &lt;br /&gt;\n            Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('4', 'Default Newsletter', 'Newsletter', 'This is a default newsletter template', '&lt;div align=&quot;center&quot;&gt;\n&lt;table style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot; cellpadding=&quot;5&quot; cellspacing=&quot;5&quot; border=&quot;0&quot; width=&quot;600&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello [NAME]!&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot; valign=&quot;top&quot;&gt;You are receiving this email as a part of your newsletter subscription.         &lt;hr&gt;\n            Here goes your newsletter content         &lt;hr&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br&gt;\n            [SITE_NAME] Team&lt;br&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;         &lt;hr&gt;\n            &lt;span style=&quot;font-size: 11px;&quot;&gt;&lt;em&gt;To stop receiving future newsletters please login into your account         and uncheck newsletter subscription box.&lt;/em&gt;&lt;/span&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;&lt;/div&gt;', 'news', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('5', 'Transaction Completed', 'Payment Completed', 'This template is used to notify administrator on successful payment transaction', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello, Admin&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;You have received new payment following:&lt;br /&gt;\n            &lt;br /&gt;\n            Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Membership: &lt;strong&gt;[ITEMNAME]&lt;/strong&gt;&lt;br /&gt;\n            Price: &lt;strong&gt;[PRICE]&lt;/strong&gt;&lt;br /&gt;\n            Status: &lt;strong&gt;[STATUS] &lt;/strong&gt;&lt;br /&gt;\r\n            Processor: &lt;strong&gt;[PP] &lt;/strong&gt;&lt;br /&gt;\n            IP: &lt;strong&gt;[IP] &lt;/strong&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;&lt;em&gt;You can view this transaction from your admin panel&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('6', 'Transaction Suspicious', 'Suspicious Transaction', 'This template is used to notify administrator on failed/suspicious payment transaction', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color:#ccc&quot;&gt;Hello, Admin&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align:left&quot;&gt;The following transaction has been disabled due to suspicious activity:&lt;br /&gt;\n            &lt;br /&gt;\n            Buyer: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Item: &lt;strong&gt;[ITEM]&lt;/strong&gt;&lt;br /&gt;\n            Price: &lt;strong&gt;[PRICE]&lt;/strong&gt;&lt;br /&gt;\n            Status: &lt;strong&gt;[STATUS]&lt;/strong&gt;&lt;/td&gt;\r\n            Processor: &lt;strong&gt;[PP] &lt;/strong&gt;&lt;br /&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align:left&quot;&gt;&lt;em&gt;Please verify this transaction is correct. If it is, please activate it in the transaction section of your site&#039;s &lt;br /&gt;\n            administration control panel. If not, it appears that someone tried to fraudulently obtain products from your site.&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('7', 'Welcome Email', 'Welcome', 'This template is used to welcome newly registered user when Configuration->Registration Verification and Configuration->Auto Registration are both set to YES', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Welcome [NAME]! Thanks for registering.&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;Hello,&lt;br /&gt;\n            &lt;br /&gt;\n            You&#039;re now a member of [SITE_NAME].&lt;br /&gt;\n            &lt;br /&gt;\n            Here are your login details. Please keep them in a safe place:&lt;br /&gt;\n            &lt;br /&gt;\n            Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('8', 'Membership Expire 7 days', 'Your membership will expire in 7 days', 'This template is used to remind user that membership will expire in 7 days', '&lt;div align=&quot;center&quot;&gt;\n&lt;table cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; width=&quot;600&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello, [NAME]&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;\n            &lt;h2 style=&quot;color: rgb(255, 0, 0);&quot;&gt;Your current membership will expire in 7 days&lt;/h2&gt;\n            Please login to your user panel to extend or upgrade your membership.&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('9', 'Membership expired today', 'Your membership has expired', 'This template is used to remind user that membership had expired', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello, [NAME]&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;\n            &lt;h2 style=&quot;color: rgb(255, 0, 0);&quot;&gt;Your current membership has expired!&lt;/h2&gt;\n            Please login to your user panel to extend or upgrade your membership.&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('10', 'Contact Request', 'Contact Inquiry', 'This template is used to send default Contact Request Form', '\n&lt;div align=&quot;center&quot;&gt;\n\t&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n\t\t&lt;tbody&gt;\n\t\t\t&lt;tr&gt;\n\t\t\t\t&lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello Admin&lt;/th&gt;\n\t\t\t&lt;/tr&gt;\n\t\t\t&lt;tr&gt;\n\t\t\t\t&lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;You have a new contact request: &lt;hr /&gt;\n\t\t\t\t\t [MESSAGE] &lt;hr /&gt;\n\t\t\t\t\t From: &lt;span style=&quot;font-weight: bold;&quot;&gt;[SENDER] - [NAME]&lt;/span&gt;&lt;br /&gt;\n\t\t\t\t\tTelephone: &lt;span style=&quot;font-weight: bold;&quot;&gt;[PHONE]&lt;/span&gt;&lt;br /&gt;\n\t\t\t\t\tSubject: &lt;span style=&quot;font-weight: bold;&quot;&gt;[MAILSUBJECT]&lt;/span&gt;&lt;br /&gt;\n\t\t\t\t\tSenders IP: &lt;span style=&quot;font-weight: bold;&quot;&gt;[IP]&lt;/span&gt;&lt;/td&gt;\n\t\t\t&lt;/tr&gt;\n\t\t&lt;/tbody&gt;\n\t&lt;/table&gt;&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('11', 'New Comment', 'New Comment Added', 'This template is used to notify admin when new comment has been added', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello Admin&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;You have a new comment post. You can login into your admin panel to view details:         &lt;hr /&gt;\n            [MESSAGE]         &lt;hr /&gt;\n            From: &lt;strong&gt;[SENDER] - [NAME]&lt;/strong&gt;&lt;br /&gt;\n            www: &lt;strong&gt;[WWW]&lt;/strong&gt;&lt;br /&gt;\n            Page Url: &lt;strong&gt;&lt;a href=&quot;[PAGEURL]&quot;&gt;[PAGEURL]&lt;/a&gt;&lt;/strong&gt;&lt;br /&gt;\n            Senders IP: &lt;strong&gt;[IP]&lt;/strong&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('12', 'Single Email', 'Single User Email', 'This template is used to email single user', '&lt;div align=&quot;center&quot;&gt;\n  &lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n      &lt;tr&gt;\n        &lt;th style=&quot;background-color:#ccc&quot;&gt;Hello [NAME]&lt;/th&gt;\n      &lt;/tr&gt;\n      &lt;tr&gt;\n        &lt;td valign=&quot;top&quot; style=&quot;text-align:left&quot;&gt;Your message goes here...&lt;/td&gt;\n      &lt;/tr&gt;\n      &lt;tr&gt;\n        &lt;td style=&quot;text-align:left&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n          [SITE_NAME] Team&lt;br /&gt;\n          &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n      &lt;/tr&gt;\n    &lt;/tbody&gt;\n  &lt;/table&gt;\n&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('13', 'Notify Admin', 'New User Registration', 'This template is used to notify admin of new registration when Configuration->Registration Notification is set to YES', '&lt;div align=&quot;center&quot;&gt;\n&lt;table cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; width=&quot;600&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello Admin&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;You have a new user registration. You can login into your admin panel to view details:&lt;hr /&gt;\n            Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Name: &lt;strong&gt;[NAME]&lt;/strong&gt;&lt;br /&gt;\n            IP: &lt;strong&gt;[IP]&lt;/strong&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('14', 'Registration Pending', 'Registration Verification Pending', 'This template is used to send Registration Verification Email, when Configuration->Auto Registration is set to NO', '&lt;div align=&quot;center&quot;&gt;\n&lt;table cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; width=&quot;600&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Welcome [NAME]! Thanks for registering.&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;Hello,&lt;br /&gt;\n            &lt;br /&gt;\n            You&#039;re now a member of [SITE_NAME].&lt;br /&gt;\n            &lt;br /&gt;\n            Here are your login details. Please keep them in a safe place:&lt;br /&gt;\n            &lt;br /&gt;\n            Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;         &lt;hr /&gt;\n            The administrator of this site has requested all new accounts&lt;br /&gt;\n            to be activated by the users who created them thus your account&lt;br /&gt;\n            is currently pending verification process.&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;', 'mailer', '');
INSERT INTO `email_templates` (`id`, `name_tr`, `subject_tr`, `help_tr`, `body_tr`, `type`, `typeid`) VALUES ('15', 'Offline Payment', 'Offline Notification', 'This template is used to send notification to a user when offline payment method is being used', '\n&lt;div align=&quot;center&quot; style=&quot;font-family: Arial,Helvetica,sans-serif; font-size: 13px; margin: 20px;&quot;&gt;\n\t&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;10&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 2px solid rgb(187, 187, 187);&quot;&gt;\n\t\t&lt;tbody&gt;\n\t\t\t&lt;tr&gt;\n\t\t\t\t&lt;th style=&quot;background-color: rgb(204, 204, 204); font-size: 16px; padding: 5px; border-bottom: 2px solid rgb(255, 255, 255);&quot;&gt;Hello [NAME]&lt;/th&gt;\n\t\t\t&lt;/tr&gt;\n\t\t\t&lt;tr&gt;\n\t\t\t\t&lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;You have purchased the following:&lt;/td&gt;\n\t\t\t&lt;/tr&gt;\n\t\t\t&lt;tr&gt;\n\t\t\t\t&lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;[ITEMS]&lt;/td&gt;\n\t\t\t&lt;/tr&gt;\n\t\t\t&lt;tr&gt;\n\t\t\t\t&lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;Please send your payment to:&lt;br /&gt;\n\t\t\t\t\t&lt;/td&gt;\n\t\t\t&lt;/tr&gt;\n\t\t\t&lt;tr&gt;\n\t\t\t\t&lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;[INFO]&lt;/td&gt;\n\t\t\t&lt;/tr&gt;\n\t\t\t&lt;tr&gt;\n\t\t\t\t&lt;td valign=&quot;top&quot; style=&quot;text-align: left; background-color: rgb(255, 255, 255); border-top: 2px solid rgb(204, 204, 204);&quot;&gt;&lt;span style=&quot;font-style: italic;&quot;&gt;Thanks,&lt;br /&gt;\n\t\t\t\t\t\t[SITENAME] Team&lt;br /&gt;\n\t\t\t\t\t\t&lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/span&gt;&lt;/td&gt;\n\t\t\t&lt;/tr&gt;\n\t\t&lt;/tbody&gt;\n\t&lt;/table&gt;&lt;/div&gt;', 'mailer', '');


-- --------------------------------------------------
# -- Table structure for table `gateways`
-- --------------------------------------------------
DROP TABLE IF EXISTS `gateways`;
CREATE TABLE `gateways` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `displayname` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL,
  `live` tinyint(1) NOT NULL DEFAULT '1',
  `extra_txt` varchar(255) NOT NULL,
  `extra_txt2` varchar(255) NOT NULL,
  `extra_txt3` varchar(255) DEFAULT NULL,
  `extra` varchar(255) NOT NULL,
  `extra2` varchar(255) NOT NULL,
  `extra3` text,
  `is_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `gateways`
-- --------------------------------------------------

INSERT INTO `gateways` (`id`, `name`, `displayname`, `dir`, `live`, `extra_txt`, `extra_txt2`, `extra_txt3`, `extra`, `extra2`, `extra3`, `is_recurring`, `active`) VALUES ('1', 'paypal', 'PayPal', 'paypal', '0', 'Email Address', 'Currency Code', 'Not in Use', 'paypal@address.com', 'CAD', '', '1', '1');
INSERT INTO `gateways` (`id`, `name`, `displayname`, `dir`, `live`, `extra_txt`, `extra_txt2`, `extra_txt3`, `extra`, `extra2`, `extra3`, `is_recurring`, `active`) VALUES ('2', 'skrill', 'Skrill', 'skrill', '1', 'Email Address', 'Currency Code', 'Secret Passphrase', 'moneybookers@address.com', 'EUR', 'mypassphrase', '1', '1');
INSERT INTO `gateways` (`id`, `name`, `displayname`, `dir`, `live`, `extra_txt`, `extra_txt2`, `extra_txt3`, `extra`, `extra2`, `extra3`, `is_recurring`, `active`) VALUES ('3', 'offline', 'Offline Payment', 'offline', '0', 'Not in Use', 'Not in Use', 'Instructions', '', '', 'Please submit all payments to:\nBank Name:\nBank Account:\netc...', '0', '1');
INSERT INTO `gateways` (`id`, `name`, `displayname`, `dir`, `live`, `extra_txt`, `extra_txt2`, `extra_txt3`, `extra`, `extra2`, `extra3`, `is_recurring`, `active`) VALUES ('4', 'stripe', 'Stripe', 'stripe', '0', 'Secret Key', 'Currency Code', 'Publishable Key', '', 'CAD', '', '0', '1');
INSERT INTO `gateways` (`id`, `name`, `displayname`, `dir`, `live`, `extra_txt`, `extra_txt2`, `extra_txt3`, `extra`, `extra2`, `extra3`, `is_recurring`, `active`) VALUES ('5', 'payfast', 'PayFast', 'payfast', '0', 'Merchant ID', 'Merchant Key', 'PassPhrase', '', '', '', '0', '1');


-- --------------------------------------------------
# -- Table structure for table `language`
-- --------------------------------------------------
DROP TABLE IF EXISTS `language`;
CREATE TABLE `language` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `flag` varchar(2) DEFAULT NULL,
  `langdir` enum('ltr','rtl') DEFAULT 'ltr',
  `author` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `language`
-- --------------------------------------------------

INSERT INTO `language` (`id`, `name`, `flag`, `langdir`, `author`) VALUES ('2', 'Türkçe', 'tr', 'ltr', '');


-- --------------------------------------------------
# -- Table structure for table `layout`
-- --------------------------------------------------
DROP TABLE IF EXISTS `layout`;
CREATE TABLE `layout` (
  `plug_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL,
  `mod_id` int NOT NULL DEFAULT '0',
  `modalias` varchar(30) DEFAULT NULL,
  `page_slug` varchar(50) DEFAULT NULL,
  `is_content` tinyint(1) NOT NULL DEFAULT '0',
  `plug_name` varchar(60) DEFAULT NULL,
  `place` varchar(20) NOT NULL,
  `space` tinyint(1) NOT NULL DEFAULT '10',
  `position` int NOT NULL,
  KEY `idx_layout_id` (`page_id`),
  KEY `idx_plugin_id` (`plug_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `layout`
-- --------------------------------------------------

INSERT INTO `layout` (`plug_id`, `page_id`, `mod_id`, `modalias`, `page_slug`, `is_content`, `plug_name`, `place`, `space`, `position`) VALUES ('49', '24', '0', '', 'anasayfa', '0', '', 'cenbot', '10', '1');


-- --------------------------------------------------
# -- Table structure for table `log`
-- --------------------------------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `failed` tinyint NOT NULL,
  `failed_last` int NOT NULL,
  `type` enum('system','admin','user') NOT NULL,
  `message` text NOT NULL,
  `info_icon` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'default',
  `importance` enum('yes','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `log`
-- --------------------------------------------------

INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('1', 'admin', '127.0.0.1', '2025-03-01 04:19:16', '0', '1740791956', 'user', 'Kullanıcı admin Başarılı bir şekilde çıkış gerçekleştirildi.', 'user', 'no');
INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('2', 'admin', '127.0.0.1', '2025-03-04 19:49:16', '0', '1741106956', 'system', 'Sayfa /Projelerimiz/ başarıyla silindi!', 'content', 'no');
INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('3', 'admin', '127.0.0.1', '2025-03-04 19:49:19', '0', '1741106959', 'system', 'Sayfa /Teklif Formu/ başarıyla silindi!', 'content', 'no');
INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('4', 'admin', '127.0.0.1', '2025-03-04 19:49:20', '0', '1741106960', 'system', 'Sayfa /Kişisel Verilerin İşlenmesi Politikası/ başarıyla silindi!', 'content', 'no');
INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('5', 'admin', '127.0.0.1', '2025-03-04 19:49:22', '0', '1741106962', 'system', 'Sayfa /İletişim Formu/ başarıyla silindi!', 'content', 'no');
INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('6', 'admin', '127.0.0.1', '2025-03-04 19:49:25', '0', '1741106965', 'system', 'Sayfa /İletişim/ başarıyla silindi!', 'content', 'no');
INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('7', 'admin', '127.0.0.1', '2025-03-04 19:49:27', '0', '1741106967', 'system', 'Sayfa /Hakkımızda/ başarıyla silindi!', 'content', 'no');
INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('8', 'admin', '127.0.0.1', '2025-03-04 19:49:29', '0', '1741106969', 'system', 'Sayfa /Ekibimiz/ başarıyla silindi!', 'content', 'no');
INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('9', 'admin', '127.0.0.1', '2025-03-04 19:49:31', '0', '1741106971', 'system', 'Sayfa /Çerez Politikası/ başarıyla silindi!', 'content', 'no');
INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('10', 'admin', '127.0.0.1', '2025-03-04 19:54:14', '0', '1741107254', 'system', 'İçerik sayfası başarıyla güncellendi!', 'content', 'no');
INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('11', 'admin', '127.0.0.1', '2025-03-10 15:53:13', '0', '1741611193', 'system', 'Veritabanı 18-Nov-2022_21-37-03.sql başarıyla silindi!', 'content', 'no');
INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('12', 'admin', '127.0.0.1', '2025-03-10 15:53:19', '0', '1741611199', 'system', 'Veritabanı 27-Feb-2025_22-19-09.sql başarıyla silindi!', 'content', 'no');
INSERT INTO `log` (`id`, `user_id`, `ip`, `created`, `failed`, `failed_last`, `type`, `message`, `info_icon`, `importance`) VALUES ('13', 'admin', '127.0.0.1', '2025-03-10 15:55:30', '0', '1741611330', 'system', 'Veritabanı 10-Mar-2025_15-55-25.sql başarıyla silindi!', 'content', 'no');


-- --------------------------------------------------
# -- Table structure for table `memberships`
-- --------------------------------------------------
DROP TABLE IF EXISTS `memberships`;
CREATE TABLE `memberships` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(255) NOT NULL,
  `description_tr` text,
  `price` float(10,2) NOT NULL DEFAULT '0.00',
  `days` int NOT NULL DEFAULT '0',
  `period` varchar(1) NOT NULL DEFAULT 'D',
  `trial` tinyint(1) NOT NULL DEFAULT '0',
  `recurring` tinyint(1) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `memberships`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `menus`
-- --------------------------------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int unsigned NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `page_slug` varchar(50) DEFAULT NULL,
  `mod_id` int NOT NULL DEFAULT '0',
  `name_tr` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `caption_tr` varchar(100) NOT NULL,
  `content_type` varchar(20) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `target` enum('_self','_blank') NOT NULL DEFAULT '_blank',
  `icon` varchar(50) DEFAULT NULL,
  `cols` tinyint(1) NOT NULL DEFAULT '1',
  `position` int NOT NULL DEFAULT '0',
  `home_page` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `content_id` (`active`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `menus`
-- --------------------------------------------------

INSERT INTO `menus` (`id`, `parent_id`, `page_id`, `page_slug`, `mod_id`, `name_tr`, `slug`, `caption_tr`, `content_type`, `link`, `target`, `icon`, `cols`, `position`, `home_page`, `active`) VALUES ('1', '0', '24', 'anasayfa', '0', 'Anasayfa', 'anasayfa', '', 'page', '', '', '', '0', '1', '1', '1');


-- --------------------------------------------------
# -- Table structure for table `mod_adblock`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_adblock`;
CREATE TABLE `mod_adblock` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(100) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_views_allowed` int NOT NULL,
  `total_clicks_allowed` int NOT NULL,
  `minimum_ctr` decimal(10,2) NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `banner_image_link` varchar(255) DEFAULT NULL,
  `banner_image_alt` varchar(255) DEFAULT NULL,
  `banner_html` text,
  `block_assignment` varchar(255) NOT NULL,
  `total_views` int NOT NULL,
  `total_clicks` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_adblock`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_adblock_memberlevels`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_adblock_memberlevels`;
CREATE TABLE `mod_adblock_memberlevels` (
  `adblock_id` int NOT NULL,
  `memberlevel_id` tinyint NOT NULL,
  PRIMARY KEY (`adblock_id`,`memberlevel_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_adblock_memberlevels`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_blog`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_blog`;
CREATE TABLE `mod_blog` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cid` int NOT NULL DEFAULT '0',
  `uid` int NOT NULL DEFAULT '0',
  `membership_id` varchar(20) NOT NULL DEFAULT '0',
  `title_tr` varchar(100) NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `short_desc_tr` text,
  `body_tr` mediumtext,
  `thumb` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `caption_tr` varchar(100) NOT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `gallery` int NOT NULL DEFAULT '0',
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `expire` datetime DEFAULT '0000-00-00 00:00:00',
  `tags_tr` varchar(100) NOT NULL,
  `hits` int DEFAULT '0',
  `show_author` tinyint(1) NOT NULL DEFAULT '1',
  `show_ratings` tinyint(1) NOT NULL DEFAULT '1',
  `show_comments` tinyint(1) NOT NULL DEFAULT '1',
  `show_sharing` tinyint(1) NOT NULL DEFAULT '1',
  `show_created` tinyint(1) NOT NULL DEFAULT '1',
  `show_like` tinyint(1) NOT NULL DEFAULT '1',
  `layout` tinyint(1) NOT NULL DEFAULT '1',
  `rating` varchar(10) NOT NULL DEFAULT '0',
  `rate_number` varchar(10) NOT NULL DEFAULT '0',
  `like_up` int NOT NULL DEFAULT '0',
  `like_down` int NOT NULL DEFAULT '0',
  `metakey_tr` varchar(200) NOT NULL,
  `metadesc_tr` text,
  `is_user` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_catid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_blog`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_blog_categories`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_blog_categories`;
CREATE TABLE `mod_blog_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL DEFAULT '0',
  `name_tr` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description_tr` text,
  `icon` varchar(100) DEFAULT NULL,
  `perpage` tinyint NOT NULL DEFAULT '10',
  `layout` tinyint(1) NOT NULL DEFAULT '1',
  `position` int NOT NULL DEFAULT '1',
  `metakey_tr` varchar(200) NOT NULL,
  `metadesc_tr` text,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `order_num` (`position`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_blog_categories`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_blog_comments`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_blog_comments`;
CREATE TABLE `mod_blog_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL DEFAULT '0',
  `artid` int NOT NULL DEFAULT '0',
  `username` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `www` varchar(220) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(16) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent_id`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_blog_comments`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_blog_related_categories`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_blog_related_categories`;
CREATE TABLE `mod_blog_related_categories` (
  `aid` int NOT NULL,
  `cid` int NOT NULL,
  PRIMARY KEY (`aid`,`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_blog_related_categories`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_blog_tags`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_blog_tags`;
CREATE TABLE `mod_blog_tags` (
  `aid` int NOT NULL DEFAULT '0',
  `tid` int NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_blog_tags`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_comments`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_comments`;
CREATE TABLE `mod_comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL DEFAULT '0',
  `page_id` int NOT NULL DEFAULT '0',
  `username` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `email` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `www` varchar(220) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(16) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent` (`parent_id`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_comments`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_events`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_events`;
CREATE TABLE `mod_events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '1',
  `title_tr` varchar(150) NOT NULL,
  `venue_tr` varchar(150) NOT NULL,
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date DEFAULT '0000-00-00',
  `time_start` time DEFAULT '00:00:00',
  `time_end` time DEFAULT '00:00:00',
  `body_tr` text,
  `contact_person` varchar(100) DEFAULT NULL,
  `contact_email` varchar(80) DEFAULT NULL,
  `contact_phone` varchar(16) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_events`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_events_data`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_events_data`;
CREATE TABLE `mod_events_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL DEFAULT '0',
  `event_date` date DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_events_data`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_faq`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_faq`;
CREATE TABLE `mod_faq` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_tr` varchar(150) NOT NULL,
  `answer_tr` text,
  `position` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_faq`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_gallery_config`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_gallery_config`;
CREATE TABLE `mod_gallery_config` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(100) NOT NULL,
  `folder` varchar(30) DEFAULT NULL,
  `cols` tinyint NOT NULL DEFAULT '0',
  `watermark` tinyint(1) NOT NULL DEFAULT '0',
  `like` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_gallery_config`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_gallery_images`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_gallery_images`;
CREATE TABLE `mod_gallery_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `gallery_id` int NOT NULL DEFAULT '0',
  `title_tr` varchar(100) NOT NULL,
  `description_tr` varchar(250) NOT NULL,
  `likes` int NOT NULL DEFAULT '0',
  `thumb` varchar(100) DEFAULT NULL,
  `sorting` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_gallery_images`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_gmaps`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_gmaps`;
CREATE TABLE `mod_gmaps` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `lat` decimal(10,6) NOT NULL,
  `lng` decimal(10,6) NOT NULL,
  `zoom` smallint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_gmaps`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_portfolio`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_portfolio`;
CREATE TABLE `mod_portfolio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cid` int NOT NULL DEFAULT '0',
  `slug` varchar(100) DEFAULT NULL,
  `title_tr` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `body_tr` text,
  `thumb` varchar(60) DEFAULT NULL,
  `gallery` smallint NOT NULL DEFAULT '0',
  `metakey_tr` varchar(200) NOT NULL,
  `metadesc_tr` text,
  `created` date DEFAULT '0000-00-00',
  `sorting` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_portfolio`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_portfolio_category`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_portfolio_category`;
CREATE TABLE `mod_portfolio_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `metakey_tr` varchar(100) NOT NULL,
  `metadesc_tr` tinytext,
  `position` smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_portfolio_category`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_slidecms`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_slidecms`;
CREATE TABLE `mod_slidecms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `plug_name` varchar(60) DEFAULT NULL,
  `height` smallint NOT NULL DEFAULT '400',
  `navtype` varchar(10) NOT NULL DEFAULT '0',
  `navpos` varchar(10) NOT NULL DEFAULT 'bottom',
  `navplace` enum('innernav','outer') NOT NULL DEFAULT 'outer',
  `navarrows` tinyint(1) NOT NULL DEFAULT '1',
  `fullscreen` tinyint(1) NOT NULL DEFAULT '0',
  `transition` varchar(20) NOT NULL DEFAULT 'slide',
  `durration` int NOT NULL DEFAULT '300',
  `captions` tinyint(1) NOT NULL DEFAULT '1',
  `autoplay` tinyint(1) NOT NULL DEFAULT '0',
  `loop` tinyint(1) NOT NULL DEFAULT '0',
  `fit` enum('none','contain','cover','scaledown') NOT NULL DEFAULT 'contain',
  `shuffle` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`navtype`,`navpos`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_slidecms`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `mod_slidecms_data`
-- --------------------------------------------------
DROP TABLE IF EXISTS `mod_slidecms_data`;
CREATE TABLE `mod_slidecms_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slider_id` int NOT NULL DEFAULT '0',
  `data_type` enum('img','txt','vid') DEFAULT 'img',
  `data` varchar(200) DEFAULT NULL,
  `caption_tr` varchar(100) NOT NULL,
  `body` text,
  `url` varchar(120) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sorting` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `mod_slidecms_data`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `modules`
-- --------------------------------------------------
DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(120) NOT NULL,
  `show_title` tinyint(1) NOT NULL DEFAULT '0',
  `info_tr` text,
  `modalias` varchar(50) NOT NULL,
  `hasconfig` tinyint(1) NOT NULL DEFAULT '0',
  `system` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `metakey_tr` varchar(200) NOT NULL,
  `metadesc_tr` text,
  `theme` varchar(50) DEFAULT NULL,
  `ver` varchar(4) DEFAULT '1.00',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `modules`
-- --------------------------------------------------

INSERT INTO `modules` (`id`, `title_tr`, `show_title`, `info_tr`, `modalias`, `hasconfig`, `system`, `created`, `metakey_tr`, `metadesc_tr`, `theme`, `ver`, `active`) VALUES ('2', 'Foto Galeri', '0', '', 'gallery', '1', '0', '2014-04-28 06:19:32', '', '', '', '4.0', '1');
INSERT INTO `modules` (`id`, `title_tr`, `show_title`, `info_tr`, `modalias`, `hasconfig`, `system`, `created`, `metakey_tr`, `metadesc_tr`, `theme`, `ver`, `active`) VALUES ('6', 'Sık Sorulan Sorular', '0', '', 'faq', '1', '0', '2014-05-31 20:15:17', '', '', '', '4.0', '1');
INSERT INTO `modules` (`id`, `title_tr`, `show_title`, `info_tr`, `modalias`, `hasconfig`, `system`, `created`, `metakey_tr`, `metadesc_tr`, `theme`, `ver`, `active`) VALUES ('7', 'Hizmetlerimiz', '0', '', 'portfolio', '1', '1', '2014-02-26 08:16:22', '', '', '', '4.0', '1');
INSERT INTO `modules` (`id`, `title_tr`, `show_title`, `info_tr`, `modalias`, `hasconfig`, `system`, `created`, `metakey_tr`, `metadesc_tr`, `theme`, `ver`, `active`) VALUES ('9', 'Haberler', '1', '', 'blog', '1', '1', '2014-03-20 19:12:22', '', '', '', '4.0', '1');
INSERT INTO `modules` (`id`, `title_tr`, `show_title`, `info_tr`, `modalias`, `hasconfig`, `system`, `created`, `metakey_tr`, `metadesc_tr`, `theme`, `ver`, `active`) VALUES ('1', 'Muzibu', '0', '', 'muzibu', '1', '1', '2014-05-07 16:28:45', '', '', '', '1.0', '1');


-- --------------------------------------------------
# -- Table structure for table `muzibu_albums`
-- --------------------------------------------------
DROP TABLE IF EXISTS `muzibu_albums`;
CREATE TABLE `muzibu_albums` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `artist_id` int DEFAULT NULL,
  `description_tr` text,
  `thumb` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `artist_id` (`artist_id`),
  CONSTRAINT `muzibu_albums_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `muzibu_artists` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------
# Dumping data for table `muzibu_albums`
-- --------------------------------------------------

INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('1', 'Dudu', 'dudu', '1', 'Tarkan&#039;ın 2003 yılında çıkardığı, &quot;Dudu&quot; ve &quot;Şımarık&quot; gibi hit şarkıları içeren albümü.', 'ALBUM_92ACBF-0A7538-381B77-E15546-F65DC7-8A0066.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('2', '10', '10', '1', 'Tarkan&#039;ın onuncu stüdyo albümü olarak 2017&#039;de yayınlanan, &quot;Yolla&quot; ve &quot;Beni Çok Sev&quot; gibi şarkıları içeren çalışması.', 'ALBUM_47FCBD-2A8F76-156651-8DFECC-2DB6E4-D54045.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('3', 'Gülümse', 'gulumse', '2', 'Sezen Aksu&#039;nun 1991 yılında yayınlanan, &quot;Hadi Bakalım&quot;, &quot;Keskin Bıçak&quot; gibi hit şarkılar içeren albümü.', 'ALBUM_5B4E1A-55526B-E9EF9E-D471FF-29CFA6-B796C5.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('4', 'Işık Doğudan Yükselir', 'isik-dogudan-yukselir', '2', 'Sezen Aksu&#039;nun 1995 yılında yayınlanan, &quot;Tutsak&quot; ve &quot;İstanbul İstanbul Olalı&quot; gibi şarkıları içeren albümü.', 'ALBUM_B8BC73-C3A603-B037D0-95DD38-30C653-C25E99.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('5', 'Aşk Tesadüfleri Sever', 'ask-tesadufleri-sever', '3', 'Müslüm Gürses&#039;in 2006 yılında çıkardığı, farklı tarzlardaki şarkıları seslendirdiği albüm.', 'ALBUM_F5F7E7-189E0C-64E5AD-7A748E-95A784-A06615.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('6', 'Sandık', 'sandik', '3', 'Müslüm Gürses&#039;in klasik arabesk şarkılarının yer aldığı en sevilen albümlerinden biri.', 'ALBUM_BE583E-E3E06A-E56DF7-769C0C-E3CC0C-B5556C.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('7', 'Dünden Bugüne', 'dunden-bugune', '4', 'Barış Manço&#039;nun en sevilen şarkılarının derlendiği 1990 yılında yayınlanan albüm.', 'ALBUM_89FE1E-1D3C86-742797-200571-4E4F29-40E770.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('8', 'Yeni Bir Gün', 'yeni-bir-gun', '4', 'Barış Manço&#039;nun 1979 yılında yayınlanan, &quot;Dönence&quot; şarkısının da yer aldığı albüm.', 'ALBUM_0A8435-299F0C-F610FB-96EB7D-4959B3-247BA9.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('9', 'Garip', 'garip', '5', 'Neşet Ertaş&#039;ın 1980&#039;lerin başında yayınlanan, Türk halk müziğinin klasikleşmiş eserlerini içeren albümü.', 'ALBUM_6C567F-E7FCE0-7724A1-29B308-EA0FA0-DEA975.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('10', 'Evvelim', 'evvelim', '5', 'Neşet Ertaş&#039;ın 2000&#039;li yıllarda yayınlanan, eski eserlerinin yeniden yorumlandığı albüm.', 'ALBUM_325CCF-30A460-5E6EBD-A07257-933DE3-5812F2.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('11', 'Superstar', 'superstar', '6', 'Ajda Pekkan&#039;ın 1980&#039;de yayınlanan ve pop müziğin klasikleşmiş şarkılarını içeren albümü.', 'ALBUM_8E0D15-A3655F-E7CCA9-4681EE-CE0674-CAA68F.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('12', 'Cool Kadın', 'cool-kadin', '6', 'Ajda Pekkan&#039;ın 2006 yılında yayınlanan ve modern pop tarzındaki şarkılarını içeren albüm.', 'ALBUM_C28E44-4F1DEB-DE7946-858A9E-0C2694-4A0B36.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('13', 'Peki Peki Anladık', 'peki-peki-anladik', '7', 'MFÖ&#039;nün 1989 yılında yayınlanan ve grubun klasikleşmiş şarkılarını içeren albümü.', 'ALBUM_C11B4C-FBB239-186B3C-50F86E-375DE7-C40966.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('14', 'Ve MFÖ', 've-mfo', '7', 'MFÖ&#039;nün 1988 yılında yayınlanan ve &quot;Güllerin İçinden&quot; gibi hit şarkıları içeren albümü.', 'ALBUM_11D357-B5C571-15AC1F-6E4E38-52D406-05D2D6.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('15', 'Yaşamak Haram Oldu', 'yasamak-haram-oldu', '16', 'Ferdi Tayfur&#039;un 1982 yılında çıkardığı, arabesk müziğin klasikleşmiş eserlerini içeren albümü.', 'ALBUM_F46270-ABD6D0-639B7B-16B6E2-70ADEE-471B68.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('16', 'Huzurum Kalmadı', 'huzurum-kalmadi', '16', 'Ferdi Tayfur&#039;un 1986 yılında yayınlanan ve acılı şarkılarının yer aldığı albüm.', 'ALBUM_A1B8C1-C070DA-293732-D8030F-DFDA9D-9F8A8B.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('17', 'Hollyworld', 'hollyworld', '17', 'Athena&#039;nın 1998 yılında yayınlanan ve grup için dönüm noktası olan rock albümü.', 'ALBUM_ABA25C-A1E910-169324-F37A7E-CC6426-ACF139.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('18', 'Her Şey Yolunda', 'her-sey-yolunda', '17', 'Athena&#039;nın 2004 yılında yayınlanan, Eurovision&#039;da ülkemizi temsil ettikleri &quot;For Real&quot; şarkısının da yer aldığı albüm.', 'ALBUM_DFD690-6F4229-6CA109-030BEB-C382C4-FB4DAB.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('19', 'Acıların Kadını', 'acilarin-kadini', '18', 'Bergen&#039;in 1986 yılında çıkardığı ve acı dolu hayatını yansıtan şarkıların yer aldığı albüm.', 'ALBUM_BB141D-959E3A-416ADD-6C1FA3-51F2C8-2936DA.jpg', '2025-03-02 00:00:00', '1');
INSERT INTO `muzibu_albums` (`id`, `title_tr`, `slug`, `artist_id`, `description_tr`, `thumb`, `created`, `active`) VALUES ('20', 'Değişim Rüzgarı', 'degisim-ruzgari', '19', 'Ebru Gündeş&#039;in 2019 yılında yayınlanan ve modern arabesk tarzı şarkıları içeren albümü.', 'ALBUM_8AE411-9F96C3-BB556C-239469-8A880C-F101CB.jpg', '2025-03-02 00:00:00', '1');


-- --------------------------------------------------
# -- Table structure for table `muzibu_artists`
-- --------------------------------------------------
DROP TABLE IF EXISTS `muzibu_artists`;
CREATE TABLE `muzibu_artists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `bio_tr` text,
  `thumb` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------
# Dumping data for table `muzibu_artists`
-- --------------------------------------------------

INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('1', 'Tarkan', 'tarkan', 'Megastar Tarkan, 17 Ekim 1972 tarihinde Almanya&#039;da doğdu. Türk pop müziğinin uluslararası üne sahip en önemli temsilcilerinden biridir.', 'ARTIST_878A2F-33AA18-124989-1580F7-832410-E70875.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('2', 'Sezen Aksu', 'sezen-aksu', 'Türk pop müziğinin &quot;Minik Serçe&quot; lakaplı efsanevi sanatçısı. 1954 doğumlu sanatçı, Türk müziğini şekillendiren en önemli besteci ve söz yazarlarından biridir.', 'ARTIST_36D19A-A9B826-3E5DB5-B86F35-F83354-A6FB1E.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('3', 'Müslüm Gürses', 'muslum-gurses', 'Arabesk müziğin efsane ismi Müslüm Gürses, 1953-2013 yılları arasında yaşamış, &quot;Müslüm Baba&quot; lakaplı unutulmaz bir sanatçıdır.', 'ARTIST_457580-DB5D55-74805D-2B1825-41BC32-F86981.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('4', 'Barış Manço', 'baris-manco', '1943-1999 yılları arasında yaşamış, Anadolu Rock&#039;ın kurucularından ve Türk kültürünün önemli temsilcilerinden biri olmuş efsanevi müzisyen.', 'ARTIST_1F4E3D-6C4E61-5ADB1B-EDA723-116F39-57ECDE.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('5', 'Neşet Ertaş', 'neset-ertas', '1938-2012 yılları arasında yaşamış, &quot;Bozkırın Tezenesi&quot; olarak anılan Türk halk müziğinin en önemli ozanlarından biridir.', 'ARTIST_2D2DDD-CA5954-4BC174-9DBD23-96AA77-3829CE.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('6', 'Ajda Pekkan', 'ajda-pekkan', '&quot;Süperstar&quot; lakaplı pop müzik sanatçısı. 1946 doğumlu olan sanatçı, Türk pop müziğinin gelişiminde önemli rol oynamıştır.', 'ARTIST_01AAED-59F734-FD1CD4-169802-28D5ED-F7D6EC.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('7', 'MFÖ', 'mfo', 'Mazhar Alanson, Fuat Güner ve Özkan Uğur&#039;dan oluşan Türk pop/rock grubu. 1980&#039;lerde kurulmuş olan grup, Türk müziğinin en sevilen gruplarından biridir.', 'ARTIST_D94355-F64D6A-B3D07E-1B16C1-70E73D-1A00C7.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('8', 'Zeki Müren', 'zeki-muren', '&quot;Sanat Güneşi&quot; olarak anılan, 1931-1996 yılları arasında yaşamış Türk sanat müziğinin unutulmaz sesi.', 'ARTIST_B4ADB8-D99D93-A62016-8C0425-424B64-C9CE9A.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('9', 'Cem Karaca', 'cem-karaca', '1945-2004 yılları arasında yaşamış, Anadolu Rock&#039;ın efsane isimlerinden biri olarak kabul edilen sanatçı.', 'ARTIST_C7DC71-AFA7B1-1F1A3A-57BA14-22BE27-A16C0F.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('10', 'Ceza', 'ceza', '1976 doğumlu, Türk hip hop sahnesinin öncülerinden ve en başarılı temsilcilerinden biri olan rap sanatçısı.', 'ARTIST_DB3643-FF72BB-5E97A4-89DDF4-922197-77F821.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('11', 'İbrahim Tatlıses', 'ibrahim-tatlises', '&quot;İmparator&quot; lakaplı, 1952 doğumlu Türk halk müziği ve arabesk sanatçısı.', 'ARTIST_7A466B-687D06-4968C1-F5042A-060F21-ED0A2F.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('12', 'Teoman', 'teoman', '1967 doğumlu, Türk rock müziğinin önemli isimlerinden biri olan şarkıcı ve söz yazarı.', 'ARTIST_C9DCE4-EF028D-0A1E10-D16064-0BF5E3-E50C3F.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('13', 'Selda Bağcan', 'selda-bagcan', '1948 doğumlu, protest müziğin Türkiye&#039;deki en önemli temsilcilerinden olan folk müzik sanatçısı.', 'ARTIST_DF7D88-9F70F5-6133C3-748DD7-7D9CCB-7B31CB.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('14', 'Mor ve Ötesi', 'mor-ve-otesi', '1995 yılında kurulan, Türk alternatif rock sahnesinin önde gelen gruplarından biri.', 'ARTIST_0DCAEA-880260-CBB5A1-3F628A-9DDC45-E66C92.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('15', 'Erol Evgin', 'erol-evgin', '1947 doğumlu, Türk pop müziğinin duayen isimlerinden biri olan şarkıcı ve besteci.', 'ARTIST_0CFD05-C86D47-456B84-A1B3E4-9A2199-F2F851.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('16', 'Ferdi Tayfur', 'ferdi-tayfur', '1945 doğumlu, arabesk müziğin kurucu isimlerinden biri olan şarkıcı, besteci ve aktör.', 'ARTIST_1BDF03-4E019F-A2406A-274698-657F54-447CAE.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('17', 'Athena', 'athena', '1987 yılında kurulan, Türkiye&#039;nin en başarılı ska ve punk rock grubu.', 'ARTIST_328F67-6D0971-20A0A2-EEEA9D-323CC6-044648.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('18', 'Bergen', 'bergen', '1958-1989 yılları arasında yaşamış, &quot;Acıların Kadını&quot; olarak bilinen arabesk sanatçısı.', 'ARTIST_ED5419-D96D63-49443F-B6133D-D14864-8552D8.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('19', 'Ebru Gündeş', 'ebru-gundes', '1974 doğumlu, güçlü sesi ile tanınan popüler Türk halk müziği ve arabesk sanatçısı.', 'ARTIST_63BDE3-FC2C99-53DDB1-2D4A9C-50F091-F51184.jpg', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_artists` (`id`, `title_tr`, `slug`, `bio_tr`, `thumb`, `created`, `active`) VALUES ('20', 'Orhan Gencebay', 'orhan-gencebay', '1944 doğumlu, &quot;Müslüm Baba&quot; olarak da bilinen arabesk müziğin öncü isimlerinden müzisyen ve besteci.', 'ARTIST_1F06A8-E6D5B6-FFECE2-1F9E8D-089816-A18B2D.jpg', '2025-02-28 23:01:01', '1');


-- --------------------------------------------------
# -- Table structure for table `muzibu_favorites`
-- --------------------------------------------------
DROP TABLE IF EXISTS `muzibu_favorites`;
CREATE TABLE `muzibu_favorites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `song_id` int NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_song` (`user_id`,`song_id`),
  KEY `song_id` (`song_id`),
  CONSTRAINT `muzibu_favorites_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `muzibu_songs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------
# Dumping data for table `muzibu_favorites`
-- --------------------------------------------------

INSERT INTO `muzibu_favorites` (`id`, `user_id`, `song_id`, `created`) VALUES ('1', '1', '1', '2025-02-28 23:01:01');
INSERT INTO `muzibu_favorites` (`id`, `user_id`, `song_id`, `created`) VALUES ('2', '1', '4', '2025-02-28 23:01:01');
INSERT INTO `muzibu_favorites` (`id`, `user_id`, `song_id`, `created`) VALUES ('3', '1', '9', '2025-02-28 23:01:01');
INSERT INTO `muzibu_favorites` (`id`, `user_id`, `song_id`, `created`) VALUES ('4', '1', '13', '2025-02-28 23:01:01');
INSERT INTO `muzibu_favorites` (`id`, `user_id`, `song_id`, `created`) VALUES ('5', '1', '17', '2025-02-28 23:01:01');
INSERT INTO `muzibu_favorites` (`id`, `user_id`, `song_id`, `created`) VALUES ('6', '1', '25', '2025-02-28 23:01:01');
INSERT INTO `muzibu_favorites` (`id`, `user_id`, `song_id`, `created`) VALUES ('7', '1', '31', '2025-02-28 23:01:01');
INSERT INTO `muzibu_favorites` (`id`, `user_id`, `song_id`, `created`) VALUES ('8', '1', '36', '2025-02-28 23:01:01');
INSERT INTO `muzibu_favorites` (`id`, `user_id`, `song_id`, `created`) VALUES ('9', '1', '42', '2025-02-28 23:01:01');
INSERT INTO `muzibu_favorites` (`id`, `user_id`, `song_id`, `created`) VALUES ('10', '1', '48', '2025-02-28 23:01:01');


-- --------------------------------------------------
# -- Table structure for table `muzibu_genres`
-- --------------------------------------------------
DROP TABLE IF EXISTS `muzibu_genres`;
CREATE TABLE `muzibu_genres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------
# Dumping data for table `muzibu_genres`
-- --------------------------------------------------

INSERT INTO `muzibu_genres` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('1', 'Pop', 'pop', 'GENRE_FB7429-1EED2F-463FDF-1C9341-13A034-3A9F2E.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_genres` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('2', 'Rock', 'rock', 'GENRE_9170F6-7659A3-A853C1-A59B3E-144627-944A9C.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_genres` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('3', 'Arabesk', 'arabesk', 'GENRE_CB756A-45EE9C-3E64E4-9D25FB-BE33FC-119207.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_genres` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('4', 'Türk Halk Müziği', 'turk-halk-muzigi', 'GENRE_65099B-198BF7-020593-B9A555-3909AC-D35EBF.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_genres` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('5', 'Türk Sanat Müziği', 'turk-sanat-muzigi', 'GENRE_1D898E-C9A028-9CBD90-FD5AC6-49FF58-0D651B.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_genres` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('6', 'Klasik', 'klasik', 'GENRE_C64126-16040C-F05106-7A057B-79AF2D-8F7389.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_genres` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('7', 'Caz', 'caz', 'GENRE_23DB36-2DABB5-B927FC-400F89-9D2818-A330E7.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_genres` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('8', 'Hip Hop', 'hip-hop', 'GENRE_BEF917-F8B068-33BB00-CACE91-DB7E65-12E16D.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_genres` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('9', 'Elektronik', 'elektronik', 'GENRE_47912C-3F920B-AA92D1-6CF556-EC53DB-8C28CD.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_genres` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('10', 'Rap', 'rap', 'GENRE_E36004-A3474A-CFB1F8-2F350E-E78781-6FD141.jpg', '2025-02-28 23:01:01');


-- --------------------------------------------------
# -- Table structure for table `muzibu_playlist_sector`
-- --------------------------------------------------
DROP TABLE IF EXISTS `muzibu_playlist_sector`;
CREATE TABLE `muzibu_playlist_sector` (
  `playlist_id` int NOT NULL,
  `sector_id` int NOT NULL,
  PRIMARY KEY (`playlist_id`,`sector_id`),
  KEY `sector_id` (`sector_id`),
  CONSTRAINT `muzibu_playlist_sector_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `muzibu_playlists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `muzibu_playlist_sector_ibfk_2` FOREIGN KEY (`sector_id`) REFERENCES `muzibu_sectors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------
# Dumping data for table `muzibu_playlist_sector`
-- --------------------------------------------------

INSERT INTO `muzibu_playlist_sector` (`playlist_id`, `sector_id`) VALUES ('5', '1');
INSERT INTO `muzibu_playlist_sector` (`playlist_id`, `sector_id`) VALUES ('6', '2');
INSERT INTO `muzibu_playlist_sector` (`playlist_id`, `sector_id`) VALUES ('7', '3');
INSERT INTO `muzibu_playlist_sector` (`playlist_id`, `sector_id`) VALUES ('8', '4');
INSERT INTO `muzibu_playlist_sector` (`playlist_id`, `sector_id`) VALUES ('4', '5');
INSERT INTO `muzibu_playlist_sector` (`playlist_id`, `sector_id`) VALUES ('5', '5');
INSERT INTO `muzibu_playlist_sector` (`playlist_id`, `sector_id`) VALUES ('9', '5');
INSERT INTO `muzibu_playlist_sector` (`playlist_id`, `sector_id`) VALUES ('3', '6');
INSERT INTO `muzibu_playlist_sector` (`playlist_id`, `sector_id`) VALUES ('4', '6');


-- --------------------------------------------------
# -- Table structure for table `muzibu_playlist_song`
-- --------------------------------------------------
DROP TABLE IF EXISTS `muzibu_playlist_song`;
CREATE TABLE `muzibu_playlist_song` (
  `playlist_id` int NOT NULL,
  `song_id` int NOT NULL,
  `position` int NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`playlist_id`,`song_id`),
  KEY `song_id` (`song_id`),
  CONSTRAINT `muzibu_playlist_song_ibfk_1` FOREIGN KEY (`playlist_id`) REFERENCES `muzibu_playlists` (`id`) ON DELETE CASCADE,
  CONSTRAINT `muzibu_playlist_song_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `muzibu_songs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------
# Dumping data for table `muzibu_playlist_song`
-- --------------------------------------------------

INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('1', '16', '0', '2025-03-04 03:05:05');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('1', '21', '3', '2025-03-04 03:05:05');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('1', '22', '4', '2025-03-04 03:05:05');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('1', '23', '2', '2025-03-04 03:05:05');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('1', '30', '6', '2025-03-04 03:05:05');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('1', '35', '1', '2025-03-04 03:05:05');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('1', '39', '9', '2025-03-04 03:05:05');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('1', '45', '7', '2025-03-04 03:05:05');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('1', '54', '8', '2025-03-04 03:05:05');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('1', '61', '5', '2025-03-04 03:05:05');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '9', '1', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '10', '2', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '11', '3', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '12', '4', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '27', '5', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '28', '6', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '29', '7', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '30', '8', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '35', '9', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '36', '10', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '44', '11', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '45', '12', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '48', '13', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '49', '14', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('2', '50', '15', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('3', '13', '1', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('3', '14', '2', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('3', '15', '3', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('3', '16', '4', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('3', '42', '5', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('3', '43', '6', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '17', '0', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '18', '1', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '19', '2', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '25', '3', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '26', '4', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '28', '16', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '31', '5', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '32', '6', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '33', '7', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '34', '8', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '35', '14', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '37', '9', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '38', '10', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '39', '11', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '42', '15', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '45', '13', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('4', '46', '12', '2025-03-04 18:09:46');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('5', '1', '1', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('5', '2', '2', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('5', '3', '3', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('5', '4', '4', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('5', '18', '5', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('5', '25', '6', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('5', '31', '7', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('5', '34', '8', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('5', '40', '9', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('6', '6', '1', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('6', '7', '2', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('6', '13', '3', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('6', '17', '4', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('6', '23', '5', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('6', '24', '6', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('6', '32', '7', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('6', '42', '8', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('7', '3', '1', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('7', '4', '2', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('7', '5', '3', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('7', '22', '4', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('7', '25', '5', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('7', '31', '6', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('7', '37', '7', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('7', '38', '8', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('7', '46', '9', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('8', '8', '1', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('8', '13', '2', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('8', '15', '3', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('8', '16', '4', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('8', '17', '5', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('8', '24', '6', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('8', '41', '7', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('8', '42', '8', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '1', '0', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '2', '1', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '4', '2', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '6', '3', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '22', '4', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '24', '5', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '31', '6', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '34', '12', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '35', '8', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '39', '10', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '40', '7', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '42', '11', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('9', '45', '9', '2025-03-04 18:09:40');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('10', '6', '1', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('10', '7', '2', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('10', '8', '3', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('10', '21', '4', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('10', '23', '5', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('10', '24', '6', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('10', '40', '7', '2025-02-28 23:01:01');
INSERT INTO `muzibu_playlist_song` (`playlist_id`, `song_id`, `position`, `created`) VALUES ('10', '41', '8', '2025-02-28 23:01:01');


-- --------------------------------------------------
# -- Table structure for table `muzibu_playlists`
-- --------------------------------------------------
DROP TABLE IF EXISTS `muzibu_playlists`;
CREATE TABLE `muzibu_playlists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `system` tinyint(1) NOT NULL DEFAULT '0',
  `description_tr` text,
  `thumb` varchar(255) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------
# Dumping data for table `muzibu_playlists`
-- --------------------------------------------------

INSERT INTO `muzibu_playlists` (`id`, `title_tr`, `slug`, `user_id`, `system`, `description_tr`, `thumb`, `is_public`, `created`, `active`) VALUES ('1', 'En Sevilen Türkçe Pop', 'en-sevilen-turkce-pop', '1', '1', 'Türkiye&#039;nin en sevilen pop şarkıları', 'PLAYLIST_01C497-9F16F4-72ACB6-33E5FD-B69044-BF749A.jpg', '1', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_playlists` (`id`, `title_tr`, `slug`, `user_id`, `system`, `description_tr`, `thumb`, `is_public`, `created`, `active`) VALUES ('2', 'Arabesk Klasikleri', 'arabesk-klasikleri', '1', '0', 'Arabesk müziğin vazgeçilmez klasikleri', 'PLAYLIST_306EEF-D53C2B-908BB0-E5E79E-AB4343-018A66.jpg', '1', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_playlists` (`id`, `title_tr`, `slug`, `user_id`, `system`, `description_tr`, `thumb`, `is_public`, `created`, `active`) VALUES ('3', 'Türk Halk Müziği Seçkileri', 'turk-halk-muzigi-seckileri', '1', '1', 'Türk Halk Müziği&#039;nin en güzel örnekleri', 'PLAYLIST_14A115-4F8BAC-CC3BA2-050405-4D065B-D31641.jpg', '1', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_playlists` (`id`, `title_tr`, `slug`, `user_id`, `system`, `description_tr`, `thumb`, `is_public`, `created`, `active`) VALUES ('4', 'Rock Efsaneleri', 'rock-efsaneleri', '1', '1', 'Türk rock müziğinin unutulmaz parçaları', 'PLAYLIST_74273C-D9CD85-5377F1-554A38-886952-66D204.jpg', '1', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_playlists` (`id`, `title_tr`, `slug`, `user_id`, `system`, `description_tr`, `thumb`, `is_public`, `created`, `active`) VALUES ('5', 'Düğün Şarkıları', 'dugun-sarkilari', '1', '0', 'Düğün ve organizasyonlar için ideal şarkılar', 'PLAYLIST_44CF4A-909532-F936AD-F24748-8212A3-55D639.jpg', '1', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_playlists` (`id`, `title_tr`, `slug`, `user_id`, `system`, `description_tr`, `thumb`, `is_public`, `created`, `active`) VALUES ('6', 'Cafe Ambiyans', 'cafe-ambiyans', '1', '1', 'Cafe ve restoranlar için seçilmiş müzikler', 'PLAYLIST_541275-2D5B1B-1F54E6-DE1A67-1498DA-8C4C8B.jpg', '1', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_playlists` (`id`, `title_tr`, `slug`, `user_id`, `system`, `description_tr`, `thumb`, `is_public`, `created`, `active`) VALUES ('7', 'Spor ve Motivasyon', 'spor-ve-motivasyon', '1', '0', 'Spor yaparken dinleyebileceğiniz enerjik parçalar', 'PLAYLIST_9AD47B-066584-FA3E84-67A39C-3EE1CA-CC0559.jpg', '1', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_playlists` (`id`, `title_tr`, `slug`, `user_id`, `system`, `description_tr`, `thumb`, `is_public`, `created`, `active`) VALUES ('8', 'Otel Dinleti', 'otel', '1', '1', 'Otel ve konaklama tesisleri için seçilmiş sakin müzikler', 'PLAYLIST_C750C4-F6C453-8A8B72-247152-BDA2D2-B1680D.jpg', '1', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_playlists` (`id`, `title_tr`, `slug`, `user_id`, `system`, `description_tr`, `thumb`, `is_public`, `created`, `active`) VALUES ('9', 'AVM Müzikleri', 'avm-muzikleri', '1', '1', 'AVM ve alışveriş merkezleri için müzik listesi', 'PLAYLIST_65C330-4D8121-366748-198982-F8BC3F-229F93.jpg', '1', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_playlists` (`id`, `title_tr`, `slug`, `user_id`, `system`, `description_tr`, `thumb`, `is_public`, `created`, `active`) VALUES ('10', 'Kuaför Keyfim', 'kuafor-keyfim', '1', '0', 'Kuaför ve güzellik salonları için özel müzikler', 'PLAYLIST_727283-90A302-C91E9F-E740C3-88172A-550F3A.jpg', '1', '2025-02-28 23:01:01', '1');


-- --------------------------------------------------
# -- Table structure for table `muzibu_sectors`
-- --------------------------------------------------
DROP TABLE IF EXISTS `muzibu_sectors`;
CREATE TABLE `muzibu_sectors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------
# Dumping data for table `muzibu_sectors`
-- --------------------------------------------------

INSERT INTO `muzibu_sectors` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('1', 'Düğün', 'dugun', 'SECTOR_F4DB8C-F6BAD1-F43A6E-92D605-7E1C36-9C6738.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_sectors` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('2', 'Cafe &amp; Restaurant', 'cafe-restaurant', 'SECTOR_047791-E7F824-1718AB-F6FF79-B6ECF5-6454C3.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_sectors` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('3', 'Spor Salonu', 'spor-salonu', 'SECTOR_55992D-398A6F-A759E4-6C9B30-FBE222-E416F2.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_sectors` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('4', 'Otel', 'otel', 'SECTOR_A2768E-CE4FD3-D69F9A-9CC4B1-EFBC05-F88308.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_sectors` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('5', 'AVM', 'avm', 'SECTOR_2443A8-3CFB17-A5F7D5-61775A-1D2ED1-4993B8.jpg', '2025-02-28 23:01:01');
INSERT INTO `muzibu_sectors` (`id`, `title_tr`, `slug`, `thumb`, `created`) VALUES ('6', 'Kuaför &amp; Güzellik', 'kuafor-guzellik', 'SECTOR_FCAD4B-545AD5-3EB58B-3D542F-B33193-2AA1A8.jpg', '2025-02-28 23:01:01');


-- --------------------------------------------------
# -- Table structure for table `muzibu_song_plays`
-- --------------------------------------------------
DROP TABLE IF EXISTS `muzibu_song_plays`;
CREATE TABLE `muzibu_song_plays` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `song_id` int NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `song_id` (`song_id`),
  CONSTRAINT `muzibu_song_plays_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `muzibu_songs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------
# Dumping data for table `muzibu_song_plays`
-- --------------------------------------------------

INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('1', '1', '1', '192.168.1.100', '2025-02-23 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('2', '1', '4', '192.168.1.100', '2025-02-23 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('3', '1', '1', '192.168.1.100', '2025-02-24 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('4', '1', '9', '192.168.1.100', '2025-02-24 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('5', '1', '13', '192.168.1.100', '2025-02-24 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('6', '1', '4', '192.168.1.100', '2025-02-25 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('7', '1', '17', '192.168.1.100', '2025-02-25 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('8', '1', '25', '192.168.1.100', '2025-02-25 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('9', '1', '1', '192.168.1.100', '2025-02-26 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('10', '1', '31', '192.168.1.100', '2025-02-26 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('11', '1', '36', '192.168.1.100', '2025-02-26 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('12', '1', '4', '192.168.1.100', '2025-02-27 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('13', '1', '42', '192.168.1.100', '2025-02-27 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('14', '1', '48', '192.168.1.100', '2025-02-27 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('15', '1', '1', '192.168.1.100', '2025-02-28 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('16', '1', '4', '192.168.1.100', '2025-02-28 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('17', '1', '9', '192.168.1.100', '2025-02-28 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('18', '1', '13', '192.168.1.100', '2025-02-28 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('19', '1', '17', '192.168.1.100', '2025-02-28 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('20', '', '1', '192.168.1.101', '2025-02-24 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('21', '', '4', '192.168.1.101', '2025-02-24 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('22', '', '1', '192.168.1.101', '2025-02-25 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('23', '', '9', '192.168.1.101', '2025-02-25 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('24', '', '13', '192.168.1.101', '2025-02-26 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('25', '', '4', '192.168.1.101', '2025-02-26 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('26', '', '17', '192.168.1.101', '2025-02-27 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('27', '', '25', '192.168.1.101', '2025-02-27 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('28', '', '1', '192.168.1.101', '2025-02-28 23:01:01');
INSERT INTO `muzibu_song_plays` (`id`, `user_id`, `song_id`, `ip_address`, `created`) VALUES ('29', '', '31', '192.168.1.101', '2025-02-28 23:01:01');


-- --------------------------------------------------
# -- Table structure for table `muzibu_songs`
-- --------------------------------------------------
DROP TABLE IF EXISTS `muzibu_songs`;
CREATE TABLE `muzibu_songs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `album_id` int DEFAULT NULL,
  `genre_id` int NOT NULL,
  `duration` int NOT NULL COMMENT 'Duration in seconds',
  `file_path` varchar(255) DEFAULT NULL,
  `lyrics_tr` text,
  `is_featured` tinyint(1) DEFAULT '0',
  `play_count` int DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `album_id` (`album_id`),
  KEY `genre_id` (`genre_id`),
  CONSTRAINT `muzibu_songs_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `muzibu_albums` (`id`) ON DELETE SET NULL,
  CONSTRAINT `muzibu_songs_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `muzibu_genres` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------
# Dumping data for table `muzibu_songs`
-- --------------------------------------------------

INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('1', 'Kuzu Kuzu', 'kuzu-kuzu', '1', '1', '261', 'uploads/songs/tarkan-kuzu-kuzu.mp3', 'Böyle bir sevdayı kim bilebilir ki?\nBöyle bir sevmede ne edebilirki? \nBenim acılarım bitmez demiştin\nSen haklı olmuştun söyleyebilirdin\n\nYine kurşun gibi saplanıp kaldın yüreğime\nYine beni senden sen beni senden sen beni senden alamadım\nKuzu kuzu geleceğim, söz alamazsın benden\nYok olmaya gideceğim, yak ateşinle beni...', '1', '5432', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('2', 'Dudu', 'dudu', '1', '1', '217', 'uploads/songs/tarkan-dudu.mp3', 'Pis dünya değişti değişeli\nKalmadı sevgi saygı sayılı günlerden beri\nTaze çiçek gibi sulanıp büyüyen\nKaldı yürekler öylece yarı yerde\n\nDudu dudu hanımefendi\nKırdın kalbimi üzgünüm şimdi\nHani güven hani sevgin\nYalancı gelin...', '1', '4298', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('3', 'Şımarık', 'simarik', '1', '1', '231', 'uploads/songs/tarkan-simarik.mp3', 'Zevki sefa doldur kadehleri hadi kaldır\nİste yukardan ne dilersen gelecekler ah\nBir öpücük kondur dudaklarıma ve tadına bak\nÇak bir selam gönder sevgilere hasretinle yan\n\nAman aman aman aman\nŞımarık şımarık', '1', '7645', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('4', 'Yolla', 'yolla', '2', '1', '198', 'uploads/songs/tarkan-yolla.mp3', 'Yazık olmuş, ilişimize yazık olmuş\nYolun açık olsun, yola yolla\nSakıncası yoksa, aşıncaya kadar\nYak beni, sonra yolla\n\nYandım tükeniyorum\nAteşinde eriyorum\nBıktım, yoruldum\nGel de, eskisi gibi\nKafam yerine gelsin\nYol da, eskisi gibi\nKalbim yerine gelsin', '1', '6834', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('5', 'Beni Çok Sev', 'beni-cok-sev', '2', '1', '254', 'uploads/songs/tarkan-beni-cok-sev.mp3', 'Beni çok sev ya da hiç sevme\nAşkımı çöpe atıp da gitme\nSen bakarsın kaşa göze, saça\nBen bakarım sadece sana\n\nŞöyle baksan, her yerim yanar\nBöyle bakma, kalbim çıldırır\nBen divane, sen de gururlu\nAşk başlarsa, mahvolurum', '1', '5326', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('6', 'Hadi Bakalım', 'hadi-bakalim', '3', '1', '245', 'uploads/songs/sezen-aksu-hadi-bakalim.mp3', 'Kim demiş ki sevdan bende eskimez?\nHangi dilden anlatayım sevmiyorum seni ben\nAşkın elbet tahtı gönülde kurulur\nSenin yerini ben çoktan doldurmuşum\n\nHadi bakalım\nÖp bakalım\nBenimkisi can yakıyor\nSenin ki ne yapıyor', '0', '3452', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('7', 'Keskin Bıçak', 'keskin-bicak', '3', '1', '276', 'uploads/songs/sezen-aksu-keskin-bicak.mp3', 'Bana da sardın kollarını\nCanım, nasıl sımsıcak\nBen bu dilden anlamam\nBu topraktan değilim\nKime anlatabilirsin beni?\n\nKeskin bıçak\nTatlı söze yalvarmak\nNe anlarsın kahrımdan?\nHiç başına gelmesin\nHer yemekte tuzu yok etmek', '0', '2851', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('8', 'Tutsak', 'tutsak', '4', '1', '238', 'uploads/songs/sezen-aksu-tutsak.mp3', 'Geçen bahar da vardık, oturduk konuştuk\nGülümsedin bana küçümseyerek\nO gün bugünmüş, sezmişim çok tuhaf\nÇığlıklar çıkarken anlamışım, tutsağım\n\nUmutsuz, tutsak, çaresiz, mahkum\nUmutsuz, tutsak, çaresiz, mahkum\nSana mahkumum, çaresizce sana mahkumum', '0', '3124', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('9', 'İstanbul İstanbul Olalı', 'istanbul-istanbul-olali', '4', '1', '265', 'uploads/songs/sezen-aksu-istanbul-istanbul-olali.mp3', 'İstanbul İstanbul olalı\nBöyle zulüm görmedi\nTarumar olmuş bahçeler\nBeton binalar dizilir\n\nSahipsiz, suskun İstanbul\nSahipsiz, suskun İstanbul', '0', '2762', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('10', 'Nilüfer', 'nilufer', '5', '3', '290', 'uploads/songs/muslum-gurses-nilufer.mp3', 'Nilüfer\nSevgilim bensiz neler yapar şimdi?\nNilüfer\nBaşkası koynunda ne söyler şimdi?\n\nSordum sarı çiçeğe\nSordum menekşeye\nNilüfer sen nerdesin, söyle\nAteşlerde yanıyor, kelimeler donuyor\nNilüfer sen nerdesin söyle?', '0', '4531', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('11', 'Paramparça', 'paramparca', '5', '3', '310', 'uploads/songs/muslum-gurses-paramparca.mp3', 'Çok yalnızım artık buralarda\nKalmak istemiyorum aramızda\nHer şey paramparça her yer dökülüyor\nYüzün aklıma gelince boğuluyorum\n\nBu son günlerimi sayıyorum\nTanrım, sensiz nasıl yaşarım ben\nHayır, bu acıya dayanamam ben\nİnan ki, son kez ağlıyorum', '0', '3890', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('12', 'Mutlu Ol Yeter', 'mutlu-ol-yeter', '6', '3', '271', 'uploads/songs/muslum-gurses-mutlu-ol-yeter.mp3', 'Seni benden koparan eller kırılsın\nGül yüzünden öpen rüzgar kurusun\nSana mutluluk versin gönlünün efendisi\nBenim içinde hiçbir şey bırakmadı gidişi\n\nSen mutlu ol yeter\nBen acı çekerim\nGeçmişi siliver\nBen harap olurum', '0', '4120', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('13', 'Bir Teselli Ver', 'bir-teselli-ver', '6', '3', '295', 'uploads/songs/muslum-gurses-bir-teselli-ver.mp3', 'Bir teselli ver\nYaralıyam ben\nAşkınla senin aşkınla\nBir mecnun olmuşam ben\n\nGel gir koynuma\nSarıl bu gece\nYaralıyam ben\nSevdalıyam ben', '0', '3458', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('14', 'Dönence', 'donence', '8', '2', '320', 'uploads/songs/baris-manco-donence.mp3', 'Dönence\nGüneşin sarı saçlı kızı\nDönence\nDağların mavi gözlü kızı\nDönence\nEsmer tenli, kara gözlü\nDönence\nÇiğdem yeşili düşlerin yarısı', '0', '5621', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('15', 'Gül Pembe', 'gul-pembe', '7', '2', '280', 'uploads/songs/baris-manco-gul-pembe.mp3', 'Ben yoruldum hayat\nGelme üstüme\nDert etme maziyi\nBoş dünya bu\n\nGül pembe, gül pembe\nEllerin ellerime değince\nGül pembe, gül pembe\nGözlerin gözlerime değince', '0', '4873', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('16', 'Neredesin Sen', 'neredesin-sen', '7', '2', '306', 'uploads/songs/baris-manco-neredesin-sen.mp3', 'Ayrılığın acısını çeken bilir\nSevdiğinden ayrı kalan bilir\nBalı özleyen arı gibi\nSensiz yaşadım şimdi bir kaçak gibi\n\nNeredesin sen, neredesin sen?\nNerede, nerede, nerede?', '0', '5124', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('17', 'Bir Bahar Akşamı', 'bir-bahar-aksami', '9', '4', '340', 'uploads/songs/neset-ertas-bir-bahar-aksami.mp3', 'Bir bahar akşamı rastladım size\nSevinçli bir telaş içindeydiniz\nDerinden bakınca gözlerinize\nNeden başınızı öne eğdiniz?\n\nİçimde uyanan eski bir arzu\nDudaklar gülüyor gözlerse nemli', '0', '3876', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('18', 'Gönül Dağı', 'gonul-dagi', '9', '4', '290', 'uploads/songs/neset-ertas-gonul-dagi.mp3', 'Gönül dağı yağmur yağmur boran olunca\nAkar can özümden coşkun seller sel olur\nDost yüzü görmeyince viran olur gönül evi\nSular gibi çağlar akar coşkunum ben', '0', '4215', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('19', 'Neredesin Sen', 'neredesin-sen-2', '10', '4', '325', 'uploads/songs/neset-ertas-neredesin-sen.mp3', 'Elvan çiçekleri soldu bağımın\nYolunu gözledi iki gözüm\nBilmem ki sevdiğim sen nerdesin\nKalbim hicranla doldu taşıyor', '0', '3547', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('20', 'Zülüf', 'zuluf', '10', '4', '310', 'uploads/songs/neset-ertas-zuluf.mp3', 'Zülüf dökülmüş yüze\nSiyah tellerin zülfün\nDeli gönül bekliyor\nBir haberin zülfün\n\nRakiplerin bağı var\nSallanır elmalı yar', '0', '3986', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('21', 'Bambaşka Biri', 'bambaska-biri', '11', '1', '218', 'uploads/songs/ajda-pekkan-bambaska-biri.mp3', 'Bambaşka biri\nAşkı arıyor\nGözlerimde ruhumu okumaya\nÇalışma sakın\n\nBambaşka biri\nBenden çalıyor\nBeni unutmuş beni anlamıyor\nGözlerin bakıyor', '0', '3124', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('22', 'Petrol', 'petrol', '11', '1', '256', 'uploads/songs/ajda-pekkan-petrol.mp3', 'Eski günlere dönülmez\nPetrol bitecek savaş bitecek\nDünyanın derdi sevgiyle çözülecek\nAşkın petrolden de değerli olduğunu bilecek', '0', '2875', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('23', 'Resim', 'resim', '12', '1', '240', 'uploads/songs/ajda-pekkan-resim.mp3', 'Ben bir resim çizerim hayalimde\nSeni saran kollarım resmine\nBir bakarsın üzerimde\nSonra birden kaybolursun', '0', '2542', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('24', 'Son Mektup', 'son-mektup', '12', '1', '227', 'uploads/songs/ajda-pekkan-son-mektup.mp3', 'Son mektup bu sana yazdığım\nSon sözler bunlar ardından\nBu son gözyaşlarım inan\nSon anlar seninle yaşadığım\n\nGittin artık sen uzaklara\nDönmeyeceksin biliyorum', '0', '2786', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('25', 'Ele Güne Karşı Yapayalnız', 'ele-gune-karsi-yapayalniz', '13', '2', '280', 'uploads/songs/mfo-ele-gune-karsi-yapayalniz.mp3', 'Her sabah uyandığımda\nYatağım buz gibi soğuk\nAnımsamaya çalışırım\nGeç kalırım işe\n\nBir çay koyup kendime\nSabah gazetesine göz atarken', '0', '4352', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('26', 'Güllerin İçinden', 'gullerin-icinden', '14', '2', '245', 'uploads/songs/mfo-gullerin-icinden.mp3', 'Güllerin içinden\nGeçip geldiğin rüyalarda\nTepeden tırnağa aşk\nGözlerin dudakların ve sen\n\nUzanıp dokunuyorum\nGüzelliğin yanı başımda\nGözlerine kilitlenmişim', '0', '4876', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('27', 'Peki Peki Anladık', 'peki-peki-anladik', '13', '2', '210', 'uploads/songs/mfo-peki-peki-anladik.mp3', 'Anlatmak istediğini anladık\nHer şeyin bir sonu var biliyorum\nBen buna alışığım, dayatırım\n\nPeki peki anladık\nSen değil yıldızlar kaybetti', '0', '3976', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('28', 'Ali Yazar Veli Bozar', 'ali-yazar-veli-bozar', '14', '2', '225', 'uploads/songs/mfo-ali-yazar-veli-bozar.mp3', 'Ali yazar Veli bozar\nEl çalar biz oynarız\nKim kimi kandırır görelim\nHaydi meydana çıkalım\n\nBir gün sende düşersin\nElbet benim tuzağıma', '0', '3542', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('29', 'Bir Yaralı Kuştum', 'bir-yarali-kustum', '15', '3', '320', 'uploads/songs/ferdi-tayfur-bir-yarali-kustum.mp3', 'Bir yaralı kuştum\nSevda semalarında\nBir ömür aramıştım\nAşkın rotasında\n\nBir yaralı kuştum\nSevda semalarında\nBir ömür aramıştım\nAşkın rotasında', '0', '4536', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('30', 'Huzurum Kalmadı', 'huzurum-kalmadi', '16', '3', '295', 'uploads/songs/ferdi-tayfur-huzurum-kalmadi.mp3', 'Şu garip gönlümün huzuru kalmadı\nSevip ayrılmanın huzuru kalmadı\nBirgün olsun mutluluğu bulmadım\nGözümde yaşların kurusu kalmadı\n\nKaderim oldun zalim zulümkar\nKadehimde zehir, dilimde efkar', '0', '4120', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('31', 'Bana Herşey Seni Hatırlatıyor', 'bana-hersey-seni-hatırlatiyor', '15', '3', '310', 'uploads/songs/ferdi-tayfur-bana-hersey-seni-hatırlatiyor.mp3', 'Bakma öyle mahzun mahzun\nBakışların içimi eritiyor\nGel bana dokunma ne olur\nEllerim ellerini arıyor\n\nBana herşey seni hatırlatıyor\nGünler, yıllar, mevsimler, yağmurlar', '0', '3875', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('32', 'Emmoğlu', 'emmoglu', '16', '3', '285', 'uploads/songs/ferdi-tayfur-emmoglu.mp3', 'Dün gece seyrettim gelin olmuşsun\nBeyaz duvak yakışmış güzelliğine\nBana kısmet olmadın emmoğlu\nEllerin koynunda mutluluklar dilerim\n\nMuhabbetin yalanmış bilseydim\nAllahından bulasın emmoğlu', '0', '4430', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('33', 'Hollyworld', 'hollyworld', '17', '2', '215', 'uploads/songs/athena-hollyworld.mp3', 'Ben bir sirkte gösteri\nKendim yaptım kendimi\nBu bir kaçış sendromu\nKim ben söyleyebilir mi?\n\nEvet biraz düşündüm\nSıkıldım her şeyden', '0', '3254', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('34', 'Arsız Gönül', 'arsiz-gonul', '19', '3', '290', 'uploads/songs/bergen-arsiz-gonul.mp3', 'Arsız gönül hala ondan yana\nÇekip çevirsem de seni\nAh ey gönül deli gönül\nUnutmadın o dilberi\n\nMadem sevdin şu gönlümü\nNeden talan ettin ömrümü?', '0', '4325', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('35', 'Acıların Kadını', 'acilarin-kadini', '19', '3', '310', 'uploads/songs/bergen-acilarin-kadini.mp3', 'Bırakın şu yalan dünyada\nBen kendi halimde yaşayayım\nAcıları ben çektim tek başıma\nAcıların kadını benim', '0', '4562', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('36', 'Ölürsem Yazıktır', 'olursem-yaziktir', '20', '3', '275', 'uploads/songs/ebru-gundes-olursem-yaziktir.mp3', 'Ölürsem yazıktır\nSana doymadım daha\nÖlürsem yazıktır\nSenden bıkmadım daha\n\nBırakma gözlerini gözlerimde\nAyrılma sevgini sevgilerimden', '0', '3876', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('37', 'Sen Mutlu Ol', 'sen-mutlu-ol', '20', '3', '260', 'uploads/songs/ebru-gundes-sen-mutlu-ol.mp3', 'Bir daha sevmeye korkuyorum ben\nNe senin olur bu yüzden ne de başkasının\nSeverim demek kolay değil artık\nŞimdi ben hayata küskünüm\n\nSen mutlu ol yeter bana\nBen senin için bu hayatta bir şeyim kalmasın', '0', '3654', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('38', 'Teşekkür Ederim', 'tesekkur-ederim', '20', '3', '255', 'uploads/songs/ebru-gundes-tesekkur-ederim.mp3', 'Uyutmadığın geceler için\nGözyaşımı sildiğin için\nTuttuğun ellerim için\nTeşekkür ederim\n\nÇok yorgunum şimdi\nDinlenmek istiyorum\nBitsin artık diyorum', '0', '3245', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('39', 'Aldırma Gönül', 'aldirma-gonul', '6', '3', '298', 'uploads/songs/muslum-gurses-aldirma-gonul.mp3', 'Aldırma gönül aldırma\nFukaralık bize ayıp değil ya\nDöner dünya döner elbet\nHere düşen kalkar bir gün\n\nSen bu derdi çekme derim\nYüreğimsin sen benim', '0', '4235', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('40', 'For Real', 'for-real', '18', '2', '190', 'uploads/songs/athena-for-real.mp3', 'Let me be (let me be) just for real\nTake me away (take me away) take me away\nIf you get the feeling\nSo amazing way to go\n\nI\'m out in the fields\nIn the middle of nowhere', '0', '3125', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('41', 'Her Şey Yolunda', 'her-sey-yolunda', '18', '2', '210', 'uploads/songs/athena-her-sey-yolunda.mp3', 'İzin ver dokunayım sana\nİzin ver sarılayım\nBir süre böyle kalalım\nBeynimizin içi çöl\n\nSana bir soru sorabilir miyim?\nHiç arkana baktın mı?', '0', '2986', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('42', 'Arabesk', 'arabesk', '18', '2', '205', 'uploads/songs/athena-arabesk.mp3', 'Bıktım bu sefil hayattan\nÜmidim yok sabahlardan\nFeleğin bana oyunu\nNeden hiç gülmez yüzün?\n\nOlmuyor olmuyor\nHayatım hep karanlık bir zindan', '0', '3254', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('43', 'Olmadı Yar', 'olmadi-yar', '19', '3', '275', 'uploads/songs/bergen-olmadi-yar.mp3', 'Yıllar yılı bekledim\nHasretinle yaşadım\nÜmitlerle gül oldum\nDikeninde kavruldum\n\nOlmadı yar olmadı\nGözlerim yaş dolmadı\nAradığım mutluluk\nBir türlü yar olmadı', '0', '3754', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('44', 'Sevda', 'sevda', '19', '3', '285', 'uploads/songs/bergen-sevda.mp3', 'Sevda dedikleri bir kahır bir zulüm\nUzun ince yolda yorgun bir yolcu\nGönül yorgunu gönlüm kırık perişan\nSen nerdesin canım ben seni özledim\n\nSevmeyi bilmeyen kalpler kırılsın\nGözyaşım sel olup akmasın artık', '0', '3521', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('45', 'Adı Yılmaz', 'adi-yilmaz', '20', '3', '265', 'uploads/songs/ebru-gundes-adi-yilmaz.mp3', 'Ne güzel günlerimiz vardı\nBitmesini hiç istemedim\nSana karşı hiç suçum yoktu\nSebebini hiç öğrenemedim\n\nKimselere kıyamayan Yılmaz\nAdı güzel kendi güzel Yılmaz\nBenim canım senden ayrılmaz', '0', '2986', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('46', 'Kaçak', 'kacak', '20', '3', '280', 'uploads/songs/ebru-gundes-kacak.mp3', 'Kaçak değilim ben bu gönül ülkesinde\nVurmayın beni zalim aşkın zindanlarında\nSuçum yok benim seni çok sevmekten başka\nBilen de yok hangi diyarda kaldığımı\n\nKimi görsem seni soruyor her gün\nKimi görsem seni arıyor her gün', '0', '3156', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('47', 'Git', 'git', '5', '3', '305', 'uploads/songs/muslum-gurses-git.mp3', 'Git artık dön yüzünü eyleme bana öyle\nBenim için her şey bitti seninle\nHayatımdan çık git istemiyorum\nVeda etmene gerek yok artık\n\nHaydi git, git\nYeter artık git', '0', '3857', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('48', 'Seni Yaşatacağım', 'seni-yasatacagim', '5', '3', '295', 'uploads/songs/muslum-gurses-seni-yasatacagim.mp3', 'Sen kolay kolay unutulmaz ki\nYeniden sevebilirim ki\nSenin yerine konulmaz ki\nAşkından başka ne bıraktın\n\nSeni yaşatacağım\nBıraktığın acılarla\nSeni aratacağım\nBitmek bilmeyen hırsımla', '0', '3452', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('49', 'Müsaade Senin', 'musaade-senin', '7', '2', '310', 'uploads/songs/baris-manco-musaade-senin.mp3', 'Kalbim senin kırılır senin elinde\nAlma da verme de ne çıkar senin dilinde\nBu yollar bitiminde neler var kim bilir\nMüsaade senin canım gönlünce takıl\n\nBu can bu beden benim deyip çekip gidiyorsun\nGizli köşede kalmış sararmış mektuplarını da\nBeraber götür bari', '0', '4125', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('50', 'Lambaya Püf De', 'lambaya-puf-de', '7', '2', '285', 'uploads/songs/baris-manco-lambaya-puf-de.mp3', 'Güzel bir gündü, aheste çek, kürekleri\nAheste çek kürekleri mehtap uyanmasın\nLambaya püf de yarı gece, boğaz içinde\n\nLambaya püf de, büyük teyze etme eyleme\nLambaya püf de, dilber teyze n\'olur söyleme\nLambaya püf de, tombul teyze beni dinleme', '0', '4356', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('51', 'Mühür Gözlüm', 'muhur-gozlum', '10', '4', '315', 'uploads/songs/neset-ertas-muhur-gozlum.mp3', 'Mühür gözlüm seni elden\nSakınırım kıskanırım\nEl değince hasta olur\nYanağında güller senin\n\nSeher vakti candan öter\nSeher vakti candan öter\nBülbüller senin', '0', '3876', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('52', 'Kara Toprak', 'kara-toprak', '9', '4', '325', 'uploads/songs/neset-ertas-kara-toprak.mp3', 'Dost dost diye ne gezersen\nDost Allah\'tır naparsın?\nBencileyin harap olmuş\nYapan Allah\'tır naparsın?\n\nGidenler gelmez yollara\nMelhem olmaz yaralara\nDerindir gitme sulara\nHazer Allah\'tır naparsın?', '0', '4235', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('53', 'Superstar', 'superstar', '11', '1', '240', 'uploads/songs/ajda-pekkan-superstar.mp3', 'Ah oh Superstar\nYapayalnız bir Superstar\nParlıyor her gece\nHiç bitmeyen çilesiyle\n\nSahnede sanki bir melek\nBir kırık kalbin sahibi\nBir hüzünlü Superstar', '0', '3542', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('54', 'Cool Kadın', 'cool-kadin', '12', '1', '235', 'uploads/songs/ajda-pekkan-cool-kadin.mp3', 'O kadın cool kadın\nKimseye minnet etmiyor\nÖzgürdür o bildiğince\nEsir olmaz kimseye\n\nO kadın cool kadın\nHer kadın özendiği\nAsla boyun eğmiyor\nMutlu yaşıyor', '0', '3124', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('55', 'Diley Diley', 'diley-diley', '14', '2', '230', 'uploads/songs/mfo-diley-diley.mp3', 'Karşımda durma öyle, yaktın beni\nÇaresiz kaldım sensiz, bilmem ki n\'eyleyim\nSana geldim yar, sana koştum yar\nSana hayran, sana mecburum ben\n\nDiley diley, diley diley\nDilediğin gibi sevdim', '0', '3652', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('56', 'Bodrum, Bodrum', 'bodrum-bodrum', '13', '2', '245', 'uploads/songs/mfo-bodrum-bodrum.mp3', 'Denize karşı\nKum üstünde bir sarhoş\nKimi zaman hüzünlü\nKimi zaman\n\nBodrum, Bodrum, Bodrum\nDalgalarla yaşar', '0', '3845', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('57', 'Leyla', 'leyla', '15', '3', '290', 'uploads/songs/ferdi-tayfur-leyla.mp3', 'Gözümü açtığım zaman\nYanımdaydın benim\nŞimdi sensiz dünyamda\nTek ben varım Leyla\n\nNe yaptım da beni terk edip\nGittin Leyla\nBenden başka bir kimseye\nKanma Leyla', '0', '4125', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('58', 'Benim İçin Üzülme', 'benim-icin-uzulme', '15', '3', '280', 'uploads/songs/ferdi-tayfur-benim-icin-uzulme.mp3', 'Benim için üzülme\nDeğmez bu dünya üzülmeye\nYalancı sevgililer\nGelir geçer üzülme\n\nHer şey nasip kısmet\nTanrıdan gelen hediye\nKimi ağlar kimi güler\nBu dünyada gülmek haram', '0', '3956', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('59', 'Halil İbrahim Sofrası', 'halil-ibrahim-sofrasi', '17', '2', '220', 'uploads/songs/athena-halil-ibrahim-sofrasi.mp3', 'Ağzından bal akıyor\nDilinle yalan söylüyorsun\nGözlerin boş deniz kıyısı\nBaşrolde oynamıyorsun\n\nDişlerini gösteriyorsun\nGülerek selam veriyorsun\nKirli ellere dokunmak için\nRuhundan öpmek istiyorsun', '0', '2985', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('60', 'Yaz Dediniz', 'yaz-dediniz', '17', '2', '225', 'uploads/songs/athena-yaz-dediniz.mp3', 'Gözyaşları içinde\nYolculuğa çıktım sizin için\nBilinmez yönlere\nHepsini yazdım ama kaybettim\n\nYaz dediniz yazdım\nEzberleyin ezberledim\nOku dedim okumadım\nTek dediniz tek geldim', '0', '3124', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('61', 'Hatırla Sevgili', 'hatirla-sevgili', '19', '3', '295', 'uploads/songs/bergen-hatirla-sevgili.mp3', 'Ne olursun hatırla\nBeni sevdiğin günleri\nSevgimizin üstüne yemin ettiğimiz\nGünleri hatırla\n\nAğlıyorum yanıyorum\nSensiz çok yalnızım\nDön ne olur hatırla\nYalvarıyorum sana', '0', '3521', '2025-02-28 23:01:01', '1');
INSERT INTO `muzibu_songs` (`id`, `title_tr`, `slug`, `album_id`, `genre_id`, `duration`, `file_path`, `lyrics_tr`, `is_featured`, `play_count`, `created`, `active`) VALUES ('62', 'Cevapsız Sorular', 'cevapsiz-sorular', '20', '3', '270', 'uploads/songs/ebru-gundes-cevapsiz-sorular.mp3', 'Gözlerim doluyor sensiz kaldığım\nHer gece yarısı ah neredesin?\nÖrselenmiş yüreğim dayanmıyor gayrı\nBu sensiz gecelere ah neredesin?\n\nCevapsız sorular var\nKapımı çalıyor bu aşk\nSana doğru koşarken\nDurduruyor bu aşk', '0', '3245', '2025-02-28 23:01:01', '1');


-- --------------------------------------------------
# -- Table structure for table `notes`
-- --------------------------------------------------
DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(40) DEFAULT NULL,
  `body_en` varchar(200) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `notes`
-- --------------------------------------------------

INSERT INTO `notes` (`id`, `username`, `body_en`, `color`, `created`) VALUES ('3', 'admin', 'Her türlü sorun ve yardım için +90 212 267 12 12 no&#039;lu numaradan destek hizmetinde bulunabilirsiniz.', 'teal', '2016-04-26 21:25:14');
INSERT INTO `notes` (`id`, `username`, `body_en`, `color`, `created`) VALUES ('2', 'admin', 'Türk Bilişim tarafından kodlanan Tubi Portal&#039;ı kullanıyorsunuz.', 'success', '2016-04-26 21:24:43');
INSERT INTO `notes` (`id`, `username`, `body_en`, `color`, `created`) VALUES ('4', 'admin', 'Lütfen yönetici kullanıcı adınızı ve şifrenizi başkalarıyla paylaşmayınız!', 'danger', '2016-04-26 21:25:44');
INSERT INTO `notes` (`id`, `username`, `body_en`, `color`, `created`) VALUES ('5', 'admin', 'Türk Bilişim çalışmalarınızda başarılar diler.', 'warning', '2016-04-26 21:26:25');


-- --------------------------------------------------
# -- Table structure for table `pages`
-- --------------------------------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(200) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `caption_tr` varchar(200) NOT NULL,
  `main` tinyint(1) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '1',
  `home_page` tinyint(1) NOT NULL DEFAULT '0',
  `contact_form` tinyint(1) NOT NULL DEFAULT '0',
  `login` tinyint(1) NOT NULL DEFAULT '0',
  `activate` tinyint(1) NOT NULL DEFAULT '0',
  `account` tinyint(1) NOT NULL DEFAULT '0',
  `register` tinyint(1) NOT NULL DEFAULT '0',
  `search` tinyint(1) NOT NULL DEFAULT '0',
  `sitemap` tinyint(1) NOT NULL DEFAULT '0',
  `profile` tinyint(1) NOT NULL DEFAULT '0',
  `membership_id` varchar(20) NOT NULL DEFAULT '0',
  `module_id` int NOT NULL DEFAULT '0',
  `module_data` varchar(100) NOT NULL DEFAULT '0',
  `module_name` varchar(50) DEFAULT NULL,
  `custom_bg` varchar(100) DEFAULT NULL,
  `theme` varchar(60) DEFAULT NULL,
  `access` enum('Public','Registered','Membership') NOT NULL DEFAULT 'Public',
  `body_tr` text,
  `jscode` text,
  `keywords_tr` text,
  `description_tr` text,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `pages`
-- --------------------------------------------------

INSERT INTO `pages` (`id`, `title_tr`, `slug`, `caption_tr`, `main`, `is_admin`, `home_page`, `contact_form`, `login`, `activate`, `account`, `register`, `search`, `sitemap`, `profile`, `membership_id`, `module_id`, `module_data`, `module_name`, `custom_bg`, `theme`, `access`, `body_tr`, `jscode`, `keywords_tr`, `description_tr`, `created`, `active`) VALUES ('15', 'Giriş', 'giris', '', '1', '1', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', 'Public', '', '', '', '', '2014-04-26 22:11:36', '1');
INSERT INTO `pages` (`id`, `title_tr`, `slug`, `caption_tr`, `main`, `is_admin`, `home_page`, `contact_form`, `login`, `activate`, `account`, `register`, `search`, `sitemap`, `profile`, `membership_id`, `module_id`, `module_data`, `module_name`, `custom_bg`, `theme`, `access`, `body_tr`, `jscode`, `keywords_tr`, `description_tr`, `created`, `active`) VALUES ('16', 'Üye Kaydı', 'kayit', '', '1', '1', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '', '', '', 'Public', '', '', '', '', '2014-04-27 01:22:53', '1');
INSERT INTO `pages` (`id`, `title_tr`, `slug`, `caption_tr`, `main`, `is_admin`, `home_page`, `contact_form`, `login`, `activate`, `account`, `register`, `search`, `sitemap`, `profile`, `membership_id`, `module_id`, `module_data`, `module_name`, `custom_bg`, `theme`, `access`, `body_tr`, `jscode`, `keywords_tr`, `description_tr`, `created`, `active`) VALUES ('17', 'Üyelik Aktivasyonu', 'aktivasyon', '', '1', '1', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', 'Public', '', '', '', '', '2014-04-27 13:08:29', '1');
INSERT INTO `pages` (`id`, `title_tr`, `slug`, `caption_tr`, `main`, `is_admin`, `home_page`, `contact_form`, `login`, `activate`, `account`, `register`, `search`, `sitemap`, `profile`, `membership_id`, `module_id`, `module_data`, `module_name`, `custom_bg`, `theme`, `access`, `body_tr`, `jscode`, `keywords_tr`, `description_tr`, `created`, `active`) VALUES ('18', 'Kullanıcı Sayfası', 'kullanici', '', '1', '1', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '', '', '', 'Public', '', '', '', '', '2014-04-27 14:06:43', '1');
INSERT INTO `pages` (`id`, `title_tr`, `slug`, `caption_tr`, `main`, `is_admin`, `home_page`, `contact_form`, `login`, `activate`, `account`, `register`, `search`, `sitemap`, `profile`, `membership_id`, `module_id`, `module_data`, `module_name`, `custom_bg`, `theme`, `access`, `body_tr`, `jscode`, `keywords_tr`, `description_tr`, `created`, `active`) VALUES ('19', 'Arama Sonuçları', 'ara', '', '1', '1', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '', '', '', 'Public', '', '', '', '', '2014-04-28 23:32:44', '1');
INSERT INTO `pages` (`id`, `title_tr`, `slug`, `caption_tr`, `main`, `is_admin`, `home_page`, `contact_form`, `login`, `activate`, `account`, `register`, `search`, `sitemap`, `profile`, `membership_id`, `module_id`, `module_data`, `module_name`, `custom_bg`, `theme`, `access`, `body_tr`, `jscode`, `keywords_tr`, `description_tr`, `created`, `active`) VALUES ('20', 'Site Haritasi', 'sitemap', '', '1', '1', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '', '', '', 'Public', '', '', '', '', '2014-05-07 17:00:53', '1');
INSERT INTO `pages` (`id`, `title_tr`, `slug`, `caption_tr`, `main`, `is_admin`, `home_page`, `contact_form`, `login`, `activate`, `account`, `register`, `search`, `sitemap`, `profile`, `membership_id`, `module_id`, `module_data`, `module_name`, `custom_bg`, `theme`, `access`, `body_tr`, `jscode`, `keywords_tr`, `description_tr`, `created`, `active`) VALUES ('23', 'Profil', 'profile', '', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '', '', '', 'Public', '', '', '', '', '2014-11-13 17:27:25', '1');
INSERT INTO `pages` (`id`, `title_tr`, `slug`, `caption_tr`, `main`, `is_admin`, `home_page`, `contact_form`, `login`, `activate`, `account`, `register`, `search`, `sitemap`, `profile`, `membership_id`, `module_id`, `module_data`, `module_name`, `custom_bg`, `theme`, `access`, `body_tr`, `jscode`, `keywords_tr`, `description_tr`, `created`, `active`) VALUES ('24', 'Muzibu Telifsiz Müzik', 'anasayfa', '', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '', 'Public', '&lt;p&gt;&lt;/p&gt;', '', '', '', '2016-04-08 02:14:56', '1');


-- --------------------------------------------------
# -- Table structure for table `payments`
-- --------------------------------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `txn_id` varchar(100) DEFAULT NULL,
  `membership_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rate_amount` varchar(255) NOT NULL,
  `currency` varchar(4) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pp` enum('PayPal','MoneyBookers','Offline','Stripe','FastPay') DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `payments`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `plug_blog_tags`
-- --------------------------------------------------
DROP TABLE IF EXISTS `plug_blog_tags`;
CREATE TABLE `plug_blog_tags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tagname_tr` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_content_id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `plug_blog_tags`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `plug_slider`
-- --------------------------------------------------
DROP TABLE IF EXISTS `plug_slider`;
CREATE TABLE `plug_slider` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(150) NOT NULL,
  `body_tr` text,
  `thumb` varchar(150) NOT NULL,
  `url` varchar(150) NOT NULL,
  `page_id` smallint DEFAULT '0',
  `urltype` enum('int','ext','nourl') DEFAULT 'nourl',
  `position` smallint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `plug_slider`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `plugins`
-- --------------------------------------------------
DROP TABLE IF EXISTS `plugins`;
CREATE TABLE `plugins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_tr` varchar(120) NOT NULL,
  `body_tr` text,
  `jscode` text,
  `show_title` tinyint(1) NOT NULL DEFAULT '0',
  `alt_class` varchar(100) NOT NULL DEFAULT '',
  `system` tinyint(1) NOT NULL DEFAULT '0',
  `cplugin` tinyint(1) NOT NULL DEFAULT '0',
  `info_tr` text,
  `plugalias` varchar(50) NOT NULL,
  `hasconfig` tinyint(1) NOT NULL DEFAULT '0',
  `main` tinyint(1) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ver` varchar(4) NOT NULL DEFAULT '1.00',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `plugins`
-- --------------------------------------------------

INSERT INTO `plugins` (`id`, `title_tr`, `body_tr`, `jscode`, `show_title`, `alt_class`, `system`, `cplugin`, `info_tr`, `plugalias`, `hasconfig`, `main`, `created`, `ver`, `active`) VALUES ('6', 'Kayan Banner', '', '', '0', '', '1', '1', '', 'slider', '1', '0', '2014-03-20 14:10:15', '4.0', '1');
INSERT INTO `plugins` (`id`, `title_tr`, `body_tr`, `jscode`, `show_title`, `alt_class`, `system`, `cplugin`, `info_tr`, `plugalias`, `hasconfig`, `main`, `created`, `ver`, `active`) VALUES ('49', 'Anasayfa', '', '', '0', '', '1', '0', '', 'anasayfa', '0', '0', '2020-02-28 02:00:32', '1.00', '1');


-- --------------------------------------------------
# -- Table structure for table `settings`
-- --------------------------------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `site_name` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `site_url` varchar(150) NOT NULL,
  `site_dir` varchar(50) DEFAULT NULL,
  `site_email` varchar(50) NOT NULL,
  `telefon` varchar(15) NOT NULL,
  `facebook` varchar(100) NOT NULL,
  `twitter` varchar(50) NOT NULL,
  `instagram` varchar(50) NOT NULL,
  `linkedin` varchar(50) NOT NULL,
  `googleplus` varchar(100) NOT NULL,
  `foursquare` varchar(100) NOT NULL,
  `youtube` varchar(100) NOT NULL,
  `pinterest` varchar(100) NOT NULL,
  `theme` varchar(32) NOT NULL,
  `theme_var` varchar(32) DEFAULT NULL,
  `seo` tinyint(1) NOT NULL DEFAULT '0',
  `perpage` tinyint NOT NULL DEFAULT '10',
  `backup` varchar(64) NOT NULL,
  `thumb_w` varchar(5) NOT NULL,
  `thumb_h` varchar(5) NOT NULL,
  `img_w` varchar(5) NOT NULL,
  `img_h` varchar(5) NOT NULL,
  `avatar_w` varchar(3) DEFAULT '80',
  `avatar_h` varchar(3) DEFAULT '80',
  `short_date` varchar(50) NOT NULL,
  `long_date` varchar(50) NOT NULL,
  `time_format` varchar(10) DEFAULT NULL,
  `dtz` varchar(120) DEFAULT NULL,
  `locale` varchar(200) DEFAULT NULL,
  `weekstart` tinyint(1) NOT NULL DEFAULT '1',
  `lang` varchar(2) NOT NULL DEFAULT 'en',
  `show_lang` tinyint(1) NOT NULL DEFAULT '0',
  `langdir` varchar(3) NOT NULL DEFAULT 'ltr',
  `eucookie` tinyint(1) NOT NULL DEFAULT '0',
  `offline` tinyint(1) NOT NULL DEFAULT '0',
  `offline_msg` text,
  `offline_d` date DEFAULT '0000-00-00',
  `offline_t` time DEFAULT '00:00:00',
  `logo` varchar(100) DEFAULT NULL,
  `showlogin` tinyint(1) NOT NULL DEFAULT '1',
  `showsearch` tinyint(1) NOT NULL DEFAULT '1',
  `showcrumbs` tinyint(1) NOT NULL DEFAULT '1',
  `bgimg` varchar(60) DEFAULT NULL,
  `repbg` tinyint(1) DEFAULT '0',
  `bgalign` enum('left','right','center') DEFAULT 'left',
  `bgfixed` tinyint(1) DEFAULT '0',
  `bgcolor` varchar(7) DEFAULT NULL,
  `currency` varchar(4) DEFAULT NULL,
  `cur_symbol` varchar(2) DEFAULT NULL,
  `dsep` char(1) NOT NULL DEFAULT ',',
  `tsep` char(1) NOT NULL DEFAULT '.',
  `reg_verify` tinyint(1) NOT NULL DEFAULT '1',
  `auto_verify` tinyint(1) NOT NULL DEFAULT '1',
  `reg_allowed` tinyint(1) NOT NULL DEFAULT '1',
  `notify_admin` tinyint(1) NOT NULL DEFAULT '0',
  `user_limit` varchar(6) DEFAULT NULL,
  `flood` varchar(6) DEFAULT NULL,
  `attempt` varchar(2) DEFAULT NULL,
  `logging` tinyint(1) NOT NULL DEFAULT '0',
  `editor` tinyint(1) NOT NULL DEFAULT '1',
  `metakeys` text,
  `metadesc` text,
  `analytics` text,
  `mailer` enum('PHP','SMTP','SMAIL') DEFAULT NULL,
  `sendmail` varchar(60) DEFAULT NULL,
  `smtp_host` varchar(150) DEFAULT NULL,
  `smtp_user` varchar(50) DEFAULT NULL,
  `smtp_pass` varchar(50) DEFAULT NULL,
  `smtp_port` varchar(3) DEFAULT NULL,
  `is_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `login_page` varchar(100) DEFAULT NULL,
  `register_page` varchar(100) DEFAULT NULL,
  `sitemap_page` varchar(100) DEFAULT NULL,
  `search_page` varchar(100) DEFAULT NULL,
  `activate_page` varchar(100) DEFAULT NULL,
  `account_page` varchar(100) DEFAULT NULL,
  `profile_page` varchar(100) DEFAULT NULL,
  `version` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `settings`
-- --------------------------------------------------

INSERT INTO `settings` (`site_name`, `company`, `site_url`, `site_dir`, `site_email`, `telefon`, `facebook`, `twitter`, `instagram`, `linkedin`, `googleplus`, `foursquare`, `youtube`, `pinterest`, `theme`, `theme_var`, `seo`, `perpage`, `backup`, `thumb_w`, `thumb_h`, `img_w`, `img_h`, `avatar_w`, `avatar_h`, `short_date`, `long_date`, `time_format`, `dtz`, `locale`, `weekstart`, `lang`, `show_lang`, `langdir`, `eucookie`, `offline`, `offline_msg`, `offline_d`, `offline_t`, `logo`, `showlogin`, `showsearch`, `showcrumbs`, `bgimg`, `repbg`, `bgalign`, `bgfixed`, `bgcolor`, `currency`, `cur_symbol`, `dsep`, `tsep`, `reg_verify`, `auto_verify`, `reg_allowed`, `notify_admin`, `user_limit`, `flood`, `attempt`, `logging`, `editor`, `metakeys`, `metadesc`, `analytics`, `mailer`, `sendmail`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `is_ssl`, `login_page`, `register_page`, `sitemap_page`, `search_page`, `activate_page`, `account_page`, `profile_page`, `version`) VALUES ('Muzibu', 'Muzibu', 'http://muzibu.test', '', 'info@turkbilisim.com.tr', '', '', '', '', '', '', '', '', '', 'turkbilisim', '', '1', '50', '10-Mar-2025_15-55-25.sql', '150', '150', '800', '800', '80', '80', '%d %b %Y', '%A %d %B %Y %H:%M', '%I:%M %p', 'Europe/Istanbul', 'tr_utf8,Turkish,tr_TR.UTF-8,Turkish_Turkey.1254,WINDOWS-1254', '1', 'tr', '1', 'ltr', '0', '0', '&lt;p&gt;We are currently working on improving our site. Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. &lt;b&gt;Cras consequat.&lt;/b&gt;&lt;/p&gt;\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n&lt;p&gt;Praesent dapibus, neque id &lt;i&gt;cursus faucibus,&lt;/i&gt; tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.&lt;/p&gt;', '2025-03-04', '00:00:00', 'Ekran_görüntüsü_2025-03-04_181436-removebg-preview.png', '1', '1', '1', 'logo-yazi.png', '0', 'center', '1', '', 'TRY', '₺', ',', '.', '1', '1', '1', '1', '0', '1800', '3', '1', '1', '', '', '', 'PHP', '/usr/sbin/sendmail -t -i', 'mail.hostname.com', 'yourusername', 'yourpass', '25', '0', 'giris', 'kayit', 'sitemap', 'ara', 'aktivasyon', 'kullanici', 'profil', '4.10');


-- --------------------------------------------------
# -- Table structure for table `stats`
-- --------------------------------------------------
DROP TABLE IF EXISTS `stats`;
CREATE TABLE `stats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `day` date NOT NULL DEFAULT '0000-00-00',
  `pageviews` int NOT NULL DEFAULT '0',
  `uniquevisitors` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `stats`
-- --------------------------------------------------

INSERT INTO `stats` (`id`, `day`, `pageviews`, `uniquevisitors`) VALUES ('1', '2025-02-27', '3', '2');
INSERT INTO `stats` (`id`, `day`, `pageviews`, `uniquevisitors`) VALUES ('2', '2025-03-04', '58', '3');
INSERT INTO `stats` (`id`, `day`, `pageviews`, `uniquevisitors`) VALUES ('3', '2025-03-05', '6', '2');
INSERT INTO `stats` (`id`, `day`, `pageviews`, `uniquevisitors`) VALUES ('4', '2025-03-08', '11', '2');
INSERT INTO `stats` (`id`, `day`, `pageviews`, `uniquevisitors`) VALUES ('5', '2025-03-10', '1', '1');


-- --------------------------------------------------
# -- Table structure for table `user_activity`
-- --------------------------------------------------
DROP TABLE IF EXISTS `user_activity`;
CREATE TABLE `user_activity` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uid` int NOT NULL DEFAULT '0',
  `url` varchar(200) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` text,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `user_activity`
-- --------------------------------------------------



-- --------------------------------------------------
# -- Table structure for table `users`
-- --------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fbid` bigint NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `membership_id` tinyint NOT NULL DEFAULT '0',
  `mem_expire` datetime DEFAULT '0000-00-00 00:00:00',
  `trial_used` tinyint(1) NOT NULL DEFAULT '0',
  `memused` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(60) NOT NULL,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) NOT NULL,
  `token` varchar(40) NOT NULL DEFAULT '0',
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `userlevel` tinyint(1) NOT NULL DEFAULT '1',
  `custom_fields` text,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `lastlogin` datetime DEFAULT '0000-00-00 00:00:00',
  `lastip` varchar(16) DEFAULT '0',
  `avatar` varchar(50) DEFAULT NULL,
  `access` text,
  `notes` tinytext,
  `info` tinytext,
  `fb_link` varchar(100) DEFAULT NULL,
  `tw_link` varchar(100) DEFAULT NULL,
  `gp_link` varchar(100) DEFAULT NULL,
  `active` enum('y','n','t','b') NOT NULL DEFAULT 'n',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------
# Dumping data for table `users`
-- --------------------------------------------------

INSERT INTO `users` (`id`, `fbid`, `username`, `password`, `membership_id`, `mem_expire`, `trial_used`, `memused`, `email`, `fname`, `lname`, `token`, `newsletter`, `userlevel`, `custom_fields`, `created`, `lastlogin`, `lastip`, `avatar`, `access`, `notes`, `info`, `fb_link`, `tw_link`, `gp_link`, `active`) VALUES ('1', '0', 'admin', '6067a3c945a228950230460f51a97b0cf8d17525', '0', '0000-00-00 00:00:00', '0', '0', 'info@turkbilisim.com.tr', '', '', '0', '0', '9', '', '2016-04-22 13:42:33', '2025-03-01 04:19:18', '127.0.0.1', '', '', '', '', '', '', '', 'y');


SET FOREIGN_KEY_CHECKS = 1;
