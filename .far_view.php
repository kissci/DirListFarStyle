<?
/*
	HTML Dir List - FAR style
	https://github.com/kissci/DirListFarStyle/
*/


$_SETTING['enableeditfiles'] = true;


//define variables
if ( ! preg_match('/^(dirlist|image|fileedit|fileview)$/', $_GET['mode'])  ) {
	$_GET['mode'] = 'dirlist';
}

if ($_GET['startdir']) {
	$startdir = './'.$_GET['startdir'];
	$startdir = preg_replace('/[\/]+/', '/', $_GET['startdir']);
	$dir_count = preg_match_all('/\//', $startdir, $match);
	while ($dir_count--) {
		$basedir .= '../';
	}
} else {
	$startdir = './';
	$basedir = './';
}


//RETURN IMAGE
if($_GET['mode'] == 'image' && isset($_GET['image'])) {
	// http://greg-j.com/projects/phpdl/PHPDL-v2.php
	// Accomidate uppercase & lowercase file extensions
	$image = strtolower($_GET['image']);
	// Set filetypes (most of this list is from http://www.filezed.com)
	$filetype = array(
		'text'		=> array('doc', 'docx', 'txt', 'rtf', 'odf', 'text', 'nfo', 'info', 'log'),
		'audio'		=> array('aac', 'mp3', 'wav', 'wma', 'm4p'),
		'graphic'	=> array('ai', 'bmp', 'eps', 'gif', 'ico', 'jpg', 'jpeg', 'png', 'psd', 'psp', 'raw', 'tga', 'tif', 'tiff'),
		'video'		=> array('mv4', 'bup', 'mkv', 'ifo', 'flv', 'vob', '3g2', 'bik', 'xvid', 'divx', 'wmv', 'avi', '3gp', 'mp4', 'mov', '3gpp', '3gp2', 'swf', 'mpg', 'mpeg'),
		'archive'	=> array('7z', 'dmg', 'rar', 'sit', 'zip', 'bzip', 'gz', 'tar'),
		'app'		=> array('exe', 'msi', 'mse', 'bat'),
		'script'	=> array('js', 'jsp', 'asp', 'aspx', 'php', 'css', 'sh', 'pl'),
		'xml'		=> array('xml'),
		'html'		=> array('html', 'htm', 'xhtml')
	);

	// Set the mimetype and cache the image for a year so we don't have to call them again.
	header("Content-type: image/png");
	header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 60 * 60 *24 * 365) . ' GMT');

	// Deliver the correct image ...
	if($image == '.')					echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAk1JREFUeNqMU01oE0EU/mY2u22qMSE2UaFKiwdLD0WE+nPx6MFDQfGmBw9evSmKeBE8C/XixZvowR+QXlQQb14KaiAnY9OKjU0Q11hSN012Z8b3JrtJWhBc+JidN+/75nvv7YrKggQ/QuAiLYfwf883Y/CYX1ImjlBgcvLC/bvd5hrC1g+4mSK87ASt+yGkM6A6DioPz91Otiml+0fS230A7tg+GGgSqWPLX8Vm9T1yM/PkUPScui6II/skFoghtYqgux2Ybgh3tIDM5Cm021uoN36h+bsFe07g3IQ37MAxSoFhS7J9EWi1/mAsDLFJyKRdSIoRp19TKtohwDf07UmJIOhgJArtXtFqSIA4DvWM+0YCaiCgVWiTBgoCId2sYlF7RjHisIOjJFCS7CBGStOJjqIhKBKglUQSGNrP3YxuUP4ltdOBiZtkL6dxtfwGCXBZSQldGqnARruduNgmQA7olrgErr/07hnGD58kYgTPc2wJkr6JZhCwQMrmfVoFb2yAbasY/B5ycCRjRXO7XLsawpWVvTafefL6I42PJNKJhNebcxgjQsQ90VEPcXlaK/h+YPOZx19U+tYTnd8IsIfnomnIOv4eNDXJdbxtkBC49ir7/HUJL4iX5jpGCfkPK2gU374sH5k9fjCbL+YEidW+fvlZKt8rc63jGXSSZi030HjwRlWYywJNxud1c/VYdWm+vrx0JleYmJ6anpsiM9U7T9Xl0zPSP39C9AUod9D54X+ULC/SfBfXv9dma2u1s1qjQGGf0PnXf/1XgAEADr97lE6is6IAAAAASUVORK5CYII=');
	elseif($image == 'pdf')					echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAHhSURBVDjLjZPLSxtRFIfVZRdWi0oFBf+BrhRx5dKVYKG4tLhRqlgXPmIVJQiC60JCCZYqFHQh7rrQlUK7aVUUfCBRG5RkJpNkkswrM5NEf73n6gxpHujAB/fOvefjnHM5VQCqCPa1MNoZnU/Qxqhx4woE7ZZlpXO53F0+n0c52Dl8Pt/nQkmhoJOCdUWBsvQJ2u4ODMOAwvapVAqSJHGJKIrw+/2uxAmuJgFdMDUVincSxvEBTNOEpmlIp9OIxWJckMlkoOs6AoHAg6RYYNs2kp4RqOvfuIACVFVFPB4vKYn3pFjAykDSOwVta52vqW6nlEQiwTMRBKGygIh9GEDCMwZH6EgoE+qHLMuVBdbfKwjv3yE6Ogjz/PQ/CZVDPSFRRYE4/RHy1y8wry8RGWGSqyC/nM1meX9IQpQV2JKIUH8vrEgYmeAFwuPDCHa9QehtD26HBhCZnYC8ucGzKSsIL8wgsjiH1PYPxL+vQvm5B/3sBMLyIm7GhhCe90BaWykV/Gp+VR9oqPVe9vfBTsruM1HtBKVPmFIUNusBrV3B4ev6bsbyXlPdkbr/u+StHUkxruBPY+0KY8f38oWX/byvNAdluHNLeOxDB+uyQQfPCWZ3NT69BYJWkjxjnB1o9Fv/ASQ5s+ABz8i2AAAAAElFTkSuQmCC');
	elseif($image == 'download')				echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAftJREFUeNqkU0trE1EUPnceIWbRTMe0625ciZDfIM1KKKm/oP0JXXYjxY1L+w+s4EaoEAQpuFE3IqJSWhDpooxYiAvtI5kkdzL34TlnOpNJZ+lhDvd1zne/8825wloL/2NePnnbe9UOW0vdhaAZLTSDSAhnLnAyGQej4bDdP/sVra6t7+X7ghi82X+5EYbhM6M13Ll7D8LlZUjGY6CzCY6e74M1Bg4/f4L6rQaMRvFeZ219kwD4mlqt9jRNU1AIoDGwbB8/vIOjr194rvE8Hg7A87yN/RfPuzMA3w/o9tzLdjUYQBzHBQCxmiYJjtAuNMgPSE9iMmeohcSE6TRhho4QYIyFIQIXAEopXhDI6ckPnruug4EG7nc6vP5+fMRrhU5xeakZANHGTYOepgqOv2HNlj7LSeY6iYxut9Yw61kJSnMwfcaa68AsKEtmfkUygSmtZgAykRicHQissbm4CHMNhvPzv3+wVM0XcAm6VML5xQUn3m4twYPuQ6g3GpWOk9gPB6978Lvfz9ipOQZTVreFDSQcAaPBVQXAcV0IwhB+RlEmZlkDKSUDkICO44Dr+RUAAqa/JWWS6VV+C4gYYUUrueLG6CoDcFnMUnKv6ES0LfRL3kAGtXq94q7nloXd3d55fFgwwEXvyc6j9xjA7WlvvIcbdpknk/0TYADQcEsPXv/LfAAAAABJRU5ErkJggg==');
	elseif(in_array($image, $filetype['xml']))		echo base64_decode('R0lGODlhEAAQAMQAAAAAAP///wAA/wAAnAAAhDFh/zFhnDGe/6XP9zHP/wCGhDH//4SGhMbHxjGeAPf39////wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAABAALAAAAAAQABAAAAViIMSMZDlCqBisbNswKdOyT/A0AazafF0DQIDqgagpFAVbMSCUIQYBRWBxIAQGxebTplgkHIQathnYFg4OgRX7IBNrhLjyt/P1em6Dfr+ny+52Pnl8fH4rgYBugHdCQY6PQSEAOw==');
	elseif(in_array($image, $filetype['html']))		echo base64_decode('R0lGODlhEAAQAKIAAEdH7P///8bGxoSEhAAAAP///wAAAAAAACH5BAEAAAUALAAAAAAQABAAAANCWFrU/msRQSslUc3Au3DR1nHVY54OoK4s2wABDHPz/MaxLOM3reew208FDAhzyJWR0GquUNBGSDAafaaWLEYSJQwSADs=');
	elseif(in_array($image, $filetype['text']))		echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAADoSURBVBgZBcExblNBGAbA2ceegTRBuIKOgiihSZNTcC5LUHAihNJR0kGKCDcYJY6D3/77MdOinTvzAgCw8ysThIvn/VojIyMjIyPP+bS1sUQIV2s95pBDDvmbP/mdkft83tpYguZq5Jh/OeaYh+yzy8hTHvNlaxNNczm+la9OTlar1UdA/+C2A4trRCnD3jS8BB1obq2Gk6GU6QbQAS4BUaYSQAf4bhhKKTFdAzrAOwAxEUAH+KEM01SY3gM6wBsEAQB0gJ+maZoC3gI6iPYaAIBJsiRmHU0AALOeFC3aK2cWAACUXe7+AwO0lc9eTHYTAAAAAElFTkSuQmCC');
	elseif(in_array($image, $filetype['audio']))		echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAdRJREFUeNqkU89rE1EQ/maz2STbQKTV1AqRWovFBgKCQsFToEfRmxfBP0DwIl56KkUPglfP0lOhBQVpDz305EmpeNAWPAQaSBoDTUuz2SabZN97nRdN0uqmFhz49s3Oj+8x82ZIKYX/EbOrPNwYGKNvGGEcdA0rs32ncc6LnulPva5weChPOc5LMMe4f2YJmn2QFAo/c6nU2JIQyPLvZiBBsegPJIhGk3e2t0vriURyzXHkLSBS+osgHnMRMsPwpY1crnWKIBIhxzQvZnd3yx8N49IrNj0e2APbNjAxYUEpowfPI/i+0SQafaRU40FgCSclHjcwNWWhst+3xWJAq4WyEJbxT4JfdQNXxoA2t4aIA0MdvdZo4NpZz5hQUrxmbDEUQSjLFAiHBDp6uJOcDyTw2000G+6yHXOfT07K9M1p4jIIbnVP1GsHkNInnVxaXQieg/1yUR/ZdCaNvYqeNomjqqPtO9ohvn3AzruXv6PnewTUXSYrlYF9b2Hz6vXU7eHL46hVayjkfsDLf33qfVl+0y5+7y/HiQXsERDRBUreyNDdJy9gDc1wWAX5T4vy89v37NaD4TCqDJdz/CCCqJ4Z/QCM0B/NFYwmw9NknNPbqGMBBgDJpb7OvDYMdwAAAABJRU5ErkJggg==');
	elseif(in_array($image, $filetype['graphic']))		echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAdlJREFUeNqkkz9v00AYxp9zzvblLnac0lLiUKpmKFKDqGBgQ0KCoQsDCxJVP0A/RAcGRsTMgtQpEh3oF+haNia2qiukCzSlieP4b987d+hIk5Ne2Wf5+d3z/jlWliXmWRbmXPz9wcFrerZn1A94lmXhh+3tz7Oo9/r9XZ6lKSuoDs8/MVgMsGtkiyLJAF0dX1TBKdnuItAjr1kBvH1aQmt5kiTICbB5n8Hl9HMdWFTA2T+gbldiEHgYAY9CYLMDRCmMRmv5NEmY3oSNY6zfW0NLhebkh8vAsleBJiTo3qlgU3IWiAqgtXwaxywvChz9+ILvQmLryRu86L00lh1e2daABQmkOX2j9KRLANJorQGktDk5PUHQDPD1ch8Xl7+wsvQA7YUV3PVbqDs6D2mAygEEpRbn14A4ji1j56KDPyOO8V8H34Y/URenUFJBKQWv4Zloej6BQ6wtdfBs1YXWagDLyEG3/QqO48B1XUgp4XkKQeCbaLVI3FTwqQhS2rCERZ2INMA4MG28ufR4Z9SrKErA2ITeLYzHJc7PcwghzCGPe2UFOBsMajXbxuHHd/85PjQEmKBmO9Ba5m9s7FiNRjjLJBaj0W8aEVBdEeh7cUs9TQSGbN7rfCXAAJNovyFuktgQAAAAAElFTkSuQmCC');
	elseif(in_array($image, $filetype['video']))		echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAdxJREFUeNqMU81KI0EQ7t9EhNU3CHjw4s0nyLKEnLz5HotP4AP4AAp5B2FZ2BxCDsoKQm57yhIU3Bwig2IwEyczY3fVVo2dTUY3uzb0dHfV91V9XdUjEVF0u90zIUS92WyeineMTqezT8t5o9H4aNgAAHVaJM3To6OTndksAw5MAwFQ8B4RsFKx6vDw4CfhGVsA5gFEMHxJkhTG48dnIgUyiPneWsNEBXwIYzkAO78655BnkZTIjKUzjEZR7r1nol5WoPhDDhGcynvgBMgf2mOaZv7q6tfs7m5MATBgPDLnTwBWQAaOqhnE2cmEee7h5maUpqnzWluG4wvGy6B6oSDcS5F6YD+Z8Pb2IXNOeGMqgqeUxY3Vizq/qAHdkZySFXR7vW9VWqtRFLnBYCBft5BgGSvA0CYzVxCKcr67u5ckycxvbt5nW1ufYJlsjFbt9rHhIpe6EAJwtu+IEvIcnRAWrLWl7EotalB6B3yFYLj0XlMA4a1dW/UQ9b8U9Ki4TkqN1lb/RmaieaMgp5TB8ANR50pxxXGVggrhywomk0nRBSrsNaKKtTYr2YT5EMdxuQv9fv+iVquxIWq1Pm//72+cTqc4HA4vintzIEq+TvuN+cN6x+D2xsR9+i3AAEgKanVYjEzGAAAAAElFTkSuQmCC');
	elseif(in_array($image, $filetype['archive']))		echo base64_decode('R0lGODlhEAAQAMQTADHPzv//9//PnM6eAGPP/2Oezs7PMf//zv//nACezufn5wAwMf/PY5zP/wBhnP/PMf////8AAAAAAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAABMALAAAAAAQABAAAAVq4CSOUmku4xStk+QkCQAQBaoiArOYvNOgq6BwpZA0JCoIJHDAMR4PSfGYZDafUKkRGbEiGNjolMv8hg1aaqSZg0IHaa7T/RjAxyqevuSzpVwwMjR+KS16hIV/CYmFLhIJjg6MEw6OkJUTIQA7');
	elseif(in_array($image, $filetype['app']))		echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAFiSURBVBgZpcEhbpRRGIXh99x7IU0asGBJWEIdCLaAqcFiCArFCkjA0KRJF0EF26kkFbVVdEj6/985zJ0wBjfp8ygJD6G3n358fP3m5NvtJscJYBObchEHx6QKJ6SKsnn6eLm7urr5/PP76cU4eXVy/ujouD074hDHd5s6By7GZknb3P7mUH+WNLZGKnx595JDvf96zTQSM92vRYA4lMEEO5RNraHWUDH3FV48f0K5mAYJk5pQQpqIgixaE1JDKtRDd2OsYfJaTKNcTA2IBIIesMAOPdDUGYJSqGYml5lGHHYkSGhAJBBIkAoWREAT3Z3JLqZhF3uS2EloQCQ8xLBxoAEWO7aZxros7EgISIIkwlZCY6s1OlAJTWFal5VppMzUgbAlQcIkiT0DXSI2U2ymYZs9AWJL4n+df3pncsI0bn5dX344W05dhctUFbapZcE2ToiLVHBMbGymS7aUhIdoPNBf7Jjw/gQ77u4AAAAASUVORK5CYII=');
	elseif(in_array($image, $filetype['script']))		echo base64_decode('R0lGODlhEAAQAO4AAP///8zMzKutrauurqyurubn6Ovs7Onq6q2vr+7v7+Lj45aZm+Pk5I2PkY+Qkt7f4bm6vKuurba4uK2wsMnLy83O0N7f4MnKzLKztYmLjfDx8vb29vP09Ovs7YuMjoOFh3x+gXd5e3l7fqqrrH+BhKeoqoKEhqipq6iqqq6xsa6vsa2vsm1vcrGzs25wc3d4enZ5e3Z3eXN1eK2usJOVl5OUloiLjYeJjJaXmYyPkYuNj4qMjpKTlZGSlJmbnaSmpqOlpYeJi6Wnp6Slp5qcnoiJi6Gjo6KjpaGjpLCytfDx8/Dx8ezt7vT19vT29fHy8+rr7Ojo6OXm5+Tl5+rq6unp6ejp6f39/f39/P38/P3+/////v39/vv8/Pj4+fj49/f49/n6+vn5+vj4+uTl5MLDxcPFxMDBwsjJy8fIysPExr2+vrW3t7S2trOztrm7u7e6uba4t93d3d3c3dzc3OHh4eDh4d/g4dna3MvLzcrLy8jKy9XV2M7P0czNzf8AACH5BAEAAH8ALAAAAAAQABAAAAfdgBITBAOFEQMIbH+LjAgAj5CPVRSMiwQAFg93DxYAQABRlIwDAAoMZAwKAEIGAFR6jBEAUwW1UgB+KAIALYy7VgfBBmGPMCISvgBQHR1MTyE3eytJRjQZf7sJ2ktgQXwLFX0+eA3YABoaSk1abgsQDg4QRD/mHBxOXS4nFw11Bjl5VOjYtWHDly0sSqTx8MgDmhk7do3xIoaLnTM8MGSwgQHHiDWkrmTB8ojEhR5l1NSoUOTPhEiPZICYc2QIkg8m/rxBMECAAAIp2sSBE+OFmQAB/tBByrQpUjmMAgEAOw==');
	else							echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAABbSURBVCjPzdAxDoAgEERRzsFp95JbGI2ASA2SCOX3Ahtr8tuXTDIO959bCxRfpOitWS5vA+lMJg9JbKCTTmMQ1QS3ThqVQbBBlsbgpXLYE8lHCXrqLptf9km7Dzv+FwGTaznIAAAAAElFTkSuQmCC');
	exit();

//DIRLIST MODE
} else if ($_GET['mode'] == 'dirlist') {

	head(true);

	echo "<div class='dborder1'>\n<div class='dborder2'>\n<div class='dborder3'>\n<table class='t1'>\n";

	//echo path and time, first line
	$echodirpath = realpath('./')."/".$startdir;
	$echodirpath = preg_replace('/\\.+\\/+$/', '', $echodirpath);
	
	echo "<tr><td colspan=\"2\">".$echodirpath."</td><td colspan=\"2\"><span id=\"time\"></span></td></tr>\n";
	
	//open the current directory
	$files = array();
	$dirs = array();
	$handle=opendir($startdir);
	while (($file = readdir($handle))!==false) {
		//if this is direcory
		if ( is_dir($startdir.$file)) {
			if ($file != '.') {
				$dirs[] = $file;
			}
		} else {
			$files[] = $file;
		}
	}
	closedir($handle);

	sort($files);
	sort($dirs);
	
	$dirCount = 0;
	foreach ( $dirs as $dir){
		$dirCount++;
		$extension = '.';
		$size = format_bytes(filesize($startdir.$dir));
		$modTime = filemtime($startdir.$dir);
		echo "<tr class=\"folder\"><td><img src=\"".$basedir.".far_view.php?mode=image&amp;image=".$extension."\" alt=\"".$extension."\"/>&nbsp;<a href=\"./".$dir."\">".$dir."</a></td><td>Folder</td><td>".date("Y.m.d.", $modTime)."</td><td>".date("H:s", $modTime)."</td></tr>\n";
	}
	$sumSize = 0;
	$fileCount = 0;
	foreach ( $files as $file){
		if (preg_match('/^(\\.htaccess|\\.htpasswd|\\.far_view\\.php|\\.far_edit\\.php)$/', $file) ) {
			continue;
		}
		$fileCount++;
		$extension = preg_replace("/^.*\.([^\.]+)/", "$1", $file);
		$size = filesize($startdir.$file);
		$sumSize += $size;
		$modTime = filemtime($startdir.$file);
		if ($_SETTING['enableeditfiles']) {
			$fileeditorview = 'fileedit';
		} else {
			$fileeditorview = 'fileview';
		}
		echo "<tr><td><a href=\"".$basedir.".far_view.php?mode=".$fileeditorview."&amp;file=".$startdir."".$file."\"><img src=\"".$basedir.".far_view.php?mode=image&amp;image=".$extension."\" alt=\"".$extension."\"/></a>&nbsp;<a href=\"".$basedir.".far_view.php?mode=fileview&amp;file=".$startdir."".$file."\">".$file."</a></td><td>".format_bytes($size)."</td><td>".date("Y.m.d.", $modTime)."</td><td>".date("H:s", $modTime)."</td></tr>\n";
	}

	// echo sumsize
	echo "<tr><td>$fileCount files and ".($dirCount-1)." dirs</td><td>".format_bytes($sumSize)."</td><td>&nbsp;</td><td>&nbsp;</td></tr>\n";
	echo "</table>\n</div>\n</div>\n</div>";

	foot(true);

} else if ($_SETTING['enableeditfiles'] && $_GET['mode'] == 'fileedit' && strlen($_GET['file']) > 0) {
	head();
	$file = $_GET['file'];
	// check if form has been submitted
	if (isset($_POST['text'])) {
		// save the text contents
		file_put_contents($file, $_POST['text']);
		$text = $_POST['text'];
	} else {
		// read the textfile
		$text = file_get_contents($file);
	}

	$texttoarea = htmlspecialchars($text);
	$backlink = dirname($file);
print <<< END1
	<form name="savefile" id="savefile" action="" method="post">
	<div class="dborder1">
	<div class="dborder2">
	<div class="dborder3">
	<textarea wrap="off" rows="10" cols="10" class="fileedit" name="text">$texttoarea</textarea>
	</div>
	</div>
	</div>
	<a class="button" id="savebutton" href="#" onclick="document.forms['savefile'].submit();">Mentés</a><a class="button" href="$backlink">Vissza</a>
	</form>
END1;

	foot();
} else if ($_GET['mode'] == 'fileview' && strlen($_GET['file']) > 0) {
	head();
	$file = $_GET['file'];
	// read the textfile
	$text = file_get_contents($file);

	$texttoarea = htmlspecialchars($text);
	$backlink = dirname($file);
print <<< END1
	<form name="savefile" id="savefile" action="" method="post">
	<div class="dborder1">
	<div class="dborder2">
	<div class="dborder3">
	<textarea wrap="off" readonly="readonly" rows="10" cols="10" class="fileview" name="text">$texttoarea</textarea>
	</div>
	</div>
	</div>
	<a class="button" href="$backlink">Vissza</a>
	</form>
END1;

	foot();
}

//functions
function format_bytes($size) {
    $units = array(' b&nbsp;', ' Kb', ' Mb', ' Gb', ' Tb');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
    return round($size, 2).$units[$i];
}

function head ($time = false) {
	if ($time) {
		$timejsfunction = "
		function echoTime () {
		var currentTime = new Date()
		var hours = currentTime.getHours()
		var minutes = currentTime.getMinutes()
		var seconds = currentTime.getSeconds()
		if (minutes < 10){
			minutes = '0' + minutes
		}
		if (seconds < 10){
			seconds = '0' + seconds
		}
		document.getElementById('time').innerHTML = hours + ':' + minutes+':'+seconds;
		setTimeout('echoTime()',100)
		}
		";
	}
	global $startdir;
	print <<< END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>$startdir - DirListFarStyle</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript"><!--//--><![CDATA[//><!--
	$timejsfunction
	$( document ).ready(function() {
		$("textarea.fileedit").keypress(function() {
			$("#savebutton").text('*Mentés*');
		});

		$("textarea.fileedit").keydown(function(e) {
			if(e.keyCode === 9) { // tab was pressed
				// get caret position/selection
				var start = this.selectionStart;
				var end = this.selectionEnd;
				var \$this = $(this);
				var value = \$this.val();
				// set textarea value to: text before caret + tab + text after caret
				\$this.val(value.substring(0, start)+"\t"+ value.substring(end));
				// put caret at right position again (add one for the tab)
				this.selectionStart = this.selectionEnd = start + 1;
				// prevent the focus lose
				e.preventDefault();
			}
		});
	});

	//--><!]]></script>

<style type="text/css">
body {
	font-size:16px;
	font-family: Lucida Console, Courier, sans-serif, Verdana;
	color: #000000;
	background: #191919; /*#cecece*/;
	margin: 30px auto ;
	max-width: 1000px;
}
a {
	color: #2E9AFE;
	text-decoration: none;
	font-weight: bold;
}
.folder, .folder a{
	color: #ffffff;
	text-decoration: none;
	font-weight: bold;
}
.t1 {
	border-collapse: collapse;
	width: 100%;
}
.t1 td {
	padding: 5px;
	color: #ffffff;
}
.t1 td:nth-child(2) {
	text-align: right;
	width: 100px;
	border-left: 2px solid #00FFFF /*#666*/;
}
.t1 td:nth-child(3) {
	text-align: right;
	width: 125px;
	border-left: 2px solid #00FFFF /*#666*/;
}
.t1 td:nth-child(4) {
	text-align: right;
	width: 60px;
	border-left: 2px solid #00FFFF /*#666*/;
}
/*row hover*/
.t1 tr:hover td, .t1 tr:hover td a {
	background-color: #008B8B;
	color: #cecece;
}
/*first(path) rows*/
.t1 tr:first-child td {
	border-bottom: 2px solid #00FFFF;
	border-left: none;
}
.t1 tr:first-child:hover td {
	background-color: #00008b;
	color: #ffffff;
}
/*last(sum) rows*/
.t1 tr:last-child td {
	border-top: 2px solid #00FFFF /*#666*/;
	border-left: none;
}
.t1 tr:last-child:hover td, .t1 tr:last-child td:hover a {
	background-color: #00008b;
	color: #ffffff;
}
/*outline double border*/
.dborder1 {
	padding: 7px;
	background-color: #00008B;
	margin: 0px 0px 4px 0px;

}
.dborder2 {
	border: 2px solid #00FFFF;
	padding: 1px;
}
.dborder3 {
	border: 2px solid #00FFFF;
}
.footer, .footer a {
	font-size: 11px;
	font-family: verdana, sans-serif, Arial;
	font-weight: none;
	text-align: center;
	margin: 5px 0 0 0;
	font-weight: normal;
	color: #5e5e5e/*#0000aa*/;
}
textarea.fileedit, textarea.fileview {
	font-size: 16px;
	padding: 2px;
	color: white;
	color: #00FFFF;
	font-weight: bold;
	background-color: #040480;/*#00008B*/
	border: none;
	width: 99%;
	height: 600px;
}
textarea::selection {
	background-color: #008080;
	color: #00FFFF;
}
textarea::-moz-selection {
	background-color: #008080;
	color: black;
}
.button {
	background-color: #008080;
	color: black;
	padding: 3px;
	margin-left: 4px;
	display: inline-block;
}
</style>
</head>
<body>
END;


}

function foot ($time = false) {
	print "<div class=\"footer\"><a href=\"https://github.com/kissci/DirListFarStyle/\">DirListFarStyle</a>&nbsp;&nbsp;&nbsp;&mdash;&nbsp;&nbsp;&nbsp;<a href=\"http://validator.w3.org/check?uri=referer\">valid XHTML</a></div>\n";
	if ($time) {
		print "<script type=\"text/javascript\">\n	echoTime();\n</script>\n";
	}
	print "</body>\n</html>\n";
}


?>