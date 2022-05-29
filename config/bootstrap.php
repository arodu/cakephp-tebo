<?php

use Cake\Core\Configure;

try {
    Configure::load('TeBo.tebo', 'default', false);
    Configure::load('tebo', 'default', false);
} catch (\Throwable $th) {
    //throw $th;
}
