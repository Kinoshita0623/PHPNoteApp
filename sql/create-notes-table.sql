CREATE TABLE notes(
    id BIGINT PRIMARY KEY AUTO_INCREMENT, 
    title VARCHAR(255) NOT NULL, 
    text VARCHAR(1000) NOT NULL, 
    user_id BIGINT NOT NULL,
    INDEX(user_id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);