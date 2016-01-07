<?php
/**
 * Created by PhpStorm.
 * User: iloverink
 * Date: 10/17/14
 * Time: 1:09 PM
 */

return [
    'aliases' => [

        'lnk_today' => function($app,$start,$date) {
            $helper = $app->make('datehelper');
            return $helper->today($start,$date);
        },

        'lnk_7day' => function($app,$start,$date) {
            $helper = $app->make('datehelper');
            return $helper->range($start,$date,'-7day');
        },

        'lnk_14day' => function($app,$start,$date) {
            $helper = $app->make('datehelper');
            return $helper->range($start,$date,'-14day');
        },

        'lnk_30day' => function($app,$start,$date) {
            $helper = $app->make('datehelper');
            return $helper->range($start,$date,'-30day');
        },

        'lnk9_today' => function($app,$start,$date) {
            $helper = $app->make('datehelper');
            return $helper->today($start,$date);
        },

        'lnk9_7day' => function($app,$start,$date) {
            $helper = $app->make('datehelper');
            return $helper->range($start,$date,'-7day');
        },

        'lnk9_14day' => function($app,$start,$date) {
            $helper = $app->make('datehelper');
            return $helper->range($start,$date,'-14day');
        },

        'lnk9_30day' => function($app,$start,$date) {
            $helper = $app->make('datehelper');
            return $helper->range($start,$date,'-30day');
        },
    ],
];