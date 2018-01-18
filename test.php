
<?php
require_once 'client.php';

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Directory($client);

// Print the first 10 users in the domain.
$optParams = array(
  'customer' => 'my_customer',
  'maxResults' => 10,
  'orderBy' => 'email',
);
$results = $service->users->listUsers($optParams);

if (count($results->getUsers()) == 0) {
  print "No users found.\n";
} else {
  print "Users:<br>\n";
  foreach ($results->getUsers() as $user) {
    printf("%s (%s)<br>\n", $user->getPrimaryEmail(),
        $user->getName()->getFullName());
  }
}

