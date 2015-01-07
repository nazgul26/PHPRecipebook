<?php
/**
 * This is email configuration file.
 *
 * Use it to configure email transports of CakePHP.
 */
class EmailConfig {

    public $default = array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => 465,
        'username' => 'yourgmail@gmail.com',
        'password' => 'secret',
        'transport' => 'Smtp'
    );
}
