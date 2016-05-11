<?php
/**
 * EuRED - European Reading Experience Database
 * UK Red CSV converter
 * Gautier MICHELIN
 */
//error_reporting(E_ERROR);
require_once 'vendor/autoload.php';

require_once("mappings.php");

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

	$vs_filename = "xml/ukred-".$data["id"].".xml";

	// Ampersand protection for XML : & => &amp;
	foreach($data as $key=>$data_content) {
		$data[$key] = str_ireplace("&","&amp;", $data[$key]);
	}

// "Create" the document.
	$implementation = new DOMImplementation();

	$dtd = $implementation->createDocumentType('TEI',"customisation-tei/tei_readingExp.dtd");

	$xml = $implementation->createDocument("", "", $dtd);
	$xml->encoding = 'utf-8';

	$xml->preserveWhiteSpace = false;
	$xml->formatOutput = true;

	$is_manuscript = false;
	if($data["manuscript_title"] != "") {
		//var_dump($data["manuscript_title"]);
		$is_manuscript = true;
	}

	// TEI Headers elements
	$xml_tei = $xml->createElement( "TEI" );
		$xml_tei->setAttribute("xmlns", "http://www.tei-c.org/ns/1.0");
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
/*
 *   <notesStmt> <note>Brief notes on the text are in a supplementary file.</note></notesStmt>
   */
				$xml_notesStmt= $xml->createElement("notesStmt");
				$xml_note=$xml->createElement("note", $vs_filename);
				$xml_notesStmt->appendChild($xml_note);
				$xml_fileDesc->appendChild($xml_notesStmt);
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
				$xml_experience->setAttribute("ref", "ukred-".$data["id"]);
					$xml_respStmt = $xml->createElement("respStmt");
					$xml_respStmt ->setAttribute("resp","submitter");
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
					$xml_respStmt2 = $xml->createElement("respStmt");
					$xml_respStmt2->setAttribute("resp","editor");
						if($data["reviewed_by"]) {
							$xml_resp2 = $xml->createElement("resp", "reviewed by");
							$xml_persName8 = $xml->createElement("persName");
							$xml_forename8 = $xml->createElement("forename", "-");
							$xml_surname8 = $xml->createElement("surname", $data["reviewed_by"]);
							$xml_persName8->appendChild($xml_forename8);
							$xml_persName8->appendChild($xml_surname8);
							$xml_respStmt2->appendChild($xml_resp2);
							$xml_respStmt2->appendChild($xml_persName8);
							$xml_date_review = $xml->createElement("date", $data["status_updated"]);
							$xml_respStmt2->appendChild($xml_date_review);

						}
					$vs_date_text="";
					$vs_date_when="";
					$vs_date_from="";
					$vs_date_to="";

					if(($data["date_reading_day"]!="") || ($data["date_reading_month"]!="") || ($data["date_reading_year"]!="")) {
						$vs_date_text=$data["date_reading_month"].". ".$data["date_reading_day"]." ".$data["date_reading_year"];
						//print_r(date_format(date_create($vs_date), "Y-m-d"));
						$date = date_create($vs_date_text);
						if($date !== false) {
							$vs_date_when = date_format($date, "Y-m-d");
						}
					} elseif (($data["date_reading_year_from"]!="")||($data["date_reading_year_to"]!="")) {
						$vs_date_text_from = $data["date_reading_month_from"]." ".$data["date_reading_day_from"]." ".$data["date_reading_year_from"];
						$vs_date_text_to = $data["date_reading_month_to"]." ".$data["date_reading_day_to"]." ".$data["date_reading_year_to"];
						$vs_date_text = $vs_date_text_from." - ".$vs_date_text_to;
						if(($data["date_reading_month_from"]!="") || ($data["date_reading_day_from"]!="") || ($data["date_reading_year_from"]!="") ) {
							$date = date_create($vs_date_text_from);
							if($date !== false) {
								$vs_date_from = date_format($date, "Y-m-d");
							}
						}
						if(($data["date_reading_month_to"]!="") || ($data["date_reading_day_to"]!="") || ($data["date_reading_year_to"]!="") ) {
							$date = date_create($vs_date_text_to);
							if($date !== false) {
								$vs_date_to = date_format($date, "Y-m-d");
							}
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
					// 8-12
					if($data["time_morning"] == "Y") {
						$vt_time[] = "in the morning".($data["time_morning_info"] ? " (".$data["time_morning_info"].")" : "");
					}
					// 13-17
					if($data["time_afternoon"] == "Y") {
						$vt_time[] = "in the afternoon".($data["time_afternoon_info"] ? " (".$data["time_afternoon_info"].")" : "");
					}
					// 18-22
					if($data["time_evening"] == "Y") {
						$vt_time[] = "in the evening".($data["time_evening_info"] ? " (".$data["time_evening_info"].")" : "");
					}
					// 8-22
					if($data["time_daytime"] == "Y") {
						$vt_time[] = "during daytime".($data["time_daytime_info"] ? " (".$data["time_daytime_info"].")" : "");
					}
					// 23-7
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

						foreach($occupation as $key=>$occ) {
							$data["occupation"]=str_replace("\"","",$data["occupation"]);
							if($data["occupation"]==$key) {
								$occupation_label = $occ[1];
								$occupation_ref = $occ[0];
								$xml_reader_occupation = $xml->createElement("occupation", $occupation_label);
								$xml_reader_occupation->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/occupation");
								$xml_reader_occupation->setAttribute("ref",$occupation_ref);
								$xml_reader->appendChild($xml_reader_occupation);
								break;
							}
						}

						$xml_reader_education = $xml->createElement("education");
						$xml_reader_education->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/education");
						$xml_reader->appendChild($xml_reader_education);

						$xml_reader->appendChild($xml_reader_birth);
						foreach($religions as $key=>$religion) {
							//var_dump($genres);
							if($data["religion"]==$key) {
								$religion_label = $religion[1];
								$religion_ref = $religion[0];
								$xml_reader_religion = $xml->createElement("faith", $religion_label);
								$xml_reader_religion->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/faith");
								$xml_reader_religion->setAttribute("ref",$religion_ref);
								$xml_reader->appendChild($xml_reader_religion);
							}
						}
						$xml_reader_country = $xml->createElement("country", $data["country_origin"]);
						$xml_reader->appendChild($xml_reader_country);
						if($data["reader_info"]!="") {
							$xml_reader_note = $xml->createElement("note", $data["reader_info"]);
							$xml_reader->appendChild($xml_reader_note);
						}
						$xml_reader_status = $xml->createElement("readerStatus");
						$xml_reader_status->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/reader_status");
						$xml_reader->appendChild($xml_reader_status);
	

					$xml_listener = $xml->createElement("listener");
						if(($data["listener_firstname"] != "") || ($data["listener_surname"] != "")) {
							$xml_persName6 = $xml->createElement("persName");
							$xml_forename6 = $xml->createElement("forename", $data["listener_firstname"]);
							$xml_surname6 = $xml->createElement("surname", $data["listener_surname"]);
							$xml_persName6->appendChild($xml_forename6);
							$xml_persName6->appendChild($xml_surname6);
							$xml_listener->appendChild($xml_persName6);

							$xml_listener_occupation = $xml->createElement("occupation");
							$xml_listener_occupation->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/occupation");
							$xml_listener->appendChild($xml_listener_occupation);

							$xml_listener_education = $xml->createElement("education");
							$xml_listener_education->setAttribute("scheme","http://eured.univ-lemans.fr/education/faith");
							$xml_listener->appendChild($xml_listener_education);

							$xml_listener_religion = $xml->createElement("faith");
							$xml_listener_religion->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/faith");
							$xml_listener->appendChild($xml_listener_religion);

							$xml_listenerStatus = $xml->createElement("listenerStatus");
							$xml_listenerStatus->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/listener_status");
							$xml_listener->appendChild($xml_listenerStatus);

						}
						if($data["listeners_present"]!="") {
							$xml_note_listeners = $xml->createElement("note", $data["listeners_present"]);
							$xml_listener->appendChild($xml_note_listeners);
						}


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
								$xml_textRead_genre->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/genre");
								$xml_textRead_genre->setAttribute("ref",$genre_ref);
								$xml_textRead->appendChild($xml_textRead_genre);
							}
						}

						foreach($provenances as $key=>$provenance) {
							//var_dump($genres);
							if($data["provenance"]==$key) {
								$provenance_label = $provenance[1];
								$provenance_ref = $provenance[0];
								$xml_textRead_textProvenance = $xml->createElement("textProvenance", $provenance_label);
								$xml_textRead_textProvenance->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/faith");
								$xml_textRead_textProvenance->setAttribute("ref",$provenance_ref);
								$xml_textRead_textProvenance->setAttribute("scheme", "http://eured.univ-lemans.fr/thesaurus/text_provenance");
								$xml_textRead->appendChild($xml_textRead_textProvenance);
								break;
							}
						}


						$xml_textRead_origLanguage = $xml->createElement("origLanguage");
						$xml_textRead_language=$xml->createElement("language");
						$xml_textRead_origLanguage->appendChild($xml_textRead_language);

						foreach($textforms as $key=>$textform) {
							//var_dump($genres);
							if($data[$key]=="Y") {
								$textform_label = $textform[1];
								$textform_ref = $textform[0];
								$xml_textRead_textForm = $xml->createElement("textForm", $textform_label);
								$xml_textRead_textForm->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/text_form");
								$xml_textRead_textForm->setAttribute("ref",$textform_ref);
								$xml_textRead->appendChild($xml_textRead_textForm);
							}
						}


						$xml_textRead_textStatus = $xml->createElement("textStatus");
						$xml_textRead_textStatus->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/text_status");


					$xml_textRead->appendChild($xml_textRead_origLanguage);
					$xml_textRead->appendChild($xml_textRead_textStatus);


					$xml_readingExp = $xml->createElement("readingExp");
					if($data["type_of_experience_reader_1_silent"]=="Y") {
						$xml_experienceType = $xml->createElement("experienceType","Silent");
						$xml_experienceType->setAttribute("scheme", "http://eured.univ-lemans.fr/thesaurus/experience_type");
						if($data["type_of_experience_reader_2_solitary"]=="Y") {
							$xml_experienceType->setAttribute("ref", "EXT122");
						} elseif($data["type_of_experience_reader_2_in_company"]=="Y") {
							$xml_experienceType->setAttribute("ref", "EXT112");
						} else {
							$xml_experienceType->setAttribute("ref", "EXT132");
						}
						$xml_readingExp->appendChild($xml_experienceType);
					}
					if($data["type_of_experience_reader_1_aloud"]=="Y") {
						$xml_experienceType = $xml->createElement("experienceType","Aloud");
						$xml_experienceType->setAttribute("scheme", "http://eured.univ-lemans.fr/thesaurus/experience_type");
						if($data["type_of_experience_reader_2_solitary"]=="Y") {
							$xml_experienceType->setAttribute("ref", "EXT121");
						} elseif($data["type_of_experience_reader_2_in_company"]=="Y") {
							$xml_experienceType->setAttribute("ref", "EXT111");
						} else {
							$xml_experienceType->setAttribute("ref", "EXT131");
						}
						$xml_readingExp->appendChild($xml_experienceType);
					}
					if($data["type_of_experience_reader_1_unknown"]=="Y") {
						$xml_experienceType = $xml->createElement("experienceType","Unknown");
						$xml_experienceType->setAttribute("scheme", "http://eured.univ-lemans.fr/thesaurus/experience_type");
						if($data["type_of_experience_reader_2_solitary"]=="Y") {
							$xml_experienceType->setAttribute("ref", "EXT123");
						} elseif($data["type_of_experience_reader_2_in_company"]=="Y") {
							$xml_experienceType->setAttribute("ref", "EXT113");
						} else {
							$xml_experienceType->setAttribute("ref", "EXT13");
						}
						$xml_readingExp->appendChild($xml_experienceType);
					}

						$xml_posture = $xml->createElement("posture");
						$xml_posture->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/posture");

						$xml_lighting = $xml->createElement("lighting");
						$xml_lighting->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/lighting");
						$xml_environment = $xml->createElement("environment");
						$xml_environment->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/environment");
						$xml_intensity = $xml->createElement("intensity");
						$xml_intensity->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/intensity");
						$xml_emotion = $xml->createElement("emotion");
						$xml_emotion->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/emotion");
						$xml_testimony = $xml->createElement("testimony");
						$xml_testimony->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/testimony");
						$xml_sourceReliability = $xml->createElement("sourceReliability");
						$xml_sourceReliability->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/source_reliability");

						$vs_frequency_label="";
						$vs_frequency_ref="";
						if($data["type_of_experience_reader_3"]=="NULL" || $data["type_of_experience_reader_3"]=="unknown") {
							$vs_frequency_label="Unknown";
							$vs_frequency_ref="EXF3";
						}
						if($data["type_of_experience_reader_3"]=="serial event") {
							$vs_frequency_label="Serial event";
							$vs_frequency_ref="EXF1";
						}
						if($data["type_of_experience_reader_3"]=="single event") {
							$vs_frequency_label="Single event";
							$vs_frequency_ref="EXF2";
						}
						$xml_expFrequency = $xml->createElement("expFrequency", $vs_frequency_label );
						$xml_expFrequency->setAttribute("scheme","http://eured.univ-lemans.fr/thesaurus/experience_frequency");
						if($vs_frequency_ref!="") {
							$xml_expFrequency->setAttribute("ref",$vs_frequency_ref);
						}

						$xml_note = $xml->createElement("note", $data["final_additional_comments"]);

					$xml_readingExp->appendChild($xml_posture);
					$xml_readingExp->appendChild($xml_lighting);
					$xml_readingExp->appendChild($xml_environment);
					$xml_readingExp->appendChild($xml_intensity);
					$xml_readingExp->appendChild($xml_emotion);
					$xml_readingExp->appendChild($xml_testimony);
					$xml_readingExp->appendChild($xml_sourceReliability);
					$xml_readingExp->appendChild($xml_expFrequency);
					$xml_readingExp->appendChild($xml_note);

				$xml_experience->appendChild($xml_respStmt);
				$xml_experience->appendChild($xml_respStmt2);
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
			$evidence = str_replace('""','"',$data["evidence"]);
			$evidence = str_replace("'",'&quot;',$data["evidence"]);
			$xml_ptr = $xml->createElement("ptr", $evidence);
			$xml_ptr->setAttribute("target", "ukred-".$data["id"]);
			$xml_p = $xml->createElement( "p");
			$xml_p->appendChild($xml_ptr);
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


	//print $xml->saveXML();
	$xml->save($vs_filename);

}

?>