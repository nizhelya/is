<?php
$API = array(
'QueryForm'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>5
	  )
           
        )
    ),
'QueryAddress'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
	  )
           
        )
    ),
'QueryTekNach'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
	  ),
	      'delPokVodomera'=>array(
                'len'=>1
	  ),
	      'newPokVodomera'=>array(
                'len'=>1
	  )
           
        )
    ),
'QueryPayment'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
	  ),
	      'newOplata'=>array(
                'len'=>1
	  ),
	      'delOplata'=>array(
                'len'=>1
	  ),
	      'getRaspechatka'=>array(
                'len'=>1
	  )
           
       )
    ),
'QueryPaymentMarfin'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
	  ),
	      'newOplata'=>array(
                'len'=>1
	  ),
	      'delOplata'=>array(
                'len'=>1
	  ),
	      'getRaspechatka'=>array(
                'len'=>1
	  )
           
       )
    ),
'QueryReport'=>array(
       'methods'=>array(
            'getResults'=>array(
                'len'=>1
            )          
        )
    ),
'QueryTarifTables'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
            )
        )
    ),
'QueryUserLogin'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
            ),
              'registration'=>array(
                 'len'=> 1
                ),
             'login'=>array(
                 'len'=> 1
                ),
                'checkLogin'=>array(
                 'len'=> 1
                ),
		'checkMyFlat'=>array(
                 'len'=> 3
                ),
		'updateUser'=>array(
                 'len'=> 1
                )

        )
    ),
'QueryMyFlat'=>array(
       'methods'=>array(
            'getResults'=>array(
                'len'=>1
            ),
            'createRecord'=>array(
            	'len'=>1
            ),
            'updateRecords'=>array(
            	'len'=>1
            ),
            'destroyRecord'=>array(
            	'len'=>1
            )
        )
    ),
'QueryVideo'=>array(
       'methods'=>array(
            'getResults'=>array(
                'len'=>1
            ),
            'createRecord'=>array(
            	'len'=>1
            ),
            'updateRecords'=>array(
            	'len'=>1
            ),
            'destroyRecord'=>array(
            	'len'=>1
            )
        )
    ),
'QueryStatistika'=>array(
       'methods'=>array(
            'getResults'=>array(
                'len'=>1
            )        
        )
    ),
'QueryAdminPn'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
            ),             
	    'saveComp'=>array(
                 'len'=> 1
                ),
	    'saveDept'=>array(
                 'len'=> 1
                ),
	    'addDept'=>array(
                 'len'=> 1
                ),
	    'deleteDept'=>array(
                 'len'=> 1
                ),
	    'savePers'=>array(
                 'len'=> 1
                ),
	    'addPers'=>array(
                 'len'=> 1
                ),
	    'deletePers'=>array(
                 'len'=> 1
                ),
	    'saveTel'=>array(
                 'len'=> 1
                ),
	    'addTel'=>array(
                 'len'=> 1
                ),
	    'deleteTel'=>array(
                 'len'=> 1
                )
	
        )
    ),
'QueryNews'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
            )    
        )
    ),
'QueryVodomer'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1	
	  ),
	      'delPokVodomera'=>array(
                'len'=>1
	
	  ),
	      'newPokVodomera'=>array(
                'len'=>1
	  )
           
       )
   ),

'QueryTeplomer'=>array(
        'methods'=>array(
            'getResults'=>array(
                'len'=>1
	  ),
	      'delPokTeplomera'=>array(
                'len'=>1
	  ),
	      'newPokTeplomera'=>array(
                'len'=>1
	  ) 
  )
    ),
);


