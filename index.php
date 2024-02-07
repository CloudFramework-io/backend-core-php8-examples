<?php
if(getenv('CF_GOOGLE_APPLICATION_CREDENTIALS')) {
  putenv('GOOGLE_APPLICATION_CREDENTIALS=/tmp/credentials.json');
  if(!is_file('/tmp/credentials.json')) 
    file_put_contents('/tmp/credentials.json',getenv('CF_GOOGLE_APPLICATION_CREDENTIALS'));
}
include "vendor/cloudframework-io/backend-core-php8/src/dispatcher.php";