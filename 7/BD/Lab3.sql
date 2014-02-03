use [AdventureWorks2012] 

update TargetA
set TargetA.VacationHours = SourceA.VacationHours
from [dbo].[Employee] TargetA
join [HumanResources].[Employee] SourceA on SourceA.BusinessEntityID = TargetA.BusinessEntityID
go

if COL_LENGTH('[dbo].[Employee]', 'EmpName') IS NULL
begin
	alter table [dbo].[Employee]
	add [EmpName] [varchar](100) NULL DEFAULT ''
end
go

update TargetA
set TargetA.[EmpName] = (SourceA.FirstName + ' ' + SourceA.LastName)
from [dbo].[Employee] TargetA
join [Person].[Person] SourceA on SourceA.BusinessEntityID = TargetA.BusinessEntityID
go

delete 
from [dbo].[Employee] 
where [BusinessEntityID] in (SELECT DISTINCT BusinessEntityID 
								from [Person].[Person] 
								where [EmailPromotion] = 0)
go

/* ==================================== */
DECLARE @database nvarchar(50)
DECLARE @table nvarchar(50)

set @database = '[AdventureWorks2012]'
set @table = '[dbo].[Employee]'

DECLARE @sql nvarchar(255)
WHILE EXISTS(select * from INFORMATION_SCHEMA.TABLE_CONSTRAINTS
				where CONSTRAINT_CATALOG = @database
				and TABLE_NAME = @table)
BEGIN
	select @sql = 'ALTER TABLE ' + @table + ' DROP CONSTRAINT ' + CONSTRAINT_NAME
	from INFORMATION_SCHEMA.TABLE_CONSTRAINTS
	where CONSTRAINT_CATALOG = @database 
	and TABLE_NAME = @table
	
	exec sp_executesql @sql
END

/* ======================= */
set @sql = ''
select @sql = @sql + 'ALTER TABLE [dbo].[Employee] DROP CONSTRAINT ' + name + ';'
from sys.default_constraints
where parent_object_id = object_id('[dbo].[Employee]')
and type = 'D'

exec sp_executesql @sql
go

/* ====================== */
if COL_LENGTH('[dbo].[Employee]', 'EmpName') IS NOT NULL
begin
	alter table [dbo].[Employee]
	drop column [EmpName]
end

go

if OBJECT_ID('dbo.Employee', 'U') IS NOT NULL
	drop table dbo.Employee