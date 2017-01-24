UPDATE quizcards.bhe_knowledge SET title = 'PHP Grundlagen', content = '<p>PHP ist im Gegensatz zu JavaScript eine Server-Seitige Programmierung.</p>
<h2>Aufbau einer PHP-Datei</h2>
<p>Alle Dateien, die vom Server als PHP Dateien interpretiert werden sollen m&uuml;ssen auf <strong>.php</strong> enden.<br /> PHP Dateien k&ouml;nnen auch reines HTML enthalten. Dieses wird unver&auml;ndert an den Client ausgeliefert.</p>
<p><strong>php-Code</strong> wird mit folgendem Tag in den HTML-Code eingebunden</p>
<pre>&lt;?php<br />...<br />?&gt;</pre>
<h4>Kommentare innerhalb einer PHP-Datei</h4>
<p>Werden Kommentare innerhalb des HTML Codes erfolgt folgenderma&szlig;en</p>
<pre>&lt;!-- <em>Kommentar</em>... --&gt;</pre>
<p>Innerhalb des PHP-Codes gibt es folgende M&ouml;glichkeiten einen Kommentar zu erstellen</p>
<pre>// <em>einzeilliger Kommentar der am Zeilenende endet</em></pre>
<pre>/*<br /></span><em>mehrzeiliger Kommentar<br /></em>*/</pre>
<h2>Ansicht einer PHP-Datei</h2>
<p>Selbst erstellte PHP-Datein k&ouml;nnen im gegensatz zu HTML Dateien nicht direkt auf dem Rechner ge&ouml;ffnet werden, da Internetbrowser nicht in der Lage sind den PHP-Code zu interpretieren.<br /></p>' WHERE id = 1;
UPDATE quizcards.bhe_knowledge SET title = 'Variablen in PHP', content = '<p>Variablen werden in PHP durch ein vorangestelltes Dollar-Zeichen ($) gefolgt vom Namen der Variablen deklariert. Dabei sind Folgende Eigenschaften zu beachten:</p>
<ul>
<li>erstes Zeichen muss ein Buchstabe sein</li>
<li>Buchstaben, Zahlen, Unterstrich sind erlaubte Zeichen</li>
<li>Leerzeichen, Umlaute und &szlig; sind nicht erlaubte Zeichen</li>
<li>keine Reservierten Worte (if, else, and echo, for, foreach...)</li>
<li>Es wird zwischen Gro&szlig;- und Kleinschreibung unterschieden (case-sensitive).</li>
</ul>
<p>PHP arbeitet nach dem Prinzip des "loose typing", d.h. Datentypen m&uuml;ssen vom Programmierer nicht festgelegt werden.<br />Trotzdem weden Datentypen unterschieden</p>
<ul>
<li>ganze Zahlen</li>
<li>Flie&szlig;kommazahlen</li>
<li>Zeichenketten</li>
<li>ein- und mehrdimensionale Felder</li>
<li>Objekte</li>
</ul>
<p>Der Datentyp einer Variable kann sich innerhalb eines Programmes wechseln. Zur manipulation stehen folgende Funktionen zur Verf&uuml;gung</p>
<table>
<tbody>
<tr><th>Funktion</th><th>Beschreibung</th></tr>
<tr>
<td>
<pre>intval(&lt;...&gt;);</pre>
</td>
<td>Konvertiert einen Wert nach integer</td>
</tr>
<tr>
<td>
<pre>floatval(&lt;...&gt;);</pre>
</td>
<td>Konvertiert einen Wert nach float</td>
</tr>
<tr>
<td>
<pre>doubleval(&lt;...&gt;);</pre>
</td>
<td>Konvertiert einen Wert nach double</td>
</tr>
</tbody>
</table>
<h4>Ausgabe von Variablen</h4>
<p>Mit der Prozedur echo k&ouml;nnen mehrere aktuelle Parameter ausgeben werden. Variablen innerhalb einer solchen Anweisung werden immmer Ausgewertet. Diese Auswertung kann man durch nutzen eines einfaches Anf&uuml;hrungszeichen anstelle eines doppelten Anf&uuml;hrungszeichens verhindert werden. Die folgende Tabelle soll diese Unterschiede deutlich machen</p>
<table>
<tbody>
<tr>
<td style="text-align: left;">
<pre>&lt;?php<br />$p = 3.14159<br />echo <span style="color: #ff0000;">"</span>$p<span style="color: #ff0000;">"</span>, <span style="color: #ff0000;">"</span> = <span style="color: #ff0000;">"</span>, $p;<br />?&gt;</pre>
</td>
<td>
3.14159 = 3.14159
</td>
<td style="text-align: left;">
<pre>&lt;?php<br />$p = 3.14159;<br />echo <span style="color: #ff0000;">"</span>p = $p &lt;br&gt;<span style="color: #ff0000;">"</span>;<br />?&gt;;</pre>
</td>
<td>
p = 3.14159
</td>
<td style="text-align: left;">
<pre>&lt;?php<br />$p = 3.14159;<br />echo <span style="color: #0000ff;">''$p''</span>, <span style="color: #ff0000;">"</span> = $p &lt;br&gt;<span style="color: #ff0000;">"</span>;<br />?&gt;</pre>
</td>
<td>
<span style="color: #0000ff;">$p</span> = 3.14159
</td>
</tr>
</tbody>
</table>
<h4>&nbsp;Best Practice</h4>
<p>Um PHP-Quelltext &uuml;bersichtlich zu gestalten empfiehlt es sich Variablen nicht innerhalb von Zeichenketten zu verwenden, sondern mit dem Punktoperator verkettet einzusetzen.</p>
<table>
<tbody>
<tr>
<td>
<pre>&lt;?php<br />$p = 3.14159;<br />echo "p = ".$p.";<br />?&gt;</pre>
</td>
<td>
<pre>p = 3.14159</pre>
</td>
</tr>
</tbody>
</table>
<h4>Rechnen in PHP</h4>
<p>Grundlegende Rechenfunktionen</p>
<table>
<tbody>
<tr><th>Operator</th><th>Beispiel</th><th>Beschreibung</th></tr>
<tr>
<td>+</td>
<td>
<pre>$s = $a + $b</pre>
</td>
<td>Addition</td>
</tr>
<tr>
<td>-</td>
<td>
<pre>$d = $a - $b</pre>
</td>
<td>Subtraktion</td>
</tr>
<tr>
<td>*</td>
<td>
<pre>$p = $a * $b</pre>
</td>
<td>Multiplikation</td>
</tr>
<tr>
<td>/</td>
<td>
<pre>$q = $a / $b</pre>
</td>
<td>Division</td>
</tr>
<tr>
<td>&nbsp;%</td>
<td>
<pre>$m = $a % $b</pre>
</td>
<td>Modulo-Operator: Rest einer Division</td>
</tr>
</tbody>
</table>
<p>Abgek&uuml;rzte Rechenfunktionen</p>
<table>
<tbody>
<tr><th>Operator</th><th>Beispiel</th><th>Identisch mit</th></tr>
<tr>
<td>++</td>
<td>
<pre>$a++</pre>
</td>
<td>
<pre>$a = $a + 1</pre>
</td>
</tr>
<tr>
<td>--</td>
<td>
<pre>$a--</pre>
</td>
<td>
<pre>$a = $a - 1</pre>
</td>
</tr>
<tr>
<td>+=</td>
<td>
<pre>$a += 7</pre>
</td>
<td>
<pre>$a = $a + 7</pre>
</td>
</tr>
<tr>
<td>-=</td>
<td>
<pre>$a -= 7</pre>
</td>
<td>
<pre>$a = $a - 7</pre>
</td>
</tr>
<tr>
<td>*=</td>
<td>
<pre>$a *= 7</pre>
</td>
<td>
<pre>$a = $a * 7</pre>
</td>
</tr>
<tr>
<td>/=</td>
<td>
<pre>$a /= 7</pre>
</td>
<td>
<pre>$a = $a / 7</pre>
</td>
</tr>
<tr>
<td>%=</td>
<td>
<pre>$a %= 7</pre>
</td>
<td>
<pre>$a = $a % 7</pre>
</td>
</tr>
</tbody>
</table>' WHERE id = 2;
UPDATE quizcards.bhe_knowledge SET title = 'Nutzereingaben', content = '<p>Um im PHP Nutzereingaben verarbeiten zu k&ouml;nnen ist es notwendig diese mittels eines Formulars zu &uuml;bermitteln. Dabei m&uuml;ssen sowohl das Attribut "action" mit der Angabe der Seite, die beim Absenden des Formulars aufgerufen werden soll, als auch dem Attribut "method" die festlegt, wie die Eingabe Daten &uuml;bermittelt werden sollen.</p>
<table>
<tbody>
<tr>
<td>
<pre>&lt;Form action="nutzer.php" method="post"&gt;

&lt;input type="Text" name="Name" /&gt;
 &lt;input type="Text" name="Vorname" /&gt;
 &lt;input type="Text" name="Klasse" /&gt;
 &lt;input type="Submit" value="Suchen" name="senden" /&gt;

&lt;/form&gt;</pre>
</td>
<td><img src="img/form.png" alt="Ansicht des Formulars" height="300" /></td>
</tr>
</tbody>
</table>
<p>Abh&auml;ngig von der gew&auml;hlten Methode werden die Daten entweder im Superglobalen Assoziativen $_POST oder $_GET Array gespeichert. Entsprechend der Methode kann mit</p>
<pre>$_POST[''Vorname''] oder $_GET[''Vorname'']</pre>
<p>ein Zugriff auf das Superglobale Assoziative Array erfolgen. Prinzipiell ist es m&ouml;glich diese Umsetzung mit zwei unterschiedlichen Dateien zu realisieren. Dies f&uuml;hrt jedoch bei gr&ouml;&szlig;eren Projekten dazu, dass der Projektordner un&uuml;bersichtlich wird. Zur Optimierung wird in der Regel in einem Dokument das Formular angezeigt, sich beim absenden des Formulars wieder selbst aufruft und&nbsp;dann die Verarbeitung der eingegebenen Daten realisiert. Um zu verhindern, dass Berechnungen scheitern, weil bisher keine Eingabe get&auml;tigt wurde gibt es die M&ouml;glichkeit mittels der Funktion isset(); zu Pr&uuml;fen ob diese Variable im Superglobalen Assoziativen $_GET oder $_POST Array vorhanden ist.</p>
<pre>if (isset($_POST[''Vorname''])){...</pre>' WHERE id = 3;