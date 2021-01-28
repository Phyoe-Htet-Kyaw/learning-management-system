<?php

include "init/init.php";

$journal_id = $_GET['journal_id'];
$user_id = $_GET['user_id'];

$journal = new Journal;
if($journal->reportJournal($journal_id, $user_id)){
    echo "<script>location.href='index.php#current'</script>";
}

?>