<?php namespace Hmones\Membership\Classes;

class Utilities {

    public static function is_array_empty($InputVariable)
    {
       $Result = true;
    
       if (is_array($InputVariable) && count($InputVariable) > 0)
       {
          foreach ($InputVariable as $Value)
          {
             $Result = $Result && self::is_array_empty($Value);
          }
       }
       else
       {
          $Result = empty($InputVariable);
       }
    
       return $Result;
    }

    
    
}

?>