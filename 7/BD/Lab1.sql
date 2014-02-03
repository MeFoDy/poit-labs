SELECT [Name], [GroupName]
FROM [AdventureWorks2012].[HumanResources].[Department]
WHERE [GroupName] = 'Research and Development'
ORDER BY [Name] ASC

/****** =============================  ******/
SELECT DISTINCT [Employee].[BusinessEntityID]
	 , [Employee].[JobTitle]
	 , [Shift].[Name]
	 , [Shift].[StartTime]
	 , [Shift].[EndTime]
  FROM [AdventureWorks2012].[HumanResources].[Employee]
  INNER JOIN [AdventureWorks2012].[HumanResources].[EmployeeDepartmentHistory]
	ON [EmployeeDepartmentHistory].[BusinessEntityID] = [Employee].[BusinessEntityID]
  INNER JOIN [AdventureWorks2012].[HumanResources].[Shift]
	ON [Shift].[ShiftID] = [EmployeeDepartmentHistory].[ShiftID]

/*=======================================*/
USE [AdventureWorks2012];
WITH [Employee_CTE] ([BusinessEntityID], [JobTitle], [Name], [StartTime], [EndTime])
AS
(
    SELECT [Employee].[BusinessEntityID]
 		 , [Employee].[JobTitle]
		 , [Shift].[Name]
		 , [Shift].[StartTime]
		 , [Shift].[EndTime]
	FROM [HumanResources].[Employee]
	INNER JOIN [HumanResources].[EmployeeDepartmentHistory]
	  ON [EmployeeDepartmentHistory].[BusinessEntityID] = [Employee].[BusinessEntityID]
	INNER JOIN [HumanResources].[Shift]
	  ON [Shift].[ShiftID] = [EmployeeDepartmentHistory].[ShiftID]
)
SELECT DISTINCT [BusinessEntityID], [JobTitle], [Name], [StartTime], [EndTime]
FROM [Employee_CTE];
GO

/*=======================================*/
DECLARE @Employee_Temp TABLE
(
  [BusinessEntityID] int,
  [JobTitle] nvarchar(50),
  [Name] nvarchar(50),
  [StartTime] time(7),
  [EndTime] time(7)
)

INSERT INTO @Employee_Temp ([BusinessEntityID], [JobTitle], [Name], [StartTime], [EndTime])
	SELECT DISTINCT [Employee].[BusinessEntityID]
 		 , [Employee].[JobTitle]
		 , [Shift].[Name]
		 , [Shift].[StartTime]
		 , [Shift].[EndTime]
	FROM [HumanResources].[Employee]
	INNER JOIN [HumanResources].[EmployeeDepartmentHistory]
	  ON [EmployeeDepartmentHistory].[BusinessEntityID] = [Employee].[BusinessEntityID]
	INNER JOIN [HumanResources].[Shift]
	  ON [Shift].[ShiftID] = [EmployeeDepartmentHistory].[ShiftID]

SELECT * FROM @Employee_Temp

/*=======================================*/
CREATE TABLE #Employee_Temp
(
  [BusinessEntityID] int,
  [JobTitle] nvarchar(50),
  [Name] nvarchar(50),
  [StartTime] time(7),
  [EndTime] time(7)
)

INSERT INTO #Employee_Temp ([BusinessEntityID], [JobTitle], [Name], [StartTime], [EndTime])
	SELECT DISTINCT [Employee].[BusinessEntityID]
 		 , [Employee].[JobTitle]
		 , [Shift].[Name]
		 , [Shift].[StartTime]
		 , [Shift].[EndTime]
	FROM [HumanResources].[Employee]
	INNER JOIN [HumanResources].[EmployeeDepartmentHistory]
	  ON [EmployeeDepartmentHistory].[BusinessEntityID] = [Employee].[BusinessEntityID]
	INNER JOIN [HumanResources].[Shift]
	  ON [Shift].[ShiftID] = [EmployeeDepartmentHistory].[ShiftID]

SELECT * FROM #Employee_Temp

DROP TABLE #Employee_Temp