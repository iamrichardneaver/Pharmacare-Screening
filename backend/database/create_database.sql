
-- Create the database
CREATE DATABASE IF NOT EXISTS pharmacare_health_screening;
USE pharmacare_health_screening;

-- Patient Information table
CREATE TABLE IF NOT EXISTS patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    address VARCHAR(255),
    phone_number VARCHAR(20),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Agent Information table
CREATE TABLE IF NOT EXISTS agents (
    agent_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Screening Types table
CREATE TABLE IF NOT EXISTS screening_types (
    screening_type_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Screening Records table
CREATE TABLE IF NOT EXISTS screening_records (
    screening_record_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    agent_id INT NOT NULL,
    screening_type_id INT NOT NULL,
    screening_date DATETIME NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    FOREIGN KEY (agent_id) REFERENCES agents(agent_id),
    FOREIGN KEY (screening_type_id) REFERENCES screening_types(screening_type_id)
);

-- Results and Findings table
CREATE TABLE IF NOT EXISTS results_and_findings (
    result_id INT AUTO_INCREMENT PRIMARY KEY,
    screening_record_id INT NOT NULL,
    parameter_name VARCHAR(100) NOT NULL,
    parameter_value VARCHAR(255) NOT NULL,
    normal_range VARCHAR(100),
    is_normal BOOLEAN,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (screening_record_id) REFERENCES screening_records(screening_record_id)
);

-- Index for faster queries
CREATE INDEX idx_patient_id ON screening_records(patient_id);
CREATE INDEX idx_agent_id ON screening_records(agent_id);
CREATE INDEX idx_screening_type_id ON screening_records(screening_type_id);
CREATE INDEX idx_screening_record_id ON results_and_findings(screening_record_id);
