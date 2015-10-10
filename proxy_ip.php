<?php
require('phpQuery/phpQuery.php');

$urlList = [
	'http://www.xicidaili.com/nn/',
	'http://www.xicidaili.com/nn/2',
	'http://www.xicidaili.com/nn/3',
	'http://www.xicidaili.com/nn/4',
	'http://www.xicidaili.com/nn/5',
];


$str = '';

foreach($urlList as $url)
{
	$str .= getIpList($url);
}

echo $str;


/**
$content = curl_string('http://www.xicidaili.com/nn/');

//echo $content;


//$doc = phpQuery::newDocumentFile('http://www.xicidaili.com/nn/');
$doc = phpQuery::newDocumentHTML($content);

//print_r($doc);

	$artlist = pq('#ip_list tr');

foreach($artlist as $li){
	if(pq($li)->find('td:eq(2)')->html())
	{
		echo "'" . pq($li)->find('td:eq(2)')->html(). ':' . pq($li)->find('td:eq(3)')->html()."', "; 
	}
} 
*/

//print_r($list);

	/**foreach($art as $tmp){
		 print '标题:'.pq($tmp)->find('div:eq(1)')->html().'<br>';
	}*/


function getIpList($url)
{
	$list = '';
	$content = curl_string($url);
	$doc = phpQuery::newDocumentHTML($content);
	$artlist = pq('#ip_list tr');
	foreach($artlist as $li)
	{
		if(pq($li)->find('td:eq(2)')->html())
		{
			$list .= "'" . pq($li)->find('td:eq(2)')->html(). ':' . pq($li)->find('td:eq(3)')->html()."', "; 
		}
	}
	return $list;
}



function curl_string($url, $user_agent="Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36")
{
       $ch = curl_init();
       curl_setopt ($ch, CURLOPT_URL, $url);
       curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
       curl_setopt ($ch, CURLOPT_COOKIEJAR, "_free_proxy_session=BAh7B0kiD3Nlc3Npb25faWQGOgZFVEkiJWI4ZDg0Yzk4M2M4ZjY3ODBmZGFiNmZlMDBjM2RhN2Y3BjsAVEkiEF9jc3JmX3Rva2VuBjsARkkiMVMySjYvMmVBVnZlbEszT2hlVVR0REU2MW1OQU1ZYzhwZGJrdm55MzBoK1k9BjsARg%3D%3D--964007854ec0ee1e8c3906d5453dd2efbd9a36af; CNZZDATA4793016=cnzz_eid%3D1103201736-1444270125-null%26ntime%3D1444454290");
       curl_setopt ($ch, CURLOPT_HEADER, 0);
       curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
       curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
       $result = curl_exec($ch);
       curl_close($ch);
       return $result;
}


die();
// INITIALIZE IT
// phpQuery::newDocumentHTML($markup);
// phpQuery::newDocumentXML();
// phpQuery::newDocumentFileXHTML('test.html');
// phpQuery::newDocumentFilePHP('test.php');
// phpQuery::newDocument('test.xml', 'application/rss+xml');
// this one defaults to text/html in utf8
$doc = phpQuery::newDocument('<div/>');

// FILL IT
// array syntax works like ->find() here
$doc['div']->append('<ul></ul>');
// array set changes inner html
$doc['div ul'] = '<li>1</li> <li>2</li> <li>3</li>';

// MANIPULATE IT
$li = null;
// almost everything can be a chain
$doc['ul > li']
	->addClass('my-new-class')
	->filter(':last')
		->addClass('last-li')
// save it anywhere in the chain
		->toReference($li);

// SELECT DOCUMENT
// pq(); is using selected document as default
phpQuery::selectDocument($doc);
// documents are selected when created or by above method
// query all unordered lists in last selected document
$ul = pq('ul')->insertAfter('div');

// ITERATE IT
// all direct LIs from $ul
foreach($ul['> li'] as $li) {
	// iteration returns PLAIN dom nodes, NOT phpQuery objects
	$tagName = $li->tagName;
	$childNodes = $li->childNodes;
	// so you NEED to wrap it within phpQuery, using pq();
	pq($li)->addClass('my-second-new-class');
}

// PRINT OUTPUT
// 1st way
print phpQuery::getDocument($doc->getDocumentID());
// 2nd way
print phpQuery::getDocument(pq('div')->getDocumentID());
// 3rd way
print pq('div')->getDocument();
// 4th way
print $doc->htmlOuter();
// 5th way
print $doc;
// another...
print $doc['ul'];