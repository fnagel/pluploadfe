#
# Table structure for table 'tx_pluploadfe_config'
#
CREATE TABLE tx_pluploadfe_config (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	title tinytext NOT NULL,
	upload_path text,
	extensions text,
	feuser_required tinyint(3) DEFAULT '1' NOT NULL,
	feuser_field tinytext NOT NULL,
	save_session tinyint(3) DEFAULT '0' NOT NULL,
	obscure_dir tinyint(3) DEFAULT '1' NOT NULL,
	check_mime tinyint(3) DEFAULT '1' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	tx_pluploadfe_config text
);