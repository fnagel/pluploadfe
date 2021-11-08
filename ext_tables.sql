#
# Table structure for table 'tx_pluploadfe_config'
#
CREATE TABLE tx_pluploadfe_config (
	title tinytext NOT NULL,
	upload_path text,
	extensions text,
	feuser_required tinyint(3) DEFAULT '1' NOT NULL,
	feuser_field tinytext NOT NULL,
	save_session tinyint(3) DEFAULT '0' NOT NULL,
	obscure_dir tinyint(3) DEFAULT '1' NOT NULL,
	check_mime tinyint(3) DEFAULT '1' NOT NULL
);


#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
	tx_pluploadfe_config text
);
