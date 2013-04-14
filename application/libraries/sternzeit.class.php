<?php

/**
 * Paket für die vier Klassen DatumsUmwandler, Datum, Sternzeit, DatumsFabrik.
 *
 * DatumsUmwandler: Implementiert die Methoden zum Umrechnen zwischen Offplay- und Inplaydaten.
 * Datum: Stellt ein Datum dar. Implementiert die Methoden zum Rechnen mit Daten und Ausgeben von selbigen.
 *  Enthält Aliase zu den Methoden von DatumsUmwandler und
 * Sternzeit: Stellt eine Sternzeit dar. Implementiert Methoden zum Umwandeln von und zu Sternzeiten.
 *  Ausgangspunkt ist immer der 1.1.2323 um 0 Uhr.
 * DatumsFabrik: Erstellt Daten und Sternzeiten aus Strings. Prüft diese auf funktionierendes Format über reguläre Ausdrücke;
 *
 * @author Jason Myrdin - Daniel Müllers
 */

/**
 * Stellt die Methoden zum Umrechnen von Daten bereit.
 */
class DatumsUmwandler {

    /**
     * Offplay-Referenzjahr;
     * @var int
     */
    const OREF = 2010;

    /**
     * Inplay-Refernzjahr
     * @var int
     */
    const IREF = 2386;


    /**
     * Wandelt ein Offplay-Datum in ein Inplay Datum um mittels Schield'scher Umwandlung.
     * @param Datum $datum
     * @return Datum
     */
    public static function offplayToInplay($datum) {
        //echo 'offplayToInplay: Datum: ' . $datum . "\n";
        $ojahr = $datum->getJahr();
        //echo 'offplayToInplay: $ojahr: ' . $ojahr . "\n";
        $halbjahr = floor(($datum->getMonat() - 1) / 6);
        //echo 'offplayToInplay: $halbjahr: ' . $halbjahr . "\n";
        $ijahr = DatumsUmwandler::IREF + $halbjahr + ($ojahr - DatumsUmwandler::OREF) * 2;
        //echo 'offplayToInplay: $ijahr: ' . $ijahr . "\n";

        if($halbjahr == 0) {
            $otage = 362;
            if($ojahr % 4 == 0) $otage += 2;
        } else {
            $otage = 368;
        }
        $itage = 365;
        if ($ijahr % 4 == 0) $itage += 1;
        //echo 'offplayToInplay: $otage: ' . $otage . "\n";
        //echo 'offplayToInplay: $itage: ' . $itage . "\n";
        $faktor = $itage * 2 / $otage;
        //echo 'offplayToInplay: $faktor: ' . $faktor . "\n";

        $zeit = round($faktor * $datum->diff(new Datum(1, $halbjahr * 6 + 1, $ojahr)));
        //echo 'offplayToInplay: $zeit: ' . $zeit . "\n";
        $return = new Datum(1, 1, $ijahr);
        //echo 'offplayToInplay: $return: ' . $return . "\n";
        $return->add($zeit);
        return $return;
    }

    /**
     * Wandelt ein Inplay-Datum in ein Offplay-Datum um mittels Schield'scher Umwandlung.
     * @param Datum $datum
     * @return Datum
     */
    public static function inplayToOffplay($datum) {
        //echo "inplayToOffplay: Datum: " . $datum . "\n";
        $ijahr = $datum->getJahr();
        $halbjahr = $ijahr % 2;
        //echo "inplayToOffplay: Halbjahr: ". $halbjahr . "\n";
        $ojahr = self::OREF + floor(($ijahr - self::IREF) / 2);
        //echo "inplayToOffplay: \$ojahr: ". $ojahr . "\n";

        if($halbjahr == 0) {
            $otage = 362;
            if($ojahr % 4 == 0) $otage += 2;
        } else {
            $otage = 368;
        }
        $itage = 365;
        if ($ijahr % 4 == 0) $itage += 1;
        //echo "inplayToOffplay: \$otage: ". $otage . "\n";
        //echo "inplayToOffplay: \$itage: ". $itage . "\n";
        $faktor = $otage / $itage / 2;
        //echo "inplayToOffplay: Faktor: " . $faktor . "\n";

        $zeit = round($faktor * $datum->diff(new Datum(1, 1, $ijahr)));
        //echo "inplayToOffplay: Zeit: " . $zeit . "\n";
        $return = new Datum(1, $halbjahr * 6 + 1, $ojahr);
        $return->add($zeit);
        return $return;
    }

}


/**
 * Repräsentiert ein Datum
 */
class Datum {
    private $tag;
    private $monat;
    private $jahr;
    private $stunde;
    private $minute;
    private $sekunde;
    private $monatstage = array(31,28,31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    private $msummen = array(0, 31,59,90,120,151,181,212,243,273,304,334,365);
    private $msummens = array(0, 31,60,91,121,152,182,213,244,274,305,335,366);

    public static $MONATE = array("", "Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
    public static $WOCHENTAGE = array("Samstag", "Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag");


    /**
     * Erstellt ein neues Datum-Objekt
     */
    public function  __construct($tag = 1, $monat = 1, $jahr = 2010, $stunde = 0, $minute = 0, $sekunde = 0) {
        $this->tag = $tag;
        $this->monat = $monat;
        $this->jahr = $jahr;
        $this->stunde = $stunde;
        $this->minute = $minute;
        $this->sekunde = $sekunde;
    }

    /**
     * Erstellt ein Datum von einem Unixtimestamp;
     * @param int $time
     * @return Datum
     */
    public static function createFromTimestamp($time = null) {
        if ($time == null) $time = time();
        return new Datum(date("d", $time), date("n", $time), date("Y", $time), date("G", $time), date("i", $time), date("s", $time));
    }

    /**
     * Erstellt ein Datum aus einer Sternzeit. Alias für Sternzeit->toDatum.
     * @param Sternzeit $sternzeit
     */
    public static function createFromSternzeit($sternzeit) {
        return $sternzeit->toDatum;
    }


    /**
     * Berechnet die Differenz in Sekunden zwischen zwei Daten.
     * @param Datum $datum
     * @return int Differenz in Sekunden
     */
    public function diff($datum) {
        //echo "\n<u>Datum::diff</u> ---\n";
        $f = $this->compare($datum);
        $d2 = $datum;
        $d1 = $this;
        if($f > 0) {
            $d2 = $this;
            $d1 = $datum;
        }
        //echo "diff: Kleineres Datum: $d1 \n";
        //echo "diff: Gr&ouml;&szlig;eres Datum:  $d2 \n";
        $referenz = floor($d1->getJahr() / 10) * 10;
        //echo "diff: Referenz: " . $referenz . "\n";

        $schalttage1 = (($d1->getJahr() - $referenz) - ($d1->getJahr() % 4) + ($referenz % 4)) / 4;
        $schalttage2 = (($d2->getJahr() - $referenz) - ($d2->getJahr() % 4) + ($referenz % 4)) / 4;
        //echo "diff: Schalttage 1,2: " . $schalttage1 . ", " . $schalttage2 . "\n";
        //echo "diff: Schaltjahr?: " . ($d1->getJahr() % 4) . "\n";
        if($d1->getJahr() % 4 == 0) $monate = $this->msummens;
        else $monate = $this->msummen;
        $zeit1 = (
                (
                        (
                                (
                                        $d1->getJahr() - $referenz
                                        ) * 365 + $schalttage1 + $monate[$d1->monat - 1] + $d1->tag - 0
                                ) * 24 + $d1->stunde
                        ) * 60 + $d1->minute
                ) * 60 + $d1->sekunde;
        //echo "diff: 1: m" . $monate[$d1->monat - 1] . " t" . $d1->tag . "\n";
        if($d2->getJahr() % 4 == 0) $monate = $this->msummens;
        else $monate = $monate = $this->msummen;
        $zeit2 = (
                (
                        (
                                (
                                        $d2->getJahr() - $referenz
                                        ) * 365 + $schalttage2 + $monate[$d2->monat - 1] + $d2->tag
                                ) * 24 + $d2->stunde
                        ) * 60 + $d2->minute
                ) * 60 + $d2->sekunde;
        //echo "diff: 2: m" . $monate[$d2->monat - 1] . " t" . $d2->tag . "\n";
        //echo "diff: Zeiten 1,2: " . $zeit1 . ", " . $zeit2 . "\n";
        //echo "diff: Differenz: " . $f * ($zeit2 - $zeit1) . "\n";
        //echo "--- <u>Datum::diff</u>\n\n";
        return $f * ($zeit2 - $zeit1);
    }


    /**
     * Vergleicht dieses Datum mit einem anderen.
     * @param Datum $datum
     * @return int 1 falls das gegebene Datum vor dem des Objekts, 0 falls beide gleich, -1 falls das gegebene Datum nach dem des Objekts.
     */
    public function compare($datum) {
        $d1 = $this->toArray();
        $d2 = $datum->toArray();

        for ($i = 0;
        $i < 6;
        $i++) {
            //echo "compare: $d1[$i] - $d2[$i]\n";
            if($d1[$i] > $d2[$i]) return 1;
            if($d1[$i] < $d2[$i]) return -1;
        }
        return 0;
    }

    /**
     * Addiert Sekunden zu einem Datum
     * @param int $sekunden
     */
    public function add ($sekunden) {
        //echo "\n<u>Datum::add</u> ---\n";
        while($sekunden < 0) {
            $jahrestage = 365;
            if(($this->jahr % 4 == 0 && $this->compare(new Datum (1,3,$this->jahr)) > 0)
                    || ($this->jahr % 4 == 1 && $this->compare(new Datum (1,3,$this->jahr)) < 0)) {
                $jahrestage = 366;
            }
            $this->jahr--;
            $sekunden += 60 * 60 * 24 * $jahrestage;
        }
        $minuten = intval($sekunden / 60);
        $sekunden -= $minuten * 60;
        $stunden = intval($minuten / 60);
        $minuten -= $stunden * 60;
        $tage = intval($stunden / 24);
        $stunden -= $tage * 24;

        //echo 'add: Datum ' . $this . "\n";
        //echo 'add: $sekunden: '. $sekunden . "\n";
        //echo 'add: $minuten: '. $minuten . "\n";
        //echo 'add: $stunden: '. $stunden . "\n";
        //echo 'add: $tage: '. $tage . "\n";

        $minuten += intval(($this->sekunde + $sekunden) / 60);
        $this->sekunde = ($this->sekunde + $sekunden) % 60;
        $stunden += intval(($this->minute + $minuten) / 60);
        $this->minute = ($this->minute + $minuten) % 60;
        $tage += intval(($this->stunde + $stunden) / 24);
        $this->stunde = ($this->stunde + $stunden) % 24;

        $tage += $this->tag;
        while($tage > Datum::tageImJahr($this->jahr)) {
            $tage -= Datum::tageImJahr($this->jahr);
            $this->jahr++;
        }
        //echo 'add: $tage: '. $tage . "\n";
        //echo 'add: tageImJahr: '. Datum::tageImJahr($this->jahr) . "\n";

        $monate = $this->monatstage;
        if($this->jahr % 4 == 0) $monate[1] = 29; //Schaltjahr-Fix
        //echo "add: Schaltjahr-Fix: ". $monate[1] . "\n";

        //echo 'add: Monate: ';
        for($i = $this->monat - 1; $tage > $monate[$i]; $i++) {
            $tage -= $monate[$i];
            $this->monat++;
            //echo "(m" . $this->monat . " i" . $i . " t" . $tage . " mt" . $monate[$i] . ") ";
        }
        //echo "\n";
        //echo 'add: $tage: '. $tage . "\n";
        //echo "--- <u>Datum::add</u>\n\n";
        $this->tag = $tage;
    }


    /**
     * Gibt die Anzahl der Tage in einem gegebenen Jahr zurück;
     * @param int $jahr
     * @return int Die Tage.
     */
    public static function tageImJahr($jahr) {
        if ($jahr % 4 == 0) return 366;
        else return 365;
    }

    /**
     * Gibt das Datum als ein nummeriertes Array wieder.
     * @return int[] Das Array
     */
    public function toArray() {
        $arr[] = $this->jahr;
        $arr[] = $this->monat;
        $arr[] = $this->tag;
        $arr[] = $this->stunde;
        $arr[] = $this->minute;
        $arr[] = $this->sekunde;
        return $arr;
    }

    /**
     * Alias für SternzeitRechner::offplayToInplay.
     * Wandelt dieses Datum in ein Inplaydatum.
     * @return Datum
     */
    public function toInplay() {
        return DatumsUmwandler::offplayToInplay($this);
    }

    /**
     * Alias für SternzeitRechner::inplayToOffplay.
     * Wandelt dieses Datum in ein Offplaydatum.
     * @return Datum
     */
    public function toOffplay() {
        return DatumsUmwandler::inplayToOffplay($this);
    }

    /**
     * Alias für Sternzeit::createFromDatum.
     * Rechnet das Datum in eine Sternzeit um und gibt diese zurück;
     * @return Sternzeit die Sternzeit
     */
    public function toSternzeit() {
        return Sternzeit::createFromDatum($this);
    }

    /**
     * Berechnet den Wochentag des Datums nach Zellers Kongruenz.
     * Die Woche beginnt mit Samstag als 0. Tag der Woche.
     * @return int Der Wochentag.
     */
    public function zellersKongruenz() {
        $q = $this->tag;
        $m = $this->monat;
        $y = $this->getJahr();
        if($m < 3) {
            $m += 12;
            $y--;
        }
        $J = floor($y / 100);
        $K = $y - $J * 100;

        $h = ($q + floor( ($m + 1) * 2.6 ) + $K
                        + floor( $K / 4 ) + floor( $J / 4 ) - 2 * $J) % 7;


        return $h;
    }

    /**
     * Gibt eine Repräsentation des Objekts als String aus.
     * @return String
     */
    public function __toString () {
        return $this->format("D j. F Y H:i:s");

    }

    /**
     * Gibt das Datum als String zurück. Format nach PHP::date().
     * Nicht unterstützt: a,e,g,h,o,r,u,z,A,B,I,N,O,P,S,T,U,W,Z
     * @param String $string Eingabe.
     * @return String;
     */
    public function format($string) {
        $replace = array();

        /** TAG **/
        $replace["d"] = str_pad($this->tag, 2, '0', STR_PAD_LEFT);
        $replace["D"] = substr(Datum::$WOCHENTAGE[$this->zellersKongruenz()], 0, 2);
        $replace["j"] = $this->tag;
        $replace["l"] = Datum::$WOCHENTAGE[$this->zellersKongruenz()];
        $replace["w"] = ($this->zellersKongruenz() + 6) % 7;

        /** Monat **/
        $replace["F"] = Datum::$MONATE[$this->monat];
        $replace["m"] = str_pad($this->monat, 2, '0', STR_PAD_LEFT);
        $replace["M"] = substr(Datum::$MONATE[$this->monat], 0, 3);
        $replace["n"] = $this->monat;
        $replace["t"] = $this->monatstage[$this->monat - 1];

        /** Jahr **/
        if ($this->jahr % 4 == 0)
            $replace["L"] = 1;
        else
            $replace["L"] = 0;
        $replace["Y"] = $this->jahr;
        $replace["y"] = $this->jahr - floor($this->jahr / 100) * 100;

        /** Zeit **/
        $replace['G'] = $this->stunde;
        $replace['H'] = str_pad($this->stunde, 2, '0', STR_PAD_LEFT);
        $replace["i"] = str_pad($this->minute, 2, '0', STR_PAD_LEFT);
        $replace["s"] = str_pad($this->sekunde, 2, '0', STR_PAD_LEFT);

        /** Volles Datum/Zeit **/
        $replace["c"] = $this->jahr."-".str_pad($this->monat, 2, '0', STR_PAD_LEFT)
                ."-".str_pad($this->tag, 2, '0', STR_PAD_LEFT)
                ."T".str_pad($this->stunde, 2, '0', STR_PAD_LEFT).":"
                .str_pad($this->minute, 2, '0', STR_PAD_LEFT).":"
                .str_pad($this->sekunde, 2, '0', STR_PAD_LEFT)."+00:00";

        //var_dump($replace);
        //echo "\n\n";
        //echo "$string \n\n";

        $output = "";
        for($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            foreach($replace as $k => $v) {
                if ($char === $k) {
                    $char = $v;
                    break;
                }
            }
            $output .= $char;
        }
        return $output;
    }

    /** -- Getter -- **/

    public function getTag() {
        return $this->tag;
    }

    public function getMonat() {
        return $this->monat;
    }

    public function getJahr() {
        return $this->jahr;
    }

    public function getStunde() {
        return $this->stunde;
    }

    public function getMinute() {
        return $this->minute;
    }

    public function getSekunde() {
        return $this->sekunde;
    }
}

/**
 * Repräsentiert eine Sternzeit;
 */
class Sternzeit {

    private $sternzeit;
    const FAKTOR = 0.000031688087814028950237026896848937;

    public function  __construct($sternzeit) {
        $this->sternzeit = $sternzeit;
    }

    /**
     * Erstellt eine Sternzeit aus einem Datum.
     * @param Datum $datum
     * @return Sternzeit
     */
    public static function createFromDatum($datum) {
        $referenz = $datum->getJahr() + 3 - ($datum->getJahr() % 4);
        //echo "createFromDate: referenz: " . $referenz . "\n";
        $zeit =  Sternzeit::FAKTOR * $datum->diff(new Datum(1, 1, $referenz));
        //echo "createFromDate: zeit: " . $zeit . "\n" ;
        $jahr = ($referenz - 2323) * 1000;
        //echo "createFromDate: jahr: " . $jahr . "\n";

        if($datum->getJahr() % 4 == 0) {
            $zeit -= 1000 / 365.25;
            //echo "createFromDate: Leap-Fix!\n";
        }
        //$datum = new Datum(0,0,0);
        //$datum->add(1 / Sternzeit::FAKTOR * -1 * $zeit);
        //echo "createFromDate: Differenz: " . $datum . "\n";
        //echo "createFromDate: Ausgabe: " . ($jahr + $zeit) . "\n";
        return new Sternzeit($jahr + $zeit);
    }

    /**
     * Wandelt die Sternzeit in gregorianisches Datum um.
     * @return Datum Das Datum
     */
    public function toDate() {
        $zeit = $this->sternzeit / Sternzeit::FAKTOR;
        $d = new Datum(1,1,2323);
        $d->add($zeit);
        return $d;
    }

    /**
     * Gibt eine Repräsentation des Objekts als String aus.
     * @return String
     */
    public function  __toString() {
        return number_format($this->sternzeit, 2, ",", "");
    }

    /** Getter **/

    public function getSternzeit() {
        return "" . $this;
    }
}

/**
 * Stellt Methoden bereit, um Daten und Sternzeiten sicher aus Strings zu erstellen.
 */
class DatumsFabrik {

    /**
     * String der From dd.mm.[YY]YY hh:mm[:ss]. [] Optionial.
     */
    const DATUMZEIT = "/([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{2,4}) ([0-9]{1,2}):([0-9]{2}):{0,1}([0-9]{0,2})/";

    /**
     * String der Form dd.mm.[YY]YY. [] Optional.
     */
    const DATUM = "/([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{2,4})/";

    /**
     * String der Form [...zzzzzz]z[,zzzzz...]. [] optional.
     */
    const STERNZEIT = "/^\-{0,1}[0-9]{1,}\,?[0-9]{0,}$/";

    public static function parseToDatum($string) {
        if(preg_match(DatumsFabrik::DATUMZEIT, $string, $matches) > 0) {
            return new Datum(0 + $matches[1], 0 + $matches[2], 0 + $matches[3], 0 + $matches[4], 0 + $matches[5], 0 + $matches[6]);
        } elseif(preg_match(DatumsFabrik::DATUM, $string, $matches) > 0) {
            return new Datum(0 + $matches[1], 0 + $matches[2], 0 + $matches[3], 0, 0, 0);
        } else {
            return false;
        }
    }

    public static function advancedParseToDatum($string) {
        if(DatumsFabrik::parseToDatum($string))
            return DatumsFabrik::parseToDatum($string);
        if(preg_match("/jetzt/", $string) > 0) {
            return Datum::createFromTimestamp();
        } elseif(preg_match("/heute/", $string) > 0) {
            return new Datum(date("d"), date("n"), date("Y"));
        } elseif(preg_match("/^morgen/", $string) > 0) {
            $x = time() + 86400;
            return new Datum(date("d", $x), date("n", $x), date("Y", $x));
        } elseif(preg_match("/bermorgen/", $string) > 0) {
            $x = time() + 2 * 86400;
            return new Datum(date("d", $x), date("n", $x), date("Y", $x));
        } elseif(preg_match("/vorgestern/", $string) > 0) {
            $x = time() - 2 * 86400;
            return new Datum(date("d", $x), date("n", $x), date("Y", $x));
        } elseif(preg_match("/gestern/", $string) > 0) {
            $x = time() - 86400;
            return new Datum(date("d", $x), date("n", $x), date("Y", $x));
        } elseif(substr($string, 0,1) === "+" | substr($string, 0,1) === "+") {
            preg_match("/(\+?\-?[0-9]{1,}) tage?/i", $string, $tage);
            preg_match("/(\+?\-?[0-9]{1,}) wochen?/i", $string, $wochen);
            preg_match("/(\+?\-?[0-9]{1,}) monate?/i", $string, $monate);
            preg_match("/(\+?\-?[0-9]{1,}) jahre?/i", $string, $jahre);
            preg_match("/(\+?\-?[0-9]{1,}) stunden?/i", $string, $stunden);
            preg_match("/(\+?\-?[0-9]{1,}) minuten?/i", $string, $minuten);
            preg_match("/(\+?\-?[0-9]{1,}) sekunden?/i", $string, $sekunden);

            $str = "+". (0 + $tage[1])." days ". (0 + $wochen[1])." weeks ". (0 + $jahre[1]) ." years "
                . (0 + $monate[1])." months ".(0 + $stunden[1])." hours ".(0 + $minuten[1])." minutes "
                . (0 + $sekunden[1]) . " seconds";
            $zeit = strtotime($str);
            return Datum::createFromTimestamp($zeit);
        } else {
            return false;
        }
    }

    public static function parseToSternzeit($string) {
        if(preg_match(DatumsFabrik::STERNZEIT, $string)) {
            $string = preg_replace("/\,/", ".", $string);
            return new Sternzeit($string);
        } else {
            return false;
        }
    }

}