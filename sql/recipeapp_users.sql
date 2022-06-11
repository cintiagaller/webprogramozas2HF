CREATE TABLE users (
    userId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    userName VARCHAR(50),
    password VARCHAR(50),  
    CONSTRAINT uc_userId_userName UNIQUE (userId, userName)
);

INSERT INTO recipeapp.users (userId, userName, password) VALUES (1, 'test', 'test');
INSERT INTO recipeapp.users (userId, userName, password) VALUES (1, '4444', '44444');