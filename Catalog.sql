DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Order;

CREATE TABLE Product(ProductNum int not null, ProductAmount int not null, PRIMARY KEY (ProductNum));
CREATE TABLE Order(OrderID int not null auto_increment, WeightBrackets varchar(50) not null, ShipCharge float not null,
  CusName varchar(50) not null, CusEmail varchar(50) not null, CusMail varchar(50), Date varchar(50), ShipStatus varchar(50),
  number int not null, OrderAmount int not null,
  PRIMARY KEY (OrderID),
  FORREIGN KEY (number) REFERENCES parts(number) ON DELETE CASCADE);