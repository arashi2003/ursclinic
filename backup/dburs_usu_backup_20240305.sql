

CREATE TABLE `account` (
  `accountid` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` varchar(45) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contactno` varchar(45) NOT NULL,
  `campus` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `datetime_created` datetime NOT NULL,
  `datetime_updated` datetime NOT NULL,
  PRIMARY KEY (`accountid`),
  UNIQUE KEY `accountid_UNIQUE` (`accountid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO account VALUES("B2021-0542","admin","STUDENT","MARK LOURENCE","PATANGAN","QUILAB","quilabmarklourence@gmail.com","09556873950","BINANGONAN","ACTIVE","2023-12-08 02:39:55","2023-12-08 02:39:55");
INSERT INTO account VALUES("B2021-0550","cordero","STUDENT","JOEMARI","VALENCIA","CORDERO","jomcordero7@gmail.com","09475081720","BINANGONAN","ACTIVE","2023-12-08 02:39:55","2023-12-08 02:39:55");
INSERT INTO account VALUES("B2021-0569","admin","STUDENT","JULEANNE ROZIER","","CARANZA","juleannerozier@gmail.com","09677223456","BINANGONAN","ACTIVE","2023-12-07 22:28:01","2024-02-28 12:04:05");
INSERT INTO account VALUES("B2021-0576","bangayan","STUDENT","ALYSSA","BUENO","BANGAYAN","yssabueno04@gmail.com","09214329360","BINANGONAN","ACTIVE","2023-12-08 02:39:55","2023-12-08 02:39:55");
INSERT INTO account VALUES("B2021-0588","ruiz","STUDENT","KIAN JOSHUA","ALLARES","RUIZ","kianruiz824@gmail.com","0920426332","BINANGONAN","ACTIVE","2023-12-08 02:39:55","2023-12-08 02:39:55");
INSERT INTO account VALUES("URS-000","admin","ADMIN","ADMIN","ADMIN","ADMIN","email@gmail.com","09123456789","ANGONO","ACTIVE","2023-12-07 22:15:38","2023-12-07 22:28:01");
INSERT INTO account VALUES("URS-959","admin","ADMIN","JAY","MONTANA","ALLEGRE","email@gmail.com","09123456789","TAYTAY","ACTIVE","2023-12-10 14:42:30","2023-12-10 14:42:30");
INSERT INTO account VALUES("URS-960","dummy","STUDENT","COOKE","CHURCH","MILA","email@gmail.com","09123456789","CARDONA","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-961","dummy","FACULTY","CHASE","STOUT","BELL","email@gmail.com","09123456789","BINANGONAN","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-962","dummy","STAFF","KOLTEN","MOONEY","HAMILTON","email@gmail.com","09123456789","ANGONO","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-963","admin","ADMIN","ARIANA","HICKMAN","BRADSHAW","email@gmail.com","09123456789","ANTIPOLO","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-964","admin","ADMIN","LUNE","HUTCHINSON","WATSON","email@gmail.com","09123456789","TANAY","INACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-965","admin","ADMIN","DALE","WHEELER","HOLMES","email@gmail.com","09123456789","MORONG","INACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-966","admin","ADMIN","BROOKE","MEYER","WILKINS","email@gmail.com","09123456789","PILILLA","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-967","dummy","STAFF","LAILAH","HANSON","FORD","email@gmail.com","09123456789","CARDONA","INACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-968","dummy","STUDENT","JAMIE","TUCKER","NOLAN","email@gmail.com","09123456789","PILILLA","PENDING","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-969","dummy","FACULTY","GABRIELA","LIN","KEEGAN","email@gmail.com","09123456789","CAINTA","INACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-970","dummy","STUDENT","AUDREY","ROY","MCKENZIE","email@gmail.com","09123456789","CAINTA","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-971","dummy","STUDENT","XAVIER","BLANCHARD","PERKINS","email@gmail.com","09123456789","TAYTAY","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-972","dummy","STUDENT","AMAYA","KEY","DAKOTA","email@gmail.com","09123456789","TANAY","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-973","dummy","STUDENT","AMARA","SANFORD","BRADSHAW","email@gmail.com","09123456789","ANTIPOLO","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-974","dummy","STUDENT","ADYSON","ELLIS","CHAPMAN","email@gmail.com","09123456789","MORONG","LOCKED","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-975","dummy","STUDENT","RANDALL","FULLER","COPELAND","email@gmail.com","09123456789","MORONG","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-976","dummy","STUDENT","RULEY","CHAMBERS","TALON","email@gmail.com","09123456789","MORONG","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-977","dummy","STUDENT","RICHARD","ROSARIO","DYER","email@gmail.com","09123456789","RODRIGUEZ","PENDING","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-978","dummy","STAFF","AYLA","MORGAN","PHAM","email@gmail.com","09123456789","RODRIGUEZ","PENDING","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-979","dummy","FACULTY","HARPER","MARTINEZ","SWANSON","email@gmail.com","09123456789","PILILLA","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-980","dummy","STUDENT","RORY","NICHOLAS","MYLES","email@gmail.com","09123456789","RODRIGUEZ","PEDNING","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-981","dummy","STUDENT","WELLS","OCHOA","LUCERO","email@gmail.com","09123456789","RODRIGUEZ","PENDING","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-982","dummy","STAFF","GRANT","MENDOZA","LORENZO","email@gmail.com","09123456789","TAYTAY","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-983","dummy","FACULTY","LOZANO","MEADOWS","ROLANDO","email@gmail.com","09123456789","TANAY","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-984","dummy","FACULTY","KYLER","MIRANDA","VIOLET","email@gmail.com","09123456789","CAINTA","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-985","dummy","STAFF","AYALA","PRIESLY","COLLIN","email@gmail.com","09123456789","CARDONA","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-986","dummy","STUDENT","REYNA","CESAR","POWERS","email@gmail.com","09123456789","ANTIPOLO","ALUMNUS","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-987","dummy","STUDENT","HERBERT","QUINN","TERRELL","email@gmail.com","09123456789","MORONG","ACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-988","dummy","STAFF","BROOKLYN","STANLEY","SAMIR","email@gmail.com","09123456789","BINANGONAN","INACTIVE","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO account VALUES("URS-989","dummy","FACULTY","DAVID","PALAHABRA","DADULA","email@gmail.com","09123456789","TAYTAY","PENDING","2023-12-08 03:12:34","2023-12-08 03:12:34");
INSERT INTO account VALUES("URS-990","dummy","STUDENT","MICHAEL","JACKSON","SPARROW SR.","email@gmail.com","09123456789","TAYTAY","ALUMNUS","2023-12-08 03:12:34","2023-12-08 03:12:34");
INSERT INTO account VALUES("URS-991","dummy","STUDENT","EMMA","AIDEN","GRACE","email@gmail.com","09123456789","TANAY","ALUMNUS","2023-12-08 03:12:34","2023-12-08 03:12:34");
INSERT INTO account VALUES("URS-992","dummy","FACULTY","JUAN","DELA CRUZ","CENTEDA","email@gmail.com","09123456789","PILILLA","INACTIVE","2023-12-08 03:12:34","2023-12-08 03:12:34");
INSERT INTO account VALUES("URS-993","dummy","STUDENT","ELIZABETH ALEXANDRA MARY","","WINDSOR II","email@gmail.com","09123456789","ANGONO","INACTIVE","2023-12-08 03:12:34","2023-12-08 03:12:34");
INSERT INTO account VALUES("URS-994","admin","ADMIN","BARBARA","MILLICENT","ROBERTS","email@gmail.com","09123456789","CARDONA","INACTIVE","2023-12-08 03:12:34","2023-12-08 03:12:34");
INSERT INTO account VALUES("URS-995","admin","ADMIN","ADA","BYRON","LOVELACE","email@gmail.com","09123456789","CAINTA","INACTIVE","2023-12-08 03:12:34","2023-12-08 03:12:34");
INSERT INTO account VALUES("URS-996","dummy","STAFF","RHAENYRA","","TARGARYEN","email@gmail.com","09123456789","ANTIPOLO","INACTIVE","2023-12-08 03:12:34","2023-12-08 03:12:34");
INSERT INTO account VALUES("URS-997","dummy","STAFF","TOM","MARVOLO","RIDDLE","email@gmail.com","09123456789","MORONG","LOCKED","2023-12-08 03:12:34","2023-12-08 03:12:34");
INSERT INTO account VALUES("URS-998","admin","ADMIN","JOCELYN","","FLORES","email@gmail.com","09123456789","RODRIGUEZ","LOCKED","2023-12-08 03:12:34","2023-12-08 03:12:34");
INSERT INTO account VALUES("URS-999","admin","ADMIN","ALLEN","JANE","CALEJO","email@gmail.com","09123456789","BINANGONAN","ACTIVE","2023-12-08 02:46:01","2024-02-28 11:45:36");
INSERT INTO account VALUES("URSD-001","maycacayan","DOCTOR","EDNA","C","MAYCACAYAN","email@gmail.com","09123456789","ALL","ACTIVE","2023-12-08 02:39:55","2023-12-08 02:46:01");
INSERT INTO account VALUES("URSD-002","admin","DENTIST","GODWIN","A","OLIVAS","email@gmail.com","09123456789","ALL","ACTIVE","2023-12-13 14:26:35","2023-12-13 14:26:35");
INSERT INTO account VALUES("URSF-000","admin","FACULTY","EDEN","C","SANTOS","email@gmail.com","09123456789","BINANGONAN","ACTIVE","2023-12-08 02:46:01","2023-12-08 02:46:01");
INSERT INTO account VALUES("URSN-001","admin","NURSE","DIOSA","A","SALVADOR","email@gmail.com","09123456789","BINANGONAN","ACTIVE","2023-12-08 02:39:55","2024-02-28 12:02:13");
INSERT INTO account VALUES("URSN-002","castro","NURSE","MARY ANN","V","CASTRO","email@gmail.com","09123456789","BINANGONAN","ACTIVE","2023-12-08 02:39:55","2023-12-08 02:46:01");



CREATE TABLE `appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `physician` varchar(200) DEFAULT NULL,
  `patient` varchar(45) NOT NULL,
  `type` int(11) NOT NULL,
  `purpose` int(11) NOT NULL,
  `chiefcomplaint` text DEFAULT NULL,
  `others` varchar(50) DEFAULT NULL,
  `status` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `patient_idx` (`patient`),
  KEY `type_idx` (`type`),
  KEY `purpose_idx` (`purpose`),
  CONSTRAINT `patient` FOREIGN KEY (`patient`) REFERENCES `account` (`accountid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO appointment VALUES("2","2023-12-11","08:00:00","08:15:00","NONE","B2021-0576","0","0","","","PENDING","2023-12-10 00:00:00");
INSERT INTO appointment VALUES("3","2023-12-11","08:45:00","09:00:00","NONE","B2021-0588","0","0","","","PENDING","2023-12-10 00:00:00");
INSERT INTO appointment VALUES("4","2023-12-11","09:20:00","09:40:00","NONE","B2021-0550","3","7","","","COMPLETED","2023-12-10 00:00:00");
INSERT INTO appointment VALUES("7","2023-12-11","14:30:00","15:00:00","EDNA C. MAYCACAYAN","URS-993","0","0","","","DISAPPROVED","2023-12-10 00:00:00");
INSERT INTO appointment VALUES("9","2023-12-12","16:00:00","16:10:00","NONE","URS-992","0","0","Headache","","Approved","2023-12-10 00:00:00");
INSERT INTO appointment VALUES("10","2023-01-08","09:00:00","09:45:00","GODWIN A. OLIVAS","B2021-0569","0","0","Headache, Toothache","","APPROVED","2023-12-13 00:00:00");
INSERT INTO appointment VALUES("11","2023-01-04","08:00:00","08:05:00","NONE","B2021-0576","0","0","","","APPROVED","2023-12-13 00:00:00");
INSERT INTO appointment VALUES("12","2023-01-04","08:05:00","08:10:00","NONE","B2021-0588","0","0","","","APPROVED","2023-12-13 00:00:00");
INSERT INTO appointment VALUES("13","2023-01-08","14:30:00","15:00:00","GODWIN A. OLIVAS","B2021-0550","0","0","Others: Wisdom Tooth Extraction","","APPROVED","2023-12-13 00:00:00");
INSERT INTO appointment VALUES("14","2023-01-04","08:15:00","08:20:00","NONE","B2021-0542","1","3","","","APPROVED","2023-12-13 00:00:00");
INSERT INTO appointment VALUES("17","2023-01-08","08:35:00","08:40:00","NONE","URSF-000","0","0","","","CANCELLED","2023-12-13 00:00:00");
INSERT INTO appointment VALUES("18","2023-01-09","08:40:00","08:45:00","EDNA C. MAYCACAYAN","URS-992","0","0","","","APPROVED","2023-12-13 00:00:00");
INSERT INTO appointment VALUES("19","2023-01-10","15:00:00","15:15:00","NONE","B2021-0569","0","0","Others: For Student-Athlete Requirement","","CANCELLED","2023-12-13 00:00:00");
INSERT INTO appointment VALUES("20","2024-01-30","10:30:00","11:00:00","GODWIN A. OLIVAS","B2021-0542","2","3","Toothache","","COMPLETED","2024-01-30 22:57:16");
INSERT INTO appointment VALUES("21","2024-01-30","10:30:00","11:00:00","GODWIN A. OLIVAS","B2021-0542","2","3","Toothache","","COMPLETED","2024-01-30 22:59:16");
INSERT INTO appointment VALUES("22","2024-01-30","10:30:00","11:00:00","EDNA C. MAYCACAYAN","B2021-0542","2","7","Others","butt hurt","PENDING","2024-01-30 22:59:51");
INSERT INTO appointment VALUES("23","2023-12-11","14:00:00","14:30:00","EDNA C. MAYCACAYAN","B2021-0542","1","3","","","DISAPPROVED","2023-12-10 00:00:00");
INSERT INTO appointment VALUES("25","2024-01-30","10:30:00","11:00:00","EDNA C. MAYCACAYAN","B2021-0542","1","2","Abdominal pain","","PENDING","2024-02-07 20:10:49");
INSERT INTO appointment VALUES("26","2024-01-30","10:30:00","11:00:00","GODWIN A. OLIVAS","B2021-0542","1","1","Sprain","","PENDING","2024-02-14 22:53:11");
INSERT INTO appointment VALUES("27","2024-01-30","10:30:00","11:00:00","EDNA C. MAYCACAYAN","B2021-0542","1","1","Flu","","PENDING","2024-02-15 01:39:57");



CREATE TABLE `appointment_cc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purpose` int(11) NOT NULL,
  `chief_complaint` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `purpose` (`purpose`),
  CONSTRAINT `appointment_cc_ibfk_1` FOREIGN KEY (`purpose`) REFERENCES `appointment_purpose` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO appointment_cc VALUES("1","6","Toothache");
INSERT INTO appointment_cc VALUES("5","2","Abdominal pain");
INSERT INTO appointment_cc VALUES("6","2","Allergy");
INSERT INTO appointment_cc VALUES("7","2","Asthma");
INSERT INTO appointment_cc VALUES("8","2","Back pain");
INSERT INTO appointment_cc VALUES("9","2","Chest pain");
INSERT INTO appointment_cc VALUES("10","2","Cold");
INSERT INTO appointment_cc VALUES("11","2","Constipation");
INSERT INTO appointment_cc VALUES("12","2","Cough");
INSERT INTO appointment_cc VALUES("13","2","Diarrhea");
INSERT INTO appointment_cc VALUES("14","2","Difficulty in breathing");
INSERT INTO appointment_cc VALUES("15","2","Dizziness");
INSERT INTO appointment_cc VALUES("16","2","Dysmenorrhea");
INSERT INTO appointment_cc VALUES("17","2","Fever");
INSERT INTO appointment_cc VALUES("18","2","Flu");
INSERT INTO appointment_cc VALUES("19","2","Headache");
INSERT INTO appointment_cc VALUES("20","2","Heart burn");
INSERT INTO appointment_cc VALUES("21","2","Injury");
INSERT INTO appointment_cc VALUES("22","2","Muscle pain");
INSERT INTO appointment_cc VALUES("23","2","Nausea");
INSERT INTO appointment_cc VALUES("24","2","Neck pain");
INSERT INTO appointment_cc VALUES("25","2","Rash");
INSERT INTO appointment_cc VALUES("26","2","Sprain");
INSERT INTO appointment_cc VALUES("27","2","Stomach ache");
INSERT INTO appointment_cc VALUES("28","2","Toothache");
INSERT INTO appointment_cc VALUES("29","2","Vomiting");
INSERT INTO appointment_cc VALUES("30","2","Others");
INSERT INTO appointment_cc VALUES("31","3","Abdominal pain");
INSERT INTO appointment_cc VALUES("32","3","Allergy");
INSERT INTO appointment_cc VALUES("33","3","Asthma");
INSERT INTO appointment_cc VALUES("34","3","Back pain");
INSERT INTO appointment_cc VALUES("35","3","Chest pain");
INSERT INTO appointment_cc VALUES("36","3","Cold");
INSERT INTO appointment_cc VALUES("37","3","Constipation");
INSERT INTO appointment_cc VALUES("38","3","Cough");
INSERT INTO appointment_cc VALUES("39","3","Diarrhea");
INSERT INTO appointment_cc VALUES("40","3","Difficulty in breathing");
INSERT INTO appointment_cc VALUES("41","3","Dizziness");
INSERT INTO appointment_cc VALUES("42","3","Dysmenorrhea");
INSERT INTO appointment_cc VALUES("43","3","Fever");
INSERT INTO appointment_cc VALUES("44","3","Flu");
INSERT INTO appointment_cc VALUES("45","3","Headache");
INSERT INTO appointment_cc VALUES("46","3","Heart burn");
INSERT INTO appointment_cc VALUES("47","3","Injury");
INSERT INTO appointment_cc VALUES("48","3","Muscle pain");
INSERT INTO appointment_cc VALUES("49","3","Nausea");
INSERT INTO appointment_cc VALUES("50","3","Neck pain");
INSERT INTO appointment_cc VALUES("51","3","Rash");
INSERT INTO appointment_cc VALUES("52","3","Sprain");
INSERT INTO appointment_cc VALUES("53","3","Stomach ache");
INSERT INTO appointment_cc VALUES("54","3","Toothache");
INSERT INTO appointment_cc VALUES("55","3","Vomiting");
INSERT INTO appointment_cc VALUES("56","3","Others");
INSERT INTO appointment_cc VALUES("57","4","Abdominal pain");
INSERT INTO appointment_cc VALUES("58","4","Allergy");
INSERT INTO appointment_cc VALUES("59","4","Asthma");
INSERT INTO appointment_cc VALUES("60","4","Back pain");
INSERT INTO appointment_cc VALUES("61","4","Chest pain");
INSERT INTO appointment_cc VALUES("62","4","Cold");
INSERT INTO appointment_cc VALUES("63","4","Constipation");
INSERT INTO appointment_cc VALUES("64","4","Cough");
INSERT INTO appointment_cc VALUES("65","4","Diarrhea");
INSERT INTO appointment_cc VALUES("66","4","Difficulty in breathing");
INSERT INTO appointment_cc VALUES("67","4","Dizziness");
INSERT INTO appointment_cc VALUES("68","4","Dysmenorrhea");
INSERT INTO appointment_cc VALUES("69","4","Fever");
INSERT INTO appointment_cc VALUES("70","4","Flu");
INSERT INTO appointment_cc VALUES("71","4","Headache");
INSERT INTO appointment_cc VALUES("72","4","Heart burn");
INSERT INTO appointment_cc VALUES("73","4","Injury");
INSERT INTO appointment_cc VALUES("74","4","Muscle pain");
INSERT INTO appointment_cc VALUES("75","4","Nausea");
INSERT INTO appointment_cc VALUES("76","4","Neck pain");
INSERT INTO appointment_cc VALUES("77","4","Rash");
INSERT INTO appointment_cc VALUES("78","4","Sprain");
INSERT INTO appointment_cc VALUES("79","4","Stomach ache");
INSERT INTO appointment_cc VALUES("80","4","Toothache");
INSERT INTO appointment_cc VALUES("81","4","Vomiting");
INSERT INTO appointment_cc VALUES("82","4","Others");
INSERT INTO appointment_cc VALUES("83","5","Others");
INSERT INTO appointment_cc VALUES("84","6","Others");
INSERT INTO appointment_cc VALUES("85","7","Others");
INSERT INTO appointment_cc VALUES("86","8","Toothache");
INSERT INTO appointment_cc VALUES("87","8","Others");
INSERT INTO appointment_cc VALUES("88","9","Toothache");
INSERT INTO appointment_cc VALUES("89","9","Others");
INSERT INTO appointment_cc VALUES("90","10","Toothache");
INSERT INTO appointment_cc VALUES("91","10","Others");
INSERT INTO appointment_cc VALUES("92","11","Toothache");
INSERT INTO appointment_cc VALUES("93","11","Others");
INSERT INTO appointment_cc VALUES("94","1","Abdominal pain");
INSERT INTO appointment_cc VALUES("95","1","Allergy");
INSERT INTO appointment_cc VALUES("96","1","Asthma");
INSERT INTO appointment_cc VALUES("97","1","Back pain");
INSERT INTO appointment_cc VALUES("98","1","Chest pain");
INSERT INTO appointment_cc VALUES("99","1","Cold");
INSERT INTO appointment_cc VALUES("100","1","Constipation");
INSERT INTO appointment_cc VALUES("101","1","Cough");
INSERT INTO appointment_cc VALUES("102","1","Diarrhea");
INSERT INTO appointment_cc VALUES("103","1","Difficulty in breathing");
INSERT INTO appointment_cc VALUES("104","1","Dizziness");
INSERT INTO appointment_cc VALUES("105","1","Dysmenorrhea");
INSERT INTO appointment_cc VALUES("106","1","Fever");
INSERT INTO appointment_cc VALUES("107","1","Flu");
INSERT INTO appointment_cc VALUES("108","1","Headache");
INSERT INTO appointment_cc VALUES("109","1","Heart burn");
INSERT INTO appointment_cc VALUES("110","1","Injury");
INSERT INTO appointment_cc VALUES("111","1","Muscle pain");
INSERT INTO appointment_cc VALUES("112","1","Nausea");
INSERT INTO appointment_cc VALUES("113","1","Neck pain");
INSERT INTO appointment_cc VALUES("114","1","Rash");
INSERT INTO appointment_cc VALUES("115","1","Sprain");
INSERT INTO appointment_cc VALUES("116","1","Stomach ache");
INSERT INTO appointment_cc VALUES("117","1","Toothache");
INSERT INTO appointment_cc VALUES("118","1","Vomiting");
INSERT INTO appointment_cc VALUES("119","1","Others");



CREATE TABLE `appointment_physician` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO appointment_physician VALUES("1","EDNA","C","MAYCACAYAN");
INSERT INTO appointment_physician VALUES("2","GODWIN","A","OLIVAS");



CREATE TABLE `appointment_purpose` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `purpose` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_idx` (`type`),
  CONSTRAINT `type` FOREIGN KEY (`type`) REFERENCES `appointment_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO appointment_purpose VALUES("1","1","General");
INSERT INTO appointment_purpose VALUES("2","1","Freshmen");
INSERT INTO appointment_purpose VALUES("3","1","OJT/SIT/WAP");
INSERT INTO appointment_purpose VALUES("4","1","ROTC");
INSERT INTO appointment_purpose VALUES("5","1","Others: BP/Ht/RBS/Wt Monitoring");
INSERT INTO appointment_purpose VALUES("6","2","Dental");
INSERT INTO appointment_purpose VALUES("7","2","Medical");
INSERT INTO appointment_purpose VALUES("8","3"," Tooth Restoration");
INSERT INTO appointment_purpose VALUES("9","3","Periodontal Treatment");
INSERT INTO appointment_purpose VALUES("10","3","Oral Prophylaxis");
INSERT INTO appointment_purpose VALUES("11","3","Tooth Extraction");



CREATE TABLE `appointment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO appointment_type VALUES("1","Checkup");
INSERT INTO appointment_type VALUES("2","Consultation");
INSERT INTO appointment_type VALUES("3","Dental");



CREATE TABLE `audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(45) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `campus` varchar(45) NOT NULL,
  `activity` varchar(200) NOT NULL,
  `status` varchar(45) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_idx` (`user`),
  CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `account` (`accountid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=922 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO audit_trail VALUES("1","URS-000","","","added an account","unread","2023-12-07 22:15:38");
INSERT INTO audit_trail VALUES("2","URS-000","","","added an account","unread","2023-12-07 22:28:01");
INSERT INTO audit_trail VALUES("3","URS-000","","","added an account status","unread","2023-12-07 22:13:38");
INSERT INTO audit_trail VALUES("4","URS-000","","","added an account status","unread","2023-12-07 22:13:38");
INSERT INTO audit_trail VALUES("5","URS-000","","","added an account status","unread","2023-12-07 22:13:38");
INSERT INTO audit_trail VALUES("6","URS-000","","","added an account status","unread","2023-12-07 22:13:38");
INSERT INTO audit_trail VALUES("7","URS-000","","","logged in","unread","2023-12-07 22:08:59");
INSERT INTO audit_trail VALUES("8","URS-000","","","logged out","unread","2023-12-07 23:09:59");
INSERT INTO audit_trail VALUES("9","URS-000","","","logged in","unread","2023-12-07 23:16:46");
INSERT INTO audit_trail VALUES("10","URS-000","","","added an account status","unread","2023-12-07 23:17:16");
INSERT INTO audit_trail VALUES("22","URS-000","","","added a campus","unread","2023-12-07 23:22:33");
INSERT INTO audit_trail VALUES("23","URS-000","","","added a campus","unread","2023-12-07 23:22:33");
INSERT INTO audit_trail VALUES("24","URS-000","","","added a campus","unread","2023-12-07 23:22:33");
INSERT INTO audit_trail VALUES("25","URS-000","","","added a campus","unread","2023-12-07 23:22:33");
INSERT INTO audit_trail VALUES("26","URS-000","","","added a campus","unread","2023-12-07 23:22:33");
INSERT INTO audit_trail VALUES("27","URS-000","","","added a campus","unread","2023-12-07 23:22:33");
INSERT INTO audit_trail VALUES("28","URS-000","","","added a campus","unread","2023-12-07 23:22:33");
INSERT INTO audit_trail VALUES("29","URS-000","","","added a campus","unread","2023-12-07 23:22:33");
INSERT INTO audit_trail VALUES("30","URS-000","","","added a campus","unread","2023-12-07 23:22:33");
INSERT INTO audit_trail VALUES("31","URS-000","","","added a campus","unread","2023-12-07 23:22:33");
INSERT INTO audit_trail VALUES("32","URS-000","","","added a campus","unread","2023-12-07 23:22:33");
INSERT INTO audit_trail VALUES("33","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("34","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("35","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("36","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("37","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("38","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("39","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("40","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("41","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("42","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("43","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("44","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("45","URS-000","","","added  a college","unread","2023-12-07 23:28:03");
INSERT INTO audit_trail VALUES("46","URS-000","","","added a department","unread","2023-12-07 23:31:32");
INSERT INTO audit_trail VALUES("47","URS-000","","","added a department","unread","2023-12-07 23:31:32");
INSERT INTO audit_trail VALUES("48","URS-000","","","added a department","unread","2023-12-07 23:31:32");
INSERT INTO audit_trail VALUES("49","URS-000","","","added a department","unread","2023-12-07 23:31:32");
INSERT INTO audit_trail VALUES("50","URS-000","","","added a department","unread","2023-12-07 23:31:32");
INSERT INTO audit_trail VALUES("51","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("52","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("53","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("54","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("55","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("56","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("57","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("58","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("59","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("60","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("61","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("62","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("63","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("64","URS-000","","","added a yearlevel","unread","2023-12-08 00:28:39");
INSERT INTO audit_trail VALUES("65","URS-000","","","removed a college","unread","2023-12-08 00:31:05");
INSERT INTO audit_trail VALUES("66","URS-000","","","removed a department","unread","2023-12-08 00:31:05");
INSERT INTO audit_trail VALUES("67","URS-000","","","added a designation","unread","2023-12-08 00:33:29");
INSERT INTO audit_trail VALUES("68","URS-000","","","added a designation","unread","2023-12-08 00:33:29");
INSERT INTO audit_trail VALUES("69","URS-000","","","added a designation","unread","2023-12-08 00:33:29");
INSERT INTO audit_trail VALUES("70","URS-000","","","added a designation","unread","2023-12-08 00:33:29");
INSERT INTO audit_trail VALUES("71","URS-000","","","added a dosage form","unread","2023-12-08 00:36:50");
INSERT INTO audit_trail VALUES("72","URS-000","","","added a dosage form","unread","2023-12-08 00:36:50");
INSERT INTO audit_trail VALUES("73","URS-000","","","added a dosage form","unread","2023-12-08 00:36:50");
INSERT INTO audit_trail VALUES("74","URS-000","","","added a dosage form","unread","2023-12-08 00:36:50");
INSERT INTO audit_trail VALUES("75","URS-000","","","added a dosage form","unread","2023-12-08 00:36:50");
INSERT INTO audit_trail VALUES("76","URS-000","","","added a dosage form","unread","2023-12-08 00:36:50");
INSERT INTO audit_trail VALUES("77","URS-000","","","added a dosage form","unread","2023-12-08 00:36:50");
INSERT INTO audit_trail VALUES("78","URS-000","","","added a dosage form","unread","2023-12-08 00:36:50");
INSERT INTO audit_trail VALUES("79","URS-000","","","added a dosage form","unread","2023-12-08 00:36:50");
INSERT INTO audit_trail VALUES("80","URS-000","","","added a dosage form","unread","2023-12-08 00:36:50");
INSERT INTO audit_trail VALUES("81","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("82","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("83","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("84","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("85","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("86","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("87","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("88","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("89","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("90","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("91","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("92","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("93","URS-000","","","added a medicine administration","unread","2023-12-08 00:41:29");
INSERT INTO audit_trail VALUES("94","URS-000","","","added a medical case","unread","2023-12-08 00:48:55");
INSERT INTO audit_trail VALUES("95","URS-000","","","added a medical case","unread","2023-12-08 00:48:55");
INSERT INTO audit_trail VALUES("96","URS-000","","","added a medical case","unread","2023-12-08 00:48:55");
INSERT INTO audit_trail VALUES("97","URS-000","","","added a medical case","unread","2023-12-08 00:48:55");
INSERT INTO audit_trail VALUES("98","URS-000","","","added a medical case","unread","2023-12-08 00:48:55");
INSERT INTO audit_trail VALUES("99","URS-000","","","added a medical case","unread","2023-12-08 00:48:56");
INSERT INTO audit_trail VALUES("100","URS-000","","","added a medical case","unread","2023-12-08 00:48:56");
INSERT INTO audit_trail VALUES("101","URS-000","","","added a medical case","unread","2023-12-08 00:48:56");
INSERT INTO audit_trail VALUES("102","URS-000","","","added a medical case","unread","2023-12-08 00:48:56");
INSERT INTO audit_trail VALUES("103","URS-000","","","added a medical case","unread","2023-12-08 00:48:56");
INSERT INTO audit_trail VALUES("104","URS-000","","","added a medical case","unread","2023-12-08 00:48:56");
INSERT INTO audit_trail VALUES("105","URS-000","","","added a program","unread","2023-12-08 01:04:28");
INSERT INTO audit_trail VALUES("106","URS-000","","","added a program","unread","2023-12-08 01:04:28");
INSERT INTO audit_trail VALUES("107","URS-000","","","added a program","unread","2023-12-08 01:04:28");
INSERT INTO audit_trail VALUES("108","URS-000","","","added a program","unread","2023-12-08 01:04:28");
INSERT INTO audit_trail VALUES("109","URS-000","","","added a program","unread","2023-12-08 01:04:28");
INSERT INTO audit_trail VALUES("110","URS-000","","","added a program","unread","2023-12-08 01:04:28");
INSERT INTO audit_trail VALUES("111","URS-000","","","added a program","unread","2023-12-08 01:04:28");
INSERT INTO audit_trail VALUES("112","URS-000","","","added a program","unread","2023-12-08 01:04:28");
INSERT INTO audit_trail VALUES("113","URS-000","","","added a type of  medical document","unread","2023-12-08 01:07:53");
INSERT INTO audit_trail VALUES("114","URS-000","","","added a type of  medical document","unread","2023-12-08 01:07:53");
INSERT INTO audit_trail VALUES("115","URS-000","","","added a type of  medical document","unread","2023-12-08 01:07:53");
INSERT INTO audit_trail VALUES("116","URS-000","","","added a type of  medical document","unread","2023-12-08 01:07:53");
INSERT INTO audit_trail VALUES("117","URS-000","","","added a tools and equipment status","unread","2023-12-08 01:13:18");
INSERT INTO audit_trail VALUES("118","URS-000","","","added a tools and equipment status","unread","2023-12-08 01:13:18");
INSERT INTO audit_trail VALUES("119","URS-000","","","added a tools and equipment status","unread","2023-12-08 01:13:18");
INSERT INTO audit_trail VALUES("120","URS-000","","","added a tools and equipment status","unread","2023-12-08 01:13:18");
INSERT INTO audit_trail VALUES("121","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("122","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("123","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("124","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("125","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("126","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("127","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("128","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("129","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("130","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("131","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("132","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("133","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("134","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("135","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("136","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("137","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("138","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("139","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("140","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("141","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("142","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("143","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("144","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("145","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("146","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("147","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("148","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("149","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("150","URS-000","","","added a unit measure","unread","2023-12-08 01:42:52");
INSERT INTO audit_trail VALUES("151","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("152","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("153","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("154","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("155","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("156","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("157","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("158","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("159","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("160","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("161","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("162","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("163","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("164","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("165","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("166","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("167","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("168","URS-000","","","added a findings/diagnosis","unread","2023-12-08 01:48:39");
INSERT INTO audit_trail VALUES("169","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("170","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("171","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("172","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("173","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("174","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("175","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("176","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("177","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("178","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("179","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("180","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("181","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("182","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("183","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("184","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("185","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("186","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("187","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("188","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("189","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("190","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("191","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("192","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("193","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("194","URS-000","","","added a chief complaint","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("195","URS-000","","","added a medical document status","unread","2023-12-08 01:55:29");
INSERT INTO audit_trail VALUES("196","URS-000","","","added a medical document status","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("197","URS-000","","","added a medical document status","unread","2023-12-08 01:54:17");
INSERT INTO audit_trail VALUES("198","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("199","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("200","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("201","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("202","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("203","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("204","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("205","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("206","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("207","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("208","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("209","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("210","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("211","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("212","URS-000","","","added a type of transaction","unread","2023-12-08 02:12:59");
INSERT INTO audit_trail VALUES("213","URS-000","","","logged out","unread","2023-12-08 02:13:23");
INSERT INTO audit_trail VALUES("214","URS-000","","","logged in","unread","2023-12-08 02:37:13");
INSERT INTO audit_trail VALUES("215","URS-000","","","added an account","unread","2023-12-08 02:39:55");
INSERT INTO audit_trail VALUES("216","URS-000","","","added an account","unread","2023-12-08 02:39:55");
INSERT INTO audit_trail VALUES("217","URS-000","","","added an account","unread","2023-12-08 02:39:55");
INSERT INTO audit_trail VALUES("218","URS-000","","","added an account","unread","2023-12-08 02:39:55");
INSERT INTO audit_trail VALUES("219","URS-000","","","added an account","unread","2023-12-08 02:39:55");
INSERT INTO audit_trail VALUES("220","URS-000","","","added an account","unread","2023-12-08 02:39:55");
INSERT INTO audit_trail VALUES("221","URS-000","","","added an account","unread","2023-12-08 02:39:55");
INSERT INTO audit_trail VALUES("222","URS-000","","","added an account","unread","2023-12-08 02:46:01");
INSERT INTO audit_trail VALUES("223","URS-000","","","added an account","unread","2023-12-08 02:46:01");
INSERT INTO audit_trail VALUES("224","URS-000","","","updated account details of URSD-001","unread","2023-12-08 02:46:01");
INSERT INTO audit_trail VALUES("225","URS-000","","","updated account details of URSN-001","unread","2023-12-08 02:46:01");
INSERT INTO audit_trail VALUES("226","URS-000","","","updated account details of URSN-002","unread","2023-12-08 02:46:01");
INSERT INTO audit_trail VALUES("227","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("228","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("229","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("230","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("231","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("232","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("233","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("234","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("235","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("236","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("237","URS-000","","","logged out","unread","2023-12-08 03:12:48");
INSERT INTO audit_trail VALUES("238","URS-000","","","logged in","unread","2023-12-08 10:08:45");
INSERT INTO audit_trail VALUES("239","URS-000","","","visited Transaction Page","unread","2023-12-08 10:08:56");
INSERT INTO audit_trail VALUES("240","URS-000","","","added a medical record","unread","2023-12-08 16:17:15");
INSERT INTO audit_trail VALUES("241","URS-000","","","added a medical record","unread","2023-12-08 16:48:36");
INSERT INTO audit_trail VALUES("242","URS-000","","","updated account details of URS-990","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("243","URS-000","","","updated account details of URS-990","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("244","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("245","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("246","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("247","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("248","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("249","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("250","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("251","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("252","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("253","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("254","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("255","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("256","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("257","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("258","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("259","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("260","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("261","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("262","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("263","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("264","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("265","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("266","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("267","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("268","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("269","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("270","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("271","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("272","URS-000","","","added an account","unread","2023-12-08 03:12:34");
INSERT INTO audit_trail VALUES("273","URS-000","","","logged out","unread","2023-12-08 03:12:47");
INSERT INTO audit_trail VALUES("274","URS-000","","","visited the User Accounts Page","unread","2023-12-08 02:48:07");
INSERT INTO audit_trail VALUES("275","URS-000","","","logged in","unread","2023-12-09 14:31:45");
INSERT INTO audit_trail VALUES("276","URS-000","","","visited Settings Page","unread","2023-12-09 14:32:10");
INSERT INTO audit_trail VALUES("277","URS-000","","","added an entry to organization","unread","2023-12-09 14:51:12");
INSERT INTO audit_trail VALUES("278","URS-000","","","added an entry to organization","unread","2023-12-09 14:51:12");
INSERT INTO audit_trail VALUES("279","URS-000","","","added an entry to organization","unread","2023-12-09 14:51:12");
INSERT INTO audit_trail VALUES("280","URS-000","","","added an entry to organization","unread","2023-12-09 14:51:12");
INSERT INTO audit_trail VALUES("281","URS-000","","","added a unit measure","unread","2023-12-09 15:05:29");
INSERT INTO audit_trail VALUES("282","URS-000","","","added a dosage form","unread","2023-12-09 15:11:02");
INSERT INTO audit_trail VALUES("283","URS-000","","","added a unit measure","unread","2023-12-09 15:14:32");
INSERT INTO audit_trail VALUES("284","URS-000","","","added a dosage form","unread","2023-12-09 16:02:05");
INSERT INTO audit_trail VALUES("285","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("286","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("287","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("288","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("289","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("290","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("291","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("292","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("293","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("294","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("295","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("296","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("297","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("298","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("299","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("300","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("301","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("302","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("303","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("304","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("305","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("306","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("307","URS-000","","","added a medicine","unread","2023-12-09 16:06:59");
INSERT INTO audit_trail VALUES("308","URS-000","","","logged out","unread","2023-12-09 17:09:47");
INSERT INTO audit_trail VALUES("309","URS-000","","","logged in","unread","2023-12-09 18:10:30");
INSERT INTO audit_trail VALUES("310","URS-000","","","visited Settings Page","unread","2023-12-09 18:11:56");
INSERT INTO audit_trail VALUES("311","URS-000","","","viseted Inventory Page","unread","2023-12-09 16:01:23");
INSERT INTO audit_trail VALUES("312","URS-000","","","added a unit measure","unread","2023-12-09 18:12:28");
INSERT INTO audit_trail VALUES("313","URS-000","","","added a unit measure","unread","2023-12-09 19:25:45");
INSERT INTO audit_trail VALUES("314","URS-000","","","added a unit measure","unread","2023-12-09 19:34:36");
INSERT INTO audit_trail VALUES("315","URS-000","","","visited Settings Page","unread","2023-12-09 17:39:09");
INSERT INTO audit_trail VALUES("316","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("317","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("318","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("319","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("320","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("321","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("322","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("323","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("324","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("325","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("326","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("327","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("328","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("329","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("330","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("331","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("332","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("333","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("334","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("335","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("336","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("337","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("338","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("339","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("340","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("341","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("342","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("343","URS-000","","","added a supply","unread","2023-12-09 19:43:39");
INSERT INTO audit_trail VALUES("344","URS-000","","","visited Inventory Page","unread","2023-12-09 19:38:23");
INSERT INTO audit_trail VALUES("345","URS-000","","","added a supply","unread","2023-12-09 19:54:04");
INSERT INTO audit_trail VALUES("346","URS-000","","","added a supply","unread","2023-12-09 19:57:12");
INSERT INTO audit_trail VALUES("347","URS-000","","","added a supply","unread","2023-12-09 19:57:12");
INSERT INTO audit_trail VALUES("348","URS-000","","","added a supply","unread","2023-12-09 20:00:21");
INSERT INTO audit_trail VALUES("349","URS-000","","","added a supply","unread","2023-12-09 20:00:21");
INSERT INTO audit_trail VALUES("350","URS-000","","","added a supply","unread","2023-12-09 20:00:21");
INSERT INTO audit_trail VALUES("351","URS-000","","","visited Settings Page","unread","2023-12-09 20:06:27");
INSERT INTO audit_trail VALUES("352","URS-000","","","added a unit measure","unread","2023-12-09 20:07:28");
INSERT INTO audit_trail VALUES("353","URS-000","","","added a unit measure","unread","2023-12-09 20:07:28");
INSERT INTO audit_trail VALUES("354","URS-000","","","visited Inventory Page","unread","2023-12-09 20:07:28");
INSERT INTO audit_trail VALUES("355","URS-000","","","added a supply","unread","2023-12-09 20:11:20");
INSERT INTO audit_trail VALUES("356","URS-000","","","added a supply","unread","2023-12-09 20:11:20");
INSERT INTO audit_trail VALUES("357","URS-000","","","added a supply","unread","2023-12-09 20:11:20");
INSERT INTO audit_trail VALUES("358","URS-000","","","added a supply","unread","2023-12-09 20:11:20");
INSERT INTO audit_trail VALUES("359","URS-000","","","added a tool/equipment","unread","2023-12-09 20:16:59");
INSERT INTO audit_trail VALUES("360","URS-000","","","added a tool/equipment","unread","2023-12-09 20:16:59");
INSERT INTO audit_trail VALUES("361","URS-000","","","added a tool/equipment","unread","2023-12-09 20:16:59");
INSERT INTO audit_trail VALUES("362","URS-000","","","added a tool/equipment","unread","2023-12-09 20:16:59");
INSERT INTO audit_trail VALUES("363","URS-000","","","added a tool/equipment","unread","2023-12-09 20:16:59");
INSERT INTO audit_trail VALUES("364","URS-000","","","added a tool/equipment","unread","2023-12-09 20:16:59");
INSERT INTO audit_trail VALUES("365","URS-000","","","added a tool/equipment","unread","2023-12-09 20:16:59");
INSERT INTO audit_trail VALUES("366","URS-000","","","added a tool/equipment","unread","2023-12-09 20:16:59");
INSERT INTO audit_trail VALUES("367","URS-000","","","added a tool/equipment","unread","2023-12-09 20:16:59");
INSERT INTO audit_trail VALUES("368","URS-000","","","added a tool/equipment","unread","2023-12-09 20:16:59");
INSERT INTO audit_trail VALUES("369","URS-000","","","added a tool/equipment","unread","2023-12-09 20:16:59");
INSERT INTO audit_trail VALUES("370","URS-000","","","logged out","unread","2023-12-09 20:17:18");
INSERT INTO audit_trail VALUES("371","URS-000","","","logged in","unread","2023-12-10 14:25:45");
INSERT INTO audit_trail VALUES("372","URS-000","","","visited Settings Page","unread","2023-12-10 14:26:40");
INSERT INTO audit_trail VALUES("373","URS-000","","","added a department","unread","2023-12-10 14:27:04");
INSERT INTO audit_trail VALUES("374","URS-000","","","added a year level","unread","2023-12-10 14:31:34");
INSERT INTO audit_trail VALUES("375","URS-000","","","added a year level","unread","2023-12-10 14:31:34");
INSERT INTO audit_trail VALUES("376","URS-000","","","added a year level","unread","2023-12-10 14:31:34");
INSERT INTO audit_trail VALUES("377","URS-000","","","added a year level","unread","2023-12-10 14:31:34");
INSERT INTO audit_trail VALUES("378","URS-000","","","visited User Accounts Page","unread","2023-12-10 14:40:07");
INSERT INTO audit_trail VALUES("379","URS-000","","","added an account","unread","2023-12-10 14:42:30");
INSERT INTO audit_trail VALUES("380","URS-000","","","visited Dashboard","unread","2023-12-10 16:13:51");
INSERT INTO audit_trail VALUES("381","URS-000","","","added a schedule for BINANGONAN CAMPUS","unread","2023-12-10 16:14:49");
INSERT INTO audit_trail VALUES("382","URS-000","","","added a schedule for BINANGONAN CAMPUS","unread","2023-12-10 16:14:49");
INSERT INTO audit_trail VALUES("383","B2021-0569","","","sent a request for online  appointment","unread","2023-12-10 16:28:19");
INSERT INTO audit_trail VALUES("384","B2021-0576","","","sent a request for online  appointment","unread","2023-12-10 16:28:19");
INSERT INTO audit_trail VALUES("385","B2021-0588","","","sent a request for online  appointment","unread","2023-12-10 16:28:19");
INSERT INTO audit_trail VALUES("386","B2021-0550","","","sent a request for online  appointment","unread","2023-12-10 16:28:19");
INSERT INTO audit_trail VALUES("387","B2021-0542","","","sent a request for online  appointment","unread","2023-12-10 16:28:19");
INSERT INTO audit_trail VALUES("388","URS-960","","","sent a request for online  appointment","unread","2023-12-10 16:28:19");
INSERT INTO audit_trail VALUES("389","URS-993","","","sent a request for online  appointment","unread","2023-12-10 16:28:19");
INSERT INTO audit_trail VALUES("390","URS-992","","","sent a request for online  appointment","unread","2023-12-10 16:28:19");
INSERT INTO audit_trail VALUES("391","URSF-000","","","sent a request for online  appointment","unread","2023-12-10 16:28:19");
INSERT INTO audit_trail VALUES("392","URSN-001","","","approved a request for online appointment","unread","2023-12-10 16:32:17");
INSERT INTO audit_trail VALUES("393","URSN-001","","","approved a request for online appointment","unread","2023-12-10 16:32:17");
INSERT INTO audit_trail VALUES("394","URSN-001","","","approved a request for online appointment","unread","2023-12-10 16:32:17");
INSERT INTO audit_trail VALUES("395","URSN-001","","","approved a request for online appointment","unread","2023-12-10 16:32:17");
INSERT INTO audit_trail VALUES("396","B2021-0569","","","logged in","unread","2023-12-10 16:25:00");
INSERT INTO audit_trail VALUES("397","B2021-0569","","","logged out","unread","2023-12-10 16:29:01");
INSERT INTO audit_trail VALUES("398","B2021-0576","","","logged in","unread","2023-12-10 16:20:17");
INSERT INTO audit_trail VALUES("399","B2021-0576","","","logged out","unread","2023-12-10 16:29:09");
INSERT INTO audit_trail VALUES("400","B2021-0588","","","logged in","unread","2023-12-10 16:19:57");
INSERT INTO audit_trail VALUES("401","B2021-0588","","","logged out","unread","2023-12-10 16:38:12");
INSERT INTO audit_trail VALUES("402","B2021-0550","","","logged in","unread","2023-12-10 16:27:34");
INSERT INTO audit_trail VALUES("403","B2021-0550","","","logged out","unread","2023-12-10 16:34:23");
INSERT INTO audit_trail VALUES("404","B2021-0542","","","logged in","unread","2023-12-10 16:27:59");
INSERT INTO audit_trail VALUES("405","B2021-0542","","","logged out","unread","2023-12-10 16:29:09");
INSERT INTO audit_trail VALUES("406","URS-960","","","logged in","unread","2023-12-10 16:08:48");
INSERT INTO audit_trail VALUES("407","URS-960","","","logged out","unread","2023-12-10 16:56:09");
INSERT INTO audit_trail VALUES("408","URS-993","","","logged in","unread","2023-12-10 16:20:47");
INSERT INTO audit_trail VALUES("409","URS-993","","","logged out","unread","2023-12-10 16:33:21");
INSERT INTO audit_trail VALUES("410","URS-992","","","logged in","unread","2023-12-10 16:12:00");
INSERT INTO audit_trail VALUES("411","URS-992","","","logged out","unread","2023-12-10 16:28:30");
INSERT INTO audit_trail VALUES("412","URSF-000","","","logged in","unread","2023-12-10 16:25:45");
INSERT INTO audit_trail VALUES("413","URSF-000","","","logged out","unread","2023-12-10 16:41:33");
INSERT INTO audit_trail VALUES("414","URSN-001","","","logged in","unread","2023-12-10 15:51:38");
INSERT INTO audit_trail VALUES("415","URSN-001","","","logged out","unread","2023-12-10 16:41:33");
INSERT INTO audit_trail VALUES("416","URS-000","","","logged out","unread","2023-12-10 20:15:22");
INSERT INTO audit_trail VALUES("417","URSD-001","","","logged in","unread","2023-12-13 13:58:42");
INSERT INTO audit_trail VALUES("440","URSD-001","","","added a schedule for BINANGONAN CAMPUS","unread","2023-12-13 14:00:02");
INSERT INTO audit_trail VALUES("441","URSD-001","","","added a schedule for ANGONO CAMPUS","unread","2023-12-13 14:01:34");
INSERT INTO audit_trail VALUES("442","URSD-001","","","added a schedule for ANTIPOLO CAMPUS","unread","2023-12-13 14:01:58");
INSERT INTO audit_trail VALUES("443","URSD-001","","","added a schedule for CARDONA CAMPUS","unread","2023-12-13 14:02:21");
INSERT INTO audit_trail VALUES("444","URSD-001","","","added a schedule for CAINTA CAMPUS","unread","2023-12-13 14:02:43");
INSERT INTO audit_trail VALUES("445","URSD-001","","","added a schedule for MORONG CAMPUS","unread","2023-12-13 14:03:47");
INSERT INTO audit_trail VALUES("446","URSD-001","","","added a schedule for PILILLA CAMPUS","unread","2023-12-13 14:05:02");
INSERT INTO audit_trail VALUES("447","URSD-001","","","added a schedule for RODRIGUEZ CAMPUS","unread","2023-12-13 14:05:17");
INSERT INTO audit_trail VALUES("448","URSD-001","","","added a schedule for TANAY CAMPUS","unread","2023-12-13 14:05:49");
INSERT INTO audit_trail VALUES("449","URSD-001","","","added a schedule for TAYTAY CAMPUS","unread","2023-12-13 14:07:00");
INSERT INTO audit_trail VALUES("450","URSD-001","","","added a schedule for ANGONO CAMPUS","unread","2023-12-13 14:07:35");
INSERT INTO audit_trail VALUES("451","URSD-001","","","added a schedule for ANTIPOLO CAMPUS","unread","2023-12-13 14:09:13");
INSERT INTO audit_trail VALUES("452","URSD-001","","","added a schedule for CARDONA CAMPUS","unread","2023-12-13 14:12:18");
INSERT INTO audit_trail VALUES("453","URSD-001","","","added a schedule for CAINTA CAMPUS","unread","2023-12-13 14:12:38");
INSERT INTO audit_trail VALUES("454","URSD-001","","","added a schedule for MORONG CAMPUS","unread","2023-12-13 14:16:07");
INSERT INTO audit_trail VALUES("455","URSD-001","","","added a schedule for PILILLA CAMPUS","unread","2023-12-13 14:20:00");
INSERT INTO audit_trail VALUES("456","URSD-001","","","added a schedule for RODRIGUEZ CAMPUS","unread","2023-12-13 14:20:31");
INSERT INTO audit_trail VALUES("457","URSD-001","","","added a schedule for TANAY CAMPUS","unread","2023-12-13 14:21:50");
INSERT INTO audit_trail VALUES("458","URSD-001","","","added a schedule for TAYTAY CAMPUS","unread","2023-12-13 14:25:19");
INSERT INTO audit_trail VALUES("459","URSD-001","","","logged out","unread","2023-12-13 14:23:31");
INSERT INTO audit_trail VALUES("460","URS-000","","","logged in","unread","2023-12-13 13:58:02");
INSERT INTO audit_trail VALUES("461","URS-000","","","visited Settings Page","unread","2023-12-13 13:59:55");
INSERT INTO audit_trail VALUES("462","URS-000","","","added a type of transaction","unread","2023-12-13 14:00:27");
INSERT INTO audit_trail VALUES("463","URS-000","","","visited Accounts Page","unread","2023-12-13 14:23:31");
INSERT INTO audit_trail VALUES("464","URS-000","","","added an account","unread","2023-12-13 14:26:35");
INSERT INTO audit_trail VALUES("465","URSD-002","","","logged in","unread","2023-12-13 14:30:02");
INSERT INTO audit_trail VALUES("466","URSD-002","","","added a schedule for CARDONA CAMPUS","unread","2023-12-13 14:33:54");
INSERT INTO audit_trail VALUES("467","URSD-002","","","added a schedule for CAINTA CAMPUS","unread","2023-12-13 14:33:54");
INSERT INTO audit_trail VALUES("468","URSD-002","","","added a schedule for BINANGONANCAMPUS","unread","2023-12-13 14:33:54");
INSERT INTO audit_trail VALUES("469","URSD-002","","","added a schedule for ANGONO CAMPUS","unread","2023-12-13 14:33:54");
INSERT INTO audit_trail VALUES("470","URSD-002","","","added a schedule for ANTIPOLO CAMPUS","unread","2023-12-13 15:00:00");
INSERT INTO audit_trail VALUES("471","URSD-002","","","added a schedule for MORONG CAMPUS","unread","2023-12-13 15:00:00");
INSERT INTO audit_trail VALUES("472","URSD-002","","","added a schedule for PILILLA CAMPUS","unread","2023-12-13 15:00:00");
INSERT INTO audit_trail VALUES("473","URSD-002","","","added a schedule for RODRIGUEZ CAMPUS","unread","2023-12-13 15:00:00");
INSERT INTO audit_trail VALUES("474","URSD-002","","","added a schedule for TANAY CAMPUS","unread","2023-12-13 15:00:00");
INSERT INTO audit_trail VALUES("475","URSD-002","","","added a schedule for TAYTAY CAMPUS","unread","2023-12-13 15:00:00");
INSERT INTO audit_trail VALUES("476","URSD-002","","","logged out","unread","2023-12-13 16:03:45");
INSERT INTO audit_trail VALUES("477","B2021-0569","","","logged in","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("478","B2021-0569","","","sent a request for online  appointment","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("479","B2021-0576","","","logged in","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("480","B2021-0576","","","sent a request for online  appointment","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("481","B2021-0576","","","logged out","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("482","B2021-0576","","","logged in","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("483","B2021-0576","","","sent a request for online  appointment","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("484","B2021-0576","","","logged out","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("485","B2021-0588","","","logged in","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("486","B2021-0588","","","sent a request for online  appointment","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("487","B2021-0588","","","logged out","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("488","B2021-0550","","","logged in","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("489","B2021-0550","","","sent a request for online  appointment","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("490","B2021-0550","","","logged out","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("491","URS-960","","","logged in","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("492","URS-960","","","sent a request for online  appointment","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("493","URS-960","","","logged out","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("494","URS-993","","","logged in","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("495","URS-993","","","sent a request for online  appointment","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("496","URS-993","","","logged out","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("497","URSF-000","","","logged in","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("498","URSF-000","","","sent a request for online  appointment","read","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("499","URSF-000","","","logged out","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("500","B2021-0569","","","sent a request for online  appointment","read","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("501","B2021-0569","","","logged out","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("502","URS-992","","","logged in","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("503","URS-992","","","sent a request for online  appointment","read","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("504","URS-992","","","logged out","unread","2023-12-13 14:59:37");
INSERT INTO audit_trail VALUES("505","URS-000","","","logged out","unread","2023-12-13 16:17:26");
INSERT INTO audit_trail VALUES("506","URSN-001","","","logged in","unread","2023-12-13 16:17:52");
INSERT INTO audit_trail VALUES("507","URSN-001","","","visited Inventory Page","unread","2023-12-13 16:18:19");
INSERT INTO audit_trail VALUES("508","URSN-001","","","added stocks for medicine","unread","2023-12-13 16:19:35");
INSERT INTO audit_trail VALUES("509","URSN-001","","","added stocks for medicine","unread","2023-12-13 16:19:35");
INSERT INTO audit_trail VALUES("510","URSN-001","","","added stocks for medicine","unread","2023-12-13 16:19:35");
INSERT INTO audit_trail VALUES("511","URSN-001","","","added stocks for medicine","unread","2023-12-13 16:19:35");
INSERT INTO audit_trail VALUES("512","URSN-001","","","added stocks for medicine","unread","2023-12-13 16:19:35");
INSERT INTO audit_trail VALUES("513","URSN-001","","","logged out","unread","2023-12-13 16:20:01");
INSERT INTO audit_trail VALUES("514","URSN-001","","","logged in","unread","2023-12-18 13:36:59");
INSERT INTO audit_trail VALUES("515","URSN-001","","","visited Settings Page","unread","2023-12-18 13:37:56");
INSERT INTO audit_trail VALUES("516","URSN-001","","","added a type of transaction","unread","2023-12-18 13:42:10");
INSERT INTO audit_trail VALUES("517","URSN-001","","","added a type of transaction","unread","2023-12-18 13:42:10");
INSERT INTO audit_trail VALUES("518","URSN-001","","","added a type of transaction","unread","2023-12-18 13:42:10");
INSERT INTO audit_trail VALUES("519","URSN-001","","","added a type of transaction","unread","2023-12-18 13:42:10");
INSERT INTO audit_trail VALUES("520","URSN-001","","","added a type of transaction","unread","2023-12-18 13:42:10");
INSERT INTO audit_trail VALUES("521","URSN-001","","","added a type of transaction","unread","2023-12-18 13:42:10");
INSERT INTO audit_trail VALUES("522","URSN-001","","","logged out","unread","2023-12-18 13:42:10");
INSERT INTO audit_trail VALUES("523","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","0000-00-00 00:00:00");
INSERT INTO audit_trail VALUES("530","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-26 15:34:50");
INSERT INTO audit_trail VALUES("531","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-26 15:35:13");
INSERT INTO audit_trail VALUES("532","URSN-001","DIOSA A SALVADOR","BINANGONAN","Cancel an appointment","unread","2024-01-26 15:48:15");
INSERT INTO audit_trail VALUES("533","URSN-001","DIOSA A SALVADOR","BINANGONAN","Cancel an appointment","unread","2024-01-26 15:48:30");
INSERT INTO audit_trail VALUES("534","URSN-001","DIOSA A SALVADOR","BINANGONAN","Cancel an appointment","unread","2024-01-26 15:48:45");
INSERT INTO audit_trail VALUES("535","URSN-001","DIOSA A SALVADOR","BINANGONAN","Approve an appointment","unread","2024-01-26 15:50:22");
INSERT INTO audit_trail VALUES("536","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-27 23:03:30");
INSERT INTO audit_trail VALUES("537","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-28 00:39:20");
INSERT INTO audit_trail VALUES("538","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-28 00:39:34");
INSERT INTO audit_trail VALUES("539","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-28 14:12:17");
INSERT INTO audit_trail VALUES("540","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-28 14:24:44");
INSERT INTO audit_trail VALUES("541","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-01-29 09:44:46");
INSERT INTO audit_trail VALUES("542","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-01-29 10:17:42");
INSERT INTO audit_trail VALUES("543","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 17:36:45");
INSERT INTO audit_trail VALUES("544","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 17:37:24");
INSERT INTO audit_trail VALUES("545","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-01-29 17:40:31");
INSERT INTO audit_trail VALUES("546","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 17:43:17");
INSERT INTO audit_trail VALUES("547","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 17:56:42");
INSERT INTO audit_trail VALUES("548","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-01-29 20:25:06");
INSERT INTO audit_trail VALUES("549","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 20:25:59");
INSERT INTO audit_trail VALUES("550","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 22:12:59");
INSERT INTO audit_trail VALUES("551","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 22:17:55");
INSERT INTO audit_trail VALUES("552","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 22:27:35");
INSERT INTO audit_trail VALUES("553","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 22:27:52");
INSERT INTO audit_trail VALUES("554","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 22:28:00");
INSERT INTO audit_trail VALUES("555","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 22:30:26");
INSERT INTO audit_trail VALUES("556","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 22:32:48");
INSERT INTO audit_trail VALUES("557","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 22:33:53");
INSERT INTO audit_trail VALUES("558","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 22:34:53");
INSERT INTO audit_trail VALUES("559","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 22:34:55");
INSERT INTO audit_trail VALUES("560","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 22:35:57");
INSERT INTO audit_trail VALUES("561","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 22:44:11");
INSERT INTO audit_trail VALUES("562","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 22:44:21");
INSERT INTO audit_trail VALUES("563","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 22:46:06");
INSERT INTO audit_trail VALUES("564","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-01-29 22:57:46");
INSERT INTO audit_trail VALUES("565","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 23:09:32");
INSERT INTO audit_trail VALUES("566","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 23:09:36");
INSERT INTO audit_trail VALUES("567","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-01-29 23:12:30");
INSERT INTO audit_trail VALUES("568","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-01-29 23:12:47");
INSERT INTO audit_trail VALUES("569","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-01-29 23:15:50");
INSERT INTO audit_trail VALUES("570","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 23:16:20");
INSERT INTO audit_trail VALUES("571","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 23:16:22");
INSERT INTO audit_trail VALUES("572","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 23:19:22");
INSERT INTO audit_trail VALUES("573","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 23:19:24");
INSERT INTO audit_trail VALUES("574","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-01-29 23:19:50");
INSERT INTO audit_trail VALUES("575","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-01-29 23:21:18");
INSERT INTO audit_trail VALUES("576","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-01-29 23:21:36");
INSERT INTO audit_trail VALUES("577","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 23:21:45");
INSERT INTO audit_trail VALUES("578","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 23:21:47");
INSERT INTO audit_trail VALUES("579","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-01-29 23:21:53");
INSERT INTO audit_trail VALUES("580","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-01-29 23:21:54");
INSERT INTO audit_trail VALUES("581","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-01-29 23:25:03");
INSERT INTO audit_trail VALUES("582","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 23:26:05");
INSERT INTO audit_trail VALUES("583","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-29 23:26:35");
INSERT INTO audit_trail VALUES("584","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-29 23:27:08");
INSERT INTO audit_trail VALUES("585","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-30 14:32:47");
INSERT INTO audit_trail VALUES("586","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-01-30 14:34:35");
INSERT INTO audit_trail VALUES("587","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-01-30 14:34:45");
INSERT INTO audit_trail VALUES("588","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-01-30 15:03:03");
INSERT INTO audit_trail VALUES("589","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-01-30 15:03:09");
INSERT INTO audit_trail VALUES("590","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-01-30 15:18:42");
INSERT INTO audit_trail VALUES("591","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-01-30 15:18:51");
INSERT INTO audit_trail VALUES("592","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-01-30 20:49:53");
INSERT INTO audit_trail VALUES("593","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-01-31 19:47:41");
INSERT INTO audit_trail VALUES("594","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-01-31 20:28:09");
INSERT INTO audit_trail VALUES("595","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-01-31 22:50:24");
INSERT INTO audit_trail VALUES("596","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-01-31 23:51:36");
INSERT INTO audit_trail VALUES("597","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-01-31 23:51:54");
INSERT INTO audit_trail VALUES("598","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-03 14:35:54");
INSERT INTO audit_trail VALUES("599","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-03 14:53:34");
INSERT INTO audit_trail VALUES("600","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-03 17:29:52");
INSERT INTO audit_trail VALUES("601","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-03 19:32:32");
INSERT INTO audit_trail VALUES("602","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-03 20:32:33");
INSERT INTO audit_trail VALUES("603","B2021-0550","JOEMARI VALENCIA CORDERO","BINANGONAN","Logged In","unread","2024-02-03 20:32:55");
INSERT INTO audit_trail VALUES("604","B2021-0550","JOEMARI VALENCIA CORDERO","BINANGONAN","Logged Out","unread","2024-02-03 20:33:16");
INSERT INTO audit_trail VALUES("605","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-03 20:33:42");
INSERT INTO audit_trail VALUES("606","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-03 20:35:15");
INSERT INTO audit_trail VALUES("607","B2021-0550","JOEMARI VALENCIA CORDERO","BINANGONAN","Logged In","unread","2024-02-03 20:35:19");
INSERT INTO audit_trail VALUES("608","B2021-0550","JOEMARI VALENCIA CORDERO","BINANGONAN","Logged Out","unread","2024-02-03 20:39:06");
INSERT INTO audit_trail VALUES("609","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-03 20:39:11");
INSERT INTO audit_trail VALUES("610","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-04 00:09:10");
INSERT INTO audit_trail VALUES("611","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-04 00:09:13");
INSERT INTO audit_trail VALUES("612","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-04 00:09:29");
INSERT INTO audit_trail VALUES("613","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-04 15:32:17");
INSERT INTO audit_trail VALUES("614","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-04 19:07:49");
INSERT INTO audit_trail VALUES("615","B2021-0550","JOEMARI VALENCIA CORDERO","BINANGONAN","Logged In","unread","2024-02-04 19:08:10");
INSERT INTO audit_trail VALUES("616","B2021-0550","JOEMARI VALENCIA CORDERO","BINANGONAN","Logged Out","unread","2024-02-04 19:09:08");
INSERT INTO audit_trail VALUES("617","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-04 19:09:13");
INSERT INTO audit_trail VALUES("618","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-04 19:51:28");
INSERT INTO audit_trail VALUES("619","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-04 19:52:06");
INSERT INTO audit_trail VALUES("620","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-06 12:43:44");
INSERT INTO audit_trail VALUES("621","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-07 19:09:44");
INSERT INTO audit_trail VALUES("622","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-07 20:09:46");
INSERT INTO audit_trail VALUES("623","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-07 20:11:16");
INSERT INTO audit_trail VALUES("624","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-12 16:59:43");
INSERT INTO audit_trail VALUES("625","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-12 19:04:01");
INSERT INTO audit_trail VALUES("626","B2021-0550","JOEMARI VALENCIA CORDERO","BINANGONAN","Logged In","unread","2024-02-12 19:04:26");
INSERT INTO audit_trail VALUES("627","B2021-0550","JOEMARI VALENCIA CORDERO","BINANGONAN","Logged Out","unread","2024-02-12 19:10:42");
INSERT INTO audit_trail VALUES("628","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-12 19:10:47");
INSERT INTO audit_trail VALUES("629","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-13 16:34:48");
INSERT INTO audit_trail VALUES("630","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-13 16:35:24");
INSERT INTO audit_trail VALUES("631","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-13 21:34:15");
INSERT INTO audit_trail VALUES("632","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-14 22:15:49");
INSERT INTO audit_trail VALUES("633","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-15 00:31:42");
INSERT INTO audit_trail VALUES("634","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-15 00:31:51");
INSERT INTO audit_trail VALUES("635","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-15 00:37:33");
INSERT INTO audit_trail VALUES("636","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-15 00:37:42");
INSERT INTO audit_trail VALUES("637","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-15 00:40:34");
INSERT INTO audit_trail VALUES("638","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-15 00:40:43");
INSERT INTO audit_trail VALUES("639","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-15 01:30:14");
INSERT INTO audit_trail VALUES("640","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-15 01:30:23");
INSERT INTO audit_trail VALUES("641","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-15 01:36:14");
INSERT INTO audit_trail VALUES("642","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-15 01:36:21");
INSERT INTO audit_trail VALUES("643","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-15 01:39:31");
INSERT INTO audit_trail VALUES("644","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-15 01:39:39");
INSERT INTO audit_trail VALUES("645","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-15 01:46:58");
INSERT INTO audit_trail VALUES("646","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-15 01:47:05");
INSERT INTO audit_trail VALUES("647","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-15 01:50:00");
INSERT INTO audit_trail VALUES("648","ursf-000","EDEN C SANTOS","BINANGONAN","Logged In","unread","2024-02-15 01:56:06");
INSERT INTO audit_trail VALUES("649","ursf-000","EDEN C SANTOS","BINANGONAN","Logged In","unread","2024-02-15 01:56:10");
INSERT INTO audit_trail VALUES("650","URSF-000","EDEN C SANTOS","BINANGONAN","Logged Out","unread","2024-02-15 01:56:59");
INSERT INTO audit_trail VALUES("651","ursf-000","EDEN C SANTOS","BINANGONAN","Logged In","unread","2024-02-15 01:57:06");
INSERT INTO audit_trail VALUES("652","URSF-000","EDEN C SANTOS","BINANGONAN","Logged Out","unread","2024-02-15 01:57:26");
INSERT INTO audit_trail VALUES("653","ursf-000","EDEN C SANTOS","BINANGONAN","Logged In","unread","2024-02-15 01:58:03");
INSERT INTO audit_trail VALUES("654","ursf-000","EDEN C SANTOS","BINANGONAN","Logged In","unread","2024-02-15 01:59:40");
INSERT INTO audit_trail VALUES("655","URSF-000","EDEN C SANTOS","BINANGONAN","Logged Out","unread","2024-02-15 01:59:45");
INSERT INTO audit_trail VALUES("656","ursf-000","EDEN C SANTOS","BINANGONAN","Logged In","unread","2024-02-15 01:59:51");
INSERT INTO audit_trail VALUES("657","URSF-000","EDEN C SANTOS","BINANGONAN","Logged Out","unread","2024-02-15 02:00:01");
INSERT INTO audit_trail VALUES("658","ursf-000","EDEN C SANTOS","BINANGONAN","Logged In","unread","2024-02-15 02:00:55");
INSERT INTO audit_trail VALUES("659","URSF-000","EDEN C SANTOS","BINANGONAN","Logged Out","unread","2024-02-15 02:02:09");
INSERT INTO audit_trail VALUES("660","ursf-000","EDEN C SANTOS","BINANGONAN","Logged In","unread","2024-02-15 02:02:14");
INSERT INTO audit_trail VALUES("661","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-22 10:39:01");
INSERT INTO audit_trail VALUES("662","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-22 10:44:27");
INSERT INTO audit_trail VALUES("663","URSD-001","EDNA C MAYCACAYAN","ALL","Logged In","unread","2024-02-22 10:45:57");
INSERT INTO audit_trail VALUES("664","URSD-001","EDNA C MAYCACAYAN","ALL","Logged Out","unread","2024-02-22 13:10:06");
INSERT INTO audit_trail VALUES("665","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-22 13:10:20");
INSERT INTO audit_trail VALUES("666","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-22 16:00:21");
INSERT INTO audit_trail VALUES("667","B2021-0569","JULEANNE ROZIER  CARANZA","BINANGONAN","Logged In","unread","2024-02-22 16:00:39");
INSERT INTO audit_trail VALUES("668","B2021-0569","JULEANNE ROZIER  CARANZA","BINANGONAN","Logged Out","unread","2024-02-22 16:18:27");
INSERT INTO audit_trail VALUES("669","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-22 16:18:41");
INSERT INTO audit_trail VALUES("670","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-22 16:23:56");
INSERT INTO audit_trail VALUES("671","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-22 16:24:24");
INSERT INTO audit_trail VALUES("672","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-22 16:24:38");
INSERT INTO audit_trail VALUES("673","B2021-0569","JULEANNE ROZIER  CARANZA","BINANGONAN","Logged In","unread","2024-02-22 16:25:00");
INSERT INTO audit_trail VALUES("674","B2021-0569","JULEANNE ROZIER  CARANZA","BINANGONAN","Logged Out","unread","2024-02-22 16:27:36");
INSERT INTO audit_trail VALUES("675","B2021-0569","JULEANNE ROZIER  CARANZA","BINANGONAN","Logged In","unread","2024-02-22 16:28:24");
INSERT INTO audit_trail VALUES("676","B2021-0569","JULEANNE ROZIER  CARANZA","BINANGONAN","Logged Out","unread","2024-02-22 16:31:38");
INSERT INTO audit_trail VALUES("677","b2021-0569","JULEANNE ROZIER  CARANZA","BINANGONAN","Logged In","unread","2024-02-22 16:31:53");
INSERT INTO audit_trail VALUES("678","B2021-0569","JULEANNE ROZIER  CARANZA","BINANGONAN","Logged Out","unread","2024-02-22 16:39:12");
INSERT INTO audit_trail VALUES("679","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-22 16:39:46");
INSERT INTO audit_trail VALUES("680","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-22 16:43:15");
INSERT INTO audit_trail VALUES("681","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-22 16:43:45");
INSERT INTO audit_trail VALUES("682","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-22 16:46:17");
INSERT INTO audit_trail VALUES("683","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-22 16:46:39");
INSERT INTO audit_trail VALUES("684","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-22 16:49:19");
INSERT INTO audit_trail VALUES("685","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-22 16:49:27");
INSERT INTO audit_trail VALUES("686","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-22 17:01:26");
INSERT INTO audit_trail VALUES("687","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-22 17:01:41");
INSERT INTO audit_trail VALUES("688","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-22 17:09:52");
INSERT INTO audit_trail VALUES("689","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-22 17:10:17");
INSERT INTO audit_trail VALUES("690","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-22 17:10:56");
INSERT INTO audit_trail VALUES("691","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-22 21:20:41");
INSERT INTO audit_trail VALUES("692","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-22 21:25:39");
INSERT INTO audit_trail VALUES("693","URSD-001","EDNA C MAYCACAYAN","ALL","Logged In","unread","2024-02-22 21:25:49");
INSERT INTO audit_trail VALUES("694","URSD-001","EDNA C MAYCACAYAN","ALL","Logged Out","unread","2024-02-22 21:27:10");
INSERT INTO audit_trail VALUES("695","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged In","unread","2024-02-22 21:27:18");
INSERT INTO audit_trail VALUES("696","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged Out","unread","2024-02-22 21:34:52");
INSERT INTO audit_trail VALUES("697","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-22 21:35:43");
INSERT INTO audit_trail VALUES("698","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-22 21:48:17");
INSERT INTO audit_trail VALUES("699","URSD-001","EDNA C MAYCACAYAN","ALL","Logged In","unread","2024-02-22 21:48:31");
INSERT INTO audit_trail VALUES("700","URSD-001","EDNA C MAYCACAYAN","ALL","Logged Out","unread","2024-02-22 21:49:31");
INSERT INTO audit_trail VALUES("701","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-22 21:49:39");
INSERT INTO audit_trail VALUES("702","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-22 21:57:11");
INSERT INTO audit_trail VALUES("703","URSD-002","GODWIN A OLIVAS","ALL","Logged In","unread","2024-02-22 21:58:08");
INSERT INTO audit_trail VALUES("704","URSD-002","GODWIN A OLIVAS","ALL","Logged Out","unread","2024-02-22 21:59:00");
INSERT INTO audit_trail VALUES("705","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged In","unread","2024-02-22 21:59:09");
INSERT INTO audit_trail VALUES("706","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged Out","unread","2024-02-22 22:36:48");
INSERT INTO audit_trail VALUES("707","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-22 22:36:56");
INSERT INTO audit_trail VALUES("708","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-22 22:38:04");
INSERT INTO audit_trail VALUES("709","B2021-0569","JULEANNE ROZIER  CARANZA","BINANGONAN","Logged In","unread","2024-02-22 22:38:15");
INSERT INTO audit_trail VALUES("710","B2021-0569","JULEANNE ROZIER  CARANZA","BINANGONAN","Logged Out","unread","2024-02-22 22:39:07");
INSERT INTO audit_trail VALUES("711","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-22 22:39:16");
INSERT INTO audit_trail VALUES("712","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-22 23:06:04");
INSERT INTO audit_trail VALUES("713","URSD-002","GODWIN A OLIVAS","ALL","Logged In","unread","2024-02-22 23:06:26");
INSERT INTO audit_trail VALUES("714","URSD-002","GODWIN A OLIVAS","ALL","Logged Out","unread","2024-02-22 23:52:05");
INSERT INTO audit_trail VALUES("715","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-22 23:52:21");
INSERT INTO audit_trail VALUES("716","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-22 23:55:51");
INSERT INTO audit_trail VALUES("717","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged In","unread","2024-02-22 23:56:01");
INSERT INTO audit_trail VALUES("718","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged Out","unread","2024-02-22 23:59:26");
INSERT INTO audit_trail VALUES("719","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged In","unread","2024-02-23 00:01:23");
INSERT INTO audit_trail VALUES("720","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged Out","unread","2024-02-23 00:09:41");
INSERT INTO audit_trail VALUES("721","URSD-002","GODWIN A OLIVAS","ALL","Logged In","unread","2024-02-23 00:09:53");
INSERT INTO audit_trail VALUES("722","URSD-002","GODWIN A OLIVAS","ALL","Logged Out","unread","2024-02-23 00:10:12");
INSERT INTO audit_trail VALUES("723","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-23 00:10:27");
INSERT INTO audit_trail VALUES("724","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-23 00:16:17");
INSERT INTO audit_trail VALUES("725","URSD-002","GODWIN A OLIVAS","ALL","Logged In","unread","2024-02-23 00:16:27");
INSERT INTO audit_trail VALUES("726","URSD-002","GODWIN A OLIVAS","ALL","Logged Out","unread","2024-02-23 00:21:27");
INSERT INTO audit_trail VALUES("727","URSD-002","GODWIN A OLIVAS","ALL","Logged In","unread","2024-02-23 00:21:38");
INSERT INTO audit_trail VALUES("728","URSD-002","GODWIN A OLIVAS","ALL","Logged Out","unread","2024-02-23 00:21:53");
INSERT INTO audit_trail VALUES("729","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-23 00:22:03");
INSERT INTO audit_trail VALUES("730","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-23 00:23:47");
INSERT INTO audit_trail VALUES("731","URSD-002","GODWIN A OLIVAS","ALL","Logged In","unread","2024-02-23 00:23:54");
INSERT INTO audit_trail VALUES("732","URSD-002","GODWIN A OLIVAS","ALL","Logged Out","unread","2024-02-23 00:26:11");
INSERT INTO audit_trail VALUES("733","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-23 00:26:21");
INSERT INTO audit_trail VALUES("734","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-23 15:58:44");
INSERT INTO audit_trail VALUES("735","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged In","unread","2024-02-23 15:58:51");
INSERT INTO audit_trail VALUES("736","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged Out","unread","2024-02-23 18:41:15");
INSERT INTO audit_trail VALUES("737","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-23 18:41:22");
INSERT INTO audit_trail VALUES("738","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-23 19:11:05");
INSERT INTO audit_trail VALUES("739","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged In","unread","2024-02-23 19:11:23");
INSERT INTO audit_trail VALUES("740","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged Out","unread","2024-02-23 19:40:24");
INSERT INTO audit_trail VALUES("741","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-23 19:40:36");
INSERT INTO audit_trail VALUES("742","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-23 21:04:43");
INSERT INTO audit_trail VALUES("743","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged In","unread","2024-02-23 21:04:57");
INSERT INTO audit_trail VALUES("744","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged Out","unread","2024-02-23 21:05:29");
INSERT INTO audit_trail VALUES("745","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-23 21:05:38");
INSERT INTO audit_trail VALUES("746","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-23 21:33:58");
INSERT INTO audit_trail VALUES("747","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged In","unread","2024-02-23 21:34:14");
INSERT INTO audit_trail VALUES("748","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged Out","unread","2024-02-24 17:20:47");
INSERT INTO audit_trail VALUES("749","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-24 17:20:54");
INSERT INTO audit_trail VALUES("750","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-24 17:26:57");
INSERT INTO audit_trail VALUES("751","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged In","unread","2024-02-24 17:27:06");
INSERT INTO audit_trail VALUES("752","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged Out","unread","2024-02-24 17:36:55");
INSERT INTO audit_trail VALUES("753","B2021-0569","JULEANNE ROZIER  CARANZA","BINANGONAN","Logged In","unread","2024-02-24 17:37:09");
INSERT INTO audit_trail VALUES("754","B2021-0569","JULEANNE ROZIER  CARANZA","BINANGONAN","Logged Out","unread","2024-02-24 18:08:18");
INSERT INTO audit_trail VALUES("755","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged In","unread","2024-02-24 18:08:33");
INSERT INTO audit_trail VALUES("756","URS-000","ADMIN A. ADMIN","ANGONO","deleted a year level","unread","2024-02-24 21:44:51");
INSERT INTO audit_trail VALUES("757","URS-000","ADMIN A. ADMIN","ANGONO","deleted a year level","unread","2024-02-24 21:45:53");
INSERT INTO audit_trail VALUES("758","URS-000","ADMIN A. ADMIN","ANGONO","deleted a year level","unread","2024-02-24 21:46:49");
INSERT INTO audit_trail VALUES("759","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged Out","unread","2024-02-25 07:47:30");
INSERT INTO audit_trail VALUES("760","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-25 08:02:36");
INSERT INTO audit_trail VALUES("761","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-25 10:42:43");
INSERT INTO audit_trail VALUES("762","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged In","unread","2024-02-25 10:42:58");
INSERT INTO audit_trail VALUES("763","URS-000","ADMIN ADMIN ADMIN","ANGONO","Logged Out","unread","2024-02-25 11:46:17");
INSERT INTO audit_trail VALUES("764","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged In","unread","2024-02-25 11:46:32");
INSERT INTO audit_trail VALUES("765","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged Out","unread","2024-02-25 13:36:40");
INSERT INTO audit_trail VALUES("766","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-25 13:36:54");
INSERT INTO audit_trail VALUES("767","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-25 16:25:19");
INSERT INTO audit_trail VALUES("768","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-25 16:52:50");
INSERT INTO audit_trail VALUES("769","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-25 21:28:06");
INSERT INTO audit_trail VALUES("770","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged In","unread","2024-02-25 21:28:17");
INSERT INTO audit_trail VALUES("771","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged Out","unread","2024-02-25 21:30:01");
INSERT INTO audit_trail VALUES("772","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-25 21:30:12");
INSERT INTO audit_trail VALUES("773","URSN-001","DIOSA A SALVADOR","BINANGONAN","removed a medicine entry","unread","2024-02-26 08:38:18");
INSERT INTO audit_trail VALUES("774","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-26 08:53:02");
INSERT INTO audit_trail VALUES("775","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-26 08:53:10");
INSERT INTO audit_trail VALUES("776","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-02-26 08:55:12");
INSERT INTO audit_trail VALUES("777","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-26 08:55:47");
INSERT INTO audit_trail VALUES("778","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-26 08:59:14");
INSERT INTO audit_trail VALUES("779","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-26 09:00:13");
INSERT INTO audit_trail VALUES("780","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-26 09:01:11");
INSERT INTO audit_trail VALUES("781","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-02-26 09:01:20");
INSERT INTO audit_trail VALUES("782","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-26 09:03:02");
INSERT INTO audit_trail VALUES("783","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-26 10:37:01");
INSERT INTO audit_trail VALUES("784","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-26 10:37:12");
INSERT INTO audit_trail VALUES("785","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-26 18:06:01");
INSERT INTO audit_trail VALUES("786","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged In","unread","2024-02-26 18:06:16");
INSERT INTO audit_trail VALUES("787","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged Out","unread","2024-02-27 13:19:55");
INSERT INTO audit_trail VALUES("788","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-27 13:20:10");
INSERT INTO audit_trail VALUES("789","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-27 13:47:55");
INSERT INTO audit_trail VALUES("790","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged In","unread","2024-02-27 13:48:08");
INSERT INTO audit_trail VALUES("791","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged Out","unread","2024-02-27 13:50:24");
INSERT INTO audit_trail VALUES("792","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-27 13:50:39");
INSERT INTO audit_trail VALUES("793","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-27 13:51:07");
INSERT INTO audit_trail VALUES("794","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged In","unread","2024-02-27 13:57:23");
INSERT INTO audit_trail VALUES("800","URS-999","ALLEN J. CALEJO","BINANGONAN","updated the account of URS-999","unread","2024-02-28 09:20:56");
INSERT INTO audit_trail VALUES("801","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged Out","unread","2024-02-28 10:01:22");
INSERT INTO audit_trail VALUES("802","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-28 10:01:36");
INSERT INTO audit_trail VALUES("803","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-28 10:10:29");
INSERT INTO audit_trail VALUES("804","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged In","unread","2024-02-28 10:10:41");
INSERT INTO audit_trail VALUES("805","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged Out","unread","2024-02-28 11:24:38");
INSERT INTO audit_trail VALUES("806","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged In","unread","2024-02-28 11:25:12");
INSERT INTO audit_trail VALUES("809","URS-999","ALLEN J. CALEJO","BINANGONAN","updated their account details","unread","2024-02-28 11:36:59");
INSERT INTO audit_trail VALUES("810","URS-999","ALLEN J. CALEJO","BINANGONAN","updated their account details","unread","2024-02-28 11:37:22");
INSERT INTO audit_trail VALUES("811","URS-999","ALLEN J. CALEJO","BINANGONAN","updated their account details","unread","2024-02-28 11:41:09");
INSERT INTO audit_trail VALUES("812","URS-999","ALLEN J. CALEJO","BINANGONAN","updated their account details","unread","2024-02-28 11:43:32");
INSERT INTO audit_trail VALUES("813","URS-999","ALLEN J. CALEJO","BINANGONAN","updated their account details","unread","2024-02-28 11:45:29");
INSERT INTO audit_trail VALUES("814","URS-999","ALLEN J. CALEJO","BINANGONAN","updated their account details","unread","2024-02-28 11:45:36");
INSERT INTO audit_trail VALUES("815","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged Out","unread","2024-02-28 11:47:27");
INSERT INTO audit_trail VALUES("816","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-28 11:47:36");
INSERT INTO audit_trail VALUES("817","URSN-001","DIOSA A SALVADOR","BINANGONAN","updated their account details","unread","2024-02-28 12:02:01");
INSERT INTO audit_trail VALUES("818","URSN-001","DIOSA A SALVADOR","BINANGONAN","updated their account details","unread","2024-02-28 12:02:13");
INSERT INTO audit_trail VALUES("819","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-28 12:02:15");
INSERT INTO audit_trail VALUES("820","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged In","unread","2024-02-28 12:02:33");
INSERT INTO audit_trail VALUES("821","URS-999","ALLEN J. CALEJO","BINANGONAN","updated the account of B2021-0569","unread","2024-02-28 12:04:05");
INSERT INTO audit_trail VALUES("822","URS-999","ALLEN J. CALEJO","BINANGONAN","updated the patient information of URSF-000","unread","2024-02-28 12:59:15");
INSERT INTO audit_trail VALUES("823","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged Out","unread","2024-02-28 14:01:12");
INSERT INTO audit_trail VALUES("824","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-28 14:01:21");
INSERT INTO audit_trail VALUES("825","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-28 14:10:54");
INSERT INTO audit_trail VALUES("826","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged In","unread","2024-02-28 14:11:05");
INSERT INTO audit_trail VALUES("827","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged Out","unread","2024-02-28 14:27:55");
INSERT INTO audit_trail VALUES("828","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-28 14:28:05");
INSERT INTO audit_trail VALUES("830","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 24 inventory stocks","unread","2024-02-28 18:11:21");
INSERT INTO audit_trail VALUES("831","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 13 inventory stocks","unread","2024-02-28 18:13:47");
INSERT INTO audit_trail VALUES("833","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 12 inventory stocks","unread","2024-02-28 18:15:37");
INSERT INTO audit_trail VALUES("834","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 1 inventory stocks","unread","2024-02-28 18:16:25");
INSERT INTO audit_trail VALUES("835","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 2 inventory stocks","unread","2024-02-28 18:17:15");
INSERT INTO audit_trail VALUES("836","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 5 inventory stocks","unread","2024-02-28 18:17:43");
INSERT INTO audit_trail VALUES("837","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 24 inventory stocks","unread","2024-02-28 18:20:42");
INSERT INTO audit_trail VALUES("838","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 13 inventory stocks","unread","2024-02-28 18:25:50");
INSERT INTO audit_trail VALUES("839","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 14 inventory stocks","unread","2024-02-28 18:27:34");
INSERT INTO audit_trail VALUES("840","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 12 inventory stocks","unread","2024-02-28 18:27:59");
INSERT INTO audit_trail VALUES("841","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 1 inventory stocks","unread","2024-02-28 18:28:23");
INSERT INTO audit_trail VALUES("842","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 2 inventory stocks","unread","2024-02-28 18:28:45");
INSERT INTO audit_trail VALUES("843","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 5 inventory stocks","unread","2024-02-28 18:29:13");
INSERT INTO audit_trail VALUES("844","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 11 inventory stocks","unread","2024-02-28 18:29:54");
INSERT INTO audit_trail VALUES("845","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 24 inventory stocks","unread","2024-02-28 18:34:49");
INSERT INTO audit_trail VALUES("846","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 13 inventory stocks","unread","2024-02-28 18:35:15");
INSERT INTO audit_trail VALUES("847","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 14 inventory stocks","unread","2024-02-28 18:35:33");
INSERT INTO audit_trail VALUES("848","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 12 inventory stocks","unread","2024-02-28 18:36:11");
INSERT INTO audit_trail VALUES("849","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 1 inventory stocks","unread","2024-02-28 18:36:56");
INSERT INTO audit_trail VALUES("850","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 2 inventory stocks","unread","2024-02-28 18:37:17");
INSERT INTO audit_trail VALUES("851","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 5 inventory stocks","unread","2024-02-28 18:38:39");
INSERT INTO audit_trail VALUES("852","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 11 inventory stocks","unread","2024-02-28 18:39:31");
INSERT INTO audit_trail VALUES("853","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 4 inventory stocks","unread","2024-02-28 18:39:52");
INSERT INTO audit_trail VALUES("854","URSN-001","DIOSA A SALVADOR","BINANGONAN","added 6 inventory stocks","unread","2024-02-28 18:41:18");
INSERT INTO audit_trail VALUES("855","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-02-28 19:27:28");
INSERT INTO audit_trail VALUES("856","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged In","unread","2024-02-28 19:27:37");
INSERT INTO audit_trail VALUES("857","URS-999","ALLEN J. CALEJO","BINANGONAN","updated a campus entry","unread","2024-02-28 19:45:31");
INSERT INTO audit_trail VALUES("858","URS-999","ALLEN J. CALEJO","BINANGONAN","updated a campus entry","unread","2024-02-28 19:46:46");
INSERT INTO audit_trail VALUES("859","URS-999","ALLEN J. CALEJO","BINANGONAN","updated a campus entry","unread","2024-02-28 19:50:47");
INSERT INTO audit_trail VALUES("860","URS-999","ALLEN J. CALEJO","BINANGONAN","updated a campus entry","unread","2024-02-28 19:51:20");
INSERT INTO audit_trail VALUES("861","URS-999","ALLEN J. CALEJO","BINANGONAN","updated a campus entry","unread","2024-02-28 19:53:14");
INSERT INTO audit_trail VALUES("862","URS-999","ALLEN J. CALEJO","BINANGONAN","updated a campus entry","unread","2024-02-28 19:55:46");
INSERT INTO audit_trail VALUES("863","URS-999","ALLEN J. CALEJO","BINANGONAN","updated a campus entry","unread","2024-02-28 20:01:00");
INSERT INTO audit_trail VALUES("864","URS-999","ALLEN J. CALEJO","BINANGONAN","updated a campus entry","unread","2024-02-28 20:02:07");
INSERT INTO audit_trail VALUES("865","URS-999","ALLEN J. CALEJO","BINANGONAN","updated a campus entry","unread","2024-02-28 20:24:14");
INSERT INTO audit_trail VALUES("866","URS-999","ALLEN J. CALEJO","BINANGONAN","updated a campus entry","unread","2024-02-28 20:26:23");
INSERT INTO audit_trail VALUES("867","URS-999","ALLEN J. CALEJO","BINANGONAN","updated a campus entry","unread","2024-02-28 20:27:30");
INSERT INTO audit_trail VALUES("868","URS-999","ALLEN J. CALEJO","BINANGONAN","added a campus","unread","2024-02-28 20:27:37");
INSERT INTO audit_trail VALUES("869","URS-999","ALLEN JANE CALEJO","BINANGONAN","Logged Out","unread","2024-02-28 20:33:29");
INSERT INTO audit_trail VALUES("870","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-02-29 11:55:51");
INSERT INTO audit_trail VALUES("871","URSN-001","","BINANGONAN","added a record to the calibration and maintenance of 4","unread","2024-02-29 12:23:14");
INSERT INTO audit_trail VALUES("872","URSN-001","","BINANGONAN","added a record to the calibration and maintenance of 4","unread","2024-02-29 12:23:39");
INSERT INTO audit_trail VALUES("873","URSN-001","DIOSA A SALVADOR","BINANGONAN","added a record to the calibration and maintenance of 4","unread","2024-02-29 19:51:37");
INSERT INTO audit_trail VALUES("874","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-03-02 14:59:29");
INSERT INTO audit_trail VALUES("875","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-03-02 15:01:42");
INSERT INTO audit_trail VALUES("876","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-03-02 15:01:48");
INSERT INTO audit_trail VALUES("877","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-03-02 15:01:57");
INSERT INTO audit_trail VALUES("878","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-03-02 15:02:00");
INSERT INTO audit_trail VALUES("879","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-03-02 15:09:57");
INSERT INTO audit_trail VALUES("880","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-03-02 15:10:31");
INSERT INTO audit_trail VALUES("881","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-03-02 18:43:30");
INSERT INTO audit_trail VALUES("882","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-03-02 19:23:43");
INSERT INTO audit_trail VALUES("883","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-03-02 19:23:48");
INSERT INTO audit_trail VALUES("884","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-03-02 19:56:56");
INSERT INTO audit_trail VALUES("887","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-03-02 19:57:15");
INSERT INTO audit_trail VALUES("888","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-03-02 22:41:20");
INSERT INTO audit_trail VALUES("889","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-03-02 22:41:24");
INSERT INTO audit_trail VALUES("890","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-03-02 22:48:47");
INSERT INTO audit_trail VALUES("891","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-03-02 22:48:49");
INSERT INTO audit_trail VALUES("892","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-03-03 00:49:22");
INSERT INTO audit_trail VALUES("893","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-03-03 00:52:53");
INSERT INTO audit_trail VALUES("894","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-03-03 01:16:03");
INSERT INTO audit_trail VALUES("895","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-03-03 01:16:05");
INSERT INTO audit_trail VALUES("896","ursn-001","DIOSA A SALVADOR","BINANGONAN","completed a request for request medical supply of","unread","2024-03-03 11:03:10");
INSERT INTO audit_trail VALUES("897","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-03-03 11:23:52");
INSERT INTO audit_trail VALUES("898","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-03-03 11:29:57");
INSERT INTO audit_trail VALUES("899","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-03-03 13:54:00");
INSERT INTO audit_trail VALUES("900","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-03-03 13:54:02");
INSERT INTO audit_trail VALUES("901","b2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","unread","2024-03-03 15:11:39");
INSERT INTO audit_trail VALUES("902","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","unread","2024-03-03 15:11:41");
INSERT INTO audit_trail VALUES("903","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-03-03 15:11:46");
INSERT INTO audit_trail VALUES("904","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","unread","2024-03-03 15:14:08");
INSERT INTO audit_trail VALUES("905","ursn-001","DIOSA A SALVADOR","BINANGONAN","Logged In","unread","2024-03-03 15:14:13");
INSERT INTO audit_trail VALUES("906","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","","2024-03-03 15:18:42");
INSERT INTO audit_trail VALUES("907","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","","2024-03-03 15:18:52");
INSERT INTO audit_trail VALUES("908","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","","2024-03-03 15:18:56");
INSERT INTO audit_trail VALUES("909","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","","2024-03-03 15:21:17");
INSERT INTO audit_trail VALUES("910","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","","2024-03-03 15:57:16");
INSERT INTO audit_trail VALUES("911","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","","2024-03-03 20:27:24");
INSERT INTO audit_trail VALUES("912","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","","2024-03-03 20:52:05");
INSERT INTO audit_trail VALUES("913","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","","2024-03-04 13:32:17");
INSERT INTO audit_trail VALUES("914","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","","2024-03-05 15:42:23");
INSERT INTO audit_trail VALUES("915","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","","2024-03-05 17:22:26");
INSERT INTO audit_trail VALUES("916","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","","2024-03-05 17:22:38");
INSERT INTO audit_trail VALUES("917","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged Out","","2024-03-05 17:51:58");
INSERT INTO audit_trail VALUES("918","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged In","","2024-03-05 17:52:04");
INSERT INTO audit_trail VALUES("919","URSN-001","DIOSA A SALVADOR","BINANGONAN","Logged Out","","2024-03-05 17:52:29");
INSERT INTO audit_trail VALUES("920","B2021-0542","MARK LOURENCE PATANGAN QUILAB","BINANGONAN","Logged In","","2024-03-05 17:52:35");
INSERT INTO audit_trail VALUES("921","URSN-001","DIOSA A. SALVADOR","BINANGONAN","completed a request for online appointment of B2021-0542","unread","2024-03-05 18:12:09");



CREATE TABLE `campus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campus` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO campus VALUES("1","ALL");
INSERT INTO campus VALUES("2","ANGONO");
INSERT INTO campus VALUES("3","ANTIPOLO");
INSERT INTO campus VALUES("4","BINANGONAN");
INSERT INTO campus VALUES("5","CAINTA");
INSERT INTO campus VALUES("6","CARDONA");
INSERT INTO campus VALUES("7","MORONG");
INSERT INTO campus VALUES("8","PILILLA");
INSERT INTO campus VALUES("9","TANAY");
INSERT INTO campus VALUES("10","TAYTAY");
INSERT INTO campus VALUES("11","RODRIGUEZ");



CREATE TABLE `chief_complaint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chief_complaint` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO chief_complaint VALUES("1","Abdominal pain");
INSERT INTO chief_complaint VALUES("2","Allergy");
INSERT INTO chief_complaint VALUES("3","Asthma");
INSERT INTO chief_complaint VALUES("4","Back pain");
INSERT INTO chief_complaint VALUES("5","Chest pain");
INSERT INTO chief_complaint VALUES("6","Cold");
INSERT INTO chief_complaint VALUES("7","Constipation");
INSERT INTO chief_complaint VALUES("8","Cough");
INSERT INTO chief_complaint VALUES("9","Diarrhea");
INSERT INTO chief_complaint VALUES("10","Difficulty in breathing");
INSERT INTO chief_complaint VALUES("11","Dizziness");
INSERT INTO chief_complaint VALUES("12","Dysmenorrhea");
INSERT INTO chief_complaint VALUES("13","Fever");
INSERT INTO chief_complaint VALUES("14","Flu");
INSERT INTO chief_complaint VALUES("15","Headache");
INSERT INTO chief_complaint VALUES("16","Heart burn");
INSERT INTO chief_complaint VALUES("17","Injury");
INSERT INTO chief_complaint VALUES("18","Muscle pain");
INSERT INTO chief_complaint VALUES("19","Nausea");
INSERT INTO chief_complaint VALUES("20","Neck pain");
INSERT INTO chief_complaint VALUES("21","Rash");
INSERT INTO chief_complaint VALUES("22","Sprain");
INSERT INTO chief_complaint VALUES("23","Stomach ache");
INSERT INTO chief_complaint VALUES("24","Toothache");
INSERT INTO chief_complaint VALUES("25","Vomiting");
INSERT INTO chief_complaint VALUES("26","Others:");



CREATE TABLE `college` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `college` text NOT NULL COMMENT 'college and strand',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO college VALUES("2","AGRICULTURE");
INSERT INTO college VALUES("3","ARTS AND LETTERS");
INSERT INTO college VALUES("4","BUSINESS");
INSERT INTO college VALUES("5","COMPUTER STUDIES");
INSERT INTO college VALUES("6","EDUCATION");
INSERT INTO college VALUES("7","ENGINEERING");
INSERT INTO college VALUES("8","HOSPITALITY INDUSTRY");
INSERT INTO college VALUES("9","INDUSTRIAL TECHNOLOGY");
INSERT INTO college VALUES("10","NURSING");
INSERT INTO college VALUES("11","SCIENCE");
INSERT INTO college VALUES("12","SOCIAL SCIENCE");
INSERT INTO college VALUES("13","SOCIAL WORK AND COMMUNITY DEVELOPMENT");



CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abbrev` varchar(45) NOT NULL,
  `department` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO department VALUES("2","JHS","JUNIOR HIGH SCHOOL");
INSERT INTO department VALUES("3","SHS","SENIOR HIGH SCHOOL");
INSERT INTO department VALUES("4","COLLEGE","COLLEGE");
INSERT INTO department VALUES("5","ELEM.","ELEMENTARY");



CREATE TABLE `designation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO designation VALUES("1","STUDENT");
INSERT INTO designation VALUES("2","FACULTY");
INSERT INTO designation VALUES("3","STAFF");
INSERT INTO designation VALUES("4","VISITOR");



CREATE TABLE `dosage_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dosage_form` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO dosage_form VALUES("1","tablet");
INSERT INTO dosage_form VALUES("2","capsule");
INSERT INTO dosage_form VALUES("3","gel");
INSERT INTO dosage_form VALUES("4","syrup");
INSERT INTO dosage_form VALUES("5","solution");
INSERT INTO dosage_form VALUES("6","liquid");
INSERT INTO dosage_form VALUES("7","thin film");
INSERT INTO dosage_form VALUES("8","powder");
INSERT INTO dosage_form VALUES("9","paste");
INSERT INTO dosage_form VALUES("10","gas");
INSERT INTO dosage_form VALUES("11","lozenge");
INSERT INTO dosage_form VALUES("12","syrup");



CREATE TABLE `findiag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `findiag` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO findiag VALUES("1","Fever");
INSERT INTO findiag VALUES("2","Headache");
INSERT INTO findiag VALUES("3","Dysmenorrhea");
INSERT INTO findiag VALUES("4","H.E.E.N.T.");
INSERT INTO findiag VALUES("5","Respiratory");
INSERT INTO findiag VALUES("6","Trauma and Minor Surgery");
INSERT INTO findiag VALUES("7","Acid Reflux/Gastro-Intestinal Tract");
INSERT INTO findiag VALUES("8","Hyperacidity/G.I.T.");
INSERT INTO findiag VALUES("9","Diarrhea");
INSERT INTO findiag VALUES("10","Cough");
INSERT INTO findiag VALUES("11","R Bigtoe Ingrown");
INSERT INTO findiag VALUES("12","MTB - Not Detected");
INSERT INTO findiag VALUES("13","Muscle Strain");
INSERT INTO findiag VALUES("14","Toothache");
INSERT INTO findiag VALUES("15","Body Malaise");
INSERT INTO findiag VALUES("16","Arthritis");
INSERT INTO findiag VALUES("17","Allergy");
INSERT INTO findiag VALUES("18","Others:");



CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campus` varchar(45) NOT NULL,
  `batchid` varchar(45) NOT NULL COMMENT 'Format: BMdY (B for Batch, M for month, d for date, y for year - date is now() or kung kelan sila nainsert sa database)',
  `stock_type` varchar(60) NOT NULL,
  `stockid` int(11) NOT NULL,
  `opened` int(11) DEFAULT NULL,
  `closed` int(11) DEFAULT NULL,
  `qty` float NOT NULL,
  `unit_cost` float NOT NULL,
  `expiration` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT 'status ay para tools and equip lang',
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO inventory VALUES("1","BINANGONAN","B20231218","medicine","24","0","1","1","10","2024-02-01","","2024-02-28","18:11:21");
INSERT INTO inventory VALUES("2","BINANGONAN","B20231218","medicine","13","0","4","4","15","2024-03-01","","2024-02-28","18:13:47");
INSERT INTO inventory VALUES("3","BINANGONAN","B20231218","medicine","14","0","7","7","16","2026-12-02","","2024-02-28","18:14:29");
INSERT INTO inventory VALUES("4","BINANGONAN","B20231218","medicine","12","0","5","5","9","2025-11-13","","2024-02-28","18:15:37");
INSERT INTO inventory VALUES("5","BINANGONAN","B20231218","medicine","1","0","15","15","8","0000-00-00","","2024-02-28","18:16:25");
INSERT INTO inventory VALUES("6","BINANGONAN","B20231218","medicine","2","0","10","10","10","2024-06-26","","2024-02-28","18:17:15");
INSERT INTO inventory VALUES("7","BINANGONAN","B20231218","medicine","5","0","23","23","17.45","2026-11-11","","2024-02-28","18:17:43");
INSERT INTO inventory VALUES("8","BINANGONAN","B20240228","medicine","24","0","8","8","11.1","2024-07-19","","2024-02-28","18:20:42");
INSERT INTO inventory VALUES("9","BINANGONAN","B20240228","medicine","13","0","15","15","14.45","2024-06-18","","2024-02-28","18:25:50");
INSERT INTO inventory VALUES("10","BINANGONAN","B20240228","medicine","14","0","5","5","17","2025-12-10","","2024-02-28","18:27:34");
INSERT INTO inventory VALUES("11","BINANGONAN","B20240228","medicine","12","0","20","20","12","2024-04-18","","2024-02-28","18:27:59");
INSERT INTO inventory VALUES("12","BINANGONAN","B20240228","medicine","1","0","16","16","18","2024-02-29","","2024-02-28","18:28:23");
INSERT INTO inventory VALUES("13","BINANGONAN","B20240228","medicine","2","0","4","4","13","2026-07-24","","2024-02-28","18:28:45");
INSERT INTO inventory VALUES("14","BINANGONAN","B20240228","medicine","5","0","7","7","16.75","2026-05-07","","2024-02-28","18:29:13");
INSERT INTO inventory VALUES("15","BINANGONAN","B20240228","medicine","11","0","20","20","18","2024-03-21","","2024-02-28","18:29:54");
INSERT INTO inventory VALUES("16","BINANGONAN","B20240228","medicine","24","0","15","15","13","2024-10-15","","2024-02-28","18:34:49");
INSERT INTO inventory VALUES("17","BINANGONAN","B20240228","medicine","13","0","18","18","16","2025-02-19","","2024-02-28","18:35:15");
INSERT INTO inventory VALUES("18","BINANGONAN","B20240228","medicine","14","0","7","7","17","2026-07-01","","2024-02-28","18:35:33");
INSERT INTO inventory VALUES("19","BINANGONAN","B20240228","medicine","12","0","12","12","14.5","2027-10-13","","2024-02-28","18:36:11");
INSERT INTO inventory VALUES("20","BINANGONAN","B20240228","medicine","1","0","10","10","18","2028-02-11","","2024-02-28","18:36:56");
INSERT INTO inventory VALUES("21","BINANGONAN","B20240228","medicine","2","0","20","20","15","2024-09-26","","2024-02-28","18:37:17");
INSERT INTO inventory VALUES("22","BINANGONAN","B20240228","medicine","5","0","10","10","16","2025-12-16","","2024-02-28","18:38:39");
INSERT INTO inventory VALUES("23","BINANGONAN","B20240228","medicine","11","0","20","20","10","2025-11-12","","2024-02-28","18:39:31");
INSERT INTO inventory VALUES("24","BINANGONAN","B20240228","medicine","4","0","12","12","5","2024-03-08","","2024-02-28","18:39:52");
INSERT INTO inventory VALUES("25","BINANGONAN","B20240228","medicine","6","0","5","5","14","2024-03-09","","2024-02-28","18:41:18");
INSERT INTO inventory VALUES("35","BINANGONAN","B20240229","te","4","0","0","1","35000","0000-00-00","","2024-02-29","19:44:27");



CREATE TABLE `inventory_medicine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campus` varchar(45) NOT NULL,
  `medid` int(11) NOT NULL,
  `closed` int(10) unsigned DEFAULT 0,
  `open` int(10) unsigned DEFAULT 0,
  `qty` int(10) unsigned NOT NULL,
  `unit_cost` float unsigned NOT NULL,
  `expiration` date DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO inventory_medicine VALUES("1","BINANGONAN","24","1","0","1","10","2024-02-01","2024-02-28","18:11:21");
INSERT INTO inventory_medicine VALUES("2","BINANGONAN","13","4","0","4","15","2024-03-01","2024-02-28","18:13:47");
INSERT INTO inventory_medicine VALUES("3","BINANGONAN","14","7","0","7","16","2026-12-02","2024-02-28","18:14:29");
INSERT INTO inventory_medicine VALUES("4","BINANGONAN","12","5","0","5","9","2025-11-13","2024-02-28","18:15:37");
INSERT INTO inventory_medicine VALUES("5","BINANGONAN","1","15","0","15","8","0000-00-00","2024-02-28","18:16:25");
INSERT INTO inventory_medicine VALUES("6","BINANGONAN","2","10","0","10","10","2024-06-26","2024-02-28","18:17:15");
INSERT INTO inventory_medicine VALUES("7","BINANGONAN","5","23","0","23","17.45","2026-11-11","2024-02-28","18:17:43");
INSERT INTO inventory_medicine VALUES("8","BINANGONAN","24","8","0","8","11.1","2024-07-19","2024-02-28","18:20:42");
INSERT INTO inventory_medicine VALUES("9","BINANGONAN","13","15","0","15","14.45","2024-06-18","2024-02-28","18:25:50");
INSERT INTO inventory_medicine VALUES("10","BINANGONAN","14","5","0","5","17","2025-12-10","2024-02-28","18:27:34");
INSERT INTO inventory_medicine VALUES("11","BINANGONAN","12","20","0","20","12","2024-04-18","2024-02-28","18:27:59");
INSERT INTO inventory_medicine VALUES("12","BINANGONAN","1","16","0","16","18","2024-02-29","2024-02-28","18:28:23");
INSERT INTO inventory_medicine VALUES("13","BINANGONAN","2","4","0","4","13","2026-07-24","2024-02-28","18:28:45");
INSERT INTO inventory_medicine VALUES("14","BINANGONAN","5","7","0","7","16.75","2026-05-07","2024-02-28","18:29:13");
INSERT INTO inventory_medicine VALUES("15","BINANGONAN","11","20","0","20","18","2024-03-21","2024-02-28","18:29:54");
INSERT INTO inventory_medicine VALUES("16","BINANGONAN","24","15","0","15","13","2024-10-15","2024-02-28","18:34:49");
INSERT INTO inventory_medicine VALUES("17","BINANGONAN","13","18","0","18","16","2025-02-19","2024-02-28","18:35:15");
INSERT INTO inventory_medicine VALUES("18","BINANGONAN","14","7","0","7","17","2026-07-01","2024-02-28","18:35:33");
INSERT INTO inventory_medicine VALUES("19","BINANGONAN","12","12","0","12","14.5","2027-10-13","2024-02-28","18:36:11");
INSERT INTO inventory_medicine VALUES("20","BINANGONAN","1","10","0","10","18","2028-02-11","2024-02-28","18:36:56");
INSERT INTO inventory_medicine VALUES("21","BINANGONAN","2","20","0","20","15","2024-09-26","2024-02-28","18:37:17");
INSERT INTO inventory_medicine VALUES("22","BINANGONAN","5","10","0","10","16","2025-12-16","2024-02-28","18:38:39");
INSERT INTO inventory_medicine VALUES("23","BINANGONAN","11","20","0","20","10","2025-11-12","2024-02-28","18:39:31");
INSERT INTO inventory_medicine VALUES("24","BINANGONAN","4","12","0","12","5","2024-03-08","2024-02-28","18:39:52");
INSERT INTO inventory_medicine VALUES("25","BINANGONAN","6","5","0","5","14","2024-03-09","2024-02-28","18:41:18");



CREATE TABLE `inventory_supply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campus` varchar(45) NOT NULL,
  `supid` int(11) NOT NULL,
  `closed` int(10) unsigned DEFAULT 0,
  `open` int(10) unsigned DEFAULT 0,
  `qty` int(10) unsigned NOT NULL,
  `unit_cost` float unsigned NOT NULL,
  `expiration` date DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;




CREATE TABLE `inventory_te` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campus` varchar(45) NOT NULL,
  `teid` int(11) NOT NULL,
  `qty` int(10) unsigned NOT NULL,
  `unit_cost` float unsigned NOT NULL,
  `status` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO inventory_te VALUES("10","BINANGONAN","4","1","35000","4","2024-02-29","19:44:27");



CREATE TABLE `med_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `med_admin` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO med_admin VALUES("1","BUCCAL");
INSERT INTO med_admin VALUES("2","INHALABLE");
INSERT INTO med_admin VALUES("3","INFUSED");
INSERT INTO med_admin VALUES("4","INTRAMUSCULAR");
INSERT INTO med_admin VALUES("5","INTRAVENOUS");
INSERT INTO med_admin VALUES("6","NASAL");
INSERT INTO med_admin VALUES("7","OPHTHALMIC");
INSERT INTO med_admin VALUES("8","ORAL");
INSERT INTO med_admin VALUES("9","OTIC");
INSERT INTO med_admin VALUES("10","SUBCUTANEOUS");
INSERT INTO med_admin VALUES("11","SUBLINGUAL");
INSERT INTO med_admin VALUES("12","TOPICAL");
INSERT INTO med_admin VALUES("13","TRANSDERMAL");



CREATE TABLE `med_case` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medcase` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO med_case VALUES("1","Allergy and Skin Diseases");
INSERT INTO med_case VALUES("2","Cardiovascular Diseases");
INSERT INTO med_case VALUES("3","H.E.E.N.T Diseases");
INSERT INTO med_case VALUES("4","Gastro-Intestinal Cases");
INSERT INTO med_case VALUES("5","Genito-Urinary Cases");
INSERT INTO med_case VALUES("6","Musculo-Skeletal Cases");
INSERT INTO med_case VALUES("7","Neuro-Psychological Cases");
INSERT INTO med_case VALUES("8","Respiratory Cases");
INSERT INTO med_case VALUES("9","OB-Gyne Cases");
INSERT INTO med_case VALUES("10","Trauma and Minor Injury");
INSERT INTO med_case VALUES("11","Others:");



CREATE TABLE `med_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transid` int(11) NOT NULL,
  `userid` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `chiefcomplaint` text NOT NULL,
  `findings` text NOT NULL,
  `type` varchar(45) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `issued` text DEFAULT NULL,
  `referral` text DEFAULT NULL,
  `medcase` text NOT NULL,
  `medcase_desc` text DEFAULT NULL,
  `pod_nod` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `userid_idx` (`userid`),
  CONSTRAINT `userid` FOREIGN KEY (`userid`) REFERENCES `account` (`accountid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO med_history VALUES("1","1","B2021-0542","2024-02-09","00:12:00","01:00:00","Headache, Stomach ache, Nausea","Diarrhea","","","2 Loperamide 2 mg/tab","","Gastro-Intestinal Cases","","DIOSA A. SALVADOR","2023-12-08 00:00:00");
INSERT INTO med_history VALUES("2","13","B2021-0569","0000-00-00","00:00:00","00:00:00","Chest pain, Stomach ache","Heartburn","","","2 Cimetidine 40 mg/tab","Take medicine twice a day.","Gastro-Intestinal Cases","","DIOSA A. SALVADOR","2023-12-08 00:00:00");



CREATE TABLE `meddoc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL COMMENT 'OJT/SIT/WAP, ROTC, FRESHMEN, ATHLETE/VARSITY',
  `applicant` varchar(45) NOT NULL,
  `doc_desc` varchar(45) NOT NULL,
  `document` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `remarks` text DEFAULT NULL,
  `dt_remarks` datetime DEFAULT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `applicant_idx` (`applicant`),
  CONSTRAINT `applicant` FOREIGN KEY (`applicant`) REFERENCES `account` (`accountid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO meddoc VALUES("1","FRESHMEN","B2021-0542","X-Ray","FRESHMEN-B2021-0542-113925X-Ray.jpeg","Pending","","","2024-02-04 09:12:33");
INSERT INTO meddoc VALUES("2","FRESHMEN","B2021-0542","CBC","B2021-0542-021152CBC.png","Pending","","","2024-02-04 09:53:06");
INSERT INTO meddoc VALUES("3","FRESHMEN","B2021-0542","DRUG TEST","B2021-0542-021218DRUG TEST.png","Pending","","","2024-02-04 09:53:06");
INSERT INTO meddoc VALUES("4","ATHLETE","B2021-0542","CBC","ATHLETE-B2021-0542-120011CBC.png","Pending","","","2024-02-12 11:18:18");
INSERT INTO meddoc VALUES("5","ATHLETE","B2021-0542","Urinalysis","ATHLETE-B2021-0542-120125Urinalysis.png","Pending","","","2024-02-12 11:18:18");
INSERT INTO meddoc VALUES("6","ATHLETE","B2021-0542","Pregnancy Test","ATHLETE-B2021-0542-120232Pregnancy Test.jpg","Pending","","","2024-02-12 11:18:18");
INSERT INTO meddoc VALUES("7","ATHLETE","B2021-0542","X-Ray","ATHLETE-B2021-0542-113907X-Ray.jpeg","Pending","","","2024-02-12 11:18:18");
INSERT INTO meddoc VALUES("11","ATHLETE","B2021-0550","X-Ray","nofile.png","Pending","","","2024-02-12 11:18:18");
INSERT INTO meddoc VALUES("12","ATHLETE","B2021-0550","Pregnancy Test","nofile.png","Pending","","","2024-02-12 11:18:18");
INSERT INTO meddoc VALUES("13","ATHLETE","B2021-0550","Urinalysis","nofile.png","Pending","","","2024-02-12 11:18:18");
INSERT INTO meddoc VALUES("14","ATHLETE","B2021-0550","CBC","nofile.png","Pending","","","2024-02-12 11:18:18");
INSERT INTO meddoc VALUES("15","FRESHMEN","B2021-0550","X-Ray","nofile.png","Pending","","","2024-02-04 09:12:33");
INSERT INTO meddoc VALUES("16","FRESHMEN","B2021-0550","CBC","nofile.png","Pending","","","2024-02-04 09:53:06");
INSERT INTO meddoc VALUES("17","FRESHMEN","B2021-0550","DRUG TEST","nofile.png","Pending","","","2024-02-04 09:53:06");
INSERT INTO meddoc VALUES("18","OJT","B2021-0542","CBC","nofile.png","Pending","","","2024-02-12 11:18:18");
INSERT INTO meddoc VALUES("19","OJT","B2021-0542","Urinalysis","nofile.png","Pending","","","2024-02-12 11:18:18");
INSERT INTO meddoc VALUES("20","OJT","B2021-0542","Pregnancy Test","nofile.png","Pending","","","2024-02-12 11:18:18");
INSERT INTO meddoc VALUES("21","OJT","B2021-0542","X-Ray","nofile.png","Pending","","","2024-02-12 11:18:18");



CREATE TABLE `meddoc_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  `applicant` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  `remarks` text DEFAULT NULL COMMENT 'meron lang remarks if disapproved',
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `application_idx` (`applicant`),
  CONSTRAINT `application` FOREIGN KEY (`applicant`) REFERENCES `account` (`accountid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;




CREATE TABLE `meddoc_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meddoc_status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO meddoc_status VALUES("1","Approved");
INSERT INTO meddoc_status VALUES("2","Disapproved");
INSERT INTO meddoc_status VALUES("3","Pending");



CREATE TABLE `meddoc_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meddoc_type` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO meddoc_type VALUES("1","ATHLETE/VARSITY");
INSERT INTO meddoc_type VALUES("2","FRESHMEN");
INSERT INTO meddoc_type VALUES("3","ROTC");
INSERT INTO meddoc_type VALUES("4","OJT/SIT/WAP");



CREATE TABLE `medicine` (
  `medid` int(11) NOT NULL AUTO_INCREMENT,
  `med_admin` varchar(45) NOT NULL,
  `medicine` varchar(100) NOT NULL,
  `dosage` float NOT NULL,
  `dosage_form` varchar(45) NOT NULL,
  `unit_measure` varchar(45) NOT NULL,
  `datetime` datetime NOT NULL,
  `state` varchar(45) NOT NULL COMMENT 'per piece/open-close',
  PRIMARY KEY (`medid`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO medicine VALUES("1","ORAL","Ambroxol","30","tablet","mg/tab","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("2","ORAL","Amoxicillin","500","capsule","mg/cap","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("3","ORAL","Paracetamol","500","capsule tablet","mg/caplet","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("4","ORAL","Clonidine HCL","75","tablet","mcg/tab","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("5","ORAL","Cefelaxin","500","tablet","mg/tab","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("6","ORAL","Cloxacillin","500","capsule","mg/cap","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("7","ORAL","Decolsin","15","capsule","mg/cap","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("8","ORAL","Decolsin","25","capsule","mg/cap","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("9","ORAL","Decolsin","325","capsule","mg/cap","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("10","ORAL","Dequalinium chloride","0.25","lozenge","mg/loz","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("11","ORAL","Chlorpheniramine maleate","500","capsule","mg/cap","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("12","ORAL","Aluminum Hydroxide/Magnesium Hydroxide/Simethicone","30","tablet","mg/tab","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("13","ORAL","Aluminum Hydroxide/Magnesium Hydroxide/Simethicone","178","tablet","mg/tab","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("14","ORAL","Aluminum Hydroxide/Magnesium Hydroxide/Simethicone","233","tablet","mg/tab","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("15","ORAL","Loperamide","2","capsule","mg/cap","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("16","ORAL","Loratadine","10","tablet","mg/tab","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("17","ORAL","Meclizine","25","tablet","mcg/tab","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("18","ORAL","Ibuprofen","200","tablet","mg/tab","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("19","ORAL","Ibuprofen","200","capsule gel","mg/capgel","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("20","ORAL","Mefenamic acid","500","capsule","mg/cap","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("21","ORAL","Omeprazole","40","tablet","mg/tab","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("22","ORAL","Salbutamol Nebule","2.5","ampule","ml","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("23","ORAL","Sinc Sulfate","60","syrup","ml","2023-12-09 16:06:59","per piece");
INSERT INTO medicine VALUES("24","BUCCAL","BUCCAL","10","eh","mg","2023-12-15 10:52:48","per piece");



CREATE TABLE `organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campus` varchar(45) NOT NULL,
  `adminid` varchar(45) DEFAULT NULL,
  `firstname` varchar(65) NOT NULL,
  `middlename` varchar(65) DEFAULT NULL,
  `lastname` varchar(65) NOT NULL,
  `extension` varchar(45) NOT NULL,
  `title` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO organization VALUES("1","UNIVERSITY","URSD-001","EDNA","C","MAYCACAYAN","MD","Head, Health Services Unit");
INSERT INTO organization VALUES("2","BINANGONAN","URSN-001","DIOSA","A","SALVADOR","RN","Campus Nurse");
INSERT INTO organization VALUES("3","BINANGONAN","URSN-002","MARY ANN","V","CASTRO","RN","Campus Nurse");
INSERT INTO organization VALUES("4","BINANGONAN","","EDEN","C","SANTOS","DBA","Campus Director");



CREATE TABLE `patient_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_id` varchar(45) NOT NULL,
  `image` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO patient_image VALUES("1","B2021-0542","B2021-0542-064011.png","2024-01-31 22:47:26");
INSERT INTO patient_image VALUES("2","B2021-0569","B2021-0569-091350.jpg","2024-02-22 16:13:38");
INSERT INTO patient_image VALUES("3","B2021-0542","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("4","B2021-0550","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("5","B2021-0576","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("6","B2021-0588","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("7","URS-960","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("8","URS-961","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("9","URS-962","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("10","URS-967","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("11","URS-968","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("12","URS-969","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("13","URS-970","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("14","URS-971","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("15","URS-972","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("16","URS-973","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("17","URS-974","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("18","URS-975","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("19","URS-976","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("20","URS-977","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("21","URS-978","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("22","URS-979","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("23","URS-980","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("24","URS-981","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("25","URS-982","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("26","URS-983","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("27","URS-984","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("28","URS-985","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("29","URS-986","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("30","URS-987","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("31","URS-988","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("32","URS-989","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("33","URS-990","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("34","URS-991","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("35","URS-992","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("36","URS-993","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("37","URS-996","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("38","URS-997","noprofile.png","2024-02-29 11:38:45");
INSERT INTO patient_image VALUES("39","URSF-000","noprofile.png","2024-02-29 11:38:45");



CREATE TABLE `patient_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` varchar(45) NOT NULL,
  `designation` varchar(45) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` varchar(45) NOT NULL,
  `birthday` date NOT NULL,
  `department` varchar(45) NOT NULL,
  `campus` varchar(45) NOT NULL,
  `college` varchar(45) DEFAULT NULL,
  `program` text DEFAULT NULL,
  `yearlevel` varchar(45) DEFAULT NULL,
  `section` varchar(45) DEFAULT NULL,
  `block` varchar(10) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `contactno` varchar(45) NOT NULL,
  `emcon_name` varchar(200) NOT NULL,
  `emcon_number` varchar(45) NOT NULL,
  `datetime_created` datetime NOT NULL,
  `datetime_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `patientid` (`patientid`),
  CONSTRAINT `patientid` FOREIGN KEY (`patientid`) REFERENCES `account` (`accountid`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO patient_info VALUES("1","B2021-0542","STUDENT","20","MALE","2003-04-23","COLLEGE","BINANGONAN","COMPUTER STUDIES","BSIT","4","1","B","quilabmarklourence@gmail.com","09556873950","MARNY QUILAB","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("2","B2021-0550","STUDENT","21","MALE","2002-09-25","COLLEGE","BINANGONAN","COMPUTER STUDIES","BSIT","3","1","A","jomcordero7@gmail.com","09475081720","JOY WILLSON","09235961061","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("3","B2021-0569","STUDENT","20","FEMALE","2003-08-25","COLLEGE","BINANGONAN","COMPUTER STUDIES","BSIT","3","1","A","juleannerozier@gmail.com","09677223456","APRIL JILL R. CARANZA","09057892990","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("4","B2021-0576","STUDENT","22","FEMALE","2001-02-04","COLLEGE","BINANGONAN","COMPUTER STUDIES","BSIT","3","1","B","yssabueno04@gmail.com","09214329360","LEONISA B. BANGAYAN","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("5","B2021-0588","STUDENT","21","MALE","2002-04-29","COLLEGE","BINANGONAN","COMPUTER STUDIES","BSIT","4","1","B","kianruiz824@gmail.com","0920426332","JOCELYN RUIZ","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("6","URS-960","STUDENT","20","FEMALE","2003-09-24","COLLEGE","CARDONA","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("7","URS-968","STUDENT","21","MALE","2002-11-30","COLLEGE","PILILLA","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("8","URS-970","STUDENT","22","MALE","2001-01-01","COLLEGE","CAINTA","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("9","URS-971","STUDENT","20","FEMALE","2003-07-12","COLLEGE","TAYTAY","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("10","URS-972","STUDENT","21","MALE","2002-04-18","COLLEGE","TANAY","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("11","URS-973","STUDENT","22","FEMALE","2001-03-19","COLLEGE","ANTIPOLO","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("12","URS-975","STUDENT","23","FEMALE","2000-05-15","COLLEGE","MORONG","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("13","URS-976","STUDENT","24","MALE","1999-02-27","COLLEGE","MORONG","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("14","URS-977","STUDENT","23","MALE","2000-09-17","COLLEGE","MORONG","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("15","URS-980","STUDENT","21","FEMALE","2002-11-02","COLLEGE","RODRIGUEZ","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("16","URS-981","STUDENT","22","FEMALE","2001-08-25","COLLEGE","RODRIGUEZ","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("17","URS-986","STUDENT","25","FEMALE","1998-02-01","COLLEGE","ANTIPOLO","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("18","URS-987","STUDENT","19","FEMALE","2004-01-29","COLLEGE","MORONG","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("19","URS-990","STUDENT","24","MALE","1999-05-22","COLLEGE","TAYTAY","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("20","URS-991","STUDENT","26","MALE","1997-12-01","COLLEGE","TANAY","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("21","URS-993","STUDENT","19","MALE","2004-06-06","COLLEGE","ANGONO","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 00:13:55","2023-12-08 00:13:55");
INSERT INTO patient_info VALUES("22","URS-961","FACULTY","35","FEMALE","1988-08-30","COLLEGE","BINANGONAN","ACCOUNTANCY","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO patient_info VALUES("23","URS-969","FACULTY","41","FEMALE","1982-09-13","JHS","CAINTA","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO patient_info VALUES("24","URS-979","FACULTY","23","MALE","2000-07-23","SHS","PILILLA","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO patient_info VALUES("25","URS-983","FACULTY","22","MALE","2001-01-05","SHS","TANAY","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO patient_info VALUES("26","URS-984","FACULTY","25","MALE","1998-12-11","JHS","CAINTA","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 17:39:57","2023-12-08 17:39:57");
INSERT INTO patient_info VALUES("27","URS-989","FACULTY","28","FEMALE","1995-05-15","JHS","TAYTAY","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 03:12:34","2023-12-08 03:12:34");
INSERT INTO patient_info VALUES("28","URS-992","FACULTY","27","FEMALE","1996-06-06","COLLEGE","PILILLA","","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 03:12:34","2023-12-08 03:12:34");
INSERT INTO patient_info VALUES("29","URSF-000","FACULTY","26","FEMALE>","1997-07-08","COLLEGE","BINANGONAN","BUSINESS","","","","","email@email.com","09123456789","ANON D. DUMMY","09123456789","2023-12-08 03:12:34","2024-02-28 12:59:15");



CREATE TABLE `program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(45) NOT NULL COMMENT 'college, shs, jhs, lab',
  `college` text NOT NULL,
  `abbrev` varchar(45) NOT NULL,
  `program` text NOT NULL COMMENT 'program or strand',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO program VALUES("1","COLLEGE","COMPUTER STUDIES","BSIT","BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY");
INSERT INTO program VALUES("2","COLLEGE","COMPUTER STUDIES","BSIS","BACHELOR OF SCIENCE IN INFORMATION SYSTEM");
INSERT INTO program VALUES("3","COLLEGE","ACCOUNTANCY","BSA","BACHELOR OF SCIENCE IN ACCOUNTANCY");
INSERT INTO program VALUES("4","COLLEGE","BUSINESS","BSBA-FM","BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN FINANCIAL MANAGEMENT");
INSERT INTO program VALUES("5","COLLEGE","BUSINESS","BSBA-HRDM","BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN HUMAN RESOURCE DEVELOPMENT MANAGEMENT");
INSERT INTO program VALUES("6","COLLEGE","BUSINESS","BSBA-OM","BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN OPERATIONS MANAGEMENT");
INSERT INTO program VALUES("7","COLLEGE","BUSINESS","BSBA-MM","BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN MARKETING MANAGEMENT");
INSERT INTO program VALUES("8","COLLEGE","BUSINESS","BSBA-BEM","BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION MAJOR IN BUSINESS ECONOMICS MANAGEMENT");



CREATE TABLE `report_medsupinv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campus` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL,
  `admin` varchar(45) DEFAULT NULL,
  `medid` varchar(45) NOT NULL,
  `medicine` text NOT NULL,
  `bqty` int(10) unsigned DEFAULT 0,
  `buc` float unsigned DEFAULT 0,
  `rqty` int(10) unsigned DEFAULT 0,
  `tqty` int(10) unsigned DEFAULT 0,
  `iqty` int(10) unsigned DEFAULT 0,
  `iamt` float unsigned DEFAULT 0,
  `eqty` int(10) unsigned DEFAULT 0,
  `eamt` float unsigned DEFAULT 0,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO report_medsupinv VALUES("1","BINANGONAN","med_admin","BUCCAL","1","BUCCAL","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO report_medsupinv VALUES("2","BINANGONAN","medicine","BUCCAL","24","BUCCAL 10mg","0","0","1","1","0","0","1","10","2023-12-31");
INSERT INTO report_medsupinv VALUES("3","BINANGONAN","med_admin","ORAL","8","ORAL","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO report_medsupinv VALUES("4","BINANGONAN","medicine","ORAL","13","Aluminum Hydroxide/Magnesium Hydroxide/Simethicone 178mg/tab","0","0","4","4","0","0","4","60","2023-12-31");
INSERT INTO report_medsupinv VALUES("5","BINANGONAN","medicine","ORAL","14","Aluminum Hydroxide/Magnesium Hydroxide/Simethicone 233mg/tab","0","0","7","7","0","0","7","112","2023-12-31");
INSERT INTO report_medsupinv VALUES("6","BINANGONAN","medicine","ORAL","12","Aluminum Hydroxide/Magnesium Hydroxide/Simethicone 30mg/tab","0","0","5","5","0","0","5","45","2023-12-31");
INSERT INTO report_medsupinv VALUES("7","BINANGONAN","medicine","ORAL","1","Ambroxol 30mg/tab","0","0","15","15","0","0","15","120","2023-12-31");
INSERT INTO report_medsupinv VALUES("8","BINANGONAN","medicine","ORAL","2","Amoxicillin 500mg/cap","0","0","10","10","0","0","10","100","2023-12-31");
INSERT INTO report_medsupinv VALUES("9","BINANGONAN","medicine","ORAL","5","Cefelaxin 500mg/tab","0","0","23","23","0","0","23","401.35","2023-12-31");
INSERT INTO report_medsupinv VALUES("10","BINANGONAN","med_admin","BUCCAL","1","BUCCAL","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO report_medsupinv VALUES("11","BINANGONAN","medicine","BUCCAL","24","BUCCAL 10mg","1","10.98","8","8","0","0","9","98.8","2024-01-31");
INSERT INTO report_medsupinv VALUES("12","BINANGONAN","med_admin","ORAL","8","ORAL","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO report_medsupinv VALUES("13","BINANGONAN","medicine","ORAL","13","Aluminum Hydroxide/Magnesium Hydroxide/Simethicone 178mg/tab","4","14.57","15","15","0","0","19","276.75","2024-01-31");
INSERT INTO report_medsupinv VALUES("14","BINANGONAN","medicine","ORAL","14","Aluminum Hydroxide/Magnesium Hydroxide/Simethicone 233mg/tab","7","16.42","5","5","0","0","12","197","2024-01-31");
INSERT INTO report_medsupinv VALUES("15","BINANGONAN","medicine","ORAL","12","Aluminum Hydroxide/Magnesium Hydroxide/Simethicone 30mg/tab","5","11.4","20","20","0","0","25","285","2024-01-31");
INSERT INTO report_medsupinv VALUES("16","BINANGONAN","medicine","ORAL","1","Ambroxol 30mg/tab","15","13.16","16","16","0","0","31","408","2024-01-31");
INSERT INTO report_medsupinv VALUES("17","BINANGONAN","medicine","ORAL","2","Amoxicillin 500mg/cap","10","10.86","4","4","0","0","14","152","2024-01-31");
INSERT INTO report_medsupinv VALUES("18","BINANGONAN","medicine","ORAL","5","Cefelaxin 500mg/tab","23","17.29","7","7","0","0","30","518.6","2024-01-31");
INSERT INTO report_medsupinv VALUES("19","BINANGONAN","medicine","ORAL","11","Chlorpheniramine maleate 500mg/cap","0","0","20","20","0","0","20","360","2024-01-31");
INSERT INTO report_medsupinv VALUES("20","BINANGONAN","med_admin","BUCCAL","1","BUCCAL","0","0","0","0","0","0","0","0","2024-02-29");
INSERT INTO report_medsupinv VALUES("21","BINANGONAN","medicine","BUCCAL","24","BUCCAL 10mg","9","12.24","15","15","0","0","24","293.8","2024-02-29");
INSERT INTO report_medsupinv VALUES("22","BINANGONAN","med_admin","ORAL","8","ORAL","0","0","0","0","0","0","0","0","2024-02-29");
INSERT INTO report_medsupinv VALUES("23","BINANGONAN","medicine","ORAL","13","Aluminum Hydroxide/Magnesium Hydroxide/Simethicone 178mg/tab","19","15.26","18","18","0","0","37","564.75","2024-02-29");
INSERT INTO report_medsupinv VALUES("24","BINANGONAN","medicine","ORAL","14","Aluminum Hydroxide/Magnesium Hydroxide/Simethicone 233mg/tab","12","16.63","7","7","0","0","19","316","2024-02-29");
INSERT INTO report_medsupinv VALUES("25","BINANGONAN","medicine","ORAL","12","Aluminum Hydroxide/Magnesium Hydroxide/Simethicone 30mg/tab","25","12.41","12","12","0","0","37","459","2024-02-29");
INSERT INTO report_medsupinv VALUES("26","BINANGONAN","medicine","ORAL","1","Ambroxol 30mg/tab","31","14.34","10","10","0","0","41","588","2024-02-29");
INSERT INTO report_medsupinv VALUES("27","BINANGONAN","medicine","ORAL","2","Amoxicillin 500mg/cap","14","13.29","20","20","0","0","34","452","2024-02-29");
INSERT INTO report_medsupinv VALUES("28","BINANGONAN","medicine","ORAL","5","Cefelaxin 500mg/tab","30","16.97","10","10","0","0","40","678.6","2024-02-29");
INSERT INTO report_medsupinv VALUES("29","BINANGONAN","medicine","ORAL","11","Chlorpheniramine maleate 500mg/cap","20","14","20","20","0","0","40","560","2024-02-29");
INSERT INTO report_medsupinv VALUES("30","BINANGONAN","medicine","ORAL","4","Clonidine HCL 75mcg/tab","0","0","12","12","0","0","12","60","2024-02-29");
INSERT INTO report_medsupinv VALUES("31","BINANGONAN","medicine","ORAL","6","Cloxacillin 500mg/cap","0","0","5","5","0","0","5","70","2024-02-29");



CREATE TABLE `report_teinv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campus` varchar(45) NOT NULL,
  `teid` int(11) NOT NULL,
  `tools_equip` text NOT NULL,
  `bnw` int(10) unsigned DEFAULT 0,
  `bum` int(10) unsigned DEFAULT 0,
  `bgc` int(10) unsigned DEFAULT 0,
  `bd` int(10) unsigned DEFAULT 0,
  `btqty` int(10) unsigned DEFAULT 0,
  `buc` float unsigned DEFAULT 0,
  `rnw` int(10) unsigned DEFAULT 0,
  `rum` int(10) unsigned DEFAULT 0,
  `rgc` int(10) unsigned DEFAULT 0,
  `rd` int(10) unsigned DEFAULT 0,
  `rtqty` int(10) unsigned DEFAULT 0,
  `enw` int(10) unsigned DEFAULT 0,
  `eum` int(10) unsigned DEFAULT 0,
  `egc` int(10) unsigned DEFAULT 0,
  `ed` int(10) unsigned DEFAULT 0,
  `etqty` int(10) unsigned DEFAULT 0,
  `eamt` float unsigned DEFAULT 0,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO report_teinv VALUES("10","BINANGONAN","4","Art P6 Piezo Electric Compact Size Scaler","0","0","0","0","0","0","1","0","0","0","1","0","1","0","0","1","35000","2024-02-29");



CREATE TABLE `reports_medcase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campus` varchar(45) NOT NULL,
  `type` varchar(45) NOT NULL COMMENT 'main, others, checkups',
  `medcase` text NOT NULL,
  `sm` int(10) unsigned DEFAULT 0,
  `sf` int(10) unsigned DEFAULT 0,
  `st` int(10) unsigned DEFAULT 0,
  `pm` int(10) unsigned DEFAULT 0,
  `pf` int(10) unsigned DEFAULT 0,
  `pt` int(10) unsigned DEFAULT 0,
  `gm` int(10) unsigned DEFAULT 0,
  `gf` int(10) unsigned DEFAULT 0,
  `gt` int(10) unsigned DEFAULT 0,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO reports_medcase VALUES("1","BINANGONAN","main","Allergy and Skin Diseases","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("2","BINANGONAN","main","Cardiovascular Diseases","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("3","BINANGONAN","main","H.E.E.N.T Diseases","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("4","BINANGONAN","main","Gastro-Intestinal Cases","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("5","BINANGONAN","main","Genito-Urinary Cases","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("6","BINANGONAN","main","Musculo-Skeletal Cases","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("7","BINANGONAN","main","Neuro-Psychological Cases","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("8","BINANGONAN","main","Respiratory Cases","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("9","BINANGONAN","main","OB-Gyne Cases","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("10","BINANGONAN","main","Trauma and Minor Injury","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("11","BINANGONAN","others","COVID-19 Probable Cases","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("12","BINANGONAN","others","COVID-19 Confirmed Cases","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("13","BINANGONAN","checkups","Freshmen","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("14","BINANGONAN","checkups","Athlete/Varsity","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("15","BINANGONAN","checkups","ROTC","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("16","BINANGONAN","checkups","OJT/SIT/WAP","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("17","BINANGONAN","checkups","Medical Certification","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("18","BINANGONAN","checkups","Others: BP/Ht/RBS/Wt Monitoring","0","0","0","0","0","0","0","0","0","2023-12-31");
INSERT INTO reports_medcase VALUES("19","BINANGONAN","main","Allergy and Skin Diseases","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("20","BINANGONAN","main","Cardiovascular Diseases","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("21","BINANGONAN","main","H.E.E.N.T Diseases","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("22","BINANGONAN","main","Gastro-Intestinal Cases","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("23","BINANGONAN","main","Genito-Urinary Cases","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("24","BINANGONAN","main","Musculo-Skeletal Cases","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("25","BINANGONAN","main","Neuro-Psychological Cases","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("26","BINANGONAN","main","Respiratory Cases","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("27","BINANGONAN","main","OB-Gyne Cases","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("28","BINANGONAN","main","Trauma and Minor Injury","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("29","BINANGONAN","checkups","Freshmen","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("30","BINANGONAN","checkups","Athlete/Varsity","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("31","BINANGONAN","checkups","ROTC","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("32","BINANGONAN","checkups","OJT/SIT/WAP","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("33","BINANGONAN","checkups","Medical Certification","0","0","0","0","0","0","0","0","0","2024-01-31");
INSERT INTO reports_medcase VALUES("34","BINANGONAN","checkups","Others: BP/Ht/RBS/Wt Monitoring","0","0","0","0","0","0","0","0","0","2024-01-31");



CREATE TABLE `request_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_type` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO request_type VALUES("1","Medicine","2024-02-12 19:54:09");
INSERT INTO request_type VALUES("2","Medical Supply","2024-02-12 19:54:09");
INSERT INTO request_type VALUES("3","Medical Clearance","2024-02-12 19:54:38");
INSERT INTO request_type VALUES("4","Medical Certificate","2024-02-12 19:54:38");



CREATE TABLE `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `physician` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `campus` varchar(45) NOT NULL,
  `maxp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `physician_idx` (`physician`),
  CONSTRAINT `physician` FOREIGN KEY (`physician`) REFERENCES `account` (`accountid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO schedule VALUES("1","URSD-001","2023-12-11","08:00:00","15:00:00","BINANGONAN","20");
INSERT INTO schedule VALUES("2","URSD-001","2023-12-12","10:00:00","16:00:00","BINANGONAN","10");
INSERT INTO schedule VALUES("3","URSD-001","2024-01-09","08:00:00","15:00:00","BINANGONAN","30");
INSERT INTO schedule VALUES("4","URSD-001","2024-01-04","08:00:00","15:00:00","ANGONO","30");
INSERT INTO schedule VALUES("5","URSD-001","2024-01-05","08:00:00","15:00:00","ANTIPOLO","30");
INSERT INTO schedule VALUES("6","URSD-001","2024-01-08","10:00:00","17:00:00","CAINTA","20");
INSERT INTO schedule VALUES("7","URSD-001","2024-01-10","08:00:00","15:00:00","CARDONA","20");
INSERT INTO schedule VALUES("8","URSD-001","2024-01-11","08:00:00","15:00:00","MORONG","50");
INSERT INTO schedule VALUES("9","URSD-001","2024-01-12","08:00:00","15:00:00","PILILLA","30");
INSERT INTO schedule VALUES("10","URSD-001","2024-01-15","09:00:00","16:00:00","RODRIGUEZ","50");
INSERT INTO schedule VALUES("11","URSD-001","2024-01-16","08:00:00","15:00:00","TANAY","10");
INSERT INTO schedule VALUES("12","URSD-001","2024-01-17","08:00:00","15:00:00","TAYTAY","20");
INSERT INTO schedule VALUES("13","URSD-001","2024-01-18","08:00:00","15:00:00","ANGONO","30");
INSERT INTO schedule VALUES("14","URSD-001","2024-01-19","09:00:00","16:00:00","ANTIPOLO","10");
INSERT INTO schedule VALUES("15","URSD-001","2024-01-22","08:00:00","15:00:00","CAINTA","20");
INSERT INTO schedule VALUES("16","URSD-001","2024-01-23","10:00:00","17:00:00","CARDONA","35");
INSERT INTO schedule VALUES("17","URSD-001","2024-01-24","08:00:00","15:00:00","MORONG","20");
INSERT INTO schedule VALUES("18","URSD-001","2024-01-25","08:00:00","15:00:00","PILILLA","15");
INSERT INTO schedule VALUES("19","URSD-001","2023-01-26","12:00:00","18:00:00","RODRIGUEZ","45");
INSERT INTO schedule VALUES("20","URSD-002","2023-01-04","08:00:00","15:00:00","CARDONA","10");
INSERT INTO schedule VALUES("21","URSD-002","2023-01-05","10:00:00","17:00:00","CAINTA","5");
INSERT INTO schedule VALUES("22","URSD-002","2023-01-08","08:00:00","15:00:00","BINANGONAN","15");
INSERT INTO schedule VALUES("23","URSD-002","2023-01-09","10:00:00","17:00:00","ANGONO","10");
INSERT INTO schedule VALUES("24","URSD-002","2023-01-10","09:00:00","16:00:00","ANTIPOLO","5");
INSERT INTO schedule VALUES("25","URSD-002","2023-01-11","08:00:00","15:00:00","MORONG","5");
INSERT INTO schedule VALUES("26","URSD-002","2023-01-12","09:00:00","16:00:00","PILILLA","15");
INSERT INTO schedule VALUES("27","URSD-002","2023-01-15","10:00:00","17:00:00","RODRIGUEZ","10");
INSERT INTO schedule VALUES("28","URSD-002","2023-01-16","10:00:00","17:00:00","TANAY","10");
INSERT INTO schedule VALUES("29","URSD-002","2023-01-17","08:00:00","15:00:00","TAYTAY","5");
INSERT INTO schedule VALUES("32","URSD-002","2024-02-28","09:00:00","16:00:00","BINANGONAN","20");
INSERT INTO schedule VALUES("33","URSD-001","2024-02-29","09:00:00","14:00:00","BINANGONAN","10");



CREATE TABLE `supply` (
  `supid` int(11) NOT NULL AUTO_INCREMENT,
  `supply` text NOT NULL,
  `volume` float DEFAULT NULL,
  `unit_measure` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `state` varchar(45) NOT NULL COMMENT 'per piece/open-close',
  PRIMARY KEY (`supid`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO supply VALUES("1","Anti-Septic Plastic Strips","100","strips/box","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("2","Povidone Iodine Dry Powder Spray","55","g/bot","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("3","Pramoxine/calamine topical","100","ml","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("4","Isophrophyl Alcohol Spray","330","ml","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("5","Isophrophyl Alcohol Spray","500","ml","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("6","Kamillosan M Spray","15","ml","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("7","Methyl Salicylate","60","ml/bot","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("8","BSI Medicated Spray","75","ml","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("9","Perskindol Muscle Spray","150","ml/can","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("10","Povidone Iodine","120","ml","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("11","Pain Patch","10","s/pack","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("12","White Flower","20","ml","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("13","Fuji1, glass ionomer","","pcs","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("14","Fuji 2, glass ionomer","","pcs","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("15","Gel Foam","","pcs","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("16","Suture thread, silk 3.0","","pcs","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("17","Suture needle","","pcs","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("18","Disposable Towel","","pcs","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("19","Elastic Bandage","","pcs","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("20","Face Mask","50","pcs/box","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("21","Latex Gloves ","100","pcs/box","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("22","Leukoplast tape","","","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("23","Muscle tape","","","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("24","Muller Tape","","roll/box","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("25","Sterile Syringe 10cc","","pc","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("26","Sterile Syringe 5cc","","pc","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("27","Sterile Syringe 1cc","","pc","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("28","Triangular Bandage","","","2023-12-09 19:38:58","open-close");
INSERT INTO supply VALUES("29","Nebulize Kit","","","2023-12-09 19:54:04","open-close");
INSERT INTO supply VALUES("30","Sterile Gause Pad 3x3","","pc","2023-12-09 19:57:12","per piece");
INSERT INTO supply VALUES("31","Sterile Gause Pad 4x4","","pc","2023-12-09 19:57:12","per piece");
INSERT INTO supply VALUES("32","Intravenous Catheter gauge 24","","","2023-12-09 20:00:21","per piece");
INSERT INTO supply VALUES("33","Intravenous Catheter gauge 22","","","2023-12-09 20:00:21","per piece");
INSERT INTO supply VALUES("34","Intravenous macroset","","","2023-12-09 20:00:21","per piece");
INSERT INTO supply VALUES("35","Mupirocin Ointment","5","g/tube","2023-12-09 20:11:20","open-close");
INSERT INTO supply VALUES("36","Silvadene, Thermazene","20","mg/tube","2023-12-09 20:11:20","open-close");
INSERT INTO supply VALUES("37","Cotton Balls","","","2023-12-09 20:11:20","open-close");
INSERT INTO supply VALUES("38","IV Fluid","","","2023-12-09 20:11:20","per-piece");



CREATE TABLE `te_calimain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campus` varchar(45) NOT NULL,
  `tools_equip` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status_idx` (`status`),
  KEY `teid_idx` (`tools_equip`),
  CONSTRAINT `status` FOREIGN KEY (`status`) REFERENCES `te_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `teid` FOREIGN KEY (`tools_equip`) REFERENCES `tools_equip` (`teid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO te_calimain VALUES("10","BINANGONAN","4","2024-02-23","2024-02-16","1");
INSERT INTO te_calimain VALUES("11","BINANGONAN","4","2024-02-29","2024-02-29","4");
INSERT INTO te_calimain VALUES("12","BINANGONAN","4","2024-02-29","2024-02-29","3");
INSERT INTO te_calimain VALUES("13","BINANGONAN","4","2024-02-29","2024-02-29","4");
INSERT INTO te_calimain VALUES("14","BINANGONAN","4","2024-02-29","2024-02-29","4");
INSERT INTO te_calimain VALUES("15","BINANGONAN","4","2024-02-17","2024-02-29","4");



CREATE TABLE `te_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `te_status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO te_status VALUES("1","Good Condition");
INSERT INTO te_status VALUES("2","Not Working");
INSERT INTO te_status VALUES("3","Damaged");
INSERT INTO te_status VALUES("4","Under Maintenance");



CREATE TABLE `tools_equip` (
  `teid` int(11) NOT NULL AUTO_INCREMENT,
  `tools_equip` text NOT NULL,
  `unit_measure` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`teid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tools_equip VALUES("1","Hot water bag 500ml","","2023-12-09 20:16:59");
INSERT INTO tools_equip VALUES("2","Tebi-pack hot and cold","","2023-12-09 20:16:59");
INSERT INTO tools_equip VALUES("3","Digital Thermometer","","2023-12-09 20:16:59");
INSERT INTO tools_equip VALUES("4","Art P6 Piezo Electric Compact Size Scaler","","2023-12-09 20:16:59");
INSERT INTO tools_equip VALUES("5","Dental Explorer","","2023-12-09 20:16:59");
INSERT INTO tools_equip VALUES("6","Mouth Mirror","","2023-12-09 20:16:59");
INSERT INTO tools_equip VALUES("7","Cotton Plier","","2023-12-09 20:16:59");
INSERT INTO tools_equip VALUES("8","Dental Probe","","2023-12-09 20:16:59");
INSERT INTO tools_equip VALUES("9","Root Elevator","","2023-12-09 20:16:59");
INSERT INTO tools_equip VALUES("10","Extraction Forcep","","2023-12-09 20:16:59");
INSERT INTO tools_equip VALUES("11","Dent Air High Speed Air Turbine Hand Piece","","2023-12-09 20:16:59");



CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_type` varchar(100) NOT NULL,
  `service` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO transaction VALUES("1","Walk-in","Request for medicine");
INSERT INTO transaction VALUES("2","Request for Medicine","");
INSERT INTO transaction VALUES("3","Emergency","");
INSERT INTO transaction VALUES("4","Appointment","Checkup");
INSERT INTO transaction VALUES("5","Request for Medical Certificate","");
INSERT INTO transaction VALUES("6","Request for Medical Clearance","");
INSERT INTO transaction VALUES("7","Walk-in","Request for medical supply");
INSERT INTO transaction VALUES("8","Consultation","Medical");
INSERT INTO transaction VALUES("9","Consultation","Dental");
INSERT INTO transaction VALUES("10","Consultation","General");
INSERT INTO transaction VALUES("11","Appointment","Tooth Extraction");
INSERT INTO transaction VALUES("12","Appointment","Tooth Restoration");
INSERT INTO transaction VALUES("13","Walk-in","Checkup");
INSERT INTO transaction VALUES("14","Appointment","Periodontal Treatment");
INSERT INTO transaction VALUES("15","Appointment","Oral Prophylaxis");
INSERT INTO transaction VALUES("16","Request for medical supply","");
INSERT INTO transaction VALUES("17","Checkup","Freshmen");
INSERT INTO transaction VALUES("18","Checkup","Athlete/Varsity");
INSERT INTO transaction VALUES("19","Checkup","ROTC");
INSERT INTO transaction VALUES("20","Checkup","OJT/SIT/WAP");
INSERT INTO transaction VALUES("21","Checkup","Medical Certification");
INSERT INTO transaction VALUES("22","Checkup","Others: BP/Ht/RBS/Wt Monitoring");



CREATE TABLE `transaction_request` (
  `transid` int(11) NOT NULL AUTO_INCREMENT,
  `patient` varchar(45) NOT NULL,
  `request_type` int(11) NOT NULL,
  `medid` varchar(45) DEFAULT NULL,
  `supid` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `purpose` text NOT NULL,
  `date_pickup` date NOT NULL,
  `time_pickup` time NOT NULL,
  `datetime` datetime NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`transid`),
  KEY `rtype` (`request_type`),
  CONSTRAINT `rtype` FOREIGN KEY (`request_type`) REFERENCES `request_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO transaction_request VALUES("1","B2021-0542","1","2","0","0","","2024-02-14","22:36:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("2","B2021-0542","1","1","0","0","","2024-02-14","22:54:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("3","B2021-0542","1","6","0","0","","2024-02-14","22:55:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("4","B2021-0542","1","6","0","0","","2024-02-14","22:55:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("5","B2021-0542","1","18","0","0","","2024-02-14","22:56:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("6","B2021-0542","1","","0","0","","2024-02-14","22:56:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("7","B2021-0542","1","","0","0","","2024-02-14","22:57:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("8","B2021-0542","1","1","0","1","wews","2024-02-14","23:00:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("9","B2021-0542","1","1","0","2","wews","2024-02-14","23:01:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("10","B2021-0542","1","2","0","2","nag na-nana na yung sugat","2024-02-14","23:01:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("11","B2021-0542","2","","1","1","nag na-nana na yung sugat","2024-02-15","23:03:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("12","B2021-0542","1","1","","1","wews","2024-02-14","23:10:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("13","B2021-0542","1","2","","1","wews","2024-02-14","23:10:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("14","B2021-0542","1","1","","1","wews","2024-02-14","23:14:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("15","B2021-0542","2","","1","1","nag na-nana na yung sugat","2024-02-14","23:16:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("16","B2021-0542","1","1","","2","wews","2024-02-22","00:05:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("17","B2021-0542","2","","19","5","nag na-nana na yung sugat","2024-02-15","00:07:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("18","B2021-0569","1","19","","4","HAHA","2024-02-23","16:44:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("19","B2021-0542","1","1","","1","mamamatay na","2024-02-22","16:49:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("20","B2021-0542","1","5","","1","mamamatay na","2024-02-22","16:49:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("21","B2021-0542","1","2","","1","mamamatay na","2024-02-22","16:49:00","0000-00-00 00:00:00","Pending");
INSERT INTO transaction_request VALUES("22","B2021-0542","1","9","","1","mamamatay na","2024-02-22","16:49:00","0000-00-00 00:00:00","Pending");



CREATE TABLE `unit_measure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `unit_measure` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO unit_measure VALUES("1","medicine","mg/tab");
INSERT INTO unit_measure VALUES("2","medicine","mg/cap");
INSERT INTO unit_measure VALUES("3","medicine","mg/loz");
INSERT INTO unit_measure VALUES("4","medicine","mg/capge");
INSERT INTO unit_measure VALUES("5","medicine","ml");
INSERT INTO unit_measure VALUES("6","medicine","ml/bot");
INSERT INTO unit_measure VALUES("7","medicine","L");
INSERT INTO unit_measure VALUES("8","medicine","mg");
INSERT INTO unit_measure VALUES("9","medicine","g");
INSERT INTO unit_measure VALUES("10","medicine","kg");
INSERT INTO unit_measure VALUES("11","medicine","ampule");
INSERT INTO unit_measure VALUES("12","medicine","tube");
INSERT INTO unit_measure VALUES("13","medicine","bottle");
INSERT INTO unit_measure VALUES("14","medicine","can");
INSERT INTO unit_measure VALUES("15","set","s/pack");
INSERT INTO unit_measure VALUES("16","set","mL/bot");
INSERT INTO unit_measure VALUES("17","set","tube");
INSERT INTO unit_measure VALUES("18","set","pack");
INSERT INTO unit_measure VALUES("19","set","bottle");
INSERT INTO unit_measure VALUES("20","set","pc");
INSERT INTO unit_measure VALUES("21","set","pcs");
INSERT INTO unit_measure VALUES("22","set","box");
INSERT INTO unit_measure VALUES("23","set","strip");
INSERT INTO unit_measure VALUES("24","set","strips");
INSERT INTO unit_measure VALUES("25","set","can");
INSERT INTO unit_measure VALUES("26","set","inch");
INSERT INTO unit_measure VALUES("27","set","cm");
INSERT INTO unit_measure VALUES("28","set","m");
INSERT INTO unit_measure VALUES("29","set","pair");
INSERT INTO unit_measure VALUES("30","set","gallon");
INSERT INTO unit_measure VALUES("31","medicine","mcg/tab");
INSERT INTO unit_measure VALUES("32","medicine","cap");
INSERT INTO unit_measure VALUES("33","set","strips/box");
INSERT INTO unit_measure VALUES("34","set","ml/can");
INSERT INTO unit_measure VALUES("35","set","roll/box");
INSERT INTO unit_measure VALUES("36","set","g/tube");
INSERT INTO unit_measure VALUES("37","set","mg/tube");



CREATE TABLE `user_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`id`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO user_status VALUES("1","ACTIVE");
INSERT INTO user_status VALUES("2","INACTIVE");
INSERT INTO user_status VALUES("3","PENDING");
INSERT INTO user_status VALUES("4","ALUMNUS");
INSERT INTO user_status VALUES("5","LOCKED");



CREATE TABLE `yearlevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(45) DEFAULT NULL,
  `yearlevel` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO yearlevel VALUES("1","","ALL");
INSERT INTO yearlevel VALUES("2","ELEMENTARY","1");
INSERT INTO yearlevel VALUES("3","ELEMENTARY","2");
INSERT INTO yearlevel VALUES("4","ELEMENTARY","3");
INSERT INTO yearlevel VALUES("5","ELEMENTARY","4");
INSERT INTO yearlevel VALUES("6","ELEMENTARY","5");
INSERT INTO yearlevel VALUES("7","ELEMENTARY","6");
INSERT INTO yearlevel VALUES("8","JHS","7");
INSERT INTO yearlevel VALUES("9","JHS","8");
INSERT INTO yearlevel VALUES("10","JHS","9");
INSERT INTO yearlevel VALUES("11","JHS","10");
INSERT INTO yearlevel VALUES("12","SHS","11");
INSERT INTO yearlevel VALUES("13","SHS","12");
INSERT INTO yearlevel VALUES("14","COLLEGE","Graduate School");
INSERT INTO yearlevel VALUES("18","COLLEGE","4");
INSERT INTO yearlevel VALUES("19","COLLEGE","1");
INSERT INTO yearlevel VALUES("20","COLLEGE","2");
INSERT INTO yearlevel VALUES("21","COLLEGE","3");

