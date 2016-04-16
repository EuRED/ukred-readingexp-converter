<?php
/**
 * EuRED - European Reading Experience Database
 * UK Red CSV converter
 * Gautier MICHELIN
 */
error_reporting(E_ERROR);
require_once 'vendor/autoload.php';

$csv = new parseCSV('ukred-extract.csv');
print_r($csv->data);

foreach($csv->data as $data) {
	// Set the content type to be XML, so that the browser will   recognise it as XML.
	header( "content-type: application/xml; charset=UTF-8" );

// "Create" the document.
	$xml = new DOMDocument( "1.0", "UTF-8" );
	$xml->preserveWhiteSpace = false;
	$xml->formatOutput = true;

	// TEI Headers elements
	$xml_tei = $xml->createElement( "TEI" );
		$xml_teiHeader = $xml->createElement("teiHeader");
			$xml_fileDesc = $xml->createElement("fileDesc");
				$xml_titleStmt = $xml->createElement("titleStmt");
					$xml_title = $xml->createElement("title", $data[title]);
					$xml_author = $xml->createElement("author");
						$xml_persName0 = $xml->createElement("persName");
							$xml_forename0 = $xml->createElement("forename", $data[author_firstname]);
							$xml_surname0 = $xml->createElement("surname", $data[author_surname]);
						$xml_persName0->appendChild($xml_forename0);
						$xml_persName0->appendChild($xml_surname0);
					$xml_author->appendChild($xml_persName0);
				$xml_titleStmt->appendChild($xml_author);
				$xml_titleStmt->appendChild( $xml_title );
				$xml_sourceDesc = $xml->createElement("sourceDesc");
					$xml_biblStruct = $xml->createElement("biblStruct");
						$xml_monogr = $xml->createElement("monogr");
							$xml_author1 = $xml->createElement("author");
								$xml_persName4 = $xml->createElement("persName");
									$xml_forename4 = $xml->createElement("forename", $data[author_firstname]);
									$xml_surname4 = $xml->createElement("surname", $data[author_surname]);
								$xml_persName4->appendChild($xml_forename4);
								$xml_persName4->appendChild($xml_surname4);
							$xml_author1->appendChild($xml_persName4);
							$xml_title1 = $xml->createElement("title", $data[title]);
							$xml_imprint = $xml->createElement("imprint");
								$xml_publisher = $xml->createElement("publisher");
	                            $xml_pubPlace = $xml->createElement("pubPlace", $data[place_of_publication]);
								$xml_date1 = $xml->createElement("date", $data[date_of_publication]);
							$xml_imprint->appendChild($xml_publisher);
							$xml_imprint->appendChild($xml_pubPlace);
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
			$xml_fileDesc->appendChild( $xml_titleStmt );
			$xml_fileDesc->appendChild( $xml_sourceDesc );
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
						$xml_resp = $xml->createElement("resp");
						$xml_persName3 = $xml->createElement("persName");
							$xml_forename3 = $xml->createElement("forename", $data[firstname]);
							$xml_surname3 = $xml->createElement("surname", $data[surname]);
						$xml_persName3->appendChild($xml_forename3);
						$xml_persName3->appendChild($xml_surname3);
						$xml_address3 = $xml->createElement("address", $data[address]);
							$xml_address_line3 = $xml->createElement("address_line");
						$xml_address3->appendChild($xml_address_line3);
						$xml_email3 = $xml->createElement("email", $data[email]);
					$xml_respStmt->appendChild($xml_resp);
					$xml_respStmt->appendChild($xml_persName3);
					$xml_respStmt->appendChild($xml_address3);
					$xml_respStmt->appendChild($xml_email3);

					$xml_date = $xml->createElement("date");

					$xml_time = $xml->createElement("time");

					$xml_reader = $xml->createElement("reader");
						$xml_persName5 = $xml->createElement("persName");
							$xml_forename5 = $xml->createElement("forename", $data[reader_firstname]);
							$xml_surname5 = $xml->createElement("surname", $data[reader_surname]);
						$xml_persName5->appendChild($xml_forename5);
						$xml_persName5->appendChild($xml_surname5);

						if($data[gender] == "Male") {$vs_sex = "M"; }
						elseif($data[gender] == "Female") {$vs_sex = "F"; }
						else {$vs_sex="";}
						$xml_reader_sex=$xml->createElement("sex", $vs_sex);

						if($data[birth_year]) {
							$date = $data[birth_month]." ".$data[birth_day]." ".$data[birth_year];
							$vs_birth = date('Y-m-d', strtotime($date));
						} else {
							$vs_birth = "";
						}
						$xml_reader_birth = $xml->createElement("birth", $vs_birth);

						$xml_reader_age=$xml->createElement("age", $data[age]);
					$xml_reader->appendChild($xml_persName5);
					$xml_reader->appendChild($xml_reader_sex);
					$xml_reader->appendChild($xml_reader_age);
					$xml_reader->appendChild($xml_reader_birth);

					$xml_listener = $xml->createElement("listener");
						$xml_persName6 = $xml->createElement("persName");
							$xml_forename6 = $xml->createElement("forename", $data[reader_firstname]);
							$xml_surname6 = $xml->createElement("surname", $data[reader_surname]);
						$xml_persName6->appendChild($xml_forename6);
						$xml_persName6->appendChild($xml_surname6);
					$xml_listener->appendChild($xml_persName6);


					$xml_place = $xml->createElement("place");

					$xml_textRead = $xml->createElement("textRead");
						$xml_textRead_author = $xml->createElement("author");
							$xml_persName7 = $xml->createElement("persName");
								$xml_forename7 = $xml->createElement("forename", $data[text_read_firstname]);
								$xml_surname7 = $xml->createElement("surname", $data[text_read_surname]);
							$xml_persName7->appendChild($xml_forename7);
							$xml_persName7->appendChild($xml_surname7);
						$xml_textRead_author->appendChild($xml_persName7);

						$xml_textRead_title = $xml->createElement("title");

						$xml_textRead_genre = $xml->createElement("genre");

						$xml_textRead_textProvenance = $xml->createElement("textProvenance");

						$xml_textRead_origLanguage = $xml->createElement("origLanguage");
							$xml_textRead_language=$xml->createElement("language");
						$xml_textRead_origLanguage->appendChild($xml_textRead_language);

						$xml_textRead_textForm = $xml->createElement("textForm");

						$xml_textRead_textStatus = $xml->createElement("textStatus");

					$xml_textRead->appendChild($xml_textRead_author);
					$xml_textRead->appendChild($xml_textRead_title);
					$xml_textRead->appendChild($xml_textRead_genre);
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
						$xml_note = $xml->createElement("note");
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

// Text elements
	$xml_text = $xml->createElement( "text" );
		$xml_body = $xml->createElement( "body" );
			$xml_p = $xml->createElement( "p" , $data["evidence"]);
		$xml_body->appendChild($xml_p);
	$xml_text->appendChild($xml_body);
	$xml_tei->appendChild( $xml_text );


	$xml->appendChild( $xml_tei );


	$vs_filename = "xml/".$data[id].".xml";
	//print $xml->saveXML();
	$xml->save($vs_filename);

}

?>