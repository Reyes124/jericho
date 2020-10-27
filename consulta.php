<?php
  // get the q parameter from URL
  // $customer_id     = $_REQUEST["customer_id"];
$customer_id = $_GET["customer_id"];
$user_log = $_GET["usuario"];

$mysqli = new mysqli('localhost','vendedor','law12', 'sakila');
  if ($mysqli->connect_errno) {
    $xml = '<mensaje>Connect failed: %s\n'. $mysqli->connect_error.'</mensaje>';
    $mysqli->close();
    return $xml;
  }

$mysqli->query("SET NAMES 'utf8'");
$query = "SELECT * FROM customer WHERE customer_id like ".$customer_id;
$result = $mysqli->query($query);
if (!$result) {
  $xml  = mensaje_de_error("Error en query: ".$mysqli->error);
  $mysqli->close();
  return $xml;
}
/* determinar el número de filas del resultado */
$row_cnt = $result -> num_rows;
  if ($row_cnt == 1) {
    while ($row   = $result -> fetch_assoc()) {
      $first_name = $row["first_name"];
      $last_name  = $row["last_name"];
      $email      = $row["email"];
    }
    $dom = new DOMDocument();
      $dom->encoding = 'utf-8';
      $dom->xmlVersion = '1.0';
      $dom->formatOutput = true;
      $xml_file_name = "ShearchCustomer_$user_log.xml";
      $root = $dom->createElement('InfoCustomer');
      $customer_node = $dom->createElement('Customer');
      $attr_customer_id = new DOMAttr('customer_id', $customer_id);
      $customer_node->setAttributeNode($attr_customer_id);      
      $child_node_name = $dom->createElement('CustomerName', $first_name);
      $customer_node->appendChild($child_node_name);
      $child_node_lastname = $dom->createElement('CustomerLastName', $last_name);
      $customer_node->appendChild($child_node_lastname);
      $child_node_email = $dom->createElement('CustomerEmail', $email);
      $customer_node->appendChild($child_node_email);
      $root->appendChild($customer_node);
      $dom->appendChild($root);    
      $dom->save($xml_file_name);
      echo "$xml_file_name has been successfully created";
      return;
    
  }
// Output "no suggestion" if no hint was found or output correct values

?>
