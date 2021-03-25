<?php
function get_new_id($fieldname,$table,$kodeawal){
 $q = "Select ".$fieldname." from ".$prefix.$table." ORDER BY ".$fieldname." DESC LIMIT 1";
 $res=mysql_query($q) or die(mysql_error());
 $row = mysql_fetch_array($res);
 $cekQ=$row[$fieldname];
 $awalQ=substr($cekQ,0-4);
 $next=$awalQ+1;
 $jid=strlen($next);
 if($jid==1)
 { $no='000'; }
	elseif($jid==2)
	{ $no='00'; }
	elseif($jid==3)
	{ $no='0'; }
 $br=$kodeawal.$no.$next;
 return $br;
}
?>