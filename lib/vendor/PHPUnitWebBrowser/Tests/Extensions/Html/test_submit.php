<?php 
if (isset($_POST['firstname'])) 
{
  echo $_POST['firstname'] . ' ' . $_POST['lastname'];
} 
else 
{ 
?>
<form action="/PHPUnit/Tests/Extensions/Html/test_submit.php" method="post">
  <label for="firstname">Firstname</label>
  <input type="text" name="firstname" id="firstname" />
  
  <label for="firstname">Lastname</label>
  <input type="text" name="lastname" id="lastname" />
  
  <input type="submit" value="Send" />
</form>
<?php 
}
?>