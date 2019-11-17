DROP DATABASE IF EXISTS mathlander;
CREATE DATABASE IF NOT EXISTS mathlander;

USE mathlander;

CREATE TABLE tbl_account_type (
  acctype_id   int(10) NOT NULL AUTO_INCREMENT, 
  acctype_name varchar(10) NOT NULL UNIQUE, 
  PRIMARY KEY (acctype_id));
CREATE TABLE tbl_account (
  acc_id        int(10) NOT NULL AUTO_INCREMENT, 
  acc_username  varchar(20) NOT NULL UNIQUE, 
  acc_pass      varchar(20) NOT NULL, 
  acc_type_id   int(10) NOT NULL, 
  acc_firstname varchar(40) NOT NULL, 
  acc_lastname  varchar(40) NOT NULL, 
  acc_email     varchar(50) NOT NULL, 
  acc_dob       date NOT NULL, 
  acc_gender    varchar(1) NOT NULL,
  acc_school    varchar(50) NOT NULL, 
  acc_country   varchar(40) NOT NULL,
  acc_timestamp timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (acc_id));
CREATE TABLE tbl_comp_question (
  comp_ques_id    int(10) NOT NULL AUTO_INCREMENT, 
  comp_ques_txt   varchar(50) NOT NULL UNIQUE, 
  comp_ques_opt1  varchar(20) NOT NULL, 
  comp_ques_opt2  varchar(20) NOT NULL, 
  comp_ques_opt3  varchar(20) NOT NULL, 
  comp_ques_answr varchar(20) NOT NULL, 
  PRIMARY KEY (comp_ques_id));
CREATE TABLE tbl_comp_subscription (
  acc_id         int(10) NOT NULL, 
  comp_ques_id   int(10) NOT NULL, 
  comp_ques_opt  varchar(20) NOT NULL, 
  comp_email     varchar(50) NOT NULL, 
  comp_classroom varchar(20) NOT NULL, 
  comp_school    varchar(50) NOT NULL, 
  comp_school_ph varchar(25) NOT NULL,
  comp_entered   timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (acc_id));
CREATE TABLE tbl_group (
  grp_id       int(10) NOT NULL AUTO_INCREMENT, 
  grp_name     varchar(30) NOT NULL UNIQUE, 
  acc_id_owner int(10) NOT NULL, 
  PRIMARY KEY (grp_id));
CREATE TABLE tbl_group_member (
  grp_id int(10) NOT NULL, 
  acc_id int(10) NOT NULL, 
  PRIMARY KEY (grp_id, acc_id));
CREATE TABLE tbl_account_nav_history (
  acc_nav_id        int(10) NOT NULL AUTO_INCREMENT,
  acc_id            int(10) NOT NULL, 
  view_id           int(10) NOT NULL, 
  nav_info          varchar(100),
  acc_nav_timestamp timestamp DEFAULT CURRENT_TIMESTAMP, 
  PRIMARY KEY (acc_nav_id));
CREATE TABLE tbl_account_message (
  acc_msg_id        int(10) NOT NULL AUTO_INCREMENT, 
  acc_id_to         int(10) NOT NULL, 
  acc_id_from       int(10) NOT NULL, 
  acc_msg_txt       varchar(255) NOT NULL, 
  acc_msg_timestamp timestamp DEFAULT CURRENT_TIMESTAMP, 
  PRIMARY KEY (acc_msg_id));
CREATE TABLE tbl_account_trainer_score (
  trainer_session_id int(10) NOT NULL AUTO_INCREMENT, 
  acc_id             int(10) NOT NULL, 
  trainer_timestamp  timestamp DEFAULT CURRENT_TIMESTAMP, 
  trainer_score      int(10) NOT NULL, 
  trainer_timeouts   int(10) NOT NULL, 
  trainer_mins       int(10) NOT NULL, 
  trainer_secs       int(10) NOT NULL, 
  PRIMARY KEY (trainer_session_id));
CREATE TABLE tbl_account_quiz_record (
  acc_quiz_id       int(10) NOT NULL AUTO_INCREMENT,
  quiz_id           int(10) NOT NULL, 
  acc_quiz_equation varchar(20) NOT NULL, 
  acc_quiz_answer   varchar(20) NOT NULL, 
  acc_quiz_equals   varchar(20) NOT NULL, 
  PRIMARY KEY (acc_quiz_id));
CREATE TABLE tbl_group_add_request (
  grp_id            int(10) NOT NULL, 
  acc_id            int(10) NOT NULL, 
  grp_add_timestamp timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (grp_id, acc_id));
CREATE TABLE tbl_group_message (
  grp_msg_id        int(10) NOT NULL AUTO_INCREMENT, 
  grp_id            int(10) NOT NULL, 
  grp_msg_txt       varchar(255) NOT NULL, 
  grp_msg_timestamp timestamp DEFAULT CURRENT_TIMESTAMP, 
  PRIMARY KEY (grp_msg_id));
CREATE TABLE tbl_quiz_session (
  quiz_id        int(10) NOT NULL AUTO_INCREMENT,
  acc_id         int(10) NOT NULL,
  quiz_timestamp timestamp DEFAULT CURRENT_TIMESTAMP, 
  PRIMARY KEY (quiz_id));
CREATE TABLE tbl_view (
  view_id          int(10) NOT NULL AUTO_INCREMENT, 
  view_name        varchar(30) NOT NULL, 
  view_title       varchar(50) NOT NULL, 
  view_description varchar(255) NOT NULL, 
  PRIMARY KEY (view_id));
CREATE TABLE tbl_comment (
  comment_id        int(10) NOT NULL AUTO_INCREMENT, 
  comment_section   varchar(20) NOT NULL,
  comment_from      int(10) NOT NULL, 
  comment_txt       varchar(255) NOT NULL, 
  comment_timestamp timestamp DEFAULT CURRENT_TIMESTAMP, 
  PRIMARY KEY (comment_id));

ALTER TABLE tbl_group ADD INDEX FKtbl_group_acc (acc_id_owner), ADD CONSTRAINT FKtbl_group_account FOREIGN KEY (acc_id_owner) REFERENCES tbl_account (acc_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_group_member ADD INDEX FKtbl_group_member_acc (acc_id), ADD CONSTRAINT FKtbl_group_member_acc FOREIGN KEY (acc_id) REFERENCES tbl_account (acc_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_group_add_request ADD INDEX FKtbl_group_add_acc (acc_id), ADD CONSTRAINT FKtbl_group_add_acc FOREIGN KEY (acc_id) REFERENCES tbl_account (acc_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_comp_subscription ADD INDEX FKtbl_comp_sub_acc (acc_id), ADD CONSTRAINT FKtbl_comp_sub_acc FOREIGN KEY (acc_id) REFERENCES tbl_account (acc_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_account ADD INDEX FKtbl_account_type (acc_type_id), ADD CONSTRAINT FKtbl_account_type FOREIGN KEY (acc_type_id) REFERENCES tbl_account_type (acctype_id) ON UPDATE Cascade;
ALTER TABLE tbl_group_message ADD INDEX FKtbl_group_msg_grp (grp_id), ADD CONSTRAINT FKtbl_group_msg_grp FOREIGN KEY (grp_id) REFERENCES tbl_group (grp_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_group_member ADD INDEX FKtbl_group_member_grp (grp_id), ADD CONSTRAINT FKtbl_group_member_grp FOREIGN KEY (grp_id) REFERENCES tbl_group (grp_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_group_add_request ADD INDEX FKtbl_group_add_grp (grp_id), ADD CONSTRAINT FKtbl_group_add_grp FOREIGN KEY (grp_id) REFERENCES tbl_group (grp_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_comp_subscription ADD INDEX FKtbl_comp_sub_ques (comp_ques_id), ADD CONSTRAINT FKtbl_comp_sub_ques FOREIGN KEY (comp_ques_id) REFERENCES tbl_comp_question (comp_ques_id) ON UPDATE Cascade;
ALTER TABLE tbl_account_quiz_record ADD INDEX FKtbl_account_quiz_id (quiz_id), ADD CONSTRAINT FKtbl_account_quiz_id FOREIGN KEY (quiz_id) REFERENCES tbl_quiz_session (quiz_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_quiz_session ADD INDEX FKtbl_quiz_sess_acc (acc_id), ADD CONSTRAINT FKtbl_quiz_sess_acc FOREIGN KEY (acc_id) REFERENCES tbl_account (acc_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_account_trainer_score ADD INDEX FKtbl_acc_trainer_acc (acc_id), ADD CONSTRAINT FKtbl_acc_trainer_acc FOREIGN KEY (acc_id) REFERENCES tbl_account (acc_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_account_message ADD INDEX FKtbl_account_msg_to (acc_id_to), ADD CONSTRAINT FKtbl_account_msg_to FOREIGN KEY (acc_id_to) REFERENCES tbl_account (acc_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_account_message ADD INDEX FKtbl_account_msg_from (acc_id_from), ADD CONSTRAINT FKtbl_account_msg_from FOREIGN KEY (acc_id_from) REFERENCES tbl_account (acc_id) ON UPDATE Cascade;
ALTER TABLE tbl_account_nav_history ADD INDEX FKtbl_account_nav_acc (acc_id), ADD CONSTRAINT FKtbl_account_nav_acc FOREIGN KEY (acc_id) REFERENCES tbl_account (acc_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_account_nav_history ADD INDEX FKtbl_account_nav_view (view_id), ADD CONSTRAINT FKtbl_account_nav_view FOREIGN KEY (view_id) REFERENCES tbl_view (view_id) ON UPDATE Cascade ON DELETE Cascade;
ALTER TABLE tbl_comment ADD INDEX FKtbl_comment (comment_from), ADD CONSTRAINT FKtbl_comment FOREIGN KEY (comment_from) REFERENCES tbl_account (acc_id) ON UPDATE Cascade ON DELETE Cascade;

#Inset Account Types
INSERT INTO tbl_account_type (acctype_name) VALUES ("Learner"),("Educator");

#Insert Test Accounts
INSERT INTO tbl_account (
	acc_username,
    acc_pass,
    acc_type_id,
    acc_firstname,
    acc_lastname,
    acc_email,
    acc_dob,
    acc_gender,
    acc_school,
    acc_country) 
    VALUES 
    ("MrsLawson","123456",2,"Michelle","Lawson","michelle.lawson@victory.com","1981-09-19","F","Victory Primary","New Zealand"),
	("Deano","123456",2,"Dean","Stanley-Hunt","dean.stanleyhunt@victory.com","1984-02-23","M","NMIT","New Zealand"),
	("Jaydox","123456",1,"Jayden","Felices","j.felieces@victory.com","2010-02-14","M","Victory Primary","New Zealand"),
    ("Jetson","123456",1,"Jet","Mac","j.mac@victory.com","2011-06-16","M","Victory Primary","New Zealand"),
	("SuperSkyla","123456",1,"Skyla","SH","skyla.sh@victory.com","2003-02-21","F","Victory Primary","New Zealand"),
	("CoolAndre","123456",1,"DeAndre","SH","deandre.sh@victory.com","2006-08-14","M","Victory Primary","New Zealand");
    
#Insert Test Groups
INSERT INTO tbl_group (grp_name,acc_id_owner) VALUES ("2017_Room_3",1),("2018_Room_3",1),("2019_Room_3",1);

#Insert Test Group Members
INSERT INTO tbl_group_member (grp_id,acc_id) VALUES (1,4),(2,3),(2,4),(2,5),(2,6);

#Insert Test Add Requests
INSERT INTO tbl_group_add_request (grp_id,acc_id) VALUES (3,3),(3,4),(3,5),(3,6);

#Insert Test Group Messages
INSERT INTO tbl_group_message (grp_id,grp_msg_txt) VALUES (1,"Task: Trainer"),(2,"Task: Quiz"),(2,"Msg: Well Done Room 3!");

#Insert Actual Views
INSERT INTO tbl_view (view_name,view_title,view_description) VALUES 
	("HomeView.php","Mathland - Learning has never been more fun!","Mathland Home Page and Account Overview!"),
	("LoginView.php","Mathland - Login!","Login to Develop your skills, see statistics as Educators!"),
    ("RegisterView.php","Mathland - Register!","Not a Member at Mathland? Sign up is free, join in the fun today!"),
    ("TutorialView.php","Mathland - Tutorials!","Need help with Mathematical concepts? Our Tutorials will help!"),
    ("PracticeView.php","Mathland - Practice!","Learners can Practice & Educators Run Exams with our Math Quizes!"),
    ("TrainerView.php","Mathland - Games!","Improve Math Equation solving speeds with our Speed Trainer Game!"),
    ("AboutView.php","Mathland - About!","Find out about Mathland and what our goals are in the About Section!"),
    ("CompetitionView.php","Mathland - Competition!","Sign up & Enter the Draw to Win a Computer for your School!"),
    ("ProfileView.php","Mathland - Profile for ","Mathland Profiles let others learn about you and your Stats!");

#Insert Actual Comp Questions
INSERT INTO tbl_comp_question (comp_ques_txt,comp_ques_opt1,comp_ques_opt2,comp_ques_opt3,comp_ques_answr) VALUES 
	("What does 256 plus 244 equal?","490","500","510","500"),
    ("What does 256 minus 244 equal?","8","10","12","12"),
    ("What does 72 divided 9 equal?","8","7","6","8"),
    ("What does 7 times 9 equal?","58","63","72","63");

#Insert Test Nav History
INSERT INTO tbl_account_nav_history (acc_id,view_id,nav_info) VALUES (2,1,""),(2,2,""),(3,5,""),(3,1,"");

#Insert Test Tutorial Comments
INSERT INTO tbl_comment (comment_section,comment_from,comment_txt) VALUES 
	("Tut1",2,"Wow these Addition tutorials have been so helpful!"),
    ("Tut1",1,"I learned lots about Addition thanks!"),
    ("Tut1",4,"These Addition tutorials are so cool!"),
    ("Tut1",5,"Im a pro at Addition now!"),
    ("Tut1",6,"Where can I learn more about Addition?"),
	("Tut1",3,"I cant believe I learned column addition in 1 day, this rocks."),
    ("Tut2",3,"Wow these Subtraction tutorials have been so helpful!"),
    ("Tut2",5,"I learned lots about Subtraction thanks!"),
    ("Tut2",4,"These Subtraction tutorials are so cool!"),
    ("Tut2",1,"Im a pro at Subtraction now!"),
    ("Tut2",6,"Where can I learn more about Subtraction?"),
	("Tut2",2,"I cant believe I learned column Subtraction in 1 day, this rocks."),
    ("Tut3",4,"Wow these Multiplication tutorials have been so helpful!"),
    ("Tut3",6,"I learned lots about Multiplication thanks!"),
    ("Tut3",2,"These Multiplication tutorials are so cool!"),
    ("Tut3",5,"Im a pro at Multiplication now!"),
    ("Tut3",1,"Where can I learn more about Multiplication?"),
	("Tut3",3,"I cant believe I learned column Multiplication in 1 day, this rocks."),
    ("Tut4",2,"Wow these Division tutorials have been so helpful!"),
    ("Tut4",3,"I learned lots about Division thanks!"),
    ("Tut4",4,"These Division tutorials are so cool!"),
    ("Tut4",5,"Im a pro at Division now!"),
    ("Tut4",6,"Where can I learn more about Division?"),
	("Tut4",1,"I cant believe I learned column Division in 1 day, this rocks.");