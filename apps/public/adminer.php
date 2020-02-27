<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
* @version 4.7.6
*/error_reporting(6135);$uc=!preg_match('~^(unsafe_raw)?$~', ini_get("filter.default")); if ($uc||ini_get("filter.default_flags")) {
    foreach (array('_GET','_POST','_COOKIE','_SERVER')as$X) {
        $bh=filter_input_array(constant("INPUT$X"), FILTER_UNSAFE_RAW);
        if ($bh) {
            $$X=$bh;
        }
    }
} if (function_exists("mb_internal_encoding")) {
    mb_internal_encoding("8bit");
}function connection()
{
    global$f;
    return$f;
}function adminer()
{
    global$b;
    return$b;
}function version()
{
    global$ga;
    return$ga;
}function idf_unescape($v)
{
    $td=substr($v, -1);
    return
str_replace($td.$td, $td, substr($v, 1, -1));
}function escape_string($X)
{
    return
substr(q($X), 1, -1);
}function number($X)
{
    return
preg_replace('~[^0-9]+~', '', $X);
}function number_type()
{
    return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';
}function remove_slashes($gf, $uc=false)
{
    if (get_magic_quotes_gpc()) {
        while (list($z, $X)=each($gf)) {
            foreach ($X
as$ld=>$W) {
                unset($gf[$z][$ld]);
                if (is_array($W)) {
                    $gf[$z][stripslashes($ld)]=$W;
                    $gf[]=&$gf[$z][stripslashes($ld)];
                } else {
                    $gf[$z][stripslashes($ld)]=($uc?$W:stripslashes($W));
                }
            }
        }
    }
}function bracket_escape($v, $Aa=false)
{
    static$Og=array(':'=>':1',']'=>':2','['=>':3','"'=>':4');
    return
strtr($v, ($Aa?array_flip($Og):$Og));
}function min_version($qh, $Fd="", $g=null)
{
    global$f;
    if (!$g) {
        $g=$f;
    }
    $Of=$g->server_info;
    if ($Fd&&preg_match('~([\d.]+)-MariaDB~', $Of, $C)) {
        $Of=$C[1];
        $qh=$Fd;
    }
    return(version_compare($Of, $qh)>=0);
}function charset($f)
{
    return(min_version("5.5.3", 0, $f)?"utf8mb4":"utf8");
}function script($Xf, $Ng="\n")
{
    return"<script".nonce().">$Xf</script>$Ng";
}function script_src($gh)
{
    return"<script src='".h($gh)."'".nonce()."></script>\n";
}function nonce()
{
    return' nonce="'.get_nonce().'"';
}function target_blank()
{
    return' target="_blank" rel="noreferrer noopener"';
}function h($hg)
{
    return
str_replace("\0", "&#0;", htmlspecialchars($hg, ENT_QUOTES, 'utf-8'));
}function nl_br($hg)
{
    return
str_replace("\n", "<br>", $hg);
}function checkbox($E, $Y, $Oa, $pd="", $qe="", $Sa="", $qd="")
{
    $K="<input type='checkbox' name='$E' value='".h($Y)."'".($Oa?" checked":"").($qd?" aria-labelledby='$qd'":"").">".($qe?script("qsl('input').onclick = function () { $qe };", ""):"");
    return($pd!=""||$Sa?"<label".($Sa?" class='$Sa'":"").">$K".h($pd)."</label>":$K);
}function optionlist($ue, $Jf=null, $kh=false)
{
    $K="";
    foreach ($ue
as$ld=>$W) {
        $ve=array($ld=>$W);
        if (is_array($W)) {
            $K.='<optgroup label="'.h($ld).'">';
            $ve=$W;
        }
        foreach ($ve
as$z=>$X) {
            $K.='<option'.($kh||is_string($z)?' value="'.h($z).'"':'').(($kh||is_string($z)?(string)$z:$X)===$Jf?' selected':'').'>'.h($X);
        }
        if (is_array($W)) {
            $K.='</optgroup>';
        }
    }
    return$K;
}function html_select($E, $ue, $Y="", $pe=true, $qd="")
{
    if ($pe) {
        return"<select name='".h($E)."'".($qd?" aria-labelledby='$qd'":"").">".optionlist($ue, $Y)."</select>".(is_string($pe)?script("qsl('select').onchange = function () { $pe };", ""):"");
    }
    $K="";
    foreach ($ue
as$z=>$X) {
        $K.="<label><input type='radio' name='".h($E)."' value='".h($z)."'".($z==$Y?" checked":"").">".h($X)."</label>";
    }
    return$K;
}function select_input($xa, $ue, $Y="", $pe="", $Te="")
{
    $wg=($ue?"select":"input");
    return"<$wg$xa".($ue?"><option value=''>$Te".optionlist($ue, $Y, true)."</select>":" size='10' value='".h($Y)."' placeholder='$Te'>").($pe?script("qsl('$wg').onchange = $pe;", ""):"");
}function confirm($D="", $Kf="qsl('input')")
{
    return
script("$Kf.onclick = function () { return confirm('".($D?js_escape($D):lang(0))."'); };", "");
}function print_fieldset($u, $yd, $th=false)
{
    echo"<fieldset><legend>","<a href='#fieldset-$u'>$yd</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$u');", ""),"</legend>","<div id='fieldset-$u'".($th?"":" class='hidden'").">\n";
}function bold($Ha, $Sa="")
{
    return($Ha?" class='active $Sa'":($Sa?" class='$Sa'":""));
}function odd($K=' class="odd"')
{
    static$t=0;
    if (!$K) {
        $t=-1;
    }
    return($t++%2?$K:'');
}function js_escape($hg)
{
    return
addcslashes($hg, "\r\n'\\/");
}function json_row($z, $X=null)
{
    static$vc=true;
    if ($vc) {
        echo"{";
    }
    if ($z!="") {
        echo($vc?"":",")."\n\t\"".addcslashes($z, "\r\n\t\"\\/").'": '.($X!==null?'"'.addcslashes($X, "\r\n\"\\/").'"':'null');
        $vc=false;
    } else {
        echo"\n}\n";
        $vc=true;
    }
}function ini_bool($Zc)
{
    $X=ini_get($Zc);
    return(preg_match('~^(on|true|yes)$~i', $X)||(int)$X);
}function sid()
{
    static$K;
    if ($K===null) {
        $K=(SID&&!($_COOKIE&&ini_bool("session.use_cookies")));
    }
    return$K;
}function set_password($ph, $O, $V, $G)
{
    $_SESSION["pwds"][$ph][$O][$V]=($_COOKIE["adminer_key"]&&is_string($G)?array(encrypt_string($G, $_COOKIE["adminer_key"])):$G);
}function get_password()
{
    $K=get_session("pwds");
    if (is_array($K)) {
        $K=($_COOKIE["adminer_key"]?decrypt_string($K[0], $_COOKIE["adminer_key"]):false);
    }
    return$K;
}function q($hg)
{
    global$f;
    return$f->quote($hg);
}function get_vals($I, $c=0)
{
    global$f;
    $K=array();
    $J=$f->query($I);
    if (is_object($J)) {
        while ($L=$J->fetch_row()) {
            $K[]=$L[$c];
        }
    }
    return$K;
}function get_key_vals($I, $g=null, $Rf=true)
{
    global$f;
    if (!is_object($g)) {
        $g=$f;
    }
    $K=array();
    $J=$g->query($I);
    if (is_object($J)) {
        while ($L=$J->fetch_row()) {
            if ($Rf) {
                $K[$L[0]]=$L[1];
            } else {
                $K[]=$L[0];
            }
        }
    }
    return$K;
}function get_rows($I, $g=null, $l="<p class='error'>")
{
    global$f;
    $fb=(is_object($g)?$g:$f);
    $K=array();
    $J=$fb->query($I);
    if (is_object($J)) {
        while ($L=$J->fetch_assoc()) {
            $K[]=$L;
        }
    } elseif (!$J&&!is_object($g)&&$l&&defined("PAGE_HEADER")) {
        echo$l.error()."\n";
    }
    return$K;
}function unique_array($L, $x)
{
    foreach ($x
as$w) {
        if (preg_match("~PRIMARY|UNIQUE~", $w["type"])) {
            $K=array();
            foreach ($w["columns"]as$z) {
                if (!isset($L[$z])) {
                    continue
2;
                }
                $K[$z]=$L[$z];
            }
            return$K;
        }
    }
}function escape_key($z)
{
    if (preg_match('(^([\w(]+)('.str_replace("_", ".*", preg_quote(idf_escape("_"))).')([ \w)]+)$)', $z, $C)) {
        return$C[1].idf_escape(idf_unescape($C[2])).$C[3];
    }
    return
idf_escape($z);
}function where($Z, $n=array())
{
    global$f,$y;
    $K=array();
    foreach ((array)$Z["where"]as$z=>$X) {
        $z=bracket_escape($z, 1);
        $c=escape_key($z);
        $K[]=$c.($y=="sql"&&is_numeric($X)&&preg_match('~\.~', $X)?" LIKE ".q($X):($y=="mssql"?" LIKE ".q(preg_replace('~[_%[]~', '[\0]', $X)):" = ".unconvert_field($n[$z], q($X))));
        if ($y=="sql"&&preg_match('~char|text~', $n[$z]["type"])&&preg_match("~[^ -@]~", $X)) {
            $K[]="$c = ".q($X)." COLLATE ".charset($f)."_bin";
        }
    }
    foreach ((array)$Z["null"]as$z) {
        $K[]=escape_key($z)." IS NULL";
    }
    return
implode(" AND ", $K);
}function where_check($X, $n=array())
{
    parse_str($X, $Na);
    remove_slashes(array(&$Na));
    return
where($Na, $n);
}function where_link($t, $c, $Y, $re="=")
{
    return"&where%5B$t%5D%5Bcol%5D=".urlencode($c)."&where%5B$t%5D%5Bop%5D=".urlencode(($Y!==null?$re:"IS NULL"))."&where%5B$t%5D%5Bval%5D=".urlencode($Y);
}function convert_fields($d, $n, $N=array())
{
    $K="";
    foreach ($d
as$z=>$X) {
        if ($N&&!in_array(idf_escape($z), $N)) {
            continue;
        }
        $va=convert_field($n[$z]);
        if ($va) {
            $K.=", $va AS ".idf_escape($z);
        }
    }
    return$K;
}function cookie($E, $Y, $Ad=2592000)
{
    global$ba;
    return
header("Set-Cookie: $E=".urlencode($Y).($Ad?"; expires=".gmdate("D, d M Y H:i:s", time()+$Ad)." GMT":"")."; path=".preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]).($ba?"; secure":"")."; HttpOnly; SameSite=lax", false);
}function restart_session()
{
    if (!ini_bool("session.use_cookies")) {
        session_start();
    }
}function stop_session($xc=false)
{
    $jh=ini_bool("session.use_cookies");
    if (!$jh||$xc) {
        session_write_close();
        if ($jh&&@ini_set("session.use_cookies", false)===false) {
            session_start();
        }
    }
}function &get_session($z)
{
    return$_SESSION[$z][DRIVER][SERVER][$_GET["username"]];
}function set_session($z, $X)
{
    $_SESSION[$z][DRIVER][SERVER][$_GET["username"]]=$X;
}function auth_url($ph, $O, $V, $j=null)
{
    global$Jb;
    preg_match('~([^?]*)\??(.*)~', remove_from_uri(implode("|", array_keys($Jb))."|username|".($j!==null?"db|":"").session_name()), $C);
    return"$C[1]?".(sid()?SID."&":"").($ph!="server"||$O!=""?urlencode($ph)."=".urlencode($O)."&":"")."username=".urlencode($V).($j!=""?"&db=".urlencode($j):"").($C[2]?"&$C[2]":"");
}function is_ajax()
{
    return($_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest");
}function redirect($B, $D=null)
{
    if ($D!==null) {
        restart_session();
        $_SESSION["messages"][preg_replace('~^[^?]*~', '', ($B!==null?$B:$_SERVER["REQUEST_URI"]))][]=$D;
    }
    if ($B!==null) {
        if ($B=="") {
            $B=".";
        }
        header("Location: $B");
        exit;
    }
}function query_redirect($I, $B, $D, $of=true, $hc=true, $oc=false, $Cg="")
{
    global$f,$l,$b;
    if ($hc) {
        $dg=microtime(true);
        $oc=!$f->query($I);
        $Cg=format_time($dg);
    }
    $Zf="";
    if ($I) {
        $Zf=$b->messageQuery($I, $Cg, $oc);
    }
    if ($oc) {
        $l=error().$Zf.script("messagesPrint();");
        return
false;
    }
    if ($of) {
        redirect($B, $D.$Zf);
    }
    return
true;
}function queries($I)
{
    global$f;
    static$jf=array();
    static$dg;
    if (!$dg) {
        $dg=microtime(true);
    }
    if ($I===null) {
        return
array(implode("\n", $jf),format_time($dg));
    }
    $jf[]=(preg_match('~;$~', $I)?"DELIMITER ;;\n$I;\nDELIMITER ":$I).";";
    return$f->query($I);
}function apply_queries($I, $S, $dc='table')
{
    foreach ($S
as$Q) {
        if (!queries("$I ".$dc($Q))) {
            return
false;
        }
    }
    return
true;
}function queries_redirect($B, $D, $of)
{
    list($jf, $Cg)=queries(null);
    return
query_redirect($jf, $B, $D, $of, false, !$of, $Cg);
}function format_time($dg)
{
    return
lang(1, max(0, microtime(true)-$dg));
}function remove_from_uri($Ie="")
{
    return
substr(preg_replace("~(?<=[?&])($Ie".(SID?"":"|".session_name()).")=[^&]*&~", '', "$_SERVER[REQUEST_URI]&"), 0, -1);
}function pagination($F, $qb)
{
    return" ".($F==$qb?$F+1:'<a href="'.h(remove_from_uri("page").($F?"&page=$F".($_GET["next"]?"&next=".urlencode($_GET["next"]):""):"")).'">'.($F+1)."</a>");
}function get_file($z, $yb=false)
{
    $sc=$_FILES[$z];
    if (!$sc) {
        return
null;
    }
    foreach ($sc
as$z=>$X) {
        $sc[$z]=(array)$X;
    }
    $K='';
    foreach ($sc["error"]as$z=>$l) {
        if ($l) {
            return$l;
        }
        $E=$sc["name"][$z];
        $Kg=$sc["tmp_name"][$z];
        $gb=file_get_contents($yb&&preg_match('~\.gz$~', $E)?"compress.zlib://$Kg":$Kg);
        if ($yb) {
            $dg=substr($gb, 0, 3);
            if (function_exists("iconv")&&preg_match("~^\xFE\xFF|^\xFF\xFE~", $dg, $uf)) {
                $gb=iconv("utf-16", "utf-8", $gb);
            } elseif ($dg=="\xEF\xBB\xBF") {
                $gb=substr($gb, 3);
            }
            $K.=$gb."\n\n";
        } else {
            $K.=$gb;
        }
    }
    return$K;
}function upload_error($l)
{
    $Ld=($l==UPLOAD_ERR_INI_SIZE?ini_get("upload_max_filesize"):0);
    return($l?lang(2).($Ld?" ".lang(3, $Ld):""):lang(4));
}function repeat_pattern($Re, $zd)
{
    return
str_repeat("$Re{0,65535}", $zd/65535)."$Re{0,".($zd%65535)."}";
}function is_utf8($X)
{
    return(preg_match('~~u', $X)&&!preg_match('~[\0-\x8\xB\xC\xE-\x1F]~', $X));
}function shorten_utf8($hg, $zd=80, $lg="")
{
    if (!preg_match("(^(".repeat_pattern("[\t\r\n -\x{10FFFF}]", $zd).")($)?)u", $hg, $C)) {
        preg_match("(^(".repeat_pattern("[\t\r\n -~]", $zd).")($)?)", $hg, $C);
    }
    return
h($C[1]).$lg.(isset($C[2])?"":"<i>…</i>");
}function format_number($X)
{
    return
strtr(number_format($X, 0, ".", lang(5)), preg_split('~~u', lang(6), -1, PREG_SPLIT_NO_EMPTY));
}function friendly_url($X)
{
    return
preg_replace('~[^a-z0-9_]~i', '-', $X);
}function hidden_fields($gf, $Vc=array())
{
    $K=false;
    while (list($z, $X)=each($gf)) {
        if (!in_array($z, $Vc)) {
            if (is_array($X)) {
                foreach ($X
as$ld=>$W) {
                    $gf[$z."[$ld]"]=$W;
                }
            } else {
                $K=true;
                echo'<input type="hidden" name="'.h($z).'" value="'.h($X).'">';
            }
        }
    }
    return$K;
}function hidden_fields_get()
{
    echo(sid()?'<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">':''),(SERVER!==null?'<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">':""),'<input type="hidden" name="username" value="'.h($_GET["username"]).'">';
}function table_status1($Q, $pc=false)
{
    $K=table_status($Q, $pc);
    return($K?$K:array("Name"=>$Q));
}function column_foreign_keys($Q)
{
    global$b;
    $K=array();
    foreach ($b->foreignKeys($Q)as$o) {
        foreach ($o["source"]as$X) {
            $K[$X][]=$o;
        }
    }
    return$K;
}function enum_input($U, $xa, $m, $Y, $Xb=null)
{
    global$b;
    preg_match_all("~'((?:[^']|'')*)'~", $m["length"], $Gd);
    $K=($Xb!==null?"<label><input type='$U'$xa value='$Xb'".((is_array($Y)?in_array($Xb, $Y):$Y===0)?" checked":"")."><i>".lang(7)."</i></label>":"");
    foreach ($Gd[1]as$t=>$X) {
        $X=stripcslashes(str_replace("''", "'", $X));
        $Oa=(is_int($Y)?$Y==$t+1:(is_array($Y)?in_array($t+1, $Y):$Y===$X));
        $K.=" <label><input type='$U'$xa value='".($t+1)."'".($Oa?' checked':'').'>'.h($b->editVal($X, $m)).'</label>';
    }
    return$K;
}function input($m, $Y, $r)
{
    global$Wg,$b,$y;
    $E=h(bracket_escape($m["field"]));
    echo"<td class='function'>";
    if (is_array($Y)&&!$r) {
        $ua=array($Y);
        if (version_compare(PHP_VERSION, 5.4)>=0) {
            $ua[]=JSON_PRETTY_PRINT;
        }
        $Y=call_user_func_array('json_encode', $ua);
        $r="json";
    }
    $wf=($y=="mssql"&&$m["auto_increment"]);
    if ($wf&&!$_POST["save"]) {
        $r=null;
    }
    $Dc=(isset($_GET["select"])||$wf?array("orig"=>lang(8)):array())+$b->editFunctions($m);
    $xa=" name='fields[$E]'";
    if ($m["type"]=="enum") {
        echo
h($Dc[""])."<td>".$b->editInput($_GET["edit"], $m, $xa, $Y);
    } else {
        $Mc=(in_array($r, $Dc)||isset($Dc[$r]));
        echo(count($Dc)>1?"<select name='function[$E]'>".optionlist($Dc, $r===null||$Mc?$r:"")."</select>".on_help("getTarget(event).value.replace(/^SQL\$/, '')", 1).script("qsl('select').onchange = functionChange;", ""):h(reset($Dc))).'<td>';
        $bd=$b->editInput($_GET["edit"], $m, $xa, $Y);
        if ($bd!="") {
            echo$bd;
        } elseif (preg_match('~bool~', $m["type"])) {
            echo"<input type='hidden'$xa value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i', $Y)?" checked='checked'":"")."$xa value='1'>";
        } elseif ($m["type"]=="set") {
            preg_match_all("~'((?:[^']|'')*)'~", $m["length"], $Gd);
            foreach ($Gd[1]as$t=>$X) {
                $X=stripcslashes(str_replace("''", "'", $X));
                $Oa=(is_int($Y)?($Y>>$t)&1:in_array($X, explode(",", $Y), true));
                echo" <label><input type='checkbox' name='fields[$E][$t]' value='".(1<<$t)."'".($Oa?' checked':'').">".h($b->editVal($X, $m)).'</label>';
            }
        } elseif (preg_match('~blob|bytea|raw|file~', $m["type"])&&ini_bool("file_uploads")) {
            echo"<input type='file' name='fields-$E'>";
        } elseif (($Ag=preg_match('~text|lob|memo~i', $m["type"]))||preg_match("~\n~", $Y)) {
            if ($Ag&&$y!="sqlite") {
                $xa.=" cols='50' rows='12'";
            } else {
                $M=min(12, substr_count($Y, "\n")+1);
                $xa.=" cols='30' rows='$M'".($M==1?" style='height: 1.2em;'":"");
            }
            echo"<textarea$xa>".h($Y).'</textarea>';
        } elseif ($r=="json"||preg_match('~^jsonb?$~', $m["type"])) {
            echo"<textarea$xa cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';
        } else {
            $Nd=(!preg_match('~int~', $m["type"])&&preg_match('~^(\d+)(,(\d+))?$~', $m["length"], $C)?((preg_match("~binary~", $m["type"])?2:1)*$C[1]+($C[3]?1:0)+($C[2]&&!$m["unsigned"]?1:0)):($Wg[$m["type"]]?$Wg[$m["type"]]+($m["unsigned"]?0:1):0));
            if ($y=='sql'&&min_version(5.6)&&preg_match('~time~', $m["type"])) {
                $Nd+=7;
            }
            echo"<input".((!$Mc||$r==="")&&preg_match('~(?<!o)int(?!er)~', $m["type"])&&!preg_match('~\[\]~', $m["full_type"])?" type='number'":"")." value='".h($Y)."'".($Nd?" data-maxlength='$Nd'":"").(preg_match('~char|binary~', $m["type"])&&$Nd>20?" size='40'":"")."$xa>";
        }
        echo$b->editHint($_GET["edit"], $m, $Y);
        $vc=0;
        foreach ($Dc
as$z=>$X) {
            if ($z===""||!$X) {
                break;
            }
            $vc++;
        }
        if ($vc) {
            echo
script("mixin(qsl('td'), {onchange: partial(skipOriginal, $vc), oninput: function () { this.onchange(); }});");
        }
    }
}function process_input($m)
{
    global$b,$k;
    $v=bracket_escape($m["field"]);
    $r=$_POST["function"][$v];
    $Y=$_POST["fields"][$v];
    if ($m["type"]=="enum") {
        if ($Y==-1) {
            return
false;
        }
        if ($Y=="") {
            return"NULL";
        }
        return+$Y;
    }
    if ($m["auto_increment"]&&$Y=="") {
        return
null;
    }
    if ($r=="orig") {
        return(preg_match('~^CURRENT_TIMESTAMP~i', $m["on_update"])?idf_escape($m["field"]):false);
    }
    if ($r=="NULL") {
        return"NULL";
    }
    if ($m["type"]=="set") {
        return
array_sum((array)$Y);
    }
    if ($r=="json") {
        $r="";
        $Y=json_decode($Y, true);
        if (!is_array($Y)) {
            return
false;
        }
        return$Y;
    }
    if (preg_match('~blob|bytea|raw|file~', $m["type"])&&ini_bool("file_uploads")) {
        $sc=get_file("fields-$v");
        if (!is_string($sc)) {
            return
false;
        }
        return$k->quoteBinary($sc);
    }
    return$b->processInput($m, $Y, $r);
}function fields_from_edit()
{
    global$k;
    $K=array();
    foreach ((array)$_POST["field_keys"]as$z=>$X) {
        if ($X!="") {
            $X=bracket_escape($X);
            $_POST["function"][$X]=$_POST["field_funs"][$z];
            $_POST["fields"][$X]=$_POST["field_vals"][$z];
        }
    }
    foreach ((array)$_POST["fields"]as$z=>$X) {
        $E=bracket_escape($z, 1);
        $K[$E]=array("field"=>$E,"privileges"=>array("insert"=>1,"update"=>1),"null"=>1,"auto_increment"=>($z==$k->primary),);
    }
    return$K;
}function search_tables()
{
    global$b,$f;
    $_GET["where"][0]["val"]=$_POST["query"];
    $Mf="<ul>\n";
    foreach (table_status('', true)as$Q=>$R) {
        $E=$b->tableName($R);
        if (isset($R["Engine"])&&$E!=""&&(!$_POST["tables"]||in_array($Q, $_POST["tables"]))) {
            $J=$f->query("SELECT".limit("1 FROM ".table($Q), " WHERE ".implode(" AND ", $b->selectSearchProcess(fields($Q), array())), 1));
            if (!$J||$J->fetch_row()) {
                $cf="<a href='".h(ME."select=".urlencode($Q)."&where[0][op]=".urlencode($_GET["where"][0]["op"])."&where[0][val]=".urlencode($_GET["where"][0]["val"]))."'>$E</a>";
                echo"$Mf<li>".($J?$cf:"<p class='error'>$cf: ".error())."\n";
                $Mf="";
            }
        }
    }
    echo($Mf?"<p class='message'>".lang(9):"</ul>")."\n";
}function dump_headers($Uc, $Ud=false)
{
    global$b;
    $K=$b->dumpHeaders($Uc, $Ud);
    $Fe=$_POST["output"];
    if ($Fe!="text") {
        header("Content-Disposition: attachment; filename=".$b->dumpFilename($Uc).".$K".($Fe!="file"&&!preg_match('~[^0-9a-z]~', $Fe)?".$Fe":""));
    }
    session_write_close();
    ob_flush();
    flush();
    return$K;
}function dump_csv($L)
{
    foreach ($L
as$z=>$X) {
        if (preg_match("~[\"\n,;\t]~", $X)||$X==="") {
            $L[$z]='"'.str_replace('"', '""', $X).'"';
        }
    }
    echo
implode(($_POST["format"]=="csv"?",":($_POST["format"]=="tsv"?"\t":";")), $L)."\r\n";
}function apply_sql_function($r, $c)
{
    return($r?($r=="unixepoch"?"DATETIME($c, '$r')":($r=="count distinct"?"COUNT(DISTINCT ":strtoupper("$r("))."$c)"):$c);
}function get_temp_dir()
{
    $K=ini_get("upload_tmp_dir");
    if (!$K) {
        if (function_exists('sys_get_temp_dir')) {
            $K=sys_get_temp_dir();
        } else {
            $tc=@tempnam("", "");
            if (!$tc) {
                return
false;
            }
            $K=dirname($tc);
            unlink($tc);
        }
    }
    return$K;
}function file_open_lock($tc)
{
    $q=@fopen($tc, "r+");
    if (!$q) {
        $q=@fopen($tc, "w");
        if (!$q) {
            return;
        }
        chmod($tc, 0660);
    }
    flock($q, LOCK_EX);
    return$q;
}function file_write_unlock($q, $sb)
{
    rewind($q);
    fwrite($q, $sb);
    ftruncate($q, strlen($sb));
    flock($q, LOCK_UN);
    fclose($q);
}function password_file($h)
{
    $tc=get_temp_dir()."/adminer.key";
    $K=@file_get_contents($tc);
    if ($K||!$h) {
        return$K;
    }
    $q=@fopen($tc, "w");
    if ($q) {
        chmod($tc, 0660);
        $K=rand_string();
        fwrite($q, $K);
        fclose($q);
    }
    return$K;
}function rand_string()
{
    return
md5(uniqid(mt_rand(), true));
}function select_value($X, $A, $m, $Bg)
{
    global$b;
    if (is_array($X)) {
        $K="";
        foreach ($X
as$ld=>$W) {
            $K.="<tr>".($X!=array_values($X)?"<th>".h($ld):"")."<td>".select_value($W, $A, $m, $Bg);
        }
        return"<table cellspacing='0'>$K</table>";
    }
    if (!$A) {
        $A=$b->selectLink($X, $m);
    }
    if ($A===null) {
        if (is_mail($X)) {
            $A="mailto:$X";
        }
        if (is_url($X)) {
            $A=$X;
        }
    }
    $K=$b->editVal($X, $m);
    if ($K!==null) {
        if (!is_utf8($K)) {
            $K="\0";
        } elseif ($Bg!=""&&is_shortable($m)) {
            $K=shorten_utf8($K, max(0, +$Bg));
        } else {
            $K=h($K);
        }
    }
    return$b->selectVal($K, $A, $m, $X);
}function is_mail($Ub)
{
    $wa='[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
    $Ib='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    $Re="$wa+(\\.$wa+)*@($Ib?\\.)+$Ib";
    return
is_string($Ub)&&preg_match("(^$Re(,\\s*$Re)*\$)i", $Ub);
}function is_url($hg)
{
    $Ib='[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    return
preg_match("~^(https?)://($Ib?\\.)+$Ib(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i", $hg);
}function is_shortable($m)
{
    return
preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~', $m["type"]);
}function count_rows($Q, $Z, $hd, $s)
{
    global$y;
    $I=" FROM ".table($Q).($Z?" WHERE ".implode(" AND ", $Z):"");
    return($hd&&($y=="sql"||count($s)==1)?"SELECT COUNT(DISTINCT ".implode(", ", $s).")$I":"SELECT COUNT(*)".($hd?" FROM (SELECT 1$I GROUP BY ".implode(", ", $s).") x":$I));
}function slow_query($I)
{
    global$b,$T,$k;
    $j=$b->database();
    $Dg=$b->queryTimeout();
    $Vf=$k->slowQuery($I, $Dg);
    if (!$Vf&&support("kill")&&is_object($g=connect())&&($j==""||$g->select_db($j))) {
        $nd=$g->result(connection_id());
        echo'<script',nonce(),'>
var timeout = setTimeout(function () {
	ajax(\'',js_escape(ME),'script=kill\', function () {
	}, \'kill=',$nd,'&token=',$T,'\');
}, ',1000*$Dg,');
</script>
';
    } else {
        $g=null;
    }
    ob_flush();
    flush();
    $K=@get_key_vals(($Vf?$Vf:$I), $g, false);
    if ($g) {
        echo
script("clearTimeout(timeout);");
        ob_flush();
        flush();
    }
    return$K;
}function get_token()
{
    $mf=rand(1, 1e6);
    return($mf^$_SESSION["token"]).":$mf";
}function verify_token()
{
    list($T, $mf)=explode(":", $_POST["token"]);
    return($mf^$_SESSION["token"])==$T;
}function lzw_decompress($Ea)
{
    $Fb=256;
    $Fa=8;
    $Ua=array();
    $xf=0;
    $yf=0;
    for ($t=0;$t<strlen($Ea);$t++) {
        $xf=($xf<<8)+ord($Ea[$t]);
        $yf+=8;
        if ($yf>=$Fa) {
            $yf-=$Fa;
            $Ua[]=$xf>>$yf;
            $xf&=(1<<$yf)-1;
            $Fb++;
            if ($Fb>>$Fa) {
                $Fa++;
            }
        }
    }
    $Eb=range("\0", "\xFF");
    $K="";
    foreach ($Ua
as$t=>$Ta) {
        $Tb=$Eb[$Ta];
        if (!isset($Tb)) {
            $Tb=$zh.$zh[0];
        }
        $K.=$Tb;
        if ($t) {
            $Eb[]=$zh.$Tb[0];
        }
        $zh=$Tb;
    }
    return$K;
}function on_help($ab, $Tf=0)
{
    return
script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $ab, $Tf) }, onmouseout: helpMouseout});", "");
}function edit_form($a, $n, $L, $eh)
{
    global$b,$y,$T,$l;
    $qg=$b->tableName(table_status1($a, true));
    page_header(($eh?lang(10):lang(11)), $l, array("select"=>array($a,$qg)), $qg);
    if ($L===false) {
        echo"<p class='error'>".lang(12)."\n";
    }
    echo'<form action="" method="post" enctype="multipart/form-data" id="form">
';
    if (!$n) {
        echo"<p class='error'>".lang(13)."\n";
    } else {
        echo"<table cellspacing='0' class='layout'>".script("qsl('table').onkeydown = editingKeydown;");
        foreach ($n
as$E=>$m) {
            echo"<tr><th>".$b->fieldName($m);
            $zb=$_GET["set"][bracket_escape($E)];
            if ($zb===null) {
                $zb=$m["default"];
                if ($m["type"]=="bit"&&preg_match("~^b'([01]*)'\$~", $zb, $uf)) {
                    $zb=$uf[1];
                }
            }
            $Y=($L!==null?($L[$E]!=""&&$y=="sql"&&preg_match("~enum|set~", $m["type"])?(is_array($L[$E])?array_sum($L[$E]):+$L[$E]):$L[$E]):(!$eh&&$m["auto_increment"]?"":(isset($_GET["select"])?false:$zb)));
            if (!$_POST["save"]&&is_string($Y)) {
                $Y=$b->editVal($Y, $m);
            }
            $r=($_POST["save"]?(string)$_POST["function"][$E]:($eh&&preg_match('~^CURRENT_TIMESTAMP~i', $m["on_update"])?"now":($Y===false?null:($Y!==null?'':'NULL'))));
            if (preg_match("~time~", $m["type"])&&preg_match('~^CURRENT_TIMESTAMP~i', $Y)) {
                $Y="";
                $r="now";
            }
            input($m, $Y, $r);
            echo"\n";
        }
        if (!support("table")) {
            echo"<tr>"."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select("field_funs[]", $b->editFunctions(array("null"=>isset($_GET["select"]))))."<td><input name='field_vals[]'>"."\n";
        }
        echo"</table>\n";
    }
    echo"<p>\n";
    if ($n) {
        echo"<input type='submit' value='".lang(14)."'>\n";
        if (!isset($_GET["select"])) {
            echo"<input type='submit' name='insert' value='".($eh?lang(15):lang(16))."' title='Ctrl+Shift+Enter'>\n",($eh?script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".lang(17)."…', this); };"):"");
        }
    }
    echo($eh?"<input type='submit' name='delete' value='".lang(18)."'>".confirm()."\n":($_POST||!$n?"":script("focus(qsa('td', qs('#form'))[1].firstChild);")));
    if (isset($_GET["select"])) {
        hidden_fields(array("check"=>(array)$_POST["check"],"clone"=>$_POST["clone"],"all"=>$_POST["all"]));
    }
    echo'<input type="hidden" name="referer" value="',h(isset($_POST["referer"])?$_POST["referer"]:$_SERVER["HTTP_REFERER"]),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$T,'">
</form>
';
} if (isset($_GET["file"])) {
    if ($_SERVER["HTTP_IF_MODIFIED_SINCE"]) {
        header("HTTP/1.1 304 Not Modified");
        exit;
    }
    header("Expires: ".gmdate("D, d M Y H:i:s", time()+365*24*60*60)." GMT");
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
    header("Cache-Control: immutable");
    if ($_GET["file"]=="favicon.ico") {
        header("Content-Type: image/x-icon");
        echo
lzw_decompress("\0\0\0` \0�\0\n @\0�C��\"\0`E�Q����?�tvM'�Jd�d\\�b0\0�\"��fӈ��s5����A�XPaJ�0���8�#R�T��z`�#.��c�X��Ȁ?�-\0�Im?�.�M��\0ȯ(̉��/(%�\0");
    } elseif ($_GET["file"]=="default.css") {
        header("Content-Type: text/css; charset=utf-8");
        echo
lzw_decompress("\n1̇�ٌ�l7��B1�4vb0��fs���n2B�ѱ٘�n:�#(�b.\rDc)��a7E����l�ñ��i1̎s���-4��f�	��i7�����t4���y�Zf4��i�AT�VV��f:Ϧ,:1�Qݼ�b2`�#�>:7G�1���s��L�XD*bv<܌#�e@�:4�!fo���t:<��咾�o��\ni���',�a_�:�i�Bv�|N�4.5Nf�i�vp�h��l��֚�O����= �OFQ��k\$��i����d2T�p��6�����-�Z�����6����h:�a�,����2�#8А�#��6n����J��h�t�����4O42��ok��*r���@p@�!������?�6��r[��L���:2B�j�!Hb��P�=!1V�\"��0��\nS���D7��Dڛ�C!�!��Gʌ� �+�=tC�.C��:+��=�������%�c�1MR/�EȒ4���2�䱠�`�8(�ӹ[W��=�yS�b�=�-ܹBS+ɯ�����@pL4Yd��q�����6�3Ĭ��Ac܌�Ψ�k�[&>���Z�pkm]�u-c:���Nt�δpҝ��8�=�#��[.��ޯ�~���m�y�PP�|I֛���Q�9v[�Q��\n��r�'g�+��T�2��V��z�4��8��(	�Ey*#j�2]��R����)��[N�R\$�<>:�>\$;�>��\r���H��T�\nw�N �wأ��<��Gw����\\Y�_�Rt^�>�\r}��S\rz�4=�\nL�%J��\",Z�8����i�0u�?�����s3#�ى�:���㽖��E]x���s^8��K^��*0��w����~���:��i���v2w����^7���7�c��u+U%�{P�*4̼�LX./!��1C��qx!H��Fd��L���Ġ�`6��5��f��Ć�=H�l �V1��\0a2�;��6����_ه�\0&�Z�S�d)KE'��n��[X��\0ZɊ�F[P�ޘ@��!��Y�,`�\"ڷ��0Ee9yF>��9b����F5:���\0}Ĵ��(\$����37H��� M�A��6R��{Mq�7G��C�C�m2�(�Ct>[�-t�/&C�]�etG�̬4@r>���<�Sq�/���Q�hm���������L��#��K�|���6fKP�\r%t��V=\"�SH\$�} ��)w�,W\0F��u@�b�9�\rr�2�#�D��X���yOI�>��n��Ǣ%���'��_��t\rτz�\\1�hl�]Q5Mp6k���qh�\$�H~�|��!*4����`S���S t�PP\\g��7�\n-�:袪p����l�B���7Өc�(wO0\\:��w���p4���{T��jO�6HÊ�r���q\n��%%�y']\$��a�Z�.fc�q*-�FW��k��z���j���lg�:�\$\"�N�\r#�d�Â���sc�̠��\"j�\r�����Ւ�Ph�1/��DA)���[�kn�p76�Y��R{�M�P���@\n-�a�6��[�zJH,�dl�B�h�o�����+�#Dr^�^��e��E��� ĜaP���JG�z��t�2�X�����V�����ȳ��B_%K=E��b弾�§kU(.!ܮ8����I.@�K�xn���:�P�32��m�H		C*�:v�T�\nR�����0u�����ҧ]�����P/�JQd�{L�޳:Y��2b��T ��3�4���c�V=���L4��r�!�B�Y�6��MeL������i�o�9< G��ƕЙMhm^�U�N����Tr5HiM�/�n�흳T��[-<__�3/Xr(<���������uҖGNX20�\r\$^��:'9�O��;�k����f��N'a����b�,�V��1��HI!%6@��\$�EGڜ�1�(mU��rս���`��iN+Ü�)���0l��f0��[U��V��-:I^��\$�s�b\re��ug�h�~9�߈�b�����f�+0�� hXrݬ�!\$�e,�w+����3��_�A�k��\nk�r�ʛcuWdY�\\�={.�č���g��p8�t\rRZ�v�J:�>��Y|+�@����C�t\r��jt��6��%�?��ǎ�>�/�����9F`ו��v~K�����R�W��z��lm�wL�9Y�*q�x�z��Se�ݛ����~�D�����x���ɟi7�2���Oݻ��_{��53��t���_��z�3�d)�C��\$?KӪP�%��T&��&\0P�NA�^�~���p� �Ϝ���\r\$�����b*+D6궦ψ��J\$(�ol��h&��KBS>���;z��x�oz>��o�Z�\nʋ[�v���Ȝ��2�OxِV�0f�����2Bl�bk�6Zk�hXcd�0*�KT�H=��π�p0�lV����\r���n�m��)(�(�:#����E��:C�C���\r�G\ré0��i����:`Z1Q\n:��\r\0���q���:`�-�M#}1;����q�#|�S���hl�D�\0fiDp�L��``����0y��1���\r�=�MQ\\��%oq��\0��1�21�1�� ���ќbi:��\r�/Ѣ� `)��0��@���I1�N�C�����O��Z��1���q1 ����,�\rdI�Ǧv�j�1 t�B���⁒0:�0��1�A2V���0���%�fi3!&Q�Rc%�q&w%��\r��V�#���Qw`�% ���m*r��y&i�+r{*��(rg(�#(2�(��)R@i�-�� ���1\"\0��R���.e.r��,�ry(2�C��b�!Bޏ3%ҵ,R�1��&��t��b�a\rL��-3�����\0��Bp�1�94�O'R�3*��=\$�[�^iI;/3i�5�&�}17�# ѹ8��\"�7��8�9*�23�!�!1\\\0�8��rk9�;S�23��ړ*�:q]5S<��#3�83�#e�=�>~9S螳�r�)��T*a�@і�bes���:-���*;,�ؙ3!i���LҲ�#1 �+n� �*��@�3i7�1���_�F�S;3�F�\rA��3�>�x:� \r�0��@�-�/��w��7��S�J3� �.F�\$O�B���%4�+t�'g�Lq\rJt�J��M2\r��7��T@���)ⓣd��2�P>ΰ��Fi಴�\nr\0��b�k(�D���KQ����1�\"2t����P�\r��,\$KCt�5��#��)��P#Pi.�U2�C�~�\"�");
    } elseif ($_GET["file"]=="functions.js") {
        header("Content-Type: text/javascript; charset=utf-8");
        echo
lzw_decompress("f:��gCI��\n8��3)��7���81��x:\nOg#)��r7\n\"��`�|2�gSi�H)N�S��\r��\"0��@�)�`(\$s6O!��V/=��' T4�=��iS��6IO�G#�X�VC��s��Z1.�hp8,�[�H�~Cz���2�l�c3���s���I�b�4\n�F8T��I���U*fz��r0�E����y���f�Y.:��I��(�c��΋!�_l��^�^(��N{S��)r�q�Y��l٦3�3�\n�+G���y���i���xV3w�uh�^r����a۔���c��\r���(.��Ch�<\r)�ѣ�`�7���43'm5���\n�P�:2�P����q ���C�}ī�����38�B�0�hR��r(�0��b\\0�Hr44��B�!�p�\$�rZZ�2܉.Ƀ(\\�5�|\nC(�\"��P���.��N�RT�Γ��>�HN��8HP�\\�7Jp~���2%��OC�1�.��C8·H��*�j����S(�/��6KU����<2�pOI���`���ⳈdO�H��5�-��4��pX25-Ң�ۈ�z7��\"(�P�\\32:]U����߅!]�<�A�ۤ���iڰ�l\r�\0v��#J8��wm��ɤ�<�ɠ��%m;p#�`X�D���iZ��N0����9��占��`��wJ�D��2�9t��*��y��NiIh\\9����:����xﭵyl*�Ȉ��Y�����8�W��?���ޛ3���!\"6�n[��\r�*\$�Ƨ�nzx�9\r�|*3ףp�ﻶ�:(p\\;��mz���9����8N���j2����\r�H�H&��(�z��7i�k� ����c��e���t���2:SH�Ƞ�/)�x�@��t�ri9����8����yҷ���V�+^Wڦ��kZ�Y�l�ʣ���4��Ƌ������\\E�{�7\0�p���D��i�-T����0l�%=���˃9(�5�\n\n�n,4�\0�a}܃.��Rs\02B\\�b1�S�\0003,�XPHJsp�d�K� CA!�2*W����2\$�+�f^\n�1����zE� Iv�\\�2��.*A���E(d���b��܄��9����Dh�&��?�H�s�Q�2�x~nÁJ�T2�&��eR���G�Q��Tw�ݑ��P���\\�)6�����sh\\3�\0R	�'\r+*;R�H�.�!�[�'~�%t< �p�K#�!�l���Le����,���&�\$	��`��CX��ӆ0֭����:M�h	�ڜG��!&3�D�<!�23��?h�J�e ��h�\r�m���Ni�������N�Hl7��v��WI�.��-�5֧ey�\rEJ\ni*�\$@�RU0,\$U�E����ªu)@(t�SJk�p!�~���d`�>��\n�;#\rp9�jɹ�]&Nc(r���TQU��S��\08n`��y�b���L�O5��,��>���x���f䴒���+��\"�I�{kM�[\r%�[	�e�a�1! ����Ԯ�F@�b)R��72��0�\nW���L�ܜҮtd�+���0wgl�0n@��ɢ�i�M��\nA�M5n�\$E�ױN��l�����%�1 A������k�r�iFB���ol,muNx-�_�֤C( ��f�l\r1p[9x(i�BҖ��zQl��8C�	��XU Tb��I�`�p+V\0��;�Cb��X�+ϒ�s��]H��[�k�x�G*�]�awn�!�6�����mS���I��K�~/�ӥ7��eeN��S�/;d�A�>}l~��� �%^�f�آpڜDE��a��t\nx=�kЎ�*d���T����j2��j��\n��� ,�e=��M84���a�j@�T�s���nf��\n�6�\rd��0���Y�'%ԓ��~	�Ҩ�<���AH�G��8���΃\$z��{���u2*��a��>�(w�K.bP�{��o��´�z�#�2�8=�8>���A,�e���+�C�x�*���-b=m���,�a��lzk���\$W�,�m�Ji�ʧ���+���0�[��.R�sK���X��ZL��2�`�(�C�vZ������\$�׹,�D?H��NxX��)��M��\$�,��*\nѣ\$<q�şh!��S����xsA!�:�K��}�������R��A2k�X�p\n<�����l���3�����VV�}�g&Yݍ!�+�;<�Y��YE3r�َ��C�o5����ճ�kk�����ۣ��t��U���)�[����}��u��l�:D��+Ϗ _o��h140���0��b�K�㬒�����lG��#��������|Ud�IK���7�^��@��O\0H��Hi�6\r����\\cg\0���2�B�*e��\n��	�zr�!�nWz&� {H��'\$X �w@�8�DGr*���H�'p#�Į���\nd���,���,�;g~�\0�#����E��\r�I`��'��%E�.�]`�Л��%&��m��\r��%4S�v�#\n��fH\$%�-�#���qB�����Q-�c2���&���]�� �qh\r�l]�s���h�7�n#����-�jE�Fr�l&d����z�F6����\"���|���s@����z)0rpڏ\0�X\0���|DL<!��o�*�D�{.B<E���0nB(� �|\r\n�^���� h�!���r\$��(^�~����/p�q��B��O����,\\��#RR��%���d�Hj�`����̭ V� bS�d�i�E���oh�r<i/k\$-�\$o��+�ŋ��l��O�&evƒ�i�jMPA'u'���( M(h/+��WD�So�.n�.�n���(�(\"���h�&p��/�/1D̊�j娸E��&⦀�,'l\$/.,�d���W�bbO3�B�sH�:J`!�.���������,F��7(��Կ��1�l�s �Ҏ���Ţq�X\r����~R鰱`�Ҟ�Y*�:R��rJ��%L�+n�\"��\r��͇H!qb�2�Li�%����Wj#9��ObE.I:�6�7\0�6+�%�.����a7E8VS�?(DG�ӳB�%;���/<�����\r ��>�M��@���H�Ds��Z[tH�Enx(���R�x��@��GkjW�>���#T/8�c8�Q0��_�IIGII�!���YEd�E�^�td�th�`DV!C�8��\r���b�3�!3�@�33N}�ZB�3	�3�30��M(�>��}�\\�t�f�f���I\r���337 X�\"td�,\nbtNO`P�;�ܕҭ���\$\n����Zѭ5U5WU�^ho���t�PM/5K4Ej�KQ&53GX�Xx)�<5D��\r�V�\n�r�5b܀\\J\">��1S\r[-��Du�\r���)00�Y��ˢ�k{\n��#��\r�^��|�uܻU�_n�U4�U�~Yt�\rI��@䏳�R �3:�uePMS�0T�wW�X���D��KOU����;U�\n�OY��Y�Q,M[\0�_�D���W��J*�\rg(]�\r\"ZC��6u�+�Y��Y6ô�0�q�(��8}��3AX3T�h9j�j�f�Mt�PJbqMP5>������Y�k%&\\�1d��E4� �Yn���\$<�U]Ӊ1�mbֶ�^�����\"NV��p��p��eM���W�ܢ�\\�)\n �\nf7\n�2��r8��=Ek7tV����7P��L��a6��v@'�6i��j&>��;��`��a	\0pڨ(�J��)�\\��n��Ĭm\0��2��eqJ��P��t��fj��\"[\0����X,<\\������+md��~�����s%o��mn�),ׄ�ԇ�\r4��8\r����mE�H]�����HW�M0D�߀��~�ˁ�K��E}����|f�^���\r>�-z]2s�xD�d[s�t�S��\0Qf-K`���t���wT�9��Z��	�\nB�9 Nb��<�B�I5o�oJ�p��JNd��\r�hލ��2�\"�x�HC�ݍ�:���9Yn16��zr+z���\\�����m ��T ���@Y2lQ<2O+�%��.Ӄh�0A���Z��2R��1��/�hH\r�X��aNB&� �M@�[x��ʮ���8&L�V͜v�*�j�ۚGH��\\ٮ	���&s�\0Q��\\\"�b��	��\rBs��w��	���BN`�7�Co(���\nè���1�9�*E� �S��U�0U� t�'|�m���?h[�\$.#�5	 �	p��yB�@R�]���@|��{���P\0x�/� w�%�EsBd���CU�~O׷�P�@X�]����Z3��1��{�eLY���ڐ�\\�(*R`�	�\n������QCF�*�����霬�p�X|`N���\$�[���@�U������Z�`Zd\"\\\"����)��I�:�t��oD�\0[�����-���g�����*`hu%�,����I�7ī�H�m�6�}��N�ͳ\$�M�UYf&1����e]pz���I��m�G/� �w �!�\\#5�4I�d�E�hq���Ѭk�x|�k�qD�b�z?���>���:��[�L�ƬZ�X��:�������j�w5	�Y��0 ���\$\0C��dSg����{�@�\n`�	���C ���M�����# t}x�N����{�۰)��C��FKZ�j��\0PFY�B�pFk��0<�>�D<JE��g\r�.�2��8�U@*�5fk��JD���4��TDU76�/��@��K+���J�����@�=��WIOD�85M��N�\$R�\0�5�\r��_���E���I�ϳN�l���y\\����qU��Q���\n@���ۺ�p���P۱�7ԽN\r�R{*�qm�\$\0R��ԓ���q�È+U@�B��Of*�Cˬ�MC��`_ ���˵N��T�5٦C׻� ��\\W�e&_X�_؍h���B�3���%�FW���|�Gޛ'�[�ł����V��#^\r��GR����P��Fg�����Yi ���z\n��+�^/�������\\�6��b�dmh��@q���Ah�),J��W��cm�em]�ӏe�kZb0�����Y�]ym��f�e�B;���O��w�apDW�����{�\0��-2/bN�sֽ޾Ra�Ϯh&qt\n\"�i�Rm�hz�e����FS7��PP�䖤��:B����sm��Y d���7}3?*�t����lT�}�~�����=c������	��3�;T�L�5*	�~#�A����s�x-7��f5`�#\"N�b��G����@�e�[�����s����-��M6��qq� h�e5�\0Ң���*�b�IS���Fή9}�p�-��`{��ɖkP�0T<��Z9�0<՚\r��;!��g�\r\nK�\n��\0��*�\nb7(�_�@,�e2\r�]�K�+\0��p C\\Ѣ,0�^�MЧ����@�;X\r��?\$\r�j�+�/��B��P�����J{\"a�6�䉜�|�\n\0��\\5���	156�� .�[�Uد\0d��8Y�:!���=��X.�uC����!S���o�p�B���7��ů�Rh�\\h�E=�y:< :u��2�80�si��TsB�@\$ ��@�u	�Q���.��T0M\\/�d+ƃ\n��=��d���A���)\r@@�h3���8.eZa|.�7�Yk�c���'D#��Y�@X�q�=M��44�B AM��dU\"�Hw4�(>��8���C�?e_`��X:�A9ø���p�G��Gy6��F�Xr��l�1��ػ�B�Å9Rz��hB�{����\0��^��-�0�%D�5F\"\"�����i�`��nAf� \"tDZ\"_�V\$��!/�D�ᚆ������٦�̀F,25�j�T��y\0�N�x\r�Yl��#��Eq\n��B2�\n��6���4���!/�\n��Q��*�;)bR�Z0\0�CDo�˞�48������e�\n�S%\\�PIk��(0��u/��G������\\�}�4Fp��G�_�G?)g�ot��[v��\0��?b�;��`(�ی�NS)\n�x=��+@��7��j�0��,�1Åz����>0��Gc��L�VX�����%����Q+���o�F���ܶ�>Q-�c���l����w��z5G��@(h�c�H��r?��Nb�@�������lx3�U`�rw���U���t�8�=�l#���l�䨉8�E\"����O6\n��1e�`\\hKf�V/зPaYK�O�� ��x�	�Oj���r7�F;��B����̒��>�Ц�V\rĖ�|�'J�z����#�PB��Y5\0NC�^\n~LrR��[̟Rì�g�eZ\0x�^�i<Q�/)�%@ʐ��fB�Hf�{%P�\"\"���@���)���DE(iM2�S�*�y�S�\"���e̒1��ט\n4`ʩ>��Q*��y�n����T�u�����~%�+W��XK���Q�[ʔ��l�PYy#D٬D<�FL���@�6']Ƌ��\rF�`�!�%\n�0�c���˩%c8WrpG�.T�Do�UL2�*�|\$�:�Xt5�XY�I�p#� �^\n��:�#D�@�1\r*�K7�@D\0��C�C�xBh�EnK�,1\"�*y[�#!�י�ٙ���l_�/��x�\0���5�Z��4\0005J�h\"2���%Y���a�a1S�O�4��%ni��P��ߴq�_ʽ6���6��\n@PjU�\0��`r;�H�������:�����4 _w*�@F@%��s[�d�e���bh�\0�ɱP\r�\\i�J�99P9�^s�.��P29�\nNj#,����5���M)��B���\ni%~����:9��X\r�e��8���eӽ+���9���x�*�ـW2�N�ba�S�E��2��\r����p�	��\\(/	Lf����Y��X#8ZJăH��+P�-I1xɈ�36�N�w\r���[x3�>\rTO�b�>s��0���jA�8;�#ј������jPd�qR�J�\"��(x����h�*��	T��aV��Yƌ��\$����7�Z9ĸ�1̚XJ���a�AOk8fD�C�96@���M�(H�����B���?�i�TAPܭ�^0�P��af/�ύ�P0�MH)\"�dU@�r1\\�\r�oH|�����h�8�@�?P��Z,A>®��E(�&��e��͞]�Q\$������ЪZ�}a���̙:P�w:��(�Z���!8������n@9�\$��(K\"����%Ŧ��@2��\$P��<��\0��灦JtUXP\"-A��ɦYk�2����4�C\n�\0���2��~�s_��\0�N5��Ҝ��/�ӀI�;���i���֗efkF<�r�E�,�6%?�I�j;'S)M����4)�N�.�~�����\0J�Ӕ��3��Qzz	�?��m1����q�	cQH�ܯyL\"Oυ0|c\$P�\"����r0eL��m#d�px.uA�^�B�76��qn�׍�B�n��iZvR@�)*�㌁qƒ�)��7^�I��jI�S5�3�������8ں���x�9	�Lq��L�OA�A\0001���%�!1-�W��Ҏ�%#!5+�����!�vue(�Bp�\nK�/������\\�i���\0^�\$�,�|�Z��(R�+k��\n++��V�G�{/�T�<��M�ê��¢���\$�{д�̀y�Vt� +�S�Z���(u� x\"HC�J�? v8�J�P� Q\0�V1��#��'_�\n�4%�ǥ\nza_���PDD{��+\$Sz�օ? l�ʍ��2z��!=�OD���[�b\0�K�Į�tj�+�(�Ҕ5�.��k�Z�F֭=A���Uך��0�C�������~�v.�8�+Rx[�º�زŦ�Au��I8䬎3���� '	�i�f��.J�ʈT���X11����&3��6���	��f@|O`b��g\0�>���x�kkMD�Q�\n����h����a�y\$t��`\"��5����56���| `&���:T�A��\n������pjR���I*��Q�����aN�Z�_Z�q⴩����G9\0�����(İ=J��� dG���9r��,Qp�+kZ�\$��I+����(��5��{2��_m�ˆ8��e���n����\\6Ŋ���\${X��K\$��#k�U��+v�vE�m�n��vO�	!Adt��_/�(6�1ڕ��m[�����\$�Tαh�d��X�����/7ꠡB� �-\$��Ur�>b*)̶Z�Xnb�\n��ESΝpoe����p\\��D� ��E�#�,��T~�.�P��m)a��=óR���E��<��r�6��gHE-t�봺R�v�ZtF+m[���u�:��7w��]��,`��-�w��9���a���o���[DM������oe�rq6�H���Ș!*�teh���^�ʔ��I��M�đ\"DA��\$�\0oH��̜�Ap��E�ZL���}\"��:�|��6�|=n����f�c���v�J]�A5c�H��8��-�����O�VBV�#д��`���\r���-�	�KBd�G�^�+��.��El��\$\$(q�0|9(��h��{\n4a7B�P\0n@-h�oW���� `�+^j��d��9cP�q1��H\"���\\�����!���\".ڤ�����E<�/���z}���(�XD.6?Nxk*,)�l�W�9�	j\\I��(J���@;�1����\n�Ix��ï�h\rI[:��ˈH�5/�vBu�Pfu��6�!4�xl��2�����^ ��g\0�����_q��~4I�O\"�-x�D��b\\\"�-_�rȔ���G\"�b�a{O���R�v�r�qK�\0\$�m�b���NAt@�)U�𣰮��p�j��v��,9�ʄ��*T~�L���dѻ�K�g��P�L����F�2���P*,uW��*Z����UpU�i\0d�]��\rGw\n@`����k�!�q�g��E��HE�@��]y2s��e��%���\"���\\�O�?�z+���4�;uzЁ0d7��F����<d��2�u�9���W\$y9��\0P܀d�,�-���[����h|BQ ��5ҙ���ة�<��r\0�t;2����f�9T��=@�s:��ɘ��L�v���X@WoN �W��\$D�D7��e����:(�v�����/����r\rA�Ơ\n�z3|�٘��z^ev/�y��^5��G��0B�����m�`��vl���n�n�R>\nYTc��b��P\\�rPc�cx7c���D�={*�dr��8��w�΁܆=R6_��Ɯ�Ny��`&��\$�H��G�k�4Y|��/�ٳ�@��Ҥ�sέ������R\"y�[�zGo�%Gg����{�ϟ�.���9r�c�\\U����5��C����\"��)L׌�I���k��\r��i��(�Ϲ-���\\d��&r�|�f����P�eM�I��bc0Ml�C���OZ9�&��z�������HK�X�Ў�%��AauR���w�I=�KY���De��̀\r�ވ1�D�\"OmuL�o�C\\�m!�s�T\0�t���|�uK��)���貅Z2�XoM|C���h/���➁!�FԨ�(���J�\0�H�Sz3��(f�J�4ޣ�8�cb�\$��۩R��`���i�޺�.\0��?�l�[6�D��Hֆ��R[��e<q�����;�������pKtf`/���Ԥz\rݫ-Mi�͢L�J��,��JC��� ��f��ӧ[�����ڲ,-Yڇ]!y nT���Bl�ބ\$zUcu��\$�j>72�,4.���!��Q��D+�F���ן��[\n6�So8�M)�Leٴ��\r,�e=�\r�����-�h��#�M�*=O���\n��#D���Q�+a�O��-Ss1+[@(���3|���r��F�拄=iJ���2&�s�\rO�\$!l��D����Bt��i��Rq;͉@�P���WP>?�=r�ןnCs,���;B�o��M�m�}��y��M�����˹-���>y,g�6�q���\"�q3|d��;��b�F7�	늫@��?��v@	��ERU� �&I\\}-X����gG4�]g6��Ԃ>��\0�:��\"jWP�{�g���O\\3����\n��\r� ��,�Dߢ�9�\0	�O}jCڷ�L��|	H��6�����r�TF������!��S+�r�����c3��B@XdT6&��ǎG�g�n�8�Ƒ�z|)���V��^��	��-\0�8���-�8b�7�-�/�@�֐>V���+u\0B�zl%5׶��OJ���!��ֲ@�x�h�7 �!�1�8�SR�\0Q*o�8�n*�?_���\nx���T�9�������n�4,7o�^�N]�d�q�1#e�(v������,���ms.8�T�WgB>`�L�@���\\�y��n\nNq���1�E=h4<Ӿ\$�sA��u3�B���:�@�u�2�A=��\\B-uM��DnW�d�V��TlrR����Ҟ�Ug�\r��������{F�>A�C��'�	��2�������b�����b���d�Y/�|nr\r��S�Sk*�AO��R)��;�s�Ԕ\$w\$)E��Ai�鰠�Q 1�ݔ���D3%�� ���*2r��PL�s,�;�ug+��t�h�b�L���%��rC�|�Z����N�*��*5;ۡ�U�A�{І��~y�iKX��ڔD��#�2CJY��������>zS�CU��c����ORԾ�0�)�+��:-IN����|�e�G�;�b��\$,p0��_L.��\$ċ�v��SܖF1&U��(	��nxt���d�@0��������/wc��_R�2�f�ѭeĪ�\0=��s��bsCO4�t~�h�(�o}OU����_h���p������x���\$?!�Bw�G�9�G��渦���V?{X�n�S�~��_1��Ţq��U{#x\nN \$�8�E��q�~��7�!��i!�n�qi\r\$��k𨞣��Q��Ld	�S��tpA9��/[�s�\0��6Vv,�������'�`�?C�s�hctH\"�K�}n���'������^�3���_M�%�o���郄�VO��ٿ����E�\n��rpT��L��|`e�Ѻ���A�j�:d|[�ێ⽌���J���4�l N�u4]l�M�H&��\$�\0YR��qzWĘ@������e3�'t|��.���`(�I<��2�_5�)%����G��m\0P\n�m�o@��>���xB\"��Em|��2�\$},3L�YX�go�\$߶ <�����IE\"`���4�g�8^�]\n����:��qV�Tԣ�m�m��7&ғĤ�m��&���Qz�������ű�H����yO�f��\r٣.�����@�JW&�q�5�0	�5��P�G��\n������F�{\0\r�m�@�@ �P� x�4i4�+@\0,͚\\�C1ӎ�\n�L���>n�\0���	 #������#@]/4JR� IR��p�<�ǯ�aj��?)Mv��2X|@v\0a��\"�τ��k���-�yA[|�7\r��\$����ZǭR�t���>����CErL	��r�O�e�R/���J��~�%Xo�4�dU\"�Qr��I�QD������QQM}�Q�{)ة�\",f��_(,�6�Q+c����&�S���~O�p�C���������V�����@1�[�<H/�~�\0^C��T���q_gP��pe��@B�������끠pȿ�)X��\0��ߔ��{�`�\0v������Q����@~�翡����TƁW������������������O�>�8&����CLݑ��(���(���Ǐ2��\r%�;�k抐4��_O;�5��`@<���/�7�_	�6'AY��\"��aS��z�kp�4�+h@Z����8>���oߔL������j�s���\rJ��m��\0L\0c�?���m��N�(����Tp#���|�>����A[?�[�ſ�Hk�����\n�t��p:�G���>��T�{*��-�t����P��X�j�N�4���0\n\$��:H,�H}�A���c�*���n?�돢\n���;�O�\0Z��v�AB���`�o��8_�R--n��T#DIs1��\0V�PM\0V�r���0\$Bi�`�T�d�X|e\08\\�7),_���K�3(.c��\\�d��2���R<�u�\\��	4�N�(|g���|�N&,����y���(���8b�:P���1Y'!��Ą�\0fx���\0��1����H[,�>����&�T�/a\rLC�bE����	7����b��kș�|b��0�T\"���.���ق5s��D�Sg�8�Rh*�4�}�����<-9B\$���d9B\$�i�H�8cj\\`���_�����	�#`��h����HΨp�\$�0�`1W\n��%N�Z\\#�b��P��%m7l\"��d��\"P��!�#/ş��,ͪ��J#0��c�]��-(򐹆6�7l~�\r\0B��0�:CA�\\pϑ�[����(Ќ�JG�0�B\"8�P�B*%�<#�BF72�B������5Bp	t&��6\0b���4<\$퀶�K��V\0G	�mY�");
    } elseif ($_GET["file"]=="jush.js") {
        header("Content-Type: text/javascript; charset=utf-8");
        echo
lzw_decompress("v0��F����==��FS	��_6MƳ���r:�E�CI��o:�C��Xc��\r�؄J(:=�E���a28�x�?�'�i�SANN���xs�NB��Vl0���S	��Ul�(D|҄��P��>�E�㩶yHch��-3Eb�� �b��pE�p�9.����~\n�?Kb�iw|�`��d.�x8EN��!��2��3���\r���Y���y6GFmY�8o7\n\r�0��\0�Dbc�!�Q7Шd8���~��N)�Eг`�Ns��`�S)�O���/�<�x�9�o�����3n��2�!r�:;�+�9�CȨ���\n<�`��b�\\�?�`�4\r#`�<�Be�B#�N ��\r.D`��j�4���p�ar��㢺�>�8�\$�c��1�c���c����{n7����A�N�RLi\r1���!�(�j´�+��62�X�8+����.\r����!x���h�'��6S�\0R����O�\n��1(W0���7q��:N�E:68n+��մ5_(�s�\r��/m�6P�@�EQ���9\n�V-���\"�.:�J��8we�q�|؇�X�]��Y X�e�zW�� �7��Z1��hQf��u�j�4Z{p\\AU�J<��k��@�ɍ��@�}&���L7U�wuYh��2��@�u� P�7�A�h����3Û��XEͅZ�]�l�@Mplv�)� ��HW���y>�Y�-�Y��/�������hC�[*��F�#~�!�`�\r#0P�C˝�f������\\���^�%B<�\\�f�ޱ�����&/�O��L\\jF��jZ�1�\\:ƴ>�N��XaF�A�������f�h{\"s\n�64������?�8�^p�\"띰�ȸ\\�e(�P�N��q[g��r�&�}Ph���W��*��r_s�P�h���\n���om������#���.�\0@�pdW �\$Һ�Q۽Tl0� ��HdH�)��ۏ��)P���H�g��U����B�e\r�t:��\0)\"�t�,�����[�(D�O\nR8!�Ƭ֚��lA�V��4�h��Sq<��@}���gK�]���]�=90��'����wA<����a�~��W��D|A���2�X�U2��yŊ��=�p)�\0P	�s��n�3�r�f\0�F���v��G��I@�%���+��_I`����\r.��N���KI�[�ʖSJ���aUf�Sz���M��%��\"Q|9��Bc�a�q\0�8�#�<a��:z1Uf��>�Z�l������e5#U@iUG��n�%Ұs���;gxL�pP�?B��Q�\\�b��龒Q�=7�:��ݡQ�\r:�t�:y(� �\n�d)���\n�X;����CaA�\r���P�GH�!���@�9\n\nAl~H���V\ns��ի�Ư�bBr���������3�\r�P�%�ф\r}b/�Α\$�5�P�C�\"w�B_��U�gAt��夅�^Q��U���j����Bvh졄4�)��+�)<�j^�<L��4U*���Bg�����*n�ʖ�-����	9O\$��طzyM�3�\\9���.o�����E(i������7	tߚ�-&�\nj!\r��y�y�D1g���]��yR�7\"������~����)TZ0E9M�YZtXe!�f�@�{Ȭyl	8�;���R{��8�Į�e�+UL�'�F�1���8PE5-	�_!�7��[2�J��;�HR��ǹ�8p痲݇@��0,ծpsK0\r�4��\$sJ���4�DZ��I��'\$cL�R��MpY&����i�z3G�zҚJ%��P�-��[�/x�T�{p��z�C�v���:�V'�\\��KJa��M�&���Ӿ\"�e�o^Q+h^��iT��1�OR�l�,5[ݘ\$��)��jLƁU`�S�`Z^�|��r�=��n登��TU	1Hyk��t+\0v�D�\r	<��ƙ��jG���t�*3%k�YܲT*�|\"C��lhE�(�\r�8r��{��0����D�_��.6и�;����rBj�O'ۜ���>\$��`^6��9�#����4X��mh8:��c��0��;�/ԉ����;�\\'(��t�'+�����̷�^�]��N�v��#�,�v���O�i�ϖ�>��<S�A\\�\\��!�3*tl`�u�\0p'�7�P�9�bs�{�v�{��7�\"{��r�a�(�^��E����g��/���U�9g���/��`�\nL\n�)���(A�a�\" ���	�&�P��@O\n師0�(M&�FJ'�! �0�<�H�������*�|��*�OZ�m*n/b�/�������.��o\0��dn�)����i�:R���P2�m�\0/v�OX���Fʳψ���\"�����0�0�����0b��gj��\$�n�0}�	�@�=MƂ0n�P�/p�ot������.�̽�g\0�)o�\n0���\rF����b�i��o}\n�̯�	NQ�'�x�Fa�J���L������\r��\r����0��'��d	oep��4D��ʐ�q(~�� �\r�E��pr�QVFH�l��Kj���N&�j!�H`�_bh\r1���n!�Ɏ�z�����\\��\r���`V_k��\"\\ׂ'V��\0ʾ`AC������V�`\r%�����\r����k@N����B�횙� �!�\n�\0Z�6�\$d��,%�%la�H�\n�#�S\$!\$@��2���I\$r�{!��J�2H�ZM\\��hb,�'||cj~g�r�`�ļ�\$���+�A1�E���� <�L��\$�Y%-FD��d�L焳��\n@�bVf�;2_(��L�п��<%@ڜ,\"�d��N�er�\0�`��Z��4�'ld9-�#`��Ŗ����j6�ƣ�v���N�͐f��@܆�&�B\$�(�Z&���278I ��P\rk\\���2`�\rdLb@E��2`P( B'�����0�&��{���:��dB�1�^؉*\r\0c<K�|�5sZ�`���O3�5=@�5�C>@�W*	=\0N<g�6s67Sm7u?	{<&L�.3~D��\rŚ�x��),r�in�/��O\0o{0k�]3>m��1\0�I@�9T34+ԙ@e�GFMC�\rE3�Etm!�#1�D @�H(��n ��<g,V`R]@����3Cr7s~�GI�i@\0v��5\rV�'������P��\r�\$<b�%(�Dd��PW����b�fO �x\0�} ��lb�&�vj4�LS��ִԶ5&dsF M�4��\".H�M0�1uL�\"��/J`�{�����xǐYu*\"U.I53Q�3Q��J��g��5�s���&jь��u�٭ЪGQMTmGB�tl-c�*��\r��Z7���*hs/RUV����B�Nˈ�����Ԋ�i�Lk�.���t�龩�rYi���-S��3�\\�T�OM^�G>�ZQj���\"���i��MsS�S\$Ib	f���u����:�SB|i��Y¦��8	v�#�D�4`��.��^�H�M�_ռ�u��U�z`Z�J	e��@Ce��a�\"m�b�6ԯJR���T�?ԣXMZ��І��p����Qv�j�jV�{���C�\r��7�Tʞ� ��5{P��]�\r�?Q�AA������2񾠓V)Ji��-N99f�l Jm��;u�@�<F�Ѡ�e�j��Ħ�I�<+CW@�����Z�l�1�<2�iF�7`KG�~L&+N��YtWH飑w	����l��s'g��q+L�zbiz���Ţ�.Њ�zW�� �zd�W����(�y)v�E4,\0�\"d��\$B�{��!)1U�5bp#�}m=��@�w�	P\0�\r�����`O|���	�ɍ����Y��JՂ�E��Ou�_�\n`F`�}M�.#1��f�*�ա��  �z�uc���� xf�8kZR�s2ʂ-���Z2�+�ʷ�(�sU�cD�ѷ���X!��u�&-vP�ر\0'L�X �L����o	��>�Վ�\r@�P�\rxF��E��ȭ�%����=5N֜��?�7�N�Å�w�`�hX�98 �����q��z��d%6̂t�/������L��l��,�Ka�N~�����,�'�ǀM\rf9�w��!x��x[�ϑ�G�8;�xA��-I�&5\$�D\$���%��xѬ���´���]����&o�-3�9�L��z���y6�;u�zZ ��8�_�ɐx\0D?�X7����y�OY.#3�8��ǀ�e�Q�=؀*��G�wm ���Y�����]YOY�F���)�z#\$e��)�/�z?�z;����^��F�Zg�����������`^�e����#�������?��e��M��3u�偃0�>�\"?��@חXv�\"������*Ԣ\r6v~��OV~�&ר�^g���đٞ�'��f6:-Z~��O6;zx��;&!�+{9M�ٳd� \r,9����W��ݭ:�\r�ٜ��@睂+��]��-�[g��ۇ[s�[i��i�q��y��x�+�|7�{7�|w�}����E��W��Wk�|J؁��xm��q xwyj���#��e��(�������ߞþ��� {��ڏ�y���M���@��ɂ��Y�(g͚-����������J(���@�;�y�#S���Y��p@�%�s��o�9;�������+��	�;����ZNٯº��� k�V��u�[�x��|q��ON?���	�`u��6�|�|X����س|O�x!�:���ϗY]�����c���\r�h�9n�������8'������\rS.1��USȸ��X��+��z]ɵ��?����C�\r��\\����\$�`��)U�|ˤ|Ѩx'՜����<�̙e�|�ͳ����L���M�y�(ۧ�l�к�O]{Ѿ�FD���}�yu��Ē�,XL\\�x��;U��Wt�v��\\OxWJ9Ȓ�R5�WiMi[�K��f(\0�dĚ�迩�\r�M����7�;��������6�KʦI�\r���xv\r�V3���ɱ.��R������|��^2�^0߾\$�Q��[�D��ܣ�>1'^X~t�1\"6L���+��A��e�����I��~����@����pM>�m<��SK��-H���T76�SMfg�=��GPʰ�P�\r��>�����2Sb\$�C[���(�)��%Q#G`u��Gwp\rk�Ke�zhj��zi(��rO�������T=�7���~�4\"ef�~�d���V�Z���U�-�b'V�J�Z7���)T��8.<�RM�\$�����'�by�\n5����_��w����U�`ei޿J�b�g�u�S��?��`���+��� M�g�7`���\0�_�-���_��?�F�\0����X���[��J�8&~D#��{P���4ܗ��\"�\0��������@ғ��\0F ?*��^��w�О:���u��3xK�^�w���߯�y[Ԟ(���#�/zr_�g��?�\0?�1wMR&M���?�St�T]ݴG�:I����)��B�� v����1�<�t��6�:�W{���x:=��ޚ��:�!!\0x�����q&��0}z\"]��o�z���j�w�����6��J�P۞[\\ }��`S�\0�qHM�/7B��P���]FT��8S5�/I�\r�\n ��O�0aQ\n�>�2�j�;=ڬ�dA=�p�VL)X�\n¦`e\$�TƦQJ����lJ����y�I�	�:����B�bP���Z��n����U;>_�\n	�����`��uM򌂂�֍m����Lw�B\0\\b8�M��[z��&�1�\0�	�\r�T������+\\�3�Plb4-)%Wd#\n��r��MX\"ϡ�(Ei11(b`@f����S���j�D��bf�}�r����D�R1���b��A��Iy\"�Wv��gC�I�J8z\"P\\i�\\m~ZR��v�1ZB5I��i@x����-�uM\njK�U�h\$o��JϤ!�L\"#p7\0� P�\0�D�\$	�GK4e��\$�\nG�?�3�EAJF4�Ip\0��F�4��<f@� %q�<k�w��	�LOp\0�x��(	�G>�@�����9\0T����GB7�-�����G:<Q��#���Ǵ�1�&tz��0*J=�'�J>���8q��Х���	�O��X�F��Q�,����\"9��p�*�66A'�,y��IF�R��T���\"��H�R�!�j#kyF���e��z�����G\0�p��aJ`C�i�@�T�|\n�Ix�K\"��*��Tk\$c��ƔaAh��!�\"�E\0O�d�Sx�\0T	�\0���!F�\n�U�|�#S&		IvL\"����\$h���EA�N\$�%%�/\nP�1���{��) <���L���-R1��6���<�@O*\0J@q��Ԫ#�@ǵ0\$t�|�]�`��ĊA]���Pᑀ�C�p\\pҤ\0���7���@9�b�m�r�o�C+�]�Jr�f��\r�)d�����^h�I\\�. g��>���8���'�H�f�rJ�[r�o���.�v���#�#yR�+�y��^����F\0᱁�]!ɕ�ޔ++�_�,�\0<@�M-�2W���R,c���e2�*@\0�P ��c�a0�\\P���O���`I_2Qs\$�w��=:�z\0)�`�h�������\nJ@@ʫ�\0�� 6qT��4J%�N-�m����.ɋ%*cn��N�6\"\r͑�����f�A���p�MۀI7\0�M�>lO�4�S	7�c���\"�ߧ\0�6�ps�����y.��	���RK��PAo1F�tI�b*��<���@�7�˂p,�0N��:��N�m�,�xO%�!��v����gz(�M���I��	��~y���h\0U:��OZyA8�<2����us�~l���E�O�0��0]'�>��ɍ�:���;�/��w�����'~3GΖ~ӭ����c.	���vT\0c�t'�;P�\$�\$����-�s��e|�!�@d�Obw��c��'�@`P\"x����0O�5�/|�U{:b�R\"�0�шk���`BD�\nk�P��c��4�^ p6S`��\$�f;�7�?ls��߆gD�'4Xja	A��E%�	86b�:qr\r�]C8�c�F\n'ьf_9�%(��*�~��iS����@(85�T��[��Jڍ4�I�l=��Q�\$d��h�@D	-��!�_]��H�Ɗ�k6:���\\M-����\r�FJ>\n.��q�eG�5QZ����' ɢ���ہ0��zP��#������r���t����ˎ��<Q��T��3�D\\����pOE�%)77�Wt�[��@����\$F)�5qG0�-�W�v�`�*)Rr��=9qE*K\$g	��A!�PjBT:�K���!��H� R0?�6�yA)B@:Q�8B+J�5U]`�Ҭ��:���*%Ip9�̀�`KcQ�Q.B��Ltb��yJ�E�T��7���Am�䢕Ku:��Sji� 5.q%LiF��Tr��i��K�Ҩz�55T%U��U�IՂ���Y\"\nS�m���x��Ch�NZ�UZ���( B��\$Y�V��u@蔻����|	�\$\0�\0�oZw2Ҁx2���k\$�*I6I�n�����I,��QU4�\n��).�Q���aI�]����L�h\"�f���>�:Z�>L�`n�ض��7�VLZu��e��X����B���B�����Z`;���J�]�����S8��f \nڶ�#\$�jM(��ޡ����a�G���+A�!�xL/\0)	C�\n�W@�4�����۩� ��RZ����=���8�`�8~�h��P ��\r�	���D-FyX�+�f�QSj+X�|��9-��s�x�����+�V�cbp쿔o6H�q�����@.��l�8g�YM��WMP��U��YL�3Pa�H2�9��:�a�`��d\0�&�Y��Y0٘��S�-��%;/�T�BS�P�%f������@�F��(�֍*�q +[�Z:�QY\0޴�JUY֓/���pkzȈ�,�𪇃j�ꀥW�״e�J�F��VBI�\r��pF�Nقֶ�*ը�3k�0�D�{����`q��ҲBq�e�D�c���V�E���n����FG�E�>j�����0g�a|�Sh�7u�݄�\$���;a��7&��R[WX���(q�#���P���ז�c8!�H���VX�Ď�j��Z������Q,DUaQ�X0��ը���Gb��l�B�t9-oZ���L���­�pˇ�x6&��My��sҐ����\"�̀�R�IWU`c���}l<|�~�w\"��vI%r+��R�\n\\����][��6�&���ȭ�a�Ӻ��j�(ړ�Tѓ��C'��� '%de,�\n�FC�эe9C�N�Ѝ�-6�Ueȵ��CX��V������+�R+�����3B��ڌJ�虜��T2�]�\0P�a�t29��(i�#�aƮ1\"S�:�����oF)k�f���Ъ\0�ӿ��,��w�J@��V򄎵�q.e}KmZ����XnZ{G-���ZQ���}��׶�6ɸ���_�؁Չ�\n�@7�` �C\0]_ ��ʵ����}�G�WW: fCYk+��b۶���2S,	ڋ�9�\0﯁+�W�Z!�e��2�������k.Oc��(v̮8�DeG`ۇ�L���,�d�\"C���B-�İ(����p���p�=����!�k������}(���B�kr�_R�ܼ0�8a%ۘL	\0���b������@�\"��r,�0T�rV>����Q��\"�r��P�&3b�P��-�x���uW~�\"�*舞�N�h�%7���K�Y��^A����C����p����\0�..`c��+ϊ�GJ���H���E����l@|I#Ac��D��|+<[c2�+*WS<�r��g���}��>i�݀�!`f8�(c����Q�=f�\n�2�c�h4�+q���8\na�R�B�|�R����m��\\q��gX����ώ0�X�`n�F���O p��H�C��jd�f��EuDV��bJɦ��:��\\�!mɱ?,TIa���aT.L�]�,J��?�?��FMct!a٧R�F�G�!�A���rr�-p�X��\r��C^�7���&�R�\0��f�*�A\n�՛H��y�Y=���l�<��A�_��	+��tA�\0B�<Ay�(fy�1�c�O;p���ᦝ`�4СM��*��f�� 5fvy {?���:y��^c��u�'���8\0��ӱ?��g��� 8B��&p9�O\"z���rs�0��B�!u�3�f{�\0�:�\n@\0����p���6�v.;�����b�ƫ:J>˂��-�B�hkR`-����aw�xEj����r�8�\0\\����\\�Uhm� �(m�H3̴��S����q\0��NVh�Hy�	��5�M͎e\\g�\n�IP:Sj�ۡٶ�<���x�&�L��;nfͶc�q��\$f�&l���i�����0%yΞ�t�/��gU̳�d�\0e:��h�Z	�^�@��1��m#�N��w@��O��zG�\$�m6�6}��ҋ�X'�I�i\\Q�Y���4k-.�:yz���H��]��x�G��3��M\0��@z7���6�-DO34�ދ\0Κ��ΰt\"�\"vC\"Jf�Rʞ��ku3�M��~����5V ��j/3���@gG�}D���B�Nq��=]\$�I��Ӟ�3�x=_j�X٨�fk(C]^j�M��F��ա��ϣCz��V��=]&�\r�A<	������6�Ԯ�״�`jk7:g��4ծ��YZq�ftu�|�h�Z��6��i〰0�?��骭{-7_:��ސtѯ�ck�`Y��&���I�lP`:�� j�{h�=�f	��[by��ʀoЋB�RS���B6��^@'�4��1U�Dq}��N�(X�6j}�c�{@8���,�	�PFC���B�\$mv���P�\"��L��CS�]����E���lU��f�wh{o�(��)�\0@*a1G� (��D4-c��P8��N|R���VM���n8G`e}�!}���p�����@_���nCt�9��\0]�u��s���~�r��#Cn�p;�%�>wu���n�w��ݞ�.���[��hT�{��值	�ˁ��J���ƗiJ�6�O�=������E��ٴ��Im���V'��@�&�{��������;�op;^��6Ŷ@2�l���N��M��r�_ܰ�Í�` �( y�6�7�����ǂ��7/�p�e>|��	�=�]�oc����&�xNm���烻��o�G�N	p����x��ý���y\\3����'�I`r�G�]ľ�7�\\7�49�]�^p�{<Z��q4�u�|��Qۙ��p���i\$�@ox�_<���9pBU\"\0005�� i�ׂ��C�p�\n�i@�[��4�jЁ�6b�P�\0�&F2~������U&�}����ɘ	��Da<��zx�k���=���r3��(l_���FeF���4�1�K	\\ӎld�	�1�H\r���p!�%bG�Xf��'\0���	'6��ps_��\$?0\0�~p(�H\n�1�W:9�͢��`��:h�B��g�B�k��p�Ɓ�t��EBI@<�%����` �y�d\\Y@D�P?�|+!��W��.:�Le�v,�>q�A���:���bY�@8�d>r/)�B�4���(���`|�:t�!����?<�@���/��S��P\0��>\\�� |�3�:V�uw���x�(����4��ZjD^���L�'���C[�'�����jº[�E�� u�{KZ[s���6��S1��z%1�c��B4�B\n3M`0�;����3�.�&?��!YA�I,)��l�W['��ITj���>F���S���BбP�ca�ǌu�N����H�	LS��0��Y`���\"il�\r�B���/����%P���N�G��0J�X\n?a�!�3@M�F&ó����,�\"���lb�:KJ\r�`k_�b��A��į��1�I,�����;B,�:���Y%�J���#v��'�{������	wx:\ni����}c��eN���`!w��\0�BRU#�S�!�<`��&v�<�&�qO�+Σ�sfL9�Q�Bʇ����b��_+�*�Su>%0�����8@l�?�L1po.�C&��ɠB��qh�����z\0�`1�_9�\"���!�\$���~~-�.�*3r?�ò�d�s\0����>z\n�\0�0�1�~���J����|Sޜ��k7g�\0��KԠd��a��Pg�%�w�D��zm�����)����j�����`k���Q�^��1���+��>/wb�GwOk���_�'��-CJ��7&����E�\0L\r>�!�q́���7����o��`9O`�����+!}�P~E�N�c��Q�)��#��#�����������J��z_u{��K%�\0=��O�X�߶C�>\n���|w�?�F�����a�ϩU����b	N�Y��h����/��)�G��2���K|�y/�\0��Z�{��P�YG�;�?Z}T!�0��=mN����f�\"%4�a�\"!�ޟ����\0���}��[��ܾ��bU}�ڕm��2�����/t���%#�.�ؖ��se�B�p&}[˟��7�<a�K���8��P\0��g��?��,�\0�߈r,�>���W����/��[�q��k~�CӋ4��G��:��X��G�r\0������L%VFLUc��䑢��H�ybP��'#��	\0п���`9�9�~���_��0q�5K-�E0�b�ϭ�����t`lm����b��Ƙ; ,=��'S�.b��S���Cc����ʍAR,����X�@�'��8Z0�&�Xnc<<ȣ�3\0(�+*�3��@&\r�+�@h, ��\$O���\0Œ��t+>����b��ʰ�\r�><]#�%�;N�s�Ŏ����*��c�0-@��L� >�Y�p#�-�f0��ʱa�,>��`����P�:9��o���ov�R)e\0ڢ\\����\nr{îX����:A*��.�D��7�����#,�N�\r�E���hQK2�ݩ��z�>P@���	T<��=�:���X�GJ<�GAf�&�A^p�`���{��0`�:���);U !�e\0����c�p\r�����:(��@�%2	S�\$Y��3�hC��:O�#��L��/����k,��K�oo7�BD0{���j��j&X2��{�}�R�x��v���أ�9A����0�;0�����-�5��/�<�� �N�8E����	+�Ѕ�Pd��;���*n��&�8/jX�\r��>	PϐW>K��O��V�/��U\n<��\0�\nI�k@��㦃[��Ϧ²�#�?���%���.\0001\0��k�`1T� ����ɐl�������p���������< .�>��5��\0��	O�>k@Bn��<\"i%�>��z��������3�P�!�\r�\"��\r �>�ad���U?�ǔ3P��j3�䰑>;���>�t6�2�[��޾M\r�>��\0��P���B�Oe*R�n���y;� 8\0���o�0���i���3ʀ2@����?x�[����L�a����w\ns����A��x\r[�a�6�clc=�ʼX0�z/>+����W[�o2���)e�2�HQP�DY�zG4#YD����p)	�H�p���&�4*@�/:�	�T�	���aH5���h.�A>��`;.���Y��a	���t/ =3��BnhD?(\n�!�B�s�\0��D�&D�J��)\0�j�Q�y��hDh(�K�/!�>�h,=�����tJ�+�S��,\"M�Ŀ�N�1�[;�Т��+��#<��I�Zğ�P�)��LJ�D��P1\$����Q�>dO��v�#�/mh8881N:��Z0Z���T �B�C�q3%��@�\0��\"�XD	�3\0�!\\�8#�h�v�ib��T�!d�����V\\2��S��Œ\nA+ͽp�x�iD(�(�<*��+��E��T���B�S�CȿT���� e�A�\"�|�u�v8�T\0002�@8D^oo�����|�N������J8[��3����J�z׳WL\0�\0��Ȇ8�:y,�6&@�� �E�ʯݑh;�!f��.B�;:���[Z3������n���ȑ��A���qP4,��Xc8^��`׃��l.����S�hޔ���O+�%P#Ρ\n?��IB��eˑ�O\\]��6�#��۽؁(!c)�N����?E��B##D �Ddo��P�A�\0�:�n�Ɵ�`  ��Q��>!\r6�\0��V%cb�HF�)�m&\0B�2I�5��#]���D>��3<\n:ML��9C���0��\0���(ᏩH\n����M�\"GR\n@���`[���\ni*\0��)������u�)��Hp\0�N�	�\"��N:9q�.\r!���J��{,�'����4�B���lq���Xc��4��N1ɨ5�Wm��3\n��F��`�'��Ҋx��&>z>N�\$4?����(\n쀨>�	�ϵP�!Cq͌��p�qGLqq�G�y�H.�^��\0z�\$�AT9Fs�Ѕ�D{�a��cc_�G�z�)� �}Q��h��HBָ�<�y!L����!\\�����'�H(��-�\"�in]Ğ���\\�!�`M�H,gȎ��*�Kf�*\0�>6���6��2�hJ�7�{nq�8����H�#c�H�#�\r�:��7�8�܀Z��ZrD��߲`rG\0�l\n�I��i\0<����\0Lg�~���E��\$��P�\$�@�PƼT03�HGH�l�Q%*\"N?�%��	��\n�CrW�C\$��p�%�uR`��%��R\$�<�`�Ifx���\$/\$�����\$���O�(���\0��\0�RY�*�/	�\rܜC9��&hh�=I�'\$�RRI�'\\�a=E����u·'̙wI�'T���������K9%�d����!��������j�����&���v̟�\\=<,�E��`�Y��\\����*b0>�r��,d�pd���0DD ̖`�,T �1�% P���/�\r�b�(���J����T0�``ƾ����J�t���ʟ((d�ʪ�h+ <Ɉ+H%i�����#�`� ���'��B>t��J�Z\\�`<J�+hR���8�hR�,J]g�I��0\n%J�*�Y���JwD��&ʖD�������R�K\"�1Q�� ��AJKC,�mV�������-���KI*�r��\0�L�\"�Kb(����J:qKr�d�ʟ-)��ˆ#Ը�޸[�A�@�.[�Ҩʼ�4���.�1�J�.̮�u#J���g\0��򑧣<�&���K�+�	M?�/d��%'/��2Y��>�\$��l�\0��+����}-t��ͅ*�R�\$ߔ��K�.����JH�ʉ�2\r��B���(P���6\"��nf�\0#Ї ��%\$��[�\n�no�LJ�����e'<����1K��y�Y1��s�0�&zLf#�Ƴ/%y-�ˣ3-��K��L�΁��0����[,��̵,������0���(�.D��@��2�L+.|�����2�(�L�*��S:\0�3����G3l��aːl�@L�3z4�ǽ%̒�L�3����!0�33=L�4|ȗ��+\"���4���7�,\$�SPM�\\��?J�Y�̡��+(�a=K��4���C̤<Ё�=\$�,��UJ]5h�W�&t�I%��5�ҳ\\M38g�́5H�N?W1H��^��Ը�Y͗ؠ�͏.�N3M�4Å�`��i/P�7�dM>�d�/�LR���=K�60>�I\0[��\0��\r2���Z@�1��2��7�9�FG+�Ҝ�\r)�hQtL}8\$�BeC#��r*H�۫�-�H�/���6��\$�RC9�ب!���7�k/P�0Xr5��3D���<T�Ԓq�K���n�H�<�F�:1SL�r�%(��u)�Xr�1��nJ�I��S�\$\$�.·9��IΟ�3 �L�l���Ι9��C�N�#ԡ�\$�/��s��9�@6�t���N�9���N�:����7�Ӭ�:D���M)<#���M}+�2�N��O&��JNy*���ٸ[;���O\"m����M�<c�´���8�K�,���N�=07s�JE=T��O<����J�=D��:�C<���ˉ=���K�ʻ̳�L3�����LTЀ3�S,�.���q-��s�7�>�?�7O;ܠ`�OA9���ϻ\$���O�;��`9�n�I�A�xp��E=O�<��5����2�O�?d�����`N�iO�>��3�P	?���O�m��S�M�ˬ��=�(�d�Aȭ9���\0�#��@��9D����&���?����i9�\n�/��A���ȭA��S�Po?kuN5�~4���6���=򖌓*@(�N\0\\۔dG��p#��>�0��\$2�4z )�`�W���+\0��80�菦������z\"T��0�:\0�\ne \$��rM�=�r\n�N�P�Cmt80�� #��J=�&��3\0*��B�6�\"������#��>�	�(Q\n���8�1C\rt2�EC�\n`(�x?j8N�\0��[��QN>���'\0�x	c���\n�3��Ch�`&\0���8�\0�\n���O`/����A`#��Xc���D �tR\n>���d�B�D�L��������Dt4���j�p�GAoQoG8,-s����K#�);�E5�TQ�G�4Ao\0�>�tM�D8yRG@'P�C�	�<P�C�\"�K\0��x��~\0�ei9���v))ѵGb6���H\r48�@�M�:��F�tQ�!H��{R} �URp���O\0�I�t8������[D4F�D�#��+D�'�M����>RgI���Q�J���U�)Em���TZ�E�'��iE����qFzA��>�)T�Q3H�#TL�qIjNT���&C��h�X\nT���K\0000�5���JH�\0�FE@'љFp�hS5F�\"�oѮ�e%aoS E)� ��DU��Q�Fm�ѣM��Ѳe(tn� �U1ܣ~>�\$��ǂ��(h�ǑG�y`�\0��	��G��3�5Sp(��P�G�\$��#��	���N�\n�V\$��]ԜP�=\"RӨ?Lzt��1L\$\0��G~��,�KN�=���GM����NS�)��O]:ԊS}�81�RGe@C�\0�OP�S�N�1��T!P�@��S����S�G`\n�:��P�j�7R� @3��\n� �������DӠ��L�����	��\0�Q5���CP��SMP�v4��?h	h�T�D0��֏��>&�ITx�O�?�@U��R8@%Ԗ��K���N�K��RyE�E#�� @����%L�Q�Q����?N5\0�R\0�ԁT�F�ԔR�S�!oTE�C(�����ĵ\0�?3i�SS@U�QeM��	K�\n4P�CeS��\0�NC�P��O�!�\"RT�����S�N���U5OU>UiI�PU#UnKP��UYT�*�C��U�/\0+���)��:ReA�\$\0���x��WD�3���`����U5�IHUY��:�P	�e\0�MJi�����Q�>�@�T�C{��u��?�^�v\0WR�]U}C��1-5+U�?�\r�W<�?5�JU-SX��L�� \\t�?�sM�b�ՃV܁t�T�>�MU+�	E�c���9Nm\rRǃC�8�S�X�'R��XjCI#G|�!Q�Gh�t�Q��� )<�Y�*��RmX0����M���OQ�Y�h���du���Z(�Ao#�NlyN�V�Z9I���M��V�ZuOՅT�T�EՇַS�e����\n�X��S�QER����[MF�V�O=/����>�gչT�V�oU�T�Z�N�*T\\*����S-p�S��V�q��M(�Q=\\�-UUUV�C���Z�\nu�V\$?M@U�WJ\r\rU��\\�'U�W]�W��W8�N�'#h=oC���F(��:9�Yu����V-U�9�]�C�:U�\\�\n�qW���(TT?5P�\$ R3�⺟C}`>\0�E]�#R��	��#R�)�W���:`#�G�)4�R��;��ViD%8�)Ǔ^�Q��#�h	�HX	��\$N�x��#i x�ԒXR��'�9`m\\���\nE��Q�`�bu@��N�dT�#YY����GV�]j5#?L�xt/#���#酽O�P��Q��6����^� �������M\\R5t�Ӛp�*��X�V\"W�D�	oRALm\rdG�N	����6�p\$�P废E5����Tx\n�+��C[��V�����8U�Du}ػF\$.��Q-;4Ȁ�NX\n�.X�b͐�\0�b�)�#�N�G4K��ZS�^״M�8��d�\"C��>��dHe\n�Y8���.� ���ҏF�D��W1cZ6��Q�KH�@*\0�^���\\Q�F�4U3Y|�=�Ӥ�E��ۤ�?-�47Y�Pm�hYw_\r�VeױM���ُe(0��F�\r�!�PUI�u�7Q�C�ю?0����gu\rqधY-Q�����=g\0�\0M#�U�S5Zt�֟ae^�\$>�ArV�_\r;t���HW�Z�@H��hzD��\0�S2J� HI�O�'ǁe�g�6�[�R�<�?� /��KM����\n>��H�Z!i����TX6���i�C !ӛg�� �G }Q6��4>�w�!ڙC}�VB�>�UQڑj�8c�U�T���'<�>����HC]�V��7jj3v���`0���23����x�@U�k�\n�:Si5��#Y�-w����M?c��MQ�GQ�уb`��\0�@��ҧ\0M��)ZrKX�֟�Wl������l�TM�D\r4�QsS�40�sQ́�mY�h�d��C`{�V�gE�\n��XkՁ�'��,4���^��6�#<4��NXnM):��OM_6d�������[\"KU�n��?l�x\0&\0�R56�T~>��ո?�Jn��� ��Z/i�6���glͦ�U��F}�.����JL�CTbM�4��cL�TjSD�}Jt���Z����:�L���d:�Ez�ʤ�>��V\$2>����[�p�6��R�9u�W.?�1��RHu���R�?58Ԯ��D��u���p�c�Z�?�r׻ Eaf��}5wY���ϒ���W�wT[Sp7'�_aEk�\"[/i��#�\$;m�fأWO����F�\r%\$�ju-t#<�!�\n:�KEA����]�\nU�Q�KE��#��X��5[�>�`/��D��֭VEp�)��I%�q���n�x):��le���[e�\\�eV[j�����7 -+��G�WEwt�WkE�~u�Q/m�#ԐW�`�yu�ǣD�A�'ױ\r��ՙO�D )ZM^��u-|v8]�g��h���L��W\0���6�X��=Y�d�Q�7ϓ��9����r <�֏�D��B`c�9���`�D�=wx�I%�,ᄬ�����j[њ����O��� ``��|�����������.�	AO���	��@�@ 0h2�\\�ЀM{e�9^>���@7\0��˂W���\$,��Ś�@؀����w^fm�,\0�yD,ם^X�.�ֆ�7����2��f;��6�\n����^�zC�קmz��n�^���&LFF�,��[��e��aXy9h�!:z�9c�Q9b� !���Gw_W�g�9���S+t���p�tɃ\nm+����_�	��\\���k5���]�4�_h�9 ��N����]%|��7�֜�];��|���X��9�|����G���[��\0�}U���MC�I:�qO�Vԃa\0\r�R�6π�\0�@H��P+r�S�W���p7�I~�p/��H�^������E�-%��̻�&.��+�Jђ;:���!���N�	�~����/�W��!�B�L+�\$��q�=��+�`/Ƅe�\\���x�pE�lpS�JS�ݢ��6��_�(ů���b\\O��&�\\�59�\0�9n���D�{�\$���K��v2	d]�v�C�����?�tf|W�:���p&��Ln��賞�{;���G�R9��T.y���I8���\rl� �	T��n�3���T.�9��3����Z�s����G����:	0���z��.�]��ģQ�?�gT�%��x�Ռ.����n<�-�8B˳,B��rgQ�����Ɏ`��2�:{�g��s��g�Z��� ׌<��w{���bU9�	`5`4�\0BxMp�8qnah�@ؼ�-�(�>S|0�����3�8h\0���C�zLQ�@�\n?��`A��>2��,���N�&��x�l8sah1�|�B�ɇD�xB�#V��V�׊`W�a'@���	X_?\n�  �_�. �P�r2�bUar�I�~��S���\0ׅ\"�2����>b;�vPh{[�7a`�\0�˲j�o�~���v��|fv�4[�\$��{�P\rv�BKGbp������O�5ݠ2\0j�لL���)�m��V�ejBB.'R{C��V'`؂ ��%�ǀ�\$�O��\0�`����4 �N�>;4���/�π��*��\\5���!��`X*�%��N�3S�AM���Ɣ,�1����\\��caϧ ��@��˃�B/����0`�v2��`hD�JO\$�@p!9�!�\n1�7pB,>8F4��f�π:��7���3��3����T8�=+~�n���\\�e�<br����Fز� ��C�N�:c�:�l�<\r��\\3�>���6�ONn��!;��@�tw�^F�L�;���,^a��\ra\"��ڮ'�:�v�Je4�א;��_d\r4\r�:����S�����2��[c��X�ʦPl�\$�ޣ�i�w�d#�B��b��������`:���~ <\0�2����R���P�\r�J8D�t@�E��\0\r͜6����7����Y���\"����\r�����3��.�+�z3�;_ʟvL����wJ�94�I�Ja,A����;�s?�N\nR��!��ݐ�Om�s�_��-zۭw���zܭ7���z���M����o����\0��a��ݹ4�8�Pf�Y�?��i��eB�S�1\0�jDTeK��UYS�?66R	�c�6Ry[c���5�]B͔�R�_eA)&�[凕XYRW�6VYaeU�fYe�w��U�b�w�E�ʆ;z�^W�9��ק�ݖ��\0<ޘ�e�9S���da�	�_-��L�8ǅ�Q��TH[!<p\0��Py5�|�#��P�	�9v��2�|Ǹ��fao��,j8�\$A@k����a���b�c��f4!4���cr,;�����b�=��;\0��ź���cd��X�b�x�a�Rx0A�h�+w�xN[��B��p���w�T�8T%��M�l2�������}��s.kY��0\$/�fU�=��s�gK���M� �?���`4c.��!�&�分g��f�/�f1�=��V AE<#̹�f\n�)���Np��`.\"\"�A�����q��X��٬:a�8��f��Vs�G��r�:�V��c�g�Vl��g=��`��W���y�gU��˙�Ẽ�eT=�����x 0� M�@����%κb���w��f��O�筘�*0���|t�%��P��p��gK���?p�@J�<Bٟ#�`1��9�2�g�!3~����nl��f��Vh���.����aC���?���-�1�68>A��a�\r��y�0��i�J�}�������z:\r�)�S���@��h@���Y���mCEg�cyφ��<���h@�@�zh<W��`��:zO���\r��W���V08�f7�(Gy���`St#��f�#����C(9���؀d���8T:���0�� q���79��phAg�6�.��7Fr�b� �j��A5��a1��h�ZCh:�%��gU��D9��Ɉ�׹��0~vTi;�VvS��w��\r΃?��f�����n�ϛiY��a��3�·9�,\n��r��,/,@.:�Y>&��F�)�����}�b���iO�i��:d�A�n��c=�L9O�h{�� 8hY.������������\r��և�����1Q�U	�C�h��e�O���+2o����N�����zp�(�]�h��Z|�O�c�zD���;�T\0j�\0�8#�>Ύ�=bZ8Fj���;�޺T酡w��)���N`���ÅB{��z\r�c���|dTG�i�/��!i��0���'`Z:�CH�(8�`V������\0�ꧩ��W��Ǫ��zgG������-[��	i��N\rq��n���o	ƥfEJ��apb��}6���=o���,t�Y+��EC\r�Px4=����@���.��F��[�zq���X6:FG��#��\$@&�ab��hE:����`�S�1�1g1���2uhY��_:Bߡdc�*���\0�ƗFYF�:���n���=ۨH*Z�Mhk�/�냡�zٹ]��h@����1\0��ZK�������^+�,vf�s��>���O�|���s�\0֜5�X��ѯF��n�A�r]|�Ii4�� ��C� h@ع����cߥ�6smO������gX�V2�6g?~��Y�Ѱ�s�cl \\R�\0��c��A+�1������\n(����^368cz:=z��(�� ;裨�s�F�@`;�,>yT��&��d�Lן��%��-�CHL8\r��b�����Mj]4�Ym9����Z�B��P}<���X���̥�+g�^�M� + B_Fd�X���l�w�~�\r⽋�\":��qA1X������3�ΓE�h�4�ZZ��&����1~!N�f��o���\nMe�଄��XI΄�G@V*X��;�Y5{V�\n���T�z\rF�3}m��p1�[�>�t�e�w����@V�z#��2��	i���{�9��p̝�gh���+[elU���A�ٶӼi1�!��omm�*K���}��!�Ƴ����{me�f`��m��C�z=�n�:}g� T�mLu1F��}=8�Z���O��mFFMf��OO����������/����ޓ���V�oqj���n!+����Z��I�.�9!nG�\\��3a�~�O+��::�K@�\n�@���Hph��\\B��dm�fvC���P�\" ��.nW&��n��HY�+\r���z�i>Mfqۤ��Qc�[�H+��o��*�1'��#āEw�D_X�)>�s��-~\rT=�������- �y�m����{�h��j�M�)�^����'@V�+i�������;F��D[�b!����B	��:MP���ۭoC�vAE?�C�IiY��#�p�P\$k�J�q�.�07���x�l�sC|���bo�2�X�>M�\rl&��:2�~��cQ����o��d�-��U�Ro�Y�nM;�n�#��\0�P�f��Po׿(C�v<���[�o۸����fѿ���;�ẖ�[�Y�.o�Up���pU���.���B!'\0���<T�:1�������<���n��F���I�ǔ��V0�ǁRO8�w��,aF��ɥ�[�Ο��YO����/\0��ox���Q�?��:ً���`h@:�����/M�m�x:۰c1������v�;���^���@��@�����\n{�����;���B���8�� g坒�\\*g�yC)��E�^�O�h	���A�u>���@�D��Y�����`o�<>��p���ķ�q,Y1Q��߸��/qg�\0+\0���D���?�� ����k:�\$����ץ6~I��=@���!��v�zO񁚲�+���9�i����a������g������?��0Gn�q�]{Ҹ,F���O���� <_>f+��,��	���&�����·�y�ǩO�:�U¯�L�\n�úI:2��-;_Ģ�|%�崿!��f�\$���Xr\"Kni����\$8#�g�t-��r@L�圏�@S�<�rN\n�D/rLdQk࣓�����e����Э��\n=4)�B���ך�");
    } else {
        header("Content-Type: image/gif");
        switch ($_GET["file"]) {case"plus.gif":echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0!�����M��*)�o��) q��e���#��L�\0;";
        break;
        case"cross.gif":echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0#�����#\na�Fo~y�.�_wa��1�J�G�L�6]\0\0;";
        break;
        case"up.gif":echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����MQN\n�}��a8�y�aŶ�\0��\0;";
        break;
        case"down.gif":echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����M��*)�[W�\\��L&ٜƶ�\0��\0;";
        break;
        case"arrow.gif":echo"GIF89a\0\n\0�\0\0������!�\0\0\0,\0\0\0\0\0\n\0\0�i������Ӳ޻\0\0;";
        break;
    }
    }
    exit;
} if ($_GET["script"]=="version") {
    $q=file_open_lock(get_temp_dir()."/adminer.version");
    if ($q) {
        file_write_unlock($q, serialize(array("signature"=>$_POST["signature"],"version"=>$_POST["version"])));
    }
    exit;
}global$b,$f,$k,$Jb,$Qb,$ac,$l,$Dc,$Ic,$ba,$ad,$y,$ca,$sd,$oe,$Se,$ig,$Nc,$T,$Qg,$Wg,$dh,$ga; if (!$_SERVER["REQUEST_URI"]) {
    $_SERVER["REQUEST_URI"]=$_SERVER["ORIG_PATH_INFO"];
} if (!strpos($_SERVER["REQUEST_URI"], '?')&&$_SERVER["QUERY_STRING"]!="") {
    $_SERVER["REQUEST_URI"].="?$_SERVER[QUERY_STRING]";
} if ($_SERVER["HTTP_X_FORWARDED_PREFIX"]) {
    $_SERVER["REQUEST_URI"]=$_SERVER["HTTP_X_FORWARDED_PREFIX"].$_SERVER["REQUEST_URI"];
}$ba=($_SERVER["HTTPS"]&&strcasecmp($_SERVER["HTTPS"], "off"))||ini_bool("session.cookie_secure");@ini_set("session.use_trans_sid", false); if (!defined("SID")) {
    session_cache_limiter("");
    session_name("adminer_sid");
    $Je=array(0,preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]),"",$ba);
    if (version_compare(PHP_VERSION, '5.2.0')>=0) {
        $Je[]=true;
    }
    call_user_func_array('session_set_cookie_params', $Je);
    session_start();
}remove_slashes(array(&$_GET,&$_POST,&$_COOKIE), $uc); if (get_magic_quotes_runtime()) {
    set_magic_quotes_runtime(false);
}@set_time_limit(0);@ini_set("zend.ze1_compatibility_mode", false);@ini_set("precision", 15);$sd=array('en'=>'English','ar'=>'العربية','bg'=>'Български','bn'=>'বাংলা','bs'=>'Bosanski','ca'=>'Català','cs'=>'Čeština','da'=>'Dansk','de'=>'Deutsch','el'=>'Ελληνικά','es'=>'Español','et'=>'Eesti','fa'=>'فارسی','fi'=>'Suomi','fr'=>'Français','gl'=>'Galego','he'=>'עברית','hu'=>'Magyar','id'=>'Bahasa Indonesia','it'=>'Italiano','ja'=>'日本語','ka'=>'ქართული','ko'=>'한국어','lt'=>'Lietuvių','ms'=>'Bahasa Melayu','nl'=>'Nederlands','no'=>'Norsk','pl'=>'Polski','pt'=>'Português','pt-br'=>'Português (Brazil)','ro'=>'Limba Română','ru'=>'Русский','sk'=>'Slovenčina','sl'=>'Slovenski','sr'=>'Српски','sv'=>'Svenska','ta'=>'த‌மிழ்','th'=>'ภาษาไทย','tr'=>'Türkçe','uk'=>'Українська','vi'=>'Tiếng Việt','zh'=>'简体中文','zh-tw'=>'繁體中文',);function get_lang()
{
    global$ca;
    return$ca;
}function lang($v, $fe=null)
{
    if (is_string($v)) {
        $Ve=array_search($v, get_translations("en"));
        if ($Ve!==false) {
            $v=$Ve;
        }
    }
    global$ca,$Qg;
    $Pg=($Qg[$v]?$Qg[$v]:$v);
    if (is_array($Pg)) {
        $Ve=($fe==1?0:($ca=='cs'||$ca=='sk'?($fe&&$fe<5?1:2):($ca=='fr'?(!$fe?0:1):($ca=='pl'?($fe%10>1&&$fe%10<5&&$fe/10%10!=1?1:2):($ca=='sl'?($fe%100==1?0:($fe%100==2?1:($fe%100==3||$fe%100==4?2:3))):($ca=='lt'?($fe%10==1&&$fe%100!=11?0:($fe%10>1&&$fe/10%10!=1?1:2)):($ca=='bs'||$ca=='ru'||$ca=='sr'||$ca=='uk'?($fe%10==1&&$fe%100!=11?0:($fe%10>1&&$fe%10<5&&$fe/10%10!=1?1:2)):1)))))));
        $Pg=$Pg[$Ve];
    }
    $ua=func_get_args();
    array_shift($ua);
    $_c=str_replace("%d", "%s", $Pg);
    if ($_c!=$Pg) {
        $ua[0]=format_number($fe);
    }
    return
vsprintf($_c, $ua);
}function switch_lang()
{
    global$ca,$sd;
    echo"<form action='' method='post'>\n<div id='lang'>",lang(19).": ".html_select("lang", $sd, $ca, "this.form.submit();")," <input type='submit' value='".lang(20)."' class='hidden'>\n","<input type='hidden' name='token' value='".get_token()."'>\n";
    echo"</div>\n</form>\n";
} if (isset($_POST["lang"])&&verify_token()) {
    cookie("adminer_lang", $_POST["lang"]);
    $_SESSION["lang"]=$_POST["lang"];
    $_SESSION["translations"]=array();
    redirect(remove_from_uri());
}$ca="en"; if (isset($sd[$_COOKIE["adminer_lang"]])) {
    cookie("adminer_lang", $_COOKIE["adminer_lang"]);
    $ca=$_COOKIE["adminer_lang"];
} elseif (isset($sd[$_SESSION["lang"]])) {
    $ca=$_SESSION["lang"];
} else {
    $la=array();
    preg_match_all('~([-a-z]+)(;q=([0-9.]+))?~', str_replace("_", "-", strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"])), $Gd, PREG_SET_ORDER);
    foreach ($Gd
as$C) {
        $la[$C[1]]=(isset($C[3])?$C[3]:1);
    }
    arsort($la);
    foreach ($la
as$z=>$H) {
        if (isset($sd[$z])) {
            $ca=$z;
            break;
        }
        $z=preg_replace('~-.*~', '', $z);
        if (!isset($la[$z])&&isset($sd[$z])) {
            $ca=$z;
            break;
        }
    }
}$Qg=$_SESSION["translations"]; if ($_SESSION["translations_version"]!=1112001675) {
    $Qg=array();
    $_SESSION["translations_version"]=1112001675;
}function get_translations($rd)
{
    switch ($rd) {case"en":$e="A9D�y�@s:�G�(�ff�����	��:�S���a2\"1�..L'�I��m�#�s,�K��OP#I�@%9��i4�o2ύ���,9�%�P�b2��a��r\n2�NC�(�r4��1C`(�:Eb�9A�i:�&㙔�y��F��Y��\r�\n� 8Z�S=\$A����`�=�܌���0�\n��dF�	��n:Zΰ)��Q���mw����O��mfpQ�΂��q��a�į�#q��w7S�X3���=�O��ztR-�<����i��gKG4�n����r&r�\$-��Ӊ�����KX�9,�8�7�o��)�*���/�h��/Ȥ\n�9��8�Ⳉ�E\r�P�/�k��)��\\# ڵ����)jj8:�0�c�9�i}�QX@;�B#�I�\0x����C@�:�t���\$�~��8^�ㄵ�C ^(�ڳ��p̳�M�^�|�8�(Ʀ�k�Q+�;�:�hKN ����2c(�T1����0@�B�78o�J��C�:��rξ��6%�x�<�\r=�6�m�p:��ƀ٫ˌ3#�CR6#N)�4�#�u&�/���3�#;9tCX�4N`�;���#C\"�%5����£�\"�h�z7;_q�CcB����\n\"`@�Y��d��MTTR}W���y�#!�/�+|�QFN��yl@�2�J��_�(�\"��~b��h��(e �/���P�lB\r�Cx�3\r��P&E��*\r��d7(��NIQ�makw.�Iܵ���{9Z\r�l׶ԄI2^߉Fۛ/n��om���/c��4�\"�)̸�5��pAp5���Qjׯ�6��p��P*1n�}C�c�����K�s�Tr�1L�4�5M�p�8GQ��9N��QCt�z�{�FQԄGt)�Ҁ���:2�\\K��q�rP�B��ω\n�8|�D�eLi�3��֛Szqz@�:�w�{Oy�O�\$�\".�_\0><@��d�]�)�\$96th��a�u�#A�tSO��4A�ٺt��R�&bP�;�HCfd���7�Qt9an��2\$��B4\r+t�!\nQyo7稈0��G!�\$!@\$�g`�|\0���D@I�\$ƈ�, �o�;�3D4�2.eIa'Ɓ �f���nr�t��a�a�v��W��F��Jo11��\\���}Jf}y��ҙ�� LY�2RJ�i/7����a	�\$\r'2➒���@��\"ִ�c8(P�B]��/����M�Q\$��;��c#��j���e]�eWŦa��0atAH���U<OR����r:s���)�K�r��i(j�l��<Hpb��M�ˢpd�F\n��\0*��oK��B�↡I�tT�eAxO	��*�\0�B�ET�@�-9e�\rb���\rB(� C��];,k�����p	Ho5Dr����v\0T�Pf6Dȷ1<R�};�0���j���G�\r\"H��Ԕ�lYM�W�v�+@�(+ ��yϹ�3���5�af:�p�0�,g=�`��[ 	j���3�/{-��X�t����95�IF#�]%z�����UN�ڧ\n��D���ϕ%-w�2\n�U�z���ܒ��!6���R�B�?wa\0�*�1Ff��Zv�-��Qr��tx}�)�6��g��%j�P �0�&�~�rZ8M(���@E;g��`�C	/`�ExHL�ADٸ���!	�-.��BH�ݵ�'�Ӊ�)��	%�����6yz�.(3��^�loq��b�a,a��p^I�2��\\��X;)����BpG(z'��4�����<��q��H��\n\n�1�5E�A�\nK�@�2Q�/�qK�M1�G�\$ b�YB�Ceڐ���L�01d�����r\$F�,&)J��G���'�Q��n��bvg�Z�Z��t�lS^�Z�U��d�b�)��ᩥ��Ë\0��ۑsf���B�I��\n� ��U7)/�i�U�}��̭��_l���7�Od�5�N�(a5@4��Q�9�f�f�j�s�\nEL㆘#��8�z՚�cN��x_���d�@�����G��_1bdMq�S13c(hB���|W�w�O����!g@�v��i⡓�Ȏ�@iH �|���M�I����W{�l�>i.|������\\�I�.�U�{���\\L����|����5��E�C�X�D�YҦ%���ʕ\$}��n�z�+�FT�����c5n���o��}�U�W{>�Q��K���u�=�C0�\n�����=v��%���H�}7����g�R��/�����M\r�����Xڝ�br!�)4���w�u�L�@�s�U�����#�}��:�őYQ���j���0i(2)�i�a�^�Fd2+\0���+�!#�,���Ҽ�r�Ovlk�G�~�g�F玾��+�\0��>�DC`�%�N��\n�yoV%]��P4C�;�^�P	D_\$N����Y���>4�{\0��ևLg	o�Ic,�G	�^��<7�8o2.\"�	hu�B�.h�̪W�`\r�����\r�V�@�`��\$��b0l��.��m\"�(b��ɴ�&�\n���Z�5��9���/r%��\n.�\r���,��\"c�3���8��N	��\r1@ئ�6��b�.�j-p�3Ҝ��[�X����@`DB:1Z*,�J�p�Ŵ/-�\n���6\\�x��ՐܮJ��K[Q6�-��m�0��0c�F���w*:��}�����qL�\r��\$\0���� � ^���4�r�K\n�\"^�Q�'dp-��\"�6R@�D�|�,\\�,91P5C0)��Q\$k`ʫB��жfX���\"�-K�2�TÀ��d\$�r�b���{'�#�}(@\\";break;case"ar":$e="�C�P���l*�\r�,&\n�A���(J.��0Se\\�\r��b�@�0�,\nQ,l)���µ���A��j_1�C�M��e��S�\ng@�Og���X�DM�)��0��cA��n8�e*y#au4�� �Ir*;rS�U�dJ	}���*z�U�@��X;ai1l(n������[�y�d�u'c(��oF����e3�Nb���p2N�S��ӳ:LZ�z�P�\\b�u�.�[�Q`u	!��Jy��&2��(gT��SњM�x�5g5�K�K�¦����0ʀ(�7\rm8�7(�9\r�f\"7�^��pL\n7A�*�BP��<7cp�4���Y�+dHB&���O��̤��\\�<i���H��2�lk4�����ﲠƗ\ns W��HBƯ��(�z �>����%�t�\$(�R�\n�v�-��������R���0ӣ�et�@2�� ��k� ��4�x荶�I�#��C�X@0ѭӄ0�m(�4���0�ԃ����`@T@�2���D4���9�Ax^;؁p�D�pT3��(��m^9�xD��lҽC46�Q\0��|��%��[F��ڏ���t�wk��j�P���Ӭ� ��m~�s���Pi�����n�E���9\r�PΎ�\$ؠ#�����r��8#��:�Yc���(r�\"W�6Rc��6�+�)/w�I(J���'	j?��ɩ�U�H��E*�߂]Z\r�~�F�d�i�	�[�r�(�}���B6n66��61�#s�-��p@)�\"bԇ����d��l�1\\��]�����1K���ű�\"�J\\�n����S_7k����!��ٖN;�^��qj��Z��1̃Ň�W4O=7x�\" ��&��B9�`�4�J7��0�E��µɺ��ț�B���\\p����MS�6n\r�x��u��9}c�OP �,d(��M�(`���r,�\0C\naH#B��#\rO�9E�N\nS�-�����L��il]I��B���F0��9��\0�Q�Y��Ɨ��)�@�o'اC8 Q+ ƈP�dQ��Ыur���X+\rb�x�����Y��G!@踖�>�����E�S��{�%���6aW΍u���Yz{�����ɘMT��#-櫕��4�p�b��W\n�^+倰� wX� 7 `\\��j�Chu���Hm�6��������T��kCk[�L8 g�-�Au\"T���&���'��fA�S1��N�b4�9DYjƃf��Q�H�����@��ޛI�F���KK`��ÙO'n�<��_��%c��9��a\n�89B&~�\rt�\\�P��VSQ3h�R�8Χ���5���V4����7�ELN\0��qOx�v�st��%(�P�\n��6U�6j�9�7\0�!�[��8@�Y#֛��1��\nC:��{V�U)3f��C��Q�M,�<b�QJ9�9h���V�9�\$�6=!fH�y3�44��N��(n���٫p��C��� 6ĩH�*�o�R�jf�M�j!��=�xS\n�,���\\�	�~Gia���v�\n!&�%�Z�2��y�q�}�����Z;:�j]������0�(��gl[t@����u?X�{o��3R�@kU\0F\n�AO�(,���Vp��cH��i�N%TV�pBjJO�ٵ���\0U\n �@��x �&\\,��x?d��bx\\Oᆨ)A�S�h����9Bؠ�M��Yvdv����䊭`�#��||\\� �xG��<2�\\�A�n>��3Q�3���X��Ѥ�^��%��t^%��N;;�2�FOx��1�Dΐ��m%�ڊe�Kuv-9<`�\\BzRMh\\K�TA�#�\$���\n �Aݾ�1�[��\r��A���}�bs�j9���h`\n.\na�=3�G,�C>\na���j\\��(R*FO���Xѭ�݅��JK!���ݧ\"����چ?km�p�DsJ�k�lg�S%(��<���Pk�>��rw��&�Jd�گ�nAb�9O��\nĠQH������R�S�2\r@�\\c����<Ih�%\$�� T!\$.��J�z��J\n`n� )�e�F��x������cY!������)=��=�x^b���*��DT{���1ʣ2����. �����J���FW\"d�?��;��A,u4�B!�5�&v˭��kx綸�whzd\"/����Ң���q�F>O�'�%I��:L�BI��*��iqA���%�]�Ǵ��19.0d|Td3��1AR�=��p�4!At�4����H)�\0�T*��O8(n|�B�d�{�:�JB���\r2�?�F5�������a���&�a�r���N�-�撚�����>�a���;���'��L`��;ri��dK��.z�b�-�lH������(d������:�|?�ǆD��R�����B*-�ڪ�Ȃ�%m��m�(,Fd\0@�Ţ\$��ğ\0O��̜t���e��H�BB��O�>#�Xt��\n'Pʏ���	��g���d`��q0�O�N,�Kj.w���P��++n�d�������M/�)nb�8ݯr8��\"��<��f�\"y�\r�]��\0���(��41�8E-!�����HB�#	�>/�P�/\\/e�0o\\��f�d�d*�e�:�n����?�|�NܐF�d��L���+��(>��fg2���j<����B&�\r��\0���#����dB���̄Lh��*@&0���\r��q]��{�]Al��sc!�� ��\"aW������R.��3\0�6O2:��o#�1�!\$�D_b&rN���K�P9c�`\$�]��&\"���]�1!\r##Hrvb!5'��(�(pj���ܲ��p+'p!2 02�*�L��GrdJ���˯�O\r��҄p��-b�#�w��k�_)��k��\$�w��lLPF�!\"��'��r����-�i1:K��\$�13 k��q��'��쌔eL�>p��mG}������RƲar{�\\�O~r��d�15��٢&��2��D�낐;�2�G�\r�V�`�`�CTtg�x}\0�����Uf��\r��RjȀ �\n���pBh�;���v�B��pHmb:c�\$o����a��dP	��; �aNzq\$����O(��t@E\$�L{B��!K0\"�Bf	�޼Ŵ�#r8/C��=��%*���-��!�/�Xj�/,�rxg-��+P,�w(�`0C	\"mJ0GT�	�\0�cH �B�f4CH�`�Y�0�QM��B�G��;��(��_bl���H��&p&�lq��Bl��B��kPqG���\$(WES�@�S ���y�Q3g��DP8�l��:OL�n��y4\"��0����`F,�G�Hsf\r���V7s:M�d4�Odp&\$d �	\0t	��@�\n`";break;case"bg":$e="�P�\r�E�@4�!Awh�Z(&��~\n��fa��N�`���D��4���\"�]4\r;Ae2��a�������.a���rp��@ד�|.W.X4��FP�����\$�hR�s���}@�Зp�Д�B�4�sE�΢7f�&E�,��i�X\nFC1��l7c��MEo)_G����_<�Gӭ}���,k놊qPX�}F�+9���7i��Z贚i�Q��_a���Z��*�n^���S��9���Y�V��~�]�X\\R�6���}�j�}	�l�4�v��=��3	�\0�@D|�¤���[�����^]#�s.�3d\0*��X�7��p@2�C��9(� �9�#�2�pA��tcƣ�n9G�8�:�p�4��3����Jn��<���(�5\n��Kz\0��+��+0�KX��e�>I�J���L�H��/sP�9����K�<h�T �<p(�h���.J*��p�!��S4�&�\n��<�����J��6�#tP�x�Dc�::��WY#�W��p�5`�:F#��H�4\r�p0�;�c X��9�0z\r��8a�^��H\\0��LPEc8_\"����iڡxD��lWU#4V6�r@��|��.Jb�BN���]0�Pl�8���M�'��l�<��8�ݴ�N�<���+Œد�z��B��9\r�HΏ�\"�-(�������J�䧍�_N��ݝK(B>H;h���L��|A�M\\��Ԑ�1�\n���IbU�9%��\r�M�݆���ڊ��#���|ՌL\"��\$ۛ\0��S�H�m��4�G��:ں|̙MS�\"��#�����D�)��+���� r�>�)��I��-�+�e�N���☢&!��Ɣ�L���2���LvT����P���Kb����Ƚ�y��=q��-�,�*%�����s��M|�eJ�v.�͹�C&��:1�	�\$��!�8�,��9:<	eB�SZL��HBϞ>����RlD�������'�\0��ۉ\n.(i�7��V#(lƘ��VNI\n\$�T�&�rO�>Ќ��%6�V�^�-9C�c����F��2FV�p	P ���\n�F/1%0Dǋ��:��+)ȳ4\\;�/�H�-#\r,D*3��hV!�b�`��X!�/�D���h�k�%�5���)%*	�;�uB_hn����Pv����hZI=Àj\"9z �(����@aD(��\$\0�U��U\n�9-pƒR8dUkd-����\n�\\��t�uֻf��K�z*�t2�ӹ����*�(�@IN��9�Q��E5#II�B*quAIpJ��l�ܞO�	&T|U\$D�\rA���䑳'��nM弸�\\ˡu.ɦ�׊�\r��!�T��W��A�X�S��>H&�SE��	(�2��5ᡛ}��E)Ïh�p3������4����R�^��S��\\��pЍ��I �d���4�f���уfH�\09�Ut�0u��7�uS]Ph-#\n�ܛA�x��aÀ\r�7���Y�zPԼ&�U��ЫGx�EР��Rv��9�R�An%�T�<�(�\ni%U9௬�oZ�4�`Ҍ�=Z\n�\"�@�VvD��%���㽮Pe��[R�,�Q1�o����P���kE]�e/�n9h-%��0w\r�1�%P�\rxF�\0001��K�F?e\$���i<�-�O�q������P\r���;gm7�E��\\[Ҹ��\rJ�(�\"��<0�)�c��N����i.�Q�D�*��t�`+20�,���o��������R�,o����A�ei^��\0�C���a<��'��9+Q����Y�4�_�D��G ��2W�Ԧ�G�\$�t�Mot������	�t-d��d��-�҅v#��� !��&m���b�J�8�x�_\"?j͛�I���<~�\n��>�����jee�ӽ��(��T)�ةأ��j�@OJ�����r'	���N��<�0��;��VuaTފ�os@r���iaM��@X\$��bp�Jge/#��D�9�T���cުn��)v��uᏏ�8�Bo��<�Ԏɣ�q���S6k�����7I,R��Rx��)?\r :�|k%�{si\$��M'D�9GhH�Kx�eb��rҺ��P��#��֘��qЁ�<�<�Ɔߌ;��C�1!�*CG���2g�`ʞ��ր�ݖɣX�l��ub��O7uz�^~>�X�'��'.L�����׿�>ڤ���o�wq�w*ȣr�D�S���_)�ݰ���D��oA|LO�k�c�r�Mv�)^q �;��ȑ��Lo:�RN{�;�N�xv��T4�}�HB�T!\$\0�Q@iU�n]�ެ�*�V��5�2Pa��\ra�i�^0hÌ��Ez��>,�\0������IH'\"�Z�p,�ʼ+�:�0\"K��Ǥ,�l<��a�6G`/D+�@,<� 9��7��!m���Z�*(���p'0��J��\0N��\$�g�L�ː�	�J6%�ĵ���fN튫bj�C�-rQ(���Ѕ�����-Pg�R�,�.!</\rl%�pO��gI\\-\"G��	а%�[��N��o�3� ��؅\0z�VH��bq0������2;M�3����߯�R�6���Χ6@Bj���B��M��\n��T�d�B���k����J�OT��1.���,�P+�n|.fڎ<��:�Mq�ҧ�ut=1��?��*�l�������#���.'@���y�f�J��Ǉ�m�nE��������P�����Tz\"�d�rТr'[\$�����\$��Nn3r �p���1���\n?!�7B��,i&�0jj�+��`+�(�`2J\$�q�䦛���9B�*��*�J�q�����00g�������Ș�h� *��2���+1Ω�x��}�v�Bp3�0�2�/�9-\"�@�����et?0�&pC,��%1,1ke�m2\n�c�&�0�>�3 �b��ʷ��+c�R�ޓe��,�v���E	7q�/���R*2��f�)&�&�NlO>B��'�q&2�c|���:�Zu�@s�l�R�Z�P���͖�?(�j�3�x��3���=P���xϳ��r�8B�8� vq����B&r��e �O.�op�M�\$g��R��O�1�6��ks\0�P��_Cs<8�o+����CS��e�gI�.�1�B�D8��\"�jƨ�7��4P�fq��w����C��'���ԏGȏ7ӑ.�ܗOJ|B�����+P�Ӓ��yE��J�mb�3&�:arS0C��S�-��6J�;d����SHoSM8�TO5�1�O�a7��2y�\0�s#O��J�_L3�P�V��04�0m��[\r��KL����2E ��aLH7S�Rq5CUT�\rSGP�Q\$��*o�+h*r�����E��A�qE/gW�QTKS3�Dd���D��J�-.�A��e����wVnV�d�Y�'�Lv5UL��֏ʩ�9XSl���a��P��QAIQ+Y�>ŕ��tx�-]թ d#�J��.!G�T��#�������m����7�T�p@t��G<\$�G\n4;2V�s@�	c�Ap.&��l?��	1rl��ޖT��f���	S[d0�%�s-1�����3F�(�����b�:bb��l�(rrD +h��)^�I��.\"�\n3<��/J�株\n���p��^�Bna�3-_T)h&��o����v�\n����bx�Z���kJ)�H{X}�\r@��TM��t��,8)rd6�5,6?���r&!粐BtWD�7H�ET�SF\\����#�K�K��\\��8��^@�w�c%��% �gF?)(ԣ�ux��	o\"�2qo�HF���7�d׹H-ꆌ�.7��H���|�V>q)qq�{@�7�'W�PvY}N��W�'Ɗz�l�y7�@�>�SG-��t�#�β�<h9}��D�\$��2�g2������g�CF�j�r�K�rP�_rX�5pb����\$��(1lA��%����vm��4	{�'cAĞ%�ex�����`4�S0�a|�[�m\"�0���v��x�0��~O\r��E\0�f�11��!%N��J�\\�}Q�H|�R8�";break;case"bn":$e="�S)\nt]\0_� 	XD)L��@�4l5���BQp�� 9��\n��\0��,��h�SE�0�b�a%�. �H�\0��.b��2n��D�e*�D��M���,OJÐ��v����х\$:IK��g5U4�L�	Nd!u>�&������a\\�@'Jx��S���4�P�D�����z�.S��E<�OS���kb�O�af�hb�\0�B���r��)����Q��W��E�{K��PP~�9\\��l*�_W	��7��ɼ� 4N�Q�� 8�'cI��g2��O9��d0�<�CA��:#ܺ�%3��5�!n�nJ�mk����,q���@ᭋ�(n+L�9�x���k�I��2�L\0I��#Vܦ�#`�������B��4��:�� �,X���2����,(_)��7*�\n�p���p@2�C��9.�#�\0�ˋ�7�ct��.A�>����7cH�B@����G�CwF0;IF���~�#�5@��RS�z+	,��;1�O#(��w0��cG�l-�ъ����v���MYL/q���)jب�hmb0�\n�P��z��-����L��ѥ*�Sђ\n^S[�̐ ��l�6 ����x�>Ä�{�#��вh@0�/�0�o �4�����a��7��`@`�@�2���D4���9�Ax^;�p�v���3��(���&9�xD��l��I�4�6�40��}D�w)c���8�\"��ej}�PF�5�S4�|��4��/�_B�V���@�����U3��+ڳp�Aw%9Z�� +�#��&�J2!�˵�<#T�z��@�ˣs�O3�R{{F�r�Q��]�PM����.� �\n��B&80��e�;#`�2��V�����P�-�:'�sh;�k��?�U����&��6�R���/��\\N*�C�V����UW�]���},���@�mܐ1��h�U�}�+^��3�\r��=�\0�CrI\n!0�\$����lG�\0ћ4N��S݀B�\n>L�*�C�|�7R�� *#9�U��cwv��UFu�nu��D� :\\�%�-5�[�F-j6?�PQ\"Ynf���p�y�,-I̔�6��,j�\nا����|�L�Ģe�,Y-�(\"'�F#c�D�=� wN��<��3`ػ�J� �S,(�y�h��<�\0���`���\0��:LlX:)JC8aI��]�e����������<Q��!�0����5������1+jk��������hSI�=P�n��3���b���xS1�hA�S0�d�M�X1�u\n�<m���B��+'e,��2����/^I�:4ft��EI�!�(�[���6������qk�ܠ�So=;�sl���5iJ3T��~��5lI�&��K�����Ǚ\"d���vT�rl̽��5��*�gL�\$���{�k2��'`A\\Xk�>��0����Âl�uʓw�<�E ��A���UA)sj\"S\$�l��h<����p@��dG���)�\\\\�a�!|J��+ ���)�����f�\0a� �1�*�^(sQ'I���VTc�J�-u��xt�\0P	AOX�L�Tye �\\�or�\0(.@��Nd��&\\�ɘ����c��\n����{Oxer�9C�����!�;ߥg��t��-��DQ��M�\0�0@��W��MG���0X�Kf�@;���+�i�Z;ny �ua3ӥ@XQٚ��+-7OP,�-��G��\n��j\$�Q�X�6bJS]��Mb1��Q[�51� �\rev�f��;��[�DA\$�����CK�<�݄���O�/9�p̛�m\0��&��+�M����(�&�J���(�t0{EW+B�gJ�hQG��aPP�W�mO1EB�Y�z�Wv�H��diC�̎�fx���������V��n*N\r�\0�~�`�*]H0�Mn_r�?h@�pzb�A�H�ұa�dH�j��'\"�k�|��2F:�ޛ���{4_�*ad�e�&�:t%<������n�H�r�y\0���)8K�[.j#u�C�w�)��臚��r��Ň�s�Y�V��pV�nb2Nc���<���S���8��~�QM��8��[����&�Dj�v>�����4�3&=�+I�yT�������ɫ���r�e��x����Ңu�:N�Y>�+�v�t����o�^d���88������QZ�Jr-'�����k����9���\0-��1Η9�HiO\"�����e=���=��Ғ�L���\\	/�܁��ݱ�M��%.��Oܞ�����tn����)�S����L,�~nÖ׸���vQN��� C�Q�?X�/����:Ą�ņ��J��}�����\$!b���v�f��h�t���B�G��Y�)O���3ɨQo�N���X'��(��mPk �\n�� �	\0@�d�\r%�L_\0࿃��k��2�g\n)��(�Cr�^6r\n�~r���>lϲvBb���F���k��ʂ���P�YHW����0��	�H(=���0`��g���(��:��{���`�I���ʮ~�P���\$Wn�P�֥`��p\"N\0/#و90���@��D������o�Β(��h6��3L�pN�#�.��1[F��c�f����o�k ��&��BJ��-���,/<��[Ѷn��&N��H��� T+	� ~+�jX��(�Y�����(D�g&�d��q��F�/NF�D��*��1L�i�p�E\\�`݆�2ll-��5N��P:��:l�\"��ɯ08��Q�\$b&����̕�NVY�r���1.o����Q����p��v���6�������jQ�npn^�Qz0�����i��vk��N�JNU(�*2�#���V�����mr�*R�(��2\0p�H�-��.2�.lx�q>tPJQ�����V�.}�M��N�5.����'h�׮�ȾZ&Q�)3�LV1ER�GL�\\�i�����ҷ.�c.�f{�A0���Srpw�V��\\ߠ@\n심��)Y�o6�B���3R-�e0�����e�6u'q4t,�B�<3�3�<ȵ0���>�>GGS�6�'7ң*�?R��7+S��.�T�����0=з9�js��\r�r����C>V7��<#\r4&�#uB�9��Cp)C��R�\r\r(�;r��s�@�WGb��/���y��@s�B�H��CZ�p_�SH��<e}H�~7!E�fQ��-Ҟt\nZ��k�u?�@���BF�o�ZLE��T��4�n߲��K�Ah��t���Lt��1�\n*\"f����4n�<�.;>8�ڲ�r��>!��H�}\$��P�m�2���j�~oNf�dy+/S9e�+��������T�D#�=�K����{;��;�AJuY��sQ4�Z@��Zs�KioQ��-2Y�MET��B��`s5��.X�����\\3)[�G^U�]P�Ru�^,�~��k�]��G��L�D��c4tkSn�{�6|���\"-�L .�Y��T-V��F�B�N��D�HHU�G5�Gp95&�&�X��KU���kAf�J��gu�(��8��f�.Ԛ��bd*%�d�g/ Pa���U��6+j\"1j��\r:�ag�n���NBZ��� \rd�5�;��]{n�?n�Gk�kU�fV�K��Q�\0VZ�p��q�\0001-`7�T����wm5�����-`������ďr��AU�ovyft���p6�7��_Wa_�;��hVq��o��5%A2DƵ!P�`�,�)�\nt]S�:5n�*eC.�F��)G^�x7s�-51��oL1)�{B1{�w�HW�R*,�ug�Y�E�S*��{��m��|��*��+\"	|��C��h��@����m\r �\rd�MFx��?iD\r��\r ̔�.���\0��E���v\n���Z�BI��|u\r\n�/Fb\"0(�w�h�!<B��	%C�z��4i�����A_~.~������t|A�0(��Sd	�A�@�cf��65r�\0���\$�8Vn�o�.0U�ߍl��L\"��ɐ��dq��`��� g�6`�\0Yeg�LɀL��P�5B6�o��A6��Bѱ �xR���JC�D��~0��%����[���x������j�S�l��×M�7v]u�ۊw\"���>C�<lZ�dO�ࣥ�����QT�!Ւl���S-g� �%��1�M���V����]B��V2��n�3�ue.i�#e�W,V@�_�����C�3�W\$�ּQ��-�[4�y��{�PB)⍕3�-�e`�^����Y-u3�JU���K�N�]�a��k��\r����?V7d'`0o�VT8{�Eb�<�ځ��	\0t	��@�\n`";break;case"bs":$e="D0�\r����e��L�S���?	E�34S6MƨA��t7��p�tp@u9���x�N0���V\"d7����dp���؈�L�A�H�a)̅.�RL��	�p7���L�X\nFC1��l7AG���n7���(U�l�����b��eēѴ�>4����)�y��FY��\n,�΢A�f �-�����e3�Nw�|��H�\r�]�ŧ��43�X�ݣw��A!�D��6e�o7�Y>9���q�\$���iM�pV�tb�q\$�٤�\n%���LIT�k���)�乪\r��ӄ\nh@����n�@�D2�8�9�#|&�\n�������:����#�`&>n���!���2��`�(�R6���f9>��(c[Z4��br����܀�\n@�\$��,\n�hԣ4cS=�##�J8��4	\n\n:�\n��:�1�P��6����0�h@�4�L��&O��`@ #C&3��:����x�K������r�3��p^8P4�2��\r����˘ڏ£px�!�=/��	&��(��	�_;1��5��`�6:4���3��%�i.��l���p�� ���\$��\n���\"2b:!-�y\rK��{�wk!\r�*\r#�z�\r��x ��\0Zѭ�J��0�:��c-��%z�B0���l;�'�	�4�Xl�f0����5�8ɖ\nq�H�+�H�\rC�j��j1Ƣ �c���4�Z^K-\"�[&�h�4�6�\r;�׭:.(����#ː��	L���%��j�C�7`/�N㹸�H�6��5ejo��g�����'I\"\"r��B�v=<��r��+c���6~�&q�\"!CMx�d�x̳wR7��2�%�~o-ʃ{[Y���O	��|�3c���t4g�f\n��w�A/�(P9�)p�2��;��b��#l�x\\J*˶�O�r������%ªR2�*7���3��տbN��8 K�|��`ƅ���L* �(��Ԋ�R�\\;��6��rT\n���腕H>����urK���\$<�D�	2)\rdeC%��A�+�\\d���A�\n�j	B����}pQE1X.���R�aM@��anT(D�!HP���>	-pӰ����5h�48�X��z�M������	pM.d}٪�MS�q���6�\"6��&�N~��l\r�ī���c�a�!3�h��\$�,�M=�\"�@s&03&wXHi.�̗��N�5	̘���d`�#A�4>���4�1d�F�pCB�X1�D�H\rt4��ԯ�\rY�L��M���{�X����&O\$�T�L⚸h��ԕ�7h�,M��1���|��rՋ��\\�\\[~?d�Y��(��a^(u19�zs�b�eO�A4BoN��A���P�f�8i^�6'�ܼ\r��2a�:�����!�jq0�#�-Iby��R�.d�	� �@'�0����,�q\0�W�W\"xI���bfMi� Ds�g��1\n!��Z�آ�\r%3%��R��tfp\$)�G�i�A� !*M�qZ�sM���Ԙ��ٹe����HS-�؍�FVtxNT(@�( ����ɚ�Kdl0��lA\0D�0\"ۋuor1�h\n�\\b`�#�`!��9˰�AmFE�4����xpjgA�4\n���XhœC@@C:��gY__t��a�1/|�9�X�]`t�\\!�4���uG��O�<���-���L7���5\nqBY��ӄ�e�П�E���]�݄����U��ͅ	�4V	)��b@�B\n�o�6��������X�F�xQЛMq칒�ы��=�\"�B�]���4��;�5�e2��#'����� jz�v�1�4��7��n���q3F ���ێ���1:=� G�TJ�����JM�!VD|&�/*�7l�_2<�Iz��h���nC	\0��+���ZgM6jx4W�(J�'5��g�`^y�2��i��-��	����G�C'R1�����8����v���c�T����^�;�F���;wPnC���@���/��<��p��E���	\$7��dp�=d�g8&��'��]�Ƕ���l���5�yB|�D#or����分���Pa�a�브Z��T�HO*���BI��F)���sug��I#�Sd�ie\\�(b�����J:?\\Y�j��e~]-���NF��U�z�J�w=���A�>Ih:\\r�|�I����'c=�a�zȟ�/��'�'�Ysu�W�'/C\r��a2���T����y���}_��^��벷��+z���k��,�\$2���^S�#�g!��Vұ��k��7耠���'��9֏�\$aY1�!�a��4���  �24��O�4kEX&�y_�?\0������-��H��_�*II ��0m�E\0�H�O\"��\ng ��K�'N\0�@���~�M����\r��L��2�����L���0E�M��\\�L�\r\n�L`�F�'����E�(p���pz���P��2m��:�J'��`!ZJ�6fc蟢@�#�T��B�� 0�q��Ϻh� ��.b��Ԑb\nSI�V�@\$nH��̟ ��m�2�0� 0�GqgR��+�\r\0�Y�r�����'�.Z�&���d�Oj��\rRf&v8�#0AmW��	e����Ќ�LQXՇ9}c~g+No#�J�.2� N����@@W�r1�԰4����\\��M�6����uQxZ��d�Y��8���(Y�D~�{&�q�0ū����2�dF#�Em�0��� ���}�\n���c�+!�2pQ�Z�- ���LD�%�z>/NֱA!\"]\$�i%5!�%ą\$��	�C\n\0���.�.�R���\"s����ۭ!�\0ڒ���\"\$�a�`����/0Yb�a��iF�� Yd�4%�1Ff7�9��q'r�\\��-�nPr�m�-\r!��'h�df\r�V�rjӏ����1 9��%����%�0\n\n���Z��<n:�2拂��@��(�J`|O+4C+*�?\0g�E�3j�uF>o�@�E��B|��+#���12X �ө0�3e��*�+#�/\\�f�\0�=,@I�j\n��Kdqp�-gܮ��d`�F�c-H�L�.	�sŎ�I�=W=P\0\r�hgp�3�F:sA=�OL¯G=0T\r��>�\ro�@s�%�1*0e��i6�Vpv�k����k��ƚ(���B0\r��q�C\rK�j� ��@��H�T�'���}��#�@g1P��<-� 2k�8M�\0�!l4nӪJ�dӄ1K�?�9 ��� �JO��\0�0���O�D�,/�\n";break;case"ca":$e="E9�j���e3�NC�P�\\33A�D�i��s9�LF�(��d5M�C	�@e6Ɠ���r����d�`g�I�hp��L�9��Q*�K��5L� ��S,�W-��\r��<�e4�&\"�P�b2��a��r\n1e��y��g4��&�Q:�h4�\rC�� �M���Xa����+�����\\>R��LK&��v������3��é�pt��0Y\$l�1\"P� ���d��\$�Ě`o9>U��^y�==��\n)�n�+Oo���M|���*��u���Nr9]x�&�����:��*!���p�\r#{\$��h�����h��nx8���	�c��C\"� P�2�(�2�F2�\"�^���*�8�9��@!��x��� !H�Ꞝ(�Ȓ7\r#Қ1h2���e��-�2�V��#s�:BțL�4r�+c�ڢÔ�0�c�7��y\r�#��`��N�\\�9����h42�0z\r��8a�^��\\�͉x\\���{��]9�xD���jꎯ#2�=�px�!�c#���O�&��0@6�^:�c��Y�rV���\\��}�*�	�Ų�*QL�P��ʓ�2��\0�<�\0M�{_��6�j�\n�H��qjG!Jc(�\$h��:=�1��(�0�S�콎�,�b��s #\$Y+%4����0��^I�� ��8�7�#`�7�}`�2��7(�p�a����&A�ŭz��KqM64�e�@��3\n7Z����&.��E(�7�,�H<y'BPͲ4�rŢ9�� !���D��Ҁp)��n�����B�Zס�&��� \"��=��5�s����YB �3�0\r�xѴ�*:7��4E38\n�L֫ *\r��}\$�	�<�c3g���%HE��<3�+ˌ�_sf&2��R��[�b��#{��pA�VBh�5�*NU�يE9�0ܙ��bxg�2�g�`ϑWD���@��(rR��bL���R�eM��>�C��Me�S*�T�z9/J� }���W���4�F��+��4�\$6���{�U+� Z��iz&!5#��L�H¯^�&\"G�T�\"S\niN)�@��\$,&�U��FPr�V�P8� !�>?��(u��	�a}G9\0���:/`�����BL�'B���~��<@A�����\r!�%!���h&P��a�Y9�0����{����GJ!B3qy3�vs\"�<n;Iq/�fL!�q�p��\$&�\0P	@���� D���E���B���l�[�6�z�\"\n\n�oN��7�y؄%�nJ��w���(��`�ݴOh�jz{��\\�!Ur�P�\0001��j]���72�ͱ���9�Ql�?�⅛A:�6��\nEd� a�=3�B�LBI&�o/T▚D��Q��T~il�T0�6~ݍ��U���\$�l��O\naP�%��O��4e����)��K\nϪ��=��[�1�Qj��?K�q+!1+&*n���cy��7�����ime!���@���L�Ԟ�)	Q�BZF��\$3%��eB�������O	��*�\0�B�El��\"P�m�;)�e�d�-j�(92���!\$�p�6P�ʐ�A� ꒓�vNr�w)�ڬ�xM�<&���P����%��Cx)\neNw��V�\n�s�(k\ru�fL�oM�C.��^%���\"\\<�4�E�PVE\r�\nH��/���G��z�AS ���5\n�	��\r��чqMf�a�\$KKi��^\n�rf\0��6��bNY�x�<�R+K�;����7�����!����#� �3.�2�+ -2�7#!t��i\$Fϒ�>��\ruc��9]�ls����؏�����ab�1�{Dv��7d��\r�����b�������0\$Qy�![\0�BH����'u<S�@�{����_]��lt�/�^j�v&�2����v&�n���������.�ВGu ���&�}��@\\R!�ׅv�q��c���Cc���AU�n�	�{Id��YA;��Y��7���s�����N��ۉڛ.���őܪl��L��%?!��D�9W)D��N=>�)�XjG6�Q3��*���#rn��1I+(�4p�g�bs�Y~V�Jֈ���9���0�B�N�nb>��>������F\"�^`�s-P��4;�|�=%Z��_\nD�Y��Ž�;H��tL�/����&z�یֲ<}�se�@f��`0��,��a/�������B�b�#	3���[��Z��\"�TH`F6J�;Dɠr\$ە\$�]c��=n�����oҗT3�/��۽k2l��4�G�5��|�C?O��:�@R�{�p�>k\0:��~�c�ȣ�?�\\}W�_\"]�_�꿋y��oy9�O�p�\$�\"�6� M0/M�ݧd#��\\��/�a�\$�����`@�\$0��\$Co����g ��8�Ȍ�O��'��0Uo3�O�	�\"g�L�\0.�b>�J\"�L>2f�%%x9C�`��R\rt��ZF��DzZG�//��\$:��� �*%㴟i��x�DF��!�����0��>q'Hd�5�����l]\nPVې r�\$��k�K1��d�����t��[̬�1�E�Ӎ����q0�j��q.���o�	�p�D�L�ô�l�0�˚�.|�ִ��E�K���i�N�pX�q1��?ь�q\0nbhzNPkqF�\"����1���!���1�t���Ѱ]�	�6EȒү��(��c�P?��Ы;qA�����1�GMBp���\0�F�8s�Mq{�~H\"�Q��p	�,Ԓ�Ď����ьEPRM\n�gg��\$6Z��_q�)�9K��N�ŲT?\$�#/\rfL�.�b�H/��&1��e��F��#%(��:&/d �d^\r�V�ĪO�c�L����)�0&�~NIH�`�\n���p@G�1���k*s�e��(�^8�8N����C\nps��?�d���*��o����Pe�r��=C�D@�=���p�2s+�\"\$�¨�</q�jV��6�@���;�1f'���I�g1�H\r��n��\n0�\\�d\\��(�^����8ly8��xh�9cy9�C�ؾƾ1O��c| �5\n4}i�=�l��`��C�_�f(���3�;L��bdj/�j�;��>��ji��2�\0U�g��!FD�,z�M�`+�<��M\"�2���\"_���  9��9]+�v����8�A9D��3�.�8��7�C��M-DV��G�LM\0�	\0t	��@�\n`";break;case"cs":$e="O8�'c!�~\n��fa�N2�\r�C2i6�Q��h90�'Hi��b7����i��i6ȍ���A;͆Y��@v2�\r&�y�Hs�JGQ�8%9��e:L�:e2���Zt�@\nFC1��l7AP��4T�ت�;j\nb�dWeH��a1M��̬���N���e���^/J��-{�J�p�lP���D��le2b��c��u:F���\r��bʻ�P��77��LDn�[?j1F��7�����I61T7r���{�F�E3i����Ǔ^0�b�b���p@c4{�2�ф֊�â�9��C�����<@Cp���Ҡ�����:4���2�F!��c`��h�6���0���#h�CJz94�P�2��l.9\r0�<��R6�c(�N{��@C`\$��5��\n��4;��ގp�%�.��8K�D�'���2\r�����C\"\$��ɻ.V�c�@5��f��!\0��D��\0xߤ(��C@�:�t��D3��%#8^1�ax�c�R2��ɬ6F�2R�i�x�!�V+4�CDb���<� 襍mz�\nx�6��sz�L\rE�m[�+zٰCXꇵo\n\$�?�`�9]�r��P�5�M�}_���|�W�蹼h��8�*Y P�����L�B`�	#p�9���Ŋ�z�[I����z��YLX�:��\\7���\0��C�E�CCX�2���\$��+#2�-6	��\"\"H�A�@��K���_0�Կ0Lf)�\"d�L����e�(�?�l���vݺ�ك�ܶ��H�+�:'2�4p���H���-�HB���Ȓ6�lX�<s�?���+jre@P�d�oD&�J3<3��2�bx�7LL�����\r�hЍ\"WP湄d�0�\r5\"=y�Sb>�Z����76\r�ᦾ2}��[��z�/�z���죞ߺ;{��č���|���<���uy�趴��\nq��=�4����_/���\"���4�����@R��;��v��\nW��6�&.�k�w��A\"n��Lh;.eQ+j���=�~D���b��9�4�T��Q��K��6�T��Tj�+*�䪕`/���@��>M�\\9�H�*�X�t�2br��ULq�����T�LTΑ�~QI�(��(BZQ�j\"4D��(�Bu\$2pDP�-)X����T\n�;�EL��4hU�e�0ܭU��������B�L�\"`�7�`�\$QBN�s��=����S~�����*I[[Wf�������]GSHv��(�p=7�M#��j�I�E\"#�q�������҅��^���R-�|>�m5#a|^�z8	蔜hD~\0P	@P�+h|�@�D�D�R�������F(g�̚y�+�C���t���=.�l֞r.��:��w�b &�PK��#�h:)�SH�E<�Rx��G� D�!����\"�8����8L�UDN0��W9�N��,N�� �\$(�rR������=R�6��\n*\"(OpEUNT�P���g.�_�s(^����^9@0g�(�*Y�L�8 ���^儑�,���Qpf\r!�:�1=�K Z��d�3PC[&\r���NU����H(�E_�ho��*RC~L��\$������XC\r!��k\\�]�f��#���[ѥ4�a/���w	�n\"�f��nD�y�~�ڠ�j�0�\$g��5�;'lV��V١&\$�������q��P��B�|����v�Cᨔ�[�QU�d�;L\\Ʌ=��\"%�Ts�C�:.�*��s�r0�K�\r����V�p<e���d�}J�:�U�R*II�e)eECOAB�Ji�\r��>��^'���Ш�%�(E�:�#I�1a=W<��{�%��%��~��|}��2.6~��#c�<bu���\"6ֈ�-E��PC} (-8���IͿ���\nӈ��\0g�+샎��^�I����FD�q�d�ey�: ��d�������Ȣ����ˣ7�D�%��#.=vt*@��AW�䚍��w86	�`�\"5������/+��#�0��̳l��r ��E�m�> ���r�]JGV��`��-�x6���9]�弾\"�M��Xl�<�n�U�3�G��D*��r٘�&����;F%΄Q�+�oP���`[B�h��S�una�bC�_�ɷL��˺Ww�]븧���;�C�]�fur*t�QN����BG�;*��)u��0H�d��d��T*�j��F؄q2�u�U.�r�s�;�RQ��G�I��)�*�\n�M?����~~Y�C/���}~F&Ja����{�'ԍ���SrH����^������)��M����~�~�T��-��T?q?7��h�h���z ��%���b�.�4���ȭ�@�JR�L2A�]Fi�7�\n�fJd��fV���Fm@Zl�7�� �[@�4�����'g*��x�gl6\"pj\r��	Xe�f�b��.j�n�4��b�B���a��\0P�lD?�R!�(�쬾���Ls/�D����\0�dO���ƫp�u� �b=\rP�\r�D{��-� bt=\0�̃P����A���ź[�r�x����P� PD�#��0\rΜ�GT玥��#k\0^�@��CJ�8�N��+�������0\0�J�1bّf8�m1u\r��j���'����ަ/E*#1����WhjfT&!Z(��K�P�ڄpF\"#��}1����9���l��\nR�l�Ex\r�hE-�<�v'��T+/��Q�K����l�<g p͊���1�a�\\Ց�g�m�s2/\"��\r�GD�e��e�\n�����24�\n0�R#)1\00012�RPޒg\r����[.n�rb޲Fq@@��ң�8����&wf	d\0�p<\\lv�\r<eC�e��1#Qo�_+�C���A�\$������H��j9��-��K�]m�\$����/2����Z�2����b\$��\$��[#��1Oe��1��1q-JS-�p/͢�R�ˍ�2��C�X�Rp7D�Ԋ�1�,rI��5R+3^\n�RJ1m3�?�>��,Q\0\\d2#��'T=\nڭ��*�����3��3���=s\0J�9\"5:�G9�Z�3��bV	b2�#�_��\rfB9�23�z#���p_�F.}:s�ḥn�FS��45s��������Z`�c�(f�����h(�\"Z�����Cd'��*o�i�dϾPa�h��&T\n���Z\n�����>��@/F`�6/Cs�@�@Exs�h�1YG�^\"�\"�.#)u�c!�]r\\�HB�? ab��\$#�/Č{k�e�F8\r�\r(�\0NWK��3O>\$lT�������|L�ִ��\"DB5rb��Er����`���ɉ\n4��\"V����.���`|�GR-!Qq0(��&��G�5QU)+�6�GRp�z ����(O�TURt&g�fg�XYd�9-8��A�P4\$p8(\"�%f���'%p�\n�t�Ѱ���1Y���\"�2\"U��F2#ΕV#�K�Zbu\\,��`r���^�#�#J��RuloR�dؕ=T��b\"v#��\n1�r�DT�K'�� ";break;case"da":$e="E9�Q��k5�NC�P�\\33AAD����eA�\"���o0�#cI�\\\n&�Mpci�� :IM���Js:0�#���s�B�S�\nNF��M�,��8�P�FY8�0��cA��n8����h(�r4��&�	�I7�S	�|l�I�FS%�o7l51�r������(�6�n7���13�/�)��@a:0��\n��]���t��e�����8��g:`�	���h���B\r�g�Л����)�0�3��h\n!��pQT�k7���WX�'\"Sω�z�O��x�����Ԝ�:'���	�s�91�\0��6���	�zkK[	5� �\0\r P�<�(�������K`�7\"czD���#@��* �px��2(��У�TX ��j֡�x��<-掎\r�>1�rZ���f1F���4��@�:�#@8F����\0y3\r	���CC.8a�^���\\��Ȼγ��z������\r�:0���\"����^0��8��\r����B������:�A�C4���4���W�-J}-`��B��9\r�X�9�� @1W�(�Vbkd	cz>�@b��8@v������ ̐Z�1��\"�0�:��춎�>ST P���cK��6��w�+�)�N��;,���'�p���bD��p���\n�jp64c:D	��6X���e��|�c%\n\"`Z5���[���X�V�����yl�W09�,�'�����0N�.鍆�(-��/�H�(�P�\"�{#\r�2��ݢƑ��!T�xx���ϴ�x�3e�N&8��*\r�\\z<����*J�5�H+X�6�`�3�+[���T�2��R���8�--�)�B0Z��*XZ5�3�YT�����\n#�c�:\$���%m�ΎJ���@�Sh�� �7���:Nä�=O��#�c�C�+e07Q����X��8�J��|� <6@.��v�ڢP��9�G\$d�rRT�7E��5\"����ɹ8''����{O��?�W��\"�~�����ps͈���߰>)�,�2D�	�R�|Іrt���R�J����*PJM0��\0��[ �Hμ�4��x K�e������N(���)i}0���	]m����9p1p2+2DO��.o�8״N	ї3`�(��\\4�'�\0����\n_�0\$�S (U\0PC?�\\1��X�;])%�e6�ܩ�i�5g��:�T���G��@���^*\$d�&`���L*L7ș�JkK(;����@ H�dЗh��y@�Ĩ��>�L�f'�0��0�(ri���;v�T'�@�����ʗ%b&NOC���a�����'9Kd|�GeN���y�@'�0���l��*}����J�6�/�Bf.�\n�vOdAK\r'�	�H�k�_��@�d��\$�����٨-\$�yY�`��#-��Ă�E&r\$*50#.��P��P0��B�HO	��*�\0�B�Ei��\"P�l\n-Z��z������EH�&Se�[N��4���)�`F\r��b��FrK��\rH����}NZ<�FM^���%I�H���J�[K�=���l@S\\\r�T9����~�A��Ő}'�/Gڮ�I-&\$(i��t�#p�\\�T�a����Wr�Y�Lt�����B�.5g@4��*��T�au�`�J\rx-��4�5j�p}�5F\0����M*9c��%�VFF�-�al�P�N�Q�����5�Z/9Q�x�`o�J<��������O^&�}u/�#�d����f�[cRGkX\0�BHF�\$��F(\\R�ᐣ�P�g��Ia�#�)�A\0/*�@����Q��1�ڲ�6''f�'��۝3ьL��Y�\"�\0N~b�A6PA�t>y��6\n]��\n)l�o�d�@M���:T�'�b>�	`�<\r]�&��D�%�t Xټ<K ��:G�\n�������Z�h(�ʴ�)�C(b���Y�˯Iٶ\$�x��\n\0�s1nTǸ5�Sm�Y\",�����LK���m�6�u|@nj���\"��,@Cxph�F�pR.}\nx�9��ߣY���y<X���Jҭ��g��\\^�MU�JD����ɖ�B��'`c�C,{eLA���L_y�=�>T��ڴA�\n��QǕ���x:-����Yĸ� R�,kVn<v�ۖ��d����ĥ�����ɴ�L�\\*J�7�]�P��-�3�H�ݓUh=3�s�Ӻ�\0���_��:���@|Xi��궜�X�x��6�ΰ*��<'~���/C�L�'ìX2�s�Mq8�|GW=����	ϧ=Un&״��WƔ�᧛�g!\r�K݆��q[�,��v�z{���3�y	��n.%I�+���\n��a�Ab�u�p�w�拏����n���LV���/b�@���V��ɉ6��P�����\"Of0�.�\0�|ć����#B\rDF�^l�<\r��d��\n�Ҏ&'p���A�p-+}\$��U� ��N�\$;���&��+�/�Z@pH6��	p�:�� bz�6U�����7� �g�������@�����4�8�\$\np��\0��L���D��)px\$����L����02F�40�|X\0�\r �1\$�n��m�@�K������Թ���mk�(G�Q\"e���e�� �L�W��я4�\rk�16���@\0�`�e\0��aJ�h��l�y�R�CL���z�L2����pv`��EŌ\$��iB���io(B��������M�EB#ڿdXĐ�&n�Az�#�ʏ�7�����%�o�/�Bd㖜I�n(�)8C��@g�9��'�0��຤6�\nvX�lYn�L��g\n��.9%	B�kt6�N��D�rd(RhjFp�&T2����\$�u(�T�j�\"b2+��2��e�a\n�\"2m��	�����D�&0%r�djڨr,\nBB��tĞ;��)�# �-�G# ��l~/d�'�R\\0�D���d���0�Z��/�V@�-j�c#�f\nBԞ�DA�A�";break;case"de":$e="S4����@s4��S��%��pQ �\n6L�Sp��o��'C)�@f2�\r�s)�0a����i��i6�M�dd�b�\$RCI���[0��cI�� ��S:�y7�a��t\$�t��C��f4����(�e���*,t\n%�M�b���e6[�@���r��d��Qfa�&7���n9�ԇCіg/���* )aRA`��m+G;�=DY��:�֎Q���K\n�c\n|j�']�C�������\\�<,�:�\r٨U;Iz�d���g#��7%�_,�a�a#�\\��\n�p�7\r�:�Cx�)��ިa�\r�r��N�02�Z�i��0��C\nT��m{���lP&)�Є��C�#��x�2����2�� ���6�h`츰�s���B��9�c�:H�9#@Q��3� T�,KC��9��� ��j�6#zZ@�X�8�v1�ij7��b��Һ;�C@��PÄ�,�C#Z-�3��:�t��L#S���C8^����J���\r�R�7�Rr:\r)\0x�!�/#��,�Q[� �������������3H�/��on��	�(�:2�F=B��Ѓ���C�H��������Ip#��G�/���0��˂�ZѺSRN���{&˄�b�\$\0P��\n�7��0�3�yS�:�eĭJ*�9�X�<ֺ�e�ssB\\�;n��fS���@:B�8�#�b���xD�2\r��������.�s\0�r\\�S�����)����6�d�#�ir��MKW!�#l�58OX�<p���,�����/� �dOX� �j���cx�3\r��f �Q�؍���t;+\\��^�c`��dƀ����!apA��0��<z:�N�\n������@�Rx��#`\\�H�j�!����w���7x>��y\n�7����z(��z����h{a��0�FP7�c����(���dA�2��e�,�x}�@!D&:�Z`!����厀�)��L�:\$ઓ�1Je<��d�qO\"uB��*�U)�V%\\F�{`B�\0�+P|w�Q�5��8V�t'�z�5ֵ,'Ġ7�r�`�{�0D��I��@�3�F4�M�i0*6<h�ڝS�R*`��Lʶ(�U^�H�\r��[�P�[أ�\rфCR\rЃ�H\n8���\\��0r',����@NY�3@'P���OI�\n (Ц��R\r�-�ŀ�\n�/D�*��\"�ijE�K{,�)!��vh�R�f�`��>���Z��]��3��:D&Q9�\0����!����N�I[���اC�/��3��a�Y�@N�#�����A �r4Qf���ja�n�Ghǧ�KhD���B,�P@^A\"Xtuᕈ+�|�Iv��>�����\r#��k��~ a�4�nQJ�� �P�5u�g�#�'\$����|P5AH��� @��ՐD��&�]L?~(]���RY�\n�q��sg\\U����tղB;\r�` %��oC�GZ�*+E(�.�&=&a@'�0�Y� rأ��L)R�SD�9I)hJ�\$��pm!߷��X�4��vk��:�`�\0k)���2\rmm!kV��M����P40����@��d��c�+�G�2[�D�#10�߃a�K���\\�p \n�@\"�pAB�0\"����`aG�\rJt�?��ͦ\$0�&��	ܞ�&��~��=�⏉�g��\$�\"�:�m-��u�s��9%�ˆ��n�XwY�&��(�XPA&u,:�����\r(Yg�5���*B\0�T�\"�EAm:t��+�#t�6*\$ Ӎ��!;����\r�T�\"�\0��N�\\�L1e�̤)	S��䞲ju3�3�h|���B�-�)��,��iˍ�o�Z����\nN�1�Y5�����у�.rі���	a����ȶX�h�\"tF�����WW��D����R�hg��&���� �xʘ8*�\0q���ݜ:m9��[�L�����Gk�S�n�3Y\$���ybk�w���LќH|3�e\0�KL�������g+At���`A�W�fG�rN/ɸɝ�(%��b����m�m��R&��S[�����W^�1��5=���AoK<�ߧ2�Թ���N�e��Lɛ�E�����yIÍ�rz�<�,P�1�/�l�0\$�Lص�I��ņ#i}�e���T�s�z�)&��j�E�`NZu߂�E��1R5AA�f�z�\n�:�#9��<�ΎG��\0�7��9FFg��n�/oɗz�Dn�3%����o�N���T_��A�ޕ���=���.Uϓ<a=+���gp�ǽ6����`��bPS��zA!��@�&ż5����d�,:�����eE���`���%���C�Z\n�\n��\0�ĠRÌ6ǆ��d(�O��G0I<5�|H��L�o�����0/~�pH�P\\�|��#�\nM̟�<���g��^���Nz&@��ϥ�NJC�r Ў�\n�,��0؃��S@��U�w�j\\̘����ax�p��P^��\n%�0 ZE�@�c\0M��#���:#�`|�H\$%��\n�B5��d�9�ʹ��ϥ\$�\rZC��F��:	PSg��o�G�pⳑ>+'�����V��.j�THf�o��׭~nC�\"��m�ڥ�[P��pɅ���̒�Q�ќ�Ϲ1��l�1��l����bgb�����l���1���rL�MԦ�QԦ��>��MC�#`	I�Hlj�J�a����T��ܰ�������	�����\"1��P�e	�օ��@��o7fM#L��#�@:�L`��#d\"\nC\"`�f�c\"H^͞(����\r�N��)�'�\"�(rtN�E'-�%Q�r�bT51�)��Jr��z&d�+���\r��?n5+���	�!`�\"��*�=`�\r&�Pt1��%�b�\r��,,��r����f	gtg����6�D��/.;G�'4�w\n�V���H �s��BE�\n;Z��\"��nA�,��\$B �\n���p4�ނ�46�&p��/a��0.0�O��b;8'��\0H�P%N�%N^1�|�R���OV;/!,�ܹcH�f�7#a4�X�N��R���	�R:�@���	�5�-ĀFG��:���\rS0�#��.4�\rƮ\$�R��o��!Lf0o�ȯd#�����'@�?\0@\0��t#@��DR�X�2��`�^��x�w:4&=�H��	-�.(�)p��D�\rÄx�+��\n��?\0��lOE�&�\"tIM&�C\"���\$HN�	�4�.�K�2b#v\\�[Fָ��g�B���|`�<Ѐ޸���*)>kd�X��84��B�  ";break;case"el":$e="�J����=�Z� �&r͜�g�Y�{=;	E�30��\ng%!��F��3�,�̙i��`��d�L��I�s��9e'�A��='���\nH|�x�V�e�H56�@TБ:�hΧ�g;B�=\\EPTD\r�d�.g2�MF2A�V2i�q+��Nd*S:�d�[h�ڲ�G%����..YJ�#!��j6�2�>h\n�QQ34d�%Y_���\\Rk�_��U�[\n��OW�x�:�X� +�\\�g��+�[J��y��\"���Eb�w1uXK;r���h���s3�D6%������`�Y�J�F((zlܦ&s�/�����2��/%�A�[�7���[��JX�	�đ�Kں��m늕!iBdABpT20�:�%�#���q\\�5)��*@I����\$Ф���6�>�r��ϼ�gfy�/.J��?�*��X�7��p@2�C��9)B �9�#�2�A9��t�=ϣ��9P�x�:�p�4��s\nM)����ҧ��z@K��T���L]ɒ���h�����`���3NgI\r�ذ�B@Q��m_\r�R�K>�{�����`g&��g6h�ʪ�Fq4�V��iX�Đ\\�;�5F���{_�)K���q8���H�Xmܫ���6�#t��x�CMc�<:���#ǃ��p�8 �:O#�>�H�4\r� ��;�c X���9�0z\r��8a�^��\\0���Nc8_F��H��xD��l�>`#4�6�t���|߲K�v��\"\\���MЕ\$�������u���o���\\8Ծ)���&��¼�+-�V����'�s��KЮ0�Cv3��(�C���GU�ݖl�)���g�:���M������� ��X�B�'��q>̑��z��ph=�- /f���dt�21ZP����q��v/�Ͻ��Iڪ��Z��WL�\r�fqL���E9��֩�H�4�@������!9EԮ��p�vg��8p^L�m5h���X��b� ����@L\$�i'�	�J=����ߜk�F˄���@N:R��^�\\�R��*D���^(�p[��s\\Q�8W�YQ,})X�=�Vp�a�J�T�@(�^�!A�\$�.5�O[iezk�@�H\r�Yy�q-���\0�:�-(��_��\"ȁ}�����o�N���p\n�;X��:A�eT�+FD�gEH)Y���I8�׃�L����e\$���Vy.����5����RJU,�,����S,�a[\"R�M�r!.L����RL	A0�Y�4�a̢�	�q	�\r�iqXaR�ދZ���P�C\naH#G�~�b]?h��e�E&�p�J4Cв\r=-�P�	k�r.)AP4ҡ�҈�U���\0���/jEG�F�A3f�ݜ��z��whm�4��ҚcPAѯ5 }T��l\r�t@!f��:�̨ͤR�ߊW�iq/U��:�u�lɘQ4O�)\$őm�(\r	2�=�uo�%�P*6g�3�К%7h�%��斢�j�R-I�B���ϒ.K\\�հ}E\nqf-'ն����Otx(D�CB�\\����&2���Ɍ�rW\0�B�hO�r��M\r�gk��U����J�O+�KĒ�����j���6�P��p�!�2�p��b�aՉ1@�o0l\rᝀ�6D#O���\0��)�n���63\nlͪ��������~J��R����tYA�	�7Bs��-�����\n�Y���XP	@�\n[Y�)��RVZN�yz�ܥ5\"��Tb�7���C�iOa������� a,b����*Y%m�n\"bD�[,�2+4�\"[��c!͔�0Apw\r���2�T����4�<\0�;9���``�L�)��H�B����XiN�4���ӏ�)�*#\\�lUЦ?A�nˢ]��;I3�r���QP��\$�E�\0?2u\\V%���\0�:lѩ�A[�����]2u�ҵa���,L,n��f�	�A\0P	�L*G�_N��Iz�Q#z�\r�>�ҹ����P[?G�ң򊾵3�C�¯3�E7�r/���_��-�D��Bv�b�o�����h0Tƕ��=���g���fr�|�#B���~����x����Z��N�+]R\$�J	��1LTu&��Z�zrH�1���#�Fu^\$#8L���(_[��kA\"�t�����f����R,�E��=�>T���nP��÷��H����t�a!^������%\r\r�z�nM\$�+��RDƔ���s������# ��1�H���ٓ�eR��z�\$S�*-��{S#DW�� �|g�@�&V�����#�'�InV_�6�Io.hJ�\\:��H��Y���x�%�u�;�\$\$���}h�DM�Jl��+�\r���8|��*(,B�\$\r&B��.\"�#ZY�(y�2�0����'::A���AK����p��dn�7+��e�\\�P�ɺo�~�E:�ǌ]�&o��H4T�ܡ�(�\"v�z�(�z��BA�碊�	��m�D��w���b�v��1���1e��X���G���_)�\rКI�  ��_�ԁ\" -���ЀB7PW�@G�mTm�4�o��¤�Ū�Ű@�\n�� �	\0@ �N\0�`�0f��\r��fa�]����ܒ��EEUF�u�^2t�0;C&u�|;�;g*�lK�ps	2\$f���\0007�L�a4���(� �I,���dt\"����H�M�.b{B{������\"�/�)�O��;\"��/�1��B-ó\rhZn�b�Ԛ)� H����/gZŪ!��C�[I���-��\$t�)�}\"�}#!4�u��[(4ޢ*��0����hT��DpÎ�N|���\$ K��,T����%���ٮ(,�/\r�M'�N]J:����Yk�S�%��h@���K��ĂrW!H�*C�.�X�\n+.5�*@r\0�2*�bvg�r��,v��}��]2�G00H�DD�̐ރ2�l�V��,���&p4��R�c�T�v��4J�op+�(��0��LG�950��B��6SR��/#�(��Ȃ@�S�X��W73�8�ͥ	�>�8s_9���^mh�\nG�q;.�ZN�r3���(�U��y���똗ªz���\n��T��H��^�N��➌-���m�L)�?�����\\fǢ�I�+s�/;|��l>s�B�3���j,�D-@R�S̃����X�s5��7����dT([E��F�7Tv1Ӿ�DW:�����m:r�C��9�W-i���o��R<���1*ObGG��	��ꚴ����rT�\"�J��yL���NQ�u�iCdPx�>m���.1�_FpC5��<��8U�Pj�蒖���T;I2��-�!1���\r;�&���Cԃ8�>������0��nY)�_	b���+2�DFH��bJ!�j(bfXC`�AW\$I ��CYjA'�UǊפ.��{V�\$I��Y�	�B��1��Lr�����S��T>�\r��;�L�U���}N�l퀎H2o�\n�g�����J�Xp����5I�*�s�G>r�R\r,sd�S]bSJ�����H�)T�5H�do�c�,}şO�!���JәcuR���vc4���b6oe�t��yd5K<53JH�g��_����dUL��θ���E����\"��[%ZA���v!���(��ƞH65M0�ˤ+��'K�M�1F�c���Q[�i�1J3�o�\rKV�d��p�9iu/�xΆ�V�E�qr�!�#fr��b�r�o���l<U��|+96L�����n[�Ys�T�¦Y�>�lR�T3D6�O�4JM�9v5d�p<\"cx�p7:ցIG�,�~CW�tT�:7�D7i����e\r�!jO�qWS���#	�Uq�wB�M�n��9oVmy�e}���w{7z�Z��i7q7Yif�s�3bQn����P��dwD����'	��\"~�EϡOwLү(�B%R6)�?28C�G\"o�4Z��&{h#{D�OB\n�\r�='�¹�6���L4�L�1\"p;7�#p7�K�O�B���|��.Q�������`�\r�\n\ri�+a>�T\$��.n\\�!yP}:��<�6-��V����Z���G%��n	s(����\n���p)@I4�ܳ~}ӄCi��Q���0}3�7v���Cǂ\\��o��GӠ�G)	�\n8;D�! V��D�<�ϫvH��t���h��=�8ŕ��fD��D��s��x�n��v�b@�.&hF���\$�dK�S\\��]H���%\$��n�J��=H0&�?)�>\"��-��B�R��WS*[�Z+�\\��T%��xW�+0m+hv0���\$h��>��H#��R9��w�Fѹ�oeUsѕLVp��>�)a���y8�0��P��eo�\0�}��x���]U��Cq��>Y�p3�%0H�4W�˜i�.����[:�\\�̅t�����G��r�s2Ͱ/����Y��\nZt�Ĥ[*��ß^��^���\0r\\��|�:��;#'���_�^���s��'ъä\r��N\0���\nv2×��p3�o�a\$<�z�\r�\"!Gt-��[rX���";break;case"es":$e="�_�NgF�@s2�Χ#x�%��pQ8� 2��y��b6D�lp�t0�����h4����QY(6�Xk��\nx�E̒)t�e�	Nd)�\n�r��b�蹖�2�\0���d3\rF�q��n4��U@Q��i3�L&ȭV�t2�����4&�̆�1��)L�(N\"-��DˌM�Q��v�U#v�Bg����S���x��#W�Ўu��@���R <�f�q�Ӹ�pr�q�߼�n�3t\"O��B�7��(������%�vI��� ���U7�{є�9M��t�D�r07/�A\0@P��:�K��c\n�\"�t6���#�x��3�p�	��P9�B�7�+�2����V�l�(a\0Ŀ\$Q�]���ҹ����E��ǉ�F!G�|��B`޸�΃|�8n(�&�1�2\r�K�)\r�J�: �bM6#ƌ��R[)5�,�;�#������9��p��>41�0z\r��8a�^���]	L�s�-�8^���B�C ^)A�ڷ\$KH̷'.3��|�\n��p�M��\r.p����3���Ƭ�7�*h�l+�6��:��8����`+�+B��\$t<�\0M�w�D�6�l(*\r(�%C*S	#p��`1�Z:���B�8`P�2���6M���pX��݈î\rS�C�BPԔ��I�Y�.s��!�T�,B�9�yc�2ď+�+-S��wG+���3�]�Cx�o�(;,����b��U�Kv��X��j%R�)G��P���ڐ8�X��YC��2�h���ԣ)�\0P��4�\$4\$��rP݈����n�+n�Q���CB �2�,5�7l�8��Cx�3<��h!���T�#�|�*\r����C��9�c�͋�d���tDb��#8´��=�N�(P9�)�p5�B�)Π삼�p\\\n�\0ٍN��J����~��ef9\r�����Ξ^�*XI��@0�I@F�h�4��\0uN��&5:}�B]#��(�:�Tz�RjUK����\"f?*�Q��^̍{\$U`�bԮ�4HN՘\$\$�`\"�\$����#��z;M�6�zhW20���L�UB�*��4������b��I)E,�Ҝ�J�9*%H���8��V���HXL8��!��`�P '/p����}�ʞ8��2�#\$����F�>�B5HӴd�fE��|\r��G������!�*���,x�bP���lY�aC\n/��\\���3�8 �lEO\"C��L�( \n (p���q(��A�s#���:󈧤�vaA��s�F�q?��5��Fù�&���\0^E�M48�.ZN�C��N��FF���N*Ľ'�(b��\nP�_ ���GD��C�\$VI�xNf�<X\n֎1�zd��L�Da�i���>�R:���	�0��fI&m),Y��a9��y���@�!\r�V���#���(#PM�O\naQ<��NH�)-�7θ� uF���tN��au�T�'�b9K��%�����4t���ǌ������t&DGx �Rj�RF�I<��'���5>�����\"��l|�6t �0�m�IA)�:�xR\nW����C�Po_�o���) ��s4B�� \n	��ǜB2bLY�7f��SV��%��5�lyP!�mWa��&[�=E(��6ԀJ�Ė�A����o�ہ����6����&�ƌ7�dP�T���,`�}��z)@�>'t���N����5JR\$J낹5_�1���1�9K��_�\n\n�P����\0�u!`��xo��14ןi~�'y���+կ��`\nb5�<̴ے3ͷ����ĖYi9��8�Oz�dN���\n�\$��-���8�NM�q5\r���S����sX��#+D��e+<�q\rS@q\\�nX�O��s�T\n��\$�[�K���E78��MO�D%��5!���{%=w��	�\r��wmbʶKC�cbP¢6���D�3P�R�K+w�h�lPǱ�v�ڻ�k�\rʳ�L�*�莑���7{�����}]_��H2ǡ�9�v�8XsTm��#/����\r���N�L����n�*eM�0;�����d&@+��{sQ�2~��ICɷ�`sG'Y\"i�T\n1Bf������5����f	J�������z���6�;`�B&e彈��[�0Hiq�]��2��]��H%���?{ބ1\0<��_�K/��絓;�q��?Űw-�m�p16���T4� x�ќ�a\"<k�!��>�I�n��Gױ	6��κT��i��>j͆\r�՜��~�{K���/��n��@��<f�xO�1�\r��5�0O��.p�©ܿ��^yp�M?��9���ɑ����}N �#&�b.�m�|���*��ͼ�O���.ܐ��`�Kf�o��/�*d>U�\$�\0��-��\no�����d-��/C�ghl�I/C�~�@e^/o�Q����DȺ�\"���\$C��ɚ���b�%�\\�D@���>��ᣜm�x.�~'	&�\0�u�AL��d|�\"�o��[�7m��B�̭�8��/-�<�,W�4���r���Bj���R)�'��Z����I��Ϗ\0%Q�\rV7�&i�\n�\$6-%���%�|��`7�A���:9MF�@��p�R0d����^�1UqX��Ј�D���䝑cf��TxfF��ÍEF�_�8p&4�q�}M���e#�\nbC����ql���1��&�-!\r��рA��C�q�ԃ�w���\\�\\A��R�_��	�\r�a��_㈥qN��T7e��m��\0�3\0��oN-�B�1�2Dn%�bqM#��\0M�#�bo�H��Bb\r�V�#��5\n�@Q�#�G�&�����	Jz\0�\n���p@c�0b�&�������+��,�.���<@���ʿ+\ns /�n��\$HÌ<�毢�҇Q�PD���4X\$��I'��^���D\$<' ��Dd,c��M��&\$�Bi���e�#H �|���G����!����J򐎚�~�3h�r5�\$3L�I2I�8����i�8%�D�R�F俤�0c�n�����MT�ƌiED�&�\$���#������@�8��\r�>2\$\$�Gcv\\q�7nܗ���D>�\nsO�p��䔋�\r����;�/#\\�J�U����e 	\0�@�	�t\n`�";break;case"et":$e="K0���a�� 5�M�C)�~\n��fa�F0�M��\ry9�&!��\n2�IIن��cf�p(�a5��3#t����ΧS��%9�����p���N�S\$�X\nFC1��l7AGH��\n7��&xT��\n*LP�|� ���j��\n)�NfS����9��f\\U}:���Rɼ� 4Nғq�Uj;F��| ��:�/�II�����R��7�����a�ýa�����t��p���Aߚ�'#<�{�Л��]���a��	��U7�sp��r9Zf�L�\n �@�^�w�R��/�2�\r`ܝ\r�:j*���4��P�:��Ԡ���88#(��!jD0�`P��A�����#�#��x���R� �q�đ�Ch�7��p���qr\0�0��ܓ,�[����G�0޶\"�	Nx� ��B��?c �ҳ��*ԥc��0�c�;A~ծH\nR;�CC-9�H�;�# X���9�0z\r��8a�^���\\�:�x\\���x�7�\rDC ^)�}HP̴����x�&��F�1���	8*�~¨�Z��,�j�߲I �7��\"��J��7��Y�����Q3�\r#��2�B�[%�H�J��j�{��\n���#����FQ���E�+�Xl�7(J%OB%\"0���@�\r����H���D]J�B	�J��\r�T�0KX���[2���(\r7j�A���4�cZ��4p��#c�cL�\"��\n\"`Z(:hS�7Y-�-�0kR,9���~�����=G#,v��6�+��}�&G�ݛ�L���\"�[�6�F*���Ȓ6�)(\"�<���5\n6����,���\"�d��\\ʲ�jR7��26������c|�p5��<�:�:��6:�J�P�Eƾ\0�3�/j�L(S�2��R�\r�b���)�]U���[e4��q��_]���I��P���ܞ��4��� V��6 @��rQa���~�i�R\nIJ)e0���T	�Q�EL�Q�Wj��B���W��;��~{PJz4l��>bd��Al}�ݮD�I�70��B��X]��KRUF(�&�Ԫ�S*mN�u>���r���S�d\n��D\$V.L8V!P>@Gk�\"i�)8%%H��|�ä,10���p�L�\$ q��Tv^��)N��(\0�Ջ�uP\r�p��a�xi�ļf�I�P��3R*Q� q.<�dɨE*<��2��!�0	�\"V}�)�K�k����H\n�4˃�n�\0()l4OCO1�8Di#�: F&��#�xw ����Ҥq���Խ�Fj�'\"�UI�Z��]�pp<�C��Y�h8��J��[)�ӑ�\$���z�ߡ�!��9!�<AL4�����U B�y��\0(\$�@�e�% ����K9�q~)�3���D��1�M��)&�@'�0�]�%*��7+��&ԍ�Q�H�iC��(B��ū\r*%A�8����\nu���<���{��6�\0����#I��U��gJ֞S�+/\"�\0%侎��c�D)�����%_�����@B�D!P\"�P@(L���0#.��;CE���ʓLi�Ya2���a��Q��w o(��%l��s�oɑ\"�dˆUr�pd�Nc7E��ɪRtp8������n�g~c��G*��J�t�_���)��n� ���O0u�F�5�@�+*\r��(��/�șGːم\nA����L@E��\"��.\"�\\],0!�xMg(����(d���M��X\r8Ѓ����h���NYb�\\���d{Lt�J��*܋�'�\$�Z�Lȿ�\0�8/��pP�KY�K{1�9��&l�!P)���(R[̀^�f쓹\rW��������]ȏ#�#��(V�8*5�z�˜~�wwj Aa S�xi]t�H	�8'X^�Ij;Nx�� Z������r�xu�%��ݔeI~��8gc�\\@^�^k\rf<�Hbj�3�����ű�ֲM\r!*��}��î�v�\$#t,�w7��D�7�E�a#�|�\"2J��\n%7D��>J/j!!��Q�zи\r��ͫ�HwI�m�(H��\$�Ox�6H��E��͖|�n�C�d�f\r�LJ�ң�l�����)���m�J�Z�]��K�ʛ����7��-�w��Zɜ\n��xcדq�*�_u���z���\\�^�G-�g���\$ӒZbLq����2�p@D=''\"���j-A���������!X��]/K2y:5��J��ǡ�(��;*���/5�=��4��Q��N����n�B;�/~�{��G��D��\n��o�����}���tx���Zå����z��/� i\"�i�IA��M��{�ڻ]��QkeE�����|(�O��.��o~�O���9\0,ȷ��L:���8%*�ZDtR�6=鎏�.̠�fxW\$@bHm�H�/^`��Qp2�6:��j�<I��~��L2!OZ���4\$ �.ʎ�>=�Bgb�W/���,,��Z��pe����f�%��%�[�R��=ؾ�%%�[e�O��m�XP�\r0�\r���\$p\"�����[��Ҥ�s��������,���d��#W�\08�����|q\"r0e�E\"+\"\r2�`���B�&��<\0�zL%�V�\$�Cy+����ʽ�����-p�1|����8�����s������ng�e �ɻ��o��sѮ�(�\r���c?��.'��V��,�A�������1�u�����R��;���/q���͑�X�9�\0�����\0�D�D�#��}����6�˱q)��H�E ������b̖�P	f���q�\n�pn ���q�10�τ�%�{`��kl�l�(�����	n���\r�n��*l��!%�.���/<���9Z� �F��`�&e�DB)kDܒ'�\n���Z���J;Bj��*B8_��\$��>&D����/���l����`ޞ@��v�є<ÒA�H<��8����v��L\"�%\$�J�HlDL�j��>;p���X�����:��>���s���Ѣ�o^\r��P1�j�������@�b79�)܏�y\r��;N��\n��d4�23jT�\$�1,b �:Z�nfd!�!k�E\nXr�̏t�G\nX�F�ˆ�ZiK�i�G`@(�(,�B\0�� �(g	��\$�,�p&F\nТ�*�>,��Px�`�,���+���L)����e��/�;��\r���5��7�d�p���7�j8c�	\0�@�	�t\n`�";break;case"fa":$e="�B����6P텛aT�F6��(J.��0Se�SěaQ\n��\$6�Ma+X�!(A������t�^.�2�[\"S��-�\\�J���)Cfh��!(i�2o	D6��\n�sRXĨ\0Sm`ۘ��k6�Ѷ�m��kv�ᶹ6�	�C!Z�Q�dJɊ�X��+<NCiW�Q�Mb\"����*�5o#�d�v\\��%�ZA���#��g+���>m�c���[��P�vr��s��\r�ZU��s��/��H�r���%�)�NƓq�GXU�+)6\r��*��<�7\rcp�;��\0�9Cx��H�0�C`ʡa\rЄ%\nBÔ82���7cH�9KIh�*�YN�<̳^�&	�\\�\n���O��4,����R���nz����\nҤl�b���!\n)MrT��jRn�o*M)#�򺖰�d���Ԣ��Ō���H4� ��k�� �2°荎���Pc�1�+�3��:B�	��H�4\r���;�C X���9�0z\r��8a�^���\\0�3��|F�#�GR���\r�T&��P�I��px�!�ƌBTN�\\�*6N�J��,T�=�Z��ܬ�4�3��J��i�Q'ru��,Ȯ0�Cs�3��(��^�P�a���8q�ɰb½\"%k�>��z�HR�.����Є��2������u��3�%iV3u�h2�ɬ���e�����\"�u��0�ʊ�BH�\n�!�s��i��>�+��6��VY��FM�������\nH)�\"c�\$%���l.��笗�]33�B�5\\\\���W:Wu]�ސ�'�Li����<\"!�%\n��+6�^C�2l�)���\nC��l��ç|�����,��q�\"Y����C��66\r�JQ*ɺ���\$*d��+��v-T�!G��Ψe.�%77L�\$Db����lAt%>�\$�����=��2����JU|=�'�g͠�}M�1��ߋ�)ȱ��U�����A)� ��o\rh��C�� ��!��:6�S	\r\$ɴ����`!_����3x�I�\n\n��0�*�P�uQ��'���:�h��D��A�U��X�5j���wWj�(+��V~C!�j��}���Z�d��TV�Ya�G`���h~�[�y�����ӑ�u'ۛR��D�ĶF@�\"+M��&��޽�%3��U*�\\���V��]+Ȟ��r�XA�a\"F�Q:�Ynv>��b鈄s�`������[�q����g��\n�s�����Aޛy,�܇1\"�MI4<�@�&�0Z�hBj*6\"p@�C`l�	�heaa�3\"\$<ê�Q��:� ��9��h4B	�F���VE`�lem3\$�*e\n��LP�)��>ڊY�J��B��Qi]@\$��ԛ�ɰPP�L8,&��1w�O!y�J�!�x��b��*�9�ք�<�T\n!\n��@����@s�m�7��JU��Bs�,JC@�=\n��T` �Jmg��৕�T�Ʌ�p�C\rOA�X�4'_(�a�A��5r@�Ji\$F��q2�/��rrM��qrId�,�g�L�ZT��#M�h\$���S�iau�K�����!�@(0̂ClM��� P�AԽ�ʆ��S%J�[�uK��V�Kd�+}�fK鈚W��'�R>Â>��\$����^��I�\\�d��xllQ��zl�޳�VAt	���R�GK\r:\\|�*Sj�ш��K��m&��'�\$�3\\�����-�6�����hi�C�A<'\0� A\n��P�B`E�mE�8�(�)	\0�.��.��&��]R��\n�>M�e�L�<#�G�!)t3^\n��U�S�s�0߮�� ]Ӆw��M�|��wi���\nyvS	�]��#�����K�N:\$����U��n��b������+�-�#Att��Ǖ�+�D�V��C\"��i�I!�\n=�Y�I(�E�겆��e�8�u�d���]��N�xTI�i�xk~�K��|��+�)eݳlLa�_O>�������ڿ���nm�uҫ:h�;88�Ȳ�R�T��xzX�24K��eZ�^����D��4��-�*v0/f���\$���d�8�ѥ6�����⥰���Aa \\4T�U�|7�:\0��Ed�d�)�d�7\n\"�,��i�}�!)����p�+1�>Ծ��xN�;W����ƸQ�;z���3T��9��,C�^�ԭu�?OP�c��EWW�	��^r\$W+;\0���kO:�N+���B�UYd�\r�<2P�r�פ;��y<��G��G~�J-�9�I��8�ji�?|s|(�g����q��C���rP���VHi�YJ�ٓ�e���yܯ��_ǈ�|C������[p��s��7r�\rt�!Oc�Vm�M�6qIYN`k8�X/m0�B\"	P�Ek�`�2cL��\0'��mB�O�%O����.݁^��\\��v�\r�h�c�H��bc!\0P�n,� ��g��ϴ�n���\"tz��<3�p�)��L���8#���w�jΧ�k��Aj)J>�Z0/&�-0]'R�o���x��%k2���\"�\nfHא����釢r☂n�����c�Ű^��P�`/PŃS��\r�R߰�)�v�;�| �T2è:�?	gnI�F{��?'�\0l�Oz��а��P��\\ů��\$~?�0� s��C8�.u��e��O��]*��o�����E1\r�^#y\n\r�tP���<`+;�do�㑙������GDv����Me�tt�V6�\$�D�����p��0�pl��\n1�]��0��Q��������m�\\.M��0e.C��!���r�䤣!�Ki�)�z\rw\"��K5o���M�RT�k5 �y �5%��\"��&�D>cdj�nH-\$�0�(*�%��#�\$�2�(g%�����\$�sD��i�'�B<�`#��B�&�b\r0�D�\r/E	�!�1��L&�)�N�ͮ���7�^�Ϥ�P�\$0���yo�J��\rk5*03)])Ѥ��V�\0�\r�V��\rn~�Ѯ��&g���`�\n���p�笝��B׉�SSX�qy('*M��\r��p�3	�`/u�g)1\rC&��|� �o!G�KkC8�F3�D�&W��*�̆����X�/6����\$.�\$ø�F�\$���0�\0000#&���!D6��h��,�6v�Fk�\$��|t)5�t��[��=p}r������@�K�.�Q�Bp9?�,筠7�o��T\r���.Ϯ�hh5g��³T*m�,/�ko��p��)4r�s=��f�p�ns2n�L�gB��F��l��9Ϙ�%��J���sbPu�����8��s�Sm'F&�oL&�B(h��r\r��@�E'�t*0�\$r>�҆m77��\$ar";break;case"fi":$e="O6N��x��a9L#�P�\\33`����d7�Ά���i��&H��\$:GNa��l4�e�p(�u:��&蔲`t:DH�b4o�A����B��b��v?K������d3\rF�q��t<�\rL5 *Xk:��+d��nd����j0�I�ZA��a\r';e�� �K�jI�Nw}�G��\r,�k2�h����@Ʃ(vå��a��p1I��݈*mM�qza��M�C^�m��v���;��c�㞄凃�����P�F����K�u�ҩ��n7��3���5\"b�&,�:�9#ͻ�2����h��:.�Ҧl��#R�7��P�:�O�2(4�L�,�&�6C\0P���)Ӹ��(ޙ��%-���2�Ix��\n	b\\�/AH�=l�ܘ�)�X0�cn�\"��79O\$|���\$%��x8#���\rcL������##��@Ā>�\$����0�c�\r�8@��ܩ�8�7�TX@��c����`@#�@�2���D4(���x�W��<ϰ���}1MS�xD��k�'c3�(�`x�!�j+%�;�Q������@݌�S�#�r�5�2����K^ر��(r�R\n�D�D�a(�׎è}_���m[���<���%�锸ӁBE���:1� Wz;\r�U����P�8�vL2 ��=F3�|32[�3?6��P�0�M<Wn���ʃ�R���7(ע��:p�������/��0�aC[Ӈ����r6� �BR�6�EҎ���+%;rqu8�K��q,�r�ÿcl�C��\"�	�\nȶ� ��Ÿ�[�\"@R�[�ds��3��3�@���52���\0�0��2č#L�X\\<8-�d��N-�:Kc�7u��5'KB4�S�J>Χ������תּ���K�'���2��'|��-\$ŵ><��1cϛ4�~��������Jj�{F����͛�A�2�6.S\nA�BR�P�.0�@Ű�Q�v.�����MB�,i������\0i*!�+4�@���'j):�0䧃\$e�O�F�U:�Uj�W�ub����V��7�0m�LU@�+�v��i5	/.R�b\\}�E�&���aw0IQ Z�]RV*�lΗsRHI�TJ�iPD�2���V*�`����J�\\�T�P|ZX\rE.��@-G�2�Oa�ym)x&����Q����R��%\$K���[!�P�d)�.A�%�C4uO�C�b�`g{�D:��	�2�Q�VK������r�i�~%\r��GB�H\n\0��3�lZ\\�\0���4V#^Ih0�\nCL�f\0\nn�2�2��JD4��EԺ�A&->!�s�Y�@㪟�cɅ���I���\$#�̕�js*';\nU]���øh\r!�o�Ϊ&B��1��MBYwb�ܞ��|P��1\\�-s#�\\I�*0h%�B���A�%�C6 �*xǨՊE̥�:\\b�Cأ=��s/������I��v�(��\0�T�6��B�e\0Pq���(���[�n8v����Apf\r!���&�J1uk<�'�L�S�9��M�:��U\n` �P(�xa��n�*���\\%d���^JiYsb�,���2Ac1d!<'\0� A\n���ЈB`E�l\r��\n���@\nH�]#\$��0N]�F��\n^�)�:����,��� ���p�R�<�,7\$����\r��ٕ'*s�g<40������p,�c�Nb��:�f��E�PL��� ��䃃x:A�}O��?�Y3��M�Sڜr��I0�\$�ٔ�s\"Mɵ��zb�!7/x�B��Z�dm9�6�p��:6����ƹLpN���CsU�(e���\$uL����W:��8���4׉��^+1w�P�y��uR��I�<�T��vDL���B�!;b䕪�8p\0PD�m��:�o�T!\$\0�I�{!>����Vj�t%4���t�j���t���i�����8%�P�eÿ���O>�@�(�;|;���}�䥆(yn�k	�Se�A��X��i�V��DՀ.N�!��|<w{&�U�C�2&�昆���9��vϘ�nnI&/�&��{��1/8�����4Α��2m���\$�Z� �����dJ�A�Љyn.GQG7�D��\n:�|]u�N���q�L��Y����@�frx��-3�q.��q�K7vؔ�̬f��yQ^S(��-��b)?�dRy~!���LP'%R�l��'�z_Nlza~C�F���V#d��1Ԫ���8 �� �7���3�\$ϷJ!�\"�!��)�鞳{O�+\r;a)D)���C\n(+�����ߪ�^���,L�f\0�P���>p~�#Ư�/�w����4K�͂I��������L�@���P\"�G����ԋ�D�r�n�\0�N:��\"v]OW/��PP�G��0��8�<t�~o��/~��>��� \$��v8�^&�-aG����Ê#�{��	��3\"v��@7�LS�,Rby\"R�<=c�`�\"-dI0�qPLJ��E�n�N~\r]�@�ȳ����AI�\\�/G�i���1�\"o��hا�\0�\"��O͏\0�M�-�!P�c_�D�z1dN�Xi�&	������&�����{��%��P8��7�EPv���op=�]����PeF�j6#\".'tّ�=œ��:�²�Jd�#O�aGh\r-cq�MRD���P|��	��]Ba�pQ�!1�/\0�D�;Q><�I�]/ ��́H2c]�<�.̣\\�P:��h��%\$�	���vރ�\r�`�P�@E��M�R�'�K�D�X)�ݦlB��12�<p��\0r�R���&߰F_r�����J\$G �cnUC`��8F�n���N��	PZ��	��\n�(	D��2�mڣ��C#(-�5B�0O0�d��@i���9BnU�C�0��#��2�0��'d)\$2�0��/cX5�Z�+V\$���V1\"O5b�2��sGj&F.Φ��oj/�G<�n�-�6����鐺��7�c�Г�/�@��o1S�좈XF�:d�7�6�:L`�@�L]b�����N.�+Vi��\"o��3�i�EТu.\\����@1\0��\$F\"6��t7.�ĆK�8�j-�<�\"61hM\nL^�lv�>ގ�A�\r��[�\"0�\$���DĮҰ��b�";break;case"fr":$e="�E�1i��u9�fS���i7\n��\0�%���(�m8�g3I��e��I�cI��i��D��i6L��İ�22@�sY�2:JeS�\ntL�M&Ӄ��� �Ps��Le�C��f4����(�i���Ɠ<B�\n �LgSt�g�M�CL�7�j��?�7Y3���:N��xI�Na;OB��'��,f��&Bu��L�K������^�\rf�Έ����9�g!uz�c7�����'���z\\ή�����k��n��M<����3�0����3��P�퍏�*��X�7������P���\n��+�t**�1���ȍ.��c@�a��*:'\r�h�ʣ� :�\0�2�*v��H脿\r1�#�q�&�'\0P�<��P�I�cR�@P\$(�KR����p�MrQ0���ɠl\0�:Gn����+���,�N��X�(l+�# ڈ&J��,��������h��I%1��3�h4 �z֤c�\\2�\0x�����CCx8a�^���\\0��C���|�ԃ�L9�xD��j\\�\"2\\��#px�!�t �*b`�%3T؎ۊ�v���������1�r��%�xNv�zä�T`:�#`@ɍ���:B��9\rԲ:���Ɓ�N!�b��7��T|*#�}���:ʲ6T����Σ�+(��ׅ�,��7�� ˉ��+�#;:L��X�>��s��{L�R��a� P�9+�P���C{�9�/���6�����R:��\n�hπ�1쪒}P�J}\n�Zvda�Q��(����:3���1��䘧�94\\EL��+��P9��0�yZ`�#�Y���GE�oܴǽM#t��#�����@�6���\"���͗����We3����\"@TƓ�`S>�hF©U\0�ׯ�*t\"l��kcx�;�C;!;@:�uJ�-Vp[\0���F�BX��\rɼ�\0�����0��Ȱ1RM�;�+Č0��Vo�50L�Xw	:\n��5��@Rǜ��R�uB�<(�ՙP�A���++L�2rЛ��e ����I	ZK̒�@�`QU/Ē����ҮV\n�:+El�Ҽ�*�9,��Zb�������I�Siد<T��JW�o��=��S۝���R�Jr_%��B#��:��V�U^�U��V��;��zЁr�XA�a\"\$�I��Y�����@��w�PԖ�\$�̦e���P\r�[�(tP_��;f�!�ƥQ4*GjI���v�QL�1�@��jP9�c<LCy}3*y8��\r�\n2�%9tNt�r\$Oń��\0eסR)�XAP���<�E�AT\"������HXi�t�y�E`��c�(�߱�BO�!\rꈠ����oN'm>-X-Ú�D1h��kHY��@7ޘU*�S�ܛK������m��Dr�L������P��Q )�=����d��χ��3�r`U#�iҚsRj�\"�L��pe\\�*U:�Ņ|�J9.�J�Tpk]��zD\$(�	�c}�%���N���շ�4(R�v�\\��J�kI�5m���yx�I�\0M1�P�h�!�,�����x���I\$E,��	]�R��i_j��l%d���ғc\r{�J��KW�*Ke�I#�I#���P�*[�� E	���b�	��c��Vp��\rm× ޓ��wR�OUr(�Ho=�A	0�O�{)�yH|[[��0���p��~��\nL���[7q\r\n9x��)����Q�*).�(��Kyg�աKǞ�,ۤt�(�e����kg9�@���B\0S4k�T��3@�!�㏖��8BK�=�M�W�ˍ��t�����B�v�2%��8�p�a[:!%A�+�ܷkY�Q�7HQ�lg���-\\�\n�)I�O+���wk2��\$�'5�PTpp����b���<�'2�	*�s�[N�ABońIw��D|� �'\r�D�bV��m�O[����2ȃ���AN��։�Q��T* ��1���`��0��5�y@Kl��@�BH�'u��Je���� �eM�%5���?��E؈/���P�Ř����[�`M�I��D�ZRj���'������@%�rnp9ֺ����>��9�.!=!9��f	A�d���s�9:b���t���\rC?�s���Wg0}J�uI�ՅD�x�DǶu��Fx�k:���Be�j�0x�aGL��\r<�! �z1�cI]���:�p��|�+�P�@<&(��D ������x6 ���v�W�3ڇH.{�@PHH�Ic��c�]O�ȝ�v����ʂ��kZ��~������ݐM>���,aAmty��+*��\r�K�O��M���/����J�����O���T2o�¬ ��|�.f�Nܫ���va\0��L�\"��ac���`� �6����Tp=��Fl#��D/��#8�FBL�V\r͘cl&y`P�f�7\rdF\0�'g*r��\n��̪ֆ���:'�zȐ������|F0�\0p�ze	P��0\nL�\n��\n�\0000%�N?�H�g�\rH���4�Z�i ����꒰�����p�C����ν\nM�����M�/����)j�͸�aP�P�\r��M��;��p�)L\$c̜#��%�M�/�|M/6�.ڬOR��T� ��R(�6�@.zlM�\"\r��M����L���<��v��e`�=-֢�p5- ~l�B �q&۱>c�6.�|G�ZtM��-����yq�0���mq1q��ʓ�1�� �P���@/�.\0�0��О�/�\"��E�f�4�5\"R9�eo��m�2r#\"c�!rW\$r]D��P|t�T��62+�+�d��F,^�q�E\$ϻ\"��)�#�E�� ��%;%IxZM�Z���)x=�T�FQ&�r�N��y2��.�,.e@dF�2�NK\n�k���dv�2+	̱\$2�l\r�ݒ�I�3/b�2�10��/N-�2��M�1F��ehM�%�8��@��K�#��S\0�F�r�*�*�XKSJm�!\"t	�u�R�N\0�ۆi���Y,	ؐ�<ac6p���Ӑ��.��9���H�cb�H���Ok9����\"�a�4���;S��rI�b�\r�V�\0��CV3�ȯfj�#n]{\0\"r'b��cblQ��g\n�M�1c8C,\0\n���p�Q)��j�*�n��S�#�4!��x\"D\$�\nL\r|զ�_P+�{-�],HT:\$�DƵ����@TjK��4j���?�'�T��B\r�����'Fw���~k�a��p#83�@C#��_��:�,C�pgp��LT>�����T t��� 㰓L,�C����S-��@��Ol��x���;e���B�)� �:iƢ����G=Pu��L�����)Q�I��S�vo�rـ���<�Z�����K��f��C\0C@�J\n���4���.:'�\r�\$:-�Nb�r֐���I���'�}ƺ\r��n`�%ȍ3���e��l�D\r�";break;case"gl":$e="E9�j��g:����P�\\33AAD�y�@�T���l2�\r&����a9\r�1��h2�aB�Q<A'6�XkY�x��̒l�c\n�NF�I��d��1\0��B�M��	���h,�@\nFC1��l7AF#��\n7��4u�&e7B\rƃ�b7�f�S%6P\n\$��ף���]E�FS���'�M\"�c�r5z;d�jQ�0�·[���(��p�% �\n#���	ˇ)�A`�Y��'7T8N6�Bi�R��hGcK��z&�Q\n�rǓ;��T�*��u�Z�\n9M��|~B�%IK\0000�ʨ�\0���ҲCJ*9��¡��s06�H�\"):�\r�~�7C���%p,�|0:FZߊo�J��B��Ԫ���EB+(��6<�*B�8c�5!\r�+dǊ\nRs(�jP@1���@�#\"�(�*�L���(�8\$�Kc,�r0�0�l	%����s]8�����\n43c0z\r��8a�^���]	�jP\\���{\0�(�@��xD��j���2�Ȩx�!�i\$�/�,;\r5S� #���!-��7��+pԷ@U�f���x�\"cx알�07I�P��\r�\\L��\0�<��M�u]��!\r��ھ�B�ҍ�qs\0��O#\"1�v��:O�r�K�P���(�\"�����\\JU�*ǈè�]�e�\$#;63�pЄ:�c���0�߉�4ʨyk\0��(&FJc�&\"�gt�	��p�5�Ӑ��R�J)\\��\$;��7�M�+�\"��&P#(e�+i�6rR!Oem�sr8��,p!�n��oM��'*�B�9;��\n\rCT�A�0��/8�<M�~�2��>��Ir^�\r�@R\r\\�W�>ʴzT.J*�J�{p�#������L�_�j��r�	�\\\n�����]��i�z�w����\$>'e�x��O�m��]>�|��[\0b��#\$Cp쁍�x�/쌝�[D��72�J�qK3ȥ��D��I�w\r=�%��F4\r\n�� xa�	�L�%��C%*(��Tz�RjT;�t�vҜS�����a�\"����f�P�X�:�C��_%!�0��R��+[*����e�z1u4�a]�ؖ�R\\��(�ʢ�b�R\nIJ)e1�:S�,��*��C�y���P '¥'4�\0�OA,6+t���x��ed�	�P��3� CTc�_\$�:%x�MTg�%\$9@�0�Cf4�!c�\0��� \r��3��`A7���%�6�\nqu�N� ��N=lx�4�5��2@�(��AC{�� �`RnM�S?�l���@�H�X)���WH<Y�A�ߠtНd��e��\0��	���� -�_\"�D�!�w���(_��&�l�t�\nY~�)V����O!��L���j�\$3!�Y&�(xK&5���.�dQ?(.49D%�YMHBr1��C?�@#���I�&Q�Y,�'�:\$���H������xVj��㋜�<)�G��Idǉ����C��%R~Q�}V�q�3r�;'W�EIi=�\n�bha�3����YMJ9+lA2�X3HI�;%o��\0�'9�r���V��J̚</+��cM�}D��b>F]f�٦	r��R*\nY!6!*P�HZ!Jv��P�*[�I�B	�H)^;�y� E	��݂)3Z��^�����J/!L�����Pɨp����2�\$r��=ZKi-��]0�Ɗ�н�@��S�n%�W��y��jX��2vS�t��n�Xʼ7�\0�Ԟ�[{qǨ�!�RpCL<� B@��_a�*l `t�M��~��N�*d��Y~ϦS�V_͖3�Zc��ͩ�<��t�}Ո`*9䊾m�:'�̺�8eX�Nvx����*���Vhڛs�ô����(a�ӢK��uZ��jt�MK�xg�쀝�ɪ�{R0(L�k�8.I�?a�H2������1�ף�~Y@z�A+ɔrmt�FU��\$��2��{h���w8JQ�d�P*]��z4ġ���gSc���H9����7��ܺx)\r]\$�6i�j&J\$��P�aP���*��.<L�q]e��*�,�M�s�eI�,4�kv*\n��\0�.�Q�L/�fo�cV�>A��r~1:��FJ}!��ӥe'rV�ڂ� ����%P�ڜx�!�����~r���2���b���)�a�u^������f\\�!�L	۲ÿP�HF̄�0��]�#R9�YfblhW����눘rV�{d�ș4e�}Kzx6{�_AZ�&��Л�\rCQo��&'�`|�M��I�]�gcOC,��/a\r�����g��l��WhJ+D�[?r~]8�w�^Aϔ�l��bզ58R5��?��_��{�PP�`�h���_�jLoN\$#\nt\n���T��C��qL|^c7p�I�qovY��%�4]P9�\"0�r2��& `@X���N8������pX�0]P�nX�0j��1o?m|\$+�/�>Z�������	ˋ	)P�'^�,��~�0�p�j+��\",2h�C8UBn����F�J\"��K����䘔mlC�\n�E��>�'��C򸈫\n�v_�10��jF�o&��H1�*ׂR�O��p�e�\$����D�/��t���-)`,-�IЗ0���dx1S �oK��}\nCqG�2�c@BM>&�E��#pJ�w\0�m,�\r��OVd��!Q��/���v�O��QA�pc�vmp7��I��c�'�ю_B6��*�d��\\1_1��m�G�j(�&(I�٢��q!�)1�%-�!��scq#�2_&�_��{q���p��!�E2X`2,�2bA�h	�&\0�ۭ�_��*���%��8�\0�梆)�B���</\"�)j�B0\0001��}�\$�wq�+/T`�^����Fx*O�|B\$`\r�Vg�i�C6�2b.r�#�h�좺iB,p\n���Z��v�\n���p�N 0�F�C��\$N��)�*\"2#b:@�N�/���YS\n�+�vdr�r��I��\0��H**���c\\�%U	��4�A.�B@�m*�*%�8.nv��7�03�ۣ8�F�<�.(���	�4iTYl���\"@�\0�i�C<<M�R\rӳ</�l\")�S��s>\$M;�?mel�W��+S��o�������4h�h��| BR\$؀ޞ��nZDӮ&C	��>�l1��H�KQ�!B�( �أ+C�3;�:%D��0*�lB)E�<�^�@�/C�-d:\$*%do #���RB�\r�";break;case"he":$e="�J5�\rt��U@ ��a��k���(�ff�P��������<=�R��\rt�]S�F�Rd�~�k�T-t�^q ��`�z�\0�2nI&�A�-yZV\r%��S��`(`1ƃQ��p9��'����K�&cu4���Q��� ��K*�u\r��u�I�Ќ4� MH㖩|���Bjs���=5��.��-���uF�}��D 3�~G=��`1:�F�9�k���)\\���N5�������%�(�n5���sp��r9�B�Q�s0���ZQ�A���>�o���2��Sq��7��#��\"\r:����������4�'�� ��Ģ�ħ�Z���iZ��K[,ס�d,ׯ�6��QZ��.�\\��n3_�	�&�!	3���K��1p�!C��`S5���# �4���@2\r�+�����8�0�c��\r�8@0����#��;�#��7��@8N#����`@M�@�2���D4���9�Ax^;ҁp�)J��\\��{�σ��@��\r��*��7?�px�!��9�RW'�j�� m+^�%q:_b��L��&v3a4j\"7�d�榥H+�#��*��J2!q�|���k�vc��\nf����L�9(j�\r�-���ű����u�Yi��ɯ&'�>'�TN��8����� '\nɮOƆ�k% .����k��8,��!�B<�\$rw\$��9z��=���JD)�\"f!5��]d5��y^G���'ijq�mb\r�����Fs�-z������@���z��{&n8z�gn�s�i�M|\")��rC�����[��cI2!�H;���RnD�G��Υ��wa%ij_��H<=̡WEԥ\\��7\r�I�8���s��rH����h���:\n���#�2JM� 2b@���=yu�n�z�!am/)ʯ�M�18�3B5EQ�u!IR��-L{���N����:V5(|�!,Y:�ժ!\$k�rpb%]Ґ7N�R�x����c2f9;D��,��T:�Qj5G�&�^ڙ<jqO�<~���@\n�S�Jb�;p\0b���C#����L�Z�&���X��CjY.X��\"N�{ \n���&G��t\r��#���A�2�@����a�2�p�c l\r�*F�v=��6\0ơ�!��64]\"��F��@Hr5� \n (\0PR�LGc�|4\0�C�M27���C�i=a�6���{�8 K��1��ڀ��(PA��^Lȃ+ql荒ܛ�|L��>�)���yOi�?�%��@ir)�uOd�a�:�\$��C�\$\r��\"^ML�70L���C	)/XS�z/bDR�4(Ի�n�hH�E�%b8�b)=%��!���Nk5c��j(�2�\$�f%9�C��P	�L*O�8IHq� n���{ȊJ�4\rQ�E\$`��+�zc�[�*�q�\"�NB0T�����h�p��/UY���Z��H3��5'�ª�'!�y��~`�{�,���]�]u��-Bp�YY�7D\r��B�È��I�OW��8(�D��z����	9m����&;iA\r�����U���2�\\��i��k)*�7�t�P�/C-���`�9�!6����a���̵9�R�3#��^Lɹ;SI�͉�(M�r4n�+r���6�H;��Ѝ��{�1�`մ���t��13w�Պ�@`R`�����2VMY��X�:�rXQpnK�I��8I��0�.��s^t+�0\\����u�X9Uv��x�	\0�a�ár!0�*f/�+]o�=�FLױc*Z�I\"!P*��t]��Aⱉh�.@_���e�C1e��H�LB�*����N3�Dq	�ffF�Y�'\rЇ��2����-I1g��ڑ�!���.W�L��╔3��c�5QXLl�.�aOXQ���i5��PB,1���fSH	j%:�M����k�ĵ\$�`饂�r�#w�a�/sLQkD䮿.�m�0-�����s�RZΩ˚��6��Ϙ���.H4���;ت`w���և|�Ĭ&��� ���|Z�l�_�F�m��p=�M�:�GA7��jǓő:)�)\0��\\!��*��fe���=�&�(_\nk�����H�z�l���s#��f�yե獐�#�)h�OJ�\r�}J�4�?C��j���l�vė�Po�B2U����N1��pI����{���&�~�,�Lm%\"�g�m��ehU�Ob#��ei��\$8���X\\��y-��^g����}WzQ�M�[J�̪��\"9˾������Z��Rg�s;C�e\ra\$'���=����O�n�trR=k+4��2M��!07\\��}~�h~������7��6�~����D�#{iWF�c�J����{���Ϣ@��&���ꯈ�/Y����e������s�I��7��p �\r��F���͢]���F 9���\rк���PX������*��M��C��\$J-l`Ĩ1�N�F,��f��{���	.��f:��́\n�0aN5�D�ʊk�-nF��,'fj5�Z:��(����`��\r��ꏐ����\r6���H�h�����H��E*��Ȋ4�BvB���v8oC�e�vO ��q�����n�`��-�t.���0*\"��d�FL\r���C\$E*4u\"%��vB@�c:��-Ct!�<1�j0'c�\\��|�CW\"Lr02ExЌ�ߦ6��jُ�]��H���aQ�g��\0,>�\r���*�l:��cOQ�����g���miF�9&'�m�|��!O���:#q�\n�y\"��>a� �MjOkK\\���G�n�-����.�!q� �#�<H�L!0�\r��;����AЄ��a�D�kLr�";break;case"hu":$e="B4�����e7���P�\\33\r�5	��d8NF0Q8�m�C|��e6kiL � 0��CT�\\\n Č'�LMBl4�fj�MRr2�X)\no9��D����:OF�\\�@\nFC1��l7AL5� �\n�L��Lt�n1�eJ��7)��F�)�\n!aOL5���x��L�sT��V�\r�*DAq2Q�Ǚ�d�u'c-L� 8�'cI�'���Χ!��!4Pd&�nM�J�6�A����p�<W>do6N����\n���\"a�}�c1�=]��\n*J�Un\\t�(;�1�(6B��5��x�73��7�I��������������`A\n�C(�Ø�7�,[5�{�\r�P��\$I�4���&(.������#��*��;�z:H����(�X��CT���f	IC\r+'<�P�lBP���\"���=A\0�K�j�	#q�C�v8A�P�1�l,D7���8��Z;�,�O?6��;�� X��Ф��D4���9�Ax^;�p���pl3��@^8RT��2��\r�cZ���`��Dcpx�!�n*#��6\$�P�:C�֕1�����JR&Y���0��ς(��6��q����M\rI\n�����7=�xJ2 ɠ��w��2��:B{\rh1Z8�c&ʌ����#�a���\"��mc跈�(�0��H@;#`�2�B[f����ì1�2�֜�:�3ʨ�b��O��9\rťI��7.x�޼�c[7F�\\�8DW2mJ�<)c�)9�R68n(@9�c�i\n\"e\"9n������2�}/�h��u�7m���|U��]���)�	��j�k�p�D��i6(6M��3�#�{��#l�gh�x�<vxC�/�6�s�uW��y �\ry��܀RR�4�E�֍�0̠!I�d�L���7��FgS�A�O|7��\r/j)��0����Cv42��RM��Aث�5�B\0C\naH#\0���`���\"�<���|�\n|�\0�4�@�^��Yf��\$*�Op H��)pƉsJaM)�<��Tʠ;��XB�prV\nȒ!v:��>��B,u�q��k&H��l��tR�T��֛H9�A��s�VaڴjMJ��pJ@d��d���>�U�T�U�H��r�C�!Et���.H���)-5~2ta�J#!����D��[!\$2�IZ�X��r�U��Z5���7ʾ1�3d�1���cp�2�`�B�L4pna���7�/�c�Q�h�Ӽd�\0c�'\$4���M�qw/0�F��*a�y��fM��2�fá�^B�^�2�A\0P	BvG	�͎\\�)��9��n�!\n���OfmM��w\$�'�a2P1r�\n\n�e�C� eva�AI�sV�� �4��s�J�:�s��A\r!�P��8YE\r����dJѝKs�7��쳩 [m�I�\nV�iIHL���\"M:uF��<��:pH)H,�9��̂�3U�u5�CN�V��e���E�Z�\n<)�B`��	\\B٭��\nm�N(�����cdr�I�ʳ�\"��=��\r��Uj1T0@��2��r�\0�(#v_����e^�N#U���d�K~���O�PW�9mx��l|΍�a,,7��Mc�Y�my�BzBCgL\$83�|�Y	IMs��9�V㒈l\$���i��I�aʖ�\0�)ڥ=�&�S���3�`7�&Y�0��y0����	�w�t7�����y�f�7����l�a��j�\r �<��j�S�\n����k2c8G�fx�V+u,��\\큟�2�(��kH�LR�	 b<��NR�`���܎�����@\n	-QJ���Òq�������<.�Гs`E�\r�����@\r�A#G�L�hwH��\\� ٛ潋��=�l#C�b��.��3��D]8JL����ٓf���*@��@ �y��=:�4Ã��G�4�m�YWV�h�v��Ay_`\$X90��73sA�l�v�x��-�\"��':X;,R��\n���VU.!2V���Bw�Hޅ_{��w��ߥ��G��.�ۜ\"�4�^����(w��w��!��B��Q*m���r������ln*xo\"F��F��[�14n�`���\n�J&D���d\$�)���e�i(F���^��1>�ʋp)��>�Bw���,��j\0PC;�%MmR)bCk�����W5�de�KG3t����<�/\"�J��%a��Js��.=�\\~w!yo@A�ٍ��T���7�}Y9���uFSk=�[sK̤Fm�W3�&'�T��z@�pA/�v��\$�JV�9F��Dy�a\n5���H�L�l%�g���'�g�������AM�ܹ��^�1!)ŧn�g��^Fb#�aH��P(�Rί�'4�,, �P���L(�E#�l/�OI�TqT����ρ q/jOBl<&\r0?-bc���b����(�.0f~�Z�p���n\0����� ��Ce�X��n��L8�ι\n˜���Om���0��pL����+�\nipCk�O�.���\n/C0b�P�w��`�R�cRnFƪj�����lb�R���X�N���H�.�'6+I�������\r&-����'0'L��~�#�aa���͆tr���PY\rQx)/^ïbdS��%o�[q�LVx1tM������Ml�1|��3���/~�����l;��#��Zq��+@�N~�����LBN2�����3��+o*Z�i�� ��ё~��A��rgo�����\$�\r�еL^�/�w�I���\"�2 ���þ\n˰C�(�%�*�~�M:N�'�*\$2n�pW�Y'�@+{KX�\n���)#��)\r4�rRq�F����*�d�Mz*�g'1�*�vJ�|�r��,2�J�g!�X?`�3q�	d�P�o��j��%�V��`%�;,f��ʵF/��/�dc�0�2���31b~�.�{R�@��%o�_l1�`/>�Q	.4K�nJ�M�4sU	T�%�\r�V��̱\$HP�Xe�Z��z����Q�n�v�*���\n���Z,��P�o'�vD�?�:ˉ;\";p�;�i;�#�@\$BH\$Ff��n�^&/fF�\"��\0�LaB����\$0��-\"~���:��81.�㺪�Af/!L\"�<&��\r�fW��P�uB�V=�;z@4;�J��H����M��t�`�0��s��ː6��sɃG.�Gb|\"�9G�H2��e�8�\n5Iv ���:NLధyH#�\"�g��-�+l�j&�	���`��F���<l�t&�%ƣqj���O��u��JfZ #��?/H��/\0�5e��TgN�3\"�4y.��Hb�2If�Q�+M\"�h��I��6B�-a8+ �/�~bH�h3��-af�͢@�\r�";break;case"id":$e="A7\"Ʉ�i7�BQp�� 9�����A8N�i��g:���@��e9�'1p(�e9�NRiD��0���I�*70#d�@%9����L�@t�A�P)l�`1ƃQ��p9��3||+6bU�t0�͒Ҝ��f)�Nf������S+Դ�o:�\r��@n7�#I��l2������:c����>㘺M��p*���4Sq�����7hA�]��l�7���c'������'�D�\$��H�4�U7�z��o9KH��>:� �#��<���2�4&�ݖX���̀�R\$������:�P�0�ˀ�! #��z;\0�K��Ѝ�rP���=��r�:�#d�BjV:�q�n�	@ڜ��P�2\r�BP���� ��l���#c�1��t���V��KF�J,�V9��@��4C(��C@�:�t���(r(ܔ�@���z29̓0^)���1�@��G���|���Ғ� P�O�H�B������V˻�Z��.@P�7D	2e���ޢ!(ȓK�h�7���%#��c�0�\$�3m���!\0�:C�՜\"M��6#c��6�(N�#@#\$#:�!�jGy�p��l��r�5���ۯ��끵�����	��)�(ֈ�h��Ӹ��Z�[0��C�֔!�J)�\"`1Gj��`5euT5�J9�c,~��.q�9��s�m-B(2��09�BKV�V؜��Y�7�\r�]���\" ���rB�;�1�x�3-3�Z%��.*\r��<�	�)ʣ5�Y#:9��0�h@A�XH�ی�@����r��b��#)�b ��\0�4��n���&9\r�H��Z��7Beʱo\no��2�S!��D�1�Ȥ�51Sl�8�s��<�s���T ���-���a��.�=1M.���ŌK������w�qJ[Dr=D�V�ͣ'B�bnN	�:'d𞃺|H�M@�%�O��?�]F0|Ӄ��Z/�R8R��[�����6�]b@W�/b�يWd�����rRR�.��Ȋ(udua�CBL��TQ\r����\r8���@��*���V'�۞-�E��Ų@P'�}�HZN�AH.t��Z�*o��&�e��eXmL:sJ��>\r��AЂ���P0�4C����#)QŔF�CqԄ�2��i%H��9B���i��:�\"JfJ�����VS��5R�5���OI�9t'H93CHk(Ԗ��LA;Xr!�^iShq](��wL���#�]d�ɾM�ɚ=Dh��\0�£EtBbz]Ae,�\"�baA'���6���C�n���L�bR4�f��,��P�#�e1�H\0@e�F\n����3��!4�C�A��HC�[��U��p \n�@\"�@U@\"���Q�PN-�������C�u��RS�j\n�M�4�C/NeQ��*0rBtN��%�m��=%\n]t��!�rvbΡ�]�}�����)�f�	�Re�0AX�:��r\nĢ��h<Y�bQ�ƈ�R�M\"�0���t}Q1#)��c���e��yK�<� ���{�U�����W9=�T�4�P��y�@��jZ&wّ��D��Ӑs���U�A���NJ�di1��w�2=��E��ο��*��w�B4���!\n�ƚ�&���G���`�BH����c�zLI�BF���F�%S)����&WFP����e	�r���48��'��A�J��[�\nd��\\#�v�͡@%�7c\n��Z���%,��xN�H�l�r\"xIF9ّ���H��1&��J����%4H��R��3�G������4�+:1k7՛�\n��H�k�4�Pt��]\$S�h/��\\�h�Nj�W9=����U�Nv9@�Еv����\r'�RW��q�U�e��=M`\\��׺�}�UY�u��!���[U�}�Du+U`�L;���B�hr*Ń0=%�wj�	�q�յ֙�{R�]���i7���g��f\n\rc#঵3�bѧ���ʓ`W;\\8V�\$zvg�p�^xy��{�f5n1�8��'{�U�D�\rn.�F^��ౡGXx���|t���.����q~u[}8�{�onKίE;u=�����]2M���3�3J	�`d܎�R�A�\0j�5�b��~�m�3&7���8?צ�ٻ[Ϫ�Fm��Z:����t5�s���43�ͯ!F�����iϺ6=��p΁t<q��|/f�B�մw�5��[��\$�霓����<�-f��؂6}�M\\sB�x��dH�q��ՙ��ū�8��������oe��[���������̝���S�}��=�i��|+����у-'y_?M���:\r7���k��c�<�bJ�P\0�Ȃ�`W�B/\\̤X_���T��\$�m��\"�Ld؎�����`�L\0�FĪ�9,T�C6��ʠ���.�E�.�	^;��L`��B`lzd\r�Vb�b,,�@\\��4F�\r����K�Z�Lu�Ȉ\n���Z��7���c&�������4�j	��\nL\0c��D�Ӣ�;e��c&�\"x#�8Ȣ,7\"@fE~(��W�Z	�ޣ���C�:�(��H� �HB�]��K��(~��v,B�d��*l&,�QZ�N�&&�����qs�\r��*~\r�t�N�U�DE��\n\n�'Lkj|�0��t��a�jb\r���^�J�ŋ&J@�j�E�/�\0�#�dc�&1�0n�߱V@��BH�hJ�N@ qc�CZ\nk�5��E\0�2�B���AƲa�A�1(�?d!\0��� ";break;case"it":$e="S4�Χ#x�%���(�a9@L&�)��o����l2�\r��p�\"u9��1qp(�a��b�㙦I!6�NsY�f7��Xj�\0��B��c���H 2�NgC,�Z0��cA��n8���S|\\o���&��N�&(܂ZM7�\r1��I�b2�M��s:�\$Ɠ9�ZY7�D�	�C#\"'j	�� ���!���4Nz��S����fʠ 1�����c0���x-T�E%�� �����\n\"�&V��3��Nw⩸�#;�pPC������h�EB�b�����)�4�M%�>W8�2��(��B#L�=����*�P��@�8�7���g��^�2Ó�����t9��@���u\0#�@�O�\0&\r�RJ80I�܊���6�l27���4c��#�#�ù�`ҮQS��X��Ɍ�G�C X���9�0z\r��8a�^��\\0��ʴ�z*��L�J0|6��3-	�v��x�%��T޺C��)��-,�-�M4�*c�\\: k��/��8��K���5���6/�r�;#�3\r�P��\r�r��\0�<��M�eY��7��\"�\n�L�i�����+X�4[��4�#��#�C`�\0\nu�b�/�3yؠP�3��C|@����8��P�0��R�����-�ph�Č��F�*6�\0^սj��#�nd�\"0)�\"`0�L+���5ei*.qXU�k�1��Ї4T�2����q+@�6ΰ�H�%K��9ꚶ�2���iyЈ!NA|/�\\<�2H�B7��3���+	l\r��t<��D�Ì�PAj�Ü��o���e� \r�p�aJZ*\r�Z*b��#)�-�4�Ap@)�[8�W^�4�s��.J��2���jܤ�������(�5t`��&�p�G܃1���5�̬��5M�t�9N����Oc��?�Ke7P���N�T�&��	�<E��t���䚦)v�Y�:*�@����O�p\r)�2:g���JkM��8�4�ӺyGo���}ɩ\$P��@��p>(��\n���hI˚q�\$t�	hL\$'����O��0���2>J�1U[�)7Ζ�.�d�<b(�Cf�i!���G#�K!�4�vD�\n��Hݖ���J��+Й��pȱ�	�ĥ2�HX�r���(����Y� �`RLZ�\$\r!���І��,NJ&����@g�KY5f��\$�nük��0��C]xQƚ�H�R{�\$��E\\��2&K����R<S���t�7.A\$L?/�L4�`���1�Q)I#��\n�I&D����C������1�:Ak̃I\n^PƵR�d���L��4Hʝ�B�0Rt�\r48�n�d�[�}֗�Л�I�/F���ΪX�M�fSF�S�RYF02��P\nm�RC����\\3��Rt\$;%�I�*�9#�nU�ac�<'\0� A\n��TЈB`E�e�\nF�����]K�)\n��.�қaA�|U�Z��?9',)��`�\r}vv��P�ڮ�*J��X*J�,W#gM�MT6��ʜ�,�P�rp΁ \r��;�~M@PV\"�##^\\�0V0Q��'W@�%C��BHhV���y/��ܑ@um�y6���KԖ>�5ꉀ�I|�W� �Ѯ���UH��Q��P�hcY��\n�\\��^�S;VJ�]^�\n��<@>J;�v�/S6`����c	+�+`���=T??������6d�ʾ�u�i�FQ�b��Ăt�y���r�B�T!\$	�DL�ߜ�\"D��Tt��2�.���x/d��³�)�?�^L�ZBF�N=0M�'��Ƴ�4��f��ݲnOǘ�*eb��Xʊ�d�\$���N�M[���Z�h��K?2g|���{�0�\$e,���+���:���\0003y��#�@�CHy�k�0G�ȱ)����X�KA8t��p��ZӶ�H�;i��H*�DޥJ�*� �K]�K�E���\n��Vy{BnX'E_��t��n��N8��Z6�ۚ���#��/<�{d�9{��TE�˫cw��ռˁV�|(���-�\"1�5���J�Ѕd5UEdp�\n������xs�%���r��=S�]m��z.j�\r�(.��U)���Yy����0Œ=�\09݄����NB�u@C�(h)a�vn:Z������v�h	騹 �H���g1y�-DL�U	nM\0`-�u�k ��\0�V��ȗq�N��v��n'q�Ts�t�����#EL�f(��Iܴ�T�G�h9)�8�h�T=VHs�' 0�uoj��Ҝ?�f�RI�׈��W������9D7�Z1~�I��NJ�Z�%`�(0�w�v����|��|�\0�;�%�\n�iϧ�[�!�����F:\0���2�rej���?���+q�o;�k�î����n���p���%�\n뮆vO�g���d�.D����R��#��o�3K<�p2uP��@\$p�������d��͵Lx��.�k�\n����laD\"-����Dn��MQ	F&��f	t?�Oj���l��\nux`��>��&׍��о �>��<b����B�Y�\"��-�\0�i��B�#�]KP�H*CNq��bX\"�1c��y\$0�N�Wż���(~c�\r�V���8�-����� �Z��()�%	�QJ�\n���p=�r/G�%��1����˭\n-(�&I��h�f�ޢ`\$bJ\$�hf���gPW+Gf����J�L#nD���*b0]�� ޥ%��p%��ÞDDl/��&B��#����f�V�v\$�0VNb�,��%�C�I *�i# H����1\"\n8�R\"K�\"���݈��b@5c(��si�7d��hޒ66�^A�F|Gq��q��M�%�0�+%rz�6��F�g�c�¬Ҵ\$��aJ1%j�\"�S*Ԓ�, ��®06r\nj��\r��q��ή�����/#\n0@�\"\$B���U��c�p������	\0�@�	�t\n`�";break;case"ja":$e="�W'�\nc���/�ɘ2-޼O���ᙘ@�S��N4UƂP�ԑ�\\}%QGq�B\r[^G0e<	�&��0S�8�r�&����#A�PKY}t ��Q�\$��I�+ܪ�Õ8��B0��<���h5\r��S�R�9P�:�aKI �T\n\n>��Ygn4\n�T:Shi�1zR��xL&���g`�ɼ� 4N�Q�� 8�'cI��g2��My��d0�5�CA�tt0����S�~���9�����s��=��O�\\�������t\\��m��t�T��BЪOsW��:QP\n�p���p@2�C��99�#��ʃu��t �*!)��Ä7cH�9�1,C�d��D��*XE)�.R����H�r�\n� ��T��E�?�i	DG)<E��:�A��A�\$rs�q�P�(��,#���SJe��H��##�z�A�2��*�r��\\��yX*�zX��M�2J�#���PB�6�#t�{r֍�@9�ÄO#���#p�4Â�#�X;�.#MR6��;�c X�h�9�0z\r��8a�^���\\0�t�Ac8^2��x�]W����J�|6�me*3Ack�\r��^0��b9)L��zS�gI\0�#��8R�d��D���h��l\n�@��>��%\ns�erW��8s0�0�Cu*3�h��L��{Ųt���h䕚�`U�Q�䬆s�\0M��t�%��E?'I,Q�~t��q��R�9hQ9��vs�|�^�q��F⬤V[kD\"{�9�6t���J�\$Y+���P�:��cw���7B��&f��=H&Y�,E����W��+Jq���F\"s�|�A�ؗG8]2c�<o+�}߷�zT/��@����\",�-w��8�t�r�Io�vA���=G@P���V�\r����4�e�\r�0�k^�d��#�Fr*\r�}�7!\0��5P3p\0��:�j��?P��\n�(��(�������#G0�dU0��2<Ji�A�S9D3h�uܩ\r܃6�8��q)O��CR����O�T��%�B�h��E.�MB�X�!e,Ŝ��ԉ1l����P�t^�Fު���^�]��>݄Cf�@�	�t�Ґ� �6��xA���:�4���m�5X�(��Ú�W�<\0ұ .X\n),u���j�Z!�i�U-��[�m-�B��\"�	!�8`ڷ�i�HKul���!�u)������q�A��#�&'�\$�#�Ia|��\"�=\"�T>5��1\"0@� F�c�(�-�Xa�9O��O\$_��+C�n�A�a�[�\0�&%�i!�9�Q(G(���T�!�	�0�\$�����>��:*:(�D��:2G�a+Io�f��i������!�5,��7f�؛3jm�++TA�:���#�\r�ޤ�aq ����G�Y�@_OU��o�x��\"�\r����\"�YXw8��4K���L�8t�ꬎcC��T�Q+�ED��\"8G�t�-�\"�L:��I��l�� ��&���%6d,���%D��H�y|!�4��\\���n��,@�Mʞ�(6����i@����*S���9�@'�0���U�%��n H`��\$�GǠ��YMB��U7�QNP@��x:@�hv��]�X�L�����w����Z��uWp@�` �EZ��PU���EG��S� ՠ��)��o�Q\n)ګi����P�*P��\0D�0\"���Zm��	���Λ�w>��W�by�A�G4\\%�)\n�˕b\r���H��s������1����\"#v�nOd�촷j&�ݛ�������I3�d%P���ږ�Y��Q`]DP��(Z�R4qR<Mi�V(�P�tB�QJ,/P�}Q����D�G����=���`\$F2ƌ1�D�S}�.��r�Z`��9 #\$u\n|���P�C�T`B\r�%����QuktE�5��/&�t,M��ҔŔng.���U�.Wvp�!�u��\"9\\���ot�<A�xK�\\��/;8�	��/w{b0N�@��R�8G��4�tӢX��X�*��A|�2CYm�p�g\nL�G�X8*db�\n�`ʁ\0/@��n��)\0 D:H;<c`h 3w��H)��H1�]���( ��g���vY����a|�b�h=���@J�S�(;��QJ�˦��F�4��ʵ]�hA�j ���BQ5��������5<(�A\\2�\$��<�F)�X��#h���#�;�1@-�Y���ֹ����h@��*8�/�X�AZ��0��G�7�D�;@�F*��͢ڤ����tŘǜLM(곢\$o��)�2�0�\0x�0G>������@� �0\$g��>d0.�p2yL��N.H�LL�h���\$��Nb��(�#��gO�6׍D��8�G_�o�gpX�M޲*bp>\"-�݆6fL��Tn���Z/\$�#\r.儨�GX�#�>P�͌����\nd��o�B �6�L�а�z��s�G��0��P�-�0�\"�����*�u�K�\r��p����q	�	\r��b>u�����/��\0���M�p�#��\rax\$�K-���6b\$X�A 0�1�d&��\$ާ��4ȣ�>����d�qv��� �<1W�:\"�,	�G1�#�	\n6�������g��\r�u�@u\r*ކ�s��F�-�aQ^m�ܤ���p� 1Z�0= ��ܒ���EQ���I\0]!��?R rA��.�jA�C(�^��c� y���g.:1Nqf��!G��9'.�ގG�2y�xrF���!#jl}H�K-B̭�첐ɦ7m�r�#�*�d\rPY\nd�*����0!�1-1Q\"��,��.<��..�-ϧ)�g-�b�F�i�x*�RG�\\_!m,�1\$�1q2ua}��d	b� �&�H���wu*�v��nw!3�\"�,�+6E��)�j\"���G\$��-����NPF��*76�o72L�'>��,��/ �{��k�\r �\rd4@�Z��\n���޶��~�j9��گ�<�j��\0��Z*�khUC��s�xg|t�^10��+>�����cF9�\\�!G)�1����&��2xa%Bc\"2b����4&�.B^�����5D���QE��=�9D-@'�7/O�� �<o�شG�~�8Q��'Hb0a�oT�@o\$�8��-�HG�\"R9�0\n�.7CR5j�[�4�R��贃���3�k\r�C���t�%�	M�O�콋�3Bɠ\n�J��\r�l����DV�|y�JB���^:f\"���.�O�Ef�p����\n��oB�UԞot����Ġ�6C�t�>2�k&2�PʳEŏ��!";break;case"ka":$e="�A� 	n\0��%`	�j���ᙘ@s@��1��#�		�(�0��\0���T0��V�����4��]A�����C%�P�jX�P����\n9��=A�`�h�Js!O���­A�G�	�,�I#�� 	itA�g�\0P�b2��a��s@U\\)�]�'V@�h]�'�I��.%��ڳ��:Bă�� �UM@T��z�ƕ�duS�*w����y��yO��d�(��OƐNo�<�h�t�2>\\r��֥����;�7HP<�6�%�I��m�s�wi\\�:���\r�P���3ZH>���{�A��:���P\"9 jt�>���M�s��<�.ΚJ��l��*-;�����XK�Ú��\$����,��v��Hf�1K2��\$�;Z�?��(IܘL(�vN�/�^�#�3*���J��*\$j�?��`��N:=3AprR�\"r���\n����r��I��:��R���,�A�jsZ�N�s�;�j�\0ԭ�<C@N��L�t��7Ml^��j��k2NNHm��Ðl��a\0�2\r�H�2�Am6���D�ޣ��'t�Z�R��n�\$��R�H!��\r��3��:����x�w��\r�aX�p�9�x�7��9�c��2��@*Mx���x�8*�D�1��v�󋮝�\r�o�l�4�P�6��͎ݵ����8��;��	�Z�N�z9^�ͺ8�OsN�J���d0�J2\$���8��g��N4�F��J����(�I;[8�)>4����G8�Ʃ�e\$p���u;A�*#Rַ4�k���I��;��=+�	;�+H��G��N�o�\r���il����D%,�h�P�����)U_X���1A��A�)˾�jTȏq�*JO�+��d�e*��k>`��}�|�9)�*)�\"e��'|�g�@R=�9Ыw�w�Eo�oJj��s�zQg�G�^�z�~Uc,G\n�4��G�r�}�a�T�Y���G�J�Z\naۻ����By��藗�n�;qN�9��8\0���C!�:'眉�(�L�#D���+2����%a\rރ�ͦ£�+��of�Ĝ���G��P'i9X����\$�������<u��4�Jn��fS���R�l��/)� ���!\0uL�LF��4uDx��5���a�mp�̓s��TnC�����)�̀�u�|IBG�i*K���Xk5Iw��ġsI��Ө�a�iB��Bʆu��G[ˁq.E̺R�]��y,V����_��7���L�`�\"%���n��C�����NY�*���G���uHq��F��.JNeU Ȗ\\�\"yglJb@���)�r��5��@\"�h�\$��e[>I9ז�Z0L5¸�*�]+�v���eR�^��}����s�+�9�����T�r��n�S&-�~|+e���a�:��� ����4�+\$�ӣ�Y�kwp�X���'T��z�)5��	�_E�:q�{j�1#�>��5Y?Պ\"\r\r�U��P\rY���C�G��,)5�IINP�\rAr�]��X^q�T�������'lI>���Y	XR�����A_&�Qê6��\rxu��-Õ0���&��2���W�lD�+�X�oQB ��եQL��]�\\���\n�<��>ar� �٤;M�4���Xɤ%'�#�h�+r8���jN��%���\"�*f���b�[�E�v�����99A�b��Qf;�&��qGj��r��sO�P��r�{r�ω8q��d�Ė�9x��i?\n<)�J���}~rPԒ�+�m��4�0|���n��Xl�c	�|*�>Cȹg[��IܝI}yn�d�NS�V���棓O)�gǭ\"�7�G��'w�`��5��P���&u��F.��f�\0�\$�A��s<�;?0�� ��G�K�3��|O�B�(YJ5/WQ��rT`��7681f�'��&���Vw��54�pw�ɛ&�֓Hm�˧LG�e�)[Q���r�\r\"d7T\"��2i�!��奕�L��2��3�_|���S��l^MԦ�u���5��X'{����F��'bȪ[RW�6�p�̒�ꯃU)����q�'�/c���T�(7�J�U��<ш�Ѣ9�&�������L�w�v�P��p�!��>dS��o�Y۬���K��\n<�U���2�n/��n��T&�#���l�Φ v�)�|�Q;�ꓝgԦMSe��aMO���E[�d��(�f��N?|v��޹}J ݡv�)��֘�|���i�b;��f�ё���B�T!\$=�8�0�c����Y�h:|<}k<���Q���V3���+���!R��Z�bW����o���Lg�|����U�m�7]\0�'�j}����XE��e�\$\n�����Ϣߊ�f����l���lŮ���\"��\"v+�⎜�N�Nf���6v�&F�V�\"��2�*,=��/+�(|	�8�4}p+�T�l\0�l�M4�	�E��F��J�F��p�����꼨tN��)�h�J���	�N��=��NM��� �ʪ9�~�,&�\n86���vc�\\�b\0���Je�z�����\\4�_�V�����飐7�ҝ�f�������j�m�ړ��K8n\$l�Cw����i�9B�\"0Rj�.� t��\$�Rp�.�����?�r�j�y\r��2(��e��(,N��4��N�l1%�\$ P�g�g�1 ��}M����t�����i8�M�(�j����)1J�*�(���Ѵ�0v����(����.��dΊ�7qv���p��ދ���.&֮�u��\$�6Q�|D��B�\"�T챁fq�;\"n֝��E�ܫ媋\$����'��c{\$�\$��Ӭ���PDӮ�'p��o�n���r����_�7'��AJ��q��G~�k��\$p0b/��������Rц�-���L&�<\$�@hRhn2�(�����S%~ж��p�B8��OD�\n|���\r��\"�i�d\n/R3�|����\$B����1n�'N�pޱQ�3O8[�\"�#S\"�K5��'%s6�O5�.Z�u��4Sk8pxS`u����r(��ӆ�sR?���%�\\v�8֯��q���~ڤ�O;�J��mt�J��7�es ���S� �y2JQ� l�?�@#ӌ4�'�Z��e�ͤ�?R���9�]r�l��(A5d�����T+C��۲�&��s3�\0mkID(��p�2S3��xj���KFP!��8�=6�gGT�C��A����I4��Q��+3�6�9q>�������AP�?�J��Z��S���LԼr��1�(`?�8�B�� T�>2;�\0�p}0vvfA�D%�NuP�5Zys�O�P���uMRHR��G��2�<�j~�u�&�3�1���hZ\r�W\n�b��v�D�(�C�g�V���(JuS:)�&eb�\n����p��B�,�N(��htt0�A���L�(�ʺ�Ɏ�Kn�u<�LN��(r�����8c.YPC���Q4Y���F�m5RT��U��u��!�r�I�Av�v���s&�\0j��5ި�b�<'ij�N��ԬL�4n�X��5Z�%�(K�A��Qό&����*�G�d��x���ͪӵ��'tlݴp�y\r�\"�W��To+.�\$�1in�+��p(�1f@���i���r�Pr���Й[i\0ZT6���Q�+Q�:�7n5+]De�h��{W��5�v�B�Zf��T:��hB�jL(���.=���3ʍ�u�?\n+���s�[VM7s��B��&����F�|I8ێUj6.���ň��\r*a\"'�q���`u,d�\"Rou�rn�+&j\0��8�4��,ڋ��";break;case"ko":$e="�E��dH�ڕL@����؊Z��h�R�?	E�30�شD���c�:��!#�t+�B�u�Ӑd��<�LJ����N\$�H��iBvr�Z��2X�\\,S�\n�%�ɖ��\n�؞VA�*zc�*��D���0��cA��n8ȡ�R`�M�i��XZ:�	J���>��]��ñN������,�	�v%�qU�Y7�D�	�� 7����i6L�S���:�����h4�N���P +�[�G�bu,�ݔ#������^�hA?�IR���(�X E=i��g̫z	��[*K��XvEH*��[b;��\0�9Cx䠈�K�ܪm�%\rл^��@2�(�9�#|N��ec*O\rvZ�H/�ZX�Q�U)q:����O��ă�|F�\n��BZ�!�\$�J��B&�zvP�GYM�e�u�2�v�ğ(Ȳ��+Ȳ�|��E�*N��a0@�E�P'a8^%ɝ#@�s��2\r���{x�\r�@9�#�%Q#��E�@0ӎ#�0�mx�4��MP�փ��	�`@V@�2���D4���9�Ax^;ځp�LSP�\$3��(���~9�xD��l\$׾�4\$6��H��}J��Q0BXGři\$��\0��4�x.Ya(9[�/9NF&%\$�\n��7>�8挌�9`�O\$U\nK�3��v���T�nT��YL��1:�>B%�0��eD;#`�2��!@v�rTF��,H��2�dL|U	�@꒧Y@V/��D?��̈́ű|c�\$�ʡA�h\n��(��C��0�Ϙ�&<�RZP;Lf�<s��=���-x6���iRe9�sr�=�tOk��ߔQ�߅�����\\#��4����}�6�1Q)�c�w�w��*Jܪ�ˁB\"�/����M;SW���3\r��Y@PK3�M�`P�7�W��<��N:�U`͢�`�ϰsXA�9?@��	�(�U2�����������!�0��0�i�X��@HS1.�v\n2P\"��:P�?���%_[�\n����������K����*E�M�CV��J�Y�=h�5���2�Kqo�:�C��\\��/�����TB��B���ǡwХK\0�\"r���,@\\!�_,�iX�D匲R�Y�Ai-@�nA�m�վ�2(EK�t��\r�m[��4�2%R�d��XֻpA��Uƨ�BD�*L��Tǘ`B���\r�T�T�lo��ˠ��S%!�@�7��#�o��\0 �nq���Ta�U\0�\"�Xii!��	��x�I/���#Z̈\n\n (i�t�\0(*����)`�h��<'�A�,���`����c�*�ZCln\r�ed��9CzrU��A�;Ҩ-D�T�q�)Y���a�V�p���N:�\r������(w9�4K\0��` ���׸0�Nx�K�|�y�3)(�t�L������/4�@�!��\\�9}MHc�'tPBI/|2�JlU�\r���ՎZXsTA��؉&T�IA���+Y�L	�(!@'�0�y�p�OT4u�B�+\n��\"�ҙ`�-�T)�<����;!�H��X�QNQ_����&)�\${�&��84p_��U�j��\0���\0f�\0�۫\0�(+�d��S�xf��A�	��2.X���}�6f��p \n�@\"�@V\"�����qH��1�*��X�G�u����t�y�h�A��V����qN���OOE,9s9oa�͸�>=7A`!��u���������5;1�ՇrO=�c�0���������*��JA)\r̝\"q�P?��+�@J�� tv�y�U!��\0����K��ڢ\"��v�LY�\r!�Q�OZ`S��R��~�T�3���FJm�(w`,\r�<F%1`�\$�B<�b�]#/���F����a�\$v_����l�\0]���6e���)�(e���q)��[@ur]GT���ز L�'���J7y��`�BHa��>Ǎ}���Y_����\r���r�A\0/��N±HoD&W�_x�{����q�{��\$�5Z.Z�S��m�\\��G��7�&��b=ʹ6@�\$���쌑���&1�ե���ZKɊ;,�^��CC^��K����#^\n�1P��A��t�4�]R�K�����1T�@��]�<�\$c�:m'�2��f���&�Lʙr���vY(Nt�d����3��q�ķ`�Ddޱ&)�؞�{�h�_��4ڻ\r��F昇��>����I��_ɰ��<l4bS[i1�~\\Qf.��z�D8!�1�w2Q��_�����_�(�o�����n�r���|S��~��:�a�PĤ�\$����G�Ȥ��̒?o��0ˬ���MnFd���*�T�춸0 ������N<4��̣\0��{�����m���N�*۰\\*fJ�O��Z��J�M��Bs��m�����t��Дذ��By*!O�/�s'pN<��Z%b���gFx\$�h��&Kd�K\0,��������#�v�A>%��O��J 0��u�,+�+p��������l��`tЌtM�t�Xڃ�s-XJ�W\n��,�`I��7�J�qA*��G��!n*Qdyo�[�Y	Qs�LE�|G�EI��0�D%���@BBأ��b �6�G :��܍�+qrcq�q�����yG���'�r����&#�]'x���j\"r�!jFT�K������-� �F�r �K��C�\"-�)��E\"R5�cb>��-�P���\r�o�rTF9%��&�@�V���e�bvj�<�4&�Ge\ra��׎(��R,�+\0>��b=��c !1if�@#�;E���R�������Qojh\r�V���`�D\$V�iC�~ ޱ��~�p( ��`ګ�D�h\n���Z8�+>��#>�lpأ�\$aq,�̪j.X�#3�C/��0%��dz�ʹ�2�f	�޼E�|#�9`7E�d\"DɀH�>tJ4t&�G�\";ad\n���eT���pc�!sA:��\\!�Q5���Ts2�L�:���Y-�L\n�<7�X5ʴ��D ��%2��>��qc�:OI�F�k�B�p\n�k�\0\r�-qB�@a8lf�@�U ���/�:�-`�1�jJP��_��S�8��'���0��gp\r��`\r���j8��%\n�/��:*��vLdtTLB>\0";break;case"lt":$e="T4��FH�%���(�e8NǓY�@�W�̦á�@f�\r��Q4�k9�M�a���Ō��!�^-	Nd)!Ba����S9�lt:��F �0��cA��n8��Ui0���#I��n�P!�D�@l2����Kg\$)L�=&:\nb+�u����l�F0j���o:�\r#(��8Yƛ���/:E����@t4M���HI��'S9���P춛h��b&Nq���|�J��PV�u��o���^<k4�9`��\$�g,�#H(�,1XI�3&�U7��sp��r9X�I�������5��t@P8�<.crR7�� �2���)�h\"��<� ��؂C(h��h \"�(�2��:l�(�6�\"��(�*V�>�jȆ���д*\\M���_\r�\")1�ܻH��B��4�C����\nB;%�2�L̕���6��@���l�4c��:�1��K�@���X�2���42\0�5(��`@RcC�3��:����x�U���:�Ar�3��^��t�0�I�|6�l��3,iZ;�x�\$���n �*�1��(��e�:�&)V9;k�����\0�C%��܎\"�#n\n��N�R���0ܳ��hJ2K(\$,9�7����.\0��+���\r��膠���0�8��@\$���+�Xʐ��̖�(gZ��1\rc�7�#;�3�S�\$���*��c��9B�4��*W'��RT��8��BbT�P�*�3�4�2�#��fc`����`�0���&��5�ir��+���K�rٺ-ľi���+�x�L��#��c�;b������.6�r�1�q�b_�G��4�l�n��#l�#�B*Q��n�7#��z�6^V�G,KR��!P�b�C��̨�3�d�f��L�1���ދ%cp��íB��J�7��u5g�nB���4�7c�(P9�)\"\\�a�(\0�!�0��8o#E�9��@��3;���g&G�+8qN��7�@�R9�\$�)o�>��ql4��������2gė�C~K�� NO����Ƅ	HdN�p�)�B��*�U*�;��^P���V����б�\"�Y����� S3�3ǬR�Ta������A�;+�e�H�*fN��]&\0�Á�/P:\")�O�\"�U\n�V*�yC��V�-������p.�/��\0��J0&Pu���r|,f0�0Ԗ�# !�8v�G��8�a�v����\0�G6��eeL6G\0000�b�o�3�W/���'�1y�r�00��@ȋ�,���ڤ��*\r!�7�b�P��.-�:�H���P	A5<.GW�X������\nc��R&�ZQ�jO��u\$ڃxw�d99%�G�\\qM��Ň����D0���&��\r����Er����5.ZPUG1��6a�2�@�o�#���4��^\\�O,�,6RĞ�X;P�F�\\�K<@Ӕ\$���d�}OJ��\0j\rQ�,����a�ONƠ���EQ&Ѫ\"&x��^͠ \n<)�H6��h sM<_V�cˍZ\r(P�(�zT�5&���P��*� l�5A��p���9h\0�V��}M\"U� 1[\$����2�mI�`�? �!vI��\0�]�bA>漮4dA)'F *X���S�t-թ��sJ��,����6!V'b�\\���%ԍ7Qɘ\"U}}�p�%�X:KDT��T�:�d��f�F�د\\� �4�}��#�=��J�,,���yf#���ż@Ĺ/\"%���(c}�K���ǻ����²5��� s���0��ݳmH(J\\K\nHOh0��?*lT����7Y�t�R��8\$���ᗳ:μw���˼��8Lc+����˨;�)\0�P��}��<��g�0ӟ���)\"���Cs���6�!Cd�c�,���1E,�̀�FC\\:�<�\"u\"�x��Z'l�S�3C}ַ��._�9���ށB�\\�\r�E܎�%�g\0W3���V��� 2��m�Q�!P*�s����ִ��	rȽ�V��C�Je���b�h�(){p��Χ	a�W�5&F6�3B�x�x��.<P_7�,t�Ʌ)�*Sr=�8tn�|U�r�)ƹZe����Wl�R|f|8���xA`��s^1��W\"�|Ӏ�����1�3��ޯ�*7Pέm@�ﴉ��\re��6r|g��b_��7/e�κ!�!N��O�zp]��Э؈� 3�g��4G�����-i�� �\\�;�����\r�X�����\n���\"�I=O�\\��N_c��;F���r�~[���\$��g�)���Y�s�>{���g���y�5b���d\req�c)��3��:��p@ㆶl,;�`95���o�_w�����/\"��LӍH��rB:5�:%���.��&\0Pl\"l+�����+2Ȍ^�fD��El[�`MD����LS�.��8)�DxpI�h�/�\0����N.�R�nzᬝ\0�<��M�[�{�V�B�j�P��m�	�+�`��B���%�t�B\"�O\\��nFP��H\"/�����\rGNwn��\rTFF�7�:���[J�\"�,���B<c�\"#��#��}���J�2��b\"6\$^���!V8��=����F���7�.*M� (��i���Z&����|σ�r�R�ϐ�b��';���*]0���-.�.�N���P^��4���]�9����ѕ\rѮ\"��\r�l۱�o�\r�J\\��#\r�w��D�UʤuEa�-Q��\n�M'9��\np�D��\n?-�\n��a���h\$��f�X;r&Ţ�	e��#�\$L8ܣ2�4\\��L�K��,׭�0��2\\��g\$,�_��!� 4�p>��-�ؒ����D��C�H��I����<q�)�е�Q��ʍ*����\r�P\r+�/��!B�sH\"�^�B[��`�F�(�6q]��#0\r.�-�e/2H�G/���-�B� �\0�f����c��-Nu!��\"��E2n].~�P��+L*\$��Y��`�z��\rd>��e�*cŀ&��|c�'�����\n���Z��F�I�L )�3��9L4�S,1n�#3���#�F�&yJ�]ϗ\0`�J2�&�\"���\\s	��-��N���%�8�'@(��ڬS�\\c�X�,d��F�\r�vX\nT4��	�8��%ĘFep��VH��\0�FR����LK ��������F��@��R�#B������\"�L-�F\r5D0�4R���O#&E�����I����F*(7����Th�\\�Ft�f�&\\H��ogD��anD,\0Fr�&�H%��E��E#�H����\r�	�N�8=��-�N��o��mfQBlp\0�D�\0L�0�<��&�t�ǅ���\\<��H��=��H@�,��F��J�M�0�\"�L~r37C�";break;case"ms":$e="A7\"���t4��BQp�� 9���S	�@n0�Mb4d� 3�d&�p(�=G#�i��s4�N����n3����0r5����h	Nd))W�F��SQ��%���h5\r��Q��s7�Pca�T4� f�\$RH\n*���(1��A7[�0!��i9�`J��Xe6��鱤@k2�!�)��Bɝ/���Bk4���C%�A�4�Js.g��@��	�œ��oF�6�sB�������e9NyCJ|y�`J#h(�G�uH�>�T�k7������r��1��I9�=�	����?C�\0002�xܘ-,JL:0�P�7��z�0��Z��%�\nL��H˼�p�2�s��(�2l����8'�8��BZ*���b(�&�:��7h�ꉃzr��T�%���1!�B�6�.�t7���ҋ9C������1˩�p��Q��9���:\rx�2��0�;�� X��9�0z\r��8a�^��\\�Ks�=�8^��(�=ϡxD��k���#3ޖ�Hx�!�J(\r+l/�c\n\n�(H;�5�C����5�oa��X�BK��0è+Rp���#\n<��M�m�舖7��蔟1�J��o�4�3��	ժ2G��i[B3��Eq�EB\$2;!� Rw�jZ�\$Γ&3�p��\"B�����(Nz_*��p��<-�i�)X�6J��С\nb��7��7\n�d��^���B�9�	k��LK�)���q!莭��&,�>����:B*_�lAe.�x��-p\"[]j4��d*�(��'#x�3-��K'��j)a\n��z:���l�ƃ���kwĕ�H�^��)��(�&�_	,����oҳ�J*\r��v!�b��1��棅�g��ct�O|���l��3�2w.�GУ\n�.��^�&(��)�:�4����Jԫ�?�,����G@�C�4]G�#�'+�/�2��p/�����Ҩ�)>�@���bl��9��#�\$��r�A̸VP[I*:H�蛴�-Y0Y;�����2�QJ1G)\$��JiN D� \n�`����B����F�C8eHf\0�'bZI	�N��8�N�q�׆�i�NA���غ�Pr3�h0�c���RgM!�:��ؒ�H NI��Fcxg��o���\\��7���'A\0P	@��pPR�I:1]5��U\n��:�X�#0A\$�Mm`��pJ��'��22H�-�˻\r��*��ވ*h5��:*���ʟO��mp�CHK�D�9\n}�a:A���d�&#�!�Si�P���3[Nn]!����}����J�yCo3\0�E���z�H��&�+�\"�;�P��Z�o4\"#�2T�!�Ž7v|�j��\$b��d�hS�u\$sj~Ux��m4�.FH�V���K\"rOi9�qfX#I8�\r��3�..��oL�+(i�3��ƹ\n4iA<'\0� A\n���P�B`E�k�e�]	l]B4��E�ǒ\n�_m�c�I,�g�p��H�\0�F�R�gH�Fǘ�^^���H����ؑl#��	Y��hHY\$� �/lHm�\r�4V��-����l��p�{���a�4W�EN�\n\n�B.�t�*�/�Yݛ�Zn�Ԝ)O:4�^�i��l)�RB��Iz-�(!�\nZ@PJm,�����CJ-�@873�|�r�X��z1SXe��6�i]��HR\",����3'���u���({�d�cSWd�>M���lECv+�'n���ڑa�z/}~��*��w5,Ðp�g�U�͝��& C��/M\n�zF��h,����&�E�)�9D9���x ��7\"������� d��nK��[��R0�K��0t��>�E��v��_5�<��ή�E��K���cKk>&Ei�%JԉS�1��'l�s�CUC\n/_��Uh��C	�Mwn�\$C��N�Ќ�1eP;Xp9��ce�6]��Oq��duVq��0RQf{/v�4�H\\�f�l	.�)[nս�3/o��e��rZ��k�f�5ێQW��|���i��ז\\�	��F��42݀7��d(������P#I�\\�j��Q�!�a.~w�;���t���Y�\\���%Mx:�y�[�=�CN��Y\\����IއzD`��^�mmL��DW�sޏ�9_<y�� Ϯ�Z[�Zq򇩠5X�8��u��/B^\$�x���������D���E���Q�KHa���U�y�2fUer�QQ�8aO�[	mؼs6�\\���xd��<�;:%T�J���{�&-[�y�X�m�qo/�S�J�L�K����>�r:�����I˓ׯȍb[tߣfE!7�����27�۝��W#���Fc�R&Q�S��F�u�h�JK�\rw�s);]�q0=v@�������p���8_��~,��5���PZ��Pof.�T? �9�.;LU���n���,X�gx`,cP����m@eld��4�/����0H���0{I��n|���Jc@�����0 �{�Gf`[�.K���b��0%�N	�C�\nN|:'��\"|!�Nm�߈���\$��A��`�-��r	\"5B�2Ȝ#c8R�)�V3��M��&���@�C\0�\n���p\$��쮾�&��D�V���-b�l,�C����Ȋ�,j\n���C!�.�6p`�(�����(�N�*2X�\\�儯�*Ґ�p��X�X#�a�i\r�������,�Q���vp-��~���Ϫ\r��3bg��Cjo��a\n��u.l ��N�c�r�Nv&��^����`�P��\n��\n���p	�k�;� ��^1�L�\n�4-�!G�EqJ�g\njN��	��\$bM\"�\r��:\0�0�e�;c9.��i����6";break;case"nl":$e="W2�N�������)�~\n��fa�O7M�s)��j5�FS���n2�X!��o0���p(�a<M�Sl��e�2�t�I&���#y��+Nb)̅5!Q��q�;�9��`1ƃQ��p9 &pQ��i3�M�`(��ɤf˔�Y;�M`����@�߰���\n,�ঃ	�Xn7�s�����4'S���,:*R�	��5'�t)<_u�������FĜ������'5����>2��v�t+CN��6D�Ͼ��G#��U7�~	ʘr��*[[�R��	���*���9�+暊�ZJ�\$�#\"\"(i����P�������#H�#�f�/�xځ.�(0C�1�6�B��2O[چC��0ǂ��1�������ѐ�7%�;�ã�R(���^6�P�2\r���'�@��m`� rXƒA�@�Ѭn<m�5:�Q��'���x�8��Rh��Ax^;�rc4�o��3��^8P�@��J�|�D��3.�j����^0�ɪ�\rʜn�i\\N�1�*:=��:�@P����ORq��ڣ���jZ�P����ҕ�.��0��*R1)Xu\$WjH	cz_\n���qt^7\$Τ�:�A\0ܞE����0�:���0���d%�Ȱ�:��2�)أ\"-'�Z��b��膲\"̗�iC2�nS	 l(Ε���獰��l�cz)�\"d֎R\\���,�������L�\")ɑۮ�C��뵐AYdѤ�?�=d\nC,��BH�9�V\"\"���k�v���ϻ\\d\"@P׏�6k2���`�3e�Rj*�r̷b��8�W���;ڣ6 K+������3Ī*��%4�2��R�L(�ȼ�)���:Yn:���v�Mz��2�<�2��aP��\$ �>*���O#8A3ӈk�1��K�Qh5HRT�-L��К��rT\n�2%fX�@>��X:�l���F�T��q�d�����\n�%D��rn�N:�T���`�����~�D���.�T�\0�}P��B��Z�U\n���vLä���� ��KpeD��Ud^�5G�P�6r~Q�eIp4��R؃Q�\n�=��x�	#4D5��RC2�\"���7LAvj4���A,h��0\0��y�8H%��\$QJ�#��(��\$�]\$m��#�q�AUw`)~���Ǔ�4a�Қx^h��S6i�=�@�b_w������U䑍l�'�*��\"6\$���V�+��&6r�J4��L=�RnNI�=LT��H�9��!�D�6��I\"���'���q&qD�4NX�%����\0'Ed�?�f��5\n<)�@Z�fiP)e6y��\\��2 �8�y�H��S��R�\n�yxY��2�W1E5�������CJƘ�S����+eE��H�B�mG��b�K�E!��?	�`O	��*�\0�B�E\"��\"P�k��^ȹ#���u\$J¯�x���dn`j�\n���ңTvI�[	ᶚp��q�<����94K,���Y�A{4�4�mV������%�pA�����\n�RG�6�I�b����������R �B,I:bw��9�b�fN��1'1~�{c�;���J�]5��>X�2���yNa7XR<��RiC(wY�B�6�X���J��\0�V���L9���۠��A̫��3� ��;�X��-�,0�8�\r\0��Cb�H�����3�p��(x�������)�`Y�\$�{�^\$���*@��@ �5���[/�poо��8E�Ðy\"���e��%&Tȅ-�H\"�,�D�L��M����b��ht�q���QI��;��%�Xdi���g�Fp�a�^aϧFI��9���Œ�:9�z\\9�Ӟ��fN`:b�\"��I)�܋�KT�0���[�:�K���6zl�\$̆�	��(�ޭ��@�8�^�����A)�:����;��P`(\"�����,FD��H^Lʖ�*Kt �b�H�K&	+��^��>w�`#�Ry�Uȁl~{|(B���7�o���L�pS��x�2\r|Z��;\n���ٔ�;�4.S��!����5ig^&:�6đnY� ��IGS]�4���8\0�/�/^��(gD��㞏-ZU�֣��AΩ?\r��)�.2s����K��G��t�̶��;�Lo���dϹ�p�.��;_m���,ݟ�wʸS9󉿸��TV>��	/��~��\n�P-Ci��������8LL���5*�ӣ�>��k#D ɗ�	�	EjgI��B���g�А<DGM|f�	O�&%X|nFx4��z�C\r�+vr�/s�v��Ͽ>?�_����|��KG��=��-�&�1!@Fn�jI��`���N�܌t c���k��\0���op�+~�nBjf���NfnJXf:�25@�\r#�Ǝ���Z����F�\0����U��� cf:�%�kN�ư[,!l\$c�}�o0s� E�0.�1�BMpH��/D��#	�:�p\n��!	p�e����,2�e�'Dd�@��ć	�O	����\nN\r��d��C\$3�� ��\nE�!bf��Yd��4pB*cP����k��\$��ࠈ�`�N�^f5F/����b���Gp���4\\����e�\r�V\rb<\$/v2nJ�\$'�d!M�2�������Gf\n���Z6~~L\"j���\0h��J�o\"ӭ>�8B9���0#B�#�B��\0*~��	��\r ��F�(NjQxf��=�xuX\0E��D\r\0�Qj8�`%��lC�&���H�U�\nC�u����7��D%�^��C(\$� `0���:0�����.B��2H�RN�b%ß#1(6�\$�Г|��[\$Ѷ(��'�*c8��F8Q&'K���~�c�Z,d�\0vB��\$�܄���u\ng�|�L&y+��2��#��Ie�G�'F(*Q�Lì\r�s.iZY�.`���V/��2�yRd(dܔ��,r �dn�#*�'��\r�.��k��.C|��x%D:	\0�@�	�t\n`�";break;case"no":$e="E9�Q��k5�NC�P�\\33AAD����eA�\"a��t����l��\\�u6��x��A%���k����l9�!B)̅)#I̦��Zi�¨q�,�@\nFC1��l7AGCy�o9L�q��\n\$�������?6B�%#)��\n̳h�Z�r��&K�(�6�nW��mj4`�q���e>�䶁\rKM7'�*\\^�w6^MҒa��>mv�>��t��4�	����j���	�L��w;i��y�`N-1�B9{�Sq��o;�!G+D��P�^h�-%/���4��)�@7 �|\0��c�@�Br`6� ²?M�f27*�@�Ka�S78ʲ�kK<�+39���!Kh�7B�<ΎP�:.���ܹm��\nS\"���p�孀P�2\r�b�2\r�+D�Øꑭp�1�r��\n�*@;�#��7���@8Fc��2�\0y1\r	���CBl8a�^��(\\�ɨ��-8^����9�Q�^(��ڴ#`̴2)��|����z2L�P�� �3�:���Եc��2��Un�#�`���ˈŁB��9\r�`�9�� @1)\0�V�Ah	c|��Gb��8Gv��H�[\0 ͣz�5��@���0�:��p���R6�P����T�\nc\rΥ�å��0)ۼ4�C:6�*�)�,��1اx2HH*)��d3��P���e��_c^�����0\"���k,�(M0���H�w_W�YaGZe���cP�ȁBzF�J���0�� �z��(-5��H�8c��[�7�ζ����i�,v\"Ur�E02�����	���3d���6d����A6��x�Hv2++K���|#�D:��3l0��*�iQ3h�aJR*���ؿL�)�Hߐh@�5.~��2,23�͘*��8ε�Kb<�R*\r+EO�#����tJ:�p� 3�A<޳��:P��BNQj5G��^�j����@���\"�%#L���Ca;9�8P�̖zFsH�7�0ܵC�)%eD9�\$��C�j�d��P*\rB�u� �J9H���`Z�m����\"A�t7��||��z��՘Ü��C)p���P��C�;&�`6�0��[e<!�iL���ap)3�E�F#�A�H0�d.AC��Rn��=�b�Q2�!ͅ��qci-�̔��Sj�1����C��V1��E`��-�!�Q�\\\n\n())��=B�\\�UA\rx�����;a��R�RɢV	Q0��_]۽w�!������#��>B�FMbi�.�\$ԧCppM��8�4�Hc\r����\$���(0���`�WI�\$���J���Hr�E��Aҗ������\"\\�~ZSR[-\$Ԭ	�q_�d3�b�`\0)��#�jNh��s)���F��b�y�}��@�	������^\n�d�JB��9Eh�uk8ߑ~'�Zf>#AY�#�x��\"H])�\nl��fl��F\n�A����Zqt����Q�R��\r�H�\0�h�٘O	��*�\0�B�Ek6L\"P�l�[��\"�b��E��&T��[�\r�{dȓ��Hl��ۛvEРFj�1�ͣ��څl7\$Ϳu��ّ�g`�FE���QkGm�\\���OaARl��e�&��@�=��EDC��Qb�	_,e��?@&#ץ	��(�(#�Z�KJ��e��7f�P:�L4��w1{�U��y�C�oI]�-�T��t�(�Ø�Z`��-����2N�Bi�-���\$%mikW�LH���Z^�R73;�dZ�BA�&J1�ɋ�V_(=�N%��lW�ܶ�n���!'Z�@��@ �D)]ΓWI�t�� 2�P�o��v'����@ʾ�1A�k�-`Ynfɴ3EÜ�Zu�F.�Ut�L):F�iM,4ƚ��,�Ս?�d�)�s��@N�'�CV�J4�<��,h�A������`�����M9ǰ;����#��k���L�A*��ؠ���Q��\0+�P�Rh�u��gE�p[�-n�ؔ3g�ޫ�c5{����,Z�''dŲ��Q���H�)j��@n�x��V�˻xy\n��p�q��s�6%С��1]P��`sTl��nk����V��6-��(�~A�|���doʄ�(h�\nt�g|X9���E�s�R�U��.8��2��u�4��r�5�C+1�������� 7�4�[�Y��~)����QJa!?��Ǻ����θ�d�=��e�n�Y�pyW7���X���j��|�N�z���-@upi��td\"�b��E�ܺ�؏l=������{��!?��C���n�+�m�-����� �)]�ֹ�^��7�S1�)ӿ��v䈝N]޹�\\�/R�O���e4��Ʉ����-�r�f�6#l��ǌ��o���H� �zO��%�0��Wp&9�n�:cz�%��ƌowBR����.��Yf��zjCV��n˸0�p�n�Yf6\r��^`��%\\߆j�*�L��_c��\$���x�l�\n0*�7\n��jǂJ`��F�;`�( �q�v�f���0u\rp����cV��\\,�8�R�'�\"��p^��4s�`i�>�\rK���:����\\��~(#��N[Q.E�,��REl���v��^c2������i�m� �j8qF�d�\r\$�L �p���j�\$�(iQPB	e�Z)�G�IQsC��oH��d�\r���:���d\r�V\rfd!�.�����4�O�Xzͮ.�����@�\n����ʊ��%1���ү�~�M����Q�B���/�|-�`����('��Q@8�#j9\"����#�8q̩��+:j2A��U�j����v ä	����G�d�5�����lXk�'.�0�,�y&�1(K�9Ƃ�'�d(P3�m(\\(r�9�D&c\"���*�\$��Nڦ\"�k�#&n�c�	��,���26ŦS.-�Wk��mX�h�r�kR��lj\"ڷLj\nf�!�N�Rz^`��C�C%\n&��|;%�)�\0��ҷ\"��#���N�X1%��";break;case"pl":$e="C=D�)��eb��)��e7�BQp�� 9���s�����\r&����yb������ob�\$Gs(�M0��g�i��n0�!�Sa�`�b!�29)�V%9���	�Y 4���I��0��cA��n8��X1�b2���i�<\n!Gj�C\r��6\"�'C��D7�8k��@r2юFF��6�Վ���Z�B��.�j4� �U��i�'\n���v7v;=��SF7&�A�<�؉����r���Z��p��k'��z\n*�κ\0Q+�5Ə&(y���7�����r7���J���2�\n�@���\0���#�9A.8���Ø�7�)��ȠϢ�'�h�99#�ܷ�\n���0�\"b��/J�9D`P�2����9.�P���m`�0� P�������j3<��BDX���Ĉ��M��47c`�3�Г��+���5��\n5LbȺ�pcF���x�3c��;�#Ƃ�Cp�K2�@p�4\r���Ń�����`@(#C 3��:����x�S���C�s�3��^8R4�&�J�|��\r��3?)��	���^0�ʘ�5�)�D�-v:�l\":֯̀���\r\n9he��Lv��[\n\$�'>� ����FC:2��3:7��58W��!���	cx��\0P�<�Dr�/�p ��X�7l�<��C����-r�i�µYvixë�ӭ�\n82���	#V�� ��b��s�\n'���B�r�\\���:R:��>J��L �8o�HC�I�r��G��orf>n�>���˚���\0�(��T�;���V�=�5�}N]�-K�5�9�itL��f�#��#sQ7�K.L�*����.��^I��>5��P�6�Y\"�]��*�\n��Nd��}!-[p�6�+�\r��ʂ��L3�F�\n�̽00͓Eեih���{k*1���4��9}n4������Ns��K�����W�G��o��7\"�����5�������0@G��D\n��}��8 � [�B�U\0Au��C�6	�=Ґ�ȕ�)���\0�F��)�Rk!�s%!���\0�C�l^e�\n:w���#r%i�6��~C��C9d��E���d@	�8!��c�xz;�8���� SA�N)�@��\"�U\n�6��^��`/4ea�Ep�|9Bec,�l�Øj(0�ġ�[�L!��ERZ�sb)(4%9>9)`ͬ���\\by�q�O�F�U9����C%`\$HeA�A	H�r��\r.������>(Q,9��щqEAK�[�d���D5l�����b��bw&�R�\0P	A�\0�dhn(A�6�L��NC��0�b�~P�(�Ծ��Z�5T�&T\0�M+.��9�����C���2��.�R#.t6��@���%�ę�f��Jz%/5:�\0���;xs~\0PTL���a2v'��52�?�FB��uFp���	`I�����&�'�3��4�rTMZ\0����\0VT!V��_R;�ZwV��I)B�K�.��O���C	l�AA�����\\�'\$����\n�l�zR�ʗ�@�P�'EȨ`�BᯫP�IĲRBQ�#�\n\"�&\$�L��4��ϐo*m�O�Wl��&\$�D5�V�|�M�e�ʷ��X[�R��^�nD-p 8�4�;RU���j�[� UMK{	���\\���L)S�5\$�Z+aq*T2�Q\\�wP����l�]M�)��B�<w�s(����@U�d\$�̺��m[���e��_@ƏBrD;��0�u�c�AV�u �ՄXkM�'�ha�I���x��IM����<�AO��PY����D \n�Xȟ�J���	l�\$M��v/��s�\">���=���8�@����uGK����Czn���j��1l#H~L��F�^\$\\�3|�%س9\r�����\r��C& ((�g��\"'.�*���\n!Flz��w��B5<9�ج\$?J�Hz��KV.#�wv&�2;��������dC��e��Ѻ��W��&�\\���;��K�oU �e�Ss�<9>�𩅧�{G�)�_�FX.N�jJQ(��͝��ۛ��ZG1:�Z��cw/���C	bo���Oj�3-�'���������ԣ1�EJ�����6}D�C���+D]!1|2�k�G�OW�Nv>w�C�g�Qr/�ܷ;��@+�.��;���(S�w��߱��%?�w<�e�ՙd�Ŕ治S)=��x%���!5;���9޼�O��ղ�=���Z,BE~�a��iN�ؑ�:�fAL#Dsd��(rN��m����H�����)��q���mӿ��͒; \$�\$c|���(b�bf�FZ��E���%^?\$z{�Te�v���9�� ��;�:^\r��RuM���&����AE��|�*�,@P6�p::HB͜(0N��ȍ��pa�[0Q�\0X�j��Tr���B��L�n��6\0�\rh�4h�d+���L����ǚd��\"@�^c�4�W\n0�dC�gl��l��Q\nB���d\r��'pp�/\"u\n�B� W����a`ڞ�P�̴l`R�P�Jǈ��^�p(Ȥ���(-��Ci^��xб�q+1Q�m�jD����0�l\n��Q��؋N���c�s���L��O\n�JO�q<��P��.�0���*^6�qc0��k�]��qx�����k�qp.a��J��;#sь�.09qB��l�m���:.LK̖h�((���^\$�gVjLm��-e,OB%�E�Zd��C	�d����5��@?\$���q+_\"�d��@6��8,�LQ����#B�}�8��6ޮi#̛���E��qi12�%���aPc�*r�ݒ���M0w��)m�\\���Ȧ���%pe�\".^��-k�p�=R�,Q-,��=��ޯ9.\"[+'..Hs/C�ؤTy��bBZc�8�j/2@�<H�-�����ʢ��Č��epsp-�9R��E.Q3Ѕ��p�V\ri'5�Ў����w�2.Sc6su+SmE����᣺��mR�L�79|��)�:�:sY.��6��.(ER�s'9.*k�V#2���\n����u�*�9��u�܂��ө;s����?PU;cd���Q��-�G5#���\$G��]63�el���(S21|m�,� �0�CjiC�uC�=Ѻ0�6*��_�\0<E�F!�\"8�-�Kn�^9-�.�G.��)E �G`�`�*�>���i�\$���)ú),N1,H��\$�\$\$��d��tň@	�\n���ZmGp5LBv��n�����,ENt���#-,g�OfD�\r	1�T1D�#�\0�#�U�vxE;�}�J��?�X�bJ9N5)�)�qC�P��{�M\n9d�5�.\n�WF䌹� �#���s�P;�|A, @ވ�b�)�X([b�\"Z���&Yp8 P�X�'O��XU�4\r!��Z��� �8F�U�YDP[��+�r=C�gȐQ5}=�2�5(O��\np���o\$|�,zNQ9`#n^p�C�aJt[��r�E�THn�^�D0˕�'�Bg�\"�\$V<H�j��u�j�Ռ��FJ�z��FDFHM\r�\\3�6bChi`�ĐG�J%�%���1^	�\r�S<�/";break;case"pt":$e="T2�D��r:OF�(J.��0Q9��7�j���s9�էc)�@e7�&��2f4��SI��.&�	��6��'�I�2d��fsX�l@%9��jT�l 7E�&Z!�8���h5\r��Q��z4��F��i7M�ZԞ�	�&))��8&�̆���X\n\$��py��1~4נ\"���^��&��a�V#'��ٞ2��H���d0�vf�����β�����K\$�Sy��x��`�\\[\rOZ��x���N�-�&�����gM�[�<��7�ES�<�n5���st��I��̷�*��.�:�15�:\\����.,�p!�#\"h0���ڃ��P�ܺm2�	���K��B8����V1-�[\r\rG��\nh:T�8�thG�����rCȔ4�T|�ɒ3��p�ǉ�\n�4�n�'*C��6�<�7�-P艶����h2@�rdH1G�\0�4����>�0�;�� X� �Ό��D4���9�Ax^;�t36\r�8\\��zP�)9�xD��3:/2�9�hx�!�q\"��*�HQ�K�kb�Iì�1Lbb�%J�8ılk�g�V��%�Ȥ�EK���\r�:(��\0�<� M�y^��!��`꼧#J=}Ǝt^��p����r2 �ϊ��k��2���6Nku�2�v-�����a����4��J((&��ǎ.ٚ��`��/b}`�1��ؠ�vA͈Jr�����٫�� ������3@Û7`��ܤ��&L����j��l� KR�n��p�>B�o�c��,Ǵ�-��h�6#k�B\$������,���Z[���U,q{��!L�>�\"��Ѵ�d7��3�R�\0�R9L�@�\n�z���!�9���b9���A�.��x��0���{Ԓp�aOr7�i@@!�b����֤���9I}w����T�a����̹	wg�����s&��ӟ�d��hui�5*B�تCD�H�e(��S�yPuD��jU\n�7�^U�-@���ί�\n�ye��j�C\n�N����U������a4�@\":��z���?:��� S*mN��B��J�J�U�Q�j�V�P8���C��7��U�s���N	�wą�%�H@�yʆŸ���C1PN<�B:A��^!�3D�^i&zeA�Sv�I�hhh���#H��\r		Fs���u'���Fc\$��P	A:9�pl�AP\$��KC���\$����K\$S�#�8׆s�GK�t6F��'2�΃�U2���FK��/�0��f����A=�?CppP�E��o	� M��L/\$\r?�+2d�(�9Z��1A(e�#��H���g=!��b��\n&\"��4�P1P'\$��H�J񜩝���zgY�^��؁AXS)��cgIaB��7��P	�L*'��I�K`�3���_���ԅ��|ؚu7���GӃ:s�s��\$����ށ�7k�6��2�Cvl��\"8��\0F\n������C>)�9D��9\$��0���~E�Y��4��P�*[Ki� E	�֑T�m\n�C�)���K��g��V��Ã-eF-cӔk�(�jYh���-���D݅\0C�r\\��%g�i�}��z�g|�L�=n�cæEs���O��Μ��|`\nE+i��v��V%��Ҷ�@\n\n���r��q�K�T�(/���S�`\"�VةF�� �Fl���3���@�a�\"dd�ʽ�Bd��W�7�X�\0�v:^\$�2�|\$fqzeƮ�a���LW��Z�8��,���)u���,��\\��qjw1��{2���*�p*f)���+�����b��|'��痀�y1��7\r]]����09��p�0�(����)?%+XC	\0��T�쓔�rӨ\"��2^Na�cf�/^XW��]+�x�@E�c�L<d�~�]���dj��p	�/#a��`���׻-�lݟJH�� X�ƚ�Y�6�,'��J���1\\�6�V�RѶ��9���0�v+2������L	Ù�'�(C8~Ȥl�'(Ɣ��ĈF3:�]qR�HP������ˣW*�1��zr�gHb@秀�r[Ǌf���;q�b��5rԳ��S�M��HEWD��\\L�LxE1s���=�V��k�Ք�߇V�D�N�N����%��;�ahW_1ݷ)�r\n����KF��������z.���Dk:֗&����~B	�mN���\\�)ޓ� ��?`�tgH�U��ģ7��hX	qz�2s�A�����!��o�'�|���\nJgO������J��Ľ���x�9<8�OY��\n~��{l}�������g�ήl����@�g8���\$���^��js���}��|�ޙ���H~��9��/,<vl�|��+�ΐ�6;ƞC��(�f`@�Q�4��&�� OX�<I6O^ߤ����9b2�ɴR�%��p:�>������H~�;�?Lo���C�L�,����[��\n�T�O���������4�ր�ҩ��k�p��μ����\0��n�%��jK��.C\"\$K��L�C\rfbH�#,R���8� ���u\n���0�	���q�Q.��&�&L�l�	Z���e�g�+1=�<�m#�\n�4q<A\$xuO@�Br�Ŝ�n�O���z.��\r�3\0@α����Br &\"�\n�8J\$N�'�q�:A1\$����%�0�`�0���`�d8�*N����^�D���n����f,6Hiftύj5H�0B���^�3o�����&�\r���<@�j�\r&q�N(En#1g-�\$� ZgB����D�ǲ\n���Zb��\r��E�W\n@�'�׏���(2,'	b)�8#���dξ��O��t,�.���,��@>q�vm\n?~n+� ��M��J�^%lKMh	��<�\0(G�C��F8(��6/�l�5�^��o��aH���0�|F�6R�0h�D���ؑ��5�d��|�*���\0�A2 'q���ƹ3/ڡ��\r��9��I�1����e�bf�Gg+\r�6�(G.R������D3�'Ӎb��:�2E �3��]\"(�Fd�KK6`8��/\$�1�&.��\\�1��_츻c�I˰�S�8,�����>`���i@����.�\0D˰CQ���8z�N";break;case"pt-br":$e="V7��j���m̧(1��?	E�30��\n'0�f�\rR 8�g6��e6�㱤�rG%����o��i��h�Xj���2L�SI�p�6�N��Lv>%9��\$\\�n 7F��Z)�\r9���h5\r��Q��z4��F��i7M�����&)A��9\"�*R�Q\$�s��NXH��f��F[���\"��M�Q��'�S���f��s���!�\r4g฽�䧂�f���L�o7T��Y|�%�7RA\\�i�A��_f�������DIA��\$���QT�*��f�y�ܕM8䜈����+	�`����A��ȃ2��.�<�J.��Cj�=m���(��	����L���B8�����N)�H<n���K6��z���mp!1���%*J.\"�136&\r�����I�ܕ��P�2*2�`����7i\n#��3`@ޱC�ꒀ:����c��2�\0y�\r��C@�:�t��,I�\n/�8^����GAC ^+�ѻ�p̾'����|�=�,귲p&�O+�ۼ���K�b\r)	jH��6]��X�@�7��I<º^7CH��C���ʃ\"��6�\nt4� U�:2��m�:#����j�ƽ=�0�:�Vk:��#k]:��x�e9�Z���%��x�ӌv;(�0I�\r�	�,��w�n�:8�R�˩ܴ�Nn�<`�Ahb�bS:���Ɵ^Ϛ|��b��1o�����e!n���h3��k��9�O��m{lN\"혂{��rT�_di��6#��@\$��S����m�ra:��T��I{5|\"Z�s]�vS6�5�{�7��0���0��'Cz��!�9��sn9��fY*�+�،#?V��u�0σ(P9�)Ȩ7�iX@!�b��V��N��������_,��b�_�KΒ��#C�!L�{�5��q��C��/�C�\n�ЪK&\n֨�����R�X;�����S������\"�X��h���#0��8��T*j(��Z؀-l���%��Lr�\$\nR.8Hf�(d{�D�U�Tz�RjUK�� ���TL������K����|�A�q��^��L�a-%Ìn��Dfb1�p�͂�:��17�&�	�h;ɶ'��JLa !o�.0����M���B���c�;���F�Ή.\r�<���P�2����\$P����h�U�����hqr���\nIQf�H9��I�A9]��-�3��� 6m��.7n�O�(��r|R�i����r8`ȡ{a����p��!J�M*���!ڣPi���0�K�}�է�S0NB�Ԕ*��\"�Q��i��H��T��,�ƌ��@�,B-���ECɫNeQ3bWN	�4l��B�NB��G�1�����(�1�h\$��6p@�1�u �m@�C���g�r�RHl����*eٲ�	�4��)��|��oI��>��!\\�Y��`�.Z�ߢ���Sc�K��'@k��t\$i��C��]���:t�NT(@�-�\"���h�4l�=x/%�'\\�P%�QF#�ω�@f��Gf=9��b̢�u~�Zm��&��C�z[E�\$t��U��h�Nļ�e�/�7���P�:�bw�݆λ[����\"��DN�pd��b^J'3�\"����B�y+\0�0�L�ELwDqP˘Yo.J�(J�9��|�Bt:������'F,Ƒtp�����t)����3p�e� ӌ-��c>X�Y��\0(a�ӳ9�il\$�������C\r��b�����b��;w���\r�IdL�PÑK�����B�PP*�.2�\0�X�7�(#+}t�y�1� ��@/z��)}%�C	\0�����k�o8�G	�2�0�. @�J�4Kl��и��<��e�E����ed�(ި]e�V�2ǹ����uf��I��mq�5ٸ��1'��+�Fje8��-�K�β���6�RY6��Dl\0��ӳ�Q�݆8�߰w<�ޕ��Cc!�6�S(�Ӈr/���&ey}�3Z��)��ۘ�����;!�i9��K�^+�7�؎PL�eHE�p��\n�L&��r���c�A�!g�`Y`ѣ9@����Up��E?��#aL�	�SlxWyZ	�؄�u�uו}�7؏��ʶ�8oA=�V�3�I�JD}Дp����y1��6M� �X��I�]�-zL8}�v\0f��-4f�?�@�-OY�D�[.G�Ϊj眎ޱ�#j�1S�^d�1Оn2nVL���&�\r{�r��\$tV���kQ(1Ulڔ=w�m�����x���>��4g�^��|ܵ���������K�fbxe��0�jlW����l�}�g0��گ��\rj�O�����`�*�͎��\0����zl�{� �`ʄ�0O�p�/����#p���߇*/��zF�,̼h\"N!��<b� ��P���C�^��t%D��pN]�Rㆃ�9�9\0�v�m��et��z3�`�p?��̒�k�ˣ�����\$�f�3l��a��,��06��#\n�\"x0J�3��F�ھ%�����������|P!�{�q\0셁��:�K��q�5�*��(Ђ�^�NK�8è�ق`�CnG������1O����p:�1q�����`w\"�cE��R�c\$_�:�1��Q=��(�8^bBl���FʬB�n�����7Bs��q��#\0�P����a���K���\n�^�6���ҁBF��# !�6v����	\r\0�N�g����'X�K� +��L-���#�F�B���B�m�^�Z̍]	�\0001C��(�B�40�\0�\$�r2�D��nƔ��<��jz\r&T\"��EX#��B��c� Ze�r��\r�L�x��\n���q�2L��-��.��#'���Q(K�cP���\$D\$��%#0�l�NOD�.�@�\"c��/#G\n��ćF���:�'�ʌ �Ҙ#*kJ��Ud�ճE-C�\n�J�NatYB��Cn�\"�N���q0��.Ŋ\rƞ�\"�7,X�v�����H�#j7*1��`�J԰L�S�ߏx!�\$S��3�5�^;Ӝ?���*,�yӪBP���|J\r3��,\r�7K���V�k��+p'�ʣ\$!LO�2#�R�G1N�\"��d�^f����0'N>�030��\0�*�6���\r+�er�&\$�DϮoO�C�M<s�\0���K���c�D�D��%n�D�% ";break;case"ro":$e="S:���VBl� 9�L�S������BQp����	�@p:�\$\"��c���f���L�L�#��>e�L��1p(�/���i��i�L��I�@-	Nd���e9�%�	��@n��h��|�X\nFC1��l7AFsy�o9B�&�\rن�7F԰�82`u���Z:LFSa�zE2`xHx(�n9�̹�g��I�f;���=,��f��o��NƜ��� :n�N,�h��2YY�N�;���΁� �A�f����2�r'-K��� �!�{��:<�ٸ�\nd& g-�(��0`P�ތ�P�7\rcp�;�)��'�\"��\n�@�*�12���B��\r.�枿#Jh��8@��C�����ڔ�B#�;.��.�����H��/c��(�6���Z�)���'I�M(E��B�\r,+�%�R�0�B�1T\n��L�7��Rp8&j(�\r�肥�i�Z7��R����FJ�愾��[�m@;�CCeF#�\r;� X�`����D4���9�Ax^;ցr��Oc�\\��|4���PC ^*A�ڼ'�̼(��J7�x�9�����c>�J�i��@�7�)rP�<���=O���t\r7S�Ȳcbj/�X��S�Ҋ�Pܽ��&2B�����`�n �H!��x�73�(�����:��\"a%�\nC'�L�2��Pح����vո��Ǌ����N�&.��3��;�E�L;V�5h|��)�����CF�DI����2�bm|C�^6�\n\"`@8���jC��o;�s�#M��Mr�&��\\��:�X�2��-��7w Ί{� �0w�8�(��7�.��	#m9\\\0P�<uc�\$�9W��͜<\n\"@SB��oH��m�7;B�0�6P)蒂&:0�7��� ,p�Gc2�6N��G)z�꽄F\"�;�P9�)�)�B3�7�p���\r�H�op \nID����ÑE*�U��4��;�+�*DS�C�R�'�pL��D��*P@�ق�U��X+%hղ�W*��+���!�1KMc��r_��Z�^\n#�hHI\r\$� ���R�A�p9�p�u��200̘OBj�?juO�2�Q�0�*�V�Uz�Vj�[�t�!�����Ŏ�]Hp2�@�D0|��\"QSL0�����J�x�,m>-�����R������z�rw/��GG��R��2n�BPa��3F7���6|\rt����p%;}K�����_Q9�C)3��e2���6���î��7�\r�<pڂ�\0��?@�ܩR25w�v�c�)�%C�Ԃ�R[[N/��Ć�X(<6D٘��r��Ɖ���X�	W}&���H\$��X�0;����:�0D⊢�ThI�6%%��r<��*�5�����f�8%�<��Ȃ��a\rE�0�¤�y6H�4���hZl�9'��MZ������7���9�X&�0���P	�L*L����E<�*@S4A1� 䁊��tBQD%\$���2;\n\"%�-�P���L�'d����I�	�|)I?�8ۉ[C��`��QG�.HUt�NC�;WL]ǐy���\n;t�ã��b�p(���x&Oپh̼����̔b��}�d���	�q� &�[:1!�3�zb��I@ptĄVoU�\$������rP*j=.æ�&�^`d,���O�A�\r<+L��҄�!�����߷q��BB2&剕�(^\0PVISQҝ#ƁB�\r�	� u\"a�svc�\0�-AR@P0��#I�~:/������ ��\"%��� uD��3���&g�0���?� 7a�;��\\�iAS'c>a��b�){���3��!�|��?�a�O��4L�i3c�����6LSh��/r��T�0�87i�\noT:�I='�]�q2;-#-�����w�I��:�P\"��!B:q�_���t�K!P*��u&T8�up݌��L�9�z�eUn�,�A�)�S`A�n��k�PQn�\\�-�����̜\\'J�P	�D�z��dw�Qݦ�w�����u)4�\n�H@������< �����x9�۳h�@[�8��'���)���:rk%i�v�Q��%�d��\0��R�+|��>�4h����}�y<�RY?�\r'�al�w�g_����P�p�����\nL6��e����ͷ��+%�c�rC�)�3��d�Z\"UF;V���r\rr���x��<-=�((�`?\0��B�D�g��m(~p�����ϣ%��/N =�&ޒbr\$r����k���]����\"�w<��L�ːzG*DK!�7�n�J��64����bSL���C<�KrC�'�p��@S(y��,�,ދ�k��5�è(t_X	`y��jz����k�w'BRL�0﨡O�\0�\0���\0�0�P\$����O*: �.R�\rFA��db�.�F�����0C0F�l9��CS�\\#�7/��,����f�����Lkk���OI09	Њ�0�=Oh>P�4Oo�+�4����8��*�>�> �֏���<�ȓ��,c\0�\\U\\\r��c�G��l�&��#( [�{	�j�0��o�ͪ���q�\"��ҍ�3��]�Dk�\0�qB����S0��qSn�cG��:��L�h�zCF� OU,�C.��~\$Og0��]́/X)F�N��C���rG&C1���~�0:@�aDC�vB~[f�:c�:�f����h�cc���q�<%��q����i���|b��pJ�E�®�!b@��e�\"\0�c��(c�\$P�/&,���Q�/L��/\$ѓL��H�{ _���-\$��\"��%d�H�U�|�ZI��2N��S(����i%�_q�\n����)2k�z	<q��P3��O*���pDoX?ep���#%�`���,��B�� �g�Ň�_��2\"lb/�.��R^�M���.R觱�/v�C\\~D�\r�V��\rq7\0�N� BhRG�%�z'�:\r��+I\\}\0�\n���pC\"N^���Jba�Vu�D�t\$�P=��7�J�B:#�B\$g~�C�����Ά�l��`<#4iO�4>cH ��ǎ����V,��p�!�bzNk8Ym�8��>��>�ʗ��&��r'��U@_oP[O�1�&�� ��A#+Aq��OcAJuA����)BI���P����*)�h6�&@�L)�C�kQ�E�/&.eIĽ��H��F���4|ZT�w/�g�b:E��ȧ�_�)F�D�/r@�E��^@/��:&14B���IC:t�#J	�B�C/��s��M�MGZc8x@޶@�/'�&�#����&�b<�@�	\0t	��@�\n`";break;case"ru":$e="�I4Qb�\r��h-Z(KA{���ᙘ@s4��\$h�X4m�E�FyAg�����\nQBKW2)R�A@�apz\0]NKWRi�Ay-]�!�&��	���p�CE#���yl��\n@N'R)��\0�	Nd*;AEJ�K����F���\$�V�&�'AA�0�@\nFC1��l7c+�&\"I�Iз��>Ĺ���K,q��ϴ�.��u�9�꠆��L���,&��NsD�M�����e!_��Z��G*�r�;i��9X��p�d����'ˌ6ky�}�V��\n�P����ػN�3\0\$�,�:)�f�(nB>�\$e�\n��mz������!0<=�����S<��lP�*�E�i�䦖�;�(P1�W�j�t�E��B��5��x�7(�9\r㒎\"\r#��1\r�*�9���7Kr�0�S8�<�(�9�#|���n;���%;�����(�?IQp�C%�G�N�C;���&�:±Æ�~��hk��ή�hO�i�9�\0G�BЌ�\nu�/*��=��*4�?@NՒ2��)�56d+R�C��<�%�N����=�jtB ��h�7JA\0�7���:\"��8J� �1�w�7�\0�o#��0�r��4��@�:�A\0�|c��2�\0yy���3��:����x�\r�m�At�3��p_��x.�K�|6ʲ��3J�m�8���^0�˪\"���wR��S��N����-X�,�dO!��ifE�dn�G&�Z�!�6��\r۴Ci��=@Z.�-j:b��9\r��Ό�#V�&�N󽯯���l����u�B�)���M/*~���*������3�I!J	t������0�p�����D.�_#��(h�P\"hGH�.��\"b�)d2�F�)t2Y�2i]/4]LY%J���iU8�k�B`��.L����2����M��{�G7�sp��q]�6eE��I�B�E��B�����ُ�AL(��Zۏ:\$d�����DZH)���s�ך��E� �2Tp��6�=�5��`��P��6���a�\r)��C;	\n�Xe�b���[s�w\ny���IZh�#\"��Ȟ�љ26�����!��X'�VEQ#:��rH��B(�\ni�P��	3��N*\"7�DD'w���K�v����\0��,RЩ���i	\0.%Q���A��(1\$�G@�`Z�Ї�3� �p	T�zB�9S�I{���-�Tm]���2VK�)3&�̝wҁ�9HO�Z<;���>�+����2�A�W\"��!z�h�^H��0#���e�K�����Г��O�Y�S&y��2���R�+I�u:�i�?�\nCU��*�)� �O�D>S�e��\"�N��'1AWBb��D�d+1�����W \$�tr��Ǣ�hV�3(�P4���i��x�����	i�8E���\ra�E��V.�X�wc�~�2 ��2�L�ќ2�}V���gL�:'i�G�)�E���2�}�&�|]0����L��ǁdU�K�d2 �Ԥ�\$vB�y�9J�S\n�p��H�LA�1F,��c����6J�*lM��92�\\4��4�L�oX���1��/��qD]�%(5��4dw\$TY��G�B�/����	��,i�\\�A�!ѽi�Xi�hKˮ�' @��`l�/�NCheoA�3&��ê�]��:� ��:ۻ��4�������T`�Wlt	�#!P�[*�իA)^��q��3\\�D�I��Dʹ�@�G�ACB���(2mAAr%!�%������� ��J]���.���A�^W�'^�w(��\$EJ\$�#衛lw�\$�Z��p���)�O�Y]��̓�l\rv���pn�0F��w\r�1�մ؝�K��1�vK�\$�x�<�\0��!~���eGHJ�c�����Kh�)�R�Bg8���#0O��%B��+�>J&ir.�T�G����\$刿��}�9�D�(\"V)� �:a\r�iB�F�� � �A��,\$ڛ��;q!�*��DEC�@xS\n�>2�Y����V�ȩ�� X�f�+�:��S��5. ʫO�\r���Y-S�T�i�NtkLy�4�-��U8��/�I�r��vD�INk|�6�S�ۆ@�NK�<|�*�2��ґ^(�xl��m�ص��*�ϥ܅ӎ���j�{�\r�6�Q5N#��[q8Y��^?[!�\rf!�t�R�}�I+�kڷ�l�/��7�?���څ�(�<�`�*F�yXur�G(���o4���C�\0�i�nFua��O���]�\rdc߫_�U��b����6��cj�Aކ�;����,�~+�Z�m��\\�Q]Vv�ؿr�����g����v+�X�\\��gء@\$\n �1>�P�/�5�QK��_d�,����q�5�+�3��_X�J��s��fЁKP5�8��\rj��`F�&k�2*\n���J�Ȉ��&j�^����G�2j������Z����@'�x~���\"jO����vU���m8T�L��k�flG��H�:(�\$@*�����,/G����h�f�ڢ�y��!h��͂��,���b��P��J*�d�B�k�H@\"�bj#!K��\r�L\$��jƘ Nn�熊����/&S������%���*L�|En�e �\n��`���Il,�\\��P�ΦYΞ&�N��Ym�5��ZM�8�L�\$o@^1��Ԋ�\$ڇ¥q��u�Z���m�������&uC\0�Q>�bN��u��ؑ��+��͌��,)���Qaq1�����BF�nv����!�r����v,hߥr��Q�F(��qi(֎�F�#��(N�\$�c!1@�e�!�\"2�ò��\"�	��C��R/rA\"���;'���\n��B%� �X�n^-av=E�U\"�'�'be2~�\"F=��Z!qЂ\$aC�(b���Y2�L��է|(2��R�3�\\ш^��\$E��鞄q@�m�>�`qb����R�p�WO�r���RK/�8C��̺�2�nYn�Q�0dP��*��.K�ג7ƴu����\0�|�{2+W2sO(�x��5��p�3����5b�6��N�2��&N�k��7���5&�!�u�4vF�Gj)�nw&�w��J��K�#\0e���6E��C[<Ӥ#n����=���XWn\$.����0h�T>O^q�����;�'>�t�PCG��S8�Y8���H���43Z��_4�~h�0��lXRBC2i��C��B�D�4E7��(�8oMD��	�Dc�@�EF8�d��#F�#�'8p�����°a21�gH�q3`�T�4T�*��@�������\$�\$��T5)��@2_JԤ��K��K�L!aLr�'�L�uG�Vΐ��*r��n���5̧4�%�9	��P�����\$B�Q�w84n.�� d4�k�\r(1���l��E*�TB���z�P��t�����\r��2#k �*�\r�\\#�A&�xP5B���0i]W*\r1c�R��Q�	�Ԛuh���'n�u0�l�U6�z��YQ��%@=�.Tk�E�Hl�Lv4��t�#�,�C�4��9r-�<��;\$u��K4��_/�Fd	O��d*�;av���vDv\n�n�bIf�v85�=M4{aGX�d�8��E]O�ltd|�*{��8NOa�l�f�=Ȗ�a|#' ⢄ֈ%�,j��4>1�(����p�\$���^dNN%6��C��5���N��Gq�%s��M�k��`s�FVuEVd����x��}V��+m��&��u-6���wbt�N7'e�9&H�\$,\\R�6q�E\n0�(�7`�!�OsB�-#_u)\n+swInnaz.���RS�tp�ew7E� 01g�Wi�TV�)Q7�*5��e��et��!��x�����J-yu�;�\\C�����IT��׉H�]�-*�&GԮ�Q�jQ�\")UKϐ�w�M�~�U�	\$(3)M�D�w�����#4���<.�!)��Nעx,Iğ���#e�_q����n�F\n�T t�1׀�	e����;c�w�TlB8h�\r�VS\$T���B���;e:���l�p|��u%]dN.��-r�Y�*l3B�Uº�8\n����qv�Yu���h�\n��O'���l��f�e[������/qv1�������V#	0��X̬���6s�v0\"��	jf�QFCx�Z��z��*\"٘��n>�?(�;C\n����`�`@AW��f%�s*%�t&2z��4o����xN�X%:wPVq6�8\"��K�vp8��T?P�7s��4�.YW+����IDj�D�8S��4�c��Zm<�x�645˝8Q�8W�9�����*�ك��˛��?�MaU�l'�y��d��T9O.��p\0�ČM��^�w�@+�D�^�dDB��9G��\$uEJX�\$0���3�7�����,&WŨH?kEjG���Ap�x�P\"Wo!�o�hOpG��ؓ�}����y��#h�/��\r��J@����=C�2��bD04�y�0#�&�";break;case"sk":$e="N0��FP�%���(��]��(a�@n2�\r�C	��l7��&�����������P�\r�h���l2������5��rxdB\$r:�\rFQ\0��B���18���-9���H�0��cA��n8��)���D�&sL�b\nb�M&}0�a1g�̤�k0��2pQZ@�_bԷ���0 �_0��ɾ�h��\r�Y�83�Nb���p�/ƃN��b�a��aWw�M\r�+o;I���Cv��\0��!����F\"<�lb�Xj�v&�g��0��<���zn5������9\"iH�ڰ	ժ��\n�)�����9�#|&��C*N�c(b��6 P��+Ck�8�\n- I��<�B�K��2��h�:3(p�eHڇ?���\n� �-�~	\rRA-�����6&��9Ģ����H@���\nr4���6���@2\r�R.7��c^�S��1ã�(7�[b�E�`�4��C=AMqp�;�c X��H2���D4���9�Ax^;Ձr�:#�\\���zr��09�xD��j&�.�2&������|�����9S�Q����<2\0�5�������s��\r	��rM�#n�(�'9	�4ݍq(����B��\0Ă�N�`��\r��cSZ;!á�](�\n��%ǩ��P�b�քH�1�C-�:D�\0�:����:�֍�V̌`�:��#>R3�+��t���\rc ʠ����H���C҄����R6&�_-d\"�h^}�c`��Ah`�0��p�&Mka[|�K��#�f`�7���v�tXĶ�Rh�r���\"������S'#^B�6����\0�Ƃz֘����#m���^���w�w�-��;ZV���l꒎��x�3\r��R'��iC12b�ސ�cp�g���B5C�͘	�	�r�0��\n�}�=a���@��\"r3��zk9)� ���:��HŌ��`d\0�=3��ތi�����*_\$!�5�#4IHT4�������JrV�M�4,�qS��O�F�U:�Uj�W�Ud��n�����,���LK'�f,��VQ<ZA���¦�d6DU��#Ɗ���\$�����T2�`%\\8�R D;���R*eP��`wU��#+0�U�'(R'����hp'�*���#pLֱ��\rяEu\r`��'I�ʡB,��D&�ܜ�XR\nb����G��O�G�0�cdE��Pύ��gޣԉ��UPZpnY'|9���^�� G��̇�rp)E1<�_*��2�0=BPȠ#S�:S�=NA[9� 9�\0�����cY*\"NSNMKu�ڧ�ۃxw������Qtjg�0�¸�%�)~��5r�_��R+7F�c����O���\$��E1��X6JB7o-=\0ij��Y-%���BZ�(ND��A��[���v�\0��9)	\$,<���X	�O�l70#EYHqf�dd\0���F�g�1�74���5\$�.�7�xI�>(	\0�¢�%��.S�l�8\$��AJ�Y!��E\$����\\é���5V�R���)�r�73�k�|Ea���\0����)�(�`�\ru~����!_k�I'���0���\rd��T��D�Av93���P�*[�{� E	���2�rcb���\n�	�%�\$���ȉB�o'��&�8w��<G�.��xD\n\"�e8W��I��Kh�?�\\[�\"��F����3�\"O5B��T�>x�ĺ'���yv��� �aEE�7�VчeREb&\$Ɵ��E�p:��vz�\0�t��s�u�*^�to�O�ś�xb��a&�R��?\n�xBC����\$�qB�����\0�.cJ�9{y�%�����`oi�A��+�WF�K��Ӄƫ�\0005Pd���f|��T1���@o���5���jC�4K��j�]��a�{,y�c��cs��\0(#,tQ�r��\\H�*���Q2�v�s��+R��D��*�z?�R�䟃���t4C�����C���fS�kafbpN'�\n����T�@��~���5�U7����5�����p	�m�B�ȸ�I�a����j��?.�(Ϙ�>;��7���rB���[�P��#�7���t�p==�g�n��#��,�3�SO�=s��a����ӻg�]ӄ�u�ى��k��>�\0�CH\$�E��?�����0��&R�)6'�������(�<���4D��*�~���lV\\��Iai�,���ఀ���xJ i`~��#@�mW�H+D�|��a�/�9a���Wį&�d<��]�gN��5�N���\$������ɻ����MO����W��]L(�����/�c�\0��Gj��\n�����\"~o�\n��:B6�\"�RB�O�h�\0 �� F���#@�]M\$j��\r�h	����7��^@��P<FL�t&�y\0n~�%��-`s�b�ƠPV��\00m\0��ķ/�ҏ%���)R'/�\0��tlk'�o���������cK����\0\", o4�B��M��.��N�@;�t\$�O�.��Ǒ\0����0�e��0����D�����N��X@컭|��C���z�p��P�T�QX�]!{m~�@�-���p\n��f\r��^��\"�F'��&&\n`��������f\rn�6%���ZE6&f�}���Nx����i�^����^*�V#f��d��6\"Ѩ\"®��\$�y����\$^�C�\nD�<\r([!mvLp�b�B�f�D�o�#Q]\n��2]R6�,��d�g3-E\$è�(��\$O�\r-�;�f9p�0'+\r&��RT���9〻�t(c&r��(��('/�K#�cd,N.	bL�����.���'Q| p0J-���\n�'\$p���Q#�.Q3P�e�\r-r(��g����'11�)�Z��xmS%�l�����P\$��1��d�.m�\$2�&�<س8N�QHR��:���v]�Z5�P�2-��>�]&2�m�J��S=�5�����~'�s#��7��JA}RS/�B��@<1�-r�K��ғĶ1��{�ȶq�Q0����x[�-,�%=\r�q,��]<���fʌ��6\$�1�C��(\$�\n��k��C\"i�@A��@�u3�\r�H\0�`�y���^��8Se�\"k(:D:�p2BR˔�\n�O�@�+�\n���p?�N#c���%�^�g�n���yH�N��De>��IHS��)��Т�L��B:#�Fx&pi`�G��F����J\$dh5��I�\\��6F\$08�G�#S�2(�;M�� �	�޸E��EP5j�b,�_+�Di��\r�ҬU �0\r6xN���\r-K!��e'�\r�G(�B0p~ǐ(\r�n���4���k3�cU5c@'�~�U\\Y\$�ӕf(ք�5L��#E��D��p�aC,&2�`��B�)�Bˣ'p�*�,�A|��5CZ@���P`���tՀ�,i`�&pa^#\nkZH�9#t��1�l��լIT�@�\nb��C��T�>��U�2c�?��#�dI�\$n���&�b��E�	\0�@�	�t\n`�";break;case"sl":$e="S:D��ib#L&�H�%���(�6�����l7�WƓ��@d0�\r�Y�]0���XI�� ��\r&�y��'��̲��%9���J�nn��S鉆^ #!��j6� �!��n7��F�9�<l�I����/*�L��QZ�v���c���c��M�Q��3���g#N\0�e3�Nb	P��p�@s��Nn�b���f��.������Pl5MB�z67Q�����fn�_�T9�n3��'�Q�������(�p�]/�Sq��w�NG(�/Ktˈ)Ѐ��Q�_�����Ø�7�){�F)@������8�!#\n*)�h�ھKp�9!�P�2��h�:HLB)���� �5��Z1!��x���4�B�\n�l�\"�(*5�R<ɍ2< ��ڠ9\$�{4ȧ�?'��1�P�3�	�B�B��\r\\�Ø��`@&�`�3��:����x�E�ʹ�������x�:����J@|���8̍\r�L7�x�%��� c{B��B��5�)L=�h�1-\"�2�͓�3��#�aث��-\"p�;2c,��B�>�L�J2b:6��q�7-�q\rI-�sݶ���\r���1�cH�	q+Nr22�s\$�&hH�;!j4?�#�؟�`�%U�R�#�(�(�B��9���:�J�5�Òx�8��K&���b7�@P�4�k�7��Ԟ�*�{��c�`��>�1�n�pފb����89��u����5�=X6f\r\"�*��ea�mN&�R��ԕ\"��#�;\r�C��A`�Yˬ���� �\r.�4bx�C��3'J�^'��:L9�B���T�p��@#��2�ؐ@�-��t��0����+�P9�06�H�9[���)�pA[:��H�Tc�ۉC���>�[Z:%�,�Ǧ��{:��^*1�+7��4�*Q��1��	,O�j\n��P�!E(�[���R���D��\"��8�TΪUY�`�ܣ+X\n��=�����Z�hI)A�^P�K\n\\9�d�}��p\r%��?��\0�P�%E�u�`@rR!�I�S��S�������`#6���q\\uR�BH@�S�_�Y#bn��������\"HI�(o��F�r���Jid��җ	^���e�C42\"��2CWZ�݁�M�Ѵ��\0c/K�4���K�7�9Y�%�]NB�V-d9PЖejԎ<\$\0@\n\n@)#��'��p�xC@�BA�����Z��Z��J�KJ\r��k<\"r�ʁ�o\$�@�5㊗L�N�p��S�5S+�;�@�-��gPr&v��9q1a\"6�tIY���Ks�nXn��y���<\r�i�B�Oҭ\"a�ŒpҸB]>���\nX�>����d��d��9����� �䝰udJI�&�@'�0��ӥ\rG]q�*��EF�3d�0�=UM��A�𛔃IZ��3��&��[U	�΄#\0M�0T��-p3��l��4D�\$98����&\rf�:��u!�\rIDX�:�j8u,����f��N^���)@��l`5����2<�i!Š�3�Pn��sY'�\$B6O1&�l\"�K�l�qps��ؘ�nzOq��4�%%sGI�Y����jlW|�!�>d�|�^K	����\0�E���m��^Z��VT��R��^V����O��)\0('�2f��PZ��ŇE�e�#�IS*+�Ԕ���Z�DǇ\$!��'M�p\0�լzY%�8dCs\rh	��F�[�Ӡ���:��Ͷ����Ab��	k�ʄ#2�*9�|�]�f�cI_#C���bE͟eHJq�>\r��5�x����1Vg��>xQ�;JaP*�0cIm�̈́��&\n]\\�b�I��/�����a3P]�����Fau(e���酬��\\|ϠP­\\!z�x��\$�;��A�*�%[k}aOu�����k}rE6�s���b݂��v�\r�8���^�١�L��v�he�ڤ�k����5���[0��E����\r2�_�mB��0ujkN�o]2����[�'�D+7Y�ۛe�kHTU!Y<\r�<�.n%����\\\\�S�5��:���wq]����\r�d*����������6ȭ\$\n��X�H���]���TJ��l(��{s6]��H<��2�:L�t�\$Qu�fc0XZW\"����x�H*F�J�l�: s��H�iFC�q���ٕ[P�^�J�kZ0t��g{�n�^1���e�u�>�Mk�C�C��ϯ��v�ڏ�Իzm�{hg���9�84?�Ul�4����p̫݀v4Fk[BJ��`p��9[���	ұ�?;�Bgi�Q�����\$��^�1|���]��_Z�8������-0��`w�AH~;�z���j\$ �x��}O�\0\r��������>���t���'J����io.%E�\rmt��|�-��-���9;++���`l�0�\rB\r-��/*l��^׍�\"�%MS�,!p107p=��l-�MH0���̠����J�P�7p�!/�{l�����0��tȃd6�>7d�E�^�@��xD�LE�����#d\$��y��*b�&�Kc��c�6�B����c�n6��*�\$��\rC\$���e�L�P�����&�v��̒l,��KF^�bY	����\rbY0��.��Qopm�lpGV1dYL���/Sb���u�A�����7k�;��\$�lHaBX_�	B����\rc\r�D%l�P;P��0Y��1�	Ohϱl��x\$�ZcĢl��1�q��Jfc��c�1�!Q�/�Z���_L�ˤf��d��%��ʌ�'q��H �M#��� E���Z;�m�Y#ú�B���\\* �\$P�F��%i��F�~0���'��6\"�r.�	�/�8��Cq��p�߫В�j��I�b�Cؒ�K-���#-�5�_����%���_��,�\nq�R�v[��B����\r�&P ��Ȭ����20@���3�2M�	�:󥦙\$P\r�V�rP���'�~�`�7�\$%��������6��\n���p>���L��o�U1��ԭ�\n��m�2�FԲ�9�d>��C峛	ӑ:0�\"�0#E���p�x�d\r � \nO[\"@��3bZ�ƍ��4S�h�&k����#b�?C8��Z0�^	�ޭ�@ D�gT8c�F��@�8\$b��\"��l����.S�I���t<�E������Bx�Cb��K\n�S�EC.3c2�x��\$�6ŔT���X�feBaIf��i�l\rb@��'Bx�C��4���d��H�<��X�B���X\n���\$���G�0@\"�Mfh�����5�\08��&*�����dZ�F��n�����\\&\"԰��2�;�@;�\0�B8B���_@";break;case"sr":$e="�J4����4P-Ak	@��6�\r��h/`��P�\\33`���h���E����C��\\f�LJⰦ��e_���D�eh��RƂ���hQ�	��jQ����*�1a1�CV�9��%9��P	u6cc�U�P���/�A�B�P�b2��a��s\$_��T���I0�.\"u�Z�H��-�0ՃAcYXZ�5�V\$Q�4�Y�iq���c9m:��M�Q��v2�\r����i;M�S9�� :q�!���:\r<��˵ɫ�x�b���x�>D�q�M��|];ٴRT�R�Ҕ=�q0�!/kV֠�N�)\nS�)��H�3��<��Ӛ�ƨ2E�H�2	��׊�p���p@2�C��9(B#��9a�Fqx�81�{��î7cH�\$-ed]!Hc.�&Bد�O)y*,R�դ�T2�?ƃ0�*�R4��d�@��\"���Ʒ�O�X�(��F�Nh�\\������!�\n��M\$�31j���)�l�Ů)!?N�2HQ1O;�13�rζ�P�2\r��`�{��\r�D��l0�c�\$�a\0�X:���9�#���uۋc�c�f2�\0ya���3��:����x�s��\rYWF�����p^8Z��2��\r���	ј��ICpx�!�D�3������ښL��#G�(�O,�,��*�KƂZ�Ҍ��d��M������\n#l�㏭\n��7BC:F��#>�N��(��a�h�����ƄH��ʵ>�����ȺHH'ixZ�ӈ¾Dl/@�m�#��[��:����a�y�R<�ԠC&�3���k�+��5/!�'G�쒀�y~+@)��Ǯ��,�'prHI�T	G��.5F�sĠ�Q�fh��N��u�%)�i���\\����\nb���xtC:�R�zb�C\0Rx񼭺q��Y>�Ζ�IE�y�2hy/�\r&E�hRs�,3�@�����Ԍate/�L\"H@JqP*O-��ޠR��ŪVt}ً �ѣ���Ĕ����!C\$����na�ܛ�����f��W�<ɔ�\n���00�A\0uI�^���܁\0l\r�	5��@!�0� A�Z�\r��낀�\nKYD,f݌��R�A��ŋ�e�d�A��H�~�T���\"O�b+���\"�\r�*9�9D����H�j�4��C\"�Z��m-ż��\\ˡuI5��z����F\n�A��`�M����矃�\"&����pY��9.�X-VЩ��oAP	E��P�j�:�5z5���xx�mH�&���[�}p�5ʹú�]a��ܼ�EH�%%���Chp9a�x�Ij��ϟ�1��@��Z�V��C��Z��R�ѯ��(E�1e�!�A��'��Z�p�pU�I`�e������FOƊC4�V�kDz_�b.YGd�RrDg� sv~����Y�C�2<��Q)#/zdJ�ahb���&�\0�*�Z���A�^L��'�L�4�;�X4���s+EW!�:��.\r����eѬAզ��WI���9�9�E}�q�_�8Eş5��E�h1��C:ߦb�6�\\pK��[�+��oH��挕}o1�`�5Y��q��hQ,D��݌�L����Iy���4�S���@n��h筠������6�֫�.q)dT[�m�d����xS\n�x����u�ʫH*��M`\r&j�Q�od�luK�����9�яFJ��s3I�'d�|�'�P�Ѽ�ȸ�ĥ԰���5�j�J��R���ʺ����\$`p��r-���&I�[�hpP�!e��s�	�8P�T��Lr%�T)����V�@�H\n�`�\"P�s�t��X�=���	(%B�@�U#�qCX&ɔ�>M0�\\�qT0�E\r�K�/)�V��DY[�)(pO��dH\$�s(�͵���_�������c�ʡQ�\nB�kS�����Tq|�H�8Dk%�-�)�E_(�\$���l\"��v��;a��b}��B��^@a�5��X�D�V��Q9�a����v4��M�j�Z.T.6��=��9X>��6�}�A\$��:���39*2Oy�\r��J�\r!��i��S�.��Ƿ��5�Fi��i�)���M(�3�E�[���(�r�}#|0���Z\\	�eB�`@ALM��c�p�]���]�v���~TY��+m�V�=�S���@\nw�����<��%��R\\Ie2����pN[����e��C;�f^s�(�3��C	\0���\0Ҭ������8X3�7�;����A�R�K����W��\r�� _A�(�S|��� �G� �j��D]�����wێ���P\\~�7�Z��/�c#������Hg���������R�/�'o��/�ۏ����GO��Fnv*�e046\n��+�&�ă� ��:gG!��P������0L�o���iʹ��'�pJ��%\0�p�)~'P`�~�0��\r���p�4��\r%ZV�d�<\$κx\"耂�I�����Q\n,t�9m`�Lb-�cp\$�\0)��� %/\r��Gg� �*E�Q�Dv�|b�vFh�P���>��b����0�B�b�0c\r�=��*?/��FrD�|KTP��!��B�VˤO��f\"��o��D���n\rM��NQX?��<1Q���̈́�������Ϳ1�܃A�~@�*ě����w�d~��<�c7�@�1~3�x�*rM���p���LD��d\n#�����sH'#V���L�%�F��З�v�1�4�qc\$�\"Gn���B�Ϊ�=�^>M+!\n3\r<Rn�ޑ��1n��ڐH�j�0d�%�����&͟'\r�'Q�'�SRY&�_'1�1�/\0����f�B�Q�+����-C����6��B�\0�2���2�&2��R����d�\0R�&�O�*��(�d�Ga,��������\n��ˤ�2�۱���c)3��1����2,��L�1�k\r�u&���&���B�.m2��U���g*�I�>�-�6 E�w�٧�5���eBi�.�D�){)\"�8�H#��1�5��AGD���ͣ��!3P�s2G�1n���w9���H�v�ҡ#読�7��f�\n���2ң32�eS��&q:�r��@&�7���O֎N�-�,���?��3!A�&���>�����B�?@��@��m�s\"���MA1 �TMC�-%5��Dm�?���\"I��#^��@>��FGn�A��2���-?��&��/�GBS/1uH��+J�@�ĬP�}��>�p'n�A0f���FP�g�?��Գ��=�7GuMm�@����`߈pd3���\"!��-ƺn�*���1��P�\$�T549P�P�@eԳ?�승Ro�t���7P�:e��B�[E��bx��uQ4)?I5]Q�1@Hxuhѵ+3D\$�J��.Mo1IƵB�*���e2��O�\"�߂�d�4\0��7M��G�<�b,ч[-O\"���[�ԐZôjc����5�{��v���30��*Pn���bu\00040����_�0t`����\r�V,�&��ϥ\"G�=k���̎\r��+f��\n���pG�,��'p+,R�=���Ϩ����h�L46o��Z�k	�.�&\"m�R���fJ�3��F	�޼��.�Ĩ�oѯ=�W�r>/�m�kv;\0L?��cT��Q���`\r�'&H�v�O1w9�.�x%���P�Kav����m��3V�Up�4er*��v�-g`���d\"����#;� �7'��-����q6�m�~��Au5rF!,��և!1�:�5	�vc�\"H�#Ysoq� \rJv�(��wm��ӌ�иQc>bP�(�\nQ�AhR\n�x��\r��-�]d�v¬��F�>#>{3�q���(�M�}����ei2�i�\r�)��W+k��4������\0�8��P��xd�QcS�P�GtFf�";break;case"sv":$e="�B�C����R̧!�(J.����!�� 3�԰#I��eL�A�Dd0�����i6M��Q!��3�Β����:�3�y�bkB BS�\nhF�L���q�A������d3\rF�q��t7�ATSI�:a6�&�<��b2�&')�H�d���7#q��u�]D).hD��1ˤ��r4��6�\\�o0�\"򳄢?��ԍ���z�M\ng�g��f�u�Rh�<#���m���w\r�7B'[m�0�\n*JL[�N^4kM�hA��\n'���s5�dt��'a0Ay���#�k�?�잯H@�3�.H�9>,�'�hڅ��\"ܷmh��J��H�:B8ʴ��Ò<�C*�)�c�(�<�#�ɨCh�	���(�8�Ю��0�R:\nX�0�ɒ.���H܎���6������:��\$\r\n/(c`��K��7 r �#%I������� ��\0x��(��CCD8a�^��h\\�K������zd����;�!xD��k:�(�zz7���^0�ɠ��\r�T❁B�<��c��:��\0�5��W�#P�?x�/\0�KpJ�C�>�a����X�5GN��8V�%)A�ִ�0��A�L��AR�P9���2ֵ��è�]�5Dg���O�i����Lb�\nm��.	3�~C(�x����*�����;�a���2R_\0�7Y��5��(��hִ��0�b�b�!	`%-4�#���m�\\�g\r�\r�I�]#j�F�&3�b�:�H�8b�@�<m��O�:�j��Ӝ�\"@TkX�Cd� �`�3�d��	�JS5��@6�L�'M#�ǜ��+Z#�X�Ò[)ാ�%#5��H��r�/-.SCg5�s�t��L�F33�?Suco[ˍ�[�-��b��#�B����4�iK9\r����*�C���:��Ț;<�H�8H\"B��R�]t@���TK��%,@Φd���P��D(�����QK�^B�U\nxB\$UR�6A�M0T�d�x��W�	+�Lo������dO	� ��`II�3N��?�T�P�%E����\n��a�J�vJGʬ.Sʁ�b��!�� ����&E�y\$x���r2�Zk�	9(%#di\r�� а9��:�Ql7�R�FXˊS�N�s��F#��@�1't�I#�x	b7�@�P�)�A��3H[���.h ����e�)'�΂\0���'�ܩ7XN��d*������R�/.��0�CĚS[\"M��s2f�I���ĝ�#XV	�L\$X���ORS�t�W�`i�{�%Ḫ�s����h\$��4Ą��ttm��vp���J�22(zM��ly�Vm��g�#���[1nf�tO��CsTMՑL��)�N��� *Rd3 �J]S�=r��\0):A�( ���̆Say�������� -i���I�Z� 	�u�ǒ.�H���9ՠ�qX\"2�N�%JI�y,��}��ZK��%!*0s[[m�ĺ�'~��U��T�����1�g������BHDT(\0�B�E\nA\$'{Ah�O\nAP*��e�[˂~J�v���?�VTd(�YI�.u8�<�r<�}�IZgth����Z�!C�����&�Y����1�����x��_ו����oBG\n��HGtթ�\r%ܽ�Ux�ϵ&���6��Y/���D�G�H�1i��T&W�rZ��&��az�_�B�`(�)�����xl<�|�� M\r�.zq@E��&Y%�·���E\\���cr4\\V)Ⱥ�/��ee�nwe���d�̚��wJ]���qRd|J\$z\$#c�C��gAR��\\A���P���~Z�j�E3�\n��Z�2J��)�䫿}Pq\$��L��D�	!��E��z�'��stkgQ\\!J�uK�vz��TK��yz����`cC�4�5)�/eQjQ���v�k]O�!c�[;4�}�64	f1�A)���ä��2�TQ,\$Ď�R3�S��()�6A�(�7�r��%�K\0�m�%�q[n�jiq	z�`<�L�?jF���c�lN2f�0�⭍k�E�\"#��o͒�>���NPv���D\n������1Mܕ,cC�y�'�tݺ��s���;\r���p�d�2������=�d���γͤ1��\r˰*���\$��Ƚ�tn���[�E8�Q�AJ�����7�y����}=t7��H��8]&g����'~ \\��y��o>��-��<�Oags]j�1��^�>|��?G��.�1��-b�,�A�9nn^�;͸���_�����<����E���C�o&���{��D�8H�?Ɩd����q�2,���x�N�6Y��z��PD/��)dL�(_3���.��	��n�k��#�l�������N���<�\\YnX��^{Ί���Ϣ/���>JP�bhϐM.���>�@��:�b�.�9\$�D��@�c��/V��3IM\",����.h���0��N�N�����\\�^�`���.��:�8kP�`fF���/�zX�ZF'����\\��������o\0�0���g��P����A���Ɩ�����\r	u��_��CpJ��h���`�qC4\"�@��.{h���\"��~c��K.7?\n�D&��H�\$<�;	�L\$�pӰԐ���i�'nP�	����SC:��.�	d�h��'jDZl��[)N�c�l~�V�ILY��1S� 1�hd\r�V\rg|.���)���5*��	#I�#P���\n��\n�Ϊ���H��ұ&�0Q�!��#�\$no6�'z���\rB����N�C��c���1c�jd�M#�{q�8Q�_JRq�<Bbi�x��Cc��t&��%#����\$H�C`�1�ivg��΂�����?(�g���0\"��P��r�\"�r�r#\"���c:9�|����*n�(	��(����T���/�9%����fAB%�-�x0c�.Xb�B���:�/�����'�|��r���H�3n�,&.{��)*J��e0el\$��'�We�\\`";break;case"ta":$e="�W* �i��F�\\Hd_�����+�BQp�� 9���t\\U�����@�W��(<�\\��@1	|�@(:�\r��	�S.WA��ht�]�R&����\\�����I`�D�J�\$��:��TϠX��`�*���rj1k�,�Յz@%9���5|�Ud�ߠj䦸��C��f4����~�L��g�����p:E5�e&���@.�����qu����W[��\"�+@�m��\0��,-��һ[�׋&��a;D�x��r4��&�)��s<�!���:\r?����8\nRl�������[zR.�<���\n��8N\"��0���AN�*�Åq`��	�&�B��%0dB���Bʳ�(B�ֶnK��*���9Q�āB��4��:�����Nr\$��Ţ��)2��0�\n*��[�;��\0�9Cx�����/��3\r�{����2���9�#|�\0�*�L��c��\$�h�7\r�/�iB��&�r̤ʲp�����I��G��:�.�z���X�.����p{��s^�8�7��-�EyqVP�\0�<�o��F��h�*r�M�����V�6����(��ѰP*�s=�I�\$�H������D�l\"�D,m�JY�D�J�f�茙еEθ*5&ܡםEK# �\$L�\0�7���:\$\n�5d��1���8���7h@;�/˹��٨�;�C X���9�0z\r��8a�^���\\��ct�MC8^2��x�h���L\0|6�O�3MCk�@���^0��\\�����LD�/�R�����^6fY�)JV��h�]H�K|%(b��0��R��1d;Na�u\"/sf��U�o�)��uM\n�����W��zr2�CV��P�0�Ct�3�!(�v�x�z��^�C�]J�X���x��\"�A�=�*�����e)�_�rկ��H�Cc\$��6Pʥ��7�����0u\r��:7BBr�AV|����;H��A-E0����eI0�ѫ|'��F��;�y&�\"X�+�Y����ֈXK�~i`�@���s�`..1V����l\r��;\0�CrE\n!0�=�������PLQR�_n�+��\0�Nc�Jq�:7X+�i0\n�̿t0���4��>�d� ]��C0�H��\"�sH�^�g6qc�!{ϙ|/�\"^���4r&I�P�\$��/*X�Ett��Kރ`����d#󉥾Ah�ɴ�B����O�I�eQ����3c�u��ؑH�ݢ\\:�iIԟ(%4Ǝ��Gxl�� B�����/��D�9\0��w^a�\r�3�8p��U�	P����+r\r��A �Y[-�\00Β�CX����AI��Y��0RW�S\nA�3\r'�h-N|��|��h.FJ���L���0�.b9�n��\$�s�L�P�#M\n{�&=�gR(K�-�rd�8]/�r�+�P����e��1����cPJ\00021֊w�CJi�9�5&�՚�Mmu��>�`��m\0�Ƿ4�ݛ���[�dj�R�&��j͗~��ؿ��nL��P�KU�>\$t�dJ�*��F����O�qla͟���ii��W���Z[Mi�E��P���Պk�ɯ6��[��M�9��P�3`�`'@�Y��>W�0�����g�W��O�:�l�H4\r�&�b����.%�����M�c����4&UdS+8�@�1+����za�3\\KFn%�tz�3��|p� +;�z�LuY��:��s��J�ҏ)�\0((����J\"��<�ì��%��0�JZ~W@PCPMj\n<��yO9�=g�2�6N���?l��Š��j����?�jߌ5 �uJzvu�鿡�U�Rs��C�ce��2�����+g���0�~�h��3��8~1�_����bK�uZ�H�<w��k�Яƛ��*P����	J����N7�fT�fUR���n��l!�!�P1zϗ��v�D.�P���%Ω��T�+L�8�0�\n	\$|<��<^��d��7_#�|@q��Dd�k��kU�K&P�Pٱ��m��YׅOGuj!�R�xS\n�R9��Uy\$�_��L>�u.u�޷�k\$�����+�WLV�H\n+�nڐ:�(H�C%�������V&S�s�k{E��PJEfsR\0��.k���`����\r3K8RvI��! [�l�P��=��v�f�\$,W	��\"6|��P�*_�� E	�ư9�[��:s�cS�V�WK�5�����_�@Py��c.��3�3�)T�|!l����\0��'�Q�%H�\n�ms��Y0��\n�K0��JHJ(�_�ķdy�^Z(ӄ�([�+���T�k�^}�Ԇ7���W�)��c�V+j@v|�;K^�h\"��Ot����h��\$<�'�\nx��f�)F��\n]E����ʵ�wol7�r�(`��Vڅn���,�F�	�F P\nǘ�#�=� N8D&\n%0i\0[���V5np\\h֘)&K�?\$��J��쀼&�N%T�K<a�*���0x��0�e�\nF�i\0�\r�^��0��dp��2�&\n`�H�CN�h[�؂�������~�,r���zc���gB���G�vĜu�\"�n�r���ߤ�(�{o�,��	�@���R��8��*��+�}��JN�����ܐW�@�D����ojHQW���\$�o�s�l\"G-g �O��)���DLzCH��0��䚅�bƴ�%%:�pX��>Ũ�D,���Dl`�U����5o�	�V\"TKp����xi��	9QbO\n��`�L��d*ΆJ�>��a�R�,����0(\"#�#g���X�m�z�\r�&Q��r@F�D�h�)� m�GO��d5q\0�hg�&��:�P���(�%)A%C��2y\0c�`咫(dg�(O�*��)�j�o>د�qq,���Ғ�p\0���\$�Щ��\0���F���*��.R�����1ó%���'�6�J}.�10,���-D���i�(���'3,�҃3Gz��Jֲ�12������5���`��fr��.�m��͜��\0�d&(�(���c	8q��V���q'�9�R4dtڭ�=/\0�rS4��4�)��+�x�g��R�\$`��C=O��0��е9���0*q`��e1�Fb\0����s5�B���w��P��636��+\r�2ٔ��<���W��|�Z\0�=��Z�\\v���p#��	3!S��E6|O���µ��80GT~��44r�}6?6M�HTq.ʈ��ˑ{=3��t�<T�4-[I����\"����Ҩה��ԿK��\r͝D�AL��M�����4�#Lg�J)�K'�H��N��\r��Li��l����A<^�qg�<��Ǭ�o�'�����.��\"��s�.Db@�M �N\"5�r-�)T%Uetؓ@������3/��R�~.|���Q)��:`Q*�e*'p�4�,��I�;Xo6�	��GY @\n��0f�s6�����y<�\\S.�1��25�̆�gO՟1��5��ƃH�Q��5q.��֒��A^̣_�2���)=IvC�/�2�_G�Y��^v	K��A\\��T��?B�p5�)^VC��x�% ��-�a��cT �Ho\rg!0�)I�xq�q��?.5et�e��M�1f+<\"i=Rp�)v��r��@6ig�O%�����Bs&���h��5�#M4���TsZ��Y��i��Z4�n�p�t۲����7�ZL�@#������c.�A��d\\tSY6S�=.H\"qC��Kt��R\0� Q\0�L��e���r ˇ����<A��72�rlC�\0DͰ&�DI�A\\7p4�w9kC�O�x�\\V�r\$h�p!'���&�\\5� ���Ȗ�~j�7n��b�i�vT��os�Im�P�ďQ^�U,���.�h�����JW����x��M�v�RQ����6�:��.�p��AX(tu�\\�Ym��bV߃�7c\"a�v���?5�bgA:�b�UO����{�nۢR Ÿ��\r��˕ㅴ�c��+1�v��z��Q�����؏�������8�)X�����t�pXWa� !�9��j\"8�Q��E8��X�nɯ���Q�����XSO���C��Љ�D0y~��|����j��&�-��S̊z���-k�7�4AvG�^�-�{��Ei��c�Ii֋�6n�[o/q�Mh�P�xk�wCm��m�\"�l1gq23����(����Y�̥�s݌�������FW�8m����L~vj�1#Wy��*A��3`��AQ�h��n��`9op��Y흱�l��F�ɜyY�ؑ���V�j����8�y��ͅw �Y���/,Tȧ�xux��t��j�1� �Cq��bGd��%�.�Q�Vr�9����GG-:k ��q�Z[�:���tU	^��f�*�K�yNȯz��%�U��ɴˬ�������O)�w8��]�3rJwA�OU�K��4v�1�Q�#y!z�A��w;��f�������Ee��&-F3�{E�v�rz�5���UH�w���UGk��K���ٳ���Vz{��@�{Eb��6��Q@�n\r �\rd�L�b�h\n?\n\"\r��(g\"���\r�Vd�:ҏ\n���pN���\$�+��zRei���W�UX�ِ��R�Z�+_����1/���5x�i��t�2❽���lv�g(��}�'\r��zx�{�r�Z�2	��\r;���{@u�TB\0���\\�d,��y�)SB��׫B�O�ƆA\\C�u\r�p:l,D/t�� �9��m�d?�Ǣ�y�V�(�v�}�ٝd+i��A��{|\r~�\0t�s���]����H�#�_�5)1��*�O�,��bvx��W�e�j��[b�x����#��Wc��4�m9Wh��m�N��;�����O#Q7�Mv�д+s��0Ɏ��{\r�m��Mש/�G5 ��S��I&8��߭�q^6R�0\\�=r`@�f`@Ɛ����������\r�-�����,'���f7U�x�#}�;=]�(g.��0�}���,�8ﹾ��\\�>���7��I]�\$p6Ë0,A�s��\r͑�Kg�������r6\0�\\\0�=�}�xIS�t�о\$�Y5�]���pt`@�	\0t	��@�\n`";break;case"th":$e="�\\! �M��@�0tD\0�� \nX:&\0��*�\n8�\0�	E�30�/\0ZB�(^\0�A�K�2\0���&��b�8�KG�n����	I�?J\\�)��b�.��)�\\�S��\"��s\0C�WJ��_6\\+eV�6r�Jé5k���]�8��@%9��9��4��fv2� #!��j6�5��:�i\\�(�zʳy�W e�j�\0MLrS��{q\0�ק�|\\Iq	�n�[�R�|��馛��7;Z��4	=j����.����Y7�D�	�� 7����i6L�S�������0��x�4\r/��0�O�ڶ�p��\0@�-�p�BP�,�JQpXD1���jCb�2�α;�󤅗\$3��\$\r�6��мJ���+��.�6��Q󄟨1���`P���#pά����P.�JV�!��\0�0@P�7\ro��7(�9\r㒰\"A0c�ÿ���7N�{OS��<@�p�4��4�È���r�|��2DA4��h��1#R��-t��I1��R� �-QaT8n󄙠΃����\$!- �i�S��#�������3\0\\�+�b��p����qf�V��U�J�T�E��^R��m,�s7(��\\1圔�خm��]���]�N�*��� ��l�7 ��>x�p�8�c�1��<�8l	#��;�0;ӌ�y(�;�# X��9�0z\r��8a�^��(\\0�8\\�8��x�7�]�C ^1��8���8��%7�x�8�l��Ŏ��r��t��Jd�\\�i�~��V+h��\n4`\\;.�KM�|�G%6p��R����\r<1���I{�����B��9\rҨ�9�#\"L�CIu��&qd�'q�c�|i(��Qj{\$�>�\\V\"���7��'6���RŐ�`���߬�B&r0��f&;#`�2�[�)Ћ��*Sw��t4���\n��6*��G��%^�U�\n�����l�\"�\0(���IHq߻C�OIڥ'�8��㾇�+-�{,��J��_\0(#>���a�7?�\0��D���)���ձTC*h�!T/ˑ��T��S.� \r��\"�'����%�C��[	Yo����h�R�c�턓+(MaނȵsƢQD�vhJ����1�m���ʍ�[�tB��EUb�|��!>�:��S�@(��N{�xf�����X�W��;k�\r��ϓa\r��UX�τ��Ҩsfa�9K���\nUH�������<�VQ�<2U\$\0�Fu�T�\$�^v͂�-ԜH��<��0�s��\"�v�ѷZr���{,����!X��J��,x�q���{A�k��^���D�M��1��c5=l�3�|�Dh�\"�4���Zx/a��:66���bJ͕�����[u��=<8q��� ��jK\n�'��wP��_g��-Ꚁ�3hy�PMd��5 ��يm�4�����6��ힳ����(wh�\$7&�\\�sPPjC����BHm�6���Q�xU�:��f�kk�L8&�ue�]0+�;����9���!D�h��=Q ���n�}�Tnʺ���c�r��8o1�Ble�[p�l� u�����,�:G=\rOS���͍q%�ǗX�1ݽ%����w	g�P	@�\nc��B�mB�@\n��^-��U�PCQ6ܺ��|���?�2��.���A,E�������+��^#;�T�V�75���C�Rc�M6 v����e���:��#��\r!����uO|;����%zR/o�	�߄�.�K%U��º[��6	��e�v�STe���ǔt���B���JOK\r\r.���6L��?��8�p���2p\r���0�|��d�W�#���T�K8�_�!�t]�O`��\\�]I�o��r:�<�Z�4�(�!�#�QvՇ	���c�u�����߁�f���֞}�b��!�d�\"0 �lvB������4�&14�b���'(|�\"�d +8�dU���2Tg�K(��xNT(@�(\n� �\"P�x��Y(�o�d\"�H;� \"p��5��9�br�\"\"�Q')g�\"~v��t�E5L�N�Nآ�(���`��sJ�ktd���ipp�Œ�ۉc��!��\rCZ\$��z�8<`���Ѣ��S��oAc�b�\\�����\"�VB]b/7%GS�����=XЫ����Q�R���!?�̸	�u���R.z�,+.e����\"F(�8�k� �_�u����1�hpC�c�9\n��0��F�Se�Ts�np�X7�&�+>�>�;����d��-����L(dV�1�N��s��E~�x��u�������P`�t��m��nB���\"&�.�%bq��9���f��v&��>��?iFDG<'�~/;�F+/�DM�1�L<)^�%bE�8�js�^Ԃ�V�ˎV\"�pF��t.��嚋ÒZ\$�Z�t�� �	\0@ѯ�b	Nċ�>@����~m��ä�e^��@�1DJI����\n��K0�K\"g(�j�s��;uθ������F�/d��\"�h��bWG_�w\r�\r��Pi�^i\nw������E�\$�&�	��e @N\0�u�N5g��g�c(��'�B�x/`9Qn�P�q+\\�)��0L�.� ~X%�t'v\n��FLM��M���yЌBCZ�gڟNE�J-��H��XX\"v��X0RX1tnb�n�P9�h9�zSÛc��_�L�hVf�.|X�D8Ð��P����1h'h:V/N�g�B�H1FTh! l�<.{\0Q�X��\$�;���}H�p\$V��sqD�Evs`n�V\"�;r*b�'�0�r~XD�mR��\$�P�� ߲���5�'���f�I��/!n��e��������N\0�O\0~+1�H�q��C�h+f�.)~\$).�5*�8�ȯ/�.o�IΛ,�Z��ro���C���r�A�+�������Ĝ���������N3������14IN�'X�'1����E�5��,s.����sx�h��c*p\r#�1��2�2S��f�7�i9�̬eJ9�\"��Tpb�b�&�;H;�!P�%��u�\rbT����f�#�A�f��\0\nD����#��)M�?M�&s���3#h9��7�:'@r���~4�0��)�~5�D�}Aq�P�Do�)���7\0@{H*~,d���;�7�Ρ��?E��sԛ�q-)�F��n�(�G7E���vQ�\rf<4Zv�DwcE0Eh/?�@��9h��	��MOT���.�(�K(c�Su&��J�K��;�Ȍ����\rG-B�OtA��7�C6�q�C�|�TC&��\r�f����#Psκ�	�5\"?t�PT�%�uB��j��9T�?�C�Z��!9��U�2�56�;8O�%�x�H��q�&'tg1e�:#h+���B�~F�a�8X2�<0L�U�X�qot\nFVargVsgQs�\\ɳ]��P��\0�']�	]�z�����J5oA�r��#O��j\r�*Q3�`�V��N8��g�J6�����C�\"\r�'b��\$�PX\$�T��P�c	���`��1_�9]s�f,�fu�6�a��Pu�*�q�gui8c�D�@�yU3�`��/c֦M�a�EW��%5J�sg������Rv6�u`��<0�lk_��D6�Xq&ߖ��1��V�+\0�d����S#L�ˌ�'�*+3�����[=�,��\rP���TB��T-�n�5��gZ��ZB�&��\"�>po��S�'�sg>c�G.s6�����ɘ\r�V� �`�ג����M�\"3%b���\r��bl��@�\n���pOjJ�U��8��Q�+�:�j�Rn�V�r�mI>�μ�I��*� �{��.^.�v[G�9�� 	2�y(�L�6��nC=�\"�x�N�w�\rB\$uqmV}yn�p� 	��ۆ�gDA`��uG�����R�V��Tg�n��X2<��+2�'֖����4����r�hǉ�'��uq�6��)�5ӏ6s�R�h�m�@\n��?��=̜��P\0০�+S~R�DEuP������L\"����Tq+�i,�GH�4����F�x�I�Ec��\"�2tn%��x��D�K#�΂s��c@���y5�d�uY�\0�vN'�<��T��NWH�mP����#��*c�W��E�/��q��x��T�8<3�,Db�)���@67D\r����@�tyǂ+��X���kW.���w��	\0t	��@�\n`";break;case"tr":$e="E6�M�	�i=�BQp�� 9������ 3����!��i6`'�y�\\\nb,P!�= 2�̑H���o<�N�X�bn���)̅'��b��)��:GX���@\nFC1��l7ASv*|%4��F`(�a1\r�	!���^�2Q�|%�O3���v��K��s��fSd��kXjya��t5��XlF�:�ډi��x���\\�F�a6�3���]7��F	�Ӻ��AE=�� 4�\\�K�K:�L&�QT�k7��8��KH4���(�K�7z�?q��<&0n	��=�S���#`�����ք�p�Bc��\$.�RЍ�H#��z�:#���\r�X�7�{T���b1��P���0+%��1;q��4��+���@�:(1��2 #r<���+�𰣘�8	+\n0�l��\r�8@���:�0�mp�4��@ި\"��9��(��.4C(��C@�:�t��2b��(��!|�/Σ���J(|6��r3\$�l�4�!�^0��<p��+6#��@��m���492+�ڼ6ʘҲ���Ƨ	⤪YP�\"[�;�����Xț0C�����ԉq���/�����(�:C�;0 �RAb��;�E�)?^�u�N�փ\$���%�L�D�_43E8� .��:�+f, ��l\"4�-H�ϥ�������Ym���lc�Sq��(���<��P�Y��;wW���z��v}�O�.��O\$V�c�jz���/p�:�����p@��9�c��m�z��qȂ5�H�|�����k�Ųj�0�VLb\"@T�Y��\0a��j>6���>�m�p������rd;��=���x�l�L�I�b�V���̖!u�o�� �k8.�\rn����D�Û��4a@�)�B0R\rL��:��9\r�X����3���{7ao����n[�\$�\\�'�qc��\n�>s�d͒���Xk]�莑�F��|O�A(E�PwQ�9'e\$�p/&g�d�8��%��L�C!x,�^�T�c�v�v�#�L��uO��@�LA�yDa 58[\0���meP3'ӌ@��O�� G�l'����VxP��,�I?��T:�Qj5����Ԩe?'�TB:���)��/\"�n���E����rGU��7F��Fb�O��&f,̑'�ڍmC&a����L��5��O��b�ȸo�F壊wt���x����rV�\$&M�\$NPpn_F��%'�HRq\n (���P�y��W���V0���y[a�K��P�H�E�,�˔���E�����X�	#<�m�稵YD�&ĂS͒NATGЋ�4�d��M��7��Ӣv݌4@C:�&ƺ��	�SI'%-���(�K�\"�,5�ܘ�,�'τ&DX�@�j�#�d�&5�Pb��'�L2�'��Ð'�dd���tSI�4a��/�R�V�r_R1Һp�^�x3@'�0�MOHiO�&6KZ��Q\"��>��F��L:��Ή�8�=nʠO�8F\n�T�69`M��r�gٟ�fR��q�\$�JV8oҲ()锁��\\q�p:M編V'��PH{����\n�YS\0���\0U\n �@�7A�O� �c%UZ\rR&���AMκ\"���u����r05�\n΁Ƽ��t�\"�Q�3gf}>�7xwC�'la���T�rN��#����i�r��u���\\�[�*�!�_���E=!���\\��{i���!�8q��L��ǰv��Z{�l�Y�O\"Dʼ �5cP�^��D��,�E��/h:>i���9���y3%���[\$f%:A�Y[�W��р@�%\\��s\\f�,�]������\rb`R9/-� �\0���%���+�儲��1#��9�]4GX\\�k����.��2����a�g�0���0�n�\\�F\$_<	S�h�����bcJ%]�h�\\P����gD'`�\"�ɐ�)Ӻ�P �0�p#�ٕ��^��@��SRA�2�̷�\0/*�j�g����@��un��Uì3s�;-�vO���Q����>�	��w�����Z�����R��qc�w�������a��\0��k�%�&��.��z?]�+%u��z���'{��ZU�|[��W�s{�����r��)CE\$���6t����5�~LL�UD��v!��(b\"���MC��\n睹�Y�S6�lǨ��c�Gh�F1�ͭ��y&�AHZ܀��l����/9CR��k6�Ǖ�B�3+�|��䇷Z�0༿��:��L.%�˚5p�� �������^��5�R�����̅a,E�x���`�\"5�����)a{��xJ�Knb�M��Ԧ	 ��M��t�K��]D\\l��S��%�vю������5~3 � /Xj���/���ll�;(��&���^�HT]��7\0@�b���x���N����@�d�704�8��[�F�D�����Ft\"��-^��b�p\"��u���eojԭNA�\"�F����LmL(j\0�/І�:lEL���	d�	��@��9�h������A�X��`0����0�,��g�j�l��LZ.F�k��\rZYK�8-x�m*�����\nz\r ����/_�\"�i�|ґ#���͡l��0P151g�h`�-I��GLH�F,�C��#�A�L;��T�DA�u��m�M�1���U\r\$��_�;�*���&�\"4�BD��YQ�ac�QJpѰ#dI�Vb#hd�\0�\n�tY#1��q\0��'���nY)%�C1c�D;�XEm��o��B�RkrNڄ[\"q���@�r~�c�h��@U�F����æކ�2ǋ\$���|ސ?%��²agz�@�\"�l^��9p��Θސ^�n ��5����F� �c������.��8 c`%�\0�D\0�e�/洭��� ��Z��\r,'	ړ.i��+Dr�	\\��f�R�/+lV�'Olgb�f&9�%+��f\$2��PHb�s�s\"���\"e1�f\\\r�;e�s����\$�B.�'Y\nkT9%h�I�#�@gRq��\n�{�f�0�,�Zr2d��ç6'��7���z���Y����}(��� d�\$){_9C�7���W��ݰ��M�BJ��`��!>h��#��=���C\r�Xi�4��_������\\�Rr�4E�/��I����pc�?&�r#'�\no��S�F\"����9�l\r��>?E�\r`�\$4i��A�L�؋E�\"�";break;case"uk":$e="�I4�ɠ�h-`��&�K�BQp�� 9��	�r�h-��-}[��Z����H`R������db��rb�h�d��Z����G��H�����\r�Ms6@Se+ȃE6�J�Td�Jsh\$g�\$�G��f�j>���C��f4����j��SdR�B�\rh��SE�6\rV�G!TI��V�����{Z�L����ʔi%Q�B���vUXh���Z<,�΢A��e�����v4��s)�@t�NC	Ӑt4z�C	��kK�4\\L+U0\\F�>�kC�5�A��2@�\$M��4�TA��J\\G�OR����	�.�%\nK���B��4��;\\��\r�'��T��SX5���5�C�����7�I���<����G��� �8A\"�C(��\rØ�7�-+rݚ��h隄��(ɳ˚l�F\n4P����d�	�+\r���&�\$��A+��hM���3m�Ҙ�(☡��5�����4�+42^ՠс�욲�(�b4HєTKH�4��Q�r�T�Yx�)�a��e��P�2\r�r�{���0��0�c�)D!\0�f;�(�9����8V��q�c�x2�\0yo���3��:����x�\r�eG�����p^8]�p�2��\r�������cpx�!�ր�e�_K	j!R)��V����@\rZ�@*����a�O�G+��顿\r�@�6m�ڿ�*�hf�m\n��7D:2��#@�%�Nɳ'5�ղ��E\0�TҚ�\$nd�I)�O�r\\�P3ɠHB����l���M�Rh����:����0�����9[���^�h�k�.�q\rR��2}ks�1Ft�ePAh����kJ1�x�t�jN��	]^��qkA?&HR�QT����f���AB786:�B01�#t:(���V�@H���7�LO-�/�f}���h%%���fS�Z�&j�4�f�8�#��P�B�`{6V0M��H6�^�qkՖ�Eb�ҵ4'�׍UR�x��	T���/MpYNA�\$ӑ3�-M��8B�Ԑ\n�	�VTV\\`\ns���׎@o��6,�NՍhT\r�-�����Q�em�g8`o�9���8a����Hn�x0RZ�ѻN�ܡ)�S\nA�*��q#�8��R�]\0�,��Q�\"HJfq}GdJ�!�N�Q�lP��0Q\"��C��γQ�np@��\n9^!�*% Ȳי�^��}/���`�%��&�Az�H�ѐ�P}8�!dl���ń���7hFD���#�.w��Ob�̗���r*PO�-��*�\"��6 ��M\\gza�\0�Wz8�4�`�&f��^��}����Xw`�7#�\\cI�A)%F*��HmH6���:��C�t6S�P�kckH8#��O�jXcDK��TT޺w���B8/\n�x�����-�ȕ�\r��1���=l��3QE�(�n}�9�u�x�d#���\0�G��it�Dg�Ĵ6o���|JIrk\0�(��l���G��\0PY�M���?�>�hYP�|F>\\zX1���OT���r-ڎsNy�:a���P���Z^����s,i\n?qA����Yp��0l���ƎX��[�͈-����\r��A��.ě(w<!�4T0��� ���>��Zc�i\\Y�e|A\n\$7����w�A\r�G)��Pc��m�&�YT'Ae&KI�w�Ц��,'��N�M�PYDY��I\"���,���NR�\\��������kH3#��1�b˾(�1��`n�:��I�,HsPM�X�b����<)�G��(�N	��C�OVh*�ϔ�F�p�u��Y]��k�M�{�H�T\$��I�%@��	s��_b7;QŃ-��\0S~\0�3\\�@t�F\n�AodH�N��~ə8�#���PkU%����0�혇e�3!RVA�#�r���	�zI�/#�f\r\r�@6��qlhCb9��ʭT2ܚ5S�h����)��`��{�j�l����w9]��)���NBY���N����\r�^+�T�\nw��\\T!����BV��\nn\r%�*\"�K���Z�fp�8b9�-Z,�Ε�\"��8���Aw��g2�Q\$hp��'���?����F�Ы4L�5m�0TK��H`�G{9g���.WEl���;�&�!��9<~\rкꝇ{��dma�n����ƃ}ϼ]֡�����R\rх0�t�%�⼩���%E,T]�\r��P��piF7M'���h��/!�0�>�zD�ޓ	*�y\"ᆄ�\rM��?G��'~�XJuԝ�2=7�m��!N\r�IoަF��T��ê���B�T�wPl�X�B���.�u�2 ��C���)ʟ��~�S��������͔�,N�����X��\n��`��G �Y谺e��;�>w`�^�)�~�>O&���me�fbm�q�P>K2n��='���*d�{�4�m�ׄ4�*�\r�\$�<g0@��\\0V&00P^��d��h(N䖊.0g���p�pZ@P�-�n����#��v,����n��.��L�+X�P���r'�ֈƴ%�)��	P�	�z#����IP��G�*��Jf���n��o1	p�!|���ޣZ	��Y%�G`�#0�A'&\$���N�FA��R|z���b�h�)@�,�Aj=\n�E.�\"�-�v����eB�E*e�N?q*QY��5g��jŋ���f��zf.r쏜��p�q�)��4\$�#CFf�r�\$X��r��44��@�\\q���a!l�V�R&.����+p�CL�\"�IR���Qc!1o�<�&� � �d�Pv-n�A���\nQR!G�%>�s\$LZ܎j����m�o>j-�g�N��\$��j���#�6�Q��n���G`�Hb\$L\$Rw�\$��I\"���L�2|6�C,��(�')/������k\"�Y%�3\"R<*a~.r��e��*qB!�4iDt!m�%@S,����D�\"��(&�HD�r�6Uq���`��z�����z�:Qh2�K3�B��3�C3�,RSa.�s/2�`D�^6�#%�C�fL.�c ���ਠ^1	��7\$3\n3iS�\$e8�K9�9C9��a��P�I4r7p��8��8��O�<O�E�3�S�s=L�/�5c��0l�o�2��23� �6�r!mw	����@t	BEmB��AR�'L��W0dT�+�yF��4R(��0��.�tjǽ/�@�ju�42��B�̈TS�eE�De��1�.B�j��L��\"q-�Bc��[C�B��IEk�+���˔6״&��>Tom\$T��&���\$�ti��)�|�\r�0�10h�7B��C&Ph�47t\$�7\$��P�i:�e'R��r�\nh�2i%+ȇP�5A�o�StB�s�S�䠕E?ǗSgS�QE�4jtM6u+VB�jo䞆j��5��UA�Sb@1n2#�P.��)f�frr���L�R�B(Q>�O9�UP�\$�\"�>յ2��T�#7��[�g��%�V��1U��AuHnvƧU��>��[5�0U���^�^�r��{V��_����/�T�ԅZ�ⶋl�`�B�S��[�zO�ST�#d2R�U�!7��,^�O�RTF�%�g`S4K��S'�Xv��%��5:�{X��S�W�G\\�Wi���hMS`+)5aJA�+I�5Z��]q�߂R��.y0XA�yVW]��Y�i��H��(0�;3I�Z�n�9��n��o�wEY	V�ai�\rF�o�yQ�2��@�o2�<���=vIp��\"�p�:���? BtV�C�t��ˀ���t�7�+B,�9\"S),�����H�&X'W'#��������h�\n���Z����l0��}1auQ�|#Ԫx��\"PM{#y=6�4�c|�=Щ��D7�{��T5\"�2�&LĂ�����{����	��z��\$Ex7BS��D�qķPo�j7�5en�O��o��.�w��x5`&ӘC7yZ\"x	��Ӧ2^��<��l.��.�oc!#R����@��RF(�|�O;�E5�1\$6iQS�S(4�As\rD��C8�\$\n�p8)����5x�&��%�[h�\"e���\"�\$�>v�Q��=�[I�eR�@KaPgW�I�RW�%O@�O+N\nƲ����,�F�xzL��OW0L5�Է&�*3�0� \nŰ��\r�[���N�}�aN��(hy.|��`D�Pq�/���B�s�',��?��%ֶ���e�q��v+D�0��T\r�n�;��+��&/8Y��x(4�e���";break;case"vi":$e="Bp��&������ *�(J.��0Q,��Z���)v��@Tf�\n�pj�p�*�V���C`�]��rY<�#\$b\$L2��@%9���I�����Γ���4˅����d3\rF�q��t9N1�Q�E3ڡ�h�j[�J;���o��\n�(�Ub��da���I¾Ri��D�\0\0�A)�X�8@q:�g!�C�_#y�̸�6:����ڋ�.���K;�.���}F��ͼS0��6�������\\��v����N5��n5���x!��r7���CI��1\r�*�9��@2������2��9�#x�9���:�����d����@3��:�ܙ�n�d	�F\r����\r�	B()�2	\njh�-��C&I�N�%h\"4�'�H�2JV�����-ȆcG�I>����2���A��QtV�\0P����8�i@�!K�쪒Ep ��k��=cx�>R��:���.�#�G��2#��0�p�4��x�L�H9�����4C(��C@�:�t�㽌4M�?#8_�p�XVAxD��k�;c3�6�0���|�+��2�dRC�\"Eނh	J�-t��NR������V\r����;�1B��9\r��Ί�\"�<�A@��B\0�G��:��I�a��ڤ�2#!-�%t0��d�;#`�2�WK!�HJpT�cvT�'��s����c[�_�K�K.ޥ�S�er�EzP<:��P�]h	O����6�NHG�,� P\$����/x(����va�\n#��T�.�@�-��3�6X��\r�o)�\"`<]@P��acM �d�H!�b'4��\\J�i��©�މ�W;{_����PµE�X�MJ>�3��/NS{Z���r`�2\"i��vMI3r\"\\�;�@P�U|7��5�7�X��#�?.jD�	\$���B_\r;�G轺9F���h�A�R���4(�X82D���a%���\"p Ιh(n�)h\0`�6DȽ>�r�^QH�3I�]\n��K�j6&��.��,߲.\rho ��HڈQO�9+@ƅ��dQ��+�t���XKcu����.Y�<7�ȅ�\nZ��7���ė\"�%�@4��Q�;E4������t�0M�2�6�C�+�-�Ծ.�\\F�!.�Z�U��Wj�_���V:Ɋg�5%���B�k-�z�0�&R\0006ǐ|�g<�-�����U�ȑ�ĸD���~�	L�t,8l\r���Cheb��3!\$��Ҝ�Ԕ��PA9&��N\n�b�n����H]�D�I�]�r��a���8!t-��P	@�534G���'ܙ;r��P��qܻGn�i;H3�%Z��!�3a�LM��8�\\z����A2(a�W)��U�B�\r��U��^�C���]��ί��� ��R�f��d��),]6�9#�����Dn���iva6���SȮ\"v����P�M'\"����A�]P��|\nIpI\"A��@�Ŕ��\r�X��%rjz]����%�<נl\rꖊ�E]KO�i]�d���HJ�`/\n<)�Hw�9���F6r��Y93#�ĝ�P���'a�G/W�E����[QBI\nE�f��\$r?mfi�'���%����9�>��n��+�Mپ\$2�`5�#L������\$�Y��D����\$��}(ɉb]	�9(�6�#�2d!&���L9�:�	:��S	�%�y	E���>A�\"-dl2\\�>wp��	���ˠA���b,a1B�H�'��գ�o��b.F��52�� h3�x��BT�����R�J�K&����AX���|G�y\"�0��:��ێ���dl�]�&�0���Z��8����#EB}�K9\r!����[6d]�^7\"����G��b��u�֧�T�\$.N�ax�\0��ρ�|-�5l32�[d F�6#��+ˤ���%�xH��8�i�3�����\"�D�f\n-��7.�P�t�M�RWie��C	'P(��P,ʓR�^�9\"�E�y���!��\0��d�\n�טX�����lGV����]�'˲A8Y��r5��1���Ɂ�92�\$��n-�8�3��q��B.�ə*/ٖt-�R]?܊;[�Sd�4�\ri�ւE\0�D��/%dˬ)Ci��u��XX��R[Bi<�w\\g���L#�?X()�a8eا�����z˓��Bf�g\$V��(�X9Wj��Fr<�6��9.z��ZCm���H�'�=?�#}����H�u\n����Gt�9ͬ\$_��p�I�-U;G���^�����0�()\0�Gƺ�#� \"Ķ~aDA.�e��x���w�`E�-r֏���\"�Ð5�l����!�<qĺ���q��\r&8i�Xc���/n�#���n����˼���zto�țuB\\�4C�FI��UeV�Ru�X�Nl���or\"Є�h0�/���{��%А�M�	n�	�6�l�0D��9�~k+k�b&j���߄���i��J!-gn&1��v�g����&��:bd�͡\r�*��+0�\n���P��@�w'h\r}d>�-�L Cf`��\0p�\0���16 ���P8��D�k��	���Ǡ�I�-~�L�\n\r�^pQPTi'`e��r�Q�1���q-�z��-�����AN7-�8Ed�	�:C�\"Kͼ:%�V��yE��jF�o��q'�l�g���t1zu�б���bJ֭�v�1R��0�O����b�9�W1Oh�QP�o8(p��}��#m� C5�)#�� �A\"�PdN�&\n_��oM	 ίm�ߐI##�&�?'\$*���X�Ѐ�����-��LZ^�P5�5�҈*f\n�H�:���.���n=����N���!w,b����y��%��NAJ ��-	��f��L�E�!�#1^���\$�r�p�/O�4�6L\n���ZH�����B�e��P�1�Є�]S8|%��G\nEҚ�#\$X�cf_E%\$�H\$w[01L6��4�a4��7\$�E�fG��G��Q*qG�����P���r���y�:��t�,\n�=(,��'mQL�3��>'�H7�o�6�fd���jfҿ���Jh-c���~�#x�C�%�m���T�tm�v��֭�?�h�vD#3Fb�K� !ri��@�¬� ��(RC\n�\rn#�^0�	)J���ǊNJ�ϜLӁ?�F�LkG�H'�3İ�\r��>��\$\$�*�4�L�3��J�[5@�h-��eHuHc2";break;case"zh":$e="�A*�s�\\�r����|%��:�\$\nr.���2�r/d�Ȼ[8� S�8�r�!T�\\�s���I4�b�r��ЀJs!J���:�2�r�ST⢔\n���h5\r��S�R�9Q��*�-Y(eȗB��+��΅�FZ�I9P�Yj^F�X9���P������2�s&֒E��~�����yc�~���#}K�r�s���k��|�i�-r�̀�)c(��C�ݦ#*�J!A�R�\n�k�P��/W�t��Z�U9��WJQ3�W���dqQF9�Ȅ�%_��|���2%Rr�\$�����9XS#%�Z�@�)J��1.[\$�h��0]��6r���C�!zJ���|r���Y�m��*QBr�.�����I���1�P0[Ŝ��&��%�XJ�1�ɲx ��h�7���]�	�H��ġ_)&�q\n�̂�N',�!�����1H,�����\r��3��:����x�G���-ˡp�9�x�7��9�c�.2��:e1�A��AN���I>��|GI\0D��YS;��rZL�9H]6\$��O�\\�J5q\r��t�h��i,X��u`O.�ZS�����tId@K����O-�1fTVW9�C�G)T�=Y���1�y\\�u�S��rM�d�����ZE�9vs�zF���s�	u��ʆV��S��qXsX�1t�E18���CF��m�\n)�\"eʏn��I����56��pIV�\\��Dn^`�?ol;�OVQLAbZ�g�x���)�l��u\rm�L�����y_C`�9%���E��]�T��ɒtN��'Ai�����5>:e��t�1�I-��Y#e|�BL9b��#	9Hs�\$b������G�5�j��on���O���tƐ���XQ3���Ը9uynt�L�*#���ed�@PT%\rDQTe���R�]L��^xn!�4��J�Q������\"ŉ<\"�Z��:(�`���[��x&������!�-�J�{.i鑁p���D����>R���PjC���TxwR*M�e0���e�M�8�0sU����ձ�̀Y�Rl�p���\\Ar!G(��_�X6����;��\n�:�S:S1��Ra&#ZAZeT��a>��p�b����r!ЭO0�'��E9ux��ȧ���n2I�4Ip@@P>G�T<��* �G�%\\��\$�.�e�����b��3a����)�Ɛ���NI	\"��qM	f[�^:�?-��0W���-`�Bbm�R(\n��ʴ_�r\\L	��&��� A�+���`��0<���@m�e��oeRp\$�9�@���h�&�pX�(^`���R\r��>UO\naP�'��)��1�qPD�l>e�@GD�����4��5X\0���Q?B0T\n|��~9W�L	�0��6��7G)ɻ�4)��d���r�xNT(@�-x�A\"���`H��Z���#���äJ���)�`��u��YDo�	���(���l\"�)e���Wt���h�牙M�iWp�:��η�Â:B�M�qP\"�zyba�Qo�>/D3b&�м���`%:>e'��-�G9����蜫�ʧE��aB9�r��b����mN��?��i-C�)֚*:Ke��&��\r2�87��t\$(�M��C��Z-�p���¹`u����o�yWbq#�KH�DM�&/���Q�i��[(��2�&q	BF\\8�d�y\r�l�M�*�1�:b���_����+��A�%-�PJ\"#3�O��t��%�`����T�\$Z������B(e,·�N�,�~�j�B:Q�)�ɗg�|�-�zS�� \$Zx���E��Y�=�tƉ�J��UhF��+�PŬ�Q�\$�6��!g��IoL��!!l9D\r�t]�Vp�V>b=�G-1��0���ؼ���`����V��7\$�ax�h�n|5l���8;�W}�m���Ek�չ-��%���`�#�2a����m��?9�LF,��X{��-�DqLf\$�\r-0�~-(/!�'����D1l��B���@EE�#\\>۬��OG��{���7��䭂ऩ�,�9㤑��Q;��:�Q�s؍�\0��)�Ww\$�K��.�o�og1�]w�Q%%��>t�#<GX�`�bp�RPHId�n9b�i�.�y��P��4.0�<,s��2%0|�����\$�xUkfX[��8Ő0����t�\n����S���n/�F���_�y��n��k_��z��i)//�����Z�0-Ŕ]��:��{e�����O\"\r8����n[lTz�E�+�d,�վ~3��U��ϖZ�b-:���ȏ�[�bL�t�3�@a<�.0�NxŪ@�/�ߡN��0�0p.G/��P,�s\0��L;͌B�.�\r����2�̜���b�	>\r\0�����^e�2��A>��4\$<ȍP6+��b���D&�s�\\'V���EЖ�M�yl����χp�D�g\r�zz\$P�>� 4.C�D�c�-��� ;��\n���p6�,N���lܶi�8)x#Iҷe|:m^[.�h�f�L.A��7�|b6����pÄ���aD�A��\"3GLm���l��Z��\\��<%��Y**�M����Nu�X����Ш�b��+mnH�����/��~-\"�4i�c,Nnm�b����Q�f�C�D*AM8�\$������ ���\r�j\$1��&Yl0�G��Y�bG�C����i�0M��+{S\"�|:ALHA7!��JGJ �ZBƿE�";break;case"zh-tw":$e="�^��%ӕ\\�r�����|%��:�\$\ns�.e�UȸE9PK72�(�P�h)ʅ@�:i	%��c�Je �R)ܫ{��	Nd T�P���\\��Õ8�C��f4����aS@/%����N����Nd�%гC��ɗB�Q+����B�_MK,�\$���u��ow�f��T9�WK��ʏW����2mizX:P	�*��_/�g*eSLK�ۈ��ι^9�H�\r���7��Zz>�����0)ȿN�\n�r!U=R�\n����^���J��T�O�](��I�s��>�E\$��A,r�����@se�^B��ABs��#hV���d���¦K���J��12A\$�&���r8mQd��qr_ �ļ6')tU��w\n.�x].��2���ft(q�W����/q�V�%�^R���pr\$)�.��P�2\r�H�2�GI@H&Ej�s�	Z&ETG�Ly)ʥ��K\rd~����\r��3��:����x�O���7Np�9�x�7��9�c�N2��JHA��ALE�K�FP��x��Q�@�aD�E	^s���(H�{�_���r��U�-[v�(\\�7#��NS16W<EiLr�\$R2�:�@���a	Z\$��O.	�vt��C��Y+e��e�9έj�e٤�����^�Q6C����↸��vs�|hs����GQ�J��D1T��\\xz���P�2��@t���|S%ؒ\0N%�+	2k�vA��~J)�\"`Az���s\$�R�6�Kr���F�EK{Žt�ֽ��v�V��qwmQ2��4I�|�>�I�ʐ��]�?\0�q��v�o�U�gC`�92�A�M�L5����˅��B(��J��7�dr�MQ�G��)C\$��_�IF�%3��w�BjB�)�\0�7�u[�X�Q3��Rb���\\�@)�v���!���t��ؚ�joO%��!EqFI H��\"����R�YL)�8����*�S��V� o\r��:�T�A���`V�\"@�w�XC�ql,���!�%b�u��*������x� Dr\$���F���!E)�#�y*%a��*\$0aH�5*��ʛS�|;�G�2�UJ��/���Z�V� �b%b(>AbYo���+��l��2W.%��H�P����\n����h��+E\"�l��r�fDC���q6����&ØC	&�;����Q>-̣�#h5�&�Lq�f\"����-� \n ( 	�!P�B������R&�X��F��+��D��G/��{�~Z	�+DK�3E�����(\\Z\"�9g^(łgϨ���L\n�#�@�A�TG��C,��l�nx���-��P%�ę��09�p�w���Yf'(1AcO�Ü��\"��6��Aa<'1�9fl��Q|'�B�O��G�b ����q���(\"����\0�  q��?\0���C���\0�1#�e?�%(�(�P+H1-3�TQb|�\0�x�*vH��@(L!��pojq�H�\$r��.�͠�Ð_=-Jh�%\r���P�*Pk�\0D�0\"�V���R4s�2\\#�\"e7�5F�.��]� �ÞtN��'dT]�aqB=ݻ���=�*��C{KFY�ɸ����>���,����3�t�h�	�*9ĂU-�<�Z_��4�t��\09�)p���DAXC�|5Tv(M)�5�tؘ�l�;�w��%z�TĘU-M��ϒ�tQ�{¹E�����ݾ'�v\n�����)��p�eǂ1����������T�ZҎat\$��B\"er��O���֡���gRc�s7	�y�\ncL��k�!x����쐌`6|u���b�ћ��N��?����語[(���P �0�9������P\n]D�X�>g�UJ�x ^�����~e5.�<%��_�a��^�Q>/��LPbE���ID%�����0\nP\"26���1���r*u-�&Qe�-��)��Y�NJ��\$x�	1�&�(����T��f��J+� \n��G��Db]�G�c Z�-�Rh�%��-5��ϱ24���!\0��h���Ȍ3E���n�T�U�+����gz�c�Ji�J��ޓs�sz�]'o[�x��q/�'eqsԝ\".�×9��lz�ø�*���ӥcY��~wY@��⅃0��9{�w�W/����K���[�g*����h�ur	C{���.�W���y|��@}�f\\���z����1�%������=-�\\.�9�hFk��e9������/��M�6���b�h�����H||��ŬZ˹Q\$q3�5�#a�i0KŹ���(���Z���1�k��.�F��L�oH��ʲ��߿�p��B���%��Ljs��#H4��1�D�j�ά\\�E�@��,��0�n�l�/����̆F\rϊ��sFc�<�0`�h��jя�p�rYA,���pA:!���J����͂7b�����O\\g�Zo\"���@밯!�d&Fd��NB~*����{M	e�Ncq\r*F`�F����Ό�Ip�o�����oE���L���l�l���D�REp{䕃�ҁ������9,	^\r\0��\n��Jgl*4g6K����@�\r�Ɖ ��*ԓD(��2<AHY�F�0D�bۊ#k5C\\�.p�ء����� gV\r��â9�@'�\\cDd2��L����\n���p8���*�\r��*L#\"6#��c�rLj�Ŕ�a��Z8������� �Qޤ�\\K�~x�#h��F.\"���:(�)����pJ����L���/Hz+�&�Zs����a��z��`Y�~�O�\\r���°��Ȕ���Ze�\\�n�Ѣ���#�r�k�.&�.�!pC���(n\n��`����\"�\0�2��\n���ԥʩ�R�2dsRm'B^��������W�&rx��\\*���L �+,�\\��`";break;}
    $Qg=array();
    foreach (explode("\n", lzw_decompress($e))as$X) {
        $Qg[]=(strpos($X, "\t")?explode("\t", $X):$X);
    }
    return$Qg;
} if (!$Qg) {
    $Qg=get_translations($ca);
    $_SESSION["translations"]=$Qg;
} if (extension_loaded('pdo')) {
    class Min_PDO extends
PDO
    {
        public $_result;
        public $server_infovar ;
        public $affected_rowsvar ;
        public $errnovar ;
        public $errorvar ;
        public function __construct()
        {
            global$b;
            $Ve=array_search("SQL", $b->operators);
            if ($Ve!==false) {
                unset($b->operators[$Ve]);
            }
        }
        public function dsn($Nb, $V, $G, $ue=array())
        {
            try {
                parent::__construct($Nb, $V, $G, $ue);
            } catch (Exception$fc) {
                auth_error(h($fc->getMessage()));
            }
            $this->setAttribute(13, array('Min_PDOStatement'));
            $this->server_info=@$this->getAttribute(4);
        }
        public function query($I, $Xg=false)
        {
            $J=parent::query($I);
            $this->error="";
            if (!$J) {
                list(, $this->errno, $this->error)=$this->errorInfo();
                if (!$this->error) {
                    $this->error=lang(21);
                }
                return
false;
            }
            $this->store_result($J);
            return$J;
        }
        public function multi_query($I)
        {
            return$this->_result=$this->query($I);
        }
        public function store_result($J=null)
        {
            if (!$J) {
                $J=$this->_result;
                if (!$J) {
                    return
false;
                }
            }
            if ($J->columnCount()) {
                $J->num_rows=$J->rowCount();
                return$J;
            }
            $this->affected_rows=$J->rowCount();
            return
true;
        }
        public function next_result()
        {
            if (!$this->_result) {
                return
false;
            }
            $this->_result->_offset=0;
            return@$this->_result->nextRowset();
        }
        public function result($I, $m=0)
        {
            $J=$this->query($I);
            if (!$J) {
                return
false;
            }
            $L=$J->fetch();
            return$L[$m];
        }
    }
    class Min_PDOStatement extends
PDOStatement
    {
        public $_offset=0;
        public $num_rowsvar ;
        public function fetch_assoc()
        {
            return$this->fetch(2);
        }
        public function fetch_row()
        {
            return$this->fetch(3);
        }
        public function fetch_field()
        {
            $L=(object)$this->getColumnMeta($this->_offset++);
            $L->orgtable=$L->table;
            $L->orgname=$L->name;
            $L->charsetnr=(in_array("blob", (array)$L->flags)?63:0);
            return$L;
        }
    }
}$Jb=array();class Min_SQL
{
    public $_conn;
    public function __construct($f)
    {
        $this->_conn=$f;
    }
    public function select($Q, $N, $Z, $s, $we=array(), $_=1, $F=0, $cf=false)
    {
        global$b,$y;
        $hd=(count($s)<count($N));
        $I=$b->selectQueryBuild($N, $Z, $s, $we, $_, $F);
        if (!$I) {
            $I="SELECT".limit(($_GET["page"]!="last"&&$_!=""&&$s&&$hd&&$y=="sql"?"SQL_CALC_FOUND_ROWS ":"").implode(", ", $N)."\nFROM ".table($Q), ($Z?"\nWHERE ".implode(" AND ", $Z):"").($s&&$hd?"\nGROUP BY ".implode(", ", $s):"").($we?"\nORDER BY ".implode(", ", $we):""), ($_!=""?+$_:null), ($F?$_*$F:0), "\n");
        }
        $dg=microtime(true);
        $K=$this->_conn->query($I);
        if ($cf) {
            echo$b->selectQuery($I, $dg, !$K);
        }
        return$K;
    }
    public function delete($Q, $kf, $_=0)
    {
        $I="FROM ".table($Q);
        return
queries("DELETE".($_?limit1($Q, $I, $kf):" $I$kf"));
    }
    public function update($Q, $P, $kf, $_=0, $Nf="\n")
    {
        $nh=array();
        foreach ($P
as$z=>$X) {
            $nh[]="$z = $X";
        }
        $I=table($Q)." SET$Nf".implode(",$Nf", $nh);
        return
queries("UPDATE".($_?limit1($Q, $I, $kf, $Nf):" $I$kf"));
    }
    public function insert($Q, $P)
    {
        return
queries("INSERT INTO ".table($Q).($P?" (".implode(", ", array_keys($P)).")\nVALUES (".implode(", ", $P).")":" DEFAULT VALUES"));
    }
    public function insertUpdate($Q, $M, $bf)
    {
        return
false;
    }
    public function begin()
    {
        return
queries("BEGIN");
    }
    public function commit()
    {
        return
queries("COMMIT");
    }
    public function rollback()
    {
        return
queries("ROLLBACK");
    }
    public function slowQuery($I, $Dg)
    {
    }
    public function convertSearch($v, $X, $m)
    {
        return$v;
    }
    public function value($X, $m)
    {
        return(method_exists($this->_conn, 'value')?$this->_conn->value($X, $m):(is_resource($X)?stream_get_contents($X):$X));
    }
    public function quoteBinary($Ef)
    {
        return
q($Ef);
    }
    public function warnings()
    {
        return'';
    }
    public function tableHelp($E)
    {
    }
}$Jb=array("server"=>"MySQL")+$Jb; if (!defined("DRIVER")) {
    $Ye=array("MySQLi","MySQL","PDO_MySQL");
    define("DRIVER", "server");
    if (extension_loaded("mysqli")) {
        class Min_DB extends
MySQLi
        {
            public $extension="MySQLi";
            public function __construct()
            {
                parent::init();
            }
            public function connect($O="", $V="", $G="", $ub=null, $Ue=null, $Wf=null)
            {
                global$b;
                mysqli_report(MYSQLI_REPORT_OFF);
                list($Sc, $Ue)=explode(":", $O, 2);
                $cg=$b->connectSsl();
                if ($cg) {
                    $this->ssl_set($cg['key'], $cg['cert'], $cg['ca'], '', '');
                }
                $K=@$this->real_connect(($O!=""?$Sc:ini_get("mysqli.default_host")), ($O.$V!=""?$V:ini_get("mysqli.default_user")), ($O.$V.$G!=""?$G:ini_get("mysqli.default_pw")), $ub, (is_numeric($Ue)?$Ue:ini_get("mysqli.default_port")), (!is_numeric($Ue)?$Ue:$Wf), ($cg?64:0));
                $this->options(MYSQLI_OPT_LOCAL_INFILE, false);
                return$K;
            }
            public function set_charset($Ma)
            {
                if (parent::set_charset($Ma)) {
                    return
true;
                }
                parent::set_charset('utf8');
                return$this->query("SET NAMES $Ma");
            }
            public function result($I, $m=0)
            {
                $J=$this->query($I);
                if (!$J) {
                    return
false;
                }
                $L=$J->fetch_array();
                return$L[$m];
            }
            public function quote($hg)
            {
                return"'".$this->escape_string($hg)."'";
            }
        }
    } elseif (extension_loaded("mysql")&&!((ini_bool("sql.safe_mode")||ini_bool("mysql.allow_local_infile"))&&extension_loaded("pdo_mysql"))) {
        class Min_DB
        {
            public $extension="MySQL";
            public $server_infovar ;
            public $affected_rowsvar ;
            public $errnovar ;
            public $errorvar ;
            public $_linkvar ;
            public $_resultvar ;
            public function connect($O, $V, $G)
            {
                if (ini_bool("mysql.allow_local_infile")) {
                    $this->error=lang(22, "'mysql.allow_local_infile'", "MySQLi", "PDO_MySQL");
                    return
false;
                }
                $this->_link=@mysql_connect(($O!=""?$O:ini_get("mysql.default_host")), ("$O$V"!=""?$V:ini_get("mysql.default_user")), ("$O$V$G"!=""?$G:ini_get("mysql.default_password")), true, 131072);
                if ($this->_link) {
                    $this->server_info=mysql_get_server_info($this->_link);
                } else {
                    $this->error=mysql_error();
                }
                return(bool)$this->_link;
            }
            public function set_charset($Ma)
            {
                if (function_exists('mysql_set_charset')) {
                    if (mysql_set_charset($Ma, $this->_link)) {
                        return
true;
                    }
                    mysql_set_charset('utf8', $this->_link);
                }
                return$this->query("SET NAMES $Ma");
            }
            public function quote($hg)
            {
                return"'".mysql_real_escape_string($hg, $this->_link)."'";
            }
            public function select_db($ub)
            {
                return
mysql_select_db($ub, $this->_link);
            }
            public function query($I, $Xg=false)
            {
                $J=@($Xg?mysql_unbuffered_query($I, $this->_link):mysql_query($I, $this->_link));
                $this->error="";
                if (!$J) {
                    $this->errno=mysql_errno($this->_link);
                    $this->error=mysql_error($this->_link);
                    return
false;
                }
                if ($J===true) {
                    $this->affected_rows=mysql_affected_rows($this->_link);
                    $this->info=mysql_info($this->_link);
                    return
true;
                }
                return
new
Min_Result($J);
            }
            public function multi_query($I)
            {
                return$this->_result=$this->query($I);
            }
            public function store_result()
            {
                return$this->_result;
            }
            public function next_result()
            {
                return
false;
            }
            public function result($I, $m=0)
            {
                $J=$this->query($I);
                if (!$J||!$J->num_rows) {
                    return
false;
                }
                return
mysql_result($J->_result, 0, $m);
            }
        }
        class Min_Result
        {
            public $num_rows;
            public $_resultvar ;
            public $_offsetvar =0;
            public function __construct($J)
            {
                $this->_result=$J;
                $this->num_rows=mysql_num_rows($J);
            }
            public function fetch_assoc()
            {
                return
mysql_fetch_assoc($this->_result);
            }
            public function fetch_row()
            {
                return
mysql_fetch_row($this->_result);
            }
            public function fetch_field()
            {
                $K=mysql_fetch_field($this->_result, $this->_offset++);
                $K->orgtable=$K->table;
                $K->orgname=$K->name;
                $K->charsetnr=($K->blob?63:0);
                return$K;
            }
            public function __destruct()
            {
                mysql_free_result($this->_result);
            }
        }
    } elseif (extension_loaded("pdo_mysql")) {
        class Min_DB extends
Min_PDO
        {
            public $extension="PDO_MySQL";
            public function connect($O, $V, $G)
            {
                global$b;
                $ue=array(PDO::MYSQL_ATTR_LOCAL_INFILE=>false);
                $cg=$b->connectSsl();
                if ($cg) {
                    if (!empty($cg['key'])) {
                        $ue[PDO::MYSQL_ATTR_SSL_KEY]=$cg['key'];
                    }
                    if (!empty($cg['cert'])) {
                        $ue[PDO::MYSQL_ATTR_SSL_CERT]=$cg['cert'];
                    }
                    if (!empty($cg['ca'])) {
                        $ue[PDO::MYSQL_ATTR_SSL_CA]=$cg['ca'];
                    }
                }
                $this->dsn("mysql:charset=utf8;host=".str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $O)), $V, $G, $ue);
                return
true;
            }
            public function set_charset($Ma)
            {
                $this->query("SET NAMES $Ma");
            }
            public function select_db($ub)
            {
                return$this->query("USE ".idf_escape($ub));
            }
            public function query($I, $Xg=false)
            {
                $this->setAttribute(1000, !$Xg);
                return
parent::query($I, $Xg);
            }
        }
    }
    class Min_Driver extends
Min_SQL
    {
        public function insert($Q, $P)
        {
            return($P?parent::insert($Q, $P):queries("INSERT INTO ".table($Q)." ()\nVALUES ()"));
        }
        public function insertUpdate($Q, $M, $bf)
        {
            $d=array_keys(reset($M));
            $Ze="INSERT INTO ".table($Q)." (".implode(", ", $d).") VALUES\n";
            $nh=array();
            foreach ($d
as$z) {
                $nh[$z]="$z = VALUES($z)";
            }
            $lg="\nON DUPLICATE KEY UPDATE ".implode(", ", $nh);
            $nh=array();
            $zd=0;
            foreach ($M
as$P) {
                $Y="(".implode(", ", $P).")";
                if ($nh&&(strlen($Ze)+$zd+strlen($Y)+strlen($lg)>1e6)) {
                    if (!queries($Ze.implode(",\n", $nh).$lg)) {
                        return
false;
                    }
                    $nh=array();
                    $zd=0;
                }
                $nh[]=$Y;
                $zd+=strlen($Y)+2;
            }
            return
queries($Ze.implode(",\n", $nh).$lg);
        }
        public function slowQuery($I, $Dg)
        {
            if (min_version('5.7.8', '10.1.2')) {
                if (preg_match('~MariaDB~', $this->_conn->server_info)) {
                    return"SET STATEMENT max_statement_time=$Dg FOR $I";
                } elseif (preg_match('~^(SELECT\b)(.+)~is', $I, $C)) {
                    return"$C[1] /*+ MAX_EXECUTION_TIME(".($Dg*1000).") */ $C[2]";
                }
            }
        }
        public function convertSearch($v, $X, $m)
        {
            return(preg_match('~char|text|enum|set~', $m["type"])&&!preg_match("~^utf8~", $m["collation"])&&preg_match('~[\x80-\xFF]~', $X['val'])?"CONVERT($v USING ".charset($this->_conn).")":$v);
        }
        public function warnings()
        {
            $J=$this->_conn->query("SHOW WARNINGS");
            if ($J&&$J->num_rows) {
                ob_start();
                select($J);
                return
ob_get_clean();
            }
        }
        public function tableHelp($E)
        {
            $Ed=preg_match('~MariaDB~', $this->_conn->server_info);
            if (information_schema(DB)) {
                return
strtolower(($Ed?"information-schema-$E-table/":str_replace("_", "-", $E)."-table.html"));
            }
            if (DB=="mysql") {
                return($Ed?"mysql$E-table/":"system-database.html");
            }
        }
    }
    function idf_escape($v)
    {
        return"`".str_replace("`", "``", $v)."`";
    }
    function table($v)
    {
        return
idf_escape($v);
    }
    function connect()
    {
        global$b,$Wg,$ig;
        $f=new
Min_DB;
        $nb=$b->credentials();
        if ($f->connect($nb[0], $nb[1], $nb[2])) {
            $f->set_charset(charset($f));
            $f->query("SET sql_quote_show_create = 1, autocommit = 1");
            if (min_version('5.7.8', 10.2, $f)) {
                $ig[lang(23)][]="json";
                $Wg["json"]=4294967295;
            }
            return$f;
        }
        $K=$f->error;
        if (function_exists('iconv')&&!is_utf8($K)&&strlen($Ef=iconv("windows-1250", "utf-8", $K))>strlen($K)) {
            $K=$Ef;
        }
        return$K;
    }
    function get_databases($wc)
    {
        $K=get_session("dbs");
        if ($K===null) {
            $I=(min_version(5)?"SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME":"SHOW DATABASES");
            $K=($wc?slow_query($I):get_vals($I));
            restart_session();
            set_session("dbs", $K);
            stop_session();
        }
        return$K;
    }
    function limit($I, $Z, $_, $he=0, $Nf=" ")
    {
        return" $I$Z".($_!==null?$Nf."LIMIT $_".($he?" OFFSET $he":""):"");
    }
    function limit1($Q, $I, $Z, $Nf="\n")
    {
        return
limit($I, $Z, 1, 0, $Nf);
    }
    function db_collation($j, $Ya)
    {
        global$f;
        $K=null;
        $h=$f->result("SHOW CREATE DATABASE ".idf_escape($j), 1);
        if (preg_match('~ COLLATE ([^ ]+)~', $h, $C)) {
            $K=$C[1];
        } elseif (preg_match('~ CHARACTER SET ([^ ]+)~', $h, $C)) {
            $K=$Ya[$C[1]][-1];
        }
        return$K;
    }
    function engines()
    {
        $K=array();
        foreach (get_rows("SHOW ENGINES")as$L) {
            if (preg_match("~YES|DEFAULT~", $L["Support"])) {
                $K[]=$L["Engine"];
            }
        }
        return$K;
    }
    function logged_user()
    {
        global$f;
        return$f->result("SELECT USER()");
    }
    function tables_list()
    {
        return
get_key_vals(min_version(5)?"SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME":"SHOW TABLES");
    }
    function count_tables($i)
    {
        $K=array();
        foreach ($i
as$j) {
            $K[$j]=count(get_vals("SHOW TABLES IN ".idf_escape($j)));
        }
        return$K;
    }
    function table_status($E="", $pc=false)
    {
        $K=array();
        foreach (get_rows($pc&&min_version(5)?"SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ".($E!=""?"AND TABLE_NAME = ".q($E):"ORDER BY Name"):"SHOW TABLE STATUS".($E!=""?" LIKE ".q(addcslashes($E, "%_\\")):""))as$L) {
            if ($L["Engine"]=="InnoDB") {
                $L["Comment"]=preg_replace('~(?:(.+); )?InnoDB free: .*~', '\1', $L["Comment"]);
            }
            if (!isset($L["Engine"])) {
                $L["Comment"]="";
            }
            if ($E!="") {
                return$L;
            }
            $K[$L["Name"]]=$L;
        }
        return$K;
    }
    function is_view($R)
    {
        return$R["Engine"]===null;
    }
    function fk_support($R)
    {
        return
preg_match('~InnoDB|IBMDB2I~i', $R["Engine"])||(preg_match('~NDB~i', $R["Engine"])&&min_version(5.6));
    }
    function fields($Q)
    {
        $K=array();
        foreach (get_rows("SHOW FULL COLUMNS FROM ".table($Q))as$L) {
            preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~', $L["Type"], $C);
            $K[$L["Field"]]=array("field"=>$L["Field"],"full_type"=>$L["Type"],"type"=>$C[1],"length"=>$C[2],"unsigned"=>ltrim($C[3].$C[4]),"default"=>($L["Default"]!=""||preg_match("~char|set~", $C[1])?$L["Default"]:null),"null"=>($L["Null"]=="YES"),"auto_increment"=>($L["Extra"]=="auto_increment"),"on_update"=>(preg_match('~^on update (.+)~i', $L["Extra"], $C)?$C[1]:""),"collation"=>$L["Collation"],"privileges"=>array_flip(preg_split('~, *~', $L["Privileges"])),"comment"=>$L["Comment"],"primary"=>($L["Key"]=="PRI"),"generated"=>preg_match('~^(VIRTUAL|PERSISTENT|STORED)~', $L["Extra"]),);
        }
        return$K;
    }
    function indexes($Q, $g=null)
    {
        $K=array();
        foreach (get_rows("SHOW INDEX FROM ".table($Q), $g)as$L) {
            $E=$L["Key_name"];
            $K[$E]["type"]=($E=="PRIMARY"?"PRIMARY":($L["Index_type"]=="FULLTEXT"?"FULLTEXT":($L["Non_unique"]?($L["Index_type"]=="SPATIAL"?"SPATIAL":"INDEX"):"UNIQUE")));
            $K[$E]["columns"][]=$L["Column_name"];
            $K[$E]["lengths"][]=($L["Index_type"]=="SPATIAL"?null:$L["Sub_part"]);
            $K[$E]["descs"][]=null;
        }
        return$K;
    }
    function foreign_keys($Q)
    {
        global$f,$oe;
        static$Re='(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';
        $K=array();
        $lb=$f->result("SHOW CREATE TABLE ".table($Q), 1);
        if ($lb) {
            preg_match_all("~CONSTRAINT ($Re) FOREIGN KEY ?\\(((?:$Re,? ?)+)\\) REFERENCES ($Re)(?:\\.($Re))? \\(((?:$Re,? ?)+)\\)(?: ON DELETE ($oe))?(?: ON UPDATE ($oe))?~", $lb, $Gd, PREG_SET_ORDER);
            foreach ($Gd
as$C) {
                preg_match_all("~$Re~", $C[2], $Xf);
                preg_match_all("~$Re~", $C[5], $xg);
                $K[idf_unescape($C[1])]=array("db"=>idf_unescape($C[4]!=""?$C[3]:$C[4]),"table"=>idf_unescape($C[4]!=""?$C[4]:$C[3]),"source"=>array_map('idf_unescape', $Xf[0]),"target"=>array_map('idf_unescape', $xg[0]),"on_delete"=>($C[6]?$C[6]:"RESTRICT"),"on_update"=>($C[7]?$C[7]:"RESTRICT"),);
            }
        }
        return$K;
    }
    function view($E)
    {
        global$f;
        return
array("select"=>preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU', '', $f->result("SHOW CREATE VIEW ".table($E), 1)));
    }
    function collations()
    {
        $K=array();
        foreach (get_rows("SHOW COLLATION")as$L) {
            if ($L["Default"]) {
                $K[$L["Charset"]][-1]=$L["Collation"];
            } else {
                $K[$L["Charset"]][]=$L["Collation"];
            }
        }
        ksort($K);
        foreach ($K
as$z=>$X) {
            asort($K[$z]);
        }
        return$K;
    }
    function information_schema($j)
    {
        return(min_version(5)&&$j=="information_schema")||(min_version(5.5)&&$j=="performance_schema");
    }
    function error()
    {
        global$f;
        return
h(preg_replace('~^You have an error.*syntax to use~U', "Syntax error", $f->error));
    }
    function create_database($j, $Xa)
    {
        return
queries("CREATE DATABASE ".idf_escape($j).($Xa?" COLLATE ".q($Xa):""));
    }
    function drop_databases($i)
    {
        $K=apply_queries("DROP DATABASE", $i, 'idf_escape');
        restart_session();
        set_session("dbs", null);
        return$K;
    }
    function rename_database($E, $Xa)
    {
        $K=false;
        if (create_database($E, $Xa)) {
            $vf=array();
            foreach (tables_list()as$Q=>$U) {
                $vf[]=table($Q)." TO ".idf_escape($E).".".table($Q);
            }
            $K=(!$vf||queries("RENAME TABLE ".implode(", ", $vf)));
            if ($K) {
                queries("DROP DATABASE ".idf_escape(DB));
            }
            restart_session();
            set_session("dbs", null);
        }
        return$K;
    }
    function auto_increment()
    {
        $_a=" PRIMARY KEY";
        if ($_GET["create"]!=""&&$_POST["auto_increment_col"]) {
            foreach (indexes($_GET["create"])as$w) {
                if (in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"], $w["columns"], true)) {
                    $_a="";
                    break;
                }
                if ($w["type"]=="PRIMARY") {
                    $_a=" UNIQUE";
                }
            }
        }
        return" AUTO_INCREMENT$_a";
    }
    function alter_table($Q, $E, $n, $yc, $cb, $Yb, $Xa, $za, $Ne)
    {
        $ta=array();
        foreach ($n
as$m) {
            $ta[]=($m[1]?($Q!=""?($m[0]!=""?"CHANGE ".idf_escape($m[0]):"ADD"):" ")." ".implode($m[1]).($Q!=""?$m[2]:""):"DROP ".idf_escape($m[0]));
        }
        $ta=array_merge($ta, $yc);
        $eg=($cb!==null?" COMMENT=".q($cb):"").($Yb?" ENGINE=".q($Yb):"").($Xa?" COLLATE ".q($Xa):"").($za!=""?" AUTO_INCREMENT=$za":"");
        if ($Q=="") {
            return
queries("CREATE TABLE ".table($E)." (\n".implode(",\n", $ta)."\n)$eg$Ne");
        }
        if ($Q!=$E) {
            $ta[]="RENAME TO ".table($E);
        }
        if ($eg) {
            $ta[]=ltrim($eg);
        }
        return($ta||$Ne?queries("ALTER TABLE ".table($Q)."\n".implode(",\n", $ta).$Ne):true);
    }
    function alter_indexes($Q, $ta)
    {
        foreach ($ta
as$z=>$X) {
            $ta[$z]=($X[2]=="DROP"?"\nDROP INDEX ".idf_escape($X[1]):"\nADD $X[0] ".($X[0]=="PRIMARY"?"KEY ":"").($X[1]!=""?idf_escape($X[1])." ":"")."(".implode(", ", $X[2]).")");
        }
        return
queries("ALTER TABLE ".table($Q).implode(",", $ta));
    }
    function truncate_tables($S)
    {
        return
apply_queries("TRUNCATE TABLE", $S);
    }
    function drop_views($sh)
    {
        return
queries("DROP VIEW ".implode(", ", array_map('table', $sh)));
    }
    function drop_tables($S)
    {
        return
queries("DROP TABLE ".implode(", ", array_map('table', $S)));
    }
    function move_tables($S, $sh, $xg)
    {
        $vf=array();
        foreach (array_merge($S, $sh)as$Q) {
            $vf[]=table($Q)." TO ".idf_escape($xg).".".table($Q);
        }
        return
queries("RENAME TABLE ".implode(", ", $vf));
    }
    function copy_tables($S, $sh, $xg)
    {
        queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");
        foreach ($S
as$Q) {
            $E=($xg==DB?table("copy_$Q"):idf_escape($xg).".".table($Q));
            if (($_POST["overwrite"]&&!queries("\nDROP TABLE IF EXISTS $E"))||!queries("CREATE TABLE $E LIKE ".table($Q))||!queries("INSERT INTO $E SELECT * FROM ".table($Q))) {
                return
false;
            }
            foreach (get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q, "%_\\")))as$L) {
                $Rg=$L["Trigger"];
                if (!queries("CREATE TRIGGER ".($xg==DB?idf_escape("copy_$Rg"):idf_escape($xg).".".idf_escape($Rg))." $L[Timing] $L[Event] ON $E FOR EACH ROW\n$L[Statement];")) {
                    return
false;
                }
            }
        }
        foreach ($sh
as$Q) {
            $E=($xg==DB?table("copy_$Q"):idf_escape($xg).".".table($Q));
            $rh=view($Q);
            if (($_POST["overwrite"]&&!queries("DROP VIEW IF EXISTS $E"))||!queries("CREATE VIEW $E AS $rh[select]")) {
                return
false;
            }
        }
        return
true;
    }
    function trigger($E)
    {
        if ($E=="") {
            return
array();
        }
        $M=get_rows("SHOW TRIGGERS WHERE `Trigger` = ".q($E));
        return
reset($M);
    }
    function triggers($Q)
    {
        $K=array();
        foreach (get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q, "%_\\")))as$L) {
            $K[$L["Trigger"]]=array($L["Timing"],$L["Event"]);
        }
        return$K;
    }
    function trigger_options()
    {
        return
array("Timing"=>array("BEFORE","AFTER"),"Event"=>array("INSERT","UPDATE","DELETE"),"Type"=>array("FOR EACH ROW"),);
    }
    function routine($E, $U)
    {
        global$f,$ac,$ad,$Wg;
        $ra=array("bool","boolean","integer","double precision","real","dec","numeric","fixed","national char","national varchar");
        $Yf="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
        $Vg="((".implode("|", array_merge(array_keys($Wg), $ra)).")\\b(?:\\s*\\(((?:[^'\")]|$ac)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";
        $Re="$Yf*(".($U=="FUNCTION"?"":$ad).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Vg";
        $h=$f->result("SHOW CREATE $U ".idf_escape($E), 2);
        preg_match("~\\(((?:$Re\\s*,?)*)\\)\\s*".($U=="FUNCTION"?"RETURNS\\s+$Vg\\s+":"")."(.*)~is", $h, $C);
        $n=array();
        preg_match_all("~$Re\\s*,?~is", $C[1], $Gd, PREG_SET_ORDER);
        foreach ($Gd
as$Ie) {
            $n[]=array("field"=>str_replace("``", "`", $Ie[2]).$Ie[3],"type"=>strtolower($Ie[5]),"length"=>preg_replace_callback("~$ac~s", 'normalize_enum', $Ie[6]),"unsigned"=>strtolower(preg_replace('~\s+~', ' ', trim("$Ie[8] $Ie[7]"))),"null"=>1,"full_type"=>$Ie[4],"inout"=>strtoupper($Ie[1]),"collation"=>strtolower($Ie[9]),);
        }
        if ($U!="FUNCTION") {
            return
array("fields"=>$n,"definition"=>$C[11]);
        }
        return
array("fields"=>$n,"returns"=>array("type"=>$C[12],"length"=>$C[13],"unsigned"=>$C[15],"collation"=>$C[16]),"definition"=>$C[17],"language"=>"SQL",);
    }
    function routines()
    {
        return
get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = ".q(DB));
    }
    function routine_languages()
    {
        return
array();
    }
    function routine_id($E, $L)
    {
        return
idf_escape($E);
    }
    function last_id()
    {
        global$f;
        return$f->result("SELECT LAST_INSERT_ID()");
    }
    function explain($f, $I)
    {
        return$f->query("EXPLAIN ".(min_version(5.1)?"PARTITIONS ":"").$I);
    }
    function found_rows($R, $Z)
    {
        return($Z||$R["Engine"]!="InnoDB"?null:$R["Rows"]);
    }
    function types()
    {
        return
array();
    }
    function schemas()
    {
        return
array();
    }
    function get_schema()
    {
        return"";
    }
    function set_schema($Gf, $g=null)
    {
        return
true;
    }
    function create_sql($Q, $za, $jg)
    {
        global$f;
        $K=$f->result("SHOW CREATE TABLE ".table($Q), 1);
        if (!$za) {
            $K=preg_replace('~ AUTO_INCREMENT=\d+~', '', $K);
        }
        return$K;
    }
    function truncate_sql($Q)
    {
        return"TRUNCATE ".table($Q);
    }
    function use_sql($ub)
    {
        return"USE ".idf_escape($ub);
    }
    function trigger_sql($Q)
    {
        $K="";
        foreach (get_rows("SHOW TRIGGERS LIKE ".q(addcslashes($Q, "%_\\")), null, "-- ")as$L) {
            $K.="\nCREATE TRIGGER ".idf_escape($L["Trigger"])." $L[Timing] $L[Event] ON ".table($L["Table"])." FOR EACH ROW\n$L[Statement];;\n";
        }
        return$K;
    }
    function show_variables()
    {
        return
get_key_vals("SHOW VARIABLES");
    }
    function process_list()
    {
        return
get_rows("SHOW FULL PROCESSLIST");
    }
    function show_status()
    {
        return
get_key_vals("SHOW STATUS");
    }
    function convert_field($m)
    {
        if (preg_match("~binary~", $m["type"])) {
            return"HEX(".idf_escape($m["field"]).")";
        }
        if ($m["type"]=="bit") {
            return"BIN(".idf_escape($m["field"])." + 0)";
        }
        if (preg_match("~geometry|point|linestring|polygon~", $m["type"])) {
            return(min_version(8)?"ST_":"")."AsWKT(".idf_escape($m["field"]).")";
        }
    }
    function unconvert_field($m, $K)
    {
        if (preg_match("~binary~", $m["type"])) {
            $K="UNHEX($K)";
        }
        if ($m["type"]=="bit") {
            $K="CONV($K, 2, 10) + 0";
        }
        if (preg_match("~geometry|point|linestring|polygon~", $m["type"])) {
            $K=(min_version(8)?"ST_":"")."GeomFromText($K, SRID($m[field]))";
        }
        return$K;
    }
    function support($qc)
    {
        return!preg_match("~scheme|sequence|type|view_trigger|materializedview".(min_version(8)?"":"|descidx".(min_version(5.1)?"":"|event|partitioning".(min_version(5)?"":"|routine|trigger|view")))."~", $qc);
    }
    function kill_process($X)
    {
        return
queries("KILL ".number($X));
    }
    function connection_id()
    {
        return"SELECT CONNECTION_ID()";
    }
    function max_connections()
    {
        global$f;
        return$f->result("SELECT @@max_connections");
    }
    $y="sql";
    $Wg=array();
    $ig=array();
    foreach (array(lang(24)=>array("tinyint"=>3,"smallint"=>5,"mediumint"=>8,"int"=>10,"bigint"=>20,"decimal"=>66,"float"=>12,"double"=>21),lang(25)=>array("date"=>10,"datetime"=>19,"timestamp"=>19,"time"=>10,"year"=>4),lang(23)=>array("char"=>255,"varchar"=>65535,"tinytext"=>255,"text"=>65535,"mediumtext"=>16777215,"longtext"=>4294967295),lang(26)=>array("enum"=>65535,"set"=>64),lang(27)=>array("bit"=>20,"binary"=>255,"varbinary"=>65535,"tinyblob"=>255,"blob"=>65535,"mediumblob"=>16777215,"longblob"=>4294967295),lang(28)=>array("geometry"=>0,"point"=>0,"linestring"=>0,"polygon"=>0,"multipoint"=>0,"multilinestring"=>0,"multipolygon"=>0,"geometrycollection"=>0),)as$z=>$X) {
        $Wg+=$X;
        $ig[$z]=array_keys($X);
    }
    $dh=array("unsigned","zerofill","unsigned zerofill");
    $se=array("=","<",">","<=",">=","!=","LIKE","LIKE %%","REGEXP","IN","FIND_IN_SET","IS NULL","NOT LIKE","NOT REGEXP","NOT IN","IS NOT NULL","SQL");
    $Dc=array("char_length","date","from_unixtime","lower","round","floor","ceil","sec_to_time","time_to_sec","upper");
    $Ic=array("avg","count","count distinct","group_concat","max","min","sum");
    $Qb=array(array("char"=>"md5/sha1/password/encrypt/uuid","binary"=>"md5/sha1","date|time"=>"now",),array(number_type()=>"+/-","date"=>"+ interval/- interval","time"=>"addtime/subtime","char|text"=>"concat",));
}define("SERVER", $_GET[DRIVER]);define("DB", $_GET["db"]);define("ME", str_replace(":", "%3a", preg_replace('~^[^?]*/([^?]*).*~', '\1', $_SERVER["REQUEST_URI"])).'?'.(sid()?SID.'&':'').(SERVER!==null?DRIVER."=".urlencode(SERVER).'&':'').(isset($_GET["username"])?"username=".urlencode($_GET["username"]).'&':'').(DB!=""?'db='.urlencode(DB).'&'.(isset($_GET["ns"])?"ns=".urlencode($_GET["ns"])."&":""):''));$ga="4.7.6";class Adminer
{
    public $operators;
    public function name()
    {
        return"<a href='https://www.adminer.org/'".target_blank()." id='h1'>Adminer</a>";
    }
    public function credentials()
    {
        return
array(SERVER,$_GET["username"],get_password());
    }
    public function connectSsl()
    {
    }
    public function permanentLogin($h=false)
    {
        return
password_file($h);
    }
    public function bruteForceKey()
    {
        return$_SERVER["REMOTE_ADDR"];
    }
    public function serverName($O)
    {
        return
h($O);
    }
    public function database()
    {
        return
DB;
    }
    public function databases($wc=true)
    {
        return
get_databases($wc);
    }
    public function schemas()
    {
        return
schemas();
    }
    public function queryTimeout()
    {
        return
2;
    }
    public function headers()
    {
    }
    public function csp()
    {
        return
csp();
    }
    public function head()
    {
        return
true;
    }
    public function css()
    {
        $K=array();
        $tc="adminer.css";
        if (file_exists($tc)) {
            $K[]="$tc?v=".crc32(file_get_contents($tc));
        }
        return$K;
    }
    public function loginForm()
    {
        global$Jb;
        echo"<table cellspacing='0' class='layout'>\n",$this->loginFormField('driver', '<tr><th>'.lang(29).'<td>', html_select("auth[driver]", $Jb, DRIVER, "loginDriver(this);")."\n"),$this->loginFormField('server', '<tr><th>'.lang(30).'<td>', '<input name="auth[server]" value="'.h(SERVER).'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">'."\n"),$this->loginFormField('username', '<tr><th>'.lang(31).'<td>', '<input name="auth[username]" id="username" value="'.h($_GET["username"]).'" autocomplete="username" autocapitalize="off">'.script("focus(qs('#username')); qs('#username').form['auth[driver]'].onchange();")),$this->loginFormField('password', '<tr><th>'.lang(32).'<td>', '<input type="password" name="auth[password]" autocomplete="current-password">'."\n"),$this->loginFormField('db', '<tr><th>'.lang(33).'<td>', '<input name="auth[db]" value="'.h($_GET["db"]).'" autocapitalize="off">'."\n"),"</table>\n","<p><input type='submit' value='".lang(34)."'>\n",checkbox("auth[permanent]", 1, $_COOKIE["adminer_permanent"], lang(35))."\n";
    }
    public function loginFormField($E, $Pc, $Y)
    {
        return$Pc.$Y;
    }
    public function login($Cd, $G)
    {
        if ($G=="") {
            return
lang(36, target_blank());
        }
        return
true;
    }
    public function tableName($pg)
    {
        return
h($pg["Name"]);
    }
    public function fieldName($m, $we=0)
    {
        return'<span title="'.h($m["full_type"]).'">'.h($m["field"]).'</span>';
    }
    public function selectLinks($pg, $P="")
    {
        global$y,$k;
        echo'<p class="links">';
        $Bd=array("select"=>lang(37));
        if (support("table")||support("indexes")) {
            $Bd["table"]=lang(38);
        }
        if (support("table")) {
            if (is_view($pg)) {
                $Bd["view"]=lang(39);
            } else {
                $Bd["create"]=lang(40);
            }
        }
        if ($P!==null) {
            $Bd["edit"]=lang(41);
        }
        $E=$pg["Name"];
        foreach ($Bd
as$z=>$X) {
            echo" <a href='".h(ME)."$z=".urlencode($E).($z=="edit"?$P:"")."'".bold(isset($_GET[$z])).">$X</a>";
        }
        echo
doc_link(array($y=>$k->tableHelp($E)), "?"),"\n";
    }
    public function foreignKeys($Q)
    {
        return
foreign_keys($Q);
    }
    public function backwardKeys($Q, $og)
    {
        return
array();
    }
    public function backwardKeysPrint($Ba, $L)
    {
    }
    public function selectQuery($I, $dg, $oc=false)
    {
        global$y,$k;
        $K="</p>\n";
        if (!$oc&&($vh=$k->warnings())) {
            $u="warnings";
            $K=", <a href='#$u'>".lang(42)."</a>".script("qsl('a').onclick = partial(toggle, '$u');", "")."$K<div id='$u' class='hidden'>\n$vh</div>\n";
        }
        return"<p><code class='jush-$y'>".h(str_replace("\n", " ", $I))."</code> <span class='time'>(".format_time($dg).")</span>".(support("sql")?" <a href='".h(ME)."sql=".urlencode($I)."'>".lang(10)."</a>":"").$K;
    }
    public function sqlCommandQuery($I)
    {
        return
shorten_utf8(trim($I), 1000);
    }
    public function rowDescription($Q)
    {
        return"";
    }
    public function rowDescriptions($M, $zc)
    {
        return$M;
    }
    public function selectLink($X, $m)
    {
    }
    public function selectVal($X, $A, $m, $De)
    {
        $K=($X===null?"<i>NULL</i>":(preg_match("~char|binary|boolean~", $m["type"])&&!preg_match("~var~", $m["type"])?"<code>$X</code>":$X));
        if (preg_match('~blob|bytea|raw|file~', $m["type"])&&!is_utf8($X)) {
            $K="<i>".lang(43, strlen($De))."</i>";
        }
        if (preg_match('~json~', $m["type"])) {
            $K="<code class='jush-js'>$K</code>";
        }
        return($A?"<a href='".h($A)."'".(is_url($A)?target_blank():"").">$K</a>":$K);
    }
    public function editVal($X, $m)
    {
        return$X;
    }
    public function tableStructurePrint($n)
    {
        echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n","<thead><tr><th>".lang(44)."<td>".lang(45).(support("comment")?"<td>".lang(46):"")."</thead>\n";
        foreach ($n
as$m) {
            echo"<tr".odd()."><th>".h($m["field"]),"<td><span title='".h($m["collation"])."'>".h($m["full_type"])."</span>",($m["null"]?" <i>NULL</i>":""),($m["auto_increment"]?" <i>".lang(47)."</i>":""),(isset($m["default"])?" <span title='".lang(48)."'>[<b>".h($m["default"])."</b>]</span>":""),(support("comment")?"<td>".h($m["comment"]):""),"\n";
        }
        echo"</table>\n","</div>\n";
    }
    public function tableIndexesPrint($x)
    {
        echo"<table cellspacing='0'>\n";
        foreach ($x
as$E=>$w) {
            ksort($w["columns"]);
            $cf=array();
            foreach ($w["columns"]as$z=>$X) {
                $cf[]="<i>".h($X)."</i>".($w["lengths"][$z]?"(".$w["lengths"][$z].")":"").($w["descs"][$z]?" DESC":"");
            }
            echo"<tr title='".h($E)."'><th>$w[type]<td>".implode(", ", $cf)."\n";
        }
        echo"</table>\n";
    }
    public function selectColumnsPrint($N, $d)
    {
        global$Dc,$Ic;
        print_fieldset("select", lang(49), $N);
        $t=0;
        $N[""]=array();
        foreach ($N
as$z=>$X) {
            $X=$_GET["columns"][$z];
            $c=select_input(" name='columns[$t][col]'", $d, $X["col"], ($z!==""?"selectFieldChange":"selectAddRow"));
            echo"<div>".($Dc||$Ic?"<select name='columns[$t][fun]'>".optionlist(array(-1=>"")+array_filter(array(lang(50)=>$Dc,lang(51)=>$Ic)), $X["fun"])."</select>".on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'", 1).script("qsl('select').onchange = function () { helpClose();".($z!==""?"":" qsl('select, input', this.parentNode).onchange();")." };", "")."($c)":$c)."</div>\n";
            $t++;
        }
        echo"</div></fieldset>\n";
    }
    public function selectSearchPrint($Z, $d, $x)
    {
        print_fieldset("search", lang(52), $Z);
        foreach ($x
as$t=>$w) {
            if ($w["type"]=="FULLTEXT") {
                echo"<div>(<i>".implode("</i>, <i>", array_map('h', $w["columns"]))."</i>) AGAINST"," <input type='search' name='fulltext[$t]' value='".h($_GET["fulltext"][$t])."'>",script("qsl('input').oninput = selectFieldChange;", ""),checkbox("boolean[$t]", 1, isset($_GET["boolean"][$t]), "BOOL"),"</div>\n";
            }
        }
        $La="this.parentNode.firstChild.onchange();";
        foreach (array_merge((array)$_GET["where"], array(array()))as$t=>$X) {
            if (!$X||("$X[col]$X[val]"!=""&&in_array($X["op"], $this->operators))) {
                echo"<div>".select_input(" name='where[$t][col]'", $d, $X["col"], ($X?"selectFieldChange":"selectAddRow"), "(".lang(53).")"),html_select("where[$t][op]", $this->operators, $X["op"], $La),"<input type='search' name='where[$t][val]' value='".h($X["val"])."'>",script("mixin(qsl('input'), {oninput: function () { $La }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});", ""),"</div>\n";
            }
        }
        echo"</div></fieldset>\n";
    }
    public function selectOrderPrint($we, $d, $x)
    {
        print_fieldset("sort", lang(54), $we);
        $t=0;
        foreach ((array)$_GET["order"]as$z=>$X) {
            if ($X!="") {
                echo"<div>".select_input(" name='order[$t]'", $d, $X, "selectFieldChange"),checkbox("desc[$t]", 1, isset($_GET["desc"][$z]), lang(55))."</div>\n";
                $t++;
            }
        }
        echo"<div>".select_input(" name='order[$t]'", $d, "", "selectAddRow"),checkbox("desc[$t]", 1, false, lang(55))."</div>\n","</div></fieldset>\n";
    }
    public function selectLimitPrint($_)
    {
        echo"<fieldset><legend>".lang(56)."</legend><div>";
        echo"<input type='number' name='limit' class='size' value='".h($_)."'>",script("qsl('input').oninput = selectFieldChange;", ""),"</div></fieldset>\n";
    }
    public function selectLengthPrint($Bg)
    {
        if ($Bg!==null) {
            echo"<fieldset><legend>".lang(57)."</legend><div>","<input type='number' name='text_length' class='size' value='".h($Bg)."'>","</div></fieldset>\n";
        }
    }
    public function selectActionPrint($x)
    {
        echo"<fieldset><legend>".lang(58)."</legend><div>","<input type='submit' value='".lang(49)."'>"," <span id='noindex' title='".lang(59)."'></span>","<script".nonce().">\n","var indexColumns = ";
        $d=array();
        foreach ($x
as$w) {
            $rb=reset($w["columns"]);
            if ($w["type"]!="FULLTEXT"&&$rb) {
                $d[$rb]=1;
            }
        }
        $d[""]=1;
        foreach ($d
as$z=>$X) {
            json_row($z);
        }
        echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";
    }
    public function selectCommandPrint()
    {
        return!information_schema(DB);
    }
    public function selectImportPrint()
    {
        return!information_schema(DB);
    }
    public function selectEmailPrint($Vb, $d)
    {
    }
    public function selectColumnsProcess($d, $x)
    {
        global$Dc,$Ic;
        $N=array();
        $s=array();
        foreach ((array)$_GET["columns"]as$z=>$X) {
            if ($X["fun"]=="count"||($X["col"]!=""&&(!$X["fun"]||in_array($X["fun"], $Dc)||in_array($X["fun"], $Ic)))) {
                $N[$z]=apply_sql_function($X["fun"], ($X["col"]!=""?idf_escape($X["col"]):"*"));
                if (!in_array($X["fun"], $Ic)) {
                    $s[]=$N[$z];
                }
            }
        }
        return
array($N,$s);
    }
    public function selectSearchProcess($n, $x)
    {
        global$f,$k;
        $K=array();
        foreach ($x
as$t=>$w) {
            if ($w["type"]=="FULLTEXT"&&$_GET["fulltext"][$t]!="") {
                $K[]="MATCH (".implode(", ", array_map('idf_escape', $w["columns"])).") AGAINST (".q($_GET["fulltext"][$t]).(isset($_GET["boolean"][$t])?" IN BOOLEAN MODE":"").")";
            }
        }
        foreach ((array)$_GET["where"]as$z=>$X) {
            if ("$X[col]$X[val]"!=""&&in_array($X["op"], $this->operators)) {
                $Ze="";
                $eb=" $X[op]";
                if (preg_match('~IN$~', $X["op"])) {
                    $Xc=process_length($X["val"]);
                    $eb.=" ".($Xc!=""?$Xc:"(NULL)");
                } elseif ($X["op"]=="SQL") {
                    $eb=" $X[val]";
                } elseif ($X["op"]=="LIKE %%") {
                    $eb=" LIKE ".$this->processInput($n[$X["col"]], "%$X[val]%");
                } elseif ($X["op"]=="ILIKE %%") {
                    $eb=" ILIKE ".$this->processInput($n[$X["col"]], "%$X[val]%");
                } elseif ($X["op"]=="FIND_IN_SET") {
                    $Ze="$X[op](".q($X["val"]).", ";
                    $eb=")";
                } elseif (!preg_match('~NULL$~', $X["op"])) {
                    $eb.=" ".$this->processInput($n[$X["col"]], $X["val"]);
                }
                if ($X["col"]!="") {
                    $K[]=$Ze.$k->convertSearch(idf_escape($X["col"]), $X, $n[$X["col"]]).$eb;
                } else {
                    $Za=array();
                    foreach ($n
as$E=>$m) {
                        if ((preg_match('~^[-\d.'.(preg_match('~IN$~', $X["op"])?',':'').']+$~', $X["val"])||!preg_match('~'.number_type().'|bit~', $m["type"]))&&(!preg_match("~[\x80-\xFF]~", $X["val"])||preg_match('~char|text|enum|set~', $m["type"]))) {
                            $Za[]=$Ze.$k->convertSearch(idf_escape($E), $X, $m).$eb;
                        }
                    }
                    $K[]=($Za?"(".implode(" OR ", $Za).")":"1 = 0");
                }
            }
        }
        return$K;
    }
    public function selectOrderProcess($n, $x)
    {
        $K=array();
        foreach ((array)$_GET["order"]as$z=>$X) {
            if ($X!="") {
                $K[]=(preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~', $X)?$X:idf_escape($X)).(isset($_GET["desc"][$z])?" DESC":"");
            }
        }
        return$K;
    }
    public function selectLimitProcess()
    {
        return(isset($_GET["limit"])?$_GET["limit"]:"50");
    }
    public function selectLengthProcess()
    {
        return(isset($_GET["text_length"])?$_GET["text_length"]:"100");
    }
    public function selectEmailProcess($Z, $zc)
    {
        return
false;
    }
    public function selectQueryBuild($N, $Z, $s, $we, $_, $F)
    {
        return"";
    }
    public function messageQuery($I, $Cg, $oc=false)
    {
        global$y,$k;
        restart_session();
        $Qc=&get_session("queries");
        if (!$Qc[$_GET["db"]]) {
            $Qc[$_GET["db"]]=array();
        }
        if (strlen($I)>1e6) {
            $I=preg_replace('~[\x80-\xFF]+$~', '', substr($I, 0, 1e6))."\n…";
        }
        $Qc[$_GET["db"]][]=array($I,time(),$Cg);
        $bg="sql-".count($Qc[$_GET["db"]]);
        $K="<a href='#$bg' class='toggle'>".lang(60)."</a>\n";
        if (!$oc&&($vh=$k->warnings())) {
            $u="warnings-".count($Qc[$_GET["db"]]);
            $K="<a href='#$u' class='toggle'>".lang(42)."</a>, $K<div id='$u' class='hidden'>\n$vh</div>\n";
        }
        return" <span class='time'>".@date("H:i:s")."</span>"." $K<div id='$bg' class='hidden'><pre><code class='jush-$y'>".shorten_utf8($I, 1000)."</code></pre>".($Cg?" <span class='time'>($Cg)</span>":'').(support("sql")?'<p><a href="'.h(str_replace("db=".urlencode(DB), "db=".urlencode($_GET["db"]), ME).'sql=&history='.(count($Qc[$_GET["db"]])-1)).'">'.lang(10).'</a>':'').'</div>';
    }
    public function editFunctions($m)
    {
        global$Qb;
        $K=($m["null"]?"NULL/":"");
        foreach ($Qb
as$z=>$Dc) {
            if (!$z||(!isset($_GET["call"])&&(isset($_GET["select"])||where($_GET)))) {
                foreach ($Dc
as$Re=>$X) {
                    if (!$Re||preg_match("~$Re~", $m["type"])) {
                        $K.="/$X";
                    }
                }
                if ($z&&!preg_match('~set|blob|bytea|raw|file~', $m["type"])) {
                    $K.="/SQL";
                }
            }
        }
        if ($m["auto_increment"]&&!isset($_GET["select"])&&!where($_GET)) {
            $K=lang(47);
        }
        return
explode("/", $K);
    }
    public function editInput($Q, $m, $xa, $Y)
    {
        if ($m["type"]=="enum") {
            return(isset($_GET["select"])?"<label><input type='radio'$xa value='-1' checked><i>".lang(8)."</i></label> ":"").($m["null"]?"<label><input type='radio'$xa value=''".($Y!==null||isset($_GET["select"])?"":" checked")."><i>NULL</i></label> ":"").enum_input("radio", $xa, $m, $Y, 0);
        }
        return"";
    }
    public function editHint($Q, $m, $Y)
    {
        return"";
    }
    public function processInput($m, $Y, $r="")
    {
        if ($r=="SQL") {
            return$Y;
        }
        $E=$m["field"];
        $K=q($Y);
        if (preg_match('~^(now|getdate|uuid)$~', $r)) {
            $K="$r()";
        } elseif (preg_match('~^current_(date|timestamp)$~', $r)) {
            $K=$r;
        } elseif (preg_match('~^([+-]|\|\|)$~', $r)) {
            $K=idf_escape($E)." $r $K";
        } elseif (preg_match('~^[+-] interval$~', $r)) {
            $K=idf_escape($E)." $r ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i", $Y)?$Y:$K);
        } elseif (preg_match('~^(addtime|subtime|concat)$~', $r)) {
            $K="$r(".idf_escape($E).", $K)";
        } elseif (preg_match('~^(md5|sha1|password|encrypt)$~', $r)) {
            $K="$r($K)";
        }
        return
unconvert_field($m, $K);
    }
    public function dumpOutput()
    {
        $K=array('text'=>lang(61),'file'=>lang(62));
        if (function_exists('gzencode')) {
            $K['gz']='gzip';
        }
        return$K;
    }
    public function dumpFormat()
    {
        return
array('sql'=>'SQL','csv'=>'CSV,','csv;'=>'CSV;','tsv'=>'TSV');
    }
    public function dumpDatabase($j)
    {
    }
    public function dumpTable($Q, $jg, $jd=0)
    {
        if ($_POST["format"]!="sql") {
            echo"\xef\xbb\xbf";
            if ($jg) {
                dump_csv(array_keys(fields($Q)));
            }
        } else {
            if ($jd==2) {
                $n=array();
                foreach (fields($Q)as$E=>$m) {
                    $n[]=idf_escape($E)." $m[full_type]";
                }
                $h="CREATE TABLE ".table($Q)." (".implode(", ", $n).")";
            } else {
                $h=create_sql($Q, $_POST["auto_increment"], $jg);
            }
            set_utf8mb4($h);
            if ($jg&&$h) {
                if ($jg=="DROP+CREATE"||$jd==1) {
                    echo"DROP ".($jd==2?"VIEW":"TABLE")." IF EXISTS ".table($Q).";\n";
                }
                if ($jd==1) {
                    $h=remove_definer($h);
                }
                echo"$h;\n\n";
            }
        }
    }
    public function dumpData($Q, $jg, $I)
    {
        global$f,$y;
        $Id=($y=="sqlite"?0:1048576);
        if ($jg) {
            if ($_POST["format"]=="sql") {
                if ($jg=="TRUNCATE+INSERT") {
                    echo
truncate_sql($Q).";\n";
                }
                $n=fields($Q);
            }
            $J=$f->query($I, 1);
            if ($J) {
                $cd="";
                $Ja="";
                $md=array();
                $lg="";
                $rc=($Q!=''?'fetch_assoc':'fetch_row');
                while ($L=$J->$rc()) {
                    if (!$md) {
                        $nh=array();
                        foreach ($L
as$X) {
                            $m=$J->fetch_field();
                            $md[]=$m->name;
                            $z=idf_escape($m->name);
                            $nh[]="$z = VALUES($z)";
                        }
                        $lg=($jg=="INSERT+UPDATE"?"\nON DUPLICATE KEY UPDATE ".implode(", ", $nh):"").";\n";
                    }
                    if ($_POST["format"]!="sql") {
                        if ($jg=="table") {
                            dump_csv($md);
                            $jg="INSERT";
                        }
                        dump_csv($L);
                    } else {
                        if (!$cd) {
                            $cd="INSERT INTO ".table($Q)." (".implode(", ", array_map('idf_escape', $md)).") VALUES";
                        }
                        foreach ($L
as$z=>$X) {
                            $m=$n[$z];
                            $L[$z]=($X!==null?unconvert_field($m, preg_match(number_type(), $m["type"])&&!preg_match('~\[~', $m["full_type"])&&is_numeric($X)?$X:q(($X===false?0:$X))):"NULL");
                        }
                        $Ef=($Id?"\n":" ")."(".implode(",\t", $L).")";
                        if (!$Ja) {
                            $Ja=$cd.$Ef;
                        } elseif (strlen($Ja)+4+strlen($Ef)+strlen($lg)<$Id) {
                            $Ja.=",$Ef";
                        } else {
                            echo$Ja.$lg;
                            $Ja=$cd.$Ef;
                        }
                    }
                }
                if ($Ja) {
                    echo$Ja.$lg;
                }
            } elseif ($_POST["format"]=="sql") {
                echo"-- ".str_replace("\n", " ", $f->error)."\n";
            }
        }
    }
    public function dumpFilename($Uc)
    {
        return
friendly_url($Uc!=""?$Uc:(SERVER!=""?SERVER:"localhost"));
    }
    public function dumpHeaders($Uc, $Ud=false)
    {
        $Fe=$_POST["output"];
        $lc=(preg_match('~sql~', $_POST["format"])?"sql":($Ud?"tar":"csv"));
        header("Content-Type: ".($Fe=="gz"?"application/x-gzip":($lc=="tar"?"application/x-tar":($lc=="sql"||$Fe!="file"?"text/plain":"text/csv")."; charset=utf-8")));
        if ($Fe=="gz") {
            ob_start('ob_gzencode', 1e6);
        }
        return$lc;
    }
    public function importServerPath()
    {
        return"adminer.sql";
    }
    public function homepage()
    {
        echo'<p class="links">'.($_GET["ns"]==""&&support("database")?'<a href="'.h(ME).'database=">'.lang(63)."</a>\n":""),(support("scheme")?"<a href='".h(ME)."scheme='>".($_GET["ns"]!=""?lang(64):lang(65))."</a>\n":""),($_GET["ns"]!==""?'<a href="'.h(ME).'schema=">'.lang(66)."</a>\n":""),(support("privileges")?"<a href='".h(ME)."privileges='>".lang(67)."</a>\n":"");
        return
true;
    }
    public function navigation($Td)
    {
        global$ga,$y,$Jb,$f;
        echo'<h1>
',$this->name(),' <span class="version">',$ga,'</span>
<a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($ga, $_COOKIE["adminer_version"])<0?h($_COOKIE["adminer_version"]):""),'</a>
</h1>
';
        if ($Td=="auth") {
            $Fe="";
            foreach ((array)$_SESSION["pwds"]as$ph=>$Pf) {
                foreach ($Pf
as$O=>$lh) {
                    foreach ($lh
as$V=>$G) {
                        if ($G!==null) {
                            $xb=$_SESSION["db"][$ph][$O][$V];
                            foreach (($xb?array_keys($xb):array(""))as$j) {
                                $Fe.="<li><a href='".h(auth_url($ph, $O, $V, $j))."'>($Jb[$ph]) ".h($V.($O!=""?"@".$this->serverName($O):"").($j!=""?" - $j":""))."</a>\n";
                            }
                        }
                    }
                }
            }
            if ($Fe) {
                echo"<ul id='logins'>\n$Fe</ul>\n".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");
            }
        } else {
            if ($_GET["ns"]!==""&&!$Td&&DB!="") {
                $f->select_db(DB);
                $S=table_status('', true);
            }
            echo
script_src(preg_replace("~\\?.*~", "", ME)."?file=jush.js&version=4.7.6");
            if (support("sql")) {
                echo'<script',nonce(),'>
';
                if ($S) {
                    $Bd=array();
                    foreach ($S
as$Q=>$U) {
                        $Bd[]=preg_quote($Q, '/');
                    }
                    echo"var jushLinks = { $y: [ '".js_escape(ME).(support("table")?"table=":"select=")."\$&', /\\b(".implode("|", $Bd).")\\b/g ] };\n";
                    foreach (array("bac","bra","sqlite_quo","mssql_bra")as$X) {
                        echo"jushLinks.$X = jushLinks.$y;\n";
                    }
                }
                $Of=$f->server_info;
                echo'bodyLoad(\'',(is_object($f)?preg_replace('~^(\d\.?\d).*~s', '\1', $Of):""),'\'',(preg_match('~MariaDB~', $Of)?", true":""),');
</script>
';
            }
            $this->databasesPrint($Td);
            if (DB==""||!$Td) {
                echo"<p class='links'>".(support("sql")?"<a href='".h(ME)."sql='".bold(isset($_GET["sql"])&&!isset($_GET["import"])).">".lang(60)."</a>\n<a href='".h(ME)."import='".bold(isset($_GET["import"])).">".lang(68)."</a>\n":"")."";
                if (support("dump")) {
                    echo"<a href='".h(ME)."dump=".urlencode(isset($_GET["table"])?$_GET["table"]:$_GET["select"])."' id='dump'".bold(isset($_GET["dump"])).">".lang(69)."</a>\n";
                }
            }
            if ($_GET["ns"]!==""&&!$Td&&DB!="") {
                echo'<a href="'.h(ME).'create="'.bold($_GET["create"]==="").">".lang(70)."</a>\n";
                if (!$S) {
                    echo"<p class='message'>".lang(9)."\n";
                } else {
                    $this->tablesPrint($S);
                }
            }
        }
    }
    public function databasesPrint($Td)
    {
        global$b,$f;
        $i=$this->databases();
        if ($i&&!in_array(DB, $i)) {
            array_unshift($i, DB);
        }
        echo'<form action="">
<p id="dbs">
';
        hidden_fields_get();
        $vb=script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");
        echo"<span title='".lang(71)."'>".lang(72)."</span>: ".($i?"<select name='db'>".optionlist(array(""=>"")+$i, DB)."</select>$vb":"<input name='db' value='".h(DB)."' autocapitalize='off'>\n"),"<input type='submit' value='".lang(20)."'".($i?" class='hidden'":"").">\n";
        if ($Td!="db"&&DB!=""&&$f->select_db(DB)) {
        }
        foreach (array("import","sql","schema","dump","privileges")as$X) {
            if (isset($_GET[$X])) {
                echo"<input type='hidden' name='$X' value=''>";
                break;
            }
        }
        echo"</p></form>\n";
    }
    public function tablesPrint($S)
    {
        echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");
        foreach ($S
as$Q=>$eg) {
            $E=$this->tableName($eg);
            if ($E!="") {
                echo'<li><a href="'.h(ME).'select='.urlencode($Q).'"'.bold($_GET["select"]==$Q||$_GET["edit"]==$Q, "select").">".lang(73)."</a> ",(support("table")||support("indexes")?'<a href="'.h(ME).'table='.urlencode($Q).'"'.bold(in_array($Q, array($_GET["table"],$_GET["create"],$_GET["indexes"],$_GET["foreign"],$_GET["trigger"])), (is_view($eg)?"view":"structure"))." title='".lang(38)."'>$E</a>":"<span>$E</span>")."\n";
            }
        }
        echo"</ul>\n";
    }
}$b=(function_exists('adminer_object')?adminer_object():new
Adminer); if ($b->operators===null) {
    $b->operators=$se;
}function page_header($Fg, $l="", $Ia=array(), $Gg="")
{
    global$ca,$ga,$b,$Jb,$y;
    page_headers();
    if (is_ajax()&&$l) {
        page_messages($l);
        exit;
    }
    $Hg=$Fg.($Gg!=""?": $Gg":"");
    $Ig=strip_tags($Hg.(SERVER!=""&&SERVER!="localhost"?h(" - ".SERVER):"")." - ".$b->name());
    echo'<!DOCTYPE html>
<html lang="',$ca,'" dir="',lang(74),'">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>',$Ig,'</title>
<link rel="stylesheet" type="text/css" href="',h(preg_replace("~\\?.*~", "", ME)."?file=default.css&version=4.7.6"),'">
',script_src(preg_replace("~\\?.*~", "", ME)."?file=functions.js&version=4.7.6");
    if ($b->head()) {
        echo'<link rel="shortcut icon" type="image/x-icon" href="',h(preg_replace("~\\?.*~", "", ME)."?file=favicon.ico&version=4.7.6"),'">
<link rel="apple-touch-icon" href="',h(preg_replace("~\\?.*~", "", ME)."?file=favicon.ico&version=4.7.6"),'">
';
        foreach ($b->css()as$pb) {
            echo'<link rel="stylesheet" type="text/css" href="',h($pb),'">
';
        }
    }
    echo'
<body class="',lang(74),' nojs">
';
    $tc=get_temp_dir()."/adminer.version";
    if (!$_COOKIE["adminer_version"]&&function_exists('openssl_verify')&&file_exists($tc)&&filemtime($tc)+86400>time()) {
        $qh=unserialize(file_get_contents($tc));
        $if="-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
";
        if (openssl_verify($qh["version"], base64_decode($qh["signature"]), $if)==1) {
            $_COOKIE["adminer_version"]=$qh["version"];
        }
    }
    echo'<script',nonce(),'>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick',(isset($_COOKIE["adminer_version"])?"":", onload: partial(verifyVersion, '$ga', '".js_escape(ME)."', '".get_token()."')"); ?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo
js_escape(lang(75)),'\';
var thousandsSeparator = \'',js_escape(lang(5)),'\';
</script>

<div id="help" class="jush-',$y,' jsonly hidden"></div>
',script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),'
<div id="content">
';
    if ($Ia!==null) {
        $A=substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1);
        echo'<p id="breadcrumb"><a href="'.h($A?$A:".").'">'.$Jb[DRIVER].'</a> &raquo; ';
        $A=substr(preg_replace('~\b(db|ns)=[^&]*&~', '', ME), 0, -1);
        $O=$b->serverName(SERVER);
        $O=($O!=""?$O:lang(30));
        if ($Ia===false) {
            echo"$O\n";
        } else {
            echo"<a href='".($A?h($A):".")."' accesskey='1' title='Alt+Shift+1'>$O</a> &raquo; ";
            if ($_GET["ns"]!=""||(DB!=""&&is_array($Ia))) {
                echo'<a href="'.h($A."&db=".urlencode(DB).(support("scheme")?"&ns=":"")).'">'.h(DB).'</a> &raquo; ';
            }
            if (is_array($Ia)) {
                if ($_GET["ns"]!="") {
                    echo'<a href="'.h(substr(ME, 0, -1)).'">'.h($_GET["ns"]).'</a> &raquo; ';
                }
                foreach ($Ia
as$z=>$X) {
                    $Cb=(is_array($X)?$X[1]:h($X));
                    if ($Cb!="") {
                        echo"<a href='".h(ME."$z=").urlencode(is_array($X)?$X[0]:$X)."'>$Cb</a> &raquo; ";
                    }
                }
            }
            echo"$Fg\n";
        }
    }
    echo"<h2>$Hg</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";
    restart_session();
    page_messages($l);
    $i=&get_session("dbs");
    if (DB!=""&&$i&&!in_array(DB, $i, true)) {
        $i=null;
    }
    stop_session();
    define("PAGE_HEADER", 1);
}function page_headers()
{
    global$b;
    header("Content-Type: text/html; charset=utf-8");
    header("Cache-Control: no-cache");
    header("X-Frame-Options: deny");
    header("X-XSS-Protection: 0");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: origin-when-cross-origin");
    foreach ($b->csp()as$ob) {
        $Oc=array();
        foreach ($ob
as$z=>$X) {
            $Oc[]="$z $X";
        }
        header("Content-Security-Policy: ".implode("; ", $Oc));
    }
    $b->headers();
}function csp()
{
    return
array(array("script-src"=>"'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'","connect-src"=>"'self'","frame-src"=>"https://www.adminer.org","object-src"=>"'none'","base-uri"=>"'none'","form-action"=>"'self'",),);
}function get_nonce()
{
    static$ce;
    if (!$ce) {
        $ce=base64_encode(rand_string());
    }
    return$ce;
}function page_messages($l)
{
    $fh=preg_replace('~^[^?]*~', '', $_SERVER["REQUEST_URI"]);
    $Rd=$_SESSION["messages"][$fh];
    if ($Rd) {
        echo"<div class='message'>".implode("</div>\n<div class='message'>", $Rd)."</div>".script("messagesPrint();");
        unset($_SESSION["messages"][$fh]);
    }
    if ($l) {
        echo"<div class='error'>$l</div>\n";
    }
}function page_footer($Td="")
{
    global$b,$T;
    echo'</div>

';
    switch_lang();
    if ($Td!="auth") {
        echo'<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="',lang(76),'" id="logout">
<input type="hidden" name="token" value="',$T,'">
</p>
</form>
';
    }
    echo'<div id="menu">
';
    $b->navigation($Td);
    echo'</div>
',script("setupSubmitHighlight(document);");
}function int32($Wd)
{
    while ($Wd>=2147483648) {
        $Wd-=4294967296;
    }
    while ($Wd<=-2147483649) {
        $Wd+=4294967296;
    }
    return(int)$Wd;
}function long2str($W, $uh)
{
    $Ef='';
    foreach ($W
as$X) {
        $Ef.=pack('V', $X);
    }
    if ($uh) {
        return
substr($Ef, 0, end($W));
    }
    return$Ef;
}function str2long($Ef, $uh)
{
    $W=array_values(unpack('V*', str_pad($Ef, 4*ceil(strlen($Ef)/4), "\0")));
    if ($uh) {
        $W[]=strlen($Ef);
    }
    return$W;
}function xxtea_mx($Ah, $_h, $mg, $ld)
{
    return
int32((($Ah>>5&0x7FFFFFF)^$_h<<2)+(($_h>>3&0x1FFFFFFF)^$Ah<<4))^int32(($mg^$_h)+($ld^$Ah));
}function encrypt_string($gg, $z)
{
    if ($gg=="") {
        return"";
    }
    $z=array_values(unpack("V*", pack("H*", md5($z))));
    $W=str2long($gg, true);
    $Wd=count($W)-1;
    $Ah=$W[$Wd];
    $_h=$W[0];
    $H=floor(6+52/($Wd+1));
    $mg=0;
    while ($H-->0) {
        $mg=int32($mg+0x9E3779B9);
        $Pb=$mg>>2&3;
        for ($Ge=0;$Ge<$Wd;$Ge++) {
            $_h=$W[$Ge+1];
            $Vd=xxtea_mx($Ah, $_h, $mg, $z[$Ge&3^$Pb]);
            $Ah=int32($W[$Ge]+$Vd);
            $W[$Ge]=$Ah;
        }
        $_h=$W[0];
        $Vd=xxtea_mx($Ah, $_h, $mg, $z[$Ge&3^$Pb]);
        $Ah=int32($W[$Wd]+$Vd);
        $W[$Wd]=$Ah;
    }
    return
long2str($W, false);
}function decrypt_string($gg, $z)
{
    if ($gg=="") {
        return"";
    }
    if (!$z) {
        return
false;
    }
    $z=array_values(unpack("V*", pack("H*", md5($z))));
    $W=str2long($gg, false);
    $Wd=count($W)-1;
    $Ah=$W[$Wd];
    $_h=$W[0];
    $H=floor(6+52/($Wd+1));
    $mg=int32($H*0x9E3779B9);
    while ($mg) {
        $Pb=$mg>>2&3;
        for ($Ge=$Wd;$Ge>0;$Ge--) {
            $Ah=$W[$Ge-1];
            $Vd=xxtea_mx($Ah, $_h, $mg, $z[$Ge&3^$Pb]);
            $_h=int32($W[$Ge]-$Vd);
            $W[$Ge]=$_h;
        }
        $Ah=$W[$Wd];
        $Vd=xxtea_mx($Ah, $_h, $mg, $z[$Ge&3^$Pb]);
        $_h=int32($W[0]-$Vd);
        $W[0]=$_h;
        $mg=int32($mg-0x9E3779B9);
    }
    return
long2str($W, true);
}$f='';$Nc=$_SESSION["token"]; if (!$Nc) {
    $_SESSION["token"]=rand(1, 1e6);
}$T=get_token();$Se=array(); if ($_COOKIE["adminer_permanent"]) {
    foreach (explode(" ", $_COOKIE["adminer_permanent"])as$X) {
        list($z)=explode(":", $X);
        $Se[$z]=$X;
    }
}function add_invalid_login()
{
    global$b;
    $q=file_open_lock(get_temp_dir()."/adminer.invalid");
    if (!$q) {
        return;
    }
    $fd=unserialize(stream_get_contents($q));
    $Cg=time();
    if ($fd) {
        foreach ($fd
as$gd=>$X) {
            if ($X[0]<$Cg) {
                unset($fd[$gd]);
            }
        }
    }
    $ed=&$fd[$b->bruteForceKey()];
    if (!$ed) {
        $ed=array($Cg+30*60,0);
    }
    $ed[1]++;
    file_write_unlock($q, serialize($fd));
}function check_invalid_login()
{
    global$b;
    $fd=unserialize(@file_get_contents(get_temp_dir()."/adminer.invalid"));
    $ed=$fd[$b->bruteForceKey()];
    $be=($ed[1]>29?$ed[0]-time():0);
    if ($be>0) {
        auth_error(lang(77, ceil($be/60)));
    }
}$ya=$_POST["auth"]; if ($ya) {
    session_regenerate_id();
    $ph=$ya["driver"];
    $O=$ya["server"];
    $V=$ya["username"];
    $G=(string)$ya["password"];
    $j=$ya["db"];
    set_password($ph, $O, $V, $G);
    $_SESSION["db"][$ph][$O][$V][$j]=true;
    if ($ya["permanent"]) {
        $z=base64_encode($ph)."-".base64_encode($O)."-".base64_encode($V)."-".base64_encode($j);
        $df=$b->permanentLogin(true);
        $Se[$z]="$z:".base64_encode($df?encrypt_string($G, $df):"");
        cookie("adminer_permanent", implode(" ", $Se));
    }
    if (count($_POST)==1||DRIVER!=$ph||SERVER!=$O||$_GET["username"]!==$V||DB!=$j) {
        redirect(auth_url($ph, $O, $V, $j));
    }
} elseif ($_POST["logout"]) {
    if ($Nc&&!verify_token()) {
        page_header(lang(76), lang(78));
        page_footer("db");
        exit;
    } else {
        foreach (array("pwds","db","dbs","queries")as$z) {
            set_session($z, null);
        }
        unset_permanent();
        redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1), lang(79).' '.lang(80));
    }
} elseif ($Se&&!$_SESSION["pwds"]) {
    session_regenerate_id();
    $df=$b->permanentLogin();
    foreach ($Se
as$z=>$X) {
        list(, $Ra)=explode(":", $X);
        list($ph, $O, $V, $j)=array_map('base64_decode', explode("-", $z));
        set_password($ph, $O, $V, decrypt_string(base64_decode($Ra), $df));
        $_SESSION["db"][$ph][$O][$V][$j]=true;
    }
}function unset_permanent()
{
    global$Se;
    foreach ($Se
as$z=>$X) {
        list($ph, $O, $V, $j)=array_map('base64_decode', explode("-", $z));
        if ($ph==DRIVER&&$O==SERVER&&$V==$_GET["username"]&&$j==DB) {
            unset($Se[$z]);
        }
    }
    cookie("adminer_permanent", implode(" ", $Se));
}function auth_error($l)
{
    global$b,$Nc;
    $Qf=session_name();
    if (isset($_GET["username"])) {
        header("HTTP/1.1 403 Forbidden");
        if (($_COOKIE[$Qf]||$_GET[$Qf])&&!$Nc) {
            $l=lang(81);
        } else {
            restart_session();
            add_invalid_login();
            $G=get_password();
            if ($G!==null) {
                if ($G===false) {
                    $l.='<br>'.lang(82, target_blank(), '<code>permanentLogin()</code>');
                }
                set_password(DRIVER, SERVER, $_GET["username"], null);
            }
            unset_permanent();
        }
    }
    if (!$_COOKIE[$Qf]&&$_GET[$Qf]&&ini_bool("session.use_only_cookies")) {
        $l=lang(83);
    }
    $Je=session_get_cookie_params();
    cookie("adminer_key", ($_COOKIE["adminer_key"]?$_COOKIE["adminer_key"]:rand_string()), $Je["lifetime"]);
    page_header(lang(34), $l, null);
    echo"<form action='' method='post'>\n","<div>";
    if (hidden_fields($_POST, array("auth"))) {
        echo"<p class='message'>".lang(84)."\n";
    }
    echo"</div>\n";
    $b->loginForm();
    echo"</form>\n";
    page_footer("auth");
    exit;
} if (isset($_GET["username"])&&!class_exists("Min_DB")) {
    unset($_SESSION["pwds"][DRIVER]);
    unset_permanent();
    page_header(lang(85), lang(86, implode(", ", $Ye)), false);
    page_footer("auth");
    exit;
}stop_session(true); if (isset($_GET["username"])&&is_string(get_password())) {
    list($Sc, $Ue)=explode(":", SERVER, 2);
    if (is_numeric($Ue)&&($Ue<1024||$Ue>65535)) {
        auth_error(lang(87));
    }
    check_invalid_login();
    $f=connect();
    $k=new
Min_Driver($f);
}$Cd=null; if (!is_object($f)||($Cd=$b->login($_GET["username"], get_password()))!==true) {
    $l=(is_string($f)?h($f):(is_string($Cd)?$Cd:lang(88)));
    auth_error($l.(preg_match('~^ | $~', get_password())?'<br>'.lang(89):''));
} if ($ya&&$_POST["token"]) {
    $_POST["token"]=$T;
}$l=''; if ($_POST) {
    if (!verify_token()) {
        $Zc="max_input_vars";
        $Md=ini_get($Zc);
        if (extension_loaded("suhosin")) {
            foreach (array("suhosin.request.max_vars","suhosin.post.max_vars")as$z) {
                $X=ini_get($z);
                if ($X&&(!$Md||$X<$Md)) {
                    $Zc=$z;
                    $Md=$X;
                }
            }
        }
        $l=(!$_POST["token"]&&$Md?lang(90, "'$Zc'"):lang(78).' '.lang(91));
    }
} elseif ($_SERVER["REQUEST_METHOD"]=="POST") {
    $l=lang(92, "'post_max_size'");
    if (isset($_GET["sql"])) {
        $l.=' '.lang(93);
    }
}function select($J, $g=null, $ze=array(), $_=0)
{
    global$y;
    $Bd=array();
    $x=array();
    $d=array();
    $Ga=array();
    $Wg=array();
    $K=array();
    odd('');
    for ($t=0;(!$_||$t<$_)&&($L=$J->fetch_row());$t++) {
        if (!$t) {
            echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n","<thead><tr>";
            for ($kd=0;$kd<count($L);$kd++) {
                $m=$J->fetch_field();
                $E=$m->name;
                $ye=$m->orgtable;
                $xe=$m->orgname;
                $K[$m->table]=$ye;
                if ($ze&&$y=="sql") {
                    $Bd[$kd]=($E=="table"?"table=":($E=="possible_keys"?"indexes=":null));
                } elseif ($ye!="") {
                    if (!isset($x[$ye])) {
                        $x[$ye]=array();
                        foreach (indexes($ye, $g)as$w) {
                            if ($w["type"]=="PRIMARY") {
                                $x[$ye]=array_flip($w["columns"]);
                                break;
                            }
                        }
                        $d[$ye]=$x[$ye];
                    }
                    if (isset($d[$ye][$xe])) {
                        unset($d[$ye][$xe]);
                        $x[$ye][$xe]=$kd;
                        $Bd[$kd]=$ye;
                    }
                }
                if ($m->charsetnr==63) {
                    $Ga[$kd]=true;
                }
                $Wg[$kd]=$m->type;
                echo"<th".($ye!=""||$m->name!=$xe?" title='".h(($ye!=""?"$ye.":"").$xe)."'":"").">".h($E).($ze?doc_link(array('sql'=>"explain-output.html#explain_".strtolower($E),'mariadb'=>"explain/#the-columns-in-explain-select",)):"");
            }
            echo"</thead>\n";
        }
        echo"<tr".odd().">";
        foreach ($L
as$z=>$X) {
            if ($X===null) {
                $X="<i>NULL</i>";
            } elseif ($Ga[$z]&&!is_utf8($X)) {
                $X="<i>".lang(43, strlen($X))."</i>";
            } else {
                $X=h($X);
                if ($Wg[$z]==254) {
                    $X="<code>$X</code>";
                }
            }
            if (isset($Bd[$z])&&!$d[$Bd[$z]]) {
                if ($ze&&$y=="sql") {
                    $Q=$L[array_search("table=", $Bd)];
                    $A=$Bd[$z].urlencode($ze[$Q]!=""?$ze[$Q]:$Q);
                } else {
                    $A="edit=".urlencode($Bd[$z]);
                    foreach ($x[$Bd[$z]]as$Va=>$kd) {
                        $A.="&where".urlencode("[".bracket_escape($Va)."]")."=".urlencode($L[$kd]);
                    }
                }
                $X="<a href='".h(ME.$A)."'>$X</a>";
            }
            echo"<td>$X";
        }
    }
    echo($t?"</table>\n</div>":"<p class='message'>".lang(12))."\n";
    return$K;
}function referencable_primary($Lf)
{
    $K=array();
    foreach (table_status('', true)as$qg=>$Q) {
        if ($qg!=$Lf&&fk_support($Q)) {
            foreach (fields($qg)as$m) {
                if ($m["primary"]) {
                    if ($K[$qg]) {
                        unset($K[$qg]);
                        break;
                    }
                    $K[$qg]=$m;
                }
            }
        }
    }
    return$K;
}function adminer_settings()
{
    parse_str($_COOKIE["adminer_settings"], $Sf);
    return$Sf;
}function adminer_setting($z)
{
    $Sf=adminer_settings();
    return$Sf[$z];
}function set_adminer_settings($Sf)
{
    return
cookie("adminer_settings", http_build_query($Sf+adminer_settings()));
}function textarea($E, $Y, $M=10, $Za=80)
{
    global$y;
    echo"<textarea name='$E' rows='$M' cols='$Za' class='sqlarea jush-$y' spellcheck='false' wrap='off'>";
    if (is_array($Y)) {
        foreach ($Y
as$X) {
            echo
h($X[0])."\n\n\n";
        }
    } else {
        echo
h($Y);
    }
    echo"</textarea>";
}function edit_type($z, $m, $Ya, $p=array(), $nc=array())
{
    global$ig,$Wg,$dh,$oe;
    $U=$m["type"];
    echo'<td><select name="',h($z),'[type]" class="type" aria-labelledby="label-type">';
    if ($U&&!isset($Wg[$U])&&!isset($p[$U])&&!in_array($U, $nc)) {
        $nc[]=$U;
    }
    if ($p) {
        $ig[lang(94)]=$p;
    }
    echo
optionlist(array_merge($nc, $ig), $U),'</select><td><input name="',h($z),'[length]" value="',h($m["length"]),'" size="3"',(!$m["length"]&&preg_match('~var(char|binary)$~', $U)?" class='required'":"");
    echo' aria-labelledby="label-length"><td class="options">',"<select name='".h($z)."[collation]'".(preg_match('~(char|text|enum|set)$~', $U)?"":" class='hidden'").'><option value="">('.lang(95).')'.optionlist($Ya, $m["collation"]).'</select>',($dh?"<select name='".h($z)."[unsigned]'".(!$U||preg_match(number_type(), $U)?"":" class='hidden'").'><option>'.optionlist($dh, $m["unsigned"]).'</select>':''),(isset($m['on_update'])?"<select name='".h($z)."[on_update]'".(preg_match('~timestamp|datetime~', $U)?"":" class='hidden'").'>'.optionlist(array(""=>"(".lang(96).")","CURRENT_TIMESTAMP"), (preg_match('~^CURRENT_TIMESTAMP~i', $m["on_update"])?"CURRENT_TIMESTAMP":$m["on_update"])).'</select>':''),($p?"<select name='".h($z)."[on_delete]'".(preg_match("~`~", $U)?"":" class='hidden'")."><option value=''>(".lang(97).")".optionlist(explode("|", $oe), $m["on_delete"])."</select> ":" ");
}function process_length($zd)
{
    global$ac;
    return(preg_match("~^\\s*\\(?\\s*$ac(?:\\s*,\\s*$ac)*+\\s*\\)?\\s*\$~", $zd)&&preg_match_all("~$ac~", $zd, $Gd)?"(".implode(",", $Gd[0]).")":preg_replace('~^[0-9].*~', '(\0)', preg_replace('~[^-0-9,+()[\]]~', '', $zd)));
}function process_type($m, $Wa="COLLATE")
{
    global$dh;
    return" $m[type]".process_length($m["length"]).(preg_match(number_type(), $m["type"])&&in_array($m["unsigned"], $dh)?" $m[unsigned]":"").(preg_match('~char|text|enum|set~', $m["type"])&&$m["collation"]?" $Wa ".q($m["collation"]):"");
}function process_field($m, $Ug)
{
    return
array(idf_escape(trim($m["field"])),process_type($Ug),($m["null"]?" NULL":" NOT NULL"),default_value($m),(preg_match('~timestamp|datetime~', $m["type"])&&$m["on_update"]?" ON UPDATE $m[on_update]":""),(support("comment")&&$m["comment"]!=""?" COMMENT ".q($m["comment"]):""),($m["auto_increment"]?auto_increment():null),);
}function default_value($m)
{
    $zb=$m["default"];
    return($zb===null?"":" DEFAULT ".(preg_match('~char|binary|text|enum|set~', $m["type"])||preg_match('~^(?![a-z])~i', $zb)?q($zb):$zb));
}function type_class($U)
{
    foreach (array('char'=>'text','date'=>'time|year','binary'=>'blob','enum'=>'set',)as$z=>$X) {
        if (preg_match("~$z|$X~", $U)) {
            return" class='$z'";
        }
    }
}function edit_fields($n, $Ya, $U="TABLE", $p=array())
{
    global$ad;
    $n=array_values($n);
    $_b=(($_POST?$_POST["defaults"]:adminer_setting("defaults"))?"":" class='hidden'");
    $db=(($_POST?$_POST["comments"]:adminer_setting("comments"))?"":" class='hidden'");
    echo'<thead><tr>
';
    if ($U=="PROCEDURE") {
        echo'<td>';
    }
    echo'<th id="label-name">',($U=="TABLE"?lang(98):lang(99)),'<td id="label-type">',lang(45),'<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">',lang(100),'<td>',lang(101);
    if ($U=="TABLE") {
        echo'<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="',lang(47),'">AI</acronym>',doc_link(array('sql'=>"example-auto-increment.html",'mariadb'=>"auto_increment/",)),'<td id="label-default"',$_b,'>',lang(48),(support("comment")?"<td id='label-comment'$db>".lang(46):"");
    }
    echo'<td>',"<input type='image' class='icon' name='add[".(support("move_col")?0:count($n))."]' src='".h(preg_replace("~\\?.*~", "", ME)."?file=plus.gif&version=4.7.6")."' alt='+' title='".lang(102)."'>".script("row_count = ".count($n).";"),'</thead>
<tbody>
',script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");
    foreach ($n
as$t=>$m) {
        $t++;
        $_e=$m[($_POST?"orig":"field")];
        $Gb=(isset($_POST["add"][$t-1])||(isset($m["field"])&&!$_POST["drop_col"][$t]))&&(support("drop_col")||$_e=="");
        echo'<tr',($Gb?"":" style='display: none;'"),'>
',($U=="PROCEDURE"?"<td>".html_select("fields[$t][inout]", explode("|", $ad), $m["inout"]):""),'<th>';
        if ($Gb) {
            echo'<input name="fields[',$t,'][field]" value="',h($m["field"]),'" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">';
        }
        echo'<input type="hidden" name="fields[',$t,'][orig]" value="',h($_e),'">';
        edit_type("fields[$t]", $m, $Ya, $p);
        if ($U=="TABLE") {
            echo'<td>',checkbox("fields[$t][null]", 1, $m["null"], "", "", "block", "label-null"),'<td><label class="block"><input type="radio" name="auto_increment_col" value="',$t,'"';
            if ($m["auto_increment"]) {
                echo' checked';
            }
            echo' aria-labelledby="label-ai"></label><td',$_b,'>',checkbox("fields[$t][has_default]", 1, $m["has_default"], "", "", "", "label-default"),'<input name="fields[',$t,'][default]" value="',h($m["default"]),'" aria-labelledby="label-default">',(support("comment")?"<td$db><input name='fields[$t][comment]' value='".h($m["comment"])."' data-maxlength='".(min_version(5.5)?1024:255)."' aria-labelledby='label-comment'>":"");
        }
        echo"<td>",(support("move_col")?"<input type='image' class='icon' name='add[$t]' src='".h(preg_replace("~\\?.*~", "", ME)."?file=plus.gif&version=4.7.6")."' alt='+' title='".lang(102)."'> "."<input type='image' class='icon' name='up[$t]' src='".h(preg_replace("~\\?.*~", "", ME)."?file=up.gif&version=4.7.6")."' alt='↑' title='".lang(103)."'> "."<input type='image' class='icon' name='down[$t]' src='".h(preg_replace("~\\?.*~", "", ME)."?file=down.gif&version=4.7.6")."' alt='↓' title='".lang(104)."'> ":""),($_e==""||support("drop_col")?"<input type='image' class='icon' name='drop_col[$t]' src='".h(preg_replace("~\\?.*~", "", ME)."?file=cross.gif&version=4.7.6")."' alt='x' title='".lang(105)."'>":"");
    }
}function process_fields(&$n)
{
    $he=0;
    if ($_POST["up"]) {
        $td=0;
        foreach ($n
as$z=>$m) {
            if (key($_POST["up"])==$z) {
                unset($n[$z]);
                array_splice($n, $td, 0, array($m));
                break;
            }
            if (isset($m["field"])) {
                $td=$he;
            }
            $he++;
        }
    } elseif ($_POST["down"]) {
        $Ac=false;
        foreach ($n
as$z=>$m) {
            if (isset($m["field"])&&$Ac) {
                unset($n[key($_POST["down"])]);
                array_splice($n, $he, 0, array($Ac));
                break;
            }
            if (key($_POST["down"])==$z) {
                $Ac=$m;
            }
            $he++;
        }
    } elseif ($_POST["add"]) {
        $n=array_values($n);
        array_splice($n, key($_POST["add"]), 0, array(array()));
    } elseif (!$_POST["drop_col"]) {
        return
false;
    }
    return
true;
}function normalize_enum($C)
{
    return"'".str_replace("'", "''", addcslashes(stripcslashes(str_replace($C[0][0].$C[0][0], $C[0][0], substr($C[0], 1, -1))), '\\'))."'";
}function grant($Ec, $ff, $d, $ne)
{
    if (!$ff) {
        return
true;
    }
    if ($ff==array("ALL PRIVILEGES","GRANT OPTION")) {
        return($Ec=="GRANT"?queries("$Ec ALL PRIVILEGES$ne WITH GRANT OPTION"):queries("$Ec ALL PRIVILEGES$ne")&&queries("$Ec GRANT OPTION$ne"));
    }
    return
queries("$Ec ".preg_replace('~(GRANT OPTION)\([^)]*\)~', '\1', implode("$d, ", $ff).$d).$ne);
}function drop_create($Kb, $h, $Lb, $_g, $Mb, $B, $Qd, $Od, $Pd, $ke, $Zd)
{
    if ($_POST["drop"]) {
        query_redirect($Kb, $B, $Qd);
    } elseif ($ke=="") {
        query_redirect($h, $B, $Pd);
    } elseif ($ke!=$Zd) {
        $mb=queries($h);
        queries_redirect($B, $Od, $mb&&queries($Kb));
        if ($mb) {
            queries($Lb);
        }
    } else {
        queries_redirect($B, $Od, queries($_g)&&queries($Mb)&&queries($Kb)&&queries($h));
    }
}function create_trigger($ne, $L)
{
    global$y;
    $Eg=" $L[Timing] $L[Event]".($L["Event"]=="UPDATE OF"?" ".idf_escape($L["Of"]):"");
    return"CREATE TRIGGER ".idf_escape($L["Trigger"]).($y=="mssql"?$ne.$Eg:$Eg.$ne).rtrim(" $L[Type]\n$L[Statement]", ";").";";
}function create_routine($Bf, $L)
{
    global$ad,$y;
    $P=array();
    $n=(array)$L["fields"];
    ksort($n);
    foreach ($n
as$m) {
        if ($m["field"]!="") {
            $P[]=(preg_match("~^($ad)\$~", $m["inout"])?"$m[inout] ":"").idf_escape($m["field"]).process_type($m, "CHARACTER SET");
        }
    }
    $Ab=rtrim("\n$L[definition]", ";");
    return"CREATE $Bf ".idf_escape(trim($L["name"]))." (".implode(", ", $P).")".(isset($_GET["function"])?" RETURNS".process_type($L["returns"], "CHARACTER SET"):"").($L["language"]?" LANGUAGE $L[language]":"").($y=="pgsql"?" AS ".q($Ab):"$Ab;");
}function remove_definer($I)
{
    return
preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~', '`@`(%|\1)', logged_user()).'`~', '\1', $I);
}function format_foreign_key($o)
{
    global$oe;
    $j=$o["db"];
    $de=$o["ns"];
    return" FOREIGN KEY (".implode(", ", array_map('idf_escape', $o["source"])).") REFERENCES ".($j!=""&&$j!=$_GET["db"]?idf_escape($j).".":"").($de!=""&&$de!=$_GET["ns"]?idf_escape($de).".":"").table($o["table"])." (".implode(", ", array_map('idf_escape', $o["target"])).")".(preg_match("~^($oe)\$~", $o["on_delete"])?" ON DELETE $o[on_delete]":"").(preg_match("~^($oe)\$~", $o["on_update"])?" ON UPDATE $o[on_update]":"");
}function tar_file($tc, $Jg)
{
    $K=pack("a100a8a8a8a12a12", $tc, 644, 0, 0, decoct($Jg->size), decoct(time()));
    $Qa=8*32;
    for ($t=0;$t<strlen($K);$t++) {
        $Qa+=ord($K[$t]);
    }
    $K.=sprintf("%06o", $Qa)."\0 ";
    echo$K,str_repeat("\0", 512-strlen($K));
    $Jg->send();
    echo
str_repeat("\0", 511-($Jg->size+511)%512);
}function ini_bytes($Zc)
{
    $X=ini_get($Zc);
    switch (strtolower(substr($X, -1))) {case'g':$X*=1024;
// no break
case'm':$X*=1024;
// no break
case'k':$X*=1024;}
    return$X;
}function doc_link($Qe, $Ag="<sup>?</sup>")
{
    global$y,$f;
    $Of=$f->server_info;
    $qh=preg_replace('~^(\d\.?\d).*~s', '\1', $Of);
    $hh=array('sql'=>"https://dev.mysql.com/doc/refman/$qh/en/",'sqlite'=>"https://www.sqlite.org/",'pgsql'=>"https://www.postgresql.org/docs/$qh/",'mssql'=>"https://msdn.microsoft.com/library/",'oracle'=>"https://www.oracle.com/pls/topic/lookup?ctx=db".preg_replace('~^.* (\d+)\.(\d+)\.\d+\.\d+\.\d+.*~s', '\1\2', $Of)."&id=",);
    if (preg_match('~MariaDB~', $Of)) {
        $hh['sql']="https://mariadb.com/kb/en/library/";
        $Qe['sql']=(isset($Qe['mariadb'])?$Qe['mariadb']:str_replace(".html", "/", $Qe['sql']));
    }
    return($Qe[$y]?"<a href='$hh[$y]$Qe[$y]'".target_blank().">$Ag</a>":"");
}function ob_gzencode($hg)
{
    return
gzencode($hg);
}function db_size($j)
{
    global$f;
    if (!$f->select_db($j)) {
        return"?";
    }
    $K=0;
    foreach (table_status()as$R) {
        $K+=$R["Data_length"]+$R["Index_length"];
    }
    return
format_number($K);
}function set_utf8mb4($h)
{
    global$f;
    static$P=false;
    if (!$P&&preg_match('~\butf8mb4~i', $h)) {
        $P=true;
        echo"SET NAMES ".charset($f).";\n\n";
    }
}function connect_error()
{
    global$b,$f,$T,$l,$Jb;
    if (DB!="") {
        header("HTTP/1.1 404 Not Found");
        page_header(lang(33).": ".h(DB), lang(106), true);
    } else {
        if ($_POST["db"]&&!$l) {
            queries_redirect(substr(ME, 0, -1), lang(107), drop_databases($_POST["db"]));
        }
        page_header(lang(108), $l, false);
        echo"<p class='links'>\n";
        foreach (array('database'=>lang(109),'privileges'=>lang(67),'processlist'=>lang(110),'variables'=>lang(111),'status'=>lang(112),)as$z=>$X) {
            if (support($z)) {
                echo"<a href='".h(ME)."$z='>$X</a>\n";
            }
        }
        echo"<p>".lang(113, $Jb[DRIVER], "<b>".h($f->server_info)."</b>", "<b>$f->extension</b>")."\n","<p>".lang(114, "<b>".h(logged_user())."</b>")."\n";
        $i=$b->databases();
        if ($i) {
            $Hf=support("scheme");
            $Ya=collations();
            echo"<form action='' method='post'>\n","<table cellspacing='0' class='checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),"<thead><tr>".(support("database")?"<td>":"")."<th>".lang(33)." - <a href='".h(ME)."refresh=1'>".lang(115)."</a>"."<td>".lang(116)."<td>".lang(117)."<td>".lang(118)." - <a href='".h(ME)."dbsize=1'>".lang(119)."</a>".script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');", "")."</thead>\n";
            $i=($_GET["dbsize"]?count_tables($i):array_flip($i));
            foreach ($i
as$j=>$S) {
                $Af=h(ME)."db=".urlencode($j);
                $u=h("Db-".$j);
                echo"<tr".odd().">".(support("database")?"<td>".checkbox("db[]", $j, in_array($j, (array)$_POST["db"]), "", "", "", $u):""),"<th><a href='$Af' id='$u'>".h($j)."</a>";
                $Xa=h(db_collation($j, $Ya));
                echo"<td>".(support("database")?"<a href='$Af".($Hf?"&amp;ns=":"")."&amp;database=' title='".lang(63)."'>$Xa</a>":$Xa),"<td align='right'><a href='$Af&amp;schema=' id='tables-".h($j)."' title='".lang(66)."'>".($_GET["dbsize"]?$S:"?")."</a>","<td align='right' id='size-".h($j)."'>".($_GET["dbsize"]?db_size($j):"?"),"\n";
            }
            echo"</table>\n",(support("database")?"<div class='footer'><div>\n"."<fieldset><legend>".lang(120)." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".lang(121)."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n":""),"<input type='hidden' name='token' value='$T'>\n","</form>\n",script("tableCheck();");
        }
    }
    page_footer("db");
} if (isset($_GET["status"])) {
    $_GET["variables"]=$_GET["status"];
} if (isset($_GET["import"])) {
    $_GET["sql"]=$_GET["import"];
} if (!(DB!=""?$f->select_db(DB):isset($_GET["sql"])||isset($_GET["dump"])||isset($_GET["database"])||isset($_GET["processlist"])||isset($_GET["privileges"])||isset($_GET["user"])||isset($_GET["variables"])||$_GET["script"]=="connect"||$_GET["script"]=="kill")) {
    if (DB!=""||$_GET["refresh"]) {
        restart_session();
        set_session("dbs", null);
    }
    connect_error();
    exit;
}$oe="RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT";class TmpFile
{
    public $handler;
    public $size;
    public function __construct()
    {
        $this->handler=tmpfile();
    }
    public function write($hb)
    {
        $this->size+=strlen($hb);
        fwrite($this->handler, $hb);
    }
    public function send()
    {
        fseek($this->handler, 0);
        fpassthru($this->handler);
        fclose($this->handler);
    }
}$ac="'(?:''|[^'\\\\]|\\\\.)*'";$ad="IN|OUT|INOUT"; if (isset($_GET["select"])&&($_POST["edit"]||$_POST["clone"])&&!$_POST["save"]) {
    $_GET["edit"]=$_GET["select"];
} if (isset($_GET["callf"])) {
    $_GET["call"]=$_GET["callf"];
} if (isset($_GET["function"])) {
    $_GET["procedure"]=$_GET["function"];
} if (isset($_GET["download"])) {
    $a=$_GET["download"];
    $n=fields($a);
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".friendly_url("$a-".implode("_", $_GET["where"])).".".friendly_url($_GET["field"]));
    $N=array(idf_escape($_GET["field"]));
    $J=$k->select($a, $N, array(where($_GET, $n)), $N);
    $L=($J?$J->fetch_row():array());
    echo$k->value($L[0], $n[$_GET["field"]]);
    exit;
} elseif (isset($_GET["table"])) {
    $a=$_GET["table"];
    $n=fields($a);
    if (!$n) {
        $l=error();
    }
    $R=table_status1($a, true);
    $E=$b->tableName($R);
    page_header(($n&&is_view($R)?$R['Engine']=='materialized view'?lang(122):lang(123):lang(124)).": ".($E!=""?$E:h($a)), $l);
    $b->selectLinks($R);
    $cb=$R["Comment"];
    if ($cb!="") {
        echo"<p class='nowrap'>".lang(46).": ".h($cb)."\n";
    }
    if ($n) {
        $b->tableStructurePrint($n);
    }
    if (!is_view($R)) {
        if (support("indexes")) {
            echo"<h3 id='indexes'>".lang(125)."</h3>\n";
            $x=indexes($a);
            if ($x) {
                $b->tableIndexesPrint($x);
            }
            echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($a).'">'.lang(126)."</a>\n";
        }
        if (fk_support($R)) {
            echo"<h3 id='foreign-keys'>".lang(94)."</h3>\n";
            $p=foreign_keys($a);
            if ($p) {
                echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(127)."<td>".lang(128)."<td>".lang(97)."<td>".lang(96)."<td></thead>\n";
                foreach ($p
as$E=>$o) {
                    echo"<tr title='".h($E)."'>","<th><i>".implode("</i>, <i>", array_map('h', $o["source"]))."</i>","<td><a href='".h($o["db"]!=""?preg_replace('~db=[^&]*~', "db=".urlencode($o["db"]), ME):($o["ns"]!=""?preg_replace('~ns=[^&]*~', "ns=".urlencode($o["ns"]), ME):ME))."table=".urlencode($o["table"])."'>".($o["db"]!=""?"<b>".h($o["db"])."</b>.":"").($o["ns"]!=""?"<b>".h($o["ns"])."</b>.":"").h($o["table"])."</a>","(<i>".implode("</i>, <i>", array_map('h', $o["target"]))."</i>)","<td>".h($o["on_delete"])."\n","<td>".h($o["on_update"])."\n",'<td><a href="'.h(ME.'foreign='.urlencode($a).'&name='.urlencode($E)).'">'.lang(129).'</a>';
                }
                echo"</table>\n";
            }
            echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($a).'">'.lang(130)."</a>\n";
        }
    }
    if (support(is_view($R)?"view_trigger":"trigger")) {
        echo"<h3 id='triggers'>".lang(131)."</h3>\n";
        $Tg=triggers($a);
        if ($Tg) {
            echo"<table cellspacing='0'>\n";
            foreach ($Tg
as$z=>$X) {
                echo"<tr valign='top'><td>".h($X[0])."<td>".h($X[1])."<th>".h($z)."<td><a href='".h(ME.'trigger='.urlencode($a).'&name='.urlencode($z))."'>".lang(129)."</a>\n";
            }
            echo"</table>\n";
        }
        echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($a).'">'.lang(132)."</a>\n";
    }
} elseif (isset($_GET["schema"])) {
    page_header(lang(66), "", array(), h(DB.($_GET["ns"]?".$_GET[ns]":"")));
    $rg=array();
    $sg=array();
    $ea=($_GET["schema"]?$_GET["schema"]:$_COOKIE["adminer_schema-".str_replace(".", "_", DB)]);
    preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~', $ea, $Gd, PREG_SET_ORDER);
    foreach ($Gd
as$t=>$C) {
        $rg[$C[1]]=array($C[2],$C[3]);
        $sg[]="\n\t'".js_escape($C[1])."': [ $C[2], $C[3] ]";
    }
    $Lg=0;
    $Da=-1;
    $Gf=array();
    $sf=array();
    $xd=array();
    foreach (table_status('', true)as$Q=>$R) {
        if (is_view($R)) {
            continue;
        }
        $Ve=0;
        $Gf[$Q]["fields"]=array();
        foreach (fields($Q)as$E=>$m) {
            $Ve+=1.25;
            $m["pos"]=$Ve;
            $Gf[$Q]["fields"][$E]=$m;
        }
        $Gf[$Q]["pos"]=($rg[$Q]?$rg[$Q]:array($Lg,0));
        foreach ($b->foreignKeys($Q)as$X) {
            if (!$X["db"]) {
                $vd=$Da;
                if ($rg[$Q][1]||$rg[$X["table"]][1]) {
                    $vd=min(floatval($rg[$Q][1]), floatval($rg[$X["table"]][1]))-1;
                } else {
                    $Da-=.1;
                }
                while ($xd[(string)$vd]) {
                    $vd-=.0001;
                }
                $Gf[$Q]["references"][$X["table"]][(string)$vd]=array($X["source"],$X["target"]);
                $sf[$X["table"]][$Q][(string)$vd]=$X["target"];
                $xd[(string)$vd]=true;
            }
        }
        $Lg=max($Lg, $Gf[$Q]["pos"][0]+2.5+$Ve);
    }
    echo'<div id="schema" style="height: ',$Lg,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(",", $sg)."\n",'};
var em = qs(\'#schema\').offsetHeight / ',$Lg,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';
    foreach ($Gf
as$E=>$Q) {
        echo"<div class='table' style='top: ".$Q["pos"][0]."em; left: ".$Q["pos"][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($E).'"><b>'.h($E)."</b></a>",script("qsl('div').onmousedown = schemaMousedown;");
        foreach ($Q["fields"]as$m) {
            $X='<span'.type_class($m["type"]).' title="'.h($m["full_type"].($m["null"]?" NULL":'')).'">'.h($m["field"]).'</span>';
            echo"<br>".($m["primary"]?"<i>$X</i>":$X);
        }
        foreach ((array)$Q["references"]as$yg=>$tf) {
            foreach ($tf
as$vd=>$pf) {
                $wd=$vd-$rg[$E][1];
                $t=0;
                foreach ($pf[0]as$Xf) {
                    echo"\n<div class='references' title='".h($yg)."' id='refs$vd-".($t++)."' style='left: $wd"."em; top: ".$Q["fields"][$Xf]["pos"]."em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: ".(-$wd)."em;'></div></div>";
                }
            }
        }
        foreach ((array)$sf[$E]as$yg=>$tf) {
            foreach ($tf
as$vd=>$d) {
                $wd=$vd-$rg[$E][1];
                $t=0;
                foreach ($d
as$xg) {
                    echo"\n<div class='references' title='".h($yg)."' id='refd$vd-".($t++)."' style='left: $wd"."em; top: ".$Q["fields"][$xg]["pos"]."em; height: 1.25em; background: url(".h(preg_replace("~\\?.*~", "", ME)."?file=arrow.gif) no-repeat right center;&version=4.7.6")."'><div style='height: .5em; border-bottom: 1px solid Gray; width: ".(-$wd)."em;'></div></div>";
                }
            }
        }
        echo"\n</div>\n";
    }
    foreach ($Gf
as$E=>$Q) {
        foreach ((array)$Q["references"]as$yg=>$tf) {
            foreach ($tf
as$vd=>$pf) {
                $Sd=$Lg;
                $Kd=-10;
                foreach ($pf[0]as$z=>$Xf) {
                    $We=$Q["pos"][0]+$Q["fields"][$Xf]["pos"];
                    $Xe=$Gf[$yg]["pos"][0]+$Gf[$yg]["fields"][$pf[1][$z]]["pos"];
                    $Sd=min($Sd, $We, $Xe);
                    $Kd=max($Kd, $We, $Xe);
                }
                echo"<div class='references' id='refl$vd' style='left: $vd"."em; top: $Sd"."em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: ".($Kd-$Sd)."em;'></div></div>\n";
            }
        }
    }
    echo'</div>
<p class="links"><a href="',h(ME."schema=".urlencode($ea)),'" id="schema-link">',lang(133),'</a>
';
} elseif (isset($_GET["dump"])) {
    $a=$_GET["dump"];
    if ($_POST&&!$l) {
        $kb="";
        foreach (array("output","format","db_style","routines","events","table_style","auto_increment","triggers","data_style")as$z) {
            $kb.="&$z=".urlencode($_POST[$z]);
        }
        cookie("adminer_export", substr($kb, 1));
        $S=array_flip((array)$_POST["tables"])+array_flip((array)$_POST["data"]);
        $lc=dump_headers((count($S)==1?key($S):DB), (DB==""||count($S)>1));
        $id=preg_match('~sql~', $_POST["format"]);
        if ($id) {
            echo"-- Adminer $ga ".$Jb[DRIVER]." dump\n\n";
            if ($y=="sql") {
                echo"SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
".($_POST["data_style"]?"SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
":"")."
";
                $f->query("SET time_zone = '+00:00';");
            }
        }
        $jg=$_POST["db_style"];
        $i=array(DB);
        if (DB=="") {
            $i=$_POST["databases"];
            if (is_string($i)) {
                $i=explode("\n", rtrim(str_replace("\r", "", $i), "\n"));
            }
        }
        foreach ((array)$i
as$j) {
            $b->dumpDatabase($j);
            if ($f->select_db($j)) {
                if ($id&&preg_match('~CREATE~', $jg)&&($h=$f->result("SHOW CREATE DATABASE ".idf_escape($j), 1))) {
                    set_utf8mb4($h);
                    if ($jg=="DROP+CREATE") {
                        echo"DROP DATABASE IF EXISTS ".idf_escape($j).";\n";
                    }
                    echo"$h;\n";
                }
                if ($id) {
                    if ($jg) {
                        echo
use_sql($j).";\n\n";
                    }
                    $Ee="";
                    if ($_POST["routines"]) {
                        foreach (array("FUNCTION","PROCEDURE")as$Bf) {
                            foreach (get_rows("SHOW $Bf STATUS WHERE Db = ".q($j), null, "-- ")as$L) {
                                $h=remove_definer($f->result("SHOW CREATE $Bf ".idf_escape($L["Name"]), 2));
                                set_utf8mb4($h);
                                $Ee.=($jg!='DROP+CREATE'?"DROP $Bf IF EXISTS ".idf_escape($L["Name"]).";;\n":"")."$h;;\n\n";
                            }
                        }
                    }
                    if ($_POST["events"]) {
                        foreach (get_rows("SHOW EVENTS", null, "-- ")as$L) {
                            $h=remove_definer($f->result("SHOW CREATE EVENT ".idf_escape($L["Name"]), 3));
                            set_utf8mb4($h);
                            $Ee.=($jg!='DROP+CREATE'?"DROP EVENT IF EXISTS ".idf_escape($L["Name"]).";;\n":"")."$h;;\n\n";
                        }
                    }
                    if ($Ee) {
                        echo"DELIMITER ;;\n\n$Ee"."DELIMITER ;\n\n";
                    }
                }
                if ($_POST["table_style"]||$_POST["data_style"]) {
                    $sh=array();
                    foreach (table_status('', true)as$E=>$R) {
                        $Q=(DB==""||in_array($E, (array)$_POST["tables"]));
                        $sb=(DB==""||in_array($E, (array)$_POST["data"]));
                        if ($Q||$sb) {
                            if ($lc=="tar") {
                                $Jg=new
TmpFile;
                                ob_start(array($Jg,'write'), 1e5);
                            }
                            $b->dumpTable($E, ($Q?$_POST["table_style"]:""), (is_view($R)?2:0));
                            if (is_view($R)) {
                                $sh[]=$E;
                            } elseif ($sb) {
                                $n=fields($E);
                                $b->dumpData($E, $_POST["data_style"], "SELECT *".convert_fields($n, $n)." FROM ".table($E));
                            }
                            if ($id&&$_POST["triggers"]&&$Q&&($Tg=trigger_sql($E))) {
                                echo"\nDELIMITER ;;\n$Tg\nDELIMITER ;\n";
                            }
                            if ($lc=="tar") {
                                ob_end_flush();
                                tar_file((DB!=""?"":"$j/")."$E.csv", $Jg);
                            } elseif ($id) {
                                echo"\n";
                            }
                        }
                    }
                    foreach ($sh
as$rh) {
                        $b->dumpTable($rh, $_POST["table_style"], 1);
                    }
                    if ($lc=="tar") {
                        echo
pack("x512");
                    }
                }
            }
        }
        if ($id) {
            echo"-- ".$f->result("SELECT NOW()")."\n";
        }
        exit;
    }
    page_header(lang(69), $l, ($_GET["export"]!=""?array("table"=>$_GET["export"]):array()), h(DB));
    echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
';
    $wb=array('','USE','DROP+CREATE','CREATE');
    $tg=array('','DROP+CREATE','CREATE');
    $tb=array('','TRUNCATE+INSERT','INSERT');
    if ($y=="sql") {
        $tb[]='INSERT+UPDATE';
    }
    parse_str($_COOKIE["adminer_export"], $L);
    if (!$L) {
        $L=array("output"=>"text","format"=>"sql","db_style"=>(DB!=""?"":"CREATE"),"table_style"=>"DROP+CREATE","data_style"=>"INSERT");
    }
    if (!isset($L["events"])) {
        $L["routines"]=$L["events"]=($_GET["dump"]=="");
        $L["triggers"]=$L["table_style"];
    }
    echo"<tr><th>".lang(134)."<td>".html_select("output", $b->dumpOutput(), $L["output"], 0)."\n";
    echo"<tr><th>".lang(135)."<td>".html_select("format", $b->dumpFormat(), $L["format"], 0)."\n";
    echo($y=="sqlite"?"":"<tr><th>".lang(33)."<td>".html_select('db_style', $wb, $L["db_style"]).(support("routine")?checkbox("routines", 1, $L["routines"], lang(136)):"").(support("event")?checkbox("events", 1, $L["events"], lang(137)):"")),"<tr><th>".lang(117)."<td>".html_select('table_style', $tg, $L["table_style"]).checkbox("auto_increment", 1, $L["auto_increment"], lang(47)).(support("trigger")?checkbox("triggers", 1, $L["triggers"], lang(131)):""),"<tr><th>".lang(138)."<td>".html_select('data_style', $tb, $L["data_style"]),'</table>
<p><input type="submit" value="',lang(69),'">
<input type="hidden" name="token" value="',$T,'">

<table cellspacing="0">
',script("qsl('table').onclick = dumpClick;");
    $af=array();
    if (DB!="") {
        $Oa=($a!=""?"":" checked");
        echo"<thead><tr>","<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$Oa>".lang(117)."</label>".script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);", ""),"<th style='text-align: right;'><label class='block'>".lang(138)."<input type='checkbox' id='check-data'$Oa></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);", ""),"</thead>\n";
        $sh="";
        $ug=tables_list();
        foreach ($ug
as$E=>$U) {
            $Ze=preg_replace('~_.*~', '', $E);
            $Oa=($a==""||$a==(substr($a, -1)=="%"?"$Ze%":$E));
            $cf="<tr><td>".checkbox("tables[]", $E, $Oa, $E, "", "block");
            if ($U!==null&&!preg_match('~table~i', $U)) {
                $sh.="$cf\n";
            } else {
                echo"$cf<td align='right'><label class='block'><span id='Rows-".h($E)."'></span>".checkbox("data[]", $E, $Oa)."</label>\n";
            }
            $af[$Ze]++;
        }
        echo$sh;
        if ($ug) {
            echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");
        }
    } else {
        echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($a==""?" checked":"").">".lang(33)."</label>",script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);", ""),"</thead>\n";
        $i=$b->databases();
        if ($i) {
            foreach ($i
as$j) {
                if (!information_schema($j)) {
                    $Ze=preg_replace('~_.*~', '', $j);
                    echo"<tr><td>".checkbox("databases[]", $j, $a==""||$a=="$Ze%", $j, "", "block")."\n";
                    $af[$Ze]++;
                }
            }
        } else {
            echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";
        }
    }
    echo'</table>
</form>
';
    $vc=true;
    foreach ($af
as$z=>$X) {
        if ($z!=""&&$X>1) {
            echo($vc?"<p>":" ")."<a href='".h(ME)."dump=".urlencode("$z%")."'>".h($z)."</a>";
            $vc=false;
        }
    }
} elseif (isset($_GET["privileges"])) {
    page_header(lang(67));
    echo'<p class="links"><a href="'.h(ME).'user=">'.lang(139)."</a>";
    $J=$f->query("SELECT User, Host FROM mysql.".(DB==""?"user":"db WHERE ".q(DB)." LIKE Db")." ORDER BY Host, User");
    $Ec=$J;
    if (!$J) {
        $J=$f->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");
    }
    echo"<form action=''><p>\n";
    hidden_fields_get();
    echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($Ec?"":"<input type='hidden' name='grant' value=''>\n"),"<table cellspacing='0'>\n","<thead><tr><th>".lang(31)."<th>".lang(30)."<th></thead>\n";
    while ($L=$J->fetch_assoc()) {
        echo'<tr'.odd().'><td>'.h($L["User"])."<td>".h($L["Host"]).'<td><a href="'.h(ME.'user='.urlencode($L["User"]).'&host='.urlencode($L["Host"])).'">'.lang(10)."</a>\n";
    }
    if (!$Ec||DB!="") {
        echo"<tr".odd()."><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".lang(10)."'>\n";
    }
    echo"</table>\n","</form>\n";
} elseif (isset($_GET["sql"])) {
    if (!$l&&$_POST["export"]) {
        dump_headers("sql");
        $b->dumpTable("", "");
        $b->dumpData("", "table", $_POST["query"]);
        exit;
    }
    restart_session();
    $Rc=&get_session("queries");
    $Qc=&$Rc[DB];
    if (!$l&&$_POST["clear"]) {
        $Qc=array();
        redirect(remove_from_uri("history"));
    }
    page_header((isset($_GET["import"])?lang(68):lang(60)), $l);
    if (!$l&&$_POST) {
        $q=false;
        if (!isset($_GET["import"])) {
            $I=$_POST["query"];
        } elseif ($_POST["webfile"]) {
            $ag=$b->importServerPath();
            $q=@fopen((file_exists($ag)?$ag:"compress.zlib://$ag.gz"), "rb");
            $I=($q?fread($q, 1e6):false);
        } else {
            $I=get_file("sql_file", true);
        }
        if (is_string($I)) {
            if (function_exists('memory_get_usage')) {
                @ini_set("memory_limit", max(ini_bytes("memory_limit"), 2*strlen($I)+memory_get_usage()+8e6));
            }
            if ($I!=""&&strlen($I)<1e6) {
                $H=$I.(preg_match("~;[ \t\r\n]*\$~", $I)?"":";");
                if (!$Qc||reset(end($Qc))!=$H) {
                    restart_session();
                    $Qc[]=array($H,time());
                    set_session("queries", $Rc);
                    stop_session();
                }
            }
            $Yf="(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
            $Bb=";";
            $he=0;
            $Xb=true;
            $g=connect();
            if (is_object($g)&&DB!="") {
                $g->select_db(DB);
                if ($_GET["ns"]!="") {
                    set_schema($_GET["ns"], $g);
                }
            }
            $bb=0;
            $cc=array();
            $Ke='[\'"'.($y=="sql"?'`#':($y=="sqlite"?'`[':($y=="mssql"?'[':''))).']|/\*|-- |$'.($y=="pgsql"?'|\$[^$]*\$':'');
            $Mg=microtime(true);
            parse_str($_COOKIE["adminer_export"], $ma);
            $Ob=$b->dumpFormat();
            unset($Ob["sql"]);
            while ($I!="") {
                if (!$he&&preg_match("~^$Yf*+DELIMITER\\s+(\\S+)~i", $I, $C)) {
                    $Bb=$C[1];
                    $I=substr($I, strlen($C[0]));
                } else {
                    preg_match('('.preg_quote($Bb)."\\s*|$Ke)", $I, $C, PREG_OFFSET_CAPTURE, $he);
                    list($Ac, $Ve)=$C[0];
                    if (!$Ac&&$q&&!feof($q)) {
                        $I.=fread($q, 1e5);
                    } else {
                        if (!$Ac&&rtrim($I)=="") {
                            break;
                        }
                        $he=$Ve+strlen($Ac);
                        if ($Ac&&rtrim($Ac)!=$Bb) {
                            while (preg_match('('.($Ac=='/*'?'\*/':($Ac=='['?']':(preg_match('~^-- |^#~', $Ac)?"\n":preg_quote($Ac)."|\\\\."))).'|$)s', $I, $C, PREG_OFFSET_CAPTURE, $he)) {
                                $Ef=$C[0][0];
                                if (!$Ef&&$q&&!feof($q)) {
                                    $I.=fread($q, 1e5);
                                } else {
                                    $he=$C[0][1]+strlen($Ef);
                                    if ($Ef[0]!="\\") {
                                        break;
                                    }
                                }
                            }
                        } else {
                            $Xb=false;
                            $H=substr($I, 0, $Ve);
                            $bb++;
                            $cf="<pre id='sql-$bb'><code class='jush-$y'>".$b->sqlCommandQuery($H)."</code></pre>\n";
                            if ($y=="sqlite"&&preg_match("~^$Yf*+ATTACH\\b~i", $H, $C)) {
                                echo$cf,"<p class='error'>".lang(140)."\n";
                                $cc[]=" <a href='#sql-$bb'>$bb</a>";
                                if ($_POST["error_stops"]) {
                                    break;
                                }
                            } else {
                                if (!$_POST["only_errors"]) {
                                    echo$cf;
                                    ob_flush();
                                    flush();
                                }
                                $dg=microtime(true);
                                if ($f->multi_query($H)&&is_object($g)&&preg_match("~^$Yf*+USE\\b~i", $H)) {
                                    $g->query($H);
                                }
                                do {
                                    $J=$f->store_result();
                                    if ($f->error) {
                                        echo($_POST["only_errors"]?$cf:""),"<p class='error'>".lang(141).($f->errno?" ($f->errno)":"").": ".error()."\n";
                                        $cc[]=" <a href='#sql-$bb'>$bb</a>";
                                        if ($_POST["error_stops"]) {
                                            break
2;
                                        }
                                    } else {
                                        $Cg=" <span class='time'>(".format_time($dg).")</span>".(strlen($H)<1000?" <a href='".h(ME)."sql=".urlencode(trim($H))."'>".lang(10)."</a>":"");
                                        $oa=$f->affected_rows;
                                        $vh=($_POST["only_errors"]?"":$k->warnings());
                                        $wh="warnings-$bb";
                                        if ($vh) {
                                            $Cg.=", <a href='#$wh'>".lang(42)."</a>".script("qsl('a').onclick = partial(toggle, '$wh');", "");
                                        }
                                        $jc=null;
                                        $kc="explain-$bb";
                                        if (is_object($J)) {
                                            $_=$_POST["limit"];
                                            $ze=select($J, $g, array(), $_);
                                            if (!$_POST["only_errors"]) {
                                                echo"<form action='' method='post'>\n";
                                                $ee=$J->num_rows;
                                                echo"<p>".($ee?($_&&$ee>$_?lang(142, $_):"").lang(143, $ee):""),$Cg;
                                                if ($g&&preg_match("~^($Yf|\\()*+SELECT\\b~i", $H)&&($jc=explain($g, $H))) {
                                                    echo", <a href='#$kc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$kc');", "");
                                                }
                                                $u="export-$bb";
                                                echo", <a href='#$u'>".lang(69)."</a>".script("qsl('a').onclick = partial(toggle, '$u');", "")."<span id='$u' class='hidden'>: ".html_select("output", $b->dumpOutput(), $ma["output"])." ".html_select("format", $Ob, $ma["format"])."<input type='hidden' name='query' value='".h($H)."'>"." <input type='submit' name='export' value='".lang(69)."'><input type='hidden' name='token' value='$T'></span>\n"."</form>\n";
                                            }
                                        } else {
                                            if (preg_match("~^$Yf*+(CREATE|DROP|ALTER)$Yf++(DATABASE|SCHEMA)\\b~i", $H)) {
                                                restart_session();
                                                set_session("dbs", null);
                                                stop_session();
                                            }
                                            if (!$_POST["only_errors"]) {
                                                echo"<p class='message' title='".h($f->info)."'>".lang(144, $oa)."$Cg\n";
                                            }
                                        }
                                        echo($vh?"<div id='$wh' class='hidden'>\n$vh</div>\n":"");
                                        if ($jc) {
                                            echo"<div id='$kc' class='hidden'>\n";
                                            select($jc, $g, $ze);
                                            echo"</div>\n";
                                        }
                                    }
                                    $dg=microtime(true);
                                } while ($f->next_result());
                            }
                            $I=substr($I, $he);
                            $he=0;
                        }
                    }
                }
            }
            if ($Xb) {
                echo"<p class='message'>".lang(145)."\n";
            } elseif ($_POST["only_errors"]) {
                echo"<p class='message'>".lang(146, $bb-count($cc))," <span class='time'>(".format_time($Mg).")</span>\n";
            } elseif ($cc&&$bb>1) {
                echo"<p class='error'>".lang(141).": ".implode("", $cc)."\n";
            }
        } else {
            echo"<p class='error'>".upload_error($I)."\n";
        }
    }
    echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';
    $hc="<input type='submit' value='".lang(147)."' title='Ctrl+Enter'>";
    if (!isset($_GET["import"])) {
        $H=$_GET["sql"];
        if ($_POST) {
            $H=$_POST["query"];
        } elseif ($_GET["history"]=="all") {
            $H=$Qc;
        } elseif ($_GET["history"]!="") {
            $H=$Qc[$_GET["history"]][0];
        }
        echo"<p>";
        textarea("query", $H, 20);
        echo
script(($_POST?"":"qs('textarea').focus();\n")."qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '".remove_from_uri("sql|limit|error_stops|only_errors")."');"),"<p>$hc\n",lang(148).": <input type='number' name='limit' class='size' value='".h($_POST?$_POST["limit"]:$_GET["limit"])."'>\n";
    } else {
        echo"<fieldset><legend>".lang(149)."</legend><div>";
        $Jc=(extension_loaded("zlib")?"[.gz]":"");
        echo(ini_bool("file_uploads")?"SQL$Jc (&lt; ".ini_get("upload_max_filesize")."B): <input type='file' name='sql_file[]' multiple>\n$hc":lang(150)),"</div></fieldset>\n";
        $Wc=$b->importServerPath();
        if ($Wc) {
            echo"<fieldset><legend>".lang(151)."</legend><div>",lang(152, "<code>".h($Wc)."$Jc</code>"),' <input type="submit" name="webfile" value="'.lang(153).'">',"</div></fieldset>\n";
        }
        echo"<p>";
    }
    echo
checkbox("error_stops", 1, ($_POST?$_POST["error_stops"]:isset($_GET["import"])), lang(154))."\n",checkbox("only_errors", 1, ($_POST?$_POST["only_errors"]:isset($_GET["import"])), lang(155))."\n","<input type='hidden' name='token' value='$T'>\n";
    if (!isset($_GET["import"])&&$Qc) {
        print_fieldset("history", lang(156), $_GET["history"]!="");
        for ($X=end($Qc);$X;$X=prev($Qc)) {
            $z=key($Qc);
            list($H, $Cg, $Sb)=$X;
            echo'<a href="'.h(ME."sql=&history=$z").'">'.lang(10)."</a>"." <span class='time' title='".@date('Y-m-d', $Cg)."'>".@date("H:i:s", $Cg)."</span>"." <code class='jush-$y'>".shorten_utf8(ltrim(str_replace("\n", " ", str_replace("\r", "", preg_replace('~^(#|-- ).*~m', '', $H)))), 80, "</code>").($Sb?" <span class='time'>($Sb)</span>":"")."<br>\n";
        }
        echo"<input type='submit' name='clear' value='".lang(157)."'>\n","<a href='".h(ME."sql=&history=all")."'>".lang(158)."</a>\n","</div></fieldset>\n";
    }
    echo'</form>
';
} elseif (isset($_GET["edit"])) {
    $a=$_GET["edit"];
    $n=fields($a);
    $Z=(isset($_GET["select"])?($_POST["check"]&&count($_POST["check"])==1?where_check($_POST["check"][0], $n):""):where($_GET, $n));
    $eh=(isset($_GET["select"])?$_POST["edit"]:$Z);
    foreach ($n
as$E=>$m) {
        if (!isset($m["privileges"][$eh?"update":"insert"])||$b->fieldName($m)==""||$m["generated"]) {
            unset($n[$E]);
        }
    }
    if ($_POST&&!$l&&!isset($_GET["select"])) {
        $B=$_POST["referer"];
        if ($_POST["insert"]) {
            $B=($eh?null:$_SERVER["REQUEST_URI"]);
        } elseif (!preg_match('~^.+&select=.+$~', $B)) {
            $B=ME."select=".urlencode($a);
        }
        $x=indexes($a);
        $Zg=unique_array($_GET["where"], $x);
        $lf="\nWHERE $Z";
        if (isset($_POST["delete"])) {
            queries_redirect($B, lang(159), $k->delete($a, $lf, !$Zg));
        } else {
            $P=array();
            foreach ($n
as$E=>$m) {
                $X=process_input($m);
                if ($X!==false&&$X!==null) {
                    $P[idf_escape($E)]=$X;
                }
            }
            if ($eh) {
                if (!$P) {
                    redirect($B);
                }
                queries_redirect($B, lang(160), $k->update($a, $P, $lf, !$Zg));
                if (is_ajax()) {
                    page_headers();
                    page_messages($l);
                    exit;
                }
            } else {
                $J=$k->insert($a, $P);
                $ud=($J?last_id():0);
                queries_redirect($B, lang(161, ($ud?" $ud":"")), $J);
            }
        }
    }
    $L=null;
    if ($_POST["save"]) {
        $L=(array)$_POST["fields"];
    } elseif ($Z) {
        $N=array();
        foreach ($n
as$E=>$m) {
            if (isset($m["privileges"]["select"])) {
                $va=convert_field($m);
                if ($_POST["clone"]&&$m["auto_increment"]) {
                    $va="''";
                }
                if ($y=="sql"&&preg_match("~enum|set~", $m["type"])) {
                    $va="1*".idf_escape($E);
                }
                $N[]=($va?"$va AS ":"").idf_escape($E);
            }
        }
        $L=array();
        if (!support("table")) {
            $N=array("*");
        }
        if ($N) {
            $J=$k->select($a, $N, array($Z), $N, array(), (isset($_GET["select"])?2:1));
            if (!$J) {
                $l=error();
            } else {
                $L=$J->fetch_assoc();
                if (!$L) {
                    $L=false;
                }
            }
            if (isset($_GET["select"])&&(!$L||$J->fetch_assoc())) {
                $L=null;
            }
        }
    }
    if (!support("table")&&!$n) {
        if (!$Z) {
            $J=$k->select($a, array("*"), $Z, array("*"));
            $L=($J?$J->fetch_assoc():false);
            if (!$L) {
                $L=array($k->primary=>"");
            }
        }
        if ($L) {
            foreach ($L
as$z=>$X) {
                if (!$Z) {
                    $L[$z]=null;
                }
                $n[$z]=array("field"=>$z,"null"=>($z!=$k->primary),"auto_increment"=>($z==$k->primary));
            }
        }
    }
    edit_form($a, $n, $L, $eh);
} elseif (isset($_GET["create"])) {
    $a=$_GET["create"];
    $Le=array();
    foreach (array('HASH','LINEAR HASH','KEY','LINEAR KEY','RANGE','LIST')as$z) {
        $Le[$z]=$z;
    }
    $rf=referencable_primary($a);
    $p=array();
    foreach ($rf
as$qg=>$m) {
        $p[str_replace("`", "``", $qg)."`".str_replace("`", "``", $m["field"])]=$qg;
    }
    $Be=array();
    $R=array();
    if ($a!="") {
        $Be=fields($a);
        $R=table_status($a);
        if (!$R) {
            $l=lang(9);
        }
    }
    $L=$_POST;
    $L["fields"]=(array)$L["fields"];
    if ($L["auto_increment_col"]) {
        $L["fields"][$L["auto_increment_col"]]["auto_increment"]=true;
    }
    if ($_POST) {
        set_adminer_settings(array("comments"=>$_POST["comments"],"defaults"=>$_POST["defaults"]));
    }
    if ($_POST&&!process_fields($L["fields"])&&!$l) {
        if ($_POST["drop"]) {
            queries_redirect(substr(ME, 0, -1), lang(162), drop_tables(array($a)));
        } else {
            $n=array();
            $sa=array();
            $ih=false;
            $yc=array();
            $Ae=reset($Be);
            $qa=" FIRST";
            foreach ($L["fields"]as$z=>$m) {
                $o=$p[$m["type"]];
                $Ug=($o!==null?$rf[$o]:$m);
                if ($m["field"]!="") {
                    if (!$m["has_default"]) {
                        $m["default"]=null;
                    }
                    if ($z==$L["auto_increment_col"]) {
                        $m["auto_increment"]=true;
                    }
                    $hf=process_field($m, $Ug);
                    $sa[]=array($m["orig"],$hf,$qa);
                    if ($hf!=process_field($Ae, $Ae)) {
                        $n[]=array($m["orig"],$hf,$qa);
                        if ($m["orig"]!=""||$qa) {
                            $ih=true;
                        }
                    }
                    if ($o!==null) {
                        $yc[idf_escape($m["field"])]=($a!=""&&$y!="sqlite"?"ADD":" ").format_foreign_key(array('table'=>$p[$m["type"]],'source'=>array($m["field"]),'target'=>array($Ug["field"]),'on_delete'=>$m["on_delete"],));
                    }
                    $qa=" AFTER ".idf_escape($m["field"]);
                } elseif ($m["orig"]!="") {
                    $ih=true;
                    $n[]=array($m["orig"]);
                }
                if ($m["orig"]!="") {
                    $Ae=next($Be);
                    if (!$Ae) {
                        $qa="";
                    }
                }
            }
            $Ne="";
            if ($Le[$L["partition_by"]]) {
                $Oe=array();
                if ($L["partition_by"]=='RANGE'||$L["partition_by"]=='LIST') {
                    foreach (array_filter($L["partition_names"])as$z=>$X) {
                        $Y=$L["partition_values"][$z];
                        $Oe[]="\n  PARTITION ".idf_escape($X)." VALUES ".($L["partition_by"]=='RANGE'?"LESS THAN":"IN").($Y!=""?" ($Y)":" MAXVALUE");
                    }
                }
                $Ne.="\nPARTITION BY $L[partition_by]($L[partition])".($Oe?" (".implode(",", $Oe)."\n)":($L["partitions"]?" PARTITIONS ".(+$L["partitions"]):""));
            } elseif (support("partitioning")&&preg_match("~partitioned~", $R["Create_options"])) {
                $Ne.="\nREMOVE PARTITIONING";
            }
            $D=lang(163);
            if ($a=="") {
                cookie("adminer_engine", $L["Engine"]);
                $D=lang(164);
            }
            $E=trim($L["name"]);
            queries_redirect(ME.(support("table")?"table=":"select=").urlencode($E), $D, alter_table($a, $E, ($y=="sqlite"&&($ih||$yc)?$sa:$n), $yc, ($L["Comment"]!=$R["Comment"]?$L["Comment"]:null), ($L["Engine"]&&$L["Engine"]!=$R["Engine"]?$L["Engine"]:""), ($L["Collation"]&&$L["Collation"]!=$R["Collation"]?$L["Collation"]:""), ($L["Auto_increment"]!=""?number($L["Auto_increment"]):""), $Ne));
        }
    }
    page_header(($a!=""?lang(40):lang(70)), $l, array("table"=>$a), h($a));
    if (!$_POST) {
        $L=array("Engine"=>$_COOKIE["adminer_engine"],"fields"=>array(array("field"=>"","type"=>(isset($Wg["int"])?"int":(isset($Wg["integer"])?"integer":"")),"on_update"=>"")),"partition_names"=>array(""),);
        if ($a!="") {
            $L=$R;
            $L["name"]=$a;
            $L["fields"]=array();
            if (!$_GET["auto_increment"]) {
                $L["Auto_increment"]="";
            }
            foreach ($Be
as$m) {
                $m["has_default"]=isset($m["default"]);
                $L["fields"][]=$m;
            }
            if (support("partitioning")) {
                $Cc="FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = ".q(DB)." AND TABLE_NAME = ".q($a);
                $J=$f->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $Cc ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");
                list($L["partition_by"], $L["partitions"], $L["partition"])=$J->fetch_row();
                $Oe=get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $Cc AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");
                $Oe[""]="";
                $L["partition_names"]=array_keys($Oe);
                $L["partition_values"]=array_values($Oe);
            }
        }
    }
    $Ya=collations();
    $Zb=engines();
    foreach ($Zb
as$Yb) {
        if (!strcasecmp($Yb, $L["Engine"])) {
            $L["Engine"]=$Yb;
            break;
        }
    }
    echo'
<form action="" method="post" id="form">
<p>
';
    if (support("columns")||$a=="") {
        echo
lang(165),': <input name="name" data-maxlength="64" value="',h($L["name"]),'" autocapitalize="off">
';
        if ($a==""&&!$_POST) {
            echo
script("focus(qs('#form')['name']);");
        }
        echo($Zb?"<select name='Engine'>".optionlist(array(""=>"(".lang(166).")")+$Zb, $L["Engine"])."</select>".on_help("getTarget(event).value", 1).script("qsl('select').onchange = helpClose;"):""),' ',($Ya&&!preg_match("~sqlite|mssql~", $y)?html_select("Collation", array(""=>"(".lang(95).")")+$Ya, $L["Collation"]):""),' <input type="submit" value="',lang(14),'">
';
    }
    echo'
';
    if (support("columns")) {
        echo'<div class="scrollable">
<table cellspacing="0" id="edit-fields" class="nowrap">
';
        edit_fields($L["fields"], $Ya, "TABLE", $p);
        echo'</table>
',script("editFields();"),'</div>
<p>
',lang(47),': <input type="number" name="Auto_increment" size="6" value="',h($L["Auto_increment"]),'">
',checkbox("defaults", 1, ($_POST?$_POST["defaults"]:adminer_setting("defaults")), lang(167), "columnShow(this.checked, 5)", "jsonly"),(support("comment")?checkbox("comments", 1, ($_POST?$_POST["comments"]:adminer_setting("comments")), lang(46), "editingCommentsClick(this, true);", "jsonly").' <input name="Comment" value="'.h($L["Comment"]).'" data-maxlength="'.(min_version(5.5)?2048:60).'">':''),'<p>
<input type="submit" value="',lang(14),'">
';
    }
    echo'
';
    if ($a!="") {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $a));
    }
    if (support("partitioning")) {
        $Me=preg_match('~RANGE|LIST~', $L["partition_by"]);
        print_fieldset("partition", lang(169), $L["partition_by"]);
        echo'<p>
',"<select name='partition_by'>".optionlist(array(""=>"")+$Le, $L["partition_by"])."</select>".on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')", 1).script("qsl('select').onchange = partitionByChange;"),'(<input name="partition" value="',h($L["partition"]),'">)
',lang(170),': <input type="number" name="partitions" class="size',($Me||!$L["partition_by"]?" hidden":""),'" value="',h($L["partitions"]),'">
<table cellspacing="0" id="partition-table"',($Me?"":" class='hidden'"),'>
<thead><tr><th>',lang(171),'<th>',lang(172),'</thead>
';
        foreach ($L["partition_names"]as$z=>$X) {
            echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($z==count($L["partition_names"])-1?script("qsl('input').oninput = partitionNameChange;"):''),'<td><input name="partition_values[]" value="'.h($L["partition_values"][$z]).'">';
        }
        echo'</table>
</div></fieldset>
';
    }
    echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["indexes"])) {
    $a=$_GET["indexes"];
    $Yc=array("PRIMARY","UNIQUE","INDEX");
    $R=table_status($a, true);
    if (preg_match('~MyISAM|M?aria'.(min_version(5.6, '10.0.5')?'|InnoDB':'').'~i', $R["Engine"])) {
        $Yc[]="FULLTEXT";
    }
    if (preg_match('~MyISAM|M?aria'.(min_version(5.7, '10.2.2')?'|InnoDB':'').'~i', $R["Engine"])) {
        $Yc[]="SPATIAL";
    }
    $x=indexes($a);
    $bf=array();
    if ($y=="mongo") {
        $bf=$x["_id_"];
        unset($Yc[0]);
        unset($x["_id_"]);
    }
    $L=$_POST;
    if ($_POST&&!$l&&!$_POST["add"]&&!$_POST["drop_col"]) {
        $ta=array();
        foreach ($L["indexes"]as$w) {
            $E=$w["name"];
            if (in_array($w["type"], $Yc)) {
                $d=array();
                $_d=array();
                $Db=array();
                $P=array();
                ksort($w["columns"]);
                foreach ($w["columns"]as$z=>$c) {
                    if ($c!="") {
                        $zd=$w["lengths"][$z];
                        $Cb=$w["descs"][$z];
                        $P[]=idf_escape($c).($zd?"(".(+$zd).")":"").($Cb?" DESC":"");
                        $d[]=$c;
                        $_d[]=($zd?$zd:null);
                        $Db[]=$Cb;
                    }
                }
                if ($d) {
                    $ic=$x[$E];
                    if ($ic) {
                        ksort($ic["columns"]);
                        ksort($ic["lengths"]);
                        ksort($ic["descs"]);
                        if ($w["type"]==$ic["type"]&&array_values($ic["columns"])===$d&&(!$ic["lengths"]||array_values($ic["lengths"])===$_d)&&array_values($ic["descs"])===$Db) {
                            unset($x[$E]);
                            continue;
                        }
                    }
                    $ta[]=array($w["type"],$E,$P);
                }
            }
        }
        foreach ($x
as$E=>$ic) {
            $ta[]=array($ic["type"],$E,"DROP");
        }
        if (!$ta) {
            redirect(ME."table=".urlencode($a));
        }
        queries_redirect(ME."table=".urlencode($a), lang(173), alter_indexes($a, $ta));
    }
    page_header(lang(125), $l, array("table"=>$a), h($a));
    $n=array_keys(fields($a));
    if ($_POST["add"]) {
        foreach ($L["indexes"]as$z=>$w) {
            if ($w["columns"][count($w["columns"])]!="") {
                $L["indexes"][$z]["columns"][]="";
            }
        }
        $w=end($L["indexes"]);
        if ($w["type"]||array_filter($w["columns"], 'strlen')) {
            $L["indexes"][]=array("columns"=>array(1=>""));
        }
    }
    if (!$L) {
        foreach ($x
as$z=>$w) {
            $x[$z]["name"]=$z;
            $x[$z]["columns"][]="";
        }
        $x[]=array("columns"=>array(1=>""));
        $L["indexes"]=$x;
    }
    echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">',lang(174),'<th><input type="submit" class="wayoff">',lang(175),'<th id="label-name">',lang(176),'<th><noscript>',"<input type='image' class='icon' name='add[0]' src='".h(preg_replace("~\\?.*~", "", ME)."?file=plus.gif&version=4.7.6")."' alt='+' title='".lang(102)."'>",'</noscript>
</thead>
';
    if ($bf) {
        echo"<tr><td>PRIMARY<td>";
        foreach ($bf["columns"]as$z=>$c) {
            echo
select_input(" disabled", $n, $c),"<label><input disabled type='checkbox'>".lang(55)."</label> ";
        }
        echo"<td><td>\n";
    }
    $kd=1;
    foreach ($L["indexes"]as$w) {
        if (!$_POST["drop_col"]||$kd!=key($_POST["drop_col"])) {
            echo"<tr><td>".html_select("indexes[$kd][type]", array(-1=>"")+$Yc, $w["type"], ($kd==count($L["indexes"])?"indexesAddRow.call(this);":1), "label-type"),"<td>";
            ksort($w["columns"]);
            $t=1;
            foreach ($w["columns"]as$z=>$c) {
                echo"<span>".select_input(" name='indexes[$kd][columns][$t]' title='".lang(44)."'", ($n?array_combine($n, $n):$n), $c, "partial(".($t==count($w["columns"])?"indexesAddColumn":"indexesChangeColumn").", '".js_escape($y=="sql"?"":$_GET["indexes"]."_")."')"),($y=="sql"||$y=="mssql"?"<input type='number' name='indexes[$kd][lengths][$t]' class='size' value='".h($w["lengths"][$z])."' title='".lang(100)."'>":""),(support("descidx")?checkbox("indexes[$kd][descs][$t]", 1, $w["descs"][$z], lang(55)):"")," </span>";
                $t++;
            }
            echo"<td><input name='indexes[$kd][name]' value='".h($w["name"])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$kd]' src='".h(preg_replace("~\\?.*~", "", ME)."?file=cross.gif&version=4.7.6")."' alt='x' title='".lang(105)."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");
        }
        $kd++;
    }
    echo'</table>
</div>
<p>
<input type="submit" value="',lang(14),'">
<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["database"])) {
    $L=$_POST;
    if ($_POST&&!$l&&!isset($_POST["add_x"])) {
        $E=trim($L["name"]);
        if ($_POST["drop"]) {
            $_GET["db"]="";
            queries_redirect(remove_from_uri("db|database"), lang(177), drop_databases(array(DB)));
        } elseif (DB!==$E) {
            if (DB!="") {
                $_GET["db"]=$E;
                queries_redirect(preg_replace('~\bdb=[^&]*&~', '', ME)."db=".urlencode($E), lang(178), rename_database($E, $L["collation"]));
            } else {
                $i=explode("\n", str_replace("\r", "", $E));
                $kg=true;
                $td="";
                foreach ($i
as$j) {
                    if (count($i)==1||$j!="") {
                        if (!create_database($j, $L["collation"])) {
                            $kg=false;
                        }
                        $td=$j;
                    }
                }
                restart_session();
                set_session("dbs", null);
                queries_redirect(ME."db=".urlencode($td), lang(179), $kg);
            }
        } else {
            if (!$L["collation"]) {
                redirect(substr(ME, 0, -1));
            }
            query_redirect("ALTER DATABASE ".idf_escape($E).(preg_match('~^[a-z0-9_]+$~i', $L["collation"])?" COLLATE $L[collation]":""), substr(ME, 0, -1), lang(180));
        }
    }
    page_header(DB!=""?lang(63):lang(109), $l, array(), h(DB));
    $Ya=collations();
    $E=DB;
    if ($_POST) {
        $E=$L["name"];
    } elseif (DB!="") {
        $L["collation"]=db_collation(DB, $Ya);
    } elseif ($y=="sql") {
        foreach (get_vals("SHOW GRANTS")as$Ec) {
            if (preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~', $Ec, $C)&&$C[1]) {
                $E=stripcslashes(idf_unescape("`$C[2]`"));
                break;
            }
        }
    }
    echo'
<form action="" method="post">
<p>
',($_POST["add_x"]||strpos($E, "\n")?'<textarea id="name" name="name" rows="10" cols="40">'.h($E).'</textarea><br>':'<input name="name" id="name" value="'.h($E).'" data-maxlength="64" autocapitalize="off">')."\n".($Ya?html_select("collation", array(""=>"(".lang(95).")")+$Ya, $L["collation"]).doc_link(array('sql'=>"charset-charsets.html",'mariadb'=>"supported-character-sets-and-collations/",)):""),script("focus(qs('#name'));"),'<input type="submit" value="',lang(14),'">
';
    if (DB!="") {
        echo"<input type='submit' name='drop' value='".lang(121)."'>".confirm(lang(168, DB))."\n";
    } elseif (!$_POST["add_x"]&&$_GET["db"]=="") {
        echo"<input type='image' class='icon' name='add' src='".h(preg_replace("~\\?.*~", "", ME)."?file=plus.gif&version=4.7.6")."' alt='+' title='".lang(102)."'>\n";
    }
    echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["call"])) {
    $da=($_GET["name"]?$_GET["name"]:$_GET["call"]);
    page_header(lang(181).": ".h($da), $l);
    $Bf=routine($_GET["call"], (isset($_GET["callf"])?"FUNCTION":"PROCEDURE"));
    $Xc=array();
    $Ee=array();
    foreach ($Bf["fields"]as$t=>$m) {
        if (substr($m["inout"], -3)=="OUT") {
            $Ee[$t]="@".idf_escape($m["field"])." AS ".idf_escape($m["field"]);
        }
        if (!$m["inout"]||substr($m["inout"], 0, 2)=="IN") {
            $Xc[]=$t;
        }
    }
    if (!$l&&$_POST) {
        $Ka=array();
        foreach ($Bf["fields"]as$z=>$m) {
            if (in_array($z, $Xc)) {
                $X=process_input($m);
                if ($X===false) {
                    $X="''";
                }
                if (isset($Ee[$z])) {
                    $f->query("SET @".idf_escape($m["field"])." = $X");
                }
            }
            $Ka[]=(isset($Ee[$z])?"@".idf_escape($m["field"]):$X);
        }
        $I=(isset($_GET["callf"])?"SELECT":"CALL")." ".table($da)."(".implode(", ", $Ka).")";
        $dg=microtime(true);
        $J=$f->multi_query($I);
        $oa=$f->affected_rows;
        echo$b->selectQuery($I, $dg, !$J);
        if (!$J) {
            echo"<p class='error'>".error()."\n";
        } else {
            $g=connect();
            if (is_object($g)) {
                $g->select_db(DB);
            }
            do {
                $J=$f->store_result();
                if (is_object($J)) {
                    select($J, $g);
                } else {
                    echo"<p class='message'>".lang(182, $oa)." <span class='time'>".@date("H:i:s")."</span>\n";
                }
            } while ($f->next_result());
            if ($Ee) {
                select($f->query("SELECT ".implode(", ", $Ee)));
            }
        }
    }
    echo'
<form action="" method="post">
';
    if ($Xc) {
        echo"<table cellspacing='0' class='layout'>\n";
        foreach ($Xc
as$z) {
            $m=$Bf["fields"][$z];
            $E=$m["field"];
            echo"<tr><th>".$b->fieldName($m);
            $Y=$_POST["fields"][$E];
            if ($Y!="") {
                if ($m["type"]=="enum") {
                    $Y=+$Y;
                }
                if ($m["type"]=="set") {
                    $Y=array_sum($Y);
                }
            }
            input($m, $Y, (string)$_POST["function"][$E]);
            echo"\n";
        }
        echo"</table>\n";
    }
    echo'<p>
<input type="submit" value="',lang(181),'">
<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["foreign"])) {
    $a=$_GET["foreign"];
    $E=$_GET["name"];
    $L=$_POST;
    if ($_POST&&!$l&&!$_POST["add"]&&!$_POST["change"]&&!$_POST["change-js"]) {
        $D=($_POST["drop"]?lang(183):($E!=""?lang(184):lang(185)));
        $B=ME."table=".urlencode($a);
        if (!$_POST["drop"]) {
            $L["source"]=array_filter($L["source"], 'strlen');
            ksort($L["source"]);
            $xg=array();
            foreach ($L["source"]as$z=>$X) {
                $xg[$z]=$L["target"][$z];
            }
            $L["target"]=$xg;
        }
        if ($y=="sqlite") {
            queries_redirect($B, $D, recreate_table($a, $a, array(), array(), array(" $E"=>($_POST["drop"]?"":" ".format_foreign_key($L)))));
        } else {
            $ta="ALTER TABLE ".table($a);
            $Kb="\nDROP ".($y=="sql"?"FOREIGN KEY ":"CONSTRAINT ").idf_escape($E);
            if ($_POST["drop"]) {
                query_redirect($ta.$Kb, $B, $D);
            } else {
                query_redirect($ta.($E!=""?"$Kb,":"")."\nADD".format_foreign_key($L), $B, $D);
                $l=lang(186)."<br>$l";
            }
        }
    }
    page_header(lang(187), $l, array("table"=>$a), h($a));
    if ($_POST) {
        ksort($L["source"]);
        if ($_POST["add"]) {
            $L["source"][]="";
        } elseif ($_POST["change"]||$_POST["change-js"]) {
            $L["target"]=array();
        }
    } elseif ($E!="") {
        $p=foreign_keys($a);
        $L=$p[$E];
        $L["source"][]="";
    } else {
        $L["table"]=$a;
        $L["source"]=array("");
    }
    echo'
<form action="" method="post">
';
    $Xf=array_keys(fields($a));
    if ($L["db"]!="") {
        $f->select_db($L["db"]);
    }
    if ($L["ns"]!="") {
        set_schema($L["ns"]);
    }
    $qf=array_keys(array_filter(table_status('', true), 'fk_support'));
    $xg=($a===$L["table"]?$Xf:array_keys(fields(in_array($L["table"], $qf)?$L["table"]:reset($qf))));
    $pe="this.form['change-js'].value = '1'; this.form.submit();";
    echo"<p>".lang(188).": ".html_select("table", $qf, $L["table"], $pe)."\n";
    if ($y=="pgsql") {
        echo
lang(189).": ".html_select("ns", $b->schemas(), $L["ns"]!=""?$L["ns"]:$_GET["ns"], $pe);
    } elseif ($y!="sqlite") {
        $xb=array();
        foreach ($b->databases()as$j) {
            if (!information_schema($j)) {
                $xb[]=$j;
            }
        }
        echo
lang(72).": ".html_select("db", $xb, $L["db"]!=""?$L["db"]:$_GET["db"], $pe);
    }
    echo'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="',lang(190),'"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">',lang(127),'<th id="label-target">',lang(128),'</thead>
';
    $kd=0;
    foreach ($L["source"]as$z=>$X) {
        echo"<tr>","<td>".html_select("source[".(+$z)."]", array(-1=>"")+$Xf, $X, ($kd==count($L["source"])-1?"foreignAddRow.call(this);":1), "label-source"),"<td>".html_select("target[".(+$z)."]", $xg, $L["target"][$z], 1, "label-target");
        $kd++;
    }
    echo'</table>
<p>
',lang(97),': ',html_select("on_delete", array(-1=>"")+explode("|", $oe), $L["on_delete"]),' ',lang(96),': ',html_select("on_update", array(-1=>"")+explode("|", $oe), $L["on_update"]),doc_link(array('sql'=>"innodb-foreign-key-constraints.html",'mariadb'=>"foreign-keys/",)),'<p>
<input type="submit" value="',lang(14),'">
<noscript><p><input type="submit" name="add" value="',lang(191),'"></noscript>
';
    if ($E!="") {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $E));
    }
    echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["view"])) {
    $a=$_GET["view"];
    $L=$_POST;
    $Ce="VIEW";
    if ($y=="pgsql"&&$a!="") {
        $eg=table_status($a);
        $Ce=strtoupper($eg["Engine"]);
    }
    if ($_POST&&!$l) {
        $E=trim($L["name"]);
        $va=" AS\n$L[select]";
        $B=ME."table=".urlencode($E);
        $D=lang(192);
        $U=($_POST["materialized"]?"MATERIALIZED VIEW":"VIEW");
        if (!$_POST["drop"]&&$a==$E&&$y!="sqlite"&&$U=="VIEW"&&$Ce=="VIEW") {
            query_redirect(($y=="mssql"?"ALTER":"CREATE OR REPLACE")." VIEW ".table($E).$va, $B, $D);
        } else {
            $zg=$E."_adminer_".uniqid();
            drop_create("DROP $Ce ".table($a), "CREATE $U ".table($E).$va, "DROP $U ".table($E), "CREATE $U ".table($zg).$va, "DROP $U ".table($zg), ($_POST["drop"]?substr(ME, 0, -1):$B), lang(193), $D, lang(194), $a, $E);
        }
    }
    if (!$_POST&&$a!="") {
        $L=view($a);
        $L["name"]=$a;
        $L["materialized"]=($Ce!="VIEW");
        if (!$l) {
            $l=error();
        }
    }
    page_header(($a!=""?lang(39):lang(195)), $l, array("table"=>$a), h($a));
    echo'
<form action="" method="post">
<p>',lang(176),': <input name="name" value="',h($L["name"]),'" data-maxlength="64" autocapitalize="off">
',(support("materializedview")?" ".checkbox("materialized", 1, $L["materialized"], lang(122)):""),'<p>';
    textarea("select", $L["select"]);
    echo'<p>
<input type="submit" value="',lang(14),'">
';
    if ($a!="") {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $a));
    }
    echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["event"])) {
    $aa=$_GET["event"];
    $dd=array("YEAR","QUARTER","MONTH","DAY","HOUR","MINUTE","WEEK","SECOND","YEAR_MONTH","DAY_HOUR","DAY_MINUTE","DAY_SECOND","HOUR_MINUTE","HOUR_SECOND","MINUTE_SECOND");
    $fg=array("ENABLED"=>"ENABLE","DISABLED"=>"DISABLE","SLAVESIDE_DISABLED"=>"DISABLE ON SLAVE");
    $L=$_POST;
    if ($_POST&&!$l) {
        if ($_POST["drop"]) {
            query_redirect("DROP EVENT ".idf_escape($aa), substr(ME, 0, -1), lang(196));
        } elseif (in_array($L["INTERVAL_FIELD"], $dd)&&isset($fg[$L["STATUS"]])) {
            $Ff="\nON SCHEDULE ".($L["INTERVAL_VALUE"]?"EVERY ".q($L["INTERVAL_VALUE"])." $L[INTERVAL_FIELD]".($L["STARTS"]?" STARTS ".q($L["STARTS"]):"").($L["ENDS"]?" ENDS ".q($L["ENDS"]):""):"AT ".q($L["STARTS"]))." ON COMPLETION".($L["ON_COMPLETION"]?"":" NOT")." PRESERVE";
            queries_redirect(substr(ME, 0, -1), ($aa!=""?lang(197):lang(198)), queries(($aa!=""?"ALTER EVENT ".idf_escape($aa).$Ff.($aa!=$L["EVENT_NAME"]?"\nRENAME TO ".idf_escape($L["EVENT_NAME"]):""):"CREATE EVENT ".idf_escape($L["EVENT_NAME"]).$Ff)."\n".$fg[$L["STATUS"]]." COMMENT ".q($L["EVENT_COMMENT"]).rtrim(" DO\n$L[EVENT_DEFINITION]", ";").";"));
        }
    }
    page_header(($aa!=""?lang(199).": ".h($aa):lang(200)), $l);
    if (!$L&&$aa!="") {
        $M=get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = ".q(DB)." AND EVENT_NAME = ".q($aa));
        $L=reset($M);
    }
    echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>',lang(176),'<td><input name="EVENT_NAME" value="',h($L["EVENT_NAME"]),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">',lang(201),'<td><input name="STARTS" value="',h("$L[EXECUTE_AT]$L[STARTS]"),'">
<tr><th title="datetime">',lang(202),'<td><input name="ENDS" value="',h($L["ENDS"]),'">
<tr><th>',lang(203),'<td><input type="number" name="INTERVAL_VALUE" value="',h($L["INTERVAL_VALUE"]),'" class="size"> ',html_select("INTERVAL_FIELD", $dd, $L["INTERVAL_FIELD"]),'<tr><th>',lang(112),'<td>',html_select("STATUS", $fg, $L["STATUS"]),'<tr><th>',lang(46),'<td><input name="EVENT_COMMENT" value="',h($L["EVENT_COMMENT"]),'" data-maxlength="64">
<tr><th><td>',checkbox("ON_COMPLETION", "PRESERVE", $L["ON_COMPLETION"]=="PRESERVE", lang(204)),'</table>
<p>';
    textarea("EVENT_DEFINITION", $L["EVENT_DEFINITION"]);
    echo'<p>
<input type="submit" value="',lang(14),'">
';
    if ($aa!="") {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $aa));
    }
    echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["procedure"])) {
    $da=($_GET["name"]?$_GET["name"]:$_GET["procedure"]);
    $Bf=(isset($_GET["function"])?"FUNCTION":"PROCEDURE");
    $L=$_POST;
    $L["fields"]=(array)$L["fields"];
    if ($_POST&&!process_fields($L["fields"])&&!$l) {
        $_e=routine($_GET["procedure"], $Bf);
        $zg="$L[name]_adminer_".uniqid();
        drop_create("DROP $Bf ".routine_id($da, $_e), create_routine($Bf, $L), "DROP $Bf ".routine_id($L["name"], $L), create_routine($Bf, array("name"=>$zg)+$L), "DROP $Bf ".routine_id($zg, $L), substr(ME, 0, -1), lang(205), lang(206), lang(207), $da, $L["name"]);
    }
    page_header(($da!=""?(isset($_GET["function"])?lang(208):lang(209)).": ".h($da):(isset($_GET["function"])?lang(210):lang(211))), $l);
    if (!$_POST&&$da!="") {
        $L=routine($_GET["procedure"], $Bf);
        $L["name"]=$da;
    }
    $Ya=get_vals("SHOW CHARACTER SET");
    sort($Ya);
    $Cf=routine_languages();
    echo'
<form action="" method="post" id="form">
<p>',lang(176),': <input name="name" value="',h($L["name"]),'" data-maxlength="64" autocapitalize="off">
',($Cf?lang(19).": ".html_select("language", $Cf, $L["language"])."\n":""),'<input type="submit" value="',lang(14),'">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
';
    edit_fields($L["fields"], $Ya, $Bf);
    if (isset($_GET["function"])) {
        echo"<tr><td>".lang(212);
        edit_type("returns", $L["returns"], $Ya, array(), ($y=="pgsql"?array("void","trigger"):array()));
    }
    echo'</table>
',script("editFields();"),'</div>
<p>';
    textarea("definition", $L["definition"]);
    echo'<p>
<input type="submit" value="',lang(14),'">
';
    if ($da!="") {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $da));
    }
    echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["trigger"])) {
    $a=$_GET["trigger"];
    $E=$_GET["name"];
    $Sg=trigger_options();
    $L=(array)trigger($E)+array("Trigger"=>$a."_bi");
    if ($_POST) {
        if (!$l&&in_array($_POST["Timing"], $Sg["Timing"])&&in_array($_POST["Event"], $Sg["Event"])&&in_array($_POST["Type"], $Sg["Type"])) {
            $ne=" ON ".table($a);
            $Kb="DROP TRIGGER ".idf_escape($E).($y=="pgsql"?$ne:"");
            $B=ME."table=".urlencode($a);
            if ($_POST["drop"]) {
                query_redirect($Kb, $B, lang(213));
            } else {
                if ($E!="") {
                    queries($Kb);
                }
                queries_redirect($B, ($E!=""?lang(214):lang(215)), queries(create_trigger($ne, $_POST)));
                if ($E!="") {
                    queries(create_trigger($ne, $L+array("Type"=>reset($Sg["Type"]))));
                }
            }
        }
        $L=$_POST;
    }
    page_header(($E!=""?lang(216).": ".h($E):lang(217)), $l, array("table"=>$a));
    echo'
<form action="" method="post" id="form">
<table cellspacing="0" class="layout">
<tr><th>',lang(218),'<td>',html_select("Timing", $Sg["Timing"], $L["Timing"], "triggerChange(/^".preg_quote($a, "/")."_[ba][iud]$/, '".js_escape($a)."', this.form);"),'<tr><th>',lang(219),'<td>',html_select("Event", $Sg["Event"], $L["Event"], "this.form['Timing'].onchange();"),(in_array("UPDATE OF", $Sg["Event"])?" <input name='Of' value='".h($L["Of"])."' class='hidden'>":""),'<tr><th>',lang(45),'<td>',html_select("Type", $Sg["Type"], $L["Type"]),'</table>
<p>',lang(176),': <input name="Trigger" value="',h($L["Trigger"]),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';
    textarea("Statement", $L["Statement"]);
    echo'<p>
<input type="submit" value="',lang(14),'">
';
    if ($E!="") {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $E));
    }
    echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["user"])) {
    $fa=$_GET["user"];
    $ff=array(""=>array("All privileges"=>""));
    foreach (get_rows("SHOW PRIVILEGES")as$L) {
        foreach (explode(",", ($L["Privilege"]=="Grant option"?"":$L["Context"]))as$ib) {
            $ff[$ib][$L["Privilege"]]=$L["Comment"];
        }
    }
    $ff["Server Admin"]+=$ff["File access on server"];
    $ff["Databases"]["Create routine"]=$ff["Procedures"]["Create routine"];
    unset($ff["Procedures"]["Create routine"]);
    $ff["Columns"]=array();
    foreach (array("Select","Insert","Update","References")as$X) {
        $ff["Columns"][$X]=$ff["Tables"][$X];
    }
    unset($ff["Server Admin"]["Usage"]);
    foreach ($ff["Tables"]as$z=>$X) {
        unset($ff["Databases"][$z]);
    }
    $Yd=array();
    if ($_POST) {
        foreach ($_POST["objects"]as$z=>$X) {
            $Yd[$X]=(array)$Yd[$X]+(array)$_POST["grants"][$z];
        }
    }
    $Fc=array();
    $le="";
    if (isset($_GET["host"])&&($J=$f->query("SHOW GRANTS FOR ".q($fa)."@".q($_GET["host"])))) {
        while ($L=$J->fetch_row()) {
            if (preg_match('~GRANT (.*) ON (.*) TO ~', $L[0], $C)&&preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~', $C[1], $Gd, PREG_SET_ORDER)) {
                foreach ($Gd
as$X) {
                    if ($X[1]!="USAGE") {
                        $Fc["$C[2]$X[2]"][$X[1]]=true;
                    }
                    if (preg_match('~ WITH GRANT OPTION~', $L[0])) {
                        $Fc["$C[2]$X[2]"]["GRANT OPTION"]=true;
                    }
                }
            }
            if (preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~", $L[0], $C)) {
                $le=$C[1];
            }
        }
    }
    if ($_POST&&!$l) {
        $me=(isset($_GET["host"])?q($fa)."@".q($_GET["host"]):"''");
        if ($_POST["drop"]) {
            query_redirect("DROP USER $me", ME."privileges=", lang(220));
        } else {
            $ae=q($_POST["user"])."@".q($_POST["host"]);
            $Pe=$_POST["pass"];
            if ($Pe!=''&&!$_POST["hashed"]&&!min_version(8)) {
                $Pe=$f->result("SELECT PASSWORD(".q($Pe).")");
                $l=!$Pe;
            }
            $mb=false;
            if (!$l) {
                if ($me!=$ae) {
                    $mb=queries((min_version(5)?"CREATE USER":"GRANT USAGE ON *.* TO")." $ae IDENTIFIED BY ".(min_version(8)?"":"PASSWORD ").q($Pe));
                    $l=!$mb;
                } elseif ($Pe!=$le) {
                    queries("SET PASSWORD FOR $ae = ".q($Pe));
                }
            }
            if (!$l) {
                $zf=array();
                foreach ($Yd
as$ge=>$Ec) {
                    if (isset($_GET["grant"])) {
                        $Ec=array_filter($Ec);
                    }
                    $Ec=array_keys($Ec);
                    if (isset($_GET["grant"])) {
                        $zf=array_diff(array_keys(array_filter($Yd[$ge], 'strlen')), $Ec);
                    } elseif ($me==$ae) {
                        $je=array_keys((array)$Fc[$ge]);
                        $zf=array_diff($je, $Ec);
                        $Ec=array_diff($Ec, $je);
                        unset($Fc[$ge]);
                    }
                    if (preg_match('~^(.+)\s*(\(.*\))?$~U', $ge, $C)&&(!grant("REVOKE", $zf, $C[2], " ON $C[1] FROM $ae")||!grant("GRANT", $Ec, $C[2], " ON $C[1] TO $ae"))) {
                        $l=true;
                        break;
                    }
                }
            }
            if (!$l&&isset($_GET["host"])) {
                if ($me!=$ae) {
                    queries("DROP USER $me");
                } elseif (!isset($_GET["grant"])) {
                    foreach ($Fc
as$ge=>$zf) {
                        if (preg_match('~^(.+)(\(.*\))?$~U', $ge, $C)) {
                            grant("REVOKE", array_keys($zf), $C[2], " ON $C[1] FROM $ae");
                        }
                    }
                }
            }
            queries_redirect(ME."privileges=", (isset($_GET["host"])?lang(221):lang(222)), !$l);
            if ($mb) {
                $f->query("DROP USER $ae");
            }
        }
    }
    page_header((isset($_GET["host"])?lang(31).": ".h("$fa@$_GET[host]"):lang(139)), $l, array("privileges"=>array('',lang(67))));
    if ($_POST) {
        $L=$_POST;
        $Fc=$Yd;
    } else {
        $L=$_GET+array("host"=>$f->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)"));
        $L["pass"]=$le;
        if ($le!="") {
            $L["hashed"]=true;
        }
        $Fc[(DB==""||$Fc?"":idf_escape(addcslashes(DB, "%_\\"))).".*"]=array();
    }
    echo'<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>',lang(30),'<td><input name="host" data-maxlength="60" value="',h($L["host"]),'" autocapitalize="off">
<tr><th>',lang(31),'<td><input name="user" data-maxlength="80" value="',h($L["user"]),'" autocapitalize="off">
<tr><th>',lang(32),'<td><input name="pass" id="pass" value="',h($L["pass"]),'" autocomplete="new-password">
';
    if (!$L["hashed"]) {
        echo
script("typePassword(qs('#pass'));");
    }
    echo(min_version(8)?"":checkbox("hashed", 1, $L["hashed"], lang(223), "typePassword(this.form['pass'], this.checked);")),'</table>

';
    echo"<table cellspacing='0'>\n","<thead><tr><th colspan='2'>".lang(67).doc_link(array('sql'=>"grant.html#priv_level"));
    $t=0;
    foreach ($Fc
as$ge=>$Ec) {
        echo'<th>'.($ge!="*.*"?"<input name='objects[$t]' value='".h($ge)."' size='10' autocapitalize='off'>":"<input type='hidden' name='objects[$t]' value='*.*' size='10'>*.*");
        $t++;
    }
    echo"</thead>\n";
    foreach (array(""=>"","Server Admin"=>lang(30),"Databases"=>lang(33),"Tables"=>lang(124),"Columns"=>lang(44),"Procedures"=>lang(224),)as$ib=>$Cb) {
        foreach ((array)$ff[$ib]as$ef=>$cb) {
            echo"<tr".odd()."><td".($Cb?">$Cb<td":" colspan='2'").' lang="en" title="'.h($cb).'">'.h($ef);
            $t=0;
            foreach ($Fc
as$ge=>$Ec) {
                $E="'grants[$t][".h(strtoupper($ef))."]'";
                $Y=$Ec[strtoupper($ef)];
                if ($ib=="Server Admin"&&$ge!=(isset($Fc["*.*"])?"*.*":".*")) {
                    echo"<td>";
                } elseif (isset($_GET["grant"])) {
                    echo"<td><select name=$E><option><option value='1'".($Y?" selected":"").">".lang(225)."<option value='0'".($Y=="0"?" selected":"").">".lang(226)."</select>";
                } else {
                    echo"<td align='center'><label class='block'>","<input type='checkbox' name=$E value='1'".($Y?" checked":"").($ef=="All privileges"?" id='grants-$t-all'>":">".($ef=="Grant option"?"":script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$t-all'); };"))),"</label>";
                }
                $t++;
            }
        }
    }
    echo"</table>\n",'<p>
<input type="submit" value="',lang(14),'">
';
    if (isset($_GET["host"])) {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, "$fa@$_GET[host]"));
    }
    echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET["processlist"])) {
    if (support("kill")&&$_POST&&!$l) {
        $od=0;
        foreach ((array)$_POST["kill"]as$X) {
            if (kill_process($X)) {
                $od++;
            }
        }
        queries_redirect(ME."processlist=", lang(227, $od), $od||!$_POST["kill"]);
    }
    page_header(lang(110), $l);
    echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap checkable">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");
    $t=-1;
    foreach (process_list()as$t=>$L) {
        if (!$t) {
            echo"<thead><tr lang='en'>".(support("kill")?"<th>":"");
            foreach ($L
as$z=>$X) {
                echo"<th>$z".doc_link(array('sql'=>"show-processlist.html#processlist_".strtolower($z),));
            }
            echo"</thead>\n";
        }
        echo"<tr".odd().">".(support("kill")?"<td>".checkbox("kill[]", $L[$y=="sql"?"Id":"pid"], 0):"");
        foreach ($L
as$z=>$X) {
            echo"<td>".(($y=="sql"&&$z=="Info"&&preg_match("~Query|Killed~", $L["Command"])&&$X!="")||($y=="pgsql"&&$z=="current_query"&&$X!="<IDLE>")||($y=="oracle"&&$z=="sql_text"&&$X!="")?"<code class='jush-$y'>".shorten_utf8($X, 100, "</code>").' <a href="'.h(ME.($L["db"]!=""?"db=".urlencode($L["db"])."&":"")."sql=".urlencode($X)).'">'.lang(228).'</a>':h($X));
        }
        echo"\n";
    }
    echo'</table>
</div>
<p>
';
    if (support("kill")) {
        echo($t+1)."/".lang(229, max_connections()),"<p><input type='submit' value='".lang(230)."'>\n";
    }
    echo'<input type="hidden" name="token" value="',$T,'">
</form>
',script("tableCheck();");
} elseif (isset($_GET["select"])) {
    $a=$_GET["select"];
    $R=table_status1($a);
    $x=indexes($a);
    $n=fields($a);
    $p=column_foreign_keys($a);
    $ie=$R["Oid"];
    parse_str($_COOKIE["adminer_import"], $na);
    $_f=array();
    $d=array();
    $Bg=null;
    foreach ($n
as$z=>$m) {
        $E=$b->fieldName($m);
        if (isset($m["privileges"]["select"])&&$E!="") {
            $d[$z]=html_entity_decode(strip_tags($E), ENT_QUOTES);
            if (is_shortable($m)) {
                $Bg=$b->selectLengthProcess();
            }
        }
        $_f+=$m["privileges"];
    }
    list($N, $s)=$b->selectColumnsProcess($d, $x);
    $hd=count($s)<count($N);
    $Z=$b->selectSearchProcess($n, $x);
    $we=$b->selectOrderProcess($n, $x);
    $_=$b->selectLimitProcess();
    if ($_GET["val"]&&is_ajax()) {
        header("Content-Type: text/plain; charset=utf-8");
        foreach ($_GET["val"]as$ah=>$L) {
            $va=convert_field($n[key($L)]);
            $N=array($va?$va:idf_escape(key($L)));
            $Z[]=where_check($ah, $n);
            $K=$k->select($a, $N, $Z, $N);
            if ($K) {
                echo
reset($K->fetch_row());
            }
        }
        exit;
    }
    $bf=$ch=null;
    foreach ($x
as$w) {
        if ($w["type"]=="PRIMARY") {
            $bf=array_flip($w["columns"]);
            $ch=($N?$bf:array());
            foreach ($ch
as$z=>$X) {
                if (in_array(idf_escape($z), $N)) {
                    unset($ch[$z]);
                }
            }
            break;
        }
    }
    if ($ie&&!$bf) {
        $bf=$ch=array($ie=>0);
        $x[]=array("type"=>"PRIMARY","columns"=>array($ie));
    }
    if ($_POST&&!$l) {
        $yh=$Z;
        if (!$_POST["all"]&&is_array($_POST["check"])) {
            $Pa=array();
            foreach ($_POST["check"]as$Na) {
                $Pa[]=where_check($Na, $n);
            }
            $yh[]="((".implode(") OR (", $Pa)."))";
        }
        $yh=($yh?"\nWHERE ".implode(" AND ", $yh):"");
        if ($_POST["export"]) {
            cookie("adminer_import", "output=".urlencode($_POST["output"])."&format=".urlencode($_POST["format"]));
            dump_headers($a);
            $b->dumpTable($a, "");
            $Cc=($N?implode(", ", $N):"*").convert_fields($d, $n, $N)."\nFROM ".table($a);
            $Hc=($s&&$hd?"\nGROUP BY ".implode(", ", $s):"").($we?"\nORDER BY ".implode(", ", $we):"");
            if (!is_array($_POST["check"])||$bf) {
                $I="SELECT $Cc$yh$Hc";
            } else {
                $Yg=array();
                foreach ($_POST["check"]as$X) {
                    $Yg[]="(SELECT".limit($Cc, "\nWHERE ".($Z?implode(" AND ", $Z)." AND ":"").where_check($X, $n).$Hc, 1).")";
                }
                $I=implode(" UNION ALL ", $Yg);
            }
            $b->dumpData($a, "table", $I);
            exit;
        }
        if (!$b->selectEmailProcess($Z, $p)) {
            if ($_POST["save"]||$_POST["delete"]) {
                $J=true;
                $oa=0;
                $P=array();
                if (!$_POST["delete"]) {
                    foreach ($d
as$E=>$X) {
                        $X=process_input($n[$E]);
                        if ($X!==null&&($_POST["clone"]||$X!==false)) {
                            $P[idf_escape($E)]=($X!==false?$X:idf_escape($E));
                        }
                    }
                }
                if ($_POST["delete"]||$P) {
                    if ($_POST["clone"]) {
                        $I="INTO ".table($a)." (".implode(", ", array_keys($P)).")\nSELECT ".implode(", ", $P)."\nFROM ".table($a);
                    }
                    if ($_POST["all"]||($bf&&is_array($_POST["check"]))||$hd) {
                        $J=($_POST["delete"]?$k->delete($a, $yh):($_POST["clone"]?queries("INSERT $I$yh"):$k->update($a, $P, $yh)));
                        $oa=$f->affected_rows;
                    } else {
                        foreach ((array)$_POST["check"]as$X) {
                            $xh="\nWHERE ".($Z?implode(" AND ", $Z)." AND ":"").where_check($X, $n);
                            $J=($_POST["delete"]?$k->delete($a, $xh, 1):($_POST["clone"]?queries("INSERT".limit1($a, $I, $xh)):$k->update($a, $P, $xh, 1)));
                            if (!$J) {
                                break;
                            }
                            $oa+=$f->affected_rows;
                        }
                    }
                }
                $D=lang(231, $oa);
                if ($_POST["clone"]&&$J&&$oa==1) {
                    $ud=last_id();
                    if ($ud) {
                        $D=lang(161, " $ud");
                    }
                }
                queries_redirect(remove_from_uri($_POST["all"]&&$_POST["delete"]?"page":""), $D, $J);
                if (!$_POST["delete"]) {
                    edit_form($a, $n, (array)$_POST["fields"], !$_POST["clone"]);
                    page_footer();
                    exit;
                }
            } elseif (!$_POST["import"]) {
                if (!$_POST["val"]) {
                    $l=lang(232);
                } else {
                    $J=true;
                    $oa=0;
                    foreach ($_POST["val"]as$ah=>$L) {
                        $P=array();
                        foreach ($L
as$z=>$X) {
                            $z=bracket_escape($z, 1);
                            $P[idf_escape($z)]=(preg_match('~char|text~', $n[$z]["type"])||$X!=""?$b->processInput($n[$z], $X):"NULL");
                        }
                        $J=$k->update($a, $P, " WHERE ".($Z?implode(" AND ", $Z)." AND ":"").where_check($ah, $n), !$hd&&!$bf, " ");
                        if (!$J) {
                            break;
                        }
                        $oa+=$f->affected_rows;
                    }
                    queries_redirect(remove_from_uri(), lang(231, $oa), $J);
                }
            } elseif (!is_string($sc=get_file("csv_file", true))) {
                $l=upload_error($sc);
            } elseif (!preg_match('~~u', $sc)) {
                $l=lang(233);
            } else {
                cookie("adminer_import", "output=".urlencode($na["output"])."&format=".urlencode($_POST["separator"]));
                $J=true;
                $Za=array_keys($n);
                preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~', $sc, $Gd);
                $oa=count($Gd[0]);
                $k->begin();
                $Nf=($_POST["separator"]=="csv"?",":($_POST["separator"]=="tsv"?"\t":";"));
                $M=array();
                foreach ($Gd[0]as$z=>$X) {
                    preg_match_all("~((?>\"[^\"]*\")+|[^$Nf]*)$Nf~", $X.$Nf, $Hd);
                    if (!$z&&!array_diff($Hd[1], $Za)) {
                        $Za=$Hd[1];
                        $oa--;
                    } else {
                        $P=array();
                        foreach ($Hd[1]as$t=>$Va) {
                            $P[idf_escape($Za[$t])]=($Va==""&&$n[$Za[$t]]["null"]?"NULL":q(str_replace('""', '"', preg_replace('~^"|"$~', '', $Va))));
                        }
                        $M[]=$P;
                    }
                }
                $J=(!$M||$k->insertUpdate($a, $M, $bf));
                if ($J) {
                    $J=$k->commit();
                }
                queries_redirect(remove_from_uri("page"), lang(234, $oa), $J);
                $k->rollback();
            }
        }
    }
    $qg=$b->tableName($R);
    if (is_ajax()) {
        page_headers();
        ob_start();
    } else {
        page_header(lang(49).": $qg", $l);
    }
    $P=null;
    if (isset($_f["insert"])||!support("table")) {
        $P="";
        foreach ((array)$_GET["where"]as$X) {
            if ($p[$X["col"]]&&count($p[$X["col"]])==1&&($X["op"]=="="||(!$X["op"]&&!preg_match('~[_%]~', $X["val"])))) {
                $P.="&set".urlencode("[".bracket_escape($X["col"])."]")."=".urlencode($X["val"]);
            }
        }
    }
    $b->selectLinks($R, $P);
    if (!$d&&support("table")) {
        echo"<p class='error'>".lang(235).($n?".":": ".error())."\n";
    } else {
        echo"<form action='' id='form'>\n","<div style='display: none;'>";
        hidden_fields_get();
        echo(DB!=""?'<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET["ns"])?'<input type="hidden" name="ns" value="'.h($_GET["ns"]).'">':""):"");
        echo'<input type="hidden" name="select" value="'.h($a).'">',"</div>\n";
        $b->selectColumnsPrint($N, $d);
        $b->selectSearchPrint($Z, $d, $x);
        $b->selectOrderPrint($we, $d, $x);
        $b->selectLimitPrint($_);
        $b->selectLengthPrint($Bg);
        $b->selectActionPrint($x);
        echo"</form>\n";
        $F=$_GET["page"];
        if ($F=="last") {
            $Bc=$f->result(count_rows($a, $Z, $hd, $s));
            $F=floor(max(0, $Bc-1)/$_);
        }
        $If=$N;
        $Gc=$s;
        if (!$If) {
            $If[]="*";
            $jb=convert_fields($d, $n, $N);
            if ($jb) {
                $If[]=substr($jb, 2);
            }
        }
        foreach ($N
as$z=>$X) {
            $m=$n[idf_unescape($X)];
            if ($m&&($va=convert_field($m))) {
                $If[$z]="$va AS $X";
            }
        }
        if (!$hd&&$ch) {
            foreach ($ch
as$z=>$X) {
                $If[]=idf_escape($z);
                if ($Gc) {
                    $Gc[]=idf_escape($z);
                }
            }
        }
        $J=$k->select($a, $If, $Z, $Gc, $we, $_, $F, true);
        if (!$J) {
            echo"<p class='error'>".error()."\n";
        } else {
            if ($y=="mssql"&&$F) {
                $J->seek($_*$F);
            }
            $Wb=array();
            echo"<form action='' method='post' enctype='multipart/form-data'>\n";
            $M=array();
            while ($L=$J->fetch_assoc()) {
                if ($F&&$y=="oracle") {
                    unset($L["RNUM"]);
                }
                $M[]=$L;
            }
            if ($_GET["page"]!="last"&&$_!=""&&$s&&$hd&&$y=="sql") {
                $Bc=$f->result(" SELECT FOUND_ROWS()");
            }
            if (!$M) {
                echo"<p class='message'>".lang(12)."\n";
            } else {
                $Ca=$b->backwardKeys($a, $qg);
                echo"<div class='scrollable'>","<table id='table' cellspacing='0' class='nowrap checkable'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),"<thead><tr>".(!$s&&$N?"":"<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);", "")." <a href='".h($_GET["modify"]?remove_from_uri("modify"):$_SERVER["REQUEST_URI"]."&modify=1")."'>".lang(236)."</a>");
                $Xd=array();
                $Dc=array();
                reset($N);
                $nf=1;
                foreach ($M[0]as$z=>$X) {
                    if (!isset($ch[$z])) {
                        $X=$_GET["columns"][key($N)];
                        $m=$n[$N?($X?$X["col"]:current($N)):$z];
                        $E=($m?$b->fieldName($m, $nf):($X["fun"]?"*":$z));
                        if ($E!="") {
                            $nf++;
                            $Xd[$z]=$E;
                            $c=idf_escape($z);
                            $Tc=remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($z);
                            $Cb="&desc%5B0%5D=1";
                            echo"<th>".script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});", ""),'<a href="'.h($Tc.($we[0]==$c||$we[0]==$z||(!$we&&$hd&&$s[0]==$c)?$Cb:'')).'">';
                            echo
apply_sql_function($X["fun"], $E)."</a>";
                            echo"<span class='column hidden'>","<a href='".h($Tc.$Cb)."' title='".lang(55)."' class='text'> ↓</a>";
                            if (!$X["fun"]) {
                                echo'<a href="#fieldset-search" title="'.lang(52).'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($z)."');");
                            }
                            echo"</span>";
                        }
                        $Dc[$z]=$X["fun"];
                        next($N);
                    }
                }
                $_d=array();
                if ($_GET["modify"]) {
                    foreach ($M
as$L) {
                        foreach ($L
as$z=>$X) {
                            $_d[$z]=max($_d[$z], min(40, strlen(utf8_decode($X))));
                        }
                    }
                }
                echo($Ca?"<th>".lang(237):"")."</thead>\n";
                if (is_ajax()) {
                    if ($_%2==1&&$F%2==1) {
                        odd();
                    }
                    ob_end_clean();
                }
                foreach ($b->rowDescriptions($M, $p)as$Wd=>$L) {
                    $Zg=unique_array($M[$Wd], $x);
                    if (!$Zg) {
                        $Zg=array();
                        foreach ($M[$Wd]as$z=>$X) {
                            if (!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~', $z)) {
                                $Zg[$z]=$X;
                            }
                        }
                    }
                    $ah="";
                    foreach ($Zg
as$z=>$X) {
                        if (($y=="sql"||$y=="pgsql")&&preg_match('~char|text|enum|set~', $n[$z]["type"])&&strlen($X)>64) {
                            $z=(strpos($z, '(')?$z:idf_escape($z));
                            $z="MD5(".($y!='sql'||preg_match("~^utf8~", $n[$z]["collation"])?$z:"CONVERT($z USING ".charset($f).")").")";
                            $X=md5($X);
                        }
                        $ah.="&".($X!==null?urlencode("where[".bracket_escape($z)."]")."=".urlencode($X):"null%5B%5D=".urlencode($z));
                    }
                    echo"<tr".odd().">".(!$s&&$N?"":"<td>".checkbox("check[]", substr($ah, 1), in_array(substr($ah, 1), (array)$_POST["check"])).($hd||information_schema(DB)?"":" <a href='".h(ME."edit=".urlencode($a).$ah)."' class='edit'>".lang(238)."</a>"));
                    foreach ($L
as$z=>$X) {
                        if (isset($Xd[$z])) {
                            $m=$n[$z];
                            $X=$k->value($X, $m);
                            if ($X!=""&&(!isset($Wb[$z])||$Wb[$z]!="")) {
                                $Wb[$z]=(is_mail($X)?$Xd[$z]:"");
                            }
                            $A="";
                            if (preg_match('~blob|bytea|raw|file~', $m["type"])&&$X!="") {
                                $A=ME.'download='.urlencode($a).'&field='.urlencode($z).$ah;
                            }
                            if (!$A&&$X!==null) {
                                foreach ((array)$p[$z]as$o) {
                                    if (count($p[$z])==1||end($o["source"])==$z) {
                                        $A="";
                                        foreach ($o["source"]as$t=>$Xf) {
                                            $A.=where_link($t, $o["target"][$t], $M[$Wd][$Xf]);
                                        }
                                        $A=($o["db"]!=""?preg_replace('~([?&]db=)[^&]+~', '\1'.urlencode($o["db"]), ME):ME).'select='.urlencode($o["table"]).$A;
                                        if ($o["ns"]) {
                                            $A=preg_replace('~([?&]ns=)[^&]+~', '\1'.urlencode($o["ns"]), $A);
                                        }
                                        if (count($o["source"])==1) {
                                            break;
                                        }
                                    }
                                }
                            }
                            if ($z=="COUNT(*)") {
                                $A=ME."select=".urlencode($a);
                                $t=0;
                                foreach ((array)$_GET["where"]as$W) {
                                    if (!array_key_exists($W["col"], $Zg)) {
                                        $A.=where_link($t++, $W["col"], $W["val"], $W["op"]);
                                    }
                                }
                                foreach ($Zg
as$ld=>$W) {
                                    $A.=where_link($t++, $ld, $W);
                                }
                            }
                            $X=select_value($X, $A, $m, $Bg);
                            $u=h("val[$ah][".bracket_escape($z)."]");
                            $Y=$_POST["val"][$ah][bracket_escape($z)];
                            $Rb=!is_array($L[$z])&&is_utf8($X)&&$M[$Wd][$z]==$L[$z]&&!$Dc[$z];
                            $Ag=preg_match('~text|lob~', $m["type"]);
                            echo"<td id='$u'";
                            if (($_GET["modify"]&&$Rb)||$Y!==null) {
                                $Kc=h($Y!==null?$Y:$L[$z]);
                                echo">".($Ag?"<textarea name='$u' cols='30' rows='".(substr_count($L[$z], "\n")+1)."'>$Kc</textarea>":"<input name='$u' value='$Kc' size='$_d[$z]'>");
                            } else {
                                $Dd=strpos($X, "<i>…</i>");
                                echo" data-text='".($Dd?2:($Ag?1:0))."'".($Rb?"":" data-warning='".h(lang(239))."'").">$X</td>";
                            }
                        }
                    }
                    if ($Ca) {
                        echo"<td>";
                    }
                    $b->backwardKeysPrint($Ca, $M[$Wd]);
                    echo"</tr>\n";
                }
                if (is_ajax()) {
                    exit;
                }
                echo"</table>\n","</div>\n";
            }
            if (!is_ajax()) {
                if ($M||$F) {
                    $gc=true;
                    if ($_GET["page"]!="last") {
                        if ($_==""||(count($M)<$_&&($M||!$F))) {
                            $Bc=($F?$F*$_:0)+count($M);
                        } elseif ($y!="sql"||!$hd) {
                            $Bc=($hd?false:found_rows($R, $Z));
                            if ($Bc<max(1e4, 2*($F+1)*$_)) {
                                $Bc=reset(slow_query(count_rows($a, $Z, $hd, $s)));
                            } else {
                                $gc=false;
                            }
                        }
                    }
                    $He=($_!=""&&($Bc===false||$Bc>$_||$F));
                    if ($He) {
                        echo(($Bc===false?count($M)+1:$Bc-$F*$_)>$_?'<p><a href="'.h(remove_from_uri("page")."&page=".($F+1)).'" class="loadmore">'.lang(240).'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$_).", '".lang(241)."…');", ""):''),"\n";
                    }
                }
                echo"<div class='footer'><div>\n";
                if ($M||$F) {
                    if ($He) {
                        $Jd=($Bc===false?$F+(count($M)>=$_?2:1):floor(($Bc-1)/$_));
                        echo"<fieldset>";
                        if ($y!="simpledb") {
                            echo"<legend><a href='".h(remove_from_uri("page"))."'>".lang(242)."</a></legend>",script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".lang(242)."', '".($F+1)."')); return false; };"),pagination(0, $F).($F>5?" …":"");
                            for ($t=max(1, $F-4);$t<min($Jd, $F+5);$t++) {
                                echo
pagination($t, $F);
                            }
                            if ($Jd>0) {
                                echo($F+5<$Jd?" …":""),($gc&&$Bc!==false?pagination($Jd, $F):" <a href='".h(remove_from_uri("page")."&page=last")."' title='~$Jd'>".lang(243)."</a>");
                            }
                        } else {
                            echo"<legend>".lang(242)."</legend>",pagination(0, $F).($F>1?" …":""),($F?pagination($F, $F):""),($Jd>$F?pagination($F+1, $F).($Jd>$F+1?" …":""):"");
                        }
                        echo"</fieldset>\n";
                    }
                    echo"<fieldset>","<legend>".lang(244)."</legend>";
                    $Hb=($gc?"":"~ ").$Bc;
                    echo
checkbox("all", 1, 0, ($Bc!==false?($gc?"":"~ ").lang(143, $Bc):""), "var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$Hb' : checked); selectCount('selected2', this.checked || !checked ? '$Hb' : checked);")."\n","</fieldset>\n";
                    if ($b->selectCommandPrint()) {
                        echo'<fieldset',($_GET["modify"]?'':' class="jsonly"'),'><legend>',lang(236),'</legend><div>
<input type="submit" value="',lang(14),'"',($_GET["modify"]?'':' title="'.lang(232).'"'),'>
</div></fieldset>
<fieldset><legend>',lang(120),' <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="',lang(10),'">
<input type="submit" name="clone" value="',lang(228),'">
<input type="submit" name="delete" value="',lang(18),'">',confirm(),'</div></fieldset>
';
                    }
                    $_c=$b->dumpFormat();
                    foreach ((array)$_GET["columns"]as$c) {
                        if ($c["fun"]) {
                            unset($_c['sql']);
                            break;
                        }
                    }
                    if ($_c) {
                        print_fieldset("export", lang(69)." <span id='selected2'></span>");
                        $Fe=$b->dumpOutput();
                        echo($Fe?html_select("output", $Fe, $na["output"])." ":""),html_select("format", $_c, $na["format"])," <input type='submit' name='export' value='".lang(69)."'>\n","</div></fieldset>\n";
                    }
                    $b->selectEmailPrint(array_filter($Wb, 'strlen'), $d);
                }
                echo"</div></div>\n";
                if ($b->selectImportPrint()) {
                    echo"<div>","<a href='#import'>".lang(68)."</a>",script("qsl('a').onclick = partial(toggle, 'import');", ""),"<span id='import' class='hidden'>: ","<input type='file' name='csv_file'> ",html_select("separator", array("csv"=>"CSV,","csv;"=>"CSV;","tsv"=>"TSV"), $na["format"], 1);
                    echo" <input type='submit' name='import' value='".lang(68)."'>","</span>","</div>";
                }
                echo"<input type='hidden' name='token' value='$T'>\n","</form>\n",(!$s&&$N?"":script("tableCheck();"));
            }
        }
    }
    if (is_ajax()) {
        ob_end_clean();
        exit;
    }
} elseif (isset($_GET["variables"])) {
    $eg=isset($_GET["status"]);
    page_header($eg?lang(112):lang(111));
    $oh=($eg?show_status():show_variables());
    if (!$oh) {
        echo"<p class='message'>".lang(12)."\n";
    } else {
        echo"<table cellspacing='0'>\n";
        foreach ($oh
as$z=>$X) {
            echo"<tr>","<th><code class='jush-".$y.($eg?"status":"set")."'>".h($z)."</code>","<td>".h($X);
        }
        echo"</table>\n";
    }
} elseif (isset($_GET["script"])) {
    header("Content-Type: text/javascript; charset=utf-8");
    if ($_GET["script"]=="db") {
        $ng=array("Data_length"=>0,"Index_length"=>0,"Data_free"=>0);
        foreach (table_status()as$E=>$R) {
            json_row("Comment-$E", h($R["Comment"]));
            if (!is_view($R)) {
                foreach (array("Engine","Collation")as$z) {
                    json_row("$z-$E", h($R[$z]));
                }
                foreach ($ng+array("Auto_increment"=>0,"Rows"=>0)as$z=>$X) {
                    if ($R[$z]!="") {
                        $X=format_number($R[$z]);
                        json_row("$z-$E", ($z=="Rows"&&$X&&$R["Engine"]==($Zf=="pgsql"?"table":"InnoDB")?"~ $X":$X));
                        if (isset($ng[$z])) {
                            $ng[$z]+=($R["Engine"]!="InnoDB"||$z!="Data_free"?$R[$z]:0);
                        }
                    } elseif (array_key_exists($z, $R)) {
                        json_row("$z-$E");
                    }
                }
            }
        }
        foreach ($ng
as$z=>$X) {
            json_row("sum-$z", format_number($X));
        }
        json_row("");
    } elseif ($_GET["script"]=="kill") {
        $f->query("KILL ".number($_POST["kill"]));
    } else {
        foreach (count_tables($b->databases())as$j=>$X) {
            json_row("tables-$j", $X);
            json_row("size-$j", db_size($j));
        }
        json_row("");
    }
    exit;
} else {
    $vg=array_merge((array)$_POST["tables"], (array)$_POST["views"]);
    if ($vg&&!$l&&!$_POST["search"]) {
        $J=true;
        $D="";
        if ($y=="sql"&&$_POST["tables"]&&count($_POST["tables"])>1&&($_POST["drop"]||$_POST["truncate"]||$_POST["copy"])) {
            queries("SET foreign_key_checks = 0");
        }
        if ($_POST["truncate"]) {
            if ($_POST["tables"]) {
                $J=truncate_tables($_POST["tables"]);
            }
            $D=lang(245);
        } elseif ($_POST["move"]) {
            $J=move_tables((array)$_POST["tables"], (array)$_POST["views"], $_POST["target"]);
            $D=lang(246);
        } elseif ($_POST["copy"]) {
            $J=copy_tables((array)$_POST["tables"], (array)$_POST["views"], $_POST["target"]);
            $D=lang(247);
        } elseif ($_POST["drop"]) {
            if ($_POST["views"]) {
                $J=drop_views($_POST["views"]);
            }
            if ($J&&$_POST["tables"]) {
                $J=drop_tables($_POST["tables"]);
            }
            $D=lang(248);
        } elseif ($y!="sql") {
            $J=($y=="sqlite"?queries("VACUUM"):apply_queries("VACUUM".($_POST["optimize"]?"":" ANALYZE"), $_POST["tables"]));
            $D=lang(249);
        } elseif (!$_POST["tables"]) {
            $D=lang(9);
        } elseif ($J=queries(($_POST["optimize"]?"OPTIMIZE":($_POST["check"]?"CHECK":($_POST["repair"]?"REPAIR":"ANALYZE")))." TABLE ".implode(", ", array_map('idf_escape', $_POST["tables"])))) {
            while ($L=$J->fetch_assoc()) {
                $D.="<b>".h($L["Table"])."</b>: ".h($L["Msg_text"])."<br>";
            }
        }
        queries_redirect(substr(ME, 0, -1), $D, $J);
    }
    page_header(($_GET["ns"]==""?lang(33).": ".h(DB):lang(189).": ".h($_GET["ns"])), $l, true);
    if ($b->homepage()) {
        if ($_GET["ns"]!=="") {
            echo"<h3 id='tables-views'>".lang(250)."</h3>\n";
            $ug=tables_list();
            if (!$ug) {
                echo"<p class='message'>".lang(9)."\n";
            } else {
                echo"<form action='' method='post'>\n";
                if (support("table")) {
                    echo"<fieldset><legend>".lang(251)." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST["query"])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');", "")," <input type='submit' name='search' value='".lang(52)."'>\n","</div></fieldset>\n";
                    if ($_POST["search"]&&$_POST["query"]!="") {
                        $_GET["where"][0]["op"]="LIKE %%";
                        search_tables();
                    }
                }
                echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);", ""),'<th>'.lang(124),'<td>'.lang(252).doc_link(array('sql'=>'storage-engines.html')),'<td>'.lang(116).doc_link(array('sql'=>'charset-charsets.html','mariadb'=>'supported-character-sets-and-collations/')),'<td>'.lang(253).doc_link(array('sql'=>'show-table-status.html',)),'<td>'.lang(254).doc_link(array('sql'=>'show-table-status.html',)),'<td>'.lang(255).doc_link(array('sql'=>'show-table-status.html')),'<td>'.lang(47).doc_link(array('sql'=>'example-auto-increment.html','mariadb'=>'auto_increment/')),'<td>'.lang(256).doc_link(array('sql'=>'show-table-status.html',)),(support("comment")?'<td>'.lang(46).doc_link(array('sql'=>'show-table-status.html',)):''),"</thead>\n";
                $S=0;
                foreach ($ug
as$E=>$U) {
                    $rh=($U!==null&&!preg_match('~table~i', $U));
                    $u=h("Table-".$E);
                    echo'<tr'.odd().'><td>'.checkbox(($rh?"views[]":"tables[]"), $E, in_array($E, $vg, true), "", "", "", $u),'<th>'.(support("table")||support("indexes")?"<a href='".h(ME)."table=".urlencode($E)."' title='".lang(38)."' id='$u'>".h($E).'</a>':h($E));
                    if ($rh) {
                        echo'<td colspan="6"><a href="'.h(ME)."view=".urlencode($E).'" title="'.lang(39).'">'.(preg_match('~materialized~i', $U)?lang(122):lang(123)).'</a>','<td align="right"><a href="'.h(ME)."select=".urlencode($E).'" title="'.lang(37).'">?</a>';
                    } else {
                        foreach (array("Engine"=>array(),"Collation"=>array(),"Data_length"=>array("create",lang(40)),"Index_length"=>array("indexes",lang(126)),"Data_free"=>array("edit",lang(41)),"Auto_increment"=>array("auto_increment=1&create",lang(40)),"Rows"=>array("select",lang(37)),)as$z=>$A) {
                            $u=" id='$z-".h($E)."'";
                            echo($A?"<td align='right'>".(support("table")||$z=="Rows"||(support("indexes")&&$z!="Data_length")?"<a href='".h(ME."$A[0]=").urlencode($E)."'$u title='$A[1]'>?</a>":"<span$u>?</span>"):"<td id='$z-".h($E)."'>");
                        }
                        $S++;
                    }
                    echo(support("comment")?"<td id='Comment-".h($E)."'>":"");
                }
                echo"<tr><td><th>".lang(229, count($ug)),"<td>".h($y=="sql"?$f->result("SELECT @@storage_engine"):""),"<td>".h(db_collation(DB, collations()));
                foreach (array("Data_length","Index_length","Data_free")as$z) {
                    echo"<td align='right' id='sum-$z'>";
                }
                echo"</table>\n","</div>\n";
                if (!information_schema(DB)) {
                    echo"<div class='footer'><div>\n";
                    $mh="<input type='submit' value='".lang(257)."'> ".on_help("'VACUUM'");
                    $te="<input type='submit' name='optimize' value='".lang(258)."'> ".on_help($y=="sql"?"'OPTIMIZE TABLE'":"'VACUUM OPTIMIZE'");
                    echo"<fieldset><legend>".lang(120)." <span id='selected'></span></legend><div>".($y=="sqlite"?$mh:($y=="pgsql"?$mh.$te:($y=="sql"?"<input type='submit' value='".lang(259)."'> ".on_help("'ANALYZE TABLE'").$te."<input type='submit' name='check' value='".lang(260)."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".lang(261)."'> ".on_help("'REPAIR TABLE'"):"")))."<input type='submit' name='truncate' value='".lang(262)."'> ".on_help($y=="sqlite"?"'DELETE'":"'TRUNCATE".($y=="pgsql"?"'":" TABLE'")).confirm()."<input type='submit' name='drop' value='".lang(121)."'>".on_help("'DROP TABLE'").confirm()."\n";
                    $i=(support("scheme")?$b->schemas():$b->databases());
                    if (count($i)!=1&&$y!="sqlite") {
                        $j=(isset($_POST["target"])?$_POST["target"]:(support("scheme")?$_GET["ns"]:DB));
                        echo"<p>".lang(263).": ",($i?html_select("target", $i, $j):'<input name="target" value="'.h($j).'" autocapitalize="off">')," <input type='submit' name='move' value='".lang(264)."'>",(support("copy")?" <input type='submit' name='copy' value='".lang(265)."'> ".checkbox("overwrite", 1, $_POST["overwrite"], lang(266)):""),"\n";
                    }
                    echo"<input type='hidden' name='all' value=''>";
                    echo
script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support("table")?" selectCount('selected2', formChecked(this, /^tables\[/) || $S);":"")." }"),"<input type='hidden' name='token' value='$T'>\n","</div></fieldset>\n","</div></div>\n";
                }
                echo"</form>\n",script("tableCheck();");
            }
            echo'<p class="links"><a href="'.h(ME).'create=">'.lang(70)."</a>\n",(support("view")?'<a href="'.h(ME).'view=">'.lang(195)."</a>\n":"");
            if (support("routine")) {
                echo"<h3 id='routines'>".lang(136)."</h3>\n";
                $Df=routines();
                if ($Df) {
                    echo"<table cellspacing='0'>\n",'<thead><tr><th>'.lang(176).'<td>'.lang(45).'<td>'.lang(212)."<td></thead>\n";
                    odd('');
                    foreach ($Df
as$L) {
                        $E=($L["SPECIFIC_NAME"]==$L["ROUTINE_NAME"]?"":"&name=".urlencode($L["ROUTINE_NAME"]));
                        echo'<tr'.odd().'>','<th><a href="'.h(ME.($L["ROUTINE_TYPE"]!="PROCEDURE"?'callf=':'call=').urlencode($L["SPECIFIC_NAME"]).$E).'">'.h($L["ROUTINE_NAME"]).'</a>','<td>'.h($L["ROUTINE_TYPE"]),'<td>'.h($L["DTD_IDENTIFIER"]),'<td><a href="'.h(ME.($L["ROUTINE_TYPE"]!="PROCEDURE"?'function=':'procedure=').urlencode($L["SPECIFIC_NAME"]).$E).'">'.lang(129)."</a>";
                    }
                    echo"</table>\n";
                }
                echo'<p class="links">'.(support("procedure")?'<a href="'.h(ME).'procedure=">'.lang(211).'</a>':'').'<a href="'.h(ME).'function=">'.lang(210)."</a>\n";
            }
            if (support("event")) {
                echo"<h3 id='events'>".lang(137)."</h3>\n";
                $M=get_rows("SHOW EVENTS");
                if ($M) {
                    echo"<table cellspacing='0'>\n","<thead><tr><th>".lang(176)."<td>".lang(267)."<td>".lang(201)."<td>".lang(202)."<td></thead>\n";
                    foreach ($M
as$L) {
                        echo"<tr>","<th>".h($L["Name"]),"<td>".($L["Execute at"]?lang(268)."<td>".$L["Execute at"]:lang(203)." ".$L["Interval value"]." ".$L["Interval field"]."<td>$L[Starts]"),"<td>$L[Ends]",'<td><a href="'.h(ME).'event='.urlencode($L["Name"]).'">'.lang(129).'</a>';
                    }
                    echo"</table>\n";
                    $ec=$f->result("SELECT @@event_scheduler");
                    if ($ec&&$ec!="ON") {
                        echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($ec)."\n";
                    }
                }
                echo'<p class="links"><a href="'.h(ME).'event=">'.lang(200)."</a>\n";
            }
            if ($ug) {
                echo
script("ajaxSetHtml('".js_escape(ME)."script=db');");
            }
        }
    }
}page_footer();
