CREATE TABLE recipes (
    recipeId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    recipeTitle VARCHAR(100),
    recipeShortDescription VARCHAR(500),
    recipePrepTimeMinutes INT,
    recipeServings TINYINT,
    recipeImageUrl VARCHAR(200),
    recipeAuthor VARCHAR(50),
    FOREIGN KEY (recipeAuthor) REFERENCES users(userName),
    CONSTRAINT uc_recipeId_userName UNIQUE (recipeId, recipeTitle)
);

INSERT INTO recipeapp.recipes (recipeId, recipeTitle, recipeShortDescription, recipePrepTimeMinutes, recipeServings, recipeImageUrl, recipeAuthor) VALUES (1, 'Garlic Shrimp Kabobs', 'This is a quick and easy shrimp kabob recipe, perfect for beginners. Requires minimal ingredients, but is bursting with flavor. Serve over a bed of rice with fresh lemon wedges.', 140, 6, 'shrimp.jpg', '4444');
INSERT INTO recipeapp.recipes (recipeId, recipeTitle, recipeShortDescription, recipePrepTimeMinutes, recipeServings, recipeImageUrl, recipeAuthor) VALUES (2, 'Classic Waffles', 'A lovely, crispy waffle perfect for the morning.', 25, 5, 'waffle.jpg', '4444');
INSERT INTO recipeapp.recipes (recipeId, recipeTitle, recipeShortDescription, recipePrepTimeMinutes, recipeServings, recipeImageUrl, recipeAuthor) VALUES (3, 'Kung Pao Chicken', "This spicy kung pao chicken is similar to what is served in Chinese restaurants. It's easy to make, and you can be as creative with the measurements as you want. The sauce reduces until nice and thick. Substitute cashews for peanuts, or bamboo shoots for the water chestnuts. You can't go wrong!", 90, 4, 'kungpao.jpg', '4444');
INSERT INTO recipeapp.recipes (recipeId, recipeTitle, recipeShortDescription, recipePrepTimeMinutes, recipeServings, recipeImageUrl, recipeAuthor) VALUES (4, 'Classic Waffles2', 'A lovely, crispy waffle perfect for the morning.', 25, 5, 'waffle.jpg', '4444');
INSERT INTO recipeapp.recipes (recipeId, recipeTitle, recipeShortDescription, recipePrepTimeMinutes, recipeServings, recipeImageUrl, recipeAuthor) VALUES (5, 'Classic Waffles3', 'A lovely, crispy waffle perfect for the morning.', 25, 5, 'waffle.jpg', '4444');
INSERT INTO recipeapp.recipes (recipeId, recipeTitle, recipeShortDescription, recipePrepTimeMinutes, recipeServings, recipeImageUrl, recipeAuthor) VALUES (6, 'Classic Waffles4', 'A lovely, crispy waffle perfect for the morning.', 25, 5, 'waffle.jpg', '4444');
INSERT INTO recipeapp.recipes (recipeId, recipeTitle, recipeShortDescription, recipePrepTimeMinutes, recipeServings, recipeImageUrl, recipeAuthor) VALUES (7, 'Classic Waffles5', 'A lovely, crispy waffle perfect for the morning.', 25, 5, 'waffle.jpg', '4444');
INSERT INTO recipeapp.recipes (recipeId, recipeTitle, recipeShortDescription, recipePrepTimeMinutes, recipeServings, recipeImageUrl, recipeAuthor) VALUES (8, 'Classic Waffles6', 'A lovely, crispy waffle perfect for the morning.', 25, 5, 'waffle.jpg', '4444');
