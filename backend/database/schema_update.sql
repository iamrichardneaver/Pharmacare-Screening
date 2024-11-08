
ALTER TABLE health_screenings ADD COLUMN location VARCHAR(100);
ALTER TABLE health_screenings ADD COLUMN screening_type VARCHAR(50);

CREATE INDEX idx_location ON health_screenings(location);
CREATE INDEX idx_screening_type ON health_screenings(screening_type);
