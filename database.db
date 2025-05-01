CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enrollment_no VARCHAR(20) UNIQUE,
    mobile_no VARCHAR(15),
    otp VARCHAR(6),
    otp_verified TINYINT(1) DEFAULT 0
);

CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    amount DECIMAL(10,2),
    status VARCHAR(20), -- e.g., "Paid", "Pending"
    txn_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id)
);
