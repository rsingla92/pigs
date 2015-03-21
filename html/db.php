<?php

$login = "ora_m8z7@ug";
$password = "a43808104";
// Run a query
function run_query($query)
{
  $c=oci_connect($login, $pass, "ug");
  $parsed = oci_parse($c, $query);
  $success = oci_execute($parsed);

  if ($success) {
    return $parsed;
  }
  echo "fail";
  return $success;
}

// Get html table string from query results
function get_html_table($parsed)
{
  $table = "<table border=\"1\">\n";

  // Header
  $ncols = oci_num_fields($parsed);
  $table = $table . "<tr>\n";
  for ($i = 1; $i <= $ncols; ++$i) {
      $colname = oci_field_name($parsed, $i);
      $table = $table . "  <th><b>".htmlentities($colname, ENT_QUOTES)."</b></th>\n";
  }
  $table = $table . "</tr>\n";

  // Data rows
  while ($row = oci_fetch_array($parsed, OCI_ASSOC+OCI_RETURN_NULLS)) {
    $table = $table . "<tr>\n";


    foreach ($row as $item) {
      $itext = ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;");
      $table = $table . "<td>" . $itext . "</td>";
    }

    $table = $table . "</tr>\n";
  }
  $table = $table . "</table>\n";
  return $table;
}
?>
