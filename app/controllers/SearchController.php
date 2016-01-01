<?php

class SearchController extends BaseController {

    private $showDistance=true;
    private $opSheet=false;

    public function search()
    {
        $inputs = Input::all();
        return View::make('search')->with('inputs', $inputs)->with('results', self::process($inputs));;
    }

    private function process(&$inputs){
        if(empty($inputs['server']) || $inputs['server']==9){
            $inputs['server']=125;
            $inputs['index']='lnk9_today';
        } else if ($inputs['server']==8){
            $inputs['server']=113;
            $inputs['index']='lnk_today';
        }
        // default origin coordinates.
        if($inputs['server']==125){
            // my fort on 9
            $playerX=16413;
            $playerY=16252;
        } else {
            // my fort on 8
            $playerX=16202;
            $playerY=16518;
        }

        if(empty($inputs['size'])){
            $inputs['size']=100;
        }
        if(empty($inputs['min'])){
            $inputs['min']=200;
        }
        if(empty($inputs['max'])){
            $inputs['max']=2000;
        }
        if(empty($inputs['originX'])){
            $inputs['originX']=$playerX;
        }
        if(empty($inputs['originY'])){
            $inputs['originY']=$playerY;
        }
        if(!empty($inputs['no_alliance'])){
            $inputs['missing'][]='allianceID';
        }
        if(!empty($inputs['in_alliance'])){
            $inputs['exists'][]='allianceID';
        }
        if(!empty($inputs['289'])){
            $inputs['must']['points'][]=289;
        }
        $inputs['query']  =  $this->query($inputs);
        $inputs['filter'] = $this->filter($inputs);
        $habitats = $this->habitats($inputs);
        echo "<pre>$habitats";
    }

    private function query(&$inputs){
        $checks = array();
        $query='';
        if(isset($inputs['min']) && !empty($inputs['max'])){
            $checks['range'] = '
                "points": {
                    "gte" : '.$inputs['min'].',
                    "lte" : '.$inputs['max'].'
                }
            ';
        }
        if(!empty($inputs['should'])){
            if(is_array($inputs['should'])){
                foreach($inputs['should'] as $tag=>$values){
                    $qt='';
                    if(is_numeric(current($values))){
                        $qt='"';
                    }
                    foreach($values as $id){
                        $checks['bool']['should'][]='
                        {
                            "term": {
                                "'.$tag.'" : '.$qt.$id.$qt.'
                            }
                        }
                    ';
                    }
                }
            }

        }
        if(!empty($inputs['must'])){
            if(is_array($inputs['must'])){
                foreach($inputs['must'] as $tag=>$values){
                    $qt='';
                    if(is_numeric(current($values))){
                        $qt='"';
                    }
                    foreach($values as $id){
                        $checks['bool']['must'][]='
                        {
                            "term": {
                                "'.$tag.'" : '.$qt.$id.$qt.'
                            }
                        }
                    ';
                    }
                }
            }

        }
        if(!empty($inputs['must_not'])){
            if(is_array($inputs['must_not'])){
                foreach($inputs['must_not'] as $tag=>$values){
                    $qt='';
                    if(is_numeric(current($values))){
                        $qt='"';
                    }
                    foreach($values as $id){
                        $checks['bool']['must_not'][]='
                        {
                            "term": {
                                "'.$tag.'" : '.$qt.$id.$qt.'
                            }
                        }
                    ';
                    }
                }
            }

        }

        $boolParts = array();
        if(!empty($checks['bool']['should'])){
            $boolParts[] = '"should": [ '.implode(',',$checks['bool']['should']).' ]';
        }
        if(!empty($checks['bool']['must'])){
            $boolParts[] = '"must": [ '.implode(',',$checks['bool']['must']).' ]';
        }
        if(!empty($checks['bool']['must_not'])){
            $boolParts[] = '"must_not": [ '.implode(',',$checks['bool']['must_not']).' ]';
        }
        if(!empty($boolParts)){
            $query .= '
            "bool": {
                '.implode(',',$boolParts).'
            }
            ';
        }
        return $query;
    }

    private function filter(&$inputs){
        $query='';
        $checks=array();
        if(!empty($inputs['missing'])){
            if(is_array($inputs['missing'])){
                foreach($inputs['missing'] as $tag){
                    $checks['bool']['must'][]='
                        { "missing" : { "field" : "'.$tag.'" } }
                    ';
                }
            }
        }
        if(!empty($inputs['exists'])){
            if(is_array($inputs['exists'])){
                foreach($inputs['exists'] as $tag){
                    $checks['bool']['must'][]='
                        { "exists" : { "field" : "'.$tag.'" } }
                    ';
                }
            }
        }

        $boolParts = array();
        if(!empty($checks['bool']['should'])){
            $boolParts[] = '"should": [ '.implode(',',$checks['bool']['should']).' ]';
        }
        if(!empty($checks['bool']['must'])){
            $boolParts[] = '"must": [ '.implode(',',$checks['bool']['must']).' ]';
        }
        if(!empty($checks['bool']['must_not'])){
            $boolParts[] = '"must_not": [ '.implode(',',$checks['bool']['must_not']).' ]';
        }
        if(!empty($boolParts)){
            $query .= '
            "filter": {
                "bool": {
                    '.implode(',',$boolParts).'
                }
            },
            ';
        }
        return $query;
    }

    private function habitats(&$inputs){

        return '
curl  -H "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7" \'localhost:9200/'.$inputs['index'].'/habitats/_search?pretty\' -d \'
{
    "from" : 0, "size" : '.$inputs['size'].',
  	"query": {
        "function_score":{
            "query":  {
                '.$inputs['query'].'
            },
            '.$inputs['filter'].'
            "boost_mode": "replace",
            "script_score" : {
                "params" : {
                    "originX" : '.$inputs['originX'].',
			        "originY" : '.$inputs['originY'].'
			    },
			    "script" : "(abs(doc[\"mapX\"].value - originX) + abs(doc[\"mapX\"].value + doc[\"mapY\"].value - originX - originY) + abs(doc[\"mapY\"].value - originY)) / 2"
			}
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
}