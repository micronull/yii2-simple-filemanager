<?php
/**
 * Created by PhpStorm.
 * User: Stepan Ipatyev
 * Date: 19.01.18
 * Time: 15:03
 */

namespace DeLuxis\Yii2SimpleFilemanager\models;


use yii\base\Model;

/**
 * Class DirectoryForm
 * @package DeLuxis\Yii2SimpleFilemanager\models
 * @property Directory $directory
 */
class DirectoryForm extends Model
{
    const SCENARIO_RENAME = 'rename';

    public $name;
    public $newName;
    public $path;

    /**
     * @var Directory
     */
    private $_directory;

    public function rules()
    {
        return [
            [['name', 'path'], 'required'],
            ['name', 'match', 'pattern' => '/\//', 'not' => true],
            ['path', 'match', 'pattern' => '/\.\.\//', 'not' => true],

            ['newName', 'required', 'on' => self::SCENARIO_RENAME],
            ['newName', 'match', 'pattern' => '/\//', 'not' => true, 'on' => self::SCENARIO_RENAME],
            ['newName', 'compare', 'compareAttribute' => 'name', 'operator' => '!=']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => \Yii::t('filemanager', 'Name'),
            'newName' => \Yii::t('filemanager', 'New name'),
            'path' => \Yii::t('filemanager', 'Path')
        ];
    }

    public function save()
    {
        if ($this->scenario == self::SCENARIO_RENAME)
            return $this->rename();

        return mkdir($this->directory->fullPath . $this->name, 0755, true);
    }

    public function rename()
    {
        return rename($this->directory->fullPath . $this->name, $this->directory->fullPath . $this->newName);
    }

    /**
     * @return Directory
     */
    public function getDirectory()
    {
        if ( ! isset($this->_directory)) {
            $this->_directory = Directory::createByPath($this->path);
        }

        return $this->_directory;
    }
}