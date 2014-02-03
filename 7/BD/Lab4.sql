USE AdventureWorks2012;

-- prepare
IF EXISTS 
	( SELECT * FROM INFORMATION_SCHEMA.TABLES
	  WHERE TABLE_NAME = 'PurchaseOrders' )
BEGIN
	DROP TABLE PurchaseOrders
	DROP VIEW vw_PurchaseOrders
END
GO

-- A
CREATE TABLE PurchaseOrders (
	  PurchaseOrderID int NOT NULL
	, RevisionNumber tinyint NOT NULL
	, Status tinyint NOT NULL
	, EmployeeID int NOT NULL
	, VendorID int NOT NULL
	, ShipMethodID int NOT NULL
	, OrderDate datetime NOT NULL
	, ShipDate datetime NOT NULL
	, SubTotal money NOT NULL
	, TaxAmt money NOT NULL
	, Freight money NOT NULL
	, TotalDue AS (isnull(([SubTotal]+[TaxAmt])+[Freight],(0)))
	, ModifiedDate datetime NOT NULL
	, Ship_Name varchar(50) NOT NULL
	, ShipBase money NOT NULL
	, ShipRate money NOT NULL
	, JobTitle nvarchar(50) NOT NULL
	, Vendor_Name varchar(50) NOT NULL
)
GO

-- B
ALTER TABLE PurchaseOrders
ADD ShipDays AS (DATEDIFF(DAY, OrderDate, ShipDate))
GO

-- C
ALTER TABLE PurchaseOrders
ADD primary key (PurchaseOrderID)
GO

-- D
CREATE VIEW vw_PurchaseOrders AS
	( SELECT * FROM PurchaseOrders )
GO

-- E
---- valid
INSERT INTO vw_PurchaseOrders
(
	PurchaseOrderID
	, RevisionNumber
	, Status
	, EmployeeID
	, VendorID
	, ShipMethodID
	, OrderDate
	, ShipDate
	, SubTotal
	, TaxAmt
	, Freight
	, ModifiedDate
	, Ship_Name
	, ShipBase
	, ShipRate
	, JobTitle
	, Vendor_Name
) VALUES (
	-- PurchaseOrderID	RevisionNumber	Status	EmployeeID	VendorID	ShipMethodID	OrderDate	ShipDate	SubTotal	TaxAmt	Freight	TotalDue	ModifiedDate	 ShipBase	ShipRate	JobTitle
	1, 0, 4, 258, 1580, 3, '2001-05-17 00:00:00.000', '2001-05-26 00:00:00.000', 201.04, 16.0832, 5.026, '2001-05-26 00:00:00.000', 'OVERSEAS - DELUXE', 29.95, 2.99, 'Buyer', 'Litware, Inc.'
)
GO

-- invalid
INSERT INTO vw_PurchaseOrders
(
	PurchaseOrderID
	, RevisionNumber
	, Status
	, EmployeeID
	, VendorID
	, ShipMethodID
	, OrderDate
	, ShipDate
	, SubTotal
	, TaxAmt
	, Freight
	, ModifiedDate
	, Ship_Name
	, ShipBase
	, ShipRate
	, JobTitle
	, Vendor_Name
) VALUES (
	-- PurchaseOrderID	RevisionNumber	Status	EmployeeID	VendorID	ShipMethodID	OrderDate	ShipDate	SubTotal	TaxAmt	Freight	TotalDue	ModifiedDate	 ShipBase	ShipRate	JobTitle
	9999, 15, 17, 19, 12, 9, '2001-05-17 01:00:00.000', '2001-05-26 01:00:00.000', 200.04, 15.0832, 4.026, '2001-05-26 01:00:00.000', 'OVERSEASSSS - DELUXE', 28.95, 1.99, 'SBuyer', 'Qitware, Inc.'
)
GO

INSERT INTO vw_PurchaseOrders
(
	PurchaseOrderID
	, RevisionNumber
	, Status
	, EmployeeID
	, VendorID
	, ShipMethodID
	, OrderDate
	, ShipDate
	, SubTotal
	, TaxAmt
	, Freight
	, ModifiedDate
	, Ship_Name
	, ShipBase
	, ShipRate
	, JobTitle
	, Vendor_Name
) VALUES (
	-- PurchaseOrderID	RevisionNumber	Status	EmployeeID	VendorID	ShipMethodID	OrderDate	ShipDate	SubTotal	TaxAmt	Freight	TotalDue	ModifiedDate	 ShipBase	ShipRate	JobTitle
	2, 0, 1, 254, 1496, 5, '2001-05-17 01:00:00.000', '2001-05-26 00:00:00.000', 272.1015, 21.7681, 6.8025, '2001-05-26 00:00:00.000', 'OVERSEAS - DELUXE', 29.95, 2.99, 'Buyer', 'Litware, Inc.'
)
GO

-- F
SELECT * FROM vw_PurchaseOrders;

WITH [PurchaseOrders] (
	PurchaseOrderID
	, RevisionNumber
	, Status
	, EmployeeID
	, VendorID
	, ShipMethodID
	, OrderDate
	, ShipDate
	, SubTotal
	, TaxAmt
	, Freight
	, ModifiedDate
	, Ship_Name
	, ShipBase
	, ShipRate
	, JobTitle
	, Vendor_Name
) AS ( SELECT PurchaseOrderID
		, RevisionNumber
		, Status
		, EmployeeID
		, VendorID
		, sm.ShipMethodID
		, OrderDate
		, ShipDate
		, SubTotal
		, TaxAmt
		, Freight
		, poh.ModifiedDate
		, sm.Name as Ship_Name
		, ShipBase
		, ShipRate
		, JobTitle
		, v.Name as Vendor_Name
	FROM [Purchasing].PurchaseOrderHeader as poh
	JOIN [Purchasing].ShipMethod as sm
		ON sm.ShipMethodID = poh.ShipMethodID
	JOIN [Purchasing].Vendor as v
		ON v.BusinessEntityID = poh.VendorID
	JOIN [HumanResources].Employee as e
		ON e.BusinessEntityID = poh.EmployeeID
	WHERE e.JobTitle != 'Buyer'
) MERGE vw_PurchaseOrders AS target
USING [PurchaseOrders] AS source
ON (target.PurchaseOrderID = source.PurchaseOrderID)
WHEN MATCHED AND target.ShipDays > 25
	THEN UPDATE
	SET
		target.RevisionNumber = source.RevisionNumber
		, target.Status = source.Status
		, target.EmployeeID = source.EmployeeID
		, target.VendorID = source.VendorID
		, target.ShipMethodID = source.ShipMethodID
		, target.OrderDate = source.OrderDate
		, target.ShipDate = source.ShipDate
		, target.SubTotal = source.SubTotal
		, target.TaxAmt = source.TaxAmt
		, target.Freight = source.Freight
		, target.ModifiedDate = source.ModifiedDate
		, target.Ship_Name = source.Ship_Name
		, target.ShipBase = source.ShipBase
		, target.ShipRate = source.ShipRate
		, target.JobTitle = source.JobTitle
		, target.Vendor_Name = source.Vendor_Name
WHEN NOT MATCHED BY source
	THEN DELETE
WHEN NOT MATCHED BY target
	THEN INSERT (
		PurchaseOrderID
		, RevisionNumber
		, Status
		, EmployeeID
		, VendorID
		, ShipMethodID
		, OrderDate
		, ShipDate
		, SubTotal
		, TaxAmt
		, Freight
		, ModifiedDate
		, Ship_Name
		, ShipBase
		, ShipRate
		, JobTitle
		, Vendor_Name
	) VALUES (
		source.PurchaseOrderID
		, source.RevisionNumber
		, source.Status
		, source.EmployeeID
		, source.VendorID
		, source.ShipMethodID
		, source.OrderDate
		, source.ShipDate
		, source.SubTotal
		, source.TaxAmt
		, source.Freight
		, source.ModifiedDate
		, source.Ship_Name
		, source.ShipBase
		, source.ShipRate
		, source.JobTitle
		, source.Vendor_Name
	);
	
SELECT * FROM vw_PurchaseOrders;