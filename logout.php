<?php

//logout.php

include('googleConfig.php');

//Reset OAuth access token
$client->revokeToken();

//Destroy entire session data.
session_destroy();

//redirect page to index.php
header('location:view/login.php');

