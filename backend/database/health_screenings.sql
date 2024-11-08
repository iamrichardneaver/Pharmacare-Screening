
CREATE TABLE IF NOT EXISTS health_screenings (
    screening_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    screening_type VARCHAR(50) NOT NULL,
    value FLOAT NOT NULL,
    unit VARCHAR(20),
    date_recorded DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id)
);
