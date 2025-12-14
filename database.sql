CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    dob DATE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
select * from users;
--  Face Authentication Table (Stores facial recognition data)
CREATE TABLE face_auth (
    id INT PRIMARY KEY REFERENCES users(id) ON DELETE CASCADE,
    face_data text NOT NULL, -- Storing face data
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
select * from face_auth;
--for storing passwords
CREATE TABLE passwords (
    pass_id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    salt VARCHAR(64) NOT NULL,
    pepper VARCHAR(64) NOT NULL,
    key VARCHAR(255) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
select * from passwords;