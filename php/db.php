<?php
// Run a query
function run_query($query, $login, $pass)
{
  $c=oci_connect($login, $pass, "ug");
  $parsed = oci_parse($c, $query);
  $success = oci_execute($parsed);

  if ($success) {
    return $parsed;
  }
  return $success;
}

// Get html table string from query results
function get_html_table($parsed)
{
  $table = "<table>";
  while ($row = oci_fetch_array($parsed, OCI_ASSOC+OCI_RETURN_NULLS)) {
    $table = $table . "<tr>";

    foreach ($row as $item) {
      $itext = ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;");
      $table = $table . "<td>" . $itext . "</td>";
    }

    $table = $table . "</tr>";
  }
  $table = table . "</table>";
  return $table;
}
?>
