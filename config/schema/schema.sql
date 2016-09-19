CREATE TABLE searches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    term VARCHAR(255) NOT NULL,
    executed DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tweets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    search_id INT NOT NULL,
    tweet_text VARCHAR(255) NOT NULL,
    tweet_url VARCHAR(255) NOT NULL,
    profile_name VARCHAR(255) NOT NULL,
    profile_url VARCHAR(255) NOT NULL,
    retweet_count INT NOT NULL,
    favorite_count INT NOT NULL,
    popularity INT NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY search_key (search_id) REFERENCES searches(id) ON DELETE CASCADE
);
