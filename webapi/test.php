<?php

# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$mgClient = new Mailgun('key-c154b4083d3d6d92f646f85fc2db10d7');
$domain = "sandbox59e4bf5f70f34b14b13a3ea12bd9a9e4.mailgun.org";

# Make the call to the client.
$result = $mgClient->sendMessage("$domain",
          array('from'    => 'Mailgun Sandbox <postmaster@sandbox59e4bf5f70f34b14b13a3ea12bd9a9e4.mailgun.org>',
                'to'      => 'Irfan Abyan <irfanabyan96@gmail.com>',
                'subject' => 'Hello Irfan Abyan',
                'text'    => 'Congratulations Irfan Abyan, you just sent an email with Mailgun!  You are truly awesome! '));

# You can see a record of this email in your logs: https://mailgun.com/app/logs .

# You can send up to 300 emails/day from this sandbox server.
# Next, you should add your own domain so you can send 10,000 emails/month for free.

?>