DROP TABLE IF EXISTS ems_allocation;
DROP TABLE IF EXISTS ems_allocation_type;
DROP TABLE IF EXISTS ems_user;
DROP TABLE IF EXISTS ems_user_group;
DROP TABLE IF EXISTS ems_village_ward;
DROP TABLE IF EXISTS ems_township;
DROP TABLE IF EXISTS ems_district;
DROP TABLE IF EXISTS ems_state_region;
DROP TABLE IF EXISTS ems_session;

CREATE TABLE ems_session(
	session_id VARCHAR(40) DEFAULT '0' NOT NULL,
	ip_address VARCHAR(45) DEFAULT '0' NOT NULL,
	user_agent VARCHAR(120) NOT NULL,
	last_activity INT(10) unsigned DEFAULT 0 NOT NULL,
	user_data TEXT NOT NULL,
	PRIMARY KEY (session_id),
	KEY `last_activity_idx` (`last_activity`)
)ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE ems_state_region(
	state_region_id INT(2) AUTO_INCREMENT,
	state_region_name VARCHAR(255) NOT NULL UNIQUE,
	state_region_location VARCHAR(255) NOT NULL,
	state_region_population BIGINT DEFAULT 0,
	PRIMARY KEY (state_region_id)
)ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE ems_district(
	district_id INT(2) AUTO_INCREMENT,
	district_name VARCHAR(255) NOT NULL,
	district_population BIGINT DEFAULT 0,
	district_state_region INT(2) NOT NULL,
	PRIMARY KEY (district_id),
	FOREIGN KEY (district_state_region) REFERENCES ems_state_region(state_region_id),
	UNIQUE KEY `unique_name_state_region` (district_name, district_state_region)
)ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE ems_township(
	township_id INT(3) AUTO_INCREMENT,
	township_name VARCHAR(255) NOT NULL,
	township_population BIGINT DEFAULT 0,
	township_district INT(2) NOT NULL,
	PRIMARY KEY (township_id),
	FOREIGN KEY (township_district) REFERENCES ems_district(district_id),
	UNIQUE KEY `unique_name_district` (township_name, township_district)
)ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE ems_village_ward(
	village_ward_id INT(5) AUTO_INCREMENT,
	village_ward_name VARCHAR(255) NOT NULL,
	village_ward_population BIGINT DEFAULT 0,
	village_ward_township INT(3) NOT NULL,
	PRIMARY KEY (village_ward_id),
	FOREIGN KEY (village_ward_township) REFERENCES ems_township(township_id),
	UNIQUE KEY `unique_name_township` (village_ward_name,village_ward_township)
)ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE ems_user_group(
	user_group_id INT(6) AUTO_INCREMENT,
	user_group_name VARCHAR(255) NOT NULL UNIQUE,
	user_group_module_access INT(1) DEFAULT 0,
	user_group_create INT(1) DEFAULT 0,
	user_group_edit INT(1) DEFAULT 0,
	user_group_delete INT(1) DEFAULT 0,
	user_module_access INT(1) DEFAULT 0,
	user_create INT(1) DEFAULT 0,
	user_edit INT(1) DEFAULT 0,
	user_delete INT(1) DEFAULT 0,
	PRIMARY KEY (user_group_id)
)ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE ems_user(
	user_id VARCHAR(6) NOT NULL,
	user_image VARCHAR(128) NOT NULL DEFAULT "default.png",
	user_email_address VARCHAR(128) NOT NULL UNIQUE,
	user_password VARCHAR(128) NOT NULL,
	user_name VARCHAR(50) NOT NULL,
	user_gender INT(1) NOT NULL,
	user_dob DATE NOT NULL,
	user_line_phone VARCHAR(9) DEFAULT "",
	user_mobile_phone VARCHAR(12) NOT NULL,
	user_address TEXT NOT NULL,
	user_biography LONGTEXT NOT NULL DEFAULT "",
	user_group INT(6) NOT NULL,
	PRIMARY KEY (user_id),
	FOREIGN KEY (user_group) REFERENCES ems_user_group(user_group_id)
)ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE ems_allocation(
	allocation_user VARCHAR(6) NOT NULL,
	allocation_location INT(6) NOT NULL,
	PRIMARY KEY (allocation_user,allocation_location),
	FOREIGN KEY (allocation_user) REFERENCES ems_user(user_id)
)ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_unicode_ci;

INSERT INTO ems_state_region(state_region_name,state_region_location,state_region_population) 
VALUES
('ကချင်ပြည်နယ်','မြောက်ပိုင်း',1270000),
('ကယားပြည်နယ်','အရှေ့ပိုင်း',259000),
('ကရင်ပြည်နယ်','တောင်ပိုင်း',1431377),
('ချင်းပြည်နယ်','အနောက်ပိုင်း',480000),
('စစ်ကိုင်းတိုင်းဒေသကြီး','မြောက်ပိုင်း',5300000),
('တနင်္သာရီတိုင်းဒေသကြီး','တောင်ပိုင်း',1356000),
('နေပြည်တော် ပြည်တောင်စုနယ်မြေ','အလယ်ပိုင်း',925000),
('ပဲခူးတိုင်းဒေသကြီး','အောက်ပိုင်း',5099000),
('မကွေးတိုင်းဒေသကြီး','အလယ်ပိုင်း',4464000),
('မန္တလေးတိုင်းဒေသကြီး','အလယ်ပိုင်း',7627000),
('မွန်ပြည်နယ်','တောင်ပိုင်း',2466000),
('ရခိုင်ပြည်နယ်','အနောက်ပိုင်း',2744000),
('ရန်ကုန်တိုင်းဒေသကြီး','အောက်ပိုင်း',5560000),
('ရှမ်းပြည်နယ်','အရှေ့ပိုင်း',4851000),
('ဧရာဝတီတိုင်းဒေသကြီး','အောက်ပိုင်း',6663000);

INSERT INTO ems_user_group VALUES (1, 'Administrator', 1, 1, 1, 1, 1, 1, 1, 1 );

INSERT INTO ems_user VALUES ('000AAA','daniel.png','dani3lsu@gmail.com', '59a2c406caf0f71e72722f012cb828c1f7df17d96f1456a8f4a4a69654ca565f', 'Daniel Su', 1, '1988-05-05', '', '01118511085', 'No 136 Jalan Song, Kuching', '', 1);