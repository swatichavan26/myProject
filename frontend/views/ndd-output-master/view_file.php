<p style="font-size:20px; color:blue;">Showrun</p><br/>
<?php
try {
    if (empty($contents)) {
        $contents = "No Data Found";
    }
    ?><textarea rows="25" style="width:100%"><?php echo $contents; ?></textarea><?php
} catch (Exception $e) {
    throw $e;
}
?>
