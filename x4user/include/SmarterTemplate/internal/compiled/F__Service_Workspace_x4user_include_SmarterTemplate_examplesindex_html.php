<?php
require_once "F:/Service/Workspace/x4user/include/SmarterTemplate/examples/../internal/extensions/dateformat.php";

?><?php $TIME_GENERATED = round(microtime (), 4); ?><table style="background-color: rgb(204, 204, 204);" border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td>
			zurueck 
			| <a href="<?php echo $loop[0]['value']['PHP_FILE']; ?>">Uebersicht</a> 
			| <a href="grundlagen.php">weiter</a> 
			| <a href="<?php echo $loop[0]['value']['PHP_FILE']; ?>?doDebug">Debugversion</a>
		</td>
	</tr>
</table>
<table style="background-color: rgb(204, 204, 204);" border="0" cellpadding="2" cellspacing="1" width="100%">
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td colspan="2"><center><b>Dokumentation zu SmarterTemplate</b></center></td>
	</tr>
	<tr style="background-color: rgb(255, 255, 255);" valign="top">
		<td><b>Beispiele</b>
			<ul>
				<li><a href="grundlagen.php">Grundlagen, Text einfuegen</a></li>
				<li><a href="erweiterung.php">Erweiterungen, ohne Argumente</a></li>
				<li><a href="erweiterung_argumente.php">Erweiterungen, mit Argumenten</a></li>
				<li><a href="schleife.php">Kontrollstrukturen, Schleifen</a></li>
				<li><a href="anzeigekontrolle.php">Kontrollstrukturen, Bedingungen</a></li>
				<li><a href="phpcode.php">PHP-Code</a></li>
				<li><a href="sprachsupport.php">Sprachsupport</a></li>
				<li><a href="sql.php">SQL-Support (mit PHP_PDO)</a></li>
			</ul>
		</td>
		<td>
			<b>Voraussetzungen</b>
			<br>PHP 5 und hoeher
			<br><br>
			<b>Installation</b>
			<br>In ein beliebiges Verzeichnis entpacken
			<br>php.ini aendern
			<br>include_path um das Installationsverzeichnis von SmarterTemplate erweitern
			<br>Beispielsweise:
			<br>include_path = "/usr/bin/pear;/opt/php_include/SmarterTemplate"
			<br>magic_quotes_gpc = Off
			<br>magic_quotes_runtime = Off
			<br>Apache neu starten
			<br>Verzeichnis examples an den Ort verschieben von dem aus man ueber den Webserver zugreifen kann
			<br>Beispielsweise: /var/www/
			<br>Im Browser die Seite examples/index.php aufrufen.
			<br>Wenn alles geklappt hat erscheint diese Seite. Jedoch kompiliert
			<br><br>
			<b>Konfiguration</b>
			<br>Debugging aktivieren (true)/deaktivieren (false)
			<br>$GLOBALS['_CONFIG']['doDebug'] = false;
			<br>// Verzeichnis in dem sich alle Templates befinden
			<br>$GLOBALS['_CONFIG']['template_dir'] = "...;
			<br>// Verzeichnis in dem alle kompilierten Templates gespeichert werden
			<br>$GLOBALS['_CONFIG']['smarttemplate_compiled'] = "...";
			<br>// Maximale Cachezeit fuer kompilierte Templates
			<br>$GLOBALS['_CONFIG']['cache_lifetime'] = 5;
			<br>$GLOBALS['_CONFIG']['compiledLifetime'] = 5;
			<br>// Verzeichnis in dem alle Erweiterungen liegen
			<br>$GLOBALS['_CONFIG']['extensionsDirectory'] = "...";
			<br>// Cachezeiten aus/in Textdatei holen/laden (false)
			<br>// Cachezeiten auf Dateimodifikation holen (true)
			<br>$GLOBALS['_CONFIG']['mtime'] = true;
			<br>// PHP-Ausfuehrung im Template unterbinden
			<br>$GLOBALS['_CONFIG']['executePHP'] = false;
			<br>// Sprachsupport fuer Templates
			<br>$GLOBALS['_CONFIG']['lang'] = 'de';
			<br>// Automatische Linkergaenzung fuer die Sprache wenn noch nicht vorhanden (?lang=aktuelle Sprache[&..])
			<br>$GLOBALS['_CONFIG']['autoLink'] = true;
			<br><br>
			<b>Verwendung</b>
			<br>Kompatibel zu <a href="http://smartphp.net/content/smarttemplate/about/about.html">SmartPHP's SmartTemplate</a>. Es gibt noch keine eigene Dokumentation
			<br>Kompatible Version laden (nicht alle oben aufgefuehrten Features verfuegbar)
			<br>require "/pfad/zu/SmarterTemplate/class.SmartTemplate.php";
			<br>Oder die nicht vollstaendig kompatible Version laden (alle oben aufgefuehrten Features verfuegbar)
			<br>require "/pfad/zu/SmarterTemplate/class.SmarterTemplate.php";
			<br>Instanz von SmarterTemplate erzeugen
			<br>$smtpl = new SmarterTemplate ( "/pfad/zu/Template/template.html" );
			<br>$smtpl-&gt;assign ( key, values );
			<br>$smtpl-&gt;assign ( values );
			<br>Fertige Seite ausgeben (mit oder ohne Debuginformationen entscheidet doDebug)
			<br>$smtpl-&gt;output ();
			<br>echo $smtpl-&gt;result ();
			<br>echo $smtpl-&gt;debug (); // Ausgabe erfolgt immer mit Debuginformationen
		</td>
	</tr>
</table>
<div align="right">
	<b>Letzte Aenderung am <?php echo stedateformat ( $loop[0]['value']['TIME_REFRESHED'] ); ?></b>
	<br><b>Seite kompiliert in <?php echo $loop[0]['value']['TIME_COMPILED']; ?> Sekunden</b>
	<br><b>Seite generiert in <?php echo ( round(microtime (), 4) - $TIME_GENERATED); ?> Sekunden</b>
</div>