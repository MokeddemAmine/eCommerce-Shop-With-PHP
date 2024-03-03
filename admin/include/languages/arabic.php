<?php
  function lang($sentence){
    static $lang = array(
        'welcome'           => 'مرحبا'
    );
    return $lang($sentence);
}
?>