<?php

class SearchController extends BaseController {

    private $showDistance=true;
    private $opSheet=true;
    private $inputs = array();
    private $alliances = array();
    private $players = array();
    private $habitats = array();
    private $origin = array();
    private $playerX = 0;
    private $playerY = 0;

    public function search()
    {
        $this->inputs = Input::all();
        //echo "<pre>";var_dump($this->inputs);exit;

        $this->setup();
        $this->origin();

        //$this->alliances();
        //$this->players();
        $this->habitats();
        $this->origin();

        //echo "<pre>";var_dump($this->origin);exit;
        return View::make('search')
                ->with('inputs', $this->inputs)
                ->with('origin', $this->origin)
                ->with('habitats', $this->habitats)
                ->with('players', $this->players)
                ->with('alliances', $this->alliances);
    }

    private function origin(){
        $json = shell_exec($this->origin_query());
        $this->origin=$this->data($json);
        if(is_array($this->origin)){
            $this->origin = current($this->origin);
        }
    }

    private function habitats(){
        $this->get('habitats');
    }

    private function alliances(){
        $this->get('alliances');
    }

    private function players(){
        $this->get('players');
    }

    private function get($type){
        $this->process($type);
        $this->inputs[$type]['query']  =  $this->query_parts($type);
        $this->inputs[$type]['filter'] = $this->filter($type);


        $json = shell_exec($this->query($type));
        $this->$type=$this->data($json);
    }

    private function data(&$json){
        $decode = json_decode($json);
        $data=array();
        if(!empty($decode->hits->hits)) {
            foreach ($decode->hits->hits as $decode) {
                $data[$decode->_id] = array();
                $data[$decode->_id] = (Array) $decode->_source;
                $data[$decode->_id]['_search_score'] = $decode->_score;
            }
        }
        return $data;
    }

    private function setup(){
        if(empty($this->inputs['ops'])){
            $this->opSheet=false;
        }
        if(empty($this->inputs['distance'])){
            $this->showDistance=false;
        }
        $this->inputs['ops']        = $this->opSheet;
        $this->inputs['distance']   = $this->showDistance;
        if(empty($this->inputs['server']) || $this->inputs['server']==125 || $this->inputs['server']=='US9'){
            $this->inputs['server']=125;
            $this->inputs['index']='lnk9_today';
        } else {
            $this->inputs['server']=113;
            $this->inputs['index']='lnk_today';
        }
        // default origin coordinates.
        if($this->inputs['server']==125){
            // my fort on 9
            $this->playerX=16413;
            $this->playerY=16252;
        } else {
            // my fort on 8
            $this->playerX=16202;
            $this->playerY=16518;
        }
        if(empty($this->inputs['originX'])){
            $this->inputs['originX'] = $this->playerX;
        } else {
            $this->playerX = $this->inputs['originX'];
        }
        if(empty($this->inputs['originY'])){
            $this->inputs['originY'] = $this->playerY;
        } else {
            $this->playerY = $this->inputs['originY'];
        }
    }

    private function origin_query(){
        return '
curl  -H "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7" \'localhost:9200/'.$this->inputs['index'].'/habitats/_search?pretty\' -d \'
{
    "from" : 0, "size" : 1,
    "query": {
        "bool": {
            "must": [
                {
                    "term": {
                        "mapX" : '.$this->playerX.'
                    }
                },
                {
                    "term": {
                        "mapY" : '.$this->playerY.'
                    }
                }
            ]
        }
    }
}\'
';

    }
    private function process($type){
        if(!empty($this->inputs[$type]['min'])){
            $this->inputs[$type]['min']=200;
        }
        if(!empty($this->inputs[$type]['max'])){
            $this->inputs[$type]['max']=2000;
        }
        if(!empty($this->inputs[$type]['points'])){
            if(is_array($this->inputs[$type]['points'])){
                $this->inputs[$type]['must']['points']=$this->inputs[$type]['points'];
            } else {
                $this->inputs[$type]['must']['points']=explode(',',$this->inputs[$type]['points']);
            }
        }
        if($type=='habitats'){
            if(empty($this->inputs[$type]['size'])){
                $this->inputs[$type]['size']=100;
            }
            if(!empty($this->inputs[$type]['in_alliance'])){
                if($this->inputs[$type]['in_alliance'] == 'no'){
                    $this->inputs[$type]['missing'][]='allianceID';
                }
                if($this->inputs[$type]['in_alliance'] == 'yes'){
                    $this->inputs[$type]['exists'][]='allianceID';
                }
            }
        } else {
            if(empty($this->inputs[$type]['size'])){
                $this->inputs[$type]['size']=9999999;
            }
        }
        //echo "<pre>";var_dump($this->inputs[$type]);exit;
    }

    private function query_parts($type="habitats"){
        $checks = array();
        $query='';
        if(isset($this->inputs[$type]['min']) && !empty($this->inputs[$type]['max'])){
            $checks['bool']['must'][] = '
                        {
                            "range": {
                                "points": {
                                    "gte" : '.$this->inputs[$type]['min'].',
                                    "lte" : '.$this->inputs[$type]['max'].'
                                }
                            }
                        }
                    ';
        }
        if(!empty($this->inputs[$type]['should'])){
            if(is_array($this->inputs[$type]['should'])){
                foreach($this->inputs[$type]['should'] as $tag=>$values){
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
        if(!empty($this->inputs[$type]['must'])){
            if(is_array($this->inputs[$type]['must'])){
                foreach($this->inputs[$type]['must'] as $tag=>$values){
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
        if(!empty($this->inputs[$type]['must_not'])){
            if(is_array($this->inputs[$type]['must_not'])){
                foreach($this->inputs[$type]['must_not'] as $tag=>$values){
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

    private function filter($type="habitats"){
        $query='';
        $checks=array();
        if(!empty($this->inputs[$type]['missing'])){
            if(is_array($this->inputs[$type]['missing'])){
                foreach($this->inputs[$type]['missing'] as $tag){
                    $checks['bool']['must'][]='
                        { "missing" : { "field" : "'.$tag.'" } }
                    ';
                }
            }
        }
        if(!empty($this->inputs[$type]['exists'])){
            if(is_array($this->inputs[$type]['exists'])){
                foreach($this->inputs[$type]['exists'] as $tag){
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

    private function query($type){
        if(empty($this->inputs[$type]['query'])){
            $this->inputs[$type]['query'] = '"match_all": {}';
        }
        // distance queries....
        if(!empty($this->inputs['originX'])){
            $query = '
            "query": {
                "function_score":{
                    "query":  {
                        '.$this->inputs[$type]['query'].'
                    },
                    '.$this->inputs[$type]['filter'].'
                    "boost_mode": "replace",
                    "script_score" : {
                        "params" : {
                            "originX" : '.$this->inputs['originX'].',
                            "originY" : '.$this->inputs['originY'].'
                        },
                        "script" : "(abs(doc[\"mapX\"].value - originX) + abs(doc[\"mapX\"].value + doc[\"mapY\"].value - originX - originY) + abs(doc[\"mapY\"].value - originY)) / 2"
                    }
                }
            },
            ';
        } else {
            $query = '
            "query":  {
                '.$this->inputs[$type]['query'].'
            },
            '.$this->inputs[$type]['filter'].'
            ';
        }

        $this->inputs[$type]['query'] = '
curl  -H "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7" \'localhost:9200/'.$this->inputs['index'].'/'.$type.'/_search?pretty\' -d \'
{
    "from" : 0, "size" : '.$this->inputs[$type]['size'].',
    '.$query.'
    "sort" : [
        {
            "_score" : {
                "order": "asc"
            }
        }
    ]
}\'
';
        return $this->inputs[$type]['query'];
    }
}