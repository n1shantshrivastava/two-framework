<?php
/*
 * validation
 * rules are predefined for validation
 * developers will use those rule to validate the data
 *
 * if any rule is not given by default require rule will be use for all mentioned data fields
 *
 * rules are defined and must be given in the defined way
 * these rules are :
 * require -> field should not be empty
 * alpha -> field should contain 'only alphabets'
 * alphanumeric -> field should contain 'only alphanumeric' characters
 * numeric -> field should contain 'only numeric' values
 * email -> validate the email
 * numeric-> field should contain numeric data only
 * special -> validate occurrence of special character.these character are !@#$%^&*.(at least one special character must be present);
 *            if you want to exclude any character you can mention it with ':' Eg 'special:@' will not consider @ as special character
 * min -> validate field with min character length. Length must be specified with prefix ':'.if length is not mentioned 5 is default value.
 *            Eg 'min:5'
 * max -> validate field with maximum character length. Length will specified same as min.
 *
 * please do not use two contradictory rules together (like alpha and numeric)
 */
class LibValidation{

    private $_data;
    private $_rules;
    private $_isvalid;
    public $validation_errors=array();
    public $error_field=array();

    public function __construct($data,$rules=null){
        $this->_data=$data;
        if(empty($rules)||!isset($rules)){
            $rules='requireAll';
        }
        $this->_rules=$rules;
        $this->_isvalid=true;
    }

    public function validate(){
        foreach($this->_data as $field=>$value){
            $rule_for_field=$this->get_rule($field);
            if(is_array($rule_for_field)){
                foreach($rule_for_field as $key=>$rule){
                    $this->parse_rule($field,$rule);
                }
            }
            elseif(is_string($rule_for_field)){
                $this->parse_rule($field,$rule_for_field);
            }

        }
        return $this->_isvalid;
    }

    private function get_rule($field){
        if(is_array($this->_rules)){
            if(array_key_exists($field,$this->_rules)){
                return $this->_rules[$field];
            }
        }
        elseif(is_string($this->_rules)&&$this->_rules=='requireAll'){
            return 'require';
        }
    }


    private function addErrorField($field){
        if(!in_array($field,$this->error_field)){
            $this->error_field[]=$field;
        }
    }
    /*
     * parse the rule and forward to corresponding method of the validation class to validate the data
     */
    private function parse_rule($field,$rule){
        $param=null;
        $temp_rule=$rule;
        if($act_rule=strstr($rule,':',true)){
            $params=strstr($rule,':');
            $params=substr($params,1,strlen($params));
            if(!(strpos($params,':'))){
                $param=$params;
            }
            else{
                do{
                    $param[]=strstr($params,':',true);
                    $params=strstr($params,':');
                    $params=substr($params,1,strlen($params));
                }  while(strpos($params,':'));
                if(!empty($params)){
                    $param[]=$params;
                }
            }
            $rule=$act_rule;
        }

        $method='validate'.ucfirst($rule);
        if((method_exists($this,$method))&&($this->validateParam($param,$rule))){
            $value=$this->_data[$field];
            if($this->$method($value,$param)===false){
                $this->addErrorField($field);
                $this->addError($field,$param,$rule);
            }
        }
        else{
            /*
             * get the information from where this function is called
             * debug_backtrace function will give all hierarchy of how call generated to function
             */
            $parent=debug_backtrace();
            throw new ApplicationException("Syntax Error: rule '$temp_rule' is not defined properly",$parent[1]['file'],$parent[1]['line']);
        }
    }
    /*
     * keep all error in one array so that user will able to use them
     */
    private function addError($field,$param,$rule){
        $this->_isvalid=false;
        switch($rule){
            case 'require':
                $this->validation_errors["$field"][]="value of $field ({$this->_data[$field]}) should not be empty";
                break;
            case 'min':
                $this->validation_errors["$field"][]="value of $field ({$this->_data[$field]}) should have minimum $param characters/digits";
                break;
            case 'max':
                $this->validation_errors["$field"][]="value of $field ({$this->_data[$field]}) should have maximum $param characters/digits";
                break;
            case 'alpha':
                $this->validation_errors["$field"][]="value of $field ({$this->_data[$field]}) should contain only alphabets";
                break;
            case 'alphanumeric':
                $this->validation_errors["$field"][]="value of $field ({$this->_data[$field]}) should be alphanumeric";
                break;
            case 'email':
                $this->validation_errors["$field"][]="value of $field ({$this->_data[$field]}) is not valid email";
                break;
            case 'special':
                $this->validation_errors["$field"][]="value of $field ({$this->_data[$field]}) should contain at least one special character";
                break;
            case 'numeric':
                $this->validation_errors["$field"][]="value of $field ({$this->_data[$field]}) should contain only numeric values";
                break;
            default:
                $this->validation_errors['other'][]="$rule is not defined in library";
        }
    }

    /*
     *function for checking field is been set and not empty
     */
    private function validateRequire($value,$param=null){
        if(!isset($value)){
            return false;
        }
        if(is_string($value)&&strlen(trim($value))<=0){
            return false;
        }
        return true;
    }

    /*
     * validate the data should have at least given number of digit or character in it
     */
    private function validateMin($value,$param=6){
            if(is_string($value)&&strlen(trim($value))<$param){
                return false;
            }
            elseif(is_numeric($value)&&(strlen((string)$value)<$param)){
                return false;
            }
            return true;
    }

    /*
    * validate the data should have at max  given number of digit or character in it
    */
    private function validateMax($value,$param=10){
        if(is_string($value)&&strlen(trim($value))>$param){
            return false;
        }
        elseif(is_numeric($value)&&(strlen((string)$value)>$param)){
            return false;
        }
        return true;
    }

    /*
     * validate the field is alphabetic or not
     */
    private function validateAlpha($value,$param){
        if(1 === preg_match('/^[a-zA-Z]+$/',$value)){
            return true;
        }
        return false;
    }

    /*
     * validate the field is alphanumeric or not
     */
    private function validateAlphanumeric($value,$param){
        if(1 === preg_match('/^[a-zA-Z0-9]+$/',$value)){
            return true;
        }
        return false;
    }
    /*
     * validate the field is numeric or not
     */
    private function validateNumeric($value,$param){
        if(1 === preg_match('/^[0-9]+$/',$value)){
            return true;
        }
        return false;
    }
    /*
     * validate the email
     */
    private function validateEmail($value,$param){
        if(!filter_var($value,FILTER_VALIDATE_EMAIL)){
            return false;
        }
        return true;
    }
    private function validateSpecial($value,$param){
        $spl_Char=array('!','@','#','$','%','^','&','*');
        $preg_char='[';
        if(is_array($param)){
            foreach($spl_Char as $char){
                if(!in_array($char,$param)){
                    $preg_char.=$char;
                }
            }
            $preg_char.=']';
        }
        else{
            foreach($spl_Char as $char){
                if($char!==$param){
                    $preg_char.=$char;
                }
            }
            $preg_char.=']';
        }
        if(0===preg_match('/'.$preg_char.'/',$value)){
            return false;
        }
        return true;
    }

    private function validateParam($param,$rule){
        /*
         * when parameter ia expected to be a single number but found array,
         *first numeric field in array will be returned as parameter
         * if no numeric value is found,false will be return indicating invalid parameter
         */
        switch($rule){
            case 'min':
            case 'max':
                if(is_array($param) || !is_numeric($param)){
                    return false;
                }
                break;
            case 'alpha':
            case 'alphanumeric':
            case 'numeric':
            case 'email':
            case 'require':
                if(isset($param)){
                    return false;
                }
                break;
        }
       return true;
    }

}