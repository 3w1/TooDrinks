<?php
return array(
    // set your paypal credential
    'client_id' => 'ASEvJyG98PAZWaUGcZYvt5uareUknqtIuWyKXaS9ib-vEDCuCGaOAQne671-iw44fixLhNusNha-GWVw',
    'secret' => 'EI2QanbXNYj4CBD5ZnwmxF5sOsMll8eSYlKfUylDYl9GT1rPxWpHe6RPXGOa9fmScW2q3t-A3NifN1eA',
 
    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',
 
        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,
 
        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,
 
        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',
 
        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);