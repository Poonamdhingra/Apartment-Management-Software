<?php
// Common Code Starts


include("dbconnect.php");

try
{
  $selectAll = "SELECT  residents.UserId, apartments.ApartmentNo, apartments.LeaseAmount FROM apartments,residents
WHERE residents.ApartmentNo = apartments.ApartmentNo 
AND apartments.Status='Leased' AND residents.UserId NOT IN ( SELECT DISTINCT transactions.UserId FROM transactions)";
$selectAllResult = $pdo->query($selectAll);



  $selectPet = "SELECT residents.UserId, residents.NumPets, apartments.ApartmentNo 
  FROM apartments,residents WHERE residents.ApartmentNo = apartments.ApartmentNo AND residents.NumPets>0 ";
  $selectPetResult = $pdo->query($selectPet);
  
  $selectNoPet = "SELECT residents.UserId, residents.NumPets, apartments.ApartmentNo 
  FROM apartments,residents WHERE residents.ApartmentNo = apartments.ApartmentNo AND residents.NumPets=0 ";
  $selectNoPetResult = $pdo->query($selectNoPet);
}
catch (PDOException $e)
{
  $error = 'Error fetching data: ' . $e->getMessage();

  exit();
}


?>