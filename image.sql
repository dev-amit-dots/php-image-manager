CREATE TABLE images (

    id INT AUTO_INCREMENT PRIMARY KEY,

    image_name VARCHAR(255) NOT NULL,

    optimized_image VARCHAR(255) NOT NULL,

    watermark_image VARCHAR(255) NOT NULL,

    image_size INT,

    image_type VARCHAR(50),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);