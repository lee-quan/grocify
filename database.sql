CREATE TABLE `grocery`.`user` (
    `custid` INT(255) NOT NULL AUTO_INCREMENT,
    `firstname` VARCHAR(255) NOT NULL,
    `lastname` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `status` INT(1) NOT NULL DEFAULT '0',
    `registerat` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `token` VARCHAR(255) NOT NULL,
    `dateofbirth` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `gender` VARCHAR(255) NOT NULL DEFAULT '-',
    PRIMARY KEY (`custid`)
) AUTO_INCREMENT = 1001 ENGINE = InnoDB;

CREATE TABLE `grocery`.`paymentmethod` (
    `paymentid` VARCHAR(255) NOT NULL,
    `custid` INT(255) NOT NULL,
    `nameoncard` VARCHAR(255) NOT NULL,
    `cardnumber` VARCHAR(255) NOT NULL,
    `expirydate` VARCHAR(255) NOT NULL,
    `cvv` INT(4) NOT NULL,
    `defaultcard` INT(1) NOT NULL DEFAULT '0'
) ENGINE = InnoDB;
ALTER TABLE `paymentmethod`
ADD CONSTRAINT `custid` FOREIGN KEY (`custid`) REFERENCES `user`(`custid`);
ALTER TABLE `paymentmethod`
ADD PRIMARY KEY(`paymentid`);

CREATE TABLE `grocery`.`address` (
    `addressid` VARCHAR(255) NOT NULL,
    `custid` INT(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `zip` VARCHAR(255) NOT NULL,
    `country` VARCHAR(255) NOT NULL,
    `tel` VARCHAR(255) NOT NULL,
    `defaultaddress` INT(1) NOT NULL DEFAULT '0'
) ENGINE = InnoDB;
ALTER TABLE `address`
ADD CONSTRAINT `custid1` FOREIGN KEY (`custid`) REFERENCES `user`(`custid`);
ALTER TABLE `address`
ADD PRIMARY KEY(`addressid`);


CREATE TABLE `grocery`.`brand` (
    `brandid` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `brand` VARCHAR(255) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `grocery`.`category` (
    `catid` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `parentcatid` INT NULL,
    `cat` VARCHAR(255) NOT NULL
) AUTO_INCREMENT=1 ENGINE = InnoDB;
ALTER TABLE `category`
ADD CONSTRAINT `parentcatid` FOREIGN KEY (`parentcatid`) REFERENCES `category`(`catid`);

CREATE TABLE `grocery`.`product` (
    `pid` INT(255) NOT NULL AUTO_INCREMENT,
    `pname` VARCHAR(255) NOT NULL,
    `pbrandid` INT(255) NOT NULL,
    `pcatid` INT(255) NOT NULL,
    `pdescription` VARCHAR(255) NOT NULL,
    `pquantity` INT(255) NOT NULL,
    `pprice` FLOAT NOT NULL,
    `pkeywords` VARCHAR(255) NOT NULL,
    `picture` VARCHAR(255) NOT NULL,
    `dateadded` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`pid`)
) AUTO_INCREMENT = 1000001 ENGINE = InnoDB;
ALTER TABLE `product`
ADD CONSTRAINT `fk_pcatid` FOREIGN KEY (`pcatid`) REFERENCES `category`(`catid`);
ALTER TABLE `product`
ADD CONSTRAINT `fk_pbrandid` FOREIGN KEY (`pbrandid`) REFERENCES `brand`(`brandid`);


CREATE TABLE `grocery`.`admin` (
    `id` INT(255) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `status` INT(1) NOT NULL DEFAULT '0',
    `registerat` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) AUTO_INCREMENT = 10001 ENGINE = InnoDB;

CREATE TABLE `grocery`.`rating` (
    `pid` INT(255) NOT NULL,
    `custid` INT(255) NOT NULL,
    `message` TEXT NULL,
    `rate` INT(1) NOT NULL,
    `rateat` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

ALTER TABLE `rating`
ADD CONSTRAINT `fk_pid` FOREIGN KEY (`pid`) REFERENCES `product`(`pid`);
ALTER TABLE `rating`
ADD CONSTRAINT `fk_custid` FOREIGN KEY (`custid`) REFERENCES `user`(`custid`);

CREATE TABLE `grocery`.`cart` (
    `cartid` VARCHAR(255) NOT NULL PRIMARY KEY,
    `custid` INT(255) NOT NULL,
    `pid`   INT(255) NOT NULL,
    `quantity` INT(255) NOT NULL,
    `timeadded` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

ALTER TABLE `cart`
ADD CONSTRAINT `fkpid` FOREIGN KEY (`custid`) REFERENCES `user`(`custid`);
ALTER TABLE `cart`
ADD CONSTRAINT `fkcustid` FOREIGN KEY (`pid`) REFERENCES `product`(`pid`);

CREATE TABLE `grocery`.`orderstatus` (
    `orderstatusid` INT(1) NOT NULL PRIMARY KEY,
    `orderstatus` VARCHAR(255) NOT NULL
) ENGINE = InnoDB;
INSERT INTO orderstatus (orderstatusid, orderstatus) VALUES (0, "Pending");

CREATE TABLE `grocery`.`shippingmethod` (
    `shippingid` INT(1) NOT NULL PRIMARY KEY,
    `shippingmethod` VARCHAR(255) NOT NULL
) ENGINE = InnoDB;
INSERT INTO shippingmethod (shippingid, shippingmethod) VALUES (0, 'Standard Delivery (7 Days)');
INSERT INTO shippingmethod (shippingid, shippingmethod) VALUES (1, 'Economy Delivery (20 Days)');

CREATE TABLE `grocery`.`order` (
    `orderid` VARCHAR(255) NOT NULL PRIMARY KEY,
    `custid` INT(255) NOT NULL,
    `adminid` INT(255) NULL,
    `ordertime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `requiredtime` DATE NOT NULL,
    `shippeddate` DATE NULL,
    `cost` FLOAT NOT NULL,
    `addressid` VARCHAR(255) NOT NULL,
    `paymentid` VARCHAR(255) NOT NULL,
    `orderstatus` INT(1) NOT NULL DEFAULT '0',
    `shippingmethod` INT(1) NOT NULL
) ENGINE = InnoDB;
ALTER TABLE `order`
ADD CONSTRAINT `fkey_custid` FOREIGN KEY (`custid`) REFERENCES `user`(`custid`);
ALTER TABLE `order`
ADD CONSTRAINT `fkey_adminid` FOREIGN KEY (`adminid`) REFERENCES `admin`(`id`);
ALTER TABLE `order`
ADD CONSTRAINT `fkey_orderstatus` FOREIGN KEY (`orderstatus`) REFERENCES `orderstatus`(`orderstatusid`);
ALTER TABLE `order`
ADD CONSTRAINT `fkey_shippingmethod` FOREIGN KEY (`shippingmethod`) REFERENCES `shippingmethod`(`shippingid`);

CREATE TABLE `grocery`.`orderdetails` (
    `orderid` VARCHAR(255) NOT NULL,
    `custid` INT(255) NOT NULL,
    `pid` INT(255) NOT NULL,
    `quantity` INT(255) NOT NULL
) ENGINE = InnoDB;

ALTER TABLE `orderdetails`
ADD CONSTRAINT `fkorderid_` FOREIGN KEY (`custid`) REFERENCES `user`(`custid`);

CREATE TABLE `grocery`.`shoppinglist` (
    `shoppinglistid` VARCHAR(255) NOT NULL PRIMARY KEY,
    `custid` INT(255) NOT NULL,
    `shoppinglist` VARCHAR(255) NOT NULL,
    `timecreated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

ALTER TABLE `shoppinglist`
ADD CONSTRAINT `fkslcustid` FOREIGN KEY (`custid`) REFERENCES `user`(`custid`);

CREATE TABLE `grocery`.`shoppinglistdetails` (
    `sdetailsid` VARCHAR(255) NOT NULL PRIMARY KEY,
    `shoppinglistid` VARCHAR(255) NOT NULL,
    `pid` INT(255) NOT NULL,
    `quantity` VARCHAR(255) NOT NULL,
    `timeadded` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

ALTER TABLE `shoppinglistdetails`
ADD CONSTRAINT `fksl_pid` FOREIGN KEY (`pid`) REFERENCES `product`(`pid`);
ALTER TABLE `shoppinglistdetails`
ADD CONSTRAINT `fksl_id` FOREIGN KEY (`shoppinglistid`) REFERENCES `shoppinglist`(`shoppinglistid`);
ALTER TABLE `address` ADD `timeadded` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `defaultaddress`;
ALTER TABLE `paymentmethod` ADD `timeadded` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `defaultcard`;

CREATE TABLE `grocery`.`feedback` (
    `feedbackid` VARCHAR(255) NOT NULL PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` INT(255) NOT NULL,
    `feeling` INT(255) NOT NULL,
    `message` TEXT NOT NULL,
    `timeadded` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

ALTER TABLE `feedback` ADD `phone` VARCHAR(255) NOT NULL AFTER `timeadded`;
ALTER TABLE `user` ADD `resetpassword` VARCHAR(255) NULL DEFAULT NULL AFTER `gender`;