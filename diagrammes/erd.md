```mermaid
erDiagram
    USERS {
        int id_user PK
        varchar nom_user
        varchar email
        varchar password_hash
         role enum ('enseignant','etudiant')
        datetime created_at
    }

    CATEGORY {
        int id_category PK
        varchar nom_category
        varchar description_category
        int created_by FK
        datetime created_at
        datetime updated_at
    }

    QUIZ {
        int id_quiz PK
        varchar titre_quiz
        varchar description_quiz
        int id_categorie FK
        int id_enseignant FK
        datetime created_at
        datetime updated_at
        boolean is_active
    }


    QUESTION {
        int id_question PK
        int quiz_id FK
        varchar question
        varchar option1
        varchar option2
        varchar option3
        varchar option4
        int correct_option
        datetime created_at
    }

    RESULT {
        int id_result PK
        int id _quiz FK
        int id_etudiant FK
        int score
        int total_questions
        datetime completed_at
    }

    USER ||--o{ CATEGORY : "crée"
    USER ||--o{ QUIZ : "crée"
    CATEGORY ||--o{ QUIZ : "contient"
    QUIZ ||--o{ QUESTION : "contient"
    QUIZ ||--o{ RESULT : "a"
    USER ||--o{ RESULT : "obtient"

