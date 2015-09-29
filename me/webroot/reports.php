<?php 
/**
 * This is a kittX pagecontroller.
 *
 */
include(__DIR__.'/config.php'); 

// Do it and store it all in variables in the kittX container.
$kittx['title'] = "Redovisningar";

$kittx['main'] = <<<EOD
<h1>Redovisningar</h1>
<h2>kmom01</h2>
<p class="text">
Ja, vart ska man börja, vilket moment! Tog sin lilla stund att läsa genom 
hela texten om Anax men det gjorde att det var lättare att hänga med när man väl skulle 
dra igång med uppgiften, jag döpte min version till kittX - en lite sötare template.
Jag sitter och skriver koden i jEdit på windows 7 och arbetar direkt mot filerna 
så man slipper ftp-program. Komplementerar med en del unix också, tex när jag skulle kopiera 
kittX till me-sidan. Putty kor jag som ssh-klient. </p>
<p class="text">
20 steg för att komma igång PHP kändes mest som en jobbig läsning då jag känner 
att jag har koll på det mesta av det. Lite nytt hittade jag väl i allafall. 
Som skillnaden mellan (") och (') hade jag inte greppat innan och förklarar 
en hel del "konstiga" fel jag fått förr. 
</p>
<p class="text">
Att sätta sig in i Anax var ganska betungande, jag har tidigare bara jobbat med 
include, det här var en ny nivå. Men jag gillar strukturen! Det enda jag har ändrat är att jag bytte plats på config- och render-anropen till 
en index.php som även hanterar vilken sida som skall visas, vilket innebär att jag slipper skriva det på alla sidor.
Jag flyttade även ut sitelogo, sitetitle osv som finns i headern till config-filen. 
</p>
<p class="text">
Source.php var lite knepigt att få till eftersom all text hanteras i adhoc och jag ville använda KITTX_INSTALL_PATH.
Jag fick helt enkelt stycka av adhoc'en efter a href=" och sedan lägga in länken med (.=) och forstätta texten efter. 
Men när jag använde KITTX_INSTALL_PATH så blev länken 
"http://www.student.bth.se/home/saxon/students/20112/oshb11/www/oophp/me/src/source.php" när den borde bli 
"http://www.student.bth.se/~oshb11/oophp/me/src/source.php", så nu körs den med ../../src/source.php istället.
</p>
<p class="text">
Min fina me-sida hämtar genom en egen klass in mina senast spelade låtar och presenterar dom. Lite parsing 
av xml från en last.fm-rssfeed. Headers är konstant uppe i kanten, men blir mindre när man scrollar 
med hjälp av javascript som väljer att använda olika css-klasser. Jag valde att inte göra extrauppgiften 
eftersom jag inte känner mig så manad att dela med mig av det här än, men om jag gör några större ändringar senare kanske 
det blir av!</p>

<h2>kmom02</h2>
<p class="text">
Ja, det här med Anax börjar sjunka in, det är smidigt! Men det är inte helt problemfritt och inte helt uppenbart alla gånger. 
Det är tur det finns ett härligt forum och en bra IRC-grupp att fråga! Det tog ganska lång tid att jobba sig igenom övningen 
OOPHP 20-steg, men jag behövde det. Jag programmerade objektorienterad c++ och java i första året. Det vill säga tre år sedan. 
Det var på tiden att damma av de kunskaperna och få de fina och fräscha.
Det var en bra uppgift, simpel men ändå sjukt utmanande, i alla fall för mig.
</p>
<p class="text">
Jag är sjukt nöjd över hur koden blev strukturerad och hur det ser ut.
Jag strukturerade koden genom följande klasser: CDie, CDiceGame, CDicePlayer, CDiceGameLogic. Det är egentligen onödigt att ha en egen 
klass för CDicePlayer eftersom den bara innehåller poäng just nu, men jag tänkte att man kunde ju lika gärna bygga ut med namn och så vidare i framtiden så 
jag behöll den strukturen. CDie innehåller helt enkelt tärningen, sidor och valör. CDieGame innehåller en tärning, summa, spelare och antal spelare.
Funktionerna i den hanterar allt som behövs för själva spelet och det räcker egentligen med den för att man ska ha spelet klart. Men 
man kan ju inte spela utan utskrifter till skärmen. 
</p>
<p class='text'>Det sköts genom CDiceGameLogic som innehåller ett spel och html och en variabel som håller koll på aktiv spelare. 
Det vill säga allting som hade varit i den "vanliga filen" om vi inte skulle ha använt oss av anax. Det var givetvis detta som tog 
allra längst tid att genomföra. Jag jobbade nonstop med (i princip) bara den här filen i 8 timmar och det är bara 132 rader. 
Det var mycket tankenötter att knäcka med platser i arrayer och anrop hit och dit, men tillslut löste det sig!
</p>
<p class='text'>
Det krävdes dock många provkörningar och mycket var_dump() för att hitta felen och rätta till. 
Till exempel så sparades inte rätt summa på rätt spelare på grund av att saven skedde efter man bytt aktiv spelare, så då fick man ju lägga på en 
-1 i anropet till funktionen som hanterade det för att hamna rätt i arrayen.
</p>
<p class="text">
Jag ändrade strukturen i kmom01 så att det var en index.php-fil som hämtade vilken fil det var som skulle visas, det fungerade dåligt 
när man ville ha olika stylesheets på olika sidor så jag ändrade tillbaka igen. Ändringen är även genomförd på kmom01's me-sida 
på grund av att jag var tvungen att fixa CSource på rätt sätt. Jag hade totalt missat hur det var man skulle göra, av någon anledning 
hade jag missat den övningen. Sånt som händer och nu ska det vara rätt! 
</p>
<p class="text">
Jag gjorde även en av extrauppgifterna i tärningsspelet, dvs man kan spela flera personer. Jag hade dock lagt till det innan jag såg att 
det var en extrauppgift, så det var bara en bonus ;). 
</p>

<h2>kmom03</h2>
<p class="text">
Det här momentet var som en bergochdalbana! Jag har läst en grundkurs i MSSQL på 3.5HP tidigare, samt påbörjat DV1219 på BTH där jag gjorde projektet och modelleringen men lyckades inte göra resten. Men det 
läser jag samtidigt som det här nu, så när jag först öppnade uppgiften var min tanke "inte samma igen!". Jag har nämnliggen gjort samma labb i Databasteknik 3 gånger nu. Men det här 
var en mycket roligare övning med bättre förklaringar. Men jag tänkte ändå att det här skulle gå fort och utan problem.
</p>
<p class="text">
Men redan i övning 1 åkte jag på problem med anslutning till Workbench, det gick så långt att jag va upp, jag trodde ändå inte att jag skulle använda det utan köra myPhpAdmin, som jag känner igen 
sedan mina egna hobby-projekt. Men när jag väl kom till punkt 2 förklarades hur man var tvungen att göra för att koppla upp sig till skolans mySQL-server genom Workbench - dessa två borde byta ordning. 
När jag väl hade fått upp Workbench såg jag direkt att det var ett helt underbart program och jag höll mig kvar vid det genom hela "Kom igång med SQL"-övningen.
</p>
<p class="text">
Trots att jag läst viss databasteknik tidigare var det ett tag sedan och det var spännande att se hur långt jag skulle klara mig utan problem eller att det kom något jag inte hade koll på. 
Det första jag stötte på som jag inte visste så mycket om var inbyggda funktioner, och det verkar vara en väldigt användbar grej att kunna!
I övrigt så kom tankebanorna med databaser tillbaka ganska snabbt, det var mer syntaxerrors lite här och var som satte stopp för mig.
</p>
<p class="text">
Vid frågeställningen om "Vilken/vilka lärare har flest uppdrag som kursansvarig?" tänkte jag direkt på att man borde kunna byta ut dendär 3an mot något dynamiskt, så jag började testa mig fram men hittade inte rätt syntax 
så jag scrollade ner 5 rader och såg det, jag hade missat parenteserna. 
Jag håller även med texten om att skillnaden på left/right outer join / left/right inner join är det svåraste att greppa, men det börjar sjunka in.
</p>
<p class="text"><a href="kmom03_sql.sql">Länk till min SQL-fil</a></p>

<h2>kmom04</h2>
<p class="text">
Under det här momentet har jag åkt på mentala blockader titt som tätt, det har tagit sjuka mängder mer tid än planerat och 
det mesta beror på att jag gjort saker svårare än vad det ska vara. Till och börja med så missade jag (om det ens finns) texten om 
att man skulle skapa en pagecontroller för varje uppgift i övningen, detta gjorde att jag skapade en multi-sida och fixade pageingering 
för alla möjliga saker, till exempel var det sjukt klurigt gällande pageinering under sortering av eb genre, men subqueryn jag använder fungerar bra 
och jag är sjukt nöjd med uppgiften när det väl blev klar.</p>
<p class="text">
Åkte direkt i uppgift 1 på samma typ av blockad och jag vet inte vad som hände med jag kunde verkligen inte se vad som kunde ligga i en klass och inte 
men efter en hel del prat, skrik, blod och tårar lyckades jag tillslut få det klart. Som ni kanske noterat så använder jag inte filmdatabasen och det bror på 
en del av förvirringen med texten under kravspecen, men kommer att vara smidigt att byta tillbaka senare, men med tanke på att jag redan 
lagt mer än dubbla tiden är det för mig viktigare att se uppgifternas innehåll och vad som ska göras än att använda en viss databas.
</p><p class="text">
Det tog sjukt lång tid att greppa PDO-tänket, jag har tidigare jobbat med databaser i PHP men inte med PDO. När man väl insåg hur det hängde ihop blev det bra och smidigt.
</p><p class="text">
Angående moduler i Anax så ser jag oftast inte poängen med att ha de som klasser, de är ofta sjukt specifik och för mig hanterar inte en klass såhär specifika uppgifter. 
Utöver det tycker jag att det fungerar bra med klasser och själva oophp-tänket.</p>

<h2>kmom05</h2>
<p class="text">
Efter förra momentet som kändes mer som hinder än uppgift så känns det mer i hamn, övningen flöt på extremt bra och jag stötte inte på några stora bekymmer alls. 
Dessa började dock när jag skulle börja med uppgiften att bryta ut det till moduler. Jag hade svårt att se hur det skulle hänga ihop men efter att ha rådfrågat i chatten och läst 
tråden i forumet om just kmom05 (http://dbwebb.se/forum/viewtopic.php?t=1843), mina frågor ledde tydligen även till en forumtråd (http://dbwebb.se/forum/viewtopic.php?t=3134).
</p><p class="text">
Modulerna börjar dock falla på plats och jag har insett skillnaden på klasser (som jag tänker mig dom) och moduler. Moduler behöver inte vara så generella som 
jag vill göra en klass. Jag valde att strukturera mina klasser ungefär i likhet med diagrammet i forumet. Det jag reagerade på var att mina CPage och CBlog bara innehåller en funktion. 
Men i framtiden kanske det växer och blir större, vem vet. 
</p><p class="text">
Jag börjar tro att mina kunskaper om objektorienterad c++ bara gör det här svårare än det borde vara för jag tänker inte som man kanske hade gjort med mindre kunskap om klasser. Så det rör till 
sig ibland med modul-tänket.
</p><p class="text">
Det största hindret jag stötte på var nog när jag skulle skapa CTextFilter, vilket kanske verkar konstigt. Men det berode på att jag ville ha funktionerna privata förutom dofilter(). 
Detta gjorde att det skulle bli self:: framför anropet, men al2br() var ju en inbyggd funktion vilket gjorde att jag var tvungen att skaffa en if-sats som hanterade detta. 
If-satsen fungerade inte som väntat och detta mynnade efter /mycket/ letande ut i att jag hade skrivit a12br istället för al2br, i tre olika teckensnitt såg det så lika ut att jag verkligen inte kunde 
förstå varför statementet inte blev True. Men jag hittade det efter mycket om och men och nu ska allting fungera.
</p><p class="text">
Intressant är att man inte kan validera edit och delete eftersom dessa sidor kräver att man är inloggad annars die. Jag hoppas dock detta är okej ändå.
</p><p class="text">
Jag hade definitivt behövt lägga till en modul som hanterar ett bildgalleri. En hemsida måste ju ha ett bildgalleri! 
Det blev en liten kortare text den här gången men helt ärligt så finns det inte så mycket att säga. 
</p>

<h2>kmom06</h2>
<p class="text">
Det här var ett moment som tog oerhört lång tid för mig, det blev som en stoppkloss som aldrig kunde bli klart. Väldigt mycket 
kod att ta in, massor nytt på en gång liksom. Jag tror inte jag förstod koden förrens jag hade flyttat in den i en egen anax-modul. 
</p><p class="text">
Jag hade inga erfarenheter av liknande bildhantering, först tyckte jag det verkade lätt, sedan verkade det svårt och så svängde det fram och tillbaka.
Men det fungerade trots motgångarna bra, även om det inte flöt på som de andra kursmomenten gjort. Däremot märkte jag hur lätt det var att lägga på text på bilder 
vilket lär bli ett projekt i framtiden, detta upptäcktes när jag kollade upp några av de funktioner som användes.
</p><p class="text">
PHP GD känns som ett väldigt mäktigt verktyg för att snabba upp en hemsida genom rätt bild-storlekar utan att behöva ladda in massor onödigt stora bilder, det var 
extremt smidigt att skapa thumbnails och jag har länge velat kunna göra detta då jag gillar att fotografera och min hemsida där mina bilder ligger är under all kritik för 
en webbprogrammerare i dagsläget. Jag kommer nog använda väldigt mycket av dom här funktionerna i projektet!
</p><p class="text">
Anax börjar klarna, ju mer jag gör moduler ju mer lyckas jag tänka moduler och inte klasser, vilket var det svåraste hindret för mig i början. 
Nu när man ser hur liten img.php faktisk blev när man bröt ut det till en modul märker man hur smidigt det blir att bygga vidare på det.
</p><p class="text">
En modul som hade varit kul att ha med skulle vara en videospelare, vilket på projektet kanske skulle kunna visa trailers. Det hade varit ballt.
</p><p class="text">
Jag är otroligt nöjd med hur min kod blev tillslut, även om det tog tid och är försenat. När jag väl fick grepp om hur det var tänkt gick det hyffsat fort, själva modulerna 
gjorde jag på totalt ca 5h medans img.php tog mig oerhört mycket mer tid, mest beroende på att jag faktiskt ville förstå koden och inte bara kopiera in och gå vidare.
Jag är mest nöjd över hur liten min img.php faktiskt blev - 10 rader - räknar man bort whitespace och kommentarer är det bara 3. 
</p><p class="text">
Jag ser väldigt mycket fram emot projektet och ska se till att få till en riktigt trevlig hemsida!
</p>

<h2>kmom07/10</h2>
<h3>Krav 1, struktur och innehåll</h3>
<p>Mitt mål här var att få sidorna att på något sätt hänga ihop designmässigt, det skulle inte spreta åt olika håll beroende på var på sidan du befann dig. Jag tycker jag lyckades ganska bra med det målet. Det är samma utseende på nyheterna på förstasidan som på nyhetssidan, filmernas titel har samma font på startsidan som på sidan för detaljerad info om en film. Jag jobbade mycket med design och för att få det att se snyggt ut. Detta återspeglar sig mycket css-filen med dryga 680 rader, även om css-filer är så fluffiga med mycket white-space.</p>
<h3>Krav 2, sida – filmer</h3>
<p>Här ville jag på ett smidigare sätt, än att behöva skapa en ny sida för individuella filmer, visa individuella filmers innehåll. Detta sköts bitvis med javascript. Jag ställde in standard-pageinering på 8 filmer/sida eftersom det såg snyggast ut och för att man skulle slippa ladda in mycket information från start. Det finns alternativ för att visa alla. Här har jag även sett till att man kan sortera på många olika sätt, titel, år, längd, regissör eller pris. Men även genom varje genre.  Sökningen i headern söker efter titel och regissör med automatisk ’%’. All information och den mesta koden ligger i CTable, men lite finns även i CMovie, modulen för att visa individuella filmer.</p>
<h3>Krav 3, sida – Nyheter</h3>
<p>På nyhetssidan möts man av en vägg med ett rutnät av nyhetsinlägg. De är sorterade i publiceringsordning och visas vänster->höger rad för rad. Här syns bara en liten del av innehållet i nyheten med en hänvisning till läs mer som leder till nyheten i sin helhet. Nyheter kan även ha filter som underlättar att visa sin nyhet på ett attraktivt sätt. När man är inloggad får man en ändra- och tabort-knapp vid rubriken när man läser nyheten. Sidan innehåller egentligen bara anrop och html-kod, resten sköts av modulen CBlog, som i sin tur sköts av CContent.</p>
<h3>Krav 4, sida – Första sidan</h3>
<p>På första sidan möts man av de tre senast ändrade filmerna, den absolut senast ändrade visas överst och är fullbredd, medan de andra två delar på bredden under. Detta för att visa vilken ordning de är uppdaterade i utan att behöva visa den informationen. Under dessa syns de tre senast publicerade nyheterna. De räknar inte uppdaterade då en nyhet oftast inte vill hoppa som nyast bara för att man rättar ett stavfel i den.  Sidan avslutas av hetast just nu och senast hyrd. Dessa två är hårdkodade, de ligger med var sin symbolisk bild över sig så man ska se vilken som är vad. Eld för het och tid för senast. Tydlighet. Första sidan innehåller egentligen inget annat än html-kod, alla funktioner för att hämta senaste filmer och nyheter sköts precis som de individuella sidorna genom moduler.</p>
<h3>Adminsidan</h3>
<p>Jag skapade en gemensam admin-sida för att sköta både filmer och nyheter.  Det är ett simpelt gui för att enkelt kunna göra det man vill göra. Här man kan även fylla i genre. Både aktiv genre och bild är förmarkerade när man öppnar redigering för att inte råka spara fel. För filmer kan man även uppdatera bild och rating. Adminsidan ligger som egen modul för att hålla pagecontrollern liten.</p>
<h3>Krav 5,6 – Extrafunktioner</h3>
<b>Ladda upp bild:</b>
<p>När man skapar en film kan man ladda upp en bild att använda. Har man ingen bild just väljs automatiskt en ”no-image”-bild som visas. Man kan därefter ladda upp bild för sig. När man ändrar i en film kan man i en rullista se alla bilder som finns att tillgå. Där kan man i efterhand välja rätt bild. Detta sköts genom en scandir. Uppladdning av bild sköts av CTable. </p>
<b>Tävling:</b>
<p>Dice-spelet är modifierat och nu på plats. När man vinner dyker det upp en kod som är tänkt att användas i kassan vid hyrning. </p>
<b>Egen funktion:</b>
<p>Man kan genom adminpanelen klicka på en stjärn-symbol, rating, som då uppdateras och sparas i databasen. Detta görs genom att en funktion hämtar hem imdb-hemsidans html-kod, letar upp rätt bit av koden och plockar ut ratingen. Substr() och strpos() används. För att kunna uppdatera ratings för alla filmer på en gång, och slippa skicka många förfrågningar mot databas skapas en sql-sats med cases för att kunna köra update för flera rader. Detta var ganska svårt att få till, men det gick. Funktionen att uppdatera alla är lite långsam, men det är inte tänkt att köra den så ofta, utan bara den för en ny film man lagt till. </p>
<h3>Allmänt</h3>
<p>Jag hade väldigt roligt med projektet, det tog lite tid att få tummen ur och börja, det såg ut som ett stort hinder. Men det var bara ett riktigt roligt hiner. Det flöt på otroligt bra och jag är nöjd över resultatet. Det tog mig tre dagar, när jag väl börjar kan jag inte släppa så det tog all vaken tid. Perfekt avslutning av kursen. Visar hur otroligt mycket man hunnit lära sig.</p>
<h3>Avslutning</h3>
<p>Den här kursen har varit väldigt spännande. Jag har lärt mig otroligt mycket. Man får väldigt bra feedback från er. Även om man ibland inte får notifikationer från it’s sådär mot kompletting 2, antar att man inte ska behöva det ;) Värt att tillägga är att jag aldrig klarat detta utan dbwebb-forumet och ircen. </p>


EOD;

// Finally, leave it all to the rendering phase of kittX.
include(KITTX_THEME_PATH);
?>