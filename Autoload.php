<?php 

/* 
 * Copyright (C) 2015 thoma 
 * 
 * This program is free software: you can redistribute it and/or modify 
 * it under the terms of the GNU General Public License as published by 
 * the Free Software Foundation, either version 3 of the License, or 
 * (at your option) any later version. 
 * 
 * This program is distributed in the hope that it will be useful, 
 * but WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
 * GNU General Public License for more details. 
 * 
 * You should have received a copy of the GNU General Public License 
 * along with this program.  If not, see <http://www.gnu.org/licenses/>. 
 */ 
namespace thom855j\PHPAutoloader;

class Autoload 
{ 

    // object instance 
    protected static 
            $_instance = null ; 
    private  
            $_storage ; 

    public 
            function __construct( $storage = array() ) 
    { 
        $this->_storage = $storage ; 
    } 

    // singleton instance
    public static 
            function load( $storage = null ) 
    { 
        if ( !isset( self::$_instance ) ) 
        { 
            self::$_instance = new Autoload( $storage ) ; 
        } 
        return self::$_instance ; 
    } 

    // load namespaces
    public 
            function namespaces() 
    { 
        //Add the paths to the class directories to the include path. 
        set_include_path( get_include_path() . PATH_SEPARATOR . implode( PATH_SEPARATOR , 
                                                                          $this->_storage ) ) ; 
        //Add the file extensions to the SPL. 
        spl_autoload_extensions( ".class.php,.php,.inc" ) ; 
        //Register the default autoloader implementation in the php engine. 
        spl_autoload_register( function ($className) 
        { 
            $className = ltrim( $className , '\\' ) ; 
            $fileName  = '' ; 
            $namespace = '' ; 
            if ( $lastNsPos = strrpos( $className , '\\' ) ) 
            { 
                $namespace = substr( $className , 0 , $lastNsPos ) ; 
                $className = substr( $className , $lastNsPos + 1 ) ; 
                $fileName  = str_replace( '\\' , DIRECTORY_SEPARATOR , 
                                          $namespace ) . DIRECTORY_SEPARATOR ; 
            } 
            $fileName .= str_replace( '_' , DIRECTORY_SEPARATOR , $className ) . '.php' ; 

            require_once $fileName ; 
        } ) ; 
    } 

} 
