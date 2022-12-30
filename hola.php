<?php

class A
{
    function __construct()
    {
        echo 'ghola';
    }
};

class B extends A {
    function __construct()
    {

    }
}

$c = new B();
