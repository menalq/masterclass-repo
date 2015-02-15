<?php
namespace MOOP\Controller;

class Error
{
    public function __construct()
    {
        
    }
    
    public function showError($message)
    {
        $content = $message;
        
        require '../layout.phtml';
    }
}