/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : restful

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-10-14 15:19:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `title` varchar(40) NOT NULL COMMENT '文章标题',
  `content` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `created_at` int(10) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`article_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', '文章标题', '文章内容', '1', '1539436658');
INSERT INTO `article` VALUES ('2', '文章标题2', '文章内容2', '1', '1539436709');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `created_at` int(10) unsigned NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`user_id`),
  KEY `username` (`username`),
  KEY `create_at` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '3eb167a3c5d9720d96da0891d6736a35', '1539435056');
INSERT INTO `user` VALUES ('2', 'buddha', '3eb167a3c5d9720d96da0891d6736a35', '1539445251');
INSERT INTO `user` VALUES ('3', 'buddha1', '3eb167a3c5d9720d96da0891d6736a35', '1539445452');
