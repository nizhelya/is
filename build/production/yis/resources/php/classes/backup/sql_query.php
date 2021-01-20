(SELECT zadol,usluga,mec,god,nachisleno,oplacheno,subsidia,budjet+pbudjet as sbudjet,dolg,data FROM VODA  WHERE address_id=6314 ORDER BY data DESC LIMIT 1 )
 UNION 
(SELECT zadol,usluga,mec,god,nachisleno,oplacheno,subsidia,budjet+pbudjet as sbudjet,dolg,data FROM STOKI  WHERE address_id=6314 ORDER BY data DESC LIMIT 1 )
 UNION
(SELECT zadol,usluga,mec,god,nachisleno,oplacheno,subsidia,budjet+pbudjet as sbudjet,dolg,data FROM OTOPLENIE  WHERE address_id=6314 ORDER BY data DESC LIMIT 1 )
 UNION 
(SELECT zadol,usluga,mec,god,nachisleno,oplacheno,subsidia,budjet+pbudjet as sbudjet,dolg,data FROM PODOGREV  WHERE address_id=6314 ORDER BY data DESC LIMIT 1 )
UNION
(SELECT zadol,usluga,mec,god,nachisleno,oplacheno,subsidia,budjet+pbudjet as sbudjet,dolg,data FROM KVARTPLATA  WHERE address_id=6314 ORDER BY data DESC LIMIT 1 )
 UNION 
(SELECT zadol,usluga,mec,god,nachisleno,oplacheno,subsidia,budjet+pbudjet as sbudjet,dolg,data FROM TBO  WHERE address_id=6314 ORDER BY data DESC LIMIT 1 )

(SELECT 1 as p,zadol,usluga,CONCAT('' ,mec,god) as period,nachisleno,oplacheno,subsidia,budjet+pbudjet as sbudjet,dolg,data FROM VODA  WHERE address_id=6314 ORDER BY data DESC  )
 UNION 
(SELECT 2 as p, zadol,usluga,CONCAT(' ',mec,god) as period,nachisleno,oplacheno,subsidia,budjet+pbudjet as sbudjet,dolg,data FROM STOKI  WHERE address_id=6314 ORDER BY data DESC  )
 UNION
(SELECT 3 as p,zadol,usluga,CONCAT(' ',mec,god) as period,nachisleno,oplacheno,subsidia,budjet+pbudjet as sbudjet,dolg,data FROM OTOPLENIE  WHERE address_id=6314 ORDER BY data DESC )
 UNION 
(SELECT 4 as p,zadol,usluga,CONCAT(' ',mec,god) as period,nachisleno,oplacheno,subsidia,budjet+pbudjet as sbudjet,dolg,data FROM PODOGREV  WHERE address_id=6314 ORDER BY data DESC  )
UNION
(SELECT 5 as p,zadol,usluga,CONCAT(' ',mec,god) as period,nachisleno,oplacheno,subsidia,budjet+pbudjet as sbudjet,dolg,data FROM KVARTPLATA  WHERE address_id=6314 ORDER BY data DESC )
 UNION 
(SELECT 6 as p,zadol,usluga,CONCAT(' ',mec,god) as period,nachisleno,oplacheno,subsidia,budjet+pbudjet as sbudjet,dolg,data FROM TBO  WHERE address_id=6314 ORDER BY data DESC ) 
ORDER BY data DESC ,p 

Начисления за :   Ext.Date.dateFormat(name, 'M j, Y, g:i a') год
