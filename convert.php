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
	$xml_persName0 = $xml->createElement("persName");
	$xml_forename0 = $xml->createElement("forename", $data[author_firstname]);
	$xml_surname0 = $xml->createElement("surname", $data[author_surname]);
	$xml_author = $xml->createElement("author");

	$xml_persName0->appendChild($xml_forename0);
	$xml_persName0->appendChild($xml_surname0);
	$xml_author->appendChild($xml_persName0);
	$xml_titleStmt->appendChild($xml_author);

	// Ajout titleStmt à fileDesc
	$xml_titleStmt->appendChild( $xml_title );
	$xml_fileDesc->appendChild( $xml_titleStmt );


	$xml_sourceDesc = $xml->createElement("sourceDesc");

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

//
	$xml_langUsage = $xml->createElement("langUsage");

	$xml_experienceDesc = $xml->createElement("experienceDesc");
	$xml_experience = $xml->createElement("experience");
	$xml_respStmt = $xml->createElement("respStmt");

	$xml_persName3 = $xml->createElement("persName");
	$xml_forename3 = $xml->createElement("forename", $data[firstname]);
	$xml_surname3 = $xml->createElement("surname", $data[surname]);
	$xml_address3 = $xml->createElement("address", $data[address]);
	$xml_email3 = $xml->createElement("email", $data[email]);
	$xml_address_line3 = $xml->createElement("address_line");

	$xml_persName3->appendChild($xml_forename3);
	$xml_persName3->appendChild($xml_surname3);
	$xml_resp = $xml->createElement("resp");

	$xml_respStmt->appendChild($xml_resp);
	$xml_respStmt->appendChild($xml_persName3);
	$xml_address3->appendChild($xml_address_line3);
	$xml_respStmt->appendChild($xml_address3);
	$xml_respStmt->appendChild($xml_email3);

	$xml_date = $xml->createElement("date");
	$xml_time = $xml->createElement("time");
	$xml_reader = $xml->createElement("reader");
	$xml_listener = $xml->createElement("listener");
	$xml_place = $xml->createElement("place");
	$xml_textRead = $xml->createElement("textRead");
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

// Text elements
	$xml_text = $xml->createElement( "text" );
	$xml_body = $xml->createElement( "body" );
	$xml_p = $xml->createElement( "p" , $data["evidence"]);

// Adding tags as a structure
	$xml_fileDesc->appendChild( $xml_sourceDesc );


	$xml_teiHeader->appendChild( $xml_fileDesc );


	$xml_profileDesc->appendChild($xml_correspDesc);
	$xml_profileDesc->appendChild($xml_langUsage);
	$xml_teiHeader->appendChild( $xml_profileDesc );
	$xml_experience->appendChild($xml_respStmt);
	$xml_experience->appendChild($xml_date);
	$xml_experience->appendChild($xml_time);
	$xml_experience->appendChild($xml_reader);
	$xml_experience->appendChild($xml_listener);
	$xml_experience->appendChild($xml_place);
	$xml_experience->appendChild($xml_textRead);
	$xml_experience->appendChild($xml_readingExp);
	$xml_experience->appendChild($xml_experienceType);
	$xml_experience->appendChild($xml_posture);
	$xml_experience->appendChild($xml_lighting);
	$xml_experience->appendChild($xml_environment);
	$xml_experience->appendChild($xml_intensity);
	$xml_experience->appendChild($xml_emotion);
	$xml_experience->appendChild($xml_testimony);
	$xml_experience->appendChild($xml_sourceRelialabiblity);
	$xml_experience->appendChild($xml_expFrequency);
	$xml_experience->appendChild($xml_note);

	$xml_experienceDesc->appendChild($xml_experience);

	$xml_teiHeader->appendChild($xml_experienceDesc);

	$xml_tei->appendChild( $xml_teiHeader );

	$xml_body->appendChild($xml_p);
	$xml_text->appendChild($xml_body);

	$xml->appendChild( $xml_tei );
	$xml->appendChild( $xml_text );

	/*$xml_track = $xml->createElement( "Track", "The ninth symphony" );

	// Set the attributes.
	$xml_track->setAttribute( "length", "0:01:15" );
	$xml_track->setAttribute( "bitrate", "64kb/s" );
	$xml_track->setAttribute( "channels", "2" );

	// Create another element, just to show you can add any (realistic to computer) number of sublevels.
	$xml_note = $xml->createElement( "Note", "The last symphony composed by Ludwig van Beethoven." );

	// Append the whole bunch.
	$xml_track->appendChild( $xml_note );
	$xml_album->appendChild( $xml_track );

	// Repeat the above with some different values..
	$xml_track = $xml->createElement( "Track", "Highway Blues" );

	$xml_track->setAttribute( "length", "0:01:33" );
	$xml_track->setAttribute( "bitrate", "64kb/s" );
	$xml_track->setAttribute( "channels", "2" );
	$xml_album->appendChild( $xml_track );*/

//$xml->appendChild( $xml_album );

// Parse the XML.
	$vs_filename = "xml/".$data[id].".xml";
	//print $xml->saveXML();
	$xml->save($vs_filename);

}

?>