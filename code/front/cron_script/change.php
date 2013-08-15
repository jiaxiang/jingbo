<?php
class change_jczq {
    
    public static function rqspf($result)
    {
        if (empty($result))
        {
            return FALSE;    
        }
        $arrcode = explode(";" ,$result['codes']);
        $arrcode2 = explode("/" ,$arrcode[0]);
        $result['match_num'] = count($arrcode2);
        $codeto = array();
        foreach($arrcode2 as $row)
        {
            $arrrow = explode("|", $row);
            $select = substr($arrrow[1], 5);
            $select = substr($select,0,strlen($select)-1);
            $codeto[] = substr($arrrow[1], 0, 1).'|'.substr($arrrow[1], 1, 3).'|'.$select;
        }
        
        $result['tocodes'] = implode('|',$codeto);
        
        switch($arrcode[1])
        {
            case '单关':
               $result['typename'] = '01';
               break;
            default:
               $result['typename'] = str_replace('串', 'x', $arrcode[1]);
        }        
        return $result;
    }
    
    
    
    public static function zjqs($result)
    {
        if (empty($result))
        {
            return FALSE;    
        }
        $arrcode = explode(";" ,$result['codes']);
        $arrcode2 = explode("/" ,$arrcode[0]);
        $result['match_num'] = count($arrcode2);
        $codeto = array();
        foreach($arrcode2 as $row)
        {
            $arrrow = explode("|", $row);
            $select = substr($arrrow[1], 5);
            $select = substr($select,0,strlen($select)-1);
            $codeto[] = substr($arrrow[1], 0, 1).'|'.substr($arrrow[1], 1, 3).'|'.$select;
        }
        
        $result['tocodes'] = implode('|',$codeto);
        
        switch($arrcode[1])
        {
            case '单关':
               $result['typename'] = '01';
               break;
            default:
               $result['typename'] = str_replace('串', 'x', $arrcode[1]);
        }        
        return $result;
    }    
    

    public static function bf($result)
    {
        if (empty($result))
        {
            return FALSE;    
        }
        $arrcode = explode(";" ,$result['codes']);
        $arrcode2 = explode("/" ,$arrcode[0]);
        $result['match_num'] = count($arrcode2);
        $codeto = array();
        foreach($arrcode2 as $row)
        {
            $arrrow = explode("|", $row);
            $select = substr($arrrow[1], 5);
            $select = substr($select,0,strlen($select)-1);
            $codeto[] = substr($arrrow[1], 0, 1).'|'.substr($arrrow[1], 1, 3).'|'.$select;
        }
        
        $result['tocodes'] = implode('|',$codeto);
        $result['tocodes'] = str_replace(':', '', $result['tocodes']);
        $result['tocodes'] = str_replace('平其它', '99', $result['tocodes']);
        $result['tocodes'] = str_replace('负其它', '09', $result['tocodes']);
        $result['tocodes'] = str_replace('胜其它', '90', $result['tocodes']);
        
        switch($arrcode[1])
        {
            case '单关':
               $result['typename'] = '01';
               break;
            default:
               $result['typename'] = str_replace('串', 'x', $arrcode[1]);
        }        
        return $result;
    } 

    public static function bqc($result)
    {
        if (empty($result))
        {
            return FALSE;    
        }
        $arrcode = explode(";" ,$result['codes']);
        $arrcode2 = explode("/" ,$arrcode[0]);
        $result['match_num'] = count($arrcode2);
        $codeto = array();
        foreach($arrcode2 as $row)
        {
            $arrrow = explode("|", $row);
            $select = substr($arrrow[1], 5);
            $select = substr($select,0,strlen($select)-1);
            $codeto[] = substr($arrrow[1], 0, 1).'|'.substr($arrrow[1], 1, 3).'|'.$select;
        }
        
        $result['tocodes'] = implode('|',$codeto);
        $result['tocodes'] = str_replace('-', '', $result['tocodes']);
        
        switch($arrcode[1])
        {
            case '单关':
               $result['typename'] = '01';
               break;
            default:
               $result['typename'] = str_replace('串', 'x', $arrcode[1]);
        }        
        return $result;
    }

    

}

$arr['rate'] = 1;
$arr['money'] = 100;
$arr['codes'] = '22922|1002[3-1]/22923|1003[3-0]/22921|1001[3-3];3串1';

print_r(change_jczq::bqc($arr));