<?php

// This file should be required at the start of artisan
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// Also disable deprecation warnings for the current process
ini_set('error_reporting', E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
