<?php
$types="DNS_NS,DNS_A,DNS_CNAME,DNS_HINFO,DNS_MX,DNS_PTR,DNS_SOA,DNS_TXT,DNS_AAAA,DNS_SRV,DNS_NAPTR,DNS_A6,DNS_ALL,DNS_ANY";
$types=explode(",",$types);
$targettype="CNAME,MX,NS,PTR";
if ($_GET['domain']) {
	$redir=0;
	if (substr($_GET['domain'],-3,3) == "%2F") {
		$_GET['domain'] = substr($_GET['domain'],0,strlen($_GET['domain']) -3);
		$redir=1;
	}
	if (substr($_GET['domain'],-1,1) == "/") {
		$_GET['domain'] = substr($_GET['domain'],0,strlen($_GET['domain']) -1);
		$redir=1;
	}
	if (substr($_GET['domain'],0,14) == "http%3A%2F%2F") {
		$_GET['domain'] = substr($_GET['domain'],14,strlen($_GET['domain']) -14);
		$redir=1;
	}
	if (substr($_GET['domain'],0,7) == "http://") {
		$_GET['domain'] = substr($_GET['domain'],7,strlen($_GET['domain']) -7);
		$redir=1;
	}
	if (substr($_GET['domain'],-3,3) == "%20") {
		$_GET['domain'] = substr($_GET['domain'],0,strlen($_GET['domain']) -3);
		$redir=1;
	}
	if (substr($_GET['domain'],-1,1) == " ") {
		$_GET['domain'] = substr($_GET['domain'],0,strlen($_GET['domain']) -1);
		$redir=1;
	}

	$_GET['domain'] = addslashes($_GET['domain']);
	if ($redir==1) {
		header('Location: http://tools.theschweitzer.info/dns/?domain='.$_GET['domain']);
	}
	$type=$_GET['type'];
	if (in_array($type,$types)) {
		$domain = dns_get_record($_GET['domain'],constant($type));
	} else {
		$domain = dns_get_record($_GET['domain'],DNS_ALL);
	}
	
	echo json_encode($domain);
} else {
	print '<form action="http://'.$_SERVER[HTTP_HOST].$_SERVER[SCRIPT_NAME].'" method="GET">
	Domain:<input type="text" name="domain"><br />
	<input type="submit" value="Submit">';
}
?>
