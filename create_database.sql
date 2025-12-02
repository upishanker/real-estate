-- Database Systems Website Project
-- Create and populate database script

-- Create database
DROP DATABASE IF EXISTS real_estate_mls;
CREATE DATABASE real_estate_mls;
USE real_estate_mls;

-- Create Property table
CREATE TABLE Property (
                          address VARCHAR(50) PRIMARY KEY,
                          ownerName VARCHAR(30) NOT NULL,
                          price INTEGER NOT NULL
);

-- Create House table
CREATE TABLE House (
                       address VARCHAR(50) PRIMARY KEY,
                       bedrooms INTEGER NOT NULL,
                       bathrooms INTEGER NOT NULL,
                       size INTEGER NOT NULL,
                       FOREIGN KEY (address) REFERENCES Property(address) ON DELETE CASCADE
);

-- Create BusinessProperty table
CREATE TABLE BusinessProperty (
                                  address VARCHAR(50) PRIMARY KEY,
                                  type CHAR(20) NOT NULL,
                                  size INTEGER NOT NULL,
                                  FOREIGN KEY (address) REFERENCES Property(address) ON DELETE CASCADE
);

-- Create Firm table
CREATE TABLE Firm (
                      id INTEGER PRIMARY KEY,
                      name VARCHAR(30) NOT NULL,
                      address VARCHAR(50) NOT NULL
);

-- Create Agent table
CREATE TABLE Agent (
                       agentId INTEGER PRIMARY KEY,
                       name VARCHAR(30) NOT NULL,
                       phone CHAR(12) NOT NULL,
                       firmId INTEGER NOT NULL,
                       dateStarted DATE NOT NULL,
                       FOREIGN KEY (firmId) REFERENCES Firm(id)
);

-- Create Listings table
CREATE TABLE Listings (
                          mlsNumber INTEGER PRIMARY KEY,
                          address VARCHAR(50) NOT NULL,
                          agentId INTEGER NOT NULL,
                          dateListed DATE NOT NULL,
                          FOREIGN KEY (address) REFERENCES Property(address) ON DELETE CASCADE,
                          FOREIGN KEY (agentId) REFERENCES Agent(agentId),
                          UNIQUE(address)
);

-- Create Buyer table
CREATE TABLE Buyer (
                       id INTEGER PRIMARY KEY,
                       name VARCHAR(30) NOT NULL,
                       phone CHAR(12) NOT NULL,
                       propertyType CHAR(20) NOT NULL,
                       bedrooms INTEGER,
                       bathrooms INTEGER,
                       businessPropertyType CHAR(20),
                       minimumPreferredPrice INTEGER,
                       maximumPreferredPrice INTEGER
);

-- Create Works_With table
CREATE TABLE Works_With (
                            buyerId INTEGER,
                            agentId INTEGER,
                            PRIMARY KEY (buyerId, agentId),
                            FOREIGN KEY (buyerId) REFERENCES Buyer(id),
                            FOREIGN KEY (agentId) REFERENCES Agent(agentId)
);

-- Populate Firm table
INSERT INTO Firm VALUES (1, 'Premium Realty Group', '100 Main St, Boston, MA');
INSERT INTO Firm VALUES (2, 'Coastal Properties Inc', '250 Ocean Ave, Miami, FL');
INSERT INTO Firm VALUES (3, 'Urban Living Real Estate', '500 Broadway, New York, NY');
INSERT INTO Firm VALUES (4, 'Suburban Homes LLC', '75 Park Rd, Chicago, IL');
INSERT INTO Firm VALUES (5, 'Elite Commercial Realty', '900 Business Blvd, LA, CA');

-- Populate Agent table
INSERT INTO Agent VALUES (1, 'John Smith', '617-555-0101', 1, '2020-01-15');
INSERT INTO Agent VALUES (2, 'Sarah Johnson', '305-555-0202', 2, '2019-06-20');
INSERT INTO Agent VALUES (3, 'Michael Brown', '212-555-0303', 3, '2021-03-10');
INSERT INTO Agent VALUES (4, 'Emily Davis', '312-555-0404', 4, '2018-11-05');
INSERT INTO Agent VALUES (5, 'David Wilson', '213-555-0505', 5, '2022-02-28');

-- Populate Property table (Houses)
INSERT INTO Property VALUES ('123 Elm St, Boston, MA', 'Robert Anderson', 225000);
INSERT INTO Property VALUES ('456 Oak Ave, Miami, FL', 'Linda Martinez', 185000);
INSERT INTO Property VALUES ('789 Maple Dr, New York, NY', 'James Thompson', 450000);
INSERT INTO Property VALUES ('321 Pine Rd, Chicago, IL', 'Patricia Garcia', 175000);
INSERT INTO Property VALUES ('654 Cedar Ln, Boston, MA', 'Christopher Lee', 310000);
INSERT INTO Property VALUES ('987 Birch St, Miami, FL', 'Mary Rodriguez', 215000);
INSERT INTO Property VALUES ('147 Spruce Ave, Chicago, IL', 'Daniel White', 195000);

-- Populate Property table (Business Properties)
INSERT INTO Property VALUES ('200 Commerce St, Boston, MA', 'Boston Holdings LLC', 550000);
INSERT INTO Property VALUES ('350 Trade Ave, Miami, FL', 'Sunshine Investments', 420000);
INSERT INTO Property VALUES ('500 Market Rd, New York, NY', 'Metro Commercial Inc', 890000);
INSERT INTO Property VALUES ('125 Business Blvd, Chicago, IL', 'Midwest Properties', 275000);
INSERT INTO Property VALUES ('800 Industrial Way, LA, CA', 'Pacific Realty Group', 650000);

-- Populate House table
INSERT INTO House VALUES ('123 Elm St, Boston, MA', 3, 2, 1800);
INSERT INTO House VALUES ('456 Oak Ave, Miami, FL', 3, 2, 1650);
INSERT INTO House VALUES ('789 Maple Dr, New York, NY', 4, 3, 2400);
INSERT INTO House VALUES ('321 Pine Rd, Chicago, IL', 3, 2, 1500);
INSERT INTO House VALUES ('654 Cedar Ln, Boston, MA', 4, 2, 2100);
INSERT INTO House VALUES ('987 Birch St, Miami, FL', 3, 2, 1750);
INSERT INTO House VALUES ('147 Spruce Ave, Chicago, IL', 2, 1, 1200);

-- Populate BusinessProperty table
INSERT INTO BusinessProperty VALUES ('200 Commerce St, Boston, MA', 'office space', 3500);
INSERT INTO BusinessProperty VALUES ('350 Trade Ave, Miami, FL', 'store front', 2800);
INSERT INTO BusinessProperty VALUES ('500 Market Rd, New York, NY', 'office space', 5000);
INSERT INTO BusinessProperty VALUES ('125 Business Blvd, Chicago, IL', 'gas station', 2000);
INSERT INTO BusinessProperty VALUES ('800 Industrial Way, LA, CA', 'office space', 4200);

-- Populate Listings table
INSERT INTO Listings VALUES (1001, '123 Elm St, Boston, MA', 1, '2024-11-01');
INSERT INTO Listings VALUES (1002, '456 Oak Ave, Miami, FL', 2, '2024-10-15');
INSERT INTO Listings VALUES (1003, '789 Maple Dr, New York, NY', 3, '2024-11-10');
INSERT INTO Listings VALUES (1004, '321 Pine Rd, Chicago, IL', 4, '2024-10-20');
INSERT INTO Listings VALUES (1005, '654 Cedar Ln, Boston, MA', 1, '2024-11-05');
INSERT INTO Listings VALUES (1006, '200 Commerce St, Boston, MA', 1, '2024-10-25');
INSERT INTO Listings VALUES (1007, '350 Trade Ave, Miami, FL', 2, '2024-11-12');
INSERT INTO Listings VALUES (1008, '500 Market Rd, New York, NY', 3, '2024-10-30');
INSERT INTO Listings VALUES (1009, '125 Business Blvd, Chicago, IL', 4, '2024-11-08');
INSERT INTO Listings VALUES (1010, '987 Birch St, Miami, FL', 2, '2024-11-15');
INSERT INTO Listings VALUES (1011, '147 Spruce Ave, Chicago, IL', 4, '2024-11-18');
INSERT INTO Listings VALUES (1012, '800 Industrial Way, LA, CA', 5, '2024-11-20');

-- Populate Buyer table
INSERT INTO Buyer VALUES (1, 'Alice Cooper', '617-555-1001', 'house', 3, 2, NULL, 100000, 250000);
INSERT INTO Buyer VALUES (2, 'Bob Turner', '305-555-1002', 'house', 4, 3, NULL, 300000, 500000);
INSERT INTO Buyer VALUES (3, 'Carol White', '212-555-1003', 'business', NULL, NULL, 'office space', 400000, 900000);
INSERT INTO Buyer VALUES (4, 'David Black', '312-555-1004', 'house', 3, 2, NULL, 150000, 220000);
INSERT INTO Buyer VALUES (5, 'Emma Green', '213-555-1005', 'business', NULL, NULL, 'store front', 200000, 500000);
INSERT INTO Buyer VALUES (6, 'Frank Blue', '617-555-1006', 'house', 2, 1, NULL, 100000, 200000);

-- Populate Works_With table
INSERT INTO Works_With VALUES (1, 1);
INSERT INTO Works_With VALUES (2, 3);
INSERT INTO Works_With VALUES (3, 3);
INSERT INTO Works_With VALUES (4, 4);
INSERT INTO Works_With VALUES (5, 2);
INSERT INTO Works_With VALUES (1, 4);
INSERT INTO Works_With VALUES (6, 4);

-- Verify data insertion
SELECT 'Property table:' as '';
SELECT * FROM Property;

SELECT 'House table:' as '';
SELECT * FROM House;

SELECT 'BusinessProperty table:' as '';
SELECT * FROM BusinessProperty;

SELECT 'Firm table:' as '';
SELECT * FROM Firm;

SELECT 'Agent table:' as '';
SELECT * FROM Agent;

SELECT 'Listings table:' as '';
SELECT * FROM Listings;

SELECT 'Buyer table:' as '';
SELECT * FROM Buyer;

SELECT 'Works_With table:' as '';
SELECT * FROM Works_With;