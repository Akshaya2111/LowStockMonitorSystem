CREATE DATABASE stock_alert_iet;
USE stock_alert_iet;

-- Drop existing tables
DROP TABLE IF EXISTS sub_products;
DROP TABLE IF EXISTS main_products;

-- Create main_products table for categories
CREATE TABLE main_products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

-- Insert categories into main_products
INSERT INTO main_products (name) VALUES
('TATA PRODUCTS'),
('BHARAT BENZ'),
('ASHOK LEYLAND'),
('MAHINDRA TRUCKS'),
('EICHER & VOLVO EICHER'),
('SPECIAL PRODUCTS');

-- Create sub_products table for product data
CREATE TABLE sub_products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  product_description VARCHAR(255) NOT NULL,
  item_code VARCHAR(50),
  stock_quantity INT DEFAULT 0,
  min_stock_level INT DEFAULT 10,  -- UI: "RTA"
  max_stock_level INT DEFAULT 100, -- UI: "RTA and WIP"
  FOREIGN KEY (category_id) REFERENCES main_products(id) ON DELETE CASCADE
);

INSERT INTO sub_products (category_id, product_description, item_code, stock_quantity, min_stock_level, max_stock_level) VALUES
(1, 'G 400 V2 PTO', '2591500001', 20, 10, 100),
(1, 'G 550 V1 PTO', '2581100001', 20, 10, 100),
(1, 'G550_V1_REAR_MOUNT_PTO', '2626500001', 20, 10, 100),
(1, 'G 600 V0 PTO', '2510110000', 20, 10, 100),
(1, 'G 600 V1 PTO', '2510210000', 20, 10, 100),
(1, 'G 600 V1 0.7 PTO', '2620500001', 20, 10, 100),
(1, 'G 600 MPH V2 PTO', '2577200001', 20, 10, 100),
(1, 'G 600 V2 PTO', '2510310000', 20, 10, 100),
(1, 'G 750 MPH V2 PTO Spur', '2576400001', 20, 10, 100),
(1, 'G 750 MPH V2 Helical PTO', '2576200001', 20, 10, 100),
(1, 'G 750 V1 0.7 PTO', '2597900001', 20, 10, 100),
(1, 'G 750 V1 Helical PTO', '2624700001', 20, 10, 100),
(1, 'G 750 V1 MK-1 Helical PTO', '2584600001', 20, 10, 100),
(1, 'G750 V1 0.94 (HELICAL GEAR)', '2625900001', 20, 10, 100),
(1, 'G 750 V1 PTO Side Mounted 0.52 Ratio', '2515210000', 20, 10, 100),
(1, 'G 750 V1 PTO Side Mounted 0.94 Ratio Spur', '2580300001', 20, 10, 100),
(1, 'G 750 V1 PTO Side Mounted 0.94 Ratio (HELICAL GEAR)', '2625900001', 20, 10, 100),
(1, 'V1 PTO for TATA G750 Transmission with Helical Gear', '2624700001', 20, 10, 100),
(1, 'G 750 V2 MK1 Closed Type', '2571100001', 20, 10, 100),
(1, 'G750 V2 0.94 (HELICAL GEAR)', '2631800001', 20, 10, 100),
(1, 'G 750 V2 MPH Helical PTO', '2576200001', 20, 10, 100),
(1, 'G 750 V2 PTO Side Mounted 0.52 Ratio', '2515310000', 20, 10, 100),
(1, 'G 750 V2 PTO Side Mounted 0.94 Ratio', '2580400001', 20, 10, 100),
(1, 'G 750 V0 PTO', '2510110001', 20, 10, 100),
(1, 'G 750 VO PTO Helical', '2595600001', 20, 10, 100),
(1, 'G 950 1C V2 PTO with Flange & Coupler', '2571700001', 20, 10, 100),
(1, 'G 950 2W V2 PTO (with Bearing )', '2582200001', 20, 10, 100);

INSERT INTO sub_products (category_id, product_description, item_code, stock_quantity, min_stock_level, max_stock_level) VALUES
(2, 'G 85 1C V1 PTO', '2588500001', 20, 10, 100),
(2, 'G85 1C V1 with 97 OD Flange', '2622800001', 20, 10, 100),
(2, 'G85 WB V2 1.08 PTO', '2585600001', 20, 10, 100),
(2, 'G 85 2W with Bearing V2 PTO', '2572300001', 20, 10, 100),
(2, 'G 85 2W with Bearing V1 PTO', '2573700001', 20, 10, 100);

INSERT INTO sub_products (category_id, product_description, item_code, stock_quantity, min_stock_level, max_stock_level) VALUES
(3, 'AL Dost PTO with 5cc Pump', '2582800001', 20, 10, 100),
(3, 'AL Dost PTO with 8cc Pump', '25810000001', 20, 10, 100),
(3, 'AL Dost PTO without Pump', '2632700001', 20, 10, 100),
(3, 'DOST-RSB V1 PTO SPL. OUTPUT SHAFT', '2625200001', 20, 10, 100),
(3, 'AL Partner V1 PTO - Pneumatic', '2612500001', 20, 10, 100),
(3, 'AL Partner 2W - Pneumatic', '2610000001', 20, 10, 100),
(3, 'AL Partner with 2W integrated PTO', NULL, 20, 10, 100),
(3, 'AL Partner V1 PTO - Mechanical', '2591700001', 20, 10, 100),
(3, 'Eaton 6209 PTO (with Bearing) 1: 1.32', '2530310000', 20, 10, 100),
(3, 'Eaton 6209 PTO (with Bearing) w/o Quill Shaft', NULL, 20, 10, 100),
(3, 'Eaton 6209 PTO (w/o Bearing) w/o Quill Shaft', '2574600001', 20, 10, 100),
(3, 'Eaton 6209 PTO (without Bearing)', '2590200001', 20, 10, 100),
(3, 'Eaton 6306 PTO (with Bearing)', '2530110000', 20, 10, 100),
(3, 'Eaton 6306 PTO (with Bearing) - V1', '2530110011', 20, 10, 100),
(3, 'Eaton 6306 V2 1.08 Sealed PTO', '2621700001', 20, 10, 100),
(3, 'Eaton10309 with Quill Shaft Assy', '2611800001', 20, 10, 100),
(3, 'EATON 6306 V1 - INTEGRATED HD PTO', '2631300001', 20, 10, 100),
(3, 'HTHR - ZF6S', '2610500001', 20, 10, 100),
(3, 'HTHR - ZF6S', '2610500002', 20, 10, 100),
(3, 'HTHR - ZF6S', '2610500003', 20, 10, 100),
(3, 'HTHR - ZF6S', '2610500004', 20, 10, 100);

INSERT INTO sub_products (category_id, product_description, item_code, stock_quantity, min_stock_level, max_stock_level) VALUES
(4, 'MLK V1 PTO', '2535110001', 15, 5, 60),
(4, 'MLK V1 PTO', '2535110002', 10, 3, 50);

INSERT INTO sub_products (category_id, product_description, item_code, stock_quantity, min_stock_level, max_stock_level) VALUES
(5, 'ET50 S7 V1', '2587400001', 18, 6, 70),
(5, 'ET50 S7 V2', '2586900001', 22, 8, 80),
(5, 'ET70 S6', '2587600001', 16, 5, 65),
(5, 'ET90 S6', '2583800001', 20, 7, 75);

INSERT INTO sub_products (category_id, product_description, item_code, stock_quantity, min_stock_level, max_stock_level) VALUES
(6, 'TATA GBS 950 - Heavy Duty PTO 1.3', '2617700001', 15, 5, 60),
(6, 'Bolero Reduction Gear Box', '2597100001', 12, 4, 50),
(6, '4 Pad Pump Drive', '2625800001', 10, 3, 40),
(6, 'GEAR BOX (RED.RATIO 2:1)', NULL, 9, 3, 35),
(6, '3-Pad Pump Drive (Pulley Output)', 'Z-001-043-030', 11, 4, 45),
(6, '3 Pad Pump Drive (SAE-3)', '2633800001', 10, 4, 42),
(6, '3 PAD PUMP DRIVE SHORT FLANGE (SAE-2)', '2621400001', 10, 4, 44),
(6, '3 Pad Splitter Pump Drive', '2626200001', 9, 3, 38),
(6, 'SAE 8 Bolt PTO Assy CRT 5633', '2592300001', 13, 5, 48),
(6, 'SUV PTO + RPD 8 Spline PTO', '2018001600', 12, 4, 45),
(6, 'SUV+ LPD T-13/15 PTO', '2595500001', 11, 3, 40),
(6, 'SUV+ LPD 1.3 R Dualistic PTO with HTHR', NULL, 8, 3, 35),
(6, 'SUV+ LPD 8 SPLINE PTO (1:1.2)', '2620800001', 12, 4, 45),
(6, 'SUV+ LPD Dualistic 1:1R with AUX', '2610700001', 14, 5, 50),
(6, 'SUV+ LPD Dualistic PTO - 1:1R (STD)', '2614500001', 14, 5, 52),
(6, 'SUV+ LPD Dualistic PTO - 1:1R (Std) Fully Pneumatic', '2617800001', 13, 5, 50),
(6, 'SUV+ LPD Dualistic PTO with Aux Unit-25 Kgm (1:1)', '2624800001', 12, 4, 46),
(6, 'SUV+ LPD Dualistic PTO with AUX Unit - 25 KGM-R', '2595500001', 11, 4, 43),
(6, 'SUV+ LPD Dualistic PTO without Aux Unit', '2617100001', 12, 4, 44),
(6, 'SUV+ LPD T-15/15 PTO (1:1.2)', '2599100001', 11, 4, 41),
(6, 'SUV+ LPD Single shifting PTO 1:1 97 OD Flange', '2631500001', 10, 4, 42),
(6, 'SUV+ RPD Single shifting PTO 1:1 97 OD Flange', '2631400001', 10, 4, 42),
(6, 'SUV+ LPD Dualistic PTO-1:1R (Std) Fully Pneumatic', '2621200001', 11, 4, 45),
(6, 'SUV+ LPD Single shifting PTO 1:1 MARK-1', '2631200001', 10, 4, 40);
INSERT INTO sub_products (category_id, product_description, item_code, stock_quantity, min_stock_level, max_stock_level) VALUES
(6, '400-40 LH (SS PTO) - (For Cross toothed flange OD 120)', '2630200001', 9, 3, 38),
(6, 'JetVAC PTO 400kgm', '2614100001', 13, 5, 50),
(6, 'Jet Vac Main Unit-400 KGM', '2586500001', 12, 4, 48),
(6, 'JetVAC PTO + Centre Unit + 25kgm + 40Kgm Aux', '2578300001', 11, 4, 45),
(6, 'JetVAC PTO + Centre Unit + 25kgm Aux', '2614700001', 10, 4, 42),
(6, 'JetVAC PTO + Centre Unit + 40kgm Aux', '2614600001', 10, 4, 42),
(6, 'JetVAC H 400-40/25', '2617300001', 11, 4, 44),
(6, 'JetVAC H 400-40', '2611600001', 10, 4, 40),
(6, 'JetVAC H400-40 RH/LH Split Shaft PTO', '2623500001', 9, 3, 38),
(6, 'Jet Vac Main Unit - 400 KGM DIN 100 Flange', '2632100001', 11, 4, 45),
(6, 'Jetvac - Split Shaft Power Take Off (Cross toothed)', '2635800001', 10, 4, 42),
(6, 'SUV PTO+(LPD/Single Shifting/8 spline/1:1Ratio)', '2634200001', 10, 4, 42),
(6, 'Split Shaft PTO-400 Kg-m cross toothed flange -', '2626400001', 10, 4, 42),
(6, 'SUV+LPD DUALISTIC PTO 1:1 (STD) WITH AUX UNIT', '2625600001', 11, 4, 44),
(6, 'SUV+ LPD Dualistic PTO 1:1 (STD) with Aux Unit-25', '2624900001', 11, 4, 44),
(6, 'H2000-130 LH-Heavy duty split shaft PTO(With Cross whale)', '2627500001', 9, 3, 38),
(6, 'SUV PTO+ Mounting Bracket Assembly Type-2', '2623600001', 8, 3, 36),
(6, 'SUV PTO+ Mounting Bracket', '2625300001', 8, 3, 35),
(6, 'Jet Vac Auxiliary Unit-25 KGM', '2574000001', 9, 3, 38),
(6, 'JetVac PTO Bracket', '2586600001', 10, 4, 40),
(6, 'H400-25/40 Split Shaft PTO', '2627000201', 9, 3, 38),
(6, 'SPLIT SHAFT PTO H 400 (40Kgm-25kgm)', '2622700001', 9, 3, 38),
(6, 'H2000-130 RH/LH-Heavy duty split shaft PTO', '2628500001', 8, 3, 36),
(6, 'HDV 130/110 Single Side Unit (R)', '2598300001', 10, 4, 40);


