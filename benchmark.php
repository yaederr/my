<meta charset="utf-8">
<?php
error_reporting(E_ERROR | E_PARSE);
$time_start=time();
set_time_limit(0);//this script can run indefinitely
$extra_data= null;
$header=null;
$url_list = array(
"http://package.ski-express.com/sejour-ski-tout-compris/comparer/com-0/0/0/14/0/0/0/NULL/NULL/2015-04-04/2015-04-10/0/2/0/resultat.html",
"http://package.ski-express.com/sejour-ski-tout-compris/comparer/com-0/0/0/9/106/0/0/NULL/NULL/2015-04-04/2015-04-10/0/8/10/resultat.html",
);
$date = new DateTime();
$file = fopen("./output/benchmark.csv","w");
$file_two = fopen("./output/benchmark_".$date->format("Y-m-d") . ".csv","w");
$header="Num;Date;Prix;Rang;Cible;Malin;MoinsCher;NbSejours;Contexte\n";
fwrite($file, $header);
fwrite($file_two, $header);
for($i=0; $i<count($url_list); $i++){
	//url format is assumed to be: stem+result_offset+suffix
	$matches = array();//this is container for pregmatch results
	$url = $url_list[$i];
	//break up url
	preg_match("/\/[a-z]+\.html/", $url, $matches);
	$suffix = $matches[0];
	$regexp = '\d+\/'.substr($suffix, 1);
	if(preg_match("/$regexp/", $url, $matches) === 0){
		echo "malformed url detected (".$url.")";
		continue;
	}

	//result offset is the beginning of list chunk
	$result_offset = substr($matches[0], 0, strpos($matches[0], '/'));
	$stem = substr($url, 0, strpos($url, $matches[0]));

	//now start getting html
	$html = "";
	$offer_cnt = "inconnu";
	while( $t = get_table($stem, $result_offset, $suffix) ){
		$html.= $t['html'];
		$offer_cnt = $t['num_results'];
		$result_offset += 10;
		if(strpos($t['html'],"VTR Hiver") !== false){
			break;//because the target has been found
		}
		sleep(2);
	}
	$data = get_prix($html);
	//save data for this row
	$line="";
	$out.= $i.";"//id
	. $date->format("Y-m-d H:i:s").";"
	. $data['vtr_prix'].";"
	. $data['vtr_rank'].";"
	. $data['cible'].";"
	. $data['is_malin'].";"
	. $data['is_cher'].";"
	. $offer_cnt.";"
	. $url;
	$out.= isset($extra_data)? $extra_data[$i]:""; $out.= "\n";
	$line.= $i.";"//id
	. $date->format("Y-m-d H:i:s").";"
	. $data['vtr_prix'].";"
	. $data['vtr_rank'].";"
	. $data['cible'].";"
	. $data['is_malin'].";"
	. $data['is_cher'].";"
	. $offer_cnt.";"
	. $url;
	$line.= isset($extra_data)? $extra_data[$i]:"";
	fputcsv($file,explode(';',$line), ";");
	fputcsv($file_two,explode(';',$line), ";");
	echo "<p>Analyse $url - -" . $date->format("Y-m-d H:i:s") . "</p>\r\n";
}
echo "l'opération terminée après ". (time()-$time_start)." secondes";
fclose($file);
fclose($file_two);
function get_table($stem, $result_offset, $suffix){
	$html = file_get_contents($stem.$result_offset.$suffix);
	$table_end_pos = strpos($html, "</table>");
	$table_start_pos = strpos($html, "<table");
	if($table_end_pos===false or $table_start_pos===false){
		//if no table was found on this page, we are done searching
		return false;//give a negative response
	}
	$table_strng = substr($html, strpos($html, "<table"), $table_end_pos - $table_start_pos);
	$description_start_pos = strpos($html, '<div class="centre">');
	//get an initial string and then trim it back
	$context = substr($html, $description_start_pos, 555);
	$actual_length = strpos($context, '<div class="valider">');
	$context = substr($context, 0, $actual_length)."</div>";

	$num_results_start_pos = strpos($html, 'class="informations"');
	$num_results = substr($html, $num_results_start_pos, 144);
	$actual_length = strpos($num_results, '</p>');
	$num_results = substr($num_results, 0, $actual_length);
	//this is my dorky way of finding numbers without using regexp. it seems ok
	for($i=0; $i<strlen($num_results); $i++){
		$char = substr($num_results, $i, 1);
		$zero_nine = array(0,1,2,3,4,5,6,7,8,9);
		if(isset($zero_nine[$char])){ //notice only a number key will work
			$num_results_start_pos = $i;
			break;
		}
	}
	$num_results = (int) substr($num_results, $num_results_start_pos);
	return array("html"=>$table_strng, "context"=>$context, "num_results"=>$num_results);
}

function get_prix($html){
	$d = new DOMDocument();
	$d->loadHTML($html);
	$xpathvar = new Domxpath($d);
	$row_q = $xpathvar->query('//tr');
	$prix = array();
	$names = array();
	$vtr_rank = null;
	$is_malin = 0;
	$is_cher = 0;
	$vtr_prix = null;
	if($row_q->length > 0){//then there is at least one row on this page
		for($row_idx=0; $row_idx<$row_q->length; $row_idx++){
			$row = $row_q->item($row_idx);
			$is_divider = ($row->childNodes->length < 3);
			$is_header = (strcmp($row->getAttribute('class'), 'entete') == 0);
			if(!$is_divider && !$is_header){
				$names[] = $row->childNodes->item(6)->firstChild->getAttribute('alt');
				$prix_td = $row->childNodes->item(10);
				$prix[] = $prix_td->lastChild->previousSibling->nodeValue;
				if(!isset($vtr_rank)){
					if(strpos($names[count($names) - 1], 'VTR') !== false){
						$vtr_rank = count($names); //set the rang
						if(strpos($prix_td->nodeValue, 'malin') !== false){
							$is_malin = 1;
						}
						if(strpos($prix_td->nodeValue, 'cher') !== false){
							$is_cher = 1;
						}
						$vtr_prix = (int) $prix[$vtr_rank-1];
					}
				}
			}
		}
	}
	return array(
		"vtr_rank"=>$vtr_rank,
		"is_malin"=>$is_malin,
		"is_cher"=>$is_cher,
		"vtr_prix"=>$vtr_prix,
		"cible"=>(int) $prix[0]
	);
}
?>
