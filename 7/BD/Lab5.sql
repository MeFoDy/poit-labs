USE AdventureWorks2012;

-- prepare
IF EXISTS 
	( SELECT * FROM INFORMATION_SCHEMA.TABLES
	  WHERE TABLE_NAME = 'PurchaseOrders' )
BEGIN
	DROP TABLE PurchaseOrders
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
	, ModifiedDate datetime NOT NULL
	, Ship_Name varchar(50) NOT NULL
	, ShipBase money NOT NULL
	, ShipRate money NOT NULL
	, JobTitle nvarchar(50) NOT NULL
	, Vendor_Name varchar(50) NOT NULL
)
GO

-- 1
CREATE TRIGGER dbo.PurchasOrderInsert ON dbo.PurchaseOrders
AFTER INSERT
AS
IF EXISTS (SELECT *
           FROM inserted
           WHERE DATEDIFF(DAY, OrderDate, ShipDate) > 9 
          )
BEGIN
	UPDATE PurchaseOrders
	SET PurchaseOrders.ShipRate = PurchaseOrders.ShipRate * 2
	FROM PurchaseOrders
	INNER JOIN inserted
	ON PurchaseOrders.PurchaseOrderID = inserted.PurchaseOrderID
END;
GO

-- 2
CREATE TRIGGER dbo.PurchasOrderUpdate ON dbo.PurchaseOrders
AFTER UPDATE
AS
IF EXISTS (SELECT *
           FROM inserted
           INNER JOIN deleted ON deleted.PurchaseOrderID = inserted.PurchaseOrderID
           WHERE (inserted.ShipBase > deleted.ShipBase * 2)
          )
BEGIN
	UPDATE PurchaseOrders
	SET PurchaseOrders.ShipRate = PurchaseOrders.ShipRate * 2
	FROM PurchaseOrders
	INNER JOIN inserted
	ON PurchaseOrders.PurchaseOrderID = inserted.PurchaseOrderID
END;
GO

-- 3
CREATE TRIGGER dbo.PurchasOrderDelete ON dbo.PurchaseOrders
AFTER DELETE
AS

declare 
	@UpdateDate varchar(21) ,
	@UserName varchar(128) ,
	@deleted int ,
	@ostalos int

BEGIN
	select @UserName = system_user ,
		@UpdateDate = convert(varchar(8), getdate(), 112) + ' ' + convert(varchar(12), getdate(), 114) ,
		@deleted = (SELECT COUNT(*) FROM deleted) ,
		@ostalos = (SELECT COUNT(*) FROM PurchaseOrders);
	PRINT 'Deleted ' + @deleted + ' by ' + @UserName + ' at ' + @UpdateDate + ', there is ' + @ostalos + ' rows now.'
END;
GO

-- 4
CREATE TRIGGER dbo.PurchasOrderAll ON dbo.PurchaseOrders
AFTER INSERT, UPDATE, DELETE
AS
	declare @Type char(1);
	
	if exists (select * from inserted)
		if exists (select * from deleted)
			select @Type = 'U'
		else
			select @Type = 'I'
	else
		select @Type = 'D';
	
	if @Type = 'D' 
		BEGIN
			declare 
				@UpdateDate varchar(21) ,
				@UserName varchar(128) ,
				@deleted int ,
				@ostalos int

			BEGIN
				select @UserName = system_user ,
					@UpdateDate = convert(varchar(8), getdate(), 112) + ' ' + convert(varchar(12), getdate(), 114) ,
					@deleted = (SELECT COUNT(*) FROM deleted) ,
					@ostalos = (SELECT COUNT(*) FROM PurchaseOrders);
				PRINT 'Deleted ' + @deleted + ' by ' + @UserName + ' at ' + @UpdateDate + ', there is ' + @ostalos + ' rows now.'
			END;
		END;
	
	if @Type = 'U'
		BEGIN
			IF EXISTS (SELECT *
					   FROM inserted
					   INNER JOIN deleted ON deleted.PurchaseOrderID = inserted.PurchaseOrderID
					   WHERE (inserted.ShipBase > deleted.ShipBase * 2)
					  )
			BEGIN
				UPDATE PurchaseOrders
				SET PurchaseOrders.ShipRate = PurchaseOrders.ShipRate * 2
				FROM PurchaseOrders
				INNER JOIN inserted
				ON PurchaseOrders.PurchaseOrderID = inserted.PurchaseOrderID
			END;
		END;
		
	if @Type = 'I'
		BEGIN
			IF EXISTS (SELECT *
					   FROM inserted
					   WHERE DATEDIFF(DAY, OrderDate, ShipDate) > 9 
					  )
			BEGIN
				UPDATE PurchaseOrders
				SET PurchaseOrders.ShipRate = PurchaseOrders.ShipRate * 2
				FROM PurchaseOrders
				INNER JOIN inserted
				ON PurchaseOrders.PurchaseOrderID = inserted.PurchaseOrderID
			END;					
		END;
GO
