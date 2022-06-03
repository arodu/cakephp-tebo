<?php

use Cake\Core\Configure;
use Cake\Routing\RouteBuilder;

$routes->plugin(
    'TeBo',
    ['path' => '/tebo'],
    function (RouteBuilder $builder) {
        $webhook = '/webhook';

        $obfuscation = Configure::read('tebo.obfuscation');
        if (!empty($obfuscation) && is_string($obfuscation)) {
            $webhook = '/' . $obfuscation;
        }
        
        $builder->post($webhook, [
            'plugin' => 'TeBo',
            'controller' => 'Api',
            'action' => 'webhook',
        ]);
    }
);
