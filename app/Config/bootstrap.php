<?php

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

CakePlugin::load('Upload');

Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

/**
 * Set some app constants.  These are not intended to be changed frequently.
 */
Configure::write('AuthRoles', array(
    'author' => 30, // Basic User
    'editor' => 60, // Can Edit other people content
    'admin'=>90 // Site Admin Level Access
));

Configure::write('MeasurementSystems', array(
    0 => 'Static',
    1 => 'Imperial',
    2 => 'Metric'
));
