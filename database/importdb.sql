CREATE TABLE `admin`(
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fullname` varchar(40) NOT NULL,            -- Admin Fullname
  `email` varchar(50) NOT NULL,               -- Admin Email Auth
  `password` varchar(255) NOT NULL,           -- Admin Password
  `otp` int(11) NOT NULL DEFAULT 0,           -- Admin OTP
  `session` varchar(100) NOT NULL DEFAULT '', -- Login Session
  `frn` varchar(100) NOT NULL                 -- FRN Generator Iniail Value
);

-- Register Admin
INSERT INTO `admin` (`id`,`fullname`,`email`,`password`,`frn`) VALUES('1', 'Indian Modassir', 'indianmodassir@gmail.com', '$2y$10$Q5n5xmF/DDvWTzo.Gv4uNuQeZWKmKha5oTVPpBALxSSG17WhUbNwW', '100310180359017');

CREATE TABLE `owner`(
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fullname` varchar(40) NOT NULL,                 -- Secretary Fullname
  `number` varchar(50) NOT NULL DEFAULT '',        -- Secretary Number
  `email` varchar(50) NOT NULL,                    -- Secretary Email
  `password` varchar(255) NOT NULL,                -- Secretary Password
  `district` varchar(100) NOT NULL,                -- Secretary District
  `circle` varchar(100) NOT NULL,                  -- Secretary Circle/Block
  `village` varchar(100) NOT NULL,                 -- Secretary Village
  `address` varchar(255) NOT NULL,                 -- Secretary Full Address
  `otp` int(11) NOT NULL DEFAULT 0,                -- Secretary OTP
  `collector_id` varchar(100) NOT NULL DEFAULT '', -- Collector ID of Collector
  `disabled` int(2) NOT NULL DEFAULT 0,            -- Secretary Account Enabled/Disabled
  `access` int(2) NOT NULL DEFAULT 0,              -- Collector Account Access Status
  `collected` int(11) NOT NULL DEFAULT 0,          -- Overall Collection Amount
  `session` varchar(100) NOT NULL DEFAULT ''       -- Login Session
);

CREATE TABLE `spent`(
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `number` varchar(50) NOT NULL,    -- Secretary Number
  `amount` int(11) NOT NULL,        -- Spend Amount
  `describe` varchar(500) NOT NULL, -- Spend Describe
  `date` varchar(100) NOT NULL      -- Spend Date
);

CREATE TABLE `request`(
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fullname` varchar(40) NOT NULL,
  `number` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL,
  `district` varchar(100) NOT NULL,
  `circle` varchar(100) NOT NULL,
  `village` varchar(100) NOT NULL,
  `reqid` varchar(100) NOT NULL,
  `field_verification` varchar(255) NOT NULL DEFAULT '',
  `approval` varchar(255) NOT NULL DEFAULT '',
  `request_date` varchar(100) NOT NULL,
  `approval_date` varchar(100) NOT NULL,
  `forwarded_time` varchar(100) NOT NULL,
  `approval_time` varchar(100) NOT NULL DEFAULT ''
);

CREATE TABLE `collector`(
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `connect_id` varchar(50) NOT NULL,
  `login_code` varchar(50) NOT NULL,
  `session` varchar(100) NOT NULL DEFAULT '',
  `collected` int(11) NOT NULL DEFAULT 0,
  `paid_data` JSON NOT NULL DEFAULT '[]',
  `collected_time` varchar(100) NOT NULL DEFAULT ''
);

CREATE TABLE `member`(
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fullname` varchar(40) NOT NULL,
  `number` varchar(50) NOT NULL,
  `profile` varchar(100) NOT NULL,
  `village` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `last_paid_from` varchar(40) NOT NULL,
  `last_paid_to` varchar(40) NOT NULL,
  `last_date` varchar(40) NOT NULL,
  `last_paid_amount` int(11) NOT NULL,
  `month_index` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `owner_id` varchar(100) NOT NULL
);

CREATE TABLE `member_details`(
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `number` varchar(50) NOT NULL,
  `frn` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `paid_from` varchar(40) NOT NULL,
  `paid_to` varchar(40) NOT NULL,
  `date` varchar(40) NOT NULL,
  `paid_amount` int(11) NOT NULL
);