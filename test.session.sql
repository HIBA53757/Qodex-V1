use qodex_v1

--@block
CREATE TABLE USERS (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom_user VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
   password_hash VARCHAR(255) NOT NULL,
    role ENUM('enseignant', 'etudiant') NOT NULL,
    created_at datetime NOT NULL  DEFAULT CURRENT_TIMESTAMP
) ;

--@block 
CREATE TABLE  CATEGORY (
    id_category INT AUTO_INCREMENT PRIMARY KEY,
    nom_category VARCHAR(200) NOT NULL,
    description_category VARCHAR(200) NOT NULL,
    created_at datetime NOT NULL,
    updated_at datetime NOT NULL,
    created_by INT NOT NULL,
    FOREIGN KEY (created_by) REFERENCES USERS(id_user)
);
--@block
CREATE TABLE   QUIZ  (
    id_quiz INT AUTO_INCREMENT PRIMARY KEY,
    titre_quiz VARCHAR(250) NOT NULL,
    description_quiz VARCHAR(350)NOT NULL,
    duree_minutes INT NOT NULL,
    id_category INT NOT NULL,
    id_enseignant INT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    FOREIGN KEY (id_category) REFERENCES CATEGORY(id_category),
    FOREIGN KEY (id_enseignant) REFERENCES USERS(id_user)
);

--@block 
CREATE TABLE QUESTION (
    id_question INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(250) NOT NULL,
    correct_option INT NOT NULL,
    option1  VARCHAR(250) NOT NULL,
    option2  VARCHAR(250) NOT NULL,
    option3  VARCHAR(250) NOT NULL,
    option4  VARCHAR(250) NOT NULL,
    created_at datetime NOT NULL,
    id_quiz INT NOT NULL,
    FOREIGN KEY (id_quiz) REFERENCES QUIZ(id_quiz)
);

--@block
CREATE TABLE RESULT (
      id_result INT  AUTO_INCREMENT PRIMARY KEY,
      score INT NOT NULL,
      total_questions INT NOT NULL,
      completed_at datetime NOT NULL,
      id_etudiant INT  NOT NULL,
      id_quiz INT NOT NULL,
      FOREIGN KEY (id_quiz) REFERENCES QUIZ(id_quiz),
      FOREIGN KEY (id_etudiant) REFERENCES USERS(id_user)
);

--@block 
ALTER TABLE USERS 
MODIFY created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;


--@block
ALTER TABLE QUIZ ADD COLUMN id_user INT;
