--------------------------------------------------------
--  File created - Monday-January-27-2025   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Sequence CUSTOMER_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "KUPIDB"."CUSTOMER_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 15 NOCACHE  NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence KUPI_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "KUPIDB"."KUPI_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 25 NOCACHE  NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence ORDERDETAIL_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "KUPIDB"."ORDERDETAIL_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 21 NOCACHE  NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence ORDERTABLE_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "KUPIDB"."ORDERTABLE_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 25 NOCACHE  NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence STAFF_SEQ
--------------------------------------------------------

   CREATE SEQUENCE  "KUPIDB"."STAFF_SEQ"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 16 NOCACHE  NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Table CUSTOMER
--------------------------------------------------------

  CREATE TABLE "KUPIDB"."CUSTOMER" 
   (	"CUSTID" NUMBER(*,0), 
	"C_USERNAME" VARCHAR2(50 BYTE), 
	"C_PASS" VARCHAR2(50 BYTE), 
	"C_PHONENUM" VARCHAR2(20 BYTE), 
	"C_EMAIL" VARCHAR2(100 BYTE), 
	"C_ADDRESS" VARCHAR2(255 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table DELIVERY
--------------------------------------------------------

  CREATE TABLE "KUPIDB"."DELIVERY" 
   (	"ORDERID" NUMBER(*,0), 
	"D_TIME" DATE, 
	"D_STATUS" VARCHAR2(50 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table KUPI
--------------------------------------------------------

  CREATE TABLE "KUPIDB"."KUPI" 
   (	"KUPIID" NUMBER(*,0), 
	"K_NAME" VARCHAR2(50 BYTE), 
	"K_PRICE" NUMBER(10,2), 
	"K_DESC" VARCHAR2(500 BYTE), 
	"K_IMAGE" BLOB
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" 
 LOB ("K_IMAGE") STORE AS BASICFILE (
  TABLESPACE "SYSTEM" ENABLE STORAGE IN ROW CHUNK 8192 RETENTION 
  NOCACHE LOGGING 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)) ;
--------------------------------------------------------
--  DDL for Table ORDERDETAIL
--------------------------------------------------------

  CREATE TABLE "KUPIDB"."ORDERDETAIL" 
   (	"ORDERDETAILID" NUMBER(*,0), 
	"QUANTITY" NUMBER(*,0), 
	"PRICEPERORDER" NUMBER(10,2), 
	"SUBTOTAL" NUMBER(10,2), 
	"KUPIID" NUMBER(*,0), 
	"ORDERID" NUMBER(*,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table ORDERTABLE
--------------------------------------------------------

  CREATE TABLE "KUPIDB"."ORDERTABLE" 
   (	"ORDERID" NUMBER(*,0), 
	"KUPIMILK" VARCHAR2(50 BYTE), 
	"KUPITYPE" VARCHAR2(50 BYTE), 
	"KUPISIZE" VARCHAR2(50 BYTE), 
	"KUPICREAM" VARCHAR2(50 BYTE), 
	"KUPIBEAN" VARCHAR2(50 BYTE), 
	"KUPIDATE" DATE, 
	"CUSTID" NUMBER(*,0), 
	"STAFFID" NUMBER(*,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table PICKUP
--------------------------------------------------------

  CREATE TABLE "KUPIDB"."PICKUP" 
   (	"ORDERID" NUMBER(*,0), 
	"P_TIME" DATE, 
	"P_STATUS" VARCHAR2(50 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table STAFF
--------------------------------------------------------

  CREATE TABLE "KUPIDB"."STAFF" 
   (	"STAFFID" NUMBER(*,0), 
	"S_USERNAME" VARCHAR2(50 BYTE), 
	"S_PASS" VARCHAR2(50 BYTE), 
	"S_PHONENUM" VARCHAR2(20 BYTE), 
	"S_EMAIL" VARCHAR2(100 BYTE), 
	"S_ROLE" VARCHAR2(255 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
REM INSERTING into KUPIDB.CUSTOMER
SET DEFINE OFF;
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (1,'zahon','123','0179154272','test@gmail.com','test');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (2,'wafi','123','0118765432','wafi@gmail.com','wafi address');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (3,'ashraf','123','0123347675','ashraf@gmail.com','ashraf address');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (4,'haris','123','0112233445','haris@gmail.com','haris address');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (5,'john_doe','password123','0123456789','john@example.com','123 Main St');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (6,'jane_doe','password456','0987654321','jane@example.com','456 Elm St');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (7,'alice','alicepass','0112233445','alice@example.com','789 Oak St');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (8,'bob','bobpass','0223344556','bob@example.com','321 Pine St');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (9,'charlie','charliepass','0334455667','charlie@example.com','654 Cedar St');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (10,'david','davidpass','0445566778','david@example.com','987 Birch St');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (11,'eva','evapass','0556677889','eva@example.com','432 Spruce St');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (12,'frank','frankpass','0667788990','frank@example.com','876 Maple St');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (13,'grace','gracepass','0778899001','grace@example.com','135 Willow St');
Insert into KUPIDB.CUSTOMER (CUSTID,C_USERNAME,C_PASS,C_PHONENUM,C_EMAIL,C_ADDRESS) values (14,'henry','henrypass','0889900112','henry@example.com','246 Fir St');
REM INSERTING into KUPIDB.DELIVERY
SET DEFINE OFF;
Insert into KUPIDB.DELIVERY (ORDERID,D_TIME,D_STATUS) values (13,to_date('26/01/2025','DD/MM/RRRR'),'Completed');
Insert into KUPIDB.DELIVERY (ORDERID,D_TIME,D_STATUS) values (15,to_date('27/01/2025','DD/MM/RRRR'),'On the Way');
Insert into KUPIDB.DELIVERY (ORDERID,D_TIME,D_STATUS) values (11,to_date('26/01/2025','DD/MM/RRRR'),'approved');
Insert into KUPIDB.DELIVERY (ORDERID,D_TIME,D_STATUS) values (12,to_date('26/01/2025','DD/MM/RRRR'),'rejected');
Insert into KUPIDB.DELIVERY (ORDERID,D_TIME,D_STATUS) values (16,to_date('27/01/2025','DD/MM/RRRR'),'Pending');
REM INSERTING into KUPIDB.KUPI
SET DEFINE OFF;
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (1,'Americano',6,'A timeless classic, freshly pulled shots of espresso to create a robust and flavorful black coffee that wakes you up with every sip.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (2,'Cappucino',6.5,'A perfect balance of bold espresso, steamed milk, and creamy foam, topped with a light dusting of cocoa for a luxurious treat.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (3,'Spanish Latte',7,'A rich and smooth blend of espresso with steamed milk and a touch of condensed milk for a perfectly sweet and creamy finish.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (4,'Salted Camy Frappe',8,'A delightful blend of caramel syrup, coffee, milk, and ice, topped with whipped cream and a drizzle of caramel.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (5,'Espresso Frappe',7.5,'A bold and creamy drink made by blending freshly brewed espresso with milk and ice, ideal for those who love strong flavors.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (6,'Salted Caramel Latte',7.5,'A decadent treat made with rich caramel sauce, a hint of sea salt, and smooth espresso, topped with creamy steamed milk.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (7,'Buttercreme Latte',8,'An indulgent latte made with creamy butter and sweet cream, paired with bold espresso for a comforting and unique flavor.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (8,'Coconut Latte',7.5,'A refreshing take on a latte with smooth coconut milk, bold espresso, and a hint of tropical sweetness to feel the day better than yesterday.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (9,'Hazelnut Latte',7,'A perfect balance of espresso and rich hazelnut syrup, blended with steamed milk for a creamy, nutty flavor.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (10,'Matcha Latte',7.5,'A smooth and creamy combination of matcha green tea and steamed milk, offering a refreshing and slightly earthy taste.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (11,'Spanish Latte',7,'A sweet, velvety espresso-based drink with a hint of condensed milk and steamed milk, offering a smooth finish.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (12,'Nesloo',7,'A delicious Malaysian blend of Nescafe and Milo, Neslo offers the perfect balance of bold coffee and sweet chocolate to energize your day.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (22,'Strawberry Frappe',8,'A refreshing and fruity drink made with strawberries, milk, and ice, creating a smooth and indulgent flavor.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (13,'Frappe',8.5,'Premium Japanese Matcha blended with milk and ice, creating a creamy and refreshing drink with a hint of earthy sweetness.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (14,'Genmaicha Latte',7.5,'A comforting latte featuring the unique nutty and toasty flavors of genmaicha tea, perfectly blended with milk.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (15,'Biscoff Frappe',9,'A creamy and indulgent blend of crushed Biscoff cookies, milk, and ice, topped with whipped cream and drizzle of caramel biscoff.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (16,'Chocohazel Frappe',8,'Rich chocolate combined with hazelnut syrup, milk, and ice, creating a dessert-like drink that’s perfect for any chocolate lover.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (17,'Chocookies',7,'A nostalgic blend of milk, ice, and crushed cookies, topped with chocolate whipped cream and cookies for a sweet and crunchy treat.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (18,'Buttercreme Choco',8,'A creamy and indulgent hot chocolate with hints of butter and cream, providing a velvety smooth experience.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (19,'Lemonade',5,'A bright and refreshing drink made with freshly squeezed lemons and sugar to start a fresh day with freshie moods.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (20,'Cheesecream Matcha',9.5,'A unique blend of matcha tea topped with a creamy cheese foam, offering a perfect balance of savory and sweet flavors.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (23,'Yam Milk',7.5,'A comforting drink made from yam, with full cream milk and a touch of sweetness, offering a unique and smooth taste.');
Insert into KUPIDB.KUPI (KUPIID,K_NAME,K_PRICE,K_DESC) values (24,'Coconut Shake',6,'A refreshing blend of creamy coconut milk and ice, topped with a scoop of vanilla ice cream for the ultimate tropical treat.');
REM INSERTING into KUPIDB.ORDERDETAIL
SET DEFINE OFF;
Insert into KUPIDB.ORDERDETAIL (ORDERDETAILID,QUANTITY,PRICEPERORDER,SUBTOTAL,KUPIID,ORDERID) values (9,3,8.25,24.75,2,13);
Insert into KUPIDB.ORDERDETAIL (ORDERDETAILID,QUANTITY,PRICEPERORDER,SUBTOTAL,KUPIID,ORDERID) values (11,1,10.75,10.75,14,15);
Insert into KUPIDB.ORDERDETAIL (ORDERDETAILID,QUANTITY,PRICEPERORDER,SUBTOTAL,KUPIID,ORDERID) values (12,1,9.25,9.25,22,16);
Insert into KUPIDB.ORDERDETAIL (ORDERDETAILID,QUANTITY,PRICEPERORDER,SUBTOTAL,KUPIID,ORDERID) values (13,1,9.75,9.75,7,17);
Insert into KUPIDB.ORDERDETAIL (ORDERDETAILID,QUANTITY,PRICEPERORDER,SUBTOTAL,KUPIID,ORDERID) values (14,2,9,18,13,18);
Insert into KUPIDB.ORDERDETAIL (ORDERDETAILID,QUANTITY,PRICEPERORDER,SUBTOTAL,KUPIID,ORDERID) values (7,2,12,24,7,11);
Insert into KUPIDB.ORDERDETAIL (ORDERDETAILID,QUANTITY,PRICEPERORDER,SUBTOTAL,KUPIID,ORDERID) values (8,2,8.75,17.5,3,12);
Insert into KUPIDB.ORDERDETAIL (ORDERDETAILID,QUANTITY,PRICEPERORDER,SUBTOTAL,KUPIID,ORDERID) values (15,1,9.25,9.25,22,19);
Insert into KUPIDB.ORDERDETAIL (ORDERDETAILID,QUANTITY,PRICEPERORDER,SUBTOTAL,KUPIID,ORDERID) values (20,1,13.25,13.25,6,24);
REM INSERTING into KUPIDB.ORDERTABLE
SET DEFINE OFF;
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (10,'Oat Milk','Genmaicha Latte','Regular','Yes','Bourbon',to_date('26/01/2025','DD/MM/RRRR'),1,null);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (11,'Full Cream Milk','Buttercreme Latte','Large','Yes','Robusta',to_date('26/01/2025','DD/MM/RRRR'),1,null);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (12,'Oat Milk','Spanish Latte','Regular','Yes','Bourbon',to_date('26/02/2025','DD/MM/RRRR'),1,null);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (13,'Oat Milk','Cappuccino','Regular','Yes','Bourbon',to_date('26/02/2025','DD/MM/RRRR'),1,2);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (14,'Coconut Milk','Strawberry Frappe','Large','No','Arabica',to_date('27/01/2025','DD/MM/RRRR'),1,null);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (15,'Oat Milk','Biscoff Frappe','Regular','Yes','Bourbon',to_date('27/01/2025','DD/MM/RRRR'),1,2);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (16,'Oat Milk','Yam Milk','Regular','Yes','Bourbon',to_date('28/03/2025','DD/MM/RRRR'),1,null);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (17,'Oat Milk','Buttercreme Latte','Regular','Yes','Bourbon',to_date('22/03/2025','DD/MM/RRRR'),1,null);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (18,'Full Cream Milk','Genmaicha Latte','Regular','Yes','Bourbon',to_date('18/03/2025','DD/MM/RRRR'),1,2);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (19,'Oat Milk','Yam Milk','Regular','Yes','Bourbon',to_date('28/03/2025','DD/MM/RRRR'),1,null);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (20,'Oat Milk','Cappucino','Large','Yes','Arabica',to_date('14/05/2025','DD/MM/RRRR'),1,null);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (21,'Oat Milk','Cappucino','Large','Yes','Arabica',to_date('23/06/2025','DD/MM/RRRR'),1,null);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (22,'Oat Milk','Cappucino','Large','Yes','Arabica',to_date('24/06/2025','DD/MM/RRRR'),1,null);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (23,'Oat Milk','Cappucino','Large','Yes','Arabica',to_date('25/07/2025','DD/MM/RRRR'),1,null);
Insert into KUPIDB.ORDERTABLE (ORDERID,KUPIMILK,KUPITYPE,KUPISIZE,KUPICREAM,KUPIBEAN,KUPIDATE,CUSTID,STAFFID) values (24,'Oat Milk','Salted Caramel Latte','Large','Yes','Geisha',to_date('27/07/2025','DD/MM/RRRR'),1,null);
REM INSERTING into KUPIDB.PICKUP
SET DEFINE OFF;
Insert into KUPIDB.PICKUP (ORDERID,P_TIME,P_STATUS) values (17,to_date('27/01/2025','DD/MM/RRRR'),'Pending');
Insert into KUPIDB.PICKUP (ORDERID,P_TIME,P_STATUS) values (18,to_date('27/01/2025','DD/MM/RRRR'),'Completed');
Insert into KUPIDB.PICKUP (ORDERID,P_TIME,P_STATUS) values (19,to_date('27/01/2025','DD/MM/RRRR'),'Pending');
Insert into KUPIDB.PICKUP (ORDERID,P_TIME,P_STATUS) values (24,to_date('27/01/2025','DD/MM/RRRR'),'Pending');
REM INSERTING into KUPIDB.STAFF
SET DEFINE OFF;
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (1,'admin','123','123','admin','admin');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (2,'teststaf','123','123','staff@gmail.com','staff');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (3,'rina','123','0129334451','rina@gmail.com','staff');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (4,'zahin','123','0138945843','zahin@gmail.com','staff');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (5,'testing','123','0192345767','testing@gmail.com','staff');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (6,'staff1','staffpass1','0123456789','staff1@example.com','admin');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (7,'staff2','staffpass2','0987654321','staff2@example.com','staff');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (8,'staff3','staffpass3','0112233445','staff3@example.com','staff');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (9,'staff4','staffpass4','0223344556','staff4@example.com','staff');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (10,'staff5','staffpass5','0334455667','staff5@example.com','staff');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (11,'staff6','staffpass6','0445566778','staff6@example.com','staff');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (12,'staff7','staffpass7','0556677889','staff7@example.com','staff');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (13,'staff8','staffpass8','0667788990','staff8@example.com','staff');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (14,'staff9','staffpass9','0778899001','staff9@example.com','staff');
Insert into KUPIDB.STAFF (STAFFID,S_USERNAME,S_PASS,S_PHONENUM,S_EMAIL,S_ROLE) values (15,'staff10','staffpass10','0889900112','staff10@example.com','staff');
--------------------------------------------------------
--  DDL for Trigger CUSTOMER_BEFORE_INSERT
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "KUPIDB"."CUSTOMER_BEFORE_INSERT" 
BEFORE INSERT ON Customer
FOR EACH ROW
BEGIN
    :new.custID := customer_seq.NEXTVAL;
END;

/
ALTER TRIGGER "KUPIDB"."CUSTOMER_BEFORE_INSERT" ENABLE;
--------------------------------------------------------
--  DDL for Trigger KUPI_BEFORE_INSERT
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "KUPIDB"."KUPI_BEFORE_INSERT" 
BEFORE INSERT ON Kupi
FOR EACH ROW
BEGIN
    :new.kupiID := kupi_seq.NEXTVAL;
END;

/
ALTER TRIGGER "KUPIDB"."KUPI_BEFORE_INSERT" ENABLE;
--------------------------------------------------------
--  DDL for Trigger ORDERDETAIL_BEFORE_INSERT
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "KUPIDB"."ORDERDETAIL_BEFORE_INSERT" 
BEFORE INSERT ON Orderdetail
FOR EACH ROW
BEGIN
    :new.orderdetailID := orderdetail_seq.NEXTVAL;
END;

/
ALTER TRIGGER "KUPIDB"."ORDERDETAIL_BEFORE_INSERT" ENABLE;
--------------------------------------------------------
--  DDL for Trigger ORDERTABLE_BEFORE_INSERT
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "KUPIDB"."ORDERTABLE_BEFORE_INSERT" 
BEFORE INSERT ON Ordertable
FOR EACH ROW
BEGIN
    :new.orderID := ordertable_seq.NEXTVAL;
END;

/
ALTER TRIGGER "KUPIDB"."ORDERTABLE_BEFORE_INSERT" ENABLE;
--------------------------------------------------------
--  DDL for Trigger STAFF_BEFORE_INSERT
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "KUPIDB"."STAFF_BEFORE_INSERT" 
BEFORE INSERT ON Staff
FOR EACH ROW
BEGIN
    :new.staffID := staff_seq.NEXTVAL;
END;

/
ALTER TRIGGER "KUPIDB"."STAFF_BEFORE_INSERT" ENABLE;
--------------------------------------------------------
--  Constraints for Table KUPI
--------------------------------------------------------

  ALTER TABLE "KUPIDB"."KUPI" ADD PRIMARY KEY ("KUPIID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
--------------------------------------------------------
--  Constraints for Table ORDERDETAIL
--------------------------------------------------------

  ALTER TABLE "KUPIDB"."ORDERDETAIL" ADD PRIMARY KEY ("ORDERDETAILID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
--------------------------------------------------------
--  Constraints for Table CUSTOMER
--------------------------------------------------------

  ALTER TABLE "KUPIDB"."CUSTOMER" ADD PRIMARY KEY ("CUSTID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
--------------------------------------------------------
--  Constraints for Table DELIVERY
--------------------------------------------------------

  ALTER TABLE "KUPIDB"."DELIVERY" ADD PRIMARY KEY ("ORDERID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
--------------------------------------------------------
--  Constraints for Table STAFF
--------------------------------------------------------

  ALTER TABLE "KUPIDB"."STAFF" ADD PRIMARY KEY ("STAFFID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
--------------------------------------------------------
--  Constraints for Table PICKUP
--------------------------------------------------------

  ALTER TABLE "KUPIDB"."PICKUP" ADD PRIMARY KEY ("ORDERID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
--------------------------------------------------------
--  Constraints for Table ORDERTABLE
--------------------------------------------------------

  ALTER TABLE "KUPIDB"."ORDERTABLE" ADD PRIMARY KEY ("ORDERID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table DELIVERY
--------------------------------------------------------

  ALTER TABLE "KUPIDB"."DELIVERY" ADD CONSTRAINT "FK_DELIVERY_ORDERTABLE" FOREIGN KEY ("ORDERID")
	  REFERENCES "KUPIDB"."ORDERTABLE" ("ORDERID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table ORDERDETAIL
--------------------------------------------------------

  ALTER TABLE "KUPIDB"."ORDERDETAIL" ADD CONSTRAINT "FK_ORDERDETAIL_KUPI" FOREIGN KEY ("KUPIID")
	  REFERENCES "KUPIDB"."KUPI" ("KUPIID") ENABLE;
  ALTER TABLE "KUPIDB"."ORDERDETAIL" ADD CONSTRAINT "FK_ORDERDETAIL_ORDERTABLE" FOREIGN KEY ("ORDERID")
	  REFERENCES "KUPIDB"."ORDERTABLE" ("ORDERID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table ORDERTABLE
--------------------------------------------------------

  ALTER TABLE "KUPIDB"."ORDERTABLE" ADD CONSTRAINT "CUSTID_FK" FOREIGN KEY ("CUSTID")
	  REFERENCES "KUPIDB"."CUSTOMER" ("CUSTID") ENABLE;
  ALTER TABLE "KUPIDB"."ORDERTABLE" ADD CONSTRAINT "FK_ORDER_STAFF" FOREIGN KEY ("STAFFID")
	  REFERENCES "KUPIDB"."STAFF" ("STAFFID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table PICKUP
--------------------------------------------------------

  ALTER TABLE "KUPIDB"."PICKUP" ADD CONSTRAINT "FK_PICKUP_ORDERTABLE" FOREIGN KEY ("ORDERID")
	  REFERENCES "KUPIDB"."ORDERTABLE" ("ORDERID") ENABLE;
