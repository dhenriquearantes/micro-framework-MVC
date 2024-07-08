<?php 

use Library\Crud\Select; 


$sql = new Select();
$output = $this->sql->selectTable('users')->getSqlRaw();
print $output;