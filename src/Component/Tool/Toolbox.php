<?php
/**
* @file toolbox.php
* @author ligang
* @date 2015-08-20
 */

namespace Vine\Component\Tool;

/**
    * General tool function
 */
class Toolbox
{/*{{{*/

    /**
        * Run shell script
        *
        * @param string $script
        * @param array $params
        * @param bool $fetchOutput
        *
        * @return array
     */
    public static function runShellScript($script, $params = array(), $fetchOutput = false)
    {/*{{{*/
        $params = implode(' ', $params);
        $cmd    = "$script $params";
        return self::runShellCmd($cmd, $fetchOutput);
    }/*}}}*/

    /**
        * Run shell cmd
        *
        * @param string $cmd
        * @param bool $fetchOutput
        *
        * @return array
     */
    public static function runShellCmd($cmd, $fetchOutput = false)
    {/*{{{*/
        $returnVar = 0;
        $lastLine  = '';
        $output    = '';

        ob_start();
        $lastLine  = system($cmd, $returnVar);
        $cmdOutput = ob_get_clean();

        if ($fetchOutput) {
            $output = $cmdOutput;
        } else {
            echo $cmdOutput;
        }

        return array(
            'return_var' => $returnVar,
            'last_line'  => $lastLine,
            'output'     => $output,
        );
    }/*}}}*/

    /**
        * Get params value which defined in shellScript
        *
        * @param string $shellScript
        * @param array $paramsMap
        *
        * @return array
     */
    public static function getParamsFromShellScript($shellScript, $paramsMap)
    {/*{{{*/
        $cmd = "source $shellScript; ";
        foreach ($paramsMap as $key => $value) {
            $cmd.= 'echo $'.$value.'; ';
        }

        $result = self::runShellCmd($cmd, true);
        $output = explode("\n", $result['output']);

        $result = array();
        $i      = 0;
        foreach ($paramsMap as $key => $value) {
            $result[$key] = $output[$i];
            $i++;
        }

        return $result;
    }/*}}}*/

    /**
        * Get request host ip
        *
        * @return string
     */
    public static function getIp()
    {/*{{{*/
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    }/*}}}*/

    /**
        * Get remote host port
        *
        * @return int
     */
    public static function getPort()
    {/*{{{*/
        return isset($_SERVER['REMOTE_PORT']) ? intval($_SERVER['REMOTE_PORT']) : 0;
    }/*}}}*/

    /**
        * Get request ua
        *
        * @return string
     */
    public static function getUa()
    {/*{{{*/
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }/*}}}*/

    /**
        * Get request queryString
        *
        * @return string
     */
    public static function getQueryString()
    {/*{{{*/
        return isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
    }/*}}}*/

    /**
        * Get request refer
        *
        * @return string
     */
    public static function getRefer()
    {/*{{{*/
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    }/*}}}*/

    /**
        * Get hostname of self
        *
        * @return string
     */
    public static function getHostname()
    {/*{{{*/
        $hostData = posix_uname();
        return $hostData['nodename'];
    }/*}}}*/

    /**
        * Get domain of self
        *
        * @return string
     */
    public static function getDomain()
    {/*{{{*/
        return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    }/*}}}*/

    /**
        * Do 302
        *
        * @param $url
        *
        * @return 
     */
    public static function jumpTo($url)
    {/*{{{*/
        header('location:'.$url);
        exit;
    }/*}}}*/

    /**
        * Get general now date
        *
        * @return string
     */
    public static function getNowDate()
    {/*{{{*/
        return date('Y-m-d H:i:s');
    }/*}}}*/

    /**
        * Avoid xss
        *
        * @param mixed $data
        * @param bool $needHtmlspecialchars
        *
        * @return mixed
     */
	public static function secureFilter($data, $needHtmlspecialchars = true)
	{/*{{{*/
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::secureFilter($value, $needHtmlspecialchars);
            }
        } else {
            $data = $needHtmlspecialchars ? htmlspecialchars($data) : strip_tags($data);
        }

        return $data;
	}/*}}}*/

    /**
        * Examine text file
        *
        * @param string $filePath
        *
        * @return bool
     */
	public static function isTextFile($filePath)
	{/*{{{*/
		$result = self::runShellCmd("file $filePath", true);
		return strpos($result['last_line'], 'text') === false ? false : true;
	}/*}}}*/

    /**
        * Get files from path recursively
        *
        * @param string $path
        * @param array $result
        * @param string $filterStr
        *
        * @return
     */
	public static function getFilesFromDirRecursively($dir, &$result, $filterStr = '')
	{/*{{{*/
		if (!is_dir($dir)) {
			return;
		}

        $dh = opendir($dir);
        if ($dh === false) {
            return;
        }

        while (($file = readdir($dh)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $path = "$dir/$file";
            if (is_dir($path)) {
                self::getFilesFromDirRecursively($path, $result, $filterStr);
            } else {
                $result[] = $filterStr == '' ? $path : str_replace($filterStr, '', $path);
            }
        }
	}/*}}}*/

    /**
        * Get file extension
        *
        * @param string $path
        *
        * @return string
     */
    public static function getFileExtension($path)
    {/*{{{*/
        $info = pathinfo($path);
        return $info['extension'];
    }/*}}}*/
}/*}}}*/
