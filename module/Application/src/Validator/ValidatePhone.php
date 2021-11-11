<?php
/**
 * Zend_Validate_Phone
 *
 * A validator that can be used in Zend_Form to validate phone numbers
 * Accepts only north-american form numbers
 * 
 * Accepted:
 * (819)800-0755
 * 819-800-0755
 * 8198000755
 * 819 800 0755
 */

class ValidatePhone extends Zend\Validator\AbstractValidator
{
    const INVALID      = 'phoneInvalid';
    const STRING_EMPTY = 'phoneStringEmpty';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID      => "Invalid phone number. Make sure this is a valid north american phone number (xxx)xxx-xxxx",
        self::STRING_EMPTY => "'%value%' is an empty string",
    );

    /**
     * Sets default option values for this instance
     *
     * @return void
     */
    public function __construct() {

    }

    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value contains a valid phone number
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value) {      
        //A regex to match phone numbers
        $pattern = "((\(?)([0-9]{3})(\-| |\))?([0-9]{3})(\-)?([0-9]{4}))";

        //If regex matches, return true, else return false
        if(preg_match($pattern, $value, $matches)) {
            //Valid phone number
            $isValid = true;
        } else {
            $this->_error(self::INVALID);
            $isValid = false;
        }


        return $isValid;
    }

}