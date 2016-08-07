<?php

Configure::write('App.version', '5.0');

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', ['engine' => 'File']);

CakePlugin::load('Upload');

Configure::write('Dispatcher.filters', [
    'AssetDispatcher',
    'CacheDispatcher',
]);

/*
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', [
    'engine' => 'File',
    'types'  => ['notice', 'info', 'debug'],
    'file'   => 'debug',
]);
CakeLog::config('error', [
    'engine' => 'File',
    'types'  => ['warning', 'error', 'critical', 'alert', 'emergency'],
    'file'   => 'error',
]);

/*
 * Set some app constants.  These are not intended to be changed frequently.
 */
Configure::write('AuthRoles', [
    'author' => 30, // Basic User
    'editor' => 60, // Can Edit other people content
    'admin'  => 90, // Site Admin Level Access
]);

// List for Binding to UI (yes I am lazy on this)
Configure::write('AuthEditRoles', [
    30 => 'author', // Basic User
    60 => 'editor', // Can Edit other people content
    90 => 'admin', // Site Admin Level Access
]);

Configure::write('MeasurementSystems', [
    0 => 'Static',
    1 => 'Imperial',
    2 => 'Metric',
]);

Configure::write('Languages', [
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
    'swe' => 'Swedish',
]);
