<?php
return array(
    /*
    |--------------------------------------------------------------------------
    | Enable emailing errors
    |--------------------------------------------------------------------------
    |
    | Should we email error traces?
    |
    */
    'enabled' => true,

    /*
    |--------------------------------------------------------------------------
    | Skip emailing errors for some HTTP status codes
    |--------------------------------------------------------------------------
    |
    | For which HTTP status codes should we NOT send error emails?
    |
    */
    'disabledStatusCodes' => array(
        '404' => true,
    ),

    /*
    |--------------------------------------------------------------------------
    | Error email recipients
    |--------------------------------------------------------------------------
    |
    | Email stack traces to these addresses.
    |
    | For a single recipient, the format can just be
    |   'to' => array('address' => 'you@domain.com', 'name' => 'Your Name'),
    |
    | For multiple recipients, just specify an array of those:
    |   'to' => array(
    |       array('address' => 'you@domain.com', 'name' => 'Your Name'),
    |       array('address' => 'me@domain.com', 'name' => 'My Name'),
    |   ),
    |
    */

    'to' => array('address' => 'errors@integrityinvoice.com', 'name' => 'Adeniyi Moses Adetola'),
);