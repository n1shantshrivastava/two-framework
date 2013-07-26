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
 * alpha -> field should contain only alphabets
 * alphanumeric -> field should contain alphanumeric characters
 * numeric -> field should contain only numeric values
 * email -> validate the email
 * numeric-> field should contain numeric data only
 * special -> validate occurrence of specified character.these character are !@#$%^&*.
 *            if you want to exclude any character you can mention it with ':' Eg 'special:@' will not consider @ as special character
 * min -> validate field with min character length. Length must be specified with prefix ':'.if length is not mentioned 5 is default value.
 *            Eg 'min:5'
 * max -> validate field with maximum character length. Length will specified same as min.
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
                $this->validation_errors["$field"][]="value of $field ({$this->_data[$field]}) does not contain special characters";
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
    private function validateRequire($field,$param=null){
        if(!isset($this->_data[$field])){
            return false;
        }
        if(is_string($this->_data[$field])&&strlen(trim($this->_data[$field]))<=0){
            return false;
        }
        return true;
    }

    /*
     * validate the data should have at least given number of digit or character in it
     */
    private function validateMin($field,$param=6){
        if($this->validateParam($param)){
            if(is_string($this->_data[$field])&&strlen(trim($this->_data[$field]))<$param){
                return false;
            }
            elseif(is_numeric($this->_data[$field])&&(strlen((string)$this->_data[$field])<$param)){
                return false;
            }
            return true;
        }
        return false;
    }

    /*
    * validate the data should have at max  given number of digit or character in it
    */
    private function validateMax($field,$param=10){
        if(is_string($this->_data[$field])&&strlen(trim($this->_data[$field]))>$param){
            return false;
        }
        elseif(is_numeric($this->_data[$field])&&(strlen((string)$this->_data[$field])>$param)){
            return false;
        }
        return true;
    }

    /*
     * validate the field is alphabetic or not
     */
    private function validateAlpha($field,$param){
        if((1 === preg_match('/[a-zA-Z]+/',$this->_data[$field]))&&(0 == preg_match('/[0-9]+/',$this->_data[$field]))){
            return true;
        }
        return false;
    }

    /*
     * validate the field is alphanumeric or not
     */
    private function validateAlphanumeric($field,$param){
        if((1 === preg_match('/[a-zA-Z]+/',$this->_data[$field]))&&(1 === preg_match('/[0-9]+/',$this->_data[$field]))){
            return true;
        }
        return false;
    }
    /*
     * validate the field is numeric or not
     */
    private function validateNumeric($field,$param){
        if(1 === preg_match('/[0-9]+/',$this->_data[$field])&& 0=== (preg_match('/[a-zA-Z]+/',$this->_data[$field]))){
            return true;
        }
        return false;
    }
    /*
     * validate the email
     */
    private function validateEmail($field,$param){
        if(!filter_var($this->_data[$field],FILTER_VALIDATE_EMAIL)){
            return false;
        }
        return true;
    }
    private function validateSpecial($field,$param){
        $spl_Char=array('!','@','#','$','%','^','&','*');
        $preg_char='[';
        if(is_array($param)){
            foreach($spl_Char as $value){
                if(!in_array($value,$param)){
                    $preg_char.=$value;
                }
            }
            $preg_char.=']';
        }
        else{
            foreach($spl_Char as $value){
                if($value!==$param){
                    $preg_char.=$value;
                }
            }
            $preg_char.=']';
        }
        if(0===preg_match('/'.$preg_char.'/',$this->_data[$field])){
            return false;
        }
        return true;
    }

    private function validateParam($param,$isArray=false){
        /*
         * when parameter ia expected to be a single number but found array,
         *first numeric field in array will be returned as parameter
         * if no numeric value is found,false will be return indicating invalid parameter
         */
        if(is_array($param)&&!$isArray){
            foreach($param as $k=>$value){
                if(is_numeric($value)){
                    return $value;
                }
            }
            return false;
        }
        elseif(!is_numeric($param)&&!$isArray){
            return false;
        }
        elseif(is_array($param)&&$isArray){
            foreach($param as $key=>$value){
                // if(is_string($value))
            }
        }
        else{
            return $param;
        }
    }
    /*
     * parse the rule and forward to corresponding method of the validation class to validate the data
     */
    private function parse_rule($field,$rule){
        $param=null;
        if($act_rule=strstr($rule,':',true)){
            $params=strstr($rule,':');
            $params=substr($params,1,strlen($params));
            if(!(strpos($params,':'))){
                $param=$params;
            }
            else{
                while(strpos($params,':')){
                    $param[]=strstr($params,':',true);
                    $params=strstr($params,':');
                    $params=substr($params,1,strlen($params));
                }
            }
            $rule=$act_rule;
        }

        $method='validate'.ucfirst($rule);
        if(method_exists($this,$method)){
            if($this->$method($field,$param)===false){
                $this->addErrorField($field);
                $this->addError($field,$param,$rule);
            }
        }
        else{
            $this->_isvalid=false;
        }
    }
}