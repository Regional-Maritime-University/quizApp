-- -----------------------------------------------------
-- Schema rmu_student_mgt_db
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `rmu_student_mgt_db`;
CREATE SCHEMA `rmu_student_mgt_db` DEFAULT CHARACTER SET utf8 ;
USE `rmu_student_mgt_db` ;

-- -----------------------------------------------------
-- Table `academic_year`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `academic_year`;
CREATE TABLE IF NOT EXISTS `academic_year` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `active` TINYINT(1) DEFAULT 1,
  `start_month` VARCHAR(5) NOT NULL, 
  `end_month` VARCHAR(5) NOT NULL,
  `start_year` YEAR NOT NULL, 
  `end_year` YEAR NOT NULL,
  `archived` TINYINT(1) DEFAULT 0,
  `name` VARCHAR(15) GENERATED ALWAYS AS (CONCAT(`start_year`, '-', `end_year`)) VIRTUAL,
  PRIMARY KEY (`id`)
);
CREATE INDEX academic_year_active_idx1 ON `academic_year` (`active`);
CREATE INDEX academic_year_start_month_idx1 ON `academic_year` (`start_month`);
CREATE INDEX academic_year_end_month_idx1 ON `academic_year` (`end_month`);
CREATE INDEX academic_year_start_year_idx1 ON `academic_year` (`start_year`);
CREATE INDEX academic_year_end_year_idx1 ON `academic_year` (`end_year`);
CREATE INDEX academic_year_archived_idx1 ON `academic_year` (`archived`);
CREATE INDEX academic_year_name_idx1 ON `academic_year` (`name`);
INSERT INTO `academic_year` (`start_month`, `start_year`, `end_month`, `end_year`) 
VALUES ('Sep', '2023', 'Jun', '2024');

-- -----------------------------------------------------
-- Table `semester`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `semester`;
CREATE TABLE IF NOT EXISTS `semester` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `active` TINYINT(1) DEFAULT 1,
  `name` VARCHAR(20) NOT NULL,
  `course_registration_opened` TINYINT(1) DEFAULT 0,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_academic_year` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_semester_academic_year1` FOREIGN KEY (`fk_academic_year`) REFERENCES `academic_year` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX semester_active_idx1 ON `semester` (`active`);
CREATE INDEX semester_name_idx1 ON `semester` (`name`);
CREATE INDEX semester_course_registration_opened_idx1 ON `semester` (`course_registration_opened`);
CREATE INDEX semester_archived_idx1 ON `semester` (`archived`);
INSERT INTO `semester` (`name`, `course_registration_opened`, `fk_academic_year`) VALUES ('SEMESTER 1', 1, 1);

-- -----------------------------------------------------
-- Table `department`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL UNIQUE,
  `archived` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`id`)
);
CREATE INDEX department_name_idx1 ON `department` (`name`);
CREATE INDEX department_archived_idx1 ON `department` (`archived`);

-- -----------------------------------------------------
-- Table `program`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `program`;
CREATE TABLE IF NOT EXISTS `program` (
  `code` VARCHAR(10) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `category` VARCHAR(100) NOT NULL,
  `index_code` VARCHAR(5) NOT NULL,
  `faculty` varchar(255) DEFAULT NULL,
  `duration` INT DEFAULT 0,
  `dur_format` VARCHAR(25) DEFAULT 'YEAR',
  `num_of_semesters` INT NOT NULL,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_department` INT NULL,
  PRIMARY KEY (`code`),
  CONSTRAINT `fk_program_department1` FOREIGN KEY (`fk_department`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
ALTER TABLE `program` ADD COLUMN `faculty` varchar(255) DEFAULT NULL AFTER `index_code`;
CREATE INDEX program_name_idx1 ON `program` (`name`);
CREATE INDEX program_category_idx1 ON `program` (`category`); 
CREATE INDEX program_index_code_idx1 ON `program` (`index_code`); 
CREATE INDEX program_faculty_idx1 ON `program` (`faculty`); 
CREATE INDEX program_duration_idx1 ON `program` (`duration`); 
CREATE INDEX program_dur_format_idx1 ON `program` (`dur_format`);
CREATE INDEX program_num_of_semesters_idx1 ON `program` (`num_of_semesters`);
CREATE INDEX program_archived_idx1 ON `program` (`archived`);

--
-- Dumping data for table `programs`
--

INSERT INTO `program` (`code`, `index_code`, `name`, `fk_department`, `category`, `duration`, `dur_format`, `num_of_semesters`) VALUES
('BNS', 'BNS', 'B.Sc. NAUTICAL SCIENCE', 3, 'DEGREE', 4, 'year', 8),
('BME', 'BME', 'B.Sc. MARINE ENGINEERING', 2, 'DEGREE', 4, 'year', 8),
('BMT', 'BMT', 'B.Sc. MECHANICAL ENGINEERING', 2, 'DEGREE', 4, 'year', 8),
('BCE', 'BCE', 'B.Sc. COMPUTER ENGINEERING', 1, 'DEGREE', 4, 'year', 8),
('BCS', 'BCS', 'B.Sc. COMPUTER SCIENCE', 1, 'DEGREE', 4, 'year', 8),
('BEE', 'BEE', 'B.Sc. ELECTRICAL/ELECTRONIC ENGINEERING', 4, 'DEGREE', 4, 'year', 8),
('BAC', 'BAC', 'B.Sc. ACCOUNTING', 5, 'DEGREE', 4, 'year', 8),
('BIT', 'BIT', 'B.Sc. INFORMATION TECHNOLOGY', 1, 'DEGREE', 4, 'year', 8),
('BPS', 'BPS', 'B.Sc. PORT AND SHIPPING ADMINISTRATION', 5, 'DEGREE', 4, 'year', 8),
('BLG', 'BLG', 'B.Sc. LOGISTICS MANAGEMENT', 5, 'DEGREE', 4, 'year', 8),
('BTA', 'BTA', 'Diploma IN BANKING TECHNOLOGY AND ACCOUNTING', 5, 'DIPLOMA', 2, 'year', 4),
('AIT', 'AIT', 'Diploma IN ACCOUNTING WITH INFORMATION TECHNOLOGY', 5, 'DIPLOMA', 2, 'year', 4),
('DIT', 'DIT', 'Diploma IN INFORMATION TECHNOLOGY', 1, 'DIPLOMA', 2, 'year', 4),
('MEM', 'MEM', 'MARINE ENGINE MECHANICS', 2, 'SHORT', 6, 'month', 0),
('CDA', 'CDA', 'CILT, DILT AND ADILT', 5, 'SHORT', 6, 'month', 0),
('BPO', 'BPO', 'B.Sc. PROCUREMENT AND OPERATIONS MANAGEMENT', 5, 'DEGREE', 4, 'year', 8),
('DNS', 'DNS', 'Diploma IN NAUTICAL SCIENCE', 3, 'DIPLOMA', 2, 'year', 4),
('DME', 'DME', 'Diploma IN MARINE ENGINEERING', 2, 'DIPLOMA', 2, 'year', 4),
('DEE', 'DEE', 'Diploma ELECTRICAL/ELECTRONIC ENGINNERING', 4, 'DIPLOMA', 2, 'year', 4),
('BNA', 'BNA', 'B.Sc. NAVAL ARCHITECTURE, SMALL CRAFT AND OCEAN ENGINEERING', 3, 'DEGREE', 4, 'year', 8),
('DPS', 'DPS', 'Diploma IN PORTS AND SHIPPING MANAGEMENT', 5, 'DIPLOMA', 2, 'year', 4);

-- -----------------------------------------------------
-- Table `course`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `code` VARCHAR(10) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `credit_hours` INT DEFAULT 0,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_department` INT NULL,
  PRIMARY KEY (`code`),
  CONSTRAINT `fk_course_department1` FOREIGN KEY (`fk_department`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX course_name_idx1 ON `course` (`name`);
CREATE INDEX course_credit_hours_idx1 ON `course` (`credit_hours`);
CREATE INDEX course_archived_idx1 ON `course` (`archived`);

-- -----------------------------------------------------
-- Table `room`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `room`;
CREATE TABLE IF NOT EXISTS `room` (
  `number` VARCHAR(10) NOT NULL,
  `capacity`INT NOT NULL,
  `location` VARCHAR(255),
  `archived` TINYINT(1) DEFAULT 0,
  `fk_department` INT NULL,
  PRIMARY KEY (`number`),
  CONSTRAINT `fk_room_department1` FOREIGN KEY (`fk_department`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX room_code_idx1 ON `room` (`capacity`);
CREATE INDEX room_name_idx1 ON `room` (`location`);
CREATE INDEX room_archived_idx1 ON `room` (`archived`);

-- -----------------------------------------------------
-- Table `class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `code` VARCHAR(10) NOT NULL,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_program` VARCHAR(10) NULL,
  PRIMARY KEY (`code`),
  CONSTRAINT `fk_class_program1`FOREIGN KEY (`fk_program`) REFERENCES `program` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX class_archived_idx1 ON `class` (`archived`);

-- -----------------------------------------------------
-- Table `student`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `index_number` VARCHAR(10) NOT NULL,
  `app_number` VARCHAR(10) NOT NULL UNIQUE,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `phone_number` VARCHAR(15) NOT NULL,
  `prefix` VARCHAR(10),
  `first_name` VARCHAR(255) NOT NULL,
  `middle_name` VARCHAR(255),
  `last_name` VARCHAR(255) NOT NULL,
  `suffix` VARCHAR(10),
  `gender` VARCHAR(1) DEFAULT 'F',
  `dob` DATE NOT NULL,
  `nationality` VARCHAR(25) NOT NULL,
  `photo` VARCHAR(255),
  `marital_status` VARCHAR(25),
  `disability` VARCHAR(25),
  `date_admitted` DATE NOT NULL,
  `term_admitted` VARCHAR(15) NOT NULL,
  `stream_admitted` VARCHAR(15) NOT NULL,
  `academic_year_admitted` VARCHAR(15) NOT NULL,
  `program` VARCHAR(255) NOT NULL,
  `department` VARCHAR(255) NOT NULL,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_department` INT NULL,
  `fk_class` VARCHAR(10) NULL,
  PRIMARY KEY (`index_number`),
  CONSTRAINT `fk_student_department1` FOREIGN KEY (`fk_department`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_class1` FOREIGN KEY (`fk_class`) REFERENCES `class` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX `student_phone_number_idx1` ON `student` (`phone_number`);
CREATE INDEX `student_first_name_idx1` ON `student` (`first_name`);
CREATE INDEX `student_last_name_idx1` ON `student` (`last_name`);
CREATE INDEX `student_gender_idx1` ON `student` (`gender`);
CREATE INDEX `student_dob_idx1` ON `student` (`dob`);
CREATE INDEX `student_nationality_idx1` ON `student` (`nationality`);
CREATE INDEX `student_marital_status_idx1` ON `student` (`marital_status`);
CREATE INDEX `student_disability_idx1` ON `student` (`disability`);
CREATE INDEX `student_date_admitted_idx1` ON `student` (`date_admitted`);
CREATE INDEX `student_term_admitted_idx1` ON `student` (`term_admitted`);
CREATE INDEX `student_stream_admitted_idx1` ON `student` (`stream_admitted`);
CREATE INDEX `student_academic_year_admitted_idx1` ON `student` (`academic_year_admitted`);
CREATE INDEX `student_program_idx1` ON `student` (`program`);
CREATE INDEX `student_department_idx1` ON `student` (`department`);
CREATE INDEX `student_archived_idx1` ON `student` (`archived`);

-- -----------------------------------------------------
-- Table `section`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `section`;
CREATE TABLE IF NOT EXISTS `section` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_course` VARCHAR(10) NULL,
  `fk_class` VARCHAR(10) NULL,
  `fk_semester` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_section_course1` FOREIGN KEY (`fk_course`) REFERENCES `course` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_section_class1` FOREIGN KEY (`fk_class`) REFERENCES `class` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_section_semester1` FOREIGN KEY (`fk_semester`) REFERENCES `semester` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX section_archived_idx1 ON `section` (`archived`);

-- -----------------------------------------------------
-- Table `schedule`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `day_of_week` VARCHAR(10) NOT NULL,
  `course_crdt_hrs` INT DEFAULT 0,
  `start_time` TIME NOT NULL,
  `minutes` INT DEFAULT 50,
  `end_time` TIME GENERATED ALWAYS AS (`start_time` + (`course_crdt_hrs` * `minutes`)),
  `archived` TINYINT(1) DEFAULT 0,
  `fk_course` VARCHAR(10) NULL,
  `fk_room` VARCHAR(10) NULL,
  `fk_semester` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_schedule_course1` FOREIGN KEY (`fk_course`) REFERENCES `course` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_schedule_room1` FOREIGN KEY (`fk_room`) REFERENCES `room` (`number`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_schedule_semester1` FOREIGN KEY (`fk_semester`) REFERENCES `semester` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX schedule_day_of_week_idx1 ON `schedule` (`day_of_week`);
CREATE INDEX schedule_course_crdt_hrs_idx1 ON `schedule` (`course_crdt_hrs`);
CREATE INDEX schedule_start_time_idx1 ON `schedule` (`start_time`);
CREATE INDEX schedule_minutes_idx1 ON `schedule` (`minutes`);
CREATE INDEX schedule_end_time_idx1 ON `schedule` (`end_time`);
CREATE INDEX schedule_archived_idx1 ON `schedule` (`archived`);

-- -----------------------------------------------------
-- Table `course_registration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `course_registration`;
CREATE TABLE IF NOT EXISTS `course_registration` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_course` VARCHAR(10) NULL,
  `fk_student` VARCHAR(10) NULL,
  `fk_semester` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_course_registration_course1` FOREIGN KEY (`fk_course`) REFERENCES `course` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_registration_student1` FOREIGN KEY (`fk_student`) REFERENCES `student` (`index_number`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_course_registration_semester1` FOREIGN KEY (`fk_semester`) REFERENCES `semester` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX course_registration_archived_idx1 ON `course_registration` (`archived`);

-- -----------------------------------------------------
-- Table `staff`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `number` VARCHAR(10) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(255) NOT NULL,
  `middle_name` VARCHAR(255),
  `last_name` VARCHAR(255) NOT NULL,
  `prefix` VARCHAR(10),
  `gender` VARCHAR(1) DEFAULT 'F',
  `role` VARCHAR(15) NOT NULL,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_department` INT NULL,
  PRIMARY KEY (`number`),
  CONSTRAINT `fk_staff_department1` FOREIGN KEY (`fk_department`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX staff_email_idx1 ON `staff` (`email`);
CREATE INDEX staff_first_name_idx1 ON `staff` (`first_name`);
CREATE INDEX staff_last_name_idx1 ON `staff` (`last_name`);
CREATE INDEX staff_gender_idx1 ON `staff` (`gender`);
CREATE INDEX staff_role_idx1 ON `staff` (`role`);
CREATE INDEX staff_archived_idx1 ON `staff` (`archived`);

-- -----------------------------------------------------
-- Table `lecture`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lecture`;
CREATE TABLE IF NOT EXISTS `lecture` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_staff` VARCHAR(20) NULL,
  `fk_section` INT NULL,
  `fk_semester` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_lecture_staff1` FOREIGN KEY (`fk_staff`) REFERENCES `staff` (`number`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lecture_section1` FOREIGN KEY (`fk_section`) REFERENCES `section` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `lecture_semester1` FOREIGN KEY (`fk_semester`) REFERENCES `semester` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX lecture_archived_idx1 ON `lecture` (`archived`);

-- -----------------------------------------------------
-- Table `quizz`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizz`;
CREATE TABLE IF NOT EXISTS `quizz` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `total_mark` DECIMAL(4,1) NOT NULL,
  `pass_mark` DECIMAL(4,1) NOT NULL,
  `start_date` DATETIME NOT NULL,
  `start_time` DATETIME NOT NULL,
  `duration` INT NOT NULL,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_course` VARCHAR(10) NULL,
  `fk_staff` VARCHAR(10) NULL,
  `fk_semester` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_quizz_course1` FOREIGN KEY (`fk_course`) REFERENCES `course` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_quizz_staff1` FOREIGN KEY (`fk_staff`) REFERENCES `staff` (`number`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_quizz_semester1` FOREIGN KEY (`fk_semester`) REFERENCES `semester` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX quizz_title_idx1 ON `quizz` (`title`);
CREATE INDEX quizz_total_mark_idx1 ON `quizz` (`total_mark`);
CREATE INDEX quizz_pass_mark_idx1 ON `quizz` (`pass_mark`);
CREATE INDEX quizz_start_date_idx1 ON `quizz` (`start_date`);
CREATE INDEX quizz_start_time_idx1 ON `quizz` (`start_time`);
CREATE INDEX quizz_duration_idx1 ON `quizz` (`duration`);
CREATE INDEX quizz_archived_idx1 ON `quizz` (`archived`);

-- -----------------------------------------------------
-- Table `question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(25) NOT NULL,
  `question` LONGTEXT NOT NULL,
  `marks` INT NOT NULL,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_course` VARCHAR(10) NULL,
  `fk_staff` VARCHAR(10) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_question_course1` FOREIGN KEY (`fk_course`) REFERENCES `course` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_staff1` FOREIGN KEY (`fk_staff`) REFERENCES `staff` (`number`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX question_type_idx1 ON `question` (`type`);
CREATE INDEX question_question_idx1 ON `question` (`question`);
CREATE INDEX question_marks_idx1 ON `question` (`marks`);
CREATE INDEX question_archived_idx1 ON `question` (`archived`);

-- -----------------------------------------------------
-- Table `answer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `answer`;
CREATE TABLE IF NOT EXISTS `answer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `option` TEXT(500) NOT NULL,
  `right_answer` VARCHAR(255) NULL,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_question` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_answer_question1` FOREIGN KEY (`fk_question`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX answer_option_idx1 ON `answer` (`option`);
CREATE INDEX answer_right_answer_idx1 ON `answer` (`right_answer`);
CREATE INDEX answer_archived_idx1 ON `answer` (`archived`);

-- -----------------------------------------------------
-- Table `quizz_question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizz_question`;
CREATE TABLE IF NOT EXISTS `quizz_question` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_quizz` INT NULL,
  `fk_question` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_quizz_question_quizz1` FOREIGN KEY (`fk_quizz`) REFERENCES `quizz` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_quizz_question_question1` FOREIGN KEY (`fk_question`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX quizz_question_archived_idx1 ON `quizz_question` (`archived`);

-- -----------------------------------------------------
-- Table `student_quizz_response`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `student_quizz_response`;
CREATE TABLE IF NOT EXISTS `student_quizz_response` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_quizz` INT NULL,
  `fk_question` INT NULL,
  `fk_answer` INT NULL,
  `fk_student` VARCHAR(10) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_student_quizz_response_quizz1` FOREIGN KEY (`fk_quizz`) REFERENCES `quizz` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_quizz_response_question1` FOREIGN KEY (`fk_question`) REFERENCES `question` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_quizz_response_answer1` FOREIGN KEY (`fk_answer`) REFERENCES `answer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_quizz_response_student1` FOREIGN KEY (`fk_student`) REFERENCES `student` (`index_number`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX student_quizz_response_archived_idx1 ON `student_quizz_response` (`archived`);

-- -----------------------------------------------------
-- Table `student_quizz_stat`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `student_quizz_stat`;
CREATE TABLE IF NOT EXISTS `student_quizz_stat` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `total_mark` DECIMAL(4,1) NOT NULL,
  `pass_mark` DECIMAL(4,1) NOT NULL,
  `score_obtained` DECIMAL(4,1) NOT NULL,
  `score_percent` DECIMAL(4,1) GENERATED ALWAYS AS ((`score_obtained` / `total_mark`) * 100) VIRTUAL,
  `grade` VARCHAR(2)  GENERATED ALWAYS AS (
    CASE
      WHEN `score_percent` >= 80 THEN 'A+'
      WHEN `score_percent` >= 76 THEN 'A-'
      WHEN `score_percent` >= 70 THEN 'B+'
      WHEN `score_percent` >= 66 THEN 'B'
      WHEN `score_percent` >= 60 THEN 'C'
      WHEN `score_percent` >= 50 THEN 'D'
      WHEN `score_percent` >= 46 THEN 'E'
      WHEN `score_percent` <= 45 THEN 'F'
    END
  ) VIRTUAL,
  `passed` TINYINT(1) GENERATED ALWAYS AS (
    CASE
      WHEN `score_obtained` >= `pass_mark` THEN 1
      WHEN `score_obtained` < `pass_mark` THEN 0
    END
  ) VIRTUAL,
  `archived` TINYINT(1) DEFAULT 0,
  `fk_quizz` INT NULL,
  `fk_student` VARCHAR(10) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_student_quizz_stat_quizz1` FOREIGN KEY (`fk_quizz`) REFERENCES `quizz` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_quizz_stat_student1` FOREIGN KEY (`fk_student`) REFERENCES `student` (`index_number`) ON DELETE NO ACTION ON UPDATE NO ACTION
);
CREATE INDEX student_quizz_stat_archived_idx1 ON `student_quizz_stat` (`score_percent`);
CREATE INDEX student_quizz_stat_archived_idx1 ON `student_quizz_stat` (`grade`);
CREATE INDEX student_quizz_stat_archived_idx1 ON `student_quizz_stat` (`passed`);
CREATE INDEX student_quizz_stat_archived_idx1 ON `student_quizz_stat` (`archived`);