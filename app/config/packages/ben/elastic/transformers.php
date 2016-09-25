<?php

return [
    //* this removes all special characters... should only do this if you NEED TO, not for ALLLLLLL strings.
    'string' => function($input) {
        // the preg_replace should strip out any "non printable characters"
        return $input;
    },

    'double' => function($input) {
        //force the casting to double
        return (DOUBLE)$input;
    },

    'integer' => function($input) {
        //force the casting to int
        return (INT)$input;
    },

];