<?php
/**
 * Created by PhpStorm.
 * User: jiahua.liu
 * Date: 5/28/19
 * Time: 11:09 AM
 */

class HotUpdater{

    private $rawContent;

    /* @var String*/
    private $builtContent;


    /* @var String*/
    private $filePath;

    /* @var String*/
    private $fileContent;



    public function __construct($file)
    {
        $this->filePath = $file;
        $this->fileContent = file_get_contents($file);
    }




    public function replaceGlobalVariable($variableName, $newContent){
        $this->rawContent = $newContent;
        $start = strstr($variableName,"$")?$variableName:"$".$variableName;
        $end = ";";
        $var = $this->findReplace($start,$end);
        if(!$var)return false;
        $this->builtContent = $this->buildContent();
        $this->fileContent = str_replace($var," = " . $this->builtContent ,$this->fileContent);
        return true;
    }


    public function replaceConstant($constantName, $newContent){
        $this->rawContent = $newContent;
        $start = "define(\"" . $constantName . "\",";
        $end = ",";
        $var = $this->findReplace($start,$end);
        if(!$var)return false;
        $this->builtContent = $this->buildContent();
        $this->fileContent = str_replace($var,$this->builtContent ,$this->fileContent);
        return true;
    }

    public function save(){
        file_put_contents($this->filePath,$this->fileContent);
    }

    private function findReplace($start,$end){
        $var0 = explode($start,$this->fileContent);
        if(count($var0) <= 1){
            return false;
        }
        $var1 = explode($end,$var0[1]);
        if(count($var1 ) == 1){
            return explode("?>",$var1[0])[0];
        }
        return $var1[0];
    }


    private function buildContent():String
    {
        if(!is_array($this->rawContent)){
            return $this->rawContent;
        }
        return $this->buildArray($this->rawContent);
    }


    private function buildArray(array $a,$deep = 1){
        $start = "\n" . $this->buildDeepStr($deep) . "[\n";
        foreach ($a as $key => $value){
            $start .=  $this->buildDeepStr($deep + 1) . "\"" . $key ."\" => ";
            if(is_int($value)) {
                $start .= $value;
            } else if(is_array($value)){
                $start .= $this->buildArray($value, $deep+1);
            } else{
                $start .= "\"" . $value ."\"";
            }
            $start.=",\n";
        }
        return $start  . $this->buildDeepStr($deep) . "]";
    }



    private function buildDeepStr($deep){
        $var0 = "";
        for ($i=0;$i<$deep;++$i){
            $var0.= "   ";
        }
        return $var0;
    }

}