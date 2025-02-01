USE assign2db;

-- Part 1 SQL Updates

-- Show all data in the nurse table
SELECT * FROM nurse;

-- Change last name to 'Cyrus' for nurses named Miley
UPDATE nurse
SET lastname = 'Cyrus'
WHERE firstname = 'Miley';

-- Show updated nurse table
SELECT * FROM nurse;

-- Set start date for nurses working with Dr. Tanaka to match Dr. Tanaka's start date
UPDATE nurse AS n
JOIN workingfor AS w ON n.nurseid = w.nurseid
JOIN doctor AS d ON w.docid = d.docid
SET n.startdate = d.startdate
WHERE d.lastname = 'Tanaka';

-- Show final nurse table after updates
SELECT * FROM nurse;

-- Part 2 SQL Inserts

-- Add Dr. Meredith Grey to the doctor table
INSERT INTO doctor (docid, firstname, lastname, birthdate, startdate)
VALUES ('GRY25', 'Meredith', 'Grey', '1978-08-03', '2005-09-27'); 

-- Add patient Cristina Yang assigned to Dr. Grey
INSERT INTO patient (ohip, firstname, lastname, weight, birthdate, height, treatsdocid)
VALUES ('123456789', 'Cristina', 'Yang', 58, '1981-03-17', 1.65, 'GRY25');

-- Add nurse Ellen Pompeo reporting to nurse Alex Russo (BBBB2)
INSERT INTO nurse (nurseid, firstname, lastname, startdate, reporttonurseid)
VALUES ('EP001', 'Ellen', 'Pompeo', '2023-01-15', 'BBBB2');

-- Assign nurse Ellen Pompeo to work 50 hours for Dr. Grey
INSERT INTO workingfor (docid, nurseid, hours)
VALUES ('GRY25', 'EP001', 50);

-- Show all data in doctor table
SELECT * FROM doctor;

-- Show all data in patient table
SELECT * FROM patient;

-- Show all data in nurse table
SELECT * FROM nurse;

-- Show all data in workingfor table
SELECT * FROM workingfor;


-- Part 3 SQL Queries

-- Show the last names of all the patients
SELECT lastname FROM patient;

-- Show the last names of all the patients with no repeats
SELECT DISTINCT lastname FROM patient;

-- Show all the data in the doctors table, ordered by when they started working at the office
SELECT * FROM doctor ORDER BY startdate;

-- Show the OHIP, first and last name, and weight of all patients who are 50 or more kilograms, ordered by weight from lightest to heaviest
SELECT ohip, firstname, lastname, weight 
FROM patient 
WHERE weight >= 50 
ORDER BY weight ASC;

-- List the first name and last name of any patients who have Dr. Tanaka as their doctor
SELECT firstname, lastname 
FROM patient 
WHERE treatsdocid = (SELECT docid FROM doctor WHERE lastname = 'Tanaka');

-- List all doctors' first and last names with their patients' first and last names, or NULL if they have no patients
SELECT d.firstname AS 'Doctor First Name', d.lastname AS 'Doctor Last Name', 
       p.firstname AS 'Patient First Name', p.lastname AS 'Patient Last Name'
FROM doctor d
LEFT JOIN patient p ON d.docid = p.treatsdocid;

-- Find the first and last name of any doctor who has no patients
SELECT firstname, lastname 
FROM doctor 
WHERE docid NOT IN (SELECT treatsdocid FROM patient);

-- Find the overall average number of hours worked by all nurses for all doctors
SELECT AVG(hours) AS 'Average Hours Worked' 
FROM workingfor;

-- Show each nurse's first and last name, and their supervisor's first and last name (NULL if no supervisor)
SELECT n1.firstname AS 'Nurse First Name', n1.lastname AS 'Nurse Last Name',
       n2.firstname AS 'Supervisor First Name', n2.lastname AS 'Supervisor Last Name'
FROM nurse AS n1
LEFT JOIN nurse AS n2 ON n1.reporttonurseid = n2.nurseid;

-- Find the total hours worked and total pay for each nurse, ordered by highest to lowest total pay
SELECT n.firstname AS 'Nurse First Name', n.lastname AS 'Nurse Last Name', 
       SUM(w.hours) AS 'Total Hours', 
       CONCAT('$', FORMAT(SUM(w.hours) * 30, 2)) AS 'Total Pay'
FROM nurse n
JOIN workingfor w ON n.nurseid = w.nurseid
GROUP BY n.nurseid
ORDER BY SUM(w.hours) * 30 DESC;

-- Display the name of a patient and the names of nurses they could have potentially been seen by based on doctor assignments
SELECT p.firstname AS 'Patient First Name', p.lastname AS 'Patient Last Name', 
       n.firstname AS 'Nurse First Name', n.lastname AS 'Nurse Last Name'
FROM patient p
JOIN workingfor w ON p.treatsdocid = w.docid
JOIN nurse n ON w.nurseid = n.nurseid;

-- List the patient's first and last name, their age and birthdate, and the doctor's first name, last name, age, and birthdate, for patients with a doctor younger than the patient
SELECT p.firstname AS 'Patient First Name', p.lastname AS 'Patient Last Name', 
       TIMESTAMPDIFF(YEAR, p.birthdate, CURDATE()) AS 'Patient Age', p.birthdate AS 'Patient Birthdate',
       d.firstname AS 'Doctor First Name', d.lastname AS 'Doctor Last Name',
       TIMESTAMPDIFF(YEAR, d.birthdate, CURDATE()) AS 'Doctor Age', d.birthdate AS 'Doctor Birthdate'
FROM patient p
JOIN doctor d ON p.treatsdocid = d.docid
WHERE TIMESTAMPDIFF(YEAR, d.birthdate, CURDATE()) < TIMESTAMPDIFF(YEAR, p.birthdate, CURDATE());

-- List the first and last names of nurses who don't work for Dr. Tanaka
SELECT DISTINCT n.firstname, n.lastname 
FROM nurse n
JOIN workingfor w ON n.nurseid = w.nurseid
JOIN doctor d ON w.docid = d.docid
WHERE d.lastname != 'Tanaka';

-- Find all nurses who work for more than 1 doctor, also showing the number of doctors they work for
SELECT n.firstname AS 'Nurse First Name', n.lastname AS 'Nurse Last Name', 
       COUNT(DISTINCT w.docid) AS 'Number of Doctors'
FROM nurse n
JOIN workingfor w ON n.nurseid = w.nurseid
GROUP BY n.nurseid
HAVING COUNT(DISTINCT w.docid) > 1;

-- My Query - Find the name of the doctor with the most patients
SELECT d.firstname AS 'Doctor First Name', d.lastname AS 'Doctor Last Name', 
       COUNT(p.ohip) AS 'Number of Patients'
FROM doctor d
LEFT JOIN patient p ON d.docid = p.treatsdocid
GROUP BY d.docid
ORDER BY COUNT(p.ohip) DESC
LIMIT 1;

-- Part 4 SQL Views/Deletes

-- Create a view to show the first and last name of each doctor and the count of patients they are treating, named "DoctorPatientCount"
CREATE VIEW DoctorPatientCount AS
SELECT d.firstname, d.lastname, COUNT(p.ohip) AS numofpat
FROM doctor d
JOIN patient p ON d.docid = p.treatsdocid
GROUP BY d.docid
HAVING numofpat > 0;

-- Prove the view works by selecting only doctors with exactly 2 patients
SELECT * FROM DoctorPatientCount
WHERE numofpat = 2;

-- Query to show all data in the doctor table
SELECT * FROM doctor;

-- Delete the doctor with the doctor ID of HIT45
DELETE FROM doctor
WHERE docid = 'HIT45';

-- Prove that the doctor with ID HIT45 was deleted
SELECT * FROM doctor;

-- Query to count the number of doctors in the doctor table
SELECT COUNT(*) AS 'Number of Doctors' FROM doctor;

-- Delete the doctor with the doctor ID of RAD34
DELETE FROM doctor
WHERE docid = 'RAD34';

-- Show the number of doctors again to see if the deletion worked
SELECT COUNT(*) AS 'Number of Doctors' FROM doctor;
