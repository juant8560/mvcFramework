CREATE TABLE `products` (
    `productId` int(11) NOT NULL AUTO_INCREMENT,
    `productName` varchar(255) NOT NULL,
    `productDescription` text NOT NULL,
    `productPrice` decimal(10,2) NOT NULL,
    `productImgUrl` varchar(255) NOT NULL,
    `productStatus` char(3) NOT NULL,
    PRIMARY KEY (`productId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `sales` (
    `saleId` int(11) NOT NULL AUTO_INCREMENT,
    `productId` int(11) NOT NULL,
    `salePrice` decimal(10,2) NOT NULL,
    `saleStart` datetime NOT NULL,
    `saleEnd` datetime NOT NULL,
    PRIMARY KEY (`saleId`),
    KEY `fk_sales_products_idx` (`productId`),
    CONSTRAINT `fk_sales_products` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `highlights` (
    `highlightId` int(11) NOT NULL AUTO_INCREMENT,
    `productId` int(11) NOT NULL,
    `highlightStart` datetime NOT NULL,
    `highlightEnd` datetime NOT NULL,
    PRIMARY KEY (`highlightId`),
    KEY `fk_highlights_products_idx` (`productId`),
    CONSTRAINT `fk_highlights_products` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;