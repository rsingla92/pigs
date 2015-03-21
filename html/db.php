<?php

// Run a query
function run_query($query)
{
  $c=oci_connect("ora_m8z7", "a43808104", "ug");
  if ($c == false) {
    echo "Unable to connect";
    return false;
  }

  $parsed = oci_parse($c, $query);
  if ($parsed == false) {
    echo "Parse error: {$query}";
    return false;
  }

  $success = oci_execute($parsed);
  if ($success) {
    return get_html_table($parsed);
  }
  echo "Execute error on: ${query}\n";
  $e = oci_error($parsed);
  echo "Error:";
  print htmlentities($e['message']);
  print "\n<pre>\n";
  print htmlentities($e['sqltext']);
  printf("\n%".($e['offset']+1)."s", "^");
  print  "\n</pre>\n";

  return false;
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
