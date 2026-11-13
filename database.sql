CREATE DATABASE your_rollno_db;

USE your_rollno_db;

CREATE TABLE your_rollno (
    roll_no VARCHAR(20) PRIMARY KEY,
    name VARCHAR(100),
    gender VARCHAR(20),
    department VARCHAR(50),
    marks INT
);

INSERT INTO your_rollno VALUES
('101', 'Rahul', 'Male', 'CST', 85),
('102', 'Priya', 'Female', 'IT', 92),
('103', 'Amit', 'Male', 'CST', 67),
('104', 'Sneha', 'Female', 'ECE', 78),
('105', 'Arjun', 'Male', 'IT', 55);