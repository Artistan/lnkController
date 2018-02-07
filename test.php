<?php

$target = 'me 8';
//$filter_set = '9knights';
$only289 = false;
//$server = 8; use targets and filters.
$origin = 'fort'; // fort, cable guy, alliance agreement 9, widow, bella
$results=100;
$showDistance=true;
$opSheet=true;


if($only289){
    $additional_match = ',
                    {
                        "match": {
                            "points": 289
                        }
                    }';
}


switch($filter_set){
    case '9war':
        /// ancient kings 1422
        /// berzerkers1 8704
        /// vikings 1387
        /// killing spree 9325
        /// berz 8754
        /// berz 7942
        $server = 9;
        $filtered = '
          "should": [
            {
              "term": {
                "allianceID": 1422
              }
            },
            {
              "term": {
                "allianceID": 8704
              }
            },
            {
              "term": {
                "allianceID": 1387
              }
            },
            {
              "term": {
                "allianceID": 9325
              }
            },
            {
              "term": {
                "allianceID": 8754
              }
            },
            {
              "term": {
                "allianceID": 7942
              }
            }
          ]';

    case '9knights':
        // Rogue 42345
        // Knights revel  35195
        // Dr.Snott 37682
        // EL Caragenes 53496
        $server = 9;
        $filtered = '
          "should": [
            {
              "term": {
                "playerID": 42345
              }
            },
            {
              "term": {
                "playerID": 35195
              }
            },
            {
              "term": {
                "playerID": 37682
              }
            },
            {
              "term": {
                "playerID": 53496
              }
            }
          ]';


}

switch($target){
    case 'loves82':
        $server = 8;
        $targetValue=6996;// 8
        $targetField='playerID';
        break;
    case 'slimnation':
        $server = 9;
        $targetValue=42662;// 9
        $targetField='playerID';
        break;
    case 'gorzel':
        $server = 9;
        $targetValue=25495;// 9
        $targetField='playerID';
        break;
    case 'strongrule':
        $server = 8;
        $targetValue=443;// 8
        $targetField='playerID';
        break;
    case 'ak9':
        $server = 9;
        $targetValue=1422;// ancient kings 9
        $targetField='allianceID';
        break;
    case 'vikings 9':
        $server = 9;
        $targetValue=8704;// vikings 9
        $targetField='allianceID';
        break;
    case 'HOJ8':
        $server = 8;
        $targetValue=9867;// hall of justice 8
        $targetField='allianceID';
        break;
    case 'elite crusaders 8':
        $server = 8;
        $targetValue=44470;// elite crusaders alliance on 8
        $targetField='playerID';
        break;
    case 'me 8':
        $server = 8;
        $targetValue=53570; // my playerID on 8
        $targetField='playerID';
        break;
    case 'darkknights9':
        $server = 9;
        $targetValue=9288; // dark knights on 9
        $targetField='allianceID';
        break;

}

$date = 'today';
if($server==9){
    $index='lnk9_'.$date;
    $worldID=125;
    if($origin=='fort'){
        // my fort
        $playerX=16413;
        $playerY=16252;
    }
} else {
    $index='lnk_'.$date;
    $worldID=113;
    if($origin=='fort'){
        // my fort
        $playerX=16202;
        $playerY=16518;
    }
}
if($origin=='alliance agreement 9') {
    $playerX=16280;
    $playerY=16455;
}
if($origin=='cable guy'){
    //// cable guy
    $playerX=16419;
    $playerY=16269;
}
if($origin=='widow'){
    $playerX=16543;
    $playerY=16410;
}
if($origin=='bella'){//9
    $playerX=16245;
    $playerY=16294;
}

if(!empty($targetField) && !empty($targetValue)){

    $curl = '
curl  -H "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7" \'localhost:9200/'.$index.'/habitats/_search?pretty\' -d \'
{
    "from" : 0, "size" : '.$results.',
    "query" : {
        "function_score":{
            "query":  {
                "bool": {
                    "must": [
                        {
                            "match": {
                                "'.$targetField.'": '.$targetValue.'
                            }
                        }
                        '.(!empty($additional_match)?$additional_match:'').'
                    ]
    		}
            },
            "boost_mode": "replace",
            "script_score" : {
                "params" : {
                    "originX" : '.$playerX.',
			        "originY" : '.$playerY.'
			    },
			    "script" : "(abs(doc[\"mapX\"].value - originX) + abs(doc[\"mapX\"].value + doc[\"mapY\"].value - originX - originY) + abs(doc[\"mapY\"].value - originY)) / 2"
			}
		}
    },
    '.(!empty($filtered)?'"filter":{"bool":{'.$filtered.'}},':'').'
    "sort" : [
        {
            "_score" : {
            "order": "asc"
            }
        }
    ]
}\'
';
} else {

    $curl = '
curl  -H "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7" \'localhost:9200/'.$index.'/habitats/_search?pretty\' -d \'
{
    "from" : 0, "size" : '.$results.',
  	"query": {
        "function_score":{
            "query":  {
                "range": {
                    "points": {
                        "gte" : 250,
                        "lte" : 1000
                    }
                }
            },
            "boost_mode": "replace",
            "script_score" : {
                "params" : {
                    "originX" : '.$playerX.',
			        "originY" : '.$playerY.'
			    },
			    "script" : "(abs(doc[\"mapX\"].value - originX) + abs(doc[\"mapX\"].value + doc[\"mapY\"].value - originX - originY) + abs(doc[\"mapY\"].value - originY)) / 2"
			}
		}
  	},
	"filter": {
        "bool" : {
		'.(!empty($filtered)?''.$filtered:'
		            	"must" : [
                			{ "missing" : { "field" : "allianceID" } }
            			]
			').'
         }
	},
    "sort" : [
        {
            "_score" : {
            "order": "asc"
            }
        }
    ]
}\'
';

}



//echo $curl."\n\n";
$json = shell_exec($curl);
//
$decode = json_decode($json);
if(!empty($decode->hits->hits)){
    foreach($decode->hits->hits as $habitat){
        $s = $habitat->_source;
        if(empty($s->name)){
            $name = 'Free Castle # N/A #';
        } else {
            $name = $s->name;
        }
        if($opSheet==='html'){
            echo "
[{$s->points} points]: {$name}<br/>
<a href='l+k://coordinates?{$s->mapX},{$s->mapY}&{$worldID}'>
    l+k://coordinates?{$s->mapX},{$s->mapY}&{$worldID}
</a><br/>
";
            if($showDistance){
                echo "  Distance:{$habitat->_score}<br/>";
            }
            echo '<br/>';
        } else if($opSheet){
            echo "
[{$s->points} points]: {$name}
l+k://coordinates?{$s->mapX},{$s->mapY}&{$worldID}
$ 💰:
+ 💣:
";

        } else {
            echo "{$name} [{$s->points}] l+k://coordinates?{$s->mapX},{$s->mapY}&{$worldID}";
            if($showDistance){
                echo "  Distance:{$habitat->_score} ";
            }
        }
        echo "\n";
    }
} else {
    var_dump(json_decode($json));
}

