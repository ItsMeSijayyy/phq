create database _Mindsoothe;
use _Mindsoothe;

CREATE TABLE User_Acc (
id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
firstName VARCHAR(50) NOT NULL,
lastName VARCHAR(50) NOT NULL,
email VARCHAR(50) NOT NULL,
password VARCHAR(50) NOT NULL,
profile_image VARCHAR(255) DEFAULT 'images/blueuser.svg',
status TINYINT(1) NOT NULL DEFAULT 0,
otp VARCHAR(6) DEFAULT NULL
);

DROP TABLE User_Acc;

CREATE TABLE Graceful_Thread (
id INT (10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
user_id INT(10) NOT NULL,
content TEXT NOT NULL,
likes INT (10) DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES User_Acc(id) ON DELETE CASCADE
);

DROP TABLE Graceful_Thread;

CREATE TABLE phq9_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL, -- Foreign key to User_Acc
    response_1 TINYINT NOT NULL,
    response_2 TINYINT NOT NULL,
    response_3 TINYINT NOT NULL,
    response_4 TINYINT NOT NULL,
    response_5 TINYINT NOT NULL,
    response_6 TINYINT NOT NULL,
    response_7 TINYINT NOT NULL,
    response_8 TINYINT NOT NULL,
    response_9 TINYINT NOT NULL,
    response_10 TINYINT NOT NULL,
    total_score TINYINT NOT NULL,
    depression_level VARCHAR(255),
    submission_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES User_Acc(id) ON DELETE CASCADE -- Foreign key referencing User_Acc
);

DROP TABLE phq9_results;

SELECT * FROM phq9_results;
