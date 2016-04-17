<?php
/**
 * EuRED - European Reading Experience Database
 * UK Red CSV converter
 * Gautier MICHELIN
 */
//error_reporting(E_ERROR);
require_once 'vendor/autoload.php';

$genres=array();
$genres["genre_bible"]=array("GEN704","Bible");
$genres["genre_sermon"]=array("GEN731","Sermon");
$genres["genre_other_religious"]=array("GEN724","Other Religious");
$genres["genre_classics"]=array("GEN706","Classics");
$genres["genre_fiction"]=array("GEN3","Fiction");
$genres["genre_drama"]=array("GEN6","Drama");
$genres["genre_essays"]=array("GEN713","Essays/criticism");
$genres["genre_history"]=array("GEN716","History");
$genres["genre_poetry"]=array("GEN2","Poetry");
$genres["genre_children"]=array("GEN8","Children's lit");
$genres["genre_social"]=array("GEN732","Social science");
$genres["genre_heraldry"]=array("GEN715","Heraldry");
$genres["genre_biography"]=array("GEN705","Biographies");
$genres["genre_autobiog"]=array("GEN703","Autobiographies");
$genres["genre_geography"]=array("GEN714","Geography/travel");
$genres["genre_politics"]=array("GEN726","Politics");
$genres["genre_philosophy"]=array("GEN725","Philosophy");
$genres["genre_education"]=array("GEN7171","Education");
$genres["genre_sport"]=array("GEN733","Sports/leisure");
$genres["genre_crafts"]=array("GEN710","Crafts");
$genres["genre_textbook"]=array("GEN7172","Textbook / Self education");
$genres["genre_conduct"]=array("GEN708","Conduct books");
$genres["genre_law"]=array("GEN718","Law");
$genres["genre_science"]=array("GEN730","Science");
$genres["genre_arts"]=array("???","???");
$genres["genre_cookery"]=array("GEN709","Cookery");
$genres["genre_medicine"]=array("GEN720","Medicine");
$genres["genre_ephemera"]=array("GEN712","Ephemera");
$genres["genre_mathematics"]=array("GEN719","Mathematics");
$genres["genre_technology"]=array("GEN734","Technology");
$genres["genre_emblem"]=array("GEN711","Emblem");
$genres["genre_natural"]=array("GEN722","Natural history");
$genres["genre_miscellary"]=array("GEN721","Misc/anthology");
$genres["genre_astrology"]=array("GEN702","Astrology/alchemy/occult");
$genres["genre_agriculture"]=array("GEN701","Agriculture/horticulture/Husbandry");
$genres["genre_reference"]=array("GEN728","Reference/General work");
$genres["genre_unknown"]=array("GEN9","Other / Unknown");
$genres["genre_other"]=array("GEN9","Other / Unknown");

$textforms = array();
$textforms["form_text_print_advertisement"]=array("TFO01","Advertisement");
$textforms["form_text_print_book"]=array("TFO02","Book");
$textforms["form_text_print_broadsheet"]=array("TFO03","Broadsheet");
$textforms["form_text_print_form"]=array("TFO10","Form");
$textforms["form_text_print_handbill"]=array(" TFO12","Handbill");
$textforms["form_text_print_newspaper"]=array("TFO17","Newspaper");
$textforms["form_text_print_pamphlet"]=array("TFO18","Pamphlet");
$textforms["form_text_print_poster"]=array(" TFO20","Poster");
$textforms["form_text_print_serial"]=array("TFO24","Serial/periodical");
$textforms["form_text_print_ticket"]=array("TFO26","Ticket");
$textforms["form_text_print_unknown"]=array(" TFO27","Unknown");
$textforms["form_text_print_other"]=array("TFO27","Unknown");
$textforms["form_text_manuscript_codex"]=array("TFO04","Codex");
$textforms["form_text_manuscript_graffito"]=array("TFO11","Graffito");
$textforms["form_text_manuscript_letter"]=array("TFO15","Letter");
$textforms["form_text_manuscript_pamphlet"]=array("TFO18","Pamphlet");
$textforms["form_text_manuscript_roll"]=array("TFO22","Roll");
$textforms["form_text_manuscript_sheet"]=array("TFO25","Sheet");
$textforms["form_text_manuscript_unknown"]=array("TFO27","Unknown");
$textforms["form_text_manuscript_other"]=array("TFO27","Unknown");
$textforms["form_text_unknown"]=array("TFO27","Unknown");
$textforms["form_text_known_publication"]=array("???","???");

$religions = array();

$religions["(Wavering) Church of Scotland"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["[lapsed] Catholic"]=array("FAI21","Catholic");
$religions["Agnostic"]=array("FAI71","Agnostics");
$religions["anabaptist (for a short time)"]=array("???","???");
$religions["Anglican"]=array("FAI241","Anglicans");
$religions["Anglican (?)"]=array("FAI241","Anglicans");
$religions["Anglican?"]=array("FAI241","Anglicans");
$religions["Anglicanism"]=array("FAI241","Anglicans");
$religions["ascetic mystical Christian"]=array("FAI2","Christianity");
$religions["At the time of reading a Roman Catholic"]=array("FAI217 Roman","Catholic");
$religions["Atheist"]=array("FAI72","Atheists");
$religions["Atheist (Marxist)"]=array("FAI72","Atheists");
$religions["Atheist (PB Shelley); unknown (Clairmont)"]=array("FAI72","Atheists");
$religions["Baptist"]=array("FAI2442 Nonconformists (Baptists, Dissenters,","Puritans)");
$religions["Born into a Quaker family"]=array("FAI233","Quakers");
$religions["C of E"]=array("FAI2411 Anglican Church of","England");
$religions["C of E? Converted to Baptism 1800, Methodism 1802."]=array("FAI2411 Anglican Church of","England");
$religions["C of E/ Methodist"]=array("FAI2411 Anglican Church of","England");
$religions["C of Scotland"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Calvinist"]=array("FAI242","Calvinists");
$religions["Catholic"]=array("FAI21","Catholic");
$religions["Catholic (having been lapsed and reverted)"]=array("FAI21","Catholic");
$religions["Catholic (lapsed)"]=array("FAI21","Catholic");
$religions["Catholic [?]"]=array("FAI21","Catholic");
$religions["Catholic by birth"]=array("FAI21","Catholic");
$religions["Catholic?"]=array("FAI21","Catholic");
$religions["Christain"]=array("FAI2","Christianity");
$religions["Christian"]=array("FAI2","Christianity");
$religions["Christian -  Unitarian"]=array("FAI2442 Nonconformists (Baptists, Dissenters,","Puritans)");
$religions["Christian - denomination unknown"]=array("FAI2","Christianity");
$religions["Christian - Evangelical"]=array("FAI2442 Nonconformists (Baptists, Dissenters,","Puritans)");
$religions["Christian (Anglican)"]=array("FAI241","Anglicans");
$religions["Christian (Anglican) later declared herself atheist"]=array("FAI241","Anglicans");
$religions["Christian (Church of England)"]=array("FAI2411 Anglican Church of","England");
$religions["Christian (denomination unknown)"]=array("FAI2","Christianity");
$religions["Christian [family originally Parsee]"]=array("FAI2","Christianity");
$religions["Christian, Protestant"]=array("FAI24","Protestants");
$religions["Christianity/Anglican"]=array("FAI241","Anglicans");
$religions["Chruch of Scotland"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Church of England"]=array("FAI2411 Anglican Church of","England");
$religions["Church of England (evangelical)"]=array("FAI2411 Anglican Church of","England");
$religions["Church of England; later atheist"]=array("FAI2411 Anglican Church of","England");
$religions["Church of England/ Methodist"]=array("FAI2411 Anglican Church of","England");
$religions["Church of Ireland"]=array("FAI2412 Anglican Church of","Ireland");
$religions["Church of Scotland"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Church of Scotland  Unitarian"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Church of Scotland (wavering)"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Church of Scotland then Unitarian"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Congregationalist"]=array("FAI24","Protestants");
$religions["Convert to Roman Catholicism"]=array("FAI217 Roman","Catholic");
$religions["Dissenter"]=array("FAI2442 Nonconformists (Baptists, Dissenters,","Puritans)");
$religions["dissenting"]=array("FAI2442 Nonconformists (Baptists, Dissenters,","Puritans)");
$religions["Dutch Jewish, coverted to Christianity"]=array("FAI2","Christianity");
$religions["Early: Church of Scotland. Later wavering, then uncommitted."]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Episcopalian"]=array("FAI2414 Scottish Episcopal","Church");
$religions["Evangelical"]=array("FAI24","Protestants");
$religions["Evangelical (Clapham Sect)"]=array("FAI24","Protestants");
$religions["Evangelical Anglican"]=array("FAI241","Anglicans");
$religions["Evangelical Christian at the time later promoted his own brand of spirituality"]=array("FAI24","Protestants");
$religions["family Methodist but becomes athiest"]=array("FAI2441 Methodists","");
$religions["Free Church"]=array("FAI24","Protestants");
$religions["Free thinker"]=array("FAI72","Atheists");
$religions["Jewish"]=array("FAI5","Judaism");
$religions["Jewish and agnostic"]=array("FAI5","Judaism");
$religions["Jewish convert to Protestant Christianity"]=array("FAI24","Protestants");
$religions["Lapsed Calvinist"]=array("FAI242","Calvinists");
$religions["lapsed Methodist"]=array("FAI2441","Methodists");
$religions["lapsed presbyterian"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["later a Wesleyan Methodist"]=array("FAI2441","Methodists");
$religions["later atheist"]=array("FAI72","Atheists");
$religions["Liberal Anglican"]=array("FAI241","Anglicans");
$religions["Methodist"]=array("FAI2441","Methodists");
$religions["Methodist (eventually)"]=array("FAI2441","Methodists");
$religions["Methodist later agnostic"]=array("FAI2441","Methodists");
$religions["methodist(lapsed-experience revives his faith)"]=array("FAI2441","Methodists");
$religions["muslim"]=array("FAI4","Islam");
$religions["New Church"]=array("FAI23 Other","Christian");
$religions["Non Conformist"]=array("FAI2442 Nonconformists (Baptists, Dissenters,","Puritans)");
$religions["Non-Conformist"]=array("FAI2442 Nonconformists (Baptists, Dissenters,","Puritans)");
$religions["Noncomformist"]=array("FAI2442 Nonconformists (Baptists, Dissenters,","Puritans)");
$religions["Nonconformist"]=array("FAI2442 Nonconformists (Baptists, Dissenters,","Puritans)");
$religions["none"]=array("FAI72","Atheists");
$religions["originally Christian (Anglican) by now declared atheist"]=array("FAI72 Atheists","");
$religions["originally Polish Catholic, by now agnostic/atheist"]=array("FAI72","Atheists");
$religions["Orthodox Anglican"]=array("FAI241","Anglicans");
$religions["Plymouth Brethern"]=array("FAI244 Other","Protestants");
$religions["Plymouth Brethren"]=array("FAI244 Other","Protestants");
$religions["Polish Catholic"]=array("FAI216 Other Catholic","");
$religions["Prebyterian"]=array("FAI2421 Church of Scotland (Presbyterian)","");
$religions["Presbiterian/ Quaker 1825 onwards"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Presbyterian"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Presbyterian [?]"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Presbyterian family"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Presbyterian/ Quaker 1825 onwards"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Presbyterian/lapsed in adolescence"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["presumably Catholic"]=array("FAI21","Catholic");
$religions["Previously Unitarian; now agnostic"]=array("FAI71","Agnostics");
$religions["Primitive Methodist"]=array("FAI2441","Methodists");
$religions["Probably Anglican"]=array("FAI241","Anglicans");
$religions["Probably still Anglican"]=array("FAI241","Anglicans");
$religions["Protestant"]=array("FAI24","Protestants");
$religions["Protestant - possibly dissenting"]=array("FAI24","Protestants");
$religions["Protestant - probably Unitarian"]=array("FAI24","Protestants");
$religions["Protestant -- probably Church of Scotland"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Protestant -probably Unitarian"]=array("FAI24","Protestants");
$religions["Protestant (?)"]=array("FAI24","Protestants");
$religions["Protestant dissenter- unitarian"]=array("FAI2442 Nonconformists (Baptists, Dissenters,","Puritans)");
$religions["Puritan"]=array("FAI2442 Nonconformists (Baptists, Dissenters,","Puritans)");
$religions["Quaker"]=array("FAI233","Quakers");
$religions["Quaker (inclination)"]=array("FAI233 Quakers","");
$religions["Quaker (Society of Friends)"]=array("FAI233","Quakers");
$religions["Quaker or associated with the Friends"]=array("FAI233","Quakers");
$religions["Roman Catholic"]=array("FAI217 Roman","Catholic");
$religions["Scottish Free Church"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Scottish Presbyterian"]=array("FAI2421 Church of Scotland","(Presbyterian)");
$religions["Spiritualism"]=array("FAI605","Other");
$religions["Spiritualist"]=array("FAI605","Other");
$religions["Swedenborgian"]=array("FAI23 Other","Christian");
$religions["Theosophist / mystical / Cambridge movement"]=array("FAI24 Protestants","");
$religions["uknown"]=array("FAI8","Unknown");
$religions["Uncommitted"]=array("FAI7 No","Religion");
$religions["Uncommitted (see Section 3, Additional Comments."]=array("FAI7 No","Religion");
$religions["Uncommitted."]=array("FAI7 No","Religion");
$religions["Unitarian"]=array("FAI24","Protestants");
$religions["Unitarian (Martineau)"]=array("FAI24","Protestants");
$religions["Unitarian [?]"]=array("FAI24","Protestants");
$religions["Unitarian Christian"]=array("FAI24","Protestants");
$religions["Unitarian; later Anglican"]=array("FAI24","Protestants");
$religions["Unitarianism, later Anglicanism"]=array("FAI24","Protestants");
$religions["unknown"]=array("FAI8","Unknown");
$religions["Unknown prob Christian"]=array("FAI8","Unknown");
$religions["unknown, probably Unitarian"]=array("FAI8","Unknown");
$religions["various"]=array("FAI8","Unknown");
$religions["wavering"]=array("FAI8","Unknown");
$religions["Wavering Christian?"]=array("FAI8","Unknown");
$religions["Wesleyan"]=array("FAI2441","Methodists");
$religions["Wesleyan Methodist"]=array("FAI2441","Methodists");
$religions["Wesleyan, later none"]=array("FAI2441","Methodists");
$religions["Weslyan Methodist"]=array("FAI2441","Methodists");

if(isset($argv[1])  && ($argv[1] != "")) {
	$csv_filename = $argv[1];
} else {
	$csv_filename = 'ukred-extract.csv';
}
$csv = new parseCSV($csv_filename);
//print_r($csv->data);

foreach($csv->data as $data) {
	$exp_time = "";
	$vt_time = array();

	// Ampersand protection for XML : & => &amp;
	foreach($data as $key=>$data_content) {
		$data[$key] = str_ireplace("&","&amp;", $data[$key]);
	}

// "Create" the document.
	$xml = new DOMDocument( "1.0", "UTF-8" );
	$xml->preserveWhiteSpace = false;
	$xml->formatOutput = true;

	$is_manuscript = false;
	if($data["manuscript_title"] != "") {
		var_dump($data["manuscript_title"]);
		$is_manuscript = true;
	}

	// TEI Headers elements
	$xml_tei = $xml->createElement( "TEI" );
		$xml_teiHeader = $xml->createElement("teiHeader");
			$xml_fileDesc = $xml->createElement("fileDesc");
				$xml_titleStmt = $xml->createElement("titleStmt");
					$xml_title = $xml->createElement("title", ($is_manuscript ? $data["manuscript_title"] : $data["title"]));
					$xml_author = $xml->createElement("author");
						$xml_persName0 = $xml->createElement("persName");
							$xml_forename0 = $xml->createElement("forename", $data["author_firstname"]);
							$xml_surname0 = $xml->createElement("surname", $data["author_surname"]);
						$xml_persName0->appendChild($xml_forename0);
						$xml_persName0->appendChild($xml_surname0);
					$xml_author->appendChild($xml_persName0);
				$xml_titleStmt->appendChild($xml_author);
				$xml_titleStmt->appendChild( $xml_title );
				$xml_sourceDesc = $xml->createElement("sourceDesc");
				$xml_fileDesc->appendChild( $xml_titleStmt );


				if(!$is_manuscript) {
					$xml_biblStruct = $xml->createElement("biblStruct");
					$xml_monogr = $xml->createElement("monogr");
					$xml_author1 = $xml->createElement("author");
					$xml_persName4 = $xml->createElement("persName");
					$xml_forename4 = $xml->createElement("forename", $data["author_firstname"]);
					$xml_surname4 = $xml->createElement("surname", $data["author_surname"]);
					$xml_persName4->appendChild($xml_forename4);
					$xml_persName4->appendChild($xml_surname4);
					$xml_author1->appendChild($xml_persName4);
					$xml_title1 = $xml->createElement("title", $data["title"]);
					$xml_imprint = $xml->createElement("imprint");
					if($data["editor_firstname"] || $data["editor_surname"]) {
						$xml_publisher = $xml->createElement("publisher", $data["editor_firstname"]." ".$data["editor_surname"]);
						$xml_imprint->appendChild($xml_publisher);
					}
					$xml_pubPlace = $xml->createElement("pubPlace", $data["place_of_publication"]);
					$xml_imprint->appendChild($xml_pubPlace);
					$xml_date1 = $xml->createElement("date", $data["date_of_publication"]);
					$xml_imprint->appendChild($xml_date1);
					$xml_availability = $xml->createElement("availability");
					$xml_biblScope = $xml->createElement("biblScope");
					$xml_monogr->appendChild($xml_author1);
					$xml_monogr->appendChild($xml_title1);
					$xml_monogr->appendChild($xml_imprint);
					$xml_monogr->appendChild($xml_availability);
					$xml_monogr->appendChild($xml_biblScope);
					$xml_biblStruct->appendChild($xml_monogr);
					$xml_sourceDesc->appendChild($xml_biblStruct);
				} else {
					$xml_msDesc = $xml->createElement("msDesc");
					$xml_msIdentifier = $xml->createElement("msIdentifier");
					$xml_msIdentifier_country = $xml->createElement("country");
					$xml_msIdentifier->appendChild($xml_msIdentifier_country);
					$xml_msIdentifier_settlement = $xml->createElement("settlement");
					$xml_msIdentifier->appendChild($xml_msIdentifier_settlement);
					$xml_msIdentifier_institution = $xml->createElement("institution");
					$xml_msIdentifier->appendChild($xml_msIdentifier_institution);
					$xml_msIdentifier_repository = $xml->createElement("repository", $data["location"]);
					$xml_msIdentifier->appendChild($xml_msIdentifier_repository);
					$xml_msIdentifier_collection = $xml->createElement("collection");
					$xml_msIdentifier->appendChild($xml_msIdentifier_collection);
					$xml_msIdentifier_idno = $xml->createElement("idno", $data["call_num"]);
					$xml_msIdentifier->appendChild($xml_msIdentifier_idno);
					$xml_msDesc->appendChild($xml_msIdentifier);
					/* Vu ici : http://www.tei-c.org/release/doc/tei-p5-doc/en/html/ref-msDesc.html
					 * <msContents>
                        <msItem>
                            <author>Geoffrey Chaucer</author>
                            <title>The Canterbury Tales</title>
                        </msItem>
					*/
					$xml_msContents = $xml->createElement("msContents");
					$xml_msItem= $xml->createElement("msItem");

					if($data["manuscript_title"]) {
						// Vu ici : http://www.tei-c.org/release/doc/tei-p5-doc/fr/html/MS.html#msid
						$xml_msItem_title = $xml->createElement("title", $data["manuscript_title"]);
						$xml_msItem->appendChild($xml_msItem_title);
					}
					if ($data["manuscript_firstname"] || $data["manuscript_surname"]) {
						$xml_msItem_author = $xml->createElement("author", $data["manuscript_firstname"]." ".$data["manuscript_surname"]);
						$xml_msItem->appendChild($xml_msItem_author);
					}
					$xml_msContents->appendChild($xml_msItem);
					$xml_msDesc->appendChild($xml_msContents);
					$xml_sourceDesc->appendChild($xml_msDesc);
				}
				$xml_fileDesc->appendChild( $xml_sourceDesc);

		$xml_teiHeader->appendChild( $xml_fileDesc );

			$xml_profileDesc = $xml->createElement("profileDesc");
				$xml_correspDesc = $xml->createElement("correspDesc");
					// Correspondant
					$xml_correspActionSending = $xml->createElement("correspAction");
					$xml_correspActionSending->setAttribute( "type", "sending" );
						$xml_persName1 = $xml->createElement("persName");
							$xml_forename1 = $xml->createElement("forename");
							$xml_surname1 = $xml->createElement("surname");
						$xml_persName1->appendChild($xml_forename1);
						$xml_persName1->appendChild($xml_surname1);
					$xml_correspActionSending->appendChild($xml_persName1);
				$xml_correspDesc->appendChild($xml_correspActionSending);
					// Receiver
					$xml_correspActionReceiving = $xml->createElement("correspAction");
					$xml_correspActionReceiving->setAttribute( "type", "receiving" );
						$xml_persName2 = $xml->createElement("persName");
							$xml_forename2 = $xml->createElement("forename");
							$xml_surname2 = $xml->createElement("surname");
						$xml_persName2->appendChild($xml_forename2);
						$xml_persName2->appendChild($xml_surname2);
					$xml_correspActionReceiving->appendChild($xml_persName2);
				$xml_correspDesc->appendChild($xml_correspActionReceiving);
				$xml_langUsage = $xml->createElement("langUsage");
			$xml_profileDesc->appendChild($xml_correspDesc);
			$xml_profileDesc->appendChild($xml_langUsage);
		$xml_teiHeader->appendChild( $xml_profileDesc );
			$xml_experienceDesc = $xml->createElement("experienceDesc");
				$xml_experience = $xml->createElement("experience");
					$xml_respStmt = $xml->createElement("respStmt");
						if($data["firstname"] || $data["surname"]) {
							$xml_resp = $xml->createElement("resp", "submitted by");
							$xml_persName3 = $xml->createElement("persName");
							$xml_forename3 = $xml->createElement("forename", $data["firstname"]);
							$xml_surname3 = $xml->createElement("surname", $data["surname"]);
							$xml_persName3->appendChild($xml_forename3);
							$xml_persName3->appendChild($xml_surname3);
							$xml_address3 = $xml->createElement("address", $data["address"]);
							$xml_address_line3 = $xml->createElement("address_line");
							$xml_address3->appendChild($xml_address_line3);
							$xml_email3 = $xml->createElement("email", $data["email"]);
							$xml_respStmt->appendChild($xml_resp);
							$xml_respStmt->appendChild($xml_persName3);
							$xml_respStmt->appendChild($xml_address3);
							$xml_respStmt->appendChild($xml_email3);
						}
						if($data["reviewed_by"]) {
							$xml_resp2 = $xml->createElement("resp", "reviewed by");
							$xml_persName8 = $xml->createElement("persName");
							$xml_forename8 = $xml->createElement("forename", "-");
							$xml_surname8 = $xml->createElement("surname", $data["reviewed_by"]);
							$xml_persName8->appendChild($xml_forename8);
							$xml_persName8->appendChild($xml_surname8);
							$xml_respStmt->appendChild($xml_resp2);
							$xml_respStmt->appendChild($xml_persName8);
							$xml_date_review = $xml->createElement("date", $data["status_updated"]);
							$xml_respStmt->appendChild($xml_date_review);

						}
					$vs_date_text="";
					$vs_date_when="";
					$vs_date_from="";
					$vs_date_to="";

					if(($data["date_reading_day"]!="") || ($data["date_reading_month"]!="") || ($data["date_reading_year"]!="")) {
						$vs_date_text=$data["date_reading_month"].". ".$data["date_reading_day"]." ".$data["date_reading_year"];
						//print_r(date_format(date_create($vs_date), "Y-m-d"));
						$vs_date_when = date_format(date_create($vs_date_text), "Y-m-d");
					} elseif (($data["date_reading_year_from"]!="")||($data["date_reading_year_to"]!="")) {
						$vs_date_text_from = $data["date_reading_month_from"]." ".$data["date_reading_day_from"]." ".$data["date_reading_year_from"];
						$vs_date_text_to = $data["date_reading_month_to"]." ".$data["date_reading_day_to"]." ".$data["date_reading_year_to"];
						$vs_date_text = $vs_date_text_from." - ".$vs_date_text_to;
						if(($data["date_reading_month_from"]!="") || ($data["date_reading_day_from"]!="") || ($data["date_reading_year_from"]!="") ) {
							$vs_date_from = date_format(date_create($vs_date_text_from), "Y-m-d");
						}
						if(($data["date_reading_month_to"]!="") || ($data["date_reading_day_to"]!="") || ($data["date_reading_year_to"]!="") ) {
							$vs_date_to = date_format(date_create($vs_date_text_to), "Y-m-d");
						}
					}
					if($vs_date_text) {
						$xml_date = $xml->createElement("date", $vs_date_text);
					} else {
						$xml_date = $xml->createElement("date");
					}
					if($vs_date_when) {
						$xml_date->setAttribute("when", $vs_date_when);
					}
					if($vs_date_from) {
						$xml_date->setAttribute("from", $vs_date_from);
					}
					if($vs_date_to) {
						$xml_date->setAttribute("to", $vs_date_to);
					}

					// Date unknown : http://www.tei-c.org/SIG/Libraries/teiinlibraries/main-driver.html
					if($data["date_reading_unknown"]=="Y") {
						$xml_date->setAttribute("cert", "unknown");
					}
					if($data["time_morning"] == "Y") {
						$vt_time[] = "in the morning".($data["time_morning_info"] ? " (".$data["time_morning_info"].")" : "");
					}
					if($data["time_afternoon"] == "Y") {
						$vt_time[] = "in the afternoon".($data["time_afternoon_info"] ? " (".$data["time_afternoon_info"].")" : "");
					}
					if($data["time_evening"] == "Y") {
						$vt_time[] = "in the evening".($data["time_evening_info"] ? " (".$data["time_evening_info"].")" : "");
					}
					if($data["time_daytime"] == "Y") {
						$vt_time[] = "during daytime".($data["time_daytime_info"] ? " (".$data["time_daytime_info"].")" : "");
					}

					if($data["time_night_time"] == "Y") {
						$vt_time[] = "in the morning".($data["time_night_time_info"] ? " (".$data["time_night_time_info"].")" : "");
					}
					$exp_time = implode(", ",$vt_time);
					//if($exp_time) {var_dump($exp_time);}

					$xml_time = $xml->createElement("time",$exp_time);
					//print_r($exp_time); die();

					$xml_reader = $xml->createElement("reader");
						$xml_persName5 = $xml->createElement("persName");
							$xml_forename5 = $xml->createElement("forename", $data["reader_firstname"]);
							$xml_surname5 = $xml->createElement("surname", $data["reader_surname"]);
						$xml_persName5->appendChild($xml_forename5);
						$xml_persName5->appendChild($xml_surname5);

						if($data["gender"] == "Male") {$vs_sex = "M"; }
						elseif($data["gender"] == "Female") {$vs_sex = "F"; }
						else {$vs_sex="";}
						$xml_reader_sex=$xml->createElement("sex", $vs_sex);

						if($data["birth_year"]) {
							$date = $data["birth_month"]." ".$data["birth_day"]." ".$data["birth_year"];
							$vs_birth = date('Y-m-d', strtotime($date));
						} else {
							$vs_birth = "";
						}
						$xml_reader_birth = $xml->createElement("birth", $vs_birth);

						$xml_reader_age=$xml->createElement("age", $data["age"]);
						$xml_reader->appendChild($xml_persName5);
						$xml_reader->appendChild($xml_reader_sex);
						$xml_reader->appendChild($xml_reader_age);
						$xml_reader->appendChild($xml_reader_birth);
						foreach($religions as $key=>$religion) {
							//var_dump($genres);
							if($data["religion"]==$key) {
								$religion_label = $religion[1];
								$religion_ref = $religion[0];
								$xml_reader_religion = $xml->createElement("faith", $religion_label);
								$xml_reader_religion->setAttribute("scheme","http://eured.univ-lemans.fr/ontologies/faith");
								$xml_reader_religion->setAttribute("ref",$religion_ref);
								$xml_reader->appendChild($xml_reader_religion);
							}
						}
						$xml_reader_country = $xml->createElement("country", $data["country_origin"]);
						$xml_reader->appendChild($xml_reader_country);


					$xml_listener = $xml->createElement("listener");
						$xml_persName6 = $xml->createElement("persName");
							$xml_forename6 = $xml->createElement("forename", $data["reader_firstname"]);
							$xml_surname6 = $xml->createElement("surname", $data["reader_surname"]);
						$xml_persName6->appendChild($xml_forename6);
						$xml_persName6->appendChild($xml_surname6);
					$xml_listener->appendChild($xml_persName6);


					$xml_place = $xml->createElement("place");
						if($data["place_specific_address"] == "Y") {
							$xml_placeName = $xml->createElement("placeName",$data["place_specific_address_info"]);
							$xml_placeName->setAttribute("type","street");
							$xml_place->appendChild($xml_placeName);
						}
						$xml_location = $xml->createElement("location");
							if(($data["x_coordinate"]>0)||($data["y_coordinate"]>0)) {
								$xml_geo = $xml->createElement("geo", $data["x_coordinate"].",".$data["y_coordinate"]." [".$data["z_coordinate"]."]");
								$xml_location->appendChild($xml_geo);
							}
							if($data["place_county"] == "Y") {
								$xml_country = $xml->createElement("country", $data["place_county_info"]);
								$xml_location->appendChild($xml_country);
							}
							if($data["place_city"] == "Y") {
								$xml_settlement = $xml->createElement("settlement", $data["place_city_info"]);
								$xml_settlement->setAttribute("type", "city");
								$xml_location->appendChild($xml_settlement);
							}
							$xml_district = $xml->createElement("district");
							$xml_location->appendChild($xml_district);
							if($data["place_location_dwelling"] == "Y") {
								$xml_place_location_dwelling = $xml->createElement("note", $data["place_location_dwelling_info"]);
								$xml_location->appendChild($xml_place_location_dwelling);
							}
							if($data["place_other"] == "Y") {
								$xml_place_other = $xml->createElement("note", $data["place_other_info"]);
								$xml_location->appendChild($xml_place_other);
							}
					$xml_place->appendChild($xml_location);

					$xml_textRead = $xml->createElement("textRead");
						$xml_textRead_author = $xml->createElement("author");
							$xml_persName7 = $xml->createElement("persName");
								$xml_forename7 = $xml->createElement("forename", $data["text_read_firstname"]);
								$xml_surname7 = $xml->createElement("surname", $data["text_read_surname"]);
							$xml_persName7->appendChild($xml_forename7);
							$xml_persName7->appendChild($xml_surname7);
						$xml_textRead_author->appendChild($xml_persName7);
						$xml_textRead->appendChild($xml_textRead_author);

						$xml_textRead_title = $xml->createElement("title", $data["text_read_title"]);
						$xml_textRead->appendChild($xml_textRead_title);

						foreach($genres as $key=>$genre) {
							//var_dump($genres);
							if($data[$key]=="Y") {
								$genre_label = $genre[1];
								$genre_ref = $genre[0];
								$xml_textRead_genre = $xml->createElement("genre", $genre_label);
								$xml_textRead_genre->setAttribute("scheme","http://eured.univ-lemans.fr/ontologies/genre");
								$xml_textRead_genre->setAttribute("ref",$genre_ref);
								$xml_textRead->appendChild($xml_textRead_genre);
							}
						}

						$xml_textRead_textProvenance = $xml->createElement("textProvenance");

						$xml_textRead_origLanguage = $xml->createElement("origLanguage");
							$xml_textRead_language=$xml->createElement("language");
						$xml_textRead_origLanguage->appendChild($xml_textRead_language);

						foreach($textforms as $key=>$textform) {
							//var_dump($genres);
							if($data[$key]=="Y") {
								$textform_label = $textform[1];
								$textform_ref = $textform[0];
								$xml_textRead_textForm = $xml->createElement("textForm", $textform_label);
								$xml_textRead_textForm->setAttribute("scheme","http://eured.univ-lemans.fr/ontologies/text_form");
								$xml_textRead_textForm->setAttribute("ref",$textform_ref);
								$xml_textRead->appendChild($xml_textRead_textForm);
							}
						}
						$xml_textRead_textForm = $xml->createElement("textForm");

						$xml_textRead_textStatus = $xml->createElement("textStatus");




					$xml_textRead->appendChild($xml_textRead_textProvenance);
					$xml_textRead->appendChild($xml_textRead_origLanguage);
					$xml_textRead->appendChild($xml_textRead_textForm);
					$xml_textRead->appendChild($xml_textRead_textStatus);


					$xml_readingExp = $xml->createElement("readingExp");
						$xml_experienceType = $xml->createElement("experienceType");
						$xml_posture = $xml->createElement("posture");
						$xml_lighting = $xml->createElement("lighting");
						$xml_environment = $xml->createElement("environment");
						$xml_intensity = $xml->createElement("intensity");
						$xml_emotion = $xml->createElement("emotion");
						$xml_testimony = $xml->createElement("testimony");
						$xml_sourceRelialabiblity = $xml->createElement("sourceRelialabiblity");
						$xml_expFrequency = $xml->createElement("expFrequency");
						$xml_note = $xml->createElement("note", $data["final_additional_comments"]);
					$xml_readingExp->appendChild($xml_experienceType);
					$xml_readingExp->appendChild($xml_posture);
					$xml_readingExp->appendChild($xml_lighting);
					$xml_readingExp->appendChild($xml_environment);
					$xml_readingExp->appendChild($xml_intensity);
					$xml_readingExp->appendChild($xml_emotion);
					$xml_readingExp->appendChild($xml_testimony);
					$xml_readingExp->appendChild($xml_sourceRelialabiblity);
					$xml_readingExp->appendChild($xml_expFrequency);
					$xml_readingExp->appendChild($xml_note);

				$xml_experience->appendChild($xml_respStmt);
				$xml_experience->appendChild($xml_date);
				$xml_experience->appendChild($xml_time);
				$xml_experience->appendChild($xml_reader);
				$xml_experience->appendChild($xml_listener);
				$xml_experience->appendChild($xml_place);
				$xml_experience->appendChild($xml_textRead);
				$xml_experience->appendChild($xml_readingExp);
			$xml_experienceDesc->appendChild($xml_experience);
		$xml_teiHeader->appendChild($xml_experienceDesc);

	$xml_tei->appendChild( $xml_teiHeader );
	//var_dump($data["evidence"]);
// Text elements
	$xml_text = $xml->createElement( "text" );
		$xml_body = $xml->createElement( "body" );
			if($data["vol_num"]) {
				$xml_vol_num_div = $xml->createElement( "div");
				$xml_vol_num_div->setAttribute("type", "volume");
				$xml_vol_num_div->setAttribute("n", $data["vol_num"]);
				$xml_body->appendChild($xml_vol_num_div);
			}
			$xml_p = $xml->createElement( "p" , $data["evidence"]);
			if($data["source_info"]!="") {
				// Documentation vue ici : http://www.tei-c.org/release/doc/tei-p5-doc/en/html/ref-div.html
				$xml_source_info_div = $xml->createElement( "div");
				$xml_source_info_div->setAttribute("type", "chapter");
				// Documentation vue ici : http://www.tei-c.org/release/doc/tei-p5-doc/en/html/ref-label.html
				$xml_source_info_div->setAttribute("label", $data["source_info"]);
				if($data["page_num"]) {
					$xml_page_num_div = $xml->createElement( "div");
					$xml_page_num_div->setAttribute("type", "page");
					$xml_page_num_div->setAttribute("n", $data["page_num"]);
					$xml_page_num_div->appendChild($xml_p);
					$xml_source_info_div->appendChild($xml_page_num_div);
				} else {
					$xml_source_info_div->appendChild($xml_p);
				}
				if($data["vol_num"]) {
					$xml_vol_num_div->appendChild($xml_source_info_div);
				} else {
					$xml_body->appendChild($xml_source_info_div);
				}
			} else {
				if($data["vol_num"]) {
					$xml_vol_num_div->appendChild($xml_p);
				} else {
					$xml_body->appendChild($xml_p);
				}
			}


	$xml_text->appendChild($xml_body);
	$xml_tei->appendChild( $xml_text );


	$xml->appendChild( $xml_tei );


	$vs_filename = "xml/ukred-".$data["id"].".xml";
	//print $xml->saveXML();
	$xml->save($vs_filename);

}

?>