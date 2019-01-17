CREATE TABLE users (
    user_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Идентификатор пользователя',
    name VARCHAR(255) NOT NULL COMMENT 'Имя пользователя',
    email VARCHAR(255) NOT NULL COMMENT 'E-mail пользователя',
    password_hash VARCHAR(255) NOT NULL COMMENT 'Хеш пароля пользователя'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Пользователи';

ALTER TABLE users ADD KEY idx_email (email);

INSERT INTO users (name, email, password_hash)
VALUE ('Сергей', 'test@gmail.com', '???');
