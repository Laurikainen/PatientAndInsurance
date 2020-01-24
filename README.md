## MySQL and PHP

Integrating MySQL and PHP to store patients and their insurance data in two different tables which are connected by a foreign key.

##### Creating table named patient

```mysql
CREATE TABLE patient (
_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
pn VARCHAR(11),
first VARCHAR(15),
last VARCHAR(25),
dob DATE,
PRIMARY KEY (_id)
);
```

##### Creating table named insurance

```mysql
CREATE TABLE insurance (
_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
patient_id INT(10) UNSIGNED NOT NULL,
iname VARCHAR(40),
from_date DATE,
to_date DATE,
PRIMARY KEY (_id),
FOREIGN KEY (patient_id) REFERENCES patient(_id)
);
```

##### Populating tables with sample data

```mysql
INSERT INTO patient (pn, first, last, dob) 
VALUES ('00000000001', 'Mark', 'Stone', '2000-12-27');
INSERT INTO patient (pn, first, last, dob) 
VALUES ('00000000002', 'Mary', 'Miller', '1971-07-01');
INSERT INTO patient (pn, first, last, dob) 
VALUES ('00000000003', 'James', 'Parker', '1974-03-20');
INSERT INTO patient (pn, first, last, dob) 
VALUES ('00000000004', 'Alan', 'Brown', '1980-01-08');
INSERT INTO patient (pn, first, last, dob) 
VALUES ('00000000005', 'Willow', 'Loper', '1999-10-18');
```

```mysql
INSERT INTO insurance (patient_id, iname, from_date, to_date) 
VALUES (1, 'Seesam', '2020-01-01', '2021-01-01');
INSERT INTO insurance (patient_id, iname, from_date, to_date) 
VALUES (1, 'Kasko', '1980-08-29', '1999-09-23');
INSERT INTO insurance (patient_id, iname, from_date, to_date) 
VALUES (2, 'Ergo', '2000-02-14', '2000-03-14');
INSERT INTO insurance (patient_id, iname, from_date, to_date) 
VALUES (2, 'If', '1973-07-15', '2019-09-22');
INSERT INTO insurance (patient_id, iname, from_date, to_date) 
VALUES (3, 'Salva', '2020-01-20', '2025-08-20');
INSERT INTO insurance (patient_id, iname, from_date, to_date) 
VALUES (3, 'Iizi', '1996-06-27', '1999-03-19');
INSERT INTO insurance (patient_id, iname, from_date, to_date) 
VALUES (4, 'PZU', '2004-11-11', '2006-08-23');
INSERT INTO insurance (patient_id, iname, from_date, to_date) 
VALUES (4, 'Inges', '2013-02-13', '2026-07-25');
INSERT INTO insurance (patient_id, iname, from_date, to_date) 
VALUES (5, 'Poliis', '2021-01-01', '2041-08-15');
INSERT INTO insurance (patient_id, iname, from_date, to_date) 
VALUES (5, 'BTA', '2012-12-12', '2023-12-11');
INSERT INTO insurance (patient_id, iname, from_date, to_date) 
VALUES (4, 'BZA', '2012-12-12', '2022-12-11');
```

To run the PatientTest.php from command line use command - **php phpunit.phar UnitTest PatientTest.php**, in command prompt

