USE AdventureWorks2012;
GO

-- 1
IF OBJECT_ID (N'dbo.MinBirthday', N'FN') IS NOT NULL
    DROP FUNCTION dbo.MinBirthday;
GO
CREATE FUNCTION dbo.MinBirthday (@JobTitle nvarchar(50))
RETURNS date
AS
BEGIN
	DECLARE @BirthDate date;
    SET @BirthDate = (SELECT MIN(BirthDate) FROM [HumanResources].[Employee] WHERE JobTitle = @JobTitle);
    RETURN @BirthDate
END;
GO

-- 2
IF OBJECT_ID (N'dbo.StartEndTime', N'IF') IS NOT NULL
    DROP FUNCTION dbo.StartEndTime;
GO
CREATE FUNCTION dbo.StartEndTime (@Time nvarchar(50))
RETURNS TABLE
AS
RETURN
(
	SELECT Emp.[BusinessEntityID] 
      , [StartTime]
      , [EndTime]
	FROM [HumanResources].[Employee] as Emp
	INNER JOIN [HumanResources].[EmployeeDepartmentHistory] as EmpHist
		ON EmpHist.[BusinessEntityID] = Emp.[BusinessEntityID]
	INNER JOIN [HumanResources].[Shift] as Sh
		ON Sh.[ShiftID] = EmpHist.[ShiftID]
	WHERE Sh.[Name] = @Time
);
GO

SELECT dbo.MinBirthday(N'Design Engineer') AS 'MinBirthday';
SELECT * FROM dbo.StartEndTime(N'Evening');

-- 3
SELECT * FROM [HumanResources].[Shift] Sh
OUTER APPLY dbo.StartEndTime(Sh.[Name]);

SELECT * FROM [HumanResources].[Shift] Sh
CROSS APPLY dbo.StartEndTime(Sh.[Name]);