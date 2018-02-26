<?php

$first_name = 'q"><script>alert("Pwned")</script>';
echo htmlentities(htmlentities($first_name),ENT_COMPAT, 'UTF-8');