<?php
/**
 * @file File.php
 * @author ligang
 * @version 1.0
 * @date 2015-08-04
 */

namespace Phpbox\Log\Writer;

/**
 * Write local file
 */
class File implements WriterInterface
{
    const SPLIT_NO      = 0;
    const SPLIT_BY_DAY  = 1;
    const SPLIT_BY_HOUR = 2;

    const DEF_COL_SPR = "\t";

    private $fileConf = array();
    private $handle   = null;


    public function __construct($filePath, $split = self::SPLIT_NO)
    {
        $suffix = $this->getFileSuffix($split);

        $this->fileConf = array(
            'split'     => $split,
            'suffix'    => $suffix,
            'path'      => $filePath,
            'real_path' => $this->getRealPath($filePath, $suffix),
        );

        $this->handle = fopen($this->fileConf['real_path'], 'a');
    }

    /**
     * {@inheritdoc}
     */
    public function write($message)
    {
        $suffix   = $this->getFileSuffix($this->fileConf['split']);
        $realPath = '';

        if ($suffix != $this->fileConf['suffix']) {
            $realPath                    = $this->getRealPath($this->fileConf['path'], $suffix);
            $this->fileConf['suffix']    = $suffix;
            $this->fileConf['real_path'] = $realPath;
        } else {
            $realPath = $this->fileConf['real_path'];
            fclose($this->handle);
            $this->handle = fopen($realPath, 'a');
        }

        flock($this->handle, LOCK_EX);
        fwrite($this->handle, $message);
        flock($this->handle, LOCK_UN);
    }


    private function getFileSuffix($split)
    {
        $suffix = '';

        switch ($split) {
            case self::SPLIT_BY_DAY:
                $suffix = date('Ymd');
                break;
            case self::SPLIT_BY_HOUR:
                $suffix = date('YmdH');
                break;
        }

        return $suffix;
    }

    private function getRealPath($filePath, $suffix)
    {
        if ($suffix != '') {
            $filePath .= '.' . $suffix;
        }

        return $filePath;
    }
}
