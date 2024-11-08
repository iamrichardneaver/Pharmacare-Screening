
CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE screening_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Update health_screenings table to use foreign keys
ALTER TABLE health_screenings 
    ADD COLUMN location_id INT,
    ADD COLUMN screening_type_id INT,
    ADD FOREIGN KEY (location_id) REFERENCES locations(id),
    ADD FOREIGN KEY (screening_type_id) REFERENCES screening_types(id);

-- Drop old columns and indexes
ALTER TABLE health_screenings 
    DROP COLUMN location,
    DROP COLUMN screening_type;

DROP INDEX idx_location ON health_screenings;
DROP INDEX idx_screening_type ON health_screenings;

-- Create new indexes
CREATE INDEX idx_location_id ON health_screenings(location_id);
CREATE INDEX idx_screening_type_id ON health_screenings(screening_type_id);
