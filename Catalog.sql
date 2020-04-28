DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Order;

CREATE TABLE Product(ProductNum int not null auto_increment, number int not null, ProductLoc varchar(50) not null, ProductAmount int not null,
  PRIMARY KEY (ProductNum));
CREATE TABLE Orders(OrderID int not null auto_increment, WeightBrackets varchar(50) not null, ShipCharge float not null,
  CusName varchar(50) not null, CusEmail varchar(50) not null, CusMail varchar(50), Date varchar(50) not null,
  ShipStatus varchar(50) not null, ProductNum int not null, number int not null, OrderAmount int not null,
  PRIMARY KEY (OrderID),
  FOREIGN KEY (ProductNum) REFERENCES Product(ProductNum) ON DELETE CASCADE);

INSERT INTO Product VALUES (11, 12, 'A-1-1', 13);

INSERT INTO Orders VALUES (101, 'Heavy', 102.33, 'Aaron', 'aaron@mail.com', ' ', '04/27/2020', 'New Order', '11', '103', 104);              
