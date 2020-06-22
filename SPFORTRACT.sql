USE [census]
GO

/****** Object:  StoredProcedure [dbo].[checkAdjState]    Script Date: 6/21/2020 8:23:17 PM ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO



CREATE OR ALTER       PROCEDURE [dbo].[checkAdjState] @statecode nvarchar(2)
AS
DECLARE  
	@PriStateCode VARCHAR(2), 
	@PriFIPS varchar(max),    
	@AdjState VARCHAR(2),  
	@AdjFIPS varchar(max), 
	 @sqlcmd AS NVARCHAR(MAX),
	@sql AS NVARCHAR(MAX),
	@sqlselect NVARCHAR(MAX),
	@AdjStatetemp VARCHAR(25);


DECLARE cur_tract CURSOR
FOR  
select          PriStateCode,  PriFIPS,       AdjState  ,  AdjFIPS      From  [dbo].[Adjcounty] 
where pristatecode   =@statecode and    AdjState <>  @statecode AND AdjState='sc'
 set  @sqlcmd = 'alter table '+@AdjState+' add MakeValidflag VARCHAR(MAX), ReorientFlag  VARCHAR(MAX);'
	 EXEC sp_executesql @sqlcmd;
	 set @sqlcmd ='update '+@AdjState+' set  MakeValidflag  =1  ,[geography4326] = GEOGRAPHY::STGeomFromWKB( [geography4326].STAsBinary(),4326).MakeValid()'
	 EXEC sp_executesql @sqlcmd;
	 set @sqlcmd = 'update ' +@AdjState+  ' set   ReorientFlag =1, [geography4326] =  [geography4326].ReorientObject()  where [geography4326].EnvelopeAngle() > 90' 
	 EXEC sp_executesql @sqlcmd;

OPEN cur_tract;

FETCH NEXT FROM cur_tract INTO    @PriStateCode,  @PriFIPS,       @AdjState  ,  @AdjFIPS  ;


--print  substring( @AdjFIPS ,3,3) 
	WHILE @@FETCH_STATUS = 0
    BEGIN   

 set @AdjStatetemp = concat(@AdjState,'_tract')
 print @AdjStatetemp


 set @sqlselect =  'INSERT INTO  [dbo].[AdjTract_county_prad_adj1]   ([PriCountyName], [PriStateCode], [PriFIPS], [PriTract],  
[AdjCountyName] , [AdjState],[AdjFIPS],[AdjTract]     )
 select pri.countyfp,    pri.Statefp   ,concat(pri.Statefp,pri.countyfp ),    pri. geoid  ,
          adj.countyfp, adj.Statefp, concat(adj.Statefp ,adj.countyfp) ,   
		  adj. geoid
 from  ga_tract4 pri,     '+@AdjStatetemp+'   adj  
 WHERE   pri.[geography4326].STIntersects(adj.[geography4326]) =1 
and pri.countyfp =  substring(cast('+@PriFIPS+' as varchar),3,3)    and  adj.countyfp =  substring(cast('+@AdjFIPS+' as varchar),3,3)' 
print @sqlselect;
 EXEC sp_executesql @sqlselect


        FETCH NEXT FROM cur_tract INTO    @PriStateCode,  @PriFIPS,       @AdjState  ,  @AdjFIPS  ;
		
-- print substring( @AdjFIPS ,3,3) 
    END;

CLOSE cur_tract;

DEALLOCATE cur_tract
GO


