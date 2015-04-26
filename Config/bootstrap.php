<?php
Configure::write('App.version', '5.0');

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

// List for Binding to UI (yes I am lazy on this)
Configure::write('AuthEditRoles', array(
    30 => 'author', // Basic User
    60 => 'editor', // Can Edit other people content
    90 =>'admin' // Site Admin Level Access
));

Configure::write('MeasurementSystems', array(
    0 => 'Static',
    1 => 'Imperial',
    2 => 'Metric'
));

Configure::write('Languages', array(
    'eng' => 'English',
    'zho' => 'Chinese',
    'dan' => 'Danish',
    'nld' => 'Dutch',
    'est' => 'Estonian',
    'fra' => 'French',
    'deu' => 'German',
    'hun' => 'Hungarian',
    'ita' => 'Italian',
    'jpn' => 'Japanese',
    'kor' => 'Korean',
    'nor' => 'Norwegian',
    'por' => 'Portuguese',
    'tur' => 'Turkish',
    'srp' => 'Serbian',
    'spa' => 'Spanish',
    'swe' => 'Swedish'
));

