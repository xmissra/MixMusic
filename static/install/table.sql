
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*{shu}{ju}{biao} `prefix_admin` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_admin`;

CREATE TABLE `prefix_admin` (
  `in_adminid` int(11) NOT NULL AUTO_INCREMENT,
  `in_adminname` varchar(255) NOT NULL,
  `in_adminpassword` varchar(255) NOT NULL,
  `in_loginip` varchar(255) DEFAULT NULL,
  `in_loginnum` int(11) NOT NULL,
  `in_logintime` datetime DEFAULT NULL,
  `in_islock` int(11) NOT NULL,
  `in_permission` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`in_adminid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_user` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_user`;

CREATE TABLE `prefix_user` (
  `in_userid` int(11) NOT NULL AUTO_INCREMENT,
  `in_username` varchar(255) NOT NULL,
  `in_userpassword` varchar(255) NOT NULL,
  `in_mail` varchar(255) DEFAULT NULL,
  `in_ismail` int(11) NOT NULL,
  `in_sex` int(11) NOT NULL,
  `in_birthday` varchar(255) DEFAULT NULL,
  `in_address` varchar(255) DEFAULT NULL,
  `in_introduce` text,
  `in_regdate` datetime DEFAULT NULL,
  `in_loginip` varchar(255) DEFAULT NULL,
  `in_logintime` datetime DEFAULT NULL,
  `in_islock` int(11) NOT NULL,
  `in_isstar` int(11) NOT NULL,
  `in_hits` int(11) NOT NULL,
  `in_points` int(11) NOT NULL,
  `in_rank` int(11) NOT NULL,
  `in_grade` int(11) NOT NULL,
  `in_vipgrade` int(11) NOT NULL,
  `in_vipindate` datetime DEFAULT NULL,
  `in_vipenddate` datetime DEFAULT NULL,
  `in_sign` int(11) NOT NULL,
  `in_signtime` datetime DEFAULT NULL,
  `in_ucid` int(11) NOT NULL,
  `in_qqopen` varchar(255) DEFAULT NULL,
  `in_qqimg` varchar(255) DEFAULT NULL,
  `in_avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`in_userid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_verify` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_verify`;

CREATE TABLE `prefix_verify` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_uid` int(11) NOT NULL,
  `in_name` varchar(255) NOT NULL,
  `in_cardtype` varchar(255) NOT NULL,
  `in_cardnum` varchar(255) NOT NULL,
  `in_address` varchar(255) NOT NULL,
  `in_mobile` varchar(255) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_session` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_session`;

CREATE TABLE `prefix_session` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_invisible` int(11) NOT NULL,
  `in_addtime` int(11) NOT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_message` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_message`;

CREATE TABLE `prefix_message` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_uids` int(11) NOT NULL,
  `in_unames` varchar(255) NOT NULL,
  `in_content` text,
  `in_isread` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_feed` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_feed`;

CREATE TABLE `prefix_feed` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_type` int(11) NOT NULL,
  `in_tid` int(11) NOT NULL,
  `in_icon` varchar(255) NOT NULL,
  `in_title` varchar(255) NOT NULL,
  `in_content` text,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_reply` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_reply`;

CREATE TABLE `prefix_reply` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_fuid` int(11) NOT NULL,
  `in_fid` int(11) NOT NULL,
  `in_content` text,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_comment` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_comment`;

CREATE TABLE `prefix_comment` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_table` varchar(255) DEFAULT NULL,
  `in_tid` int(11) NOT NULL,
  `in_content` text,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_wall` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_wall`;

CREATE TABLE `prefix_wall` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_uids` int(11) NOT NULL,
  `in_unames` varchar(255) NOT NULL,
  `in_content` text,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_blog_group` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_blog_group`;

CREATE TABLE `prefix_blog_group` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_title` varchar(255) NOT NULL,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_blog` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_blog`;

CREATE TABLE `prefix_blog` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_gid` int(11) NOT NULL,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_title` varchar(255) NOT NULL,
  `in_content` text,
  `in_hits` int(11) NOT NULL,
  `in_egg` int(11) NOT NULL,
  `in_flower` int(11) NOT NULL,
  `in_scary` int(11) NOT NULL,
  `in_cool` int(11) NOT NULL,
  `in_beautiful` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_photo_group` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_photo_group`;

CREATE TABLE `prefix_photo_group` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_pid` int(11) NOT NULL,
  `in_title` varchar(255) NOT NULL,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_photo` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_photo`;

CREATE TABLE `prefix_photo` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_gid` int(11) NOT NULL,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_title` varchar(255) DEFAULT NULL,
  `in_url` varchar(255) NOT NULL,
  `in_hits` int(11) NOT NULL,
  `in_egg` int(11) NOT NULL,
  `in_flower` int(11) NOT NULL,
  `in_scary` int(11) NOT NULL,
  `in_cool` int(11) NOT NULL,
  `in_beautiful` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_friend_group` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_friend_group`;

CREATE TABLE `prefix_friend_group` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_title` varchar(255) NOT NULL,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_friend` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_friend`;

CREATE TABLE `prefix_friend` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_gid` int(11) NOT NULL,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_uids` int(11) NOT NULL,
  `in_unames` varchar(255) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_footprint` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_footprint`;

CREATE TABLE `prefix_footprint` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_uids` int(11) NOT NULL,
  `in_unames` varchar(255) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_favorites` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_favorites`;

CREATE TABLE `prefix_favorites` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_mid` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_listen` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_listen`;

CREATE TABLE `prefix_listen` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_mid` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_link` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_link`;

CREATE TABLE `prefix_link` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_url` varchar(255) NOT NULL,
  `in_cover` varchar(255) DEFAULT NULL,
  `in_type` int(11) NOT NULL,
  `in_hide` int(11) NOT NULL,
  `in_order` int(11) NOT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_uplog` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_uplog`;

CREATE TABLE `prefix_uplog` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_title` varchar(255) DEFAULT NULL,
  `in_type` varchar(255) DEFAULT NULL,
  `in_size` varchar(255) DEFAULT NULL,
  `in_url` varchar(255) DEFAULT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_paylog` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_paylog`;

CREATE TABLE `prefix_paylog` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_title` varchar(255) NOT NULL,
  `in_points` int(11) NOT NULL,
  `in_money` int(11) NOT NULL,
  `in_lock` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_label` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_label`;

CREATE TABLE `prefix_label` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_type` varchar(255) NOT NULL,
  `in_selflable` text,
  `in_remark` varchar(255) DEFAULT NULL,
  `in_priority` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_template` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_template`;

CREATE TABLE `prefix_template` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_path` varchar(255) NOT NULL,
  `in_default` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_plugin` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_plugin`;

CREATE TABLE `prefix_plugin` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_dir` varchar(255) NOT NULL,
  `in_file` varchar(255) NOT NULL,
  `in_isindex` int(11) NOT NULL,
  `in_type` int(11) NOT NULL,
  `in_author` varchar(255) DEFAULT NULL,
  `in_address` varchar(255) DEFAULT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_mail` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_mail`;

CREATE TABLE `prefix_mail` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_uid` int(11) NOT NULL,
  `in_ucode` varchar(255) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_tag` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_tag`;

CREATE TABLE `prefix_tag` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_title` varchar(255) NOT NULL,
  `in_type` int(11) NOT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_class` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_class`;

CREATE TABLE `prefix_class` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_hide` int(11) NOT NULL,
  `in_order` int(11) NOT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_music` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_music`;

CREATE TABLE `prefix_music` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_classid` int(11) NOT NULL,
  `in_specialid` int(11) NOT NULL,
  `in_singerid` int(11) NOT NULL,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_audio` varchar(255) NOT NULL,
  `in_lyric` varchar(255) DEFAULT NULL,
  `in_text` text,
  `in_cover` varchar(255) DEFAULT NULL,
  `in_tag` varchar(255) DEFAULT NULL,
  `in_color` varchar(255) DEFAULT NULL,
  `in_hits` int(11) NOT NULL,
  `in_downhits` int(11) NOT NULL,
  `in_favhits` int(11) NOT NULL,
  `in_goodhits` int(11) NOT NULL,
  `in_badhits` int(11) NOT NULL,
  `in_points` int(11) NOT NULL,
  `in_grade` int(11) NOT NULL,
  `in_best` int(11) NOT NULL,
  `in_passed` int(11) NOT NULL,
  `in_wrong` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_special_class` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_special_class`;

CREATE TABLE `prefix_special_class` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_hide` int(11) NOT NULL,
  `in_order` int(11) NOT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_special` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_special`;

CREATE TABLE `prefix_special` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_classid` int(11) NOT NULL,
  `in_singerid` int(11) NOT NULL,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_cover` varchar(255) DEFAULT NULL,
  `in_intro` text,
  `in_firm` varchar(255) DEFAULT NULL,
  `in_lang` varchar(255) DEFAULT NULL,
  `in_hits` int(11) NOT NULL,
  `in_passed` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_singer_class` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_singer_class`;

CREATE TABLE `prefix_singer_class` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_hide` int(11) NOT NULL,
  `in_order` int(11) NOT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_singer` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_singer`;

CREATE TABLE `prefix_singer` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_nick` varchar(255) DEFAULT NULL,
  `in_classid` int(11) NOT NULL,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_cover` varchar(255) DEFAULT NULL,
  `in_intro` text,
  `in_hits` int(11) NOT NULL,
  `in_passed` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_video_class` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_video_class`;

CREATE TABLE `prefix_video_class` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_hide` int(11) NOT NULL,
  `in_order` int(11) NOT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_video` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_video`;

CREATE TABLE `prefix_video` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_classid` int(11) NOT NULL,
  `in_singerid` int(11) NOT NULL,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_play` varchar(255) NOT NULL,
  `in_cover` varchar(255) DEFAULT NULL,
  `in_intro` text,
  `in_hits` int(11) NOT NULL,
  `in_passed` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_article_class` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_article_class`;

CREATE TABLE `prefix_article_class` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_hide` int(11) NOT NULL,
  `in_order` int(11) NOT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};

/*{shu}{ju}{biao} `prefix_article` {de}{jie}{gou}*/

DROP TABLE IF EXISTS `prefix_article`;

CREATE TABLE `prefix_article` (
  `in_id` int(11) NOT NULL AUTO_INCREMENT,
  `in_name` varchar(255) NOT NULL,
  `in_nick` varchar(255) DEFAULT NULL,
  `in_classid` int(11) NOT NULL,
  `in_uid` int(11) NOT NULL,
  `in_uname` varchar(255) NOT NULL,
  `in_cover` varchar(255) DEFAULT NULL,
  `in_intro` text,
  `in_hits` int(11) NOT NULL,
  `in_passed` int(11) NOT NULL,
  `in_addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`in_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET={charset};
