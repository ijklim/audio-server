<?php

/**
 * This is the file path class.
 *
 * It's responsible for file or directory related operations.
 */
class FilePath
{
    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath;
    protected $baseName;
    protected $dirName;
    protected $fileName;

    /**
     * Create a new file path instance.
     *
     * @param string $filePath
     *
     * @return void
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        $this->baseName = pathinfo($filePath, PATHINFO_BASENAME);
        $this->dirName = pathinfo($filePath, PATHINFO_DIRNAME);
        $this->fileName = pathinfo($filePath, PATHINFO_FILENAME);
    }



    /**
     * . and .. should be ignored in most cases.
     *
     * @return boolean
     */
    public function shouldIgnore()
    {
        return ($this->baseName === '.' || $this->baseName === '..');
    }

    /**
     * File or directory name starting with _ is considered restricted.
     *
     * @return boolean
     */
    public function isRestricted()
    {
        return ($this->baseName)[0] === '_';
    }

    /**
     * Check if file path is a directory.
     *
     * @return boolean
     */
    public function isDirectory()
    {
        return is_dir($this->filePath);
    }

    /**
     * Check if file is an actual file and has an audio extension that this system can process.
     *
     * @return boolean
     */
    public function isAcceptableAudioFile()
    {
        return (is_file($this->filePath) && strtolower(substr($this->filePath, -4)) === '.mp3');
    }

    /**
     * Name file ends in .name.
     *
     * @return boolean
     */
    public function isAudioTypeNameFile()
    {
        return (is_file($this->filePath) && strtolower(substr($this->filePath, -5)) === '.name');
    }



    /**
     * Retrieve protected attribute value.
     *
     * @param string $field
     * 
     * @return string
     */
    public function __get($field)
    {
        switch ($field) {
            case 'displayName':
                return $this->formatForDisplay($this->fileName);
                break;
            case 'displayDirectoryName':
                if ($this->isDirectory()) {
                    return $this->formatForDisplay($this->fileName);
                } else {
                    return $this->dirName;
                }
                break;
            default:
                return $this->$field;
                break;
        }
    }

    /**
     * Remove - from $name.
     *
     * @param string $name
     * 
     * @return string
     */
    private function formatForDisplay($name)
    {
        return str_replace('-', ' ', $name);
    }



    /**
     * Print file path class properties.
     *
     * @return string
     */
    public function __toString()
    {
        return 'File path: ' . $this->filePath . '<br>' .
               'Base name: ' . $this->baseName . '<br>' .
               'File name: ' . $this->fileName . '<br>';
    }
}