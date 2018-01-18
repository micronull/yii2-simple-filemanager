<?php

namespace DeLuxis\Yii2SimpleFilemanager\models;

use Yii;
use DeLuxis\Yii2SimpleFilemanager\SimpleFilemanagerModule;
use yii\base\InvalidParamException;

/**
 * Class Directory
 * @package DeLuxis\Yii2SimpleFilemanager\models
 * @property array $list
 * @property boolean $isRoot
 * @property Directory|null $parent
 * @property array $breadcrumbs
 */
class Directory extends Item
{
    public function getParent()
    {
        if ($this->isRoot) {
            return null;
        }

        $directoriesList = explode(DIRECTORY_SEPARATOR, $this->path);

        array_pop($directoriesList);

        $path = implode(DIRECTORY_SEPARATOR, $directoriesList);

        if (substr($path, 0, 1) != DIRECTORY_SEPARATOR) {
            $path = DIRECTORY_SEPARATOR . $path;
        }

        return new Directory([
            'root' => $this->root,
            'path' => $path
        ]);
    }

    public function getBreadcrumbs()
    {
        $breadcrumbs = [];

        if ($this->isRoot)
            return $breadcrumbs;

        $directoriesList = explode(DIRECTORY_SEPARATOR, $this->path);

        $currentPath = '';

        foreach ($directoriesList as $n => $directory) {
            if (!$directory){
                $breadcrumbs[] = [
                    'label' => Yii::t('filemanager', 'File manager'),
                    'url' => ['index']
                ];
            } elseif ($n < count($directoriesList) - 1) {
                $currentPath .= DIRECTORY_SEPARATOR . $directory;

                $breadcrumbs[] = [
                    'label' => $directory,
                    'url' => ['index', 'path' => $currentPath]
                ];
            } else {
                $breadcrumbs[] = $directory;
            }
        }

        return $breadcrumbs;
    }

    public function getIsRoot()
    {
        return $this->path === DIRECTORY_SEPARATOR;
    }

    public function getIcon()
    {
        /**
         * @var SimpleFilemanagerModule $module
         */
        $module = \Yii::$app->getModule('filemanager');

        return $module->icons['dir'];
    }

    public function getList()
    {
        $path = $this->fullPath;

        if (substr($path, -1) != DIRECTORY_SEPARATOR) {
            $path .= DIRECTORY_SEPARATOR;
        }

        if ( ! is_dir($path)) {
            throw new InvalidParamException();
        }

        $items = glob($path . '*');

        $result = [];

        if (count($items)) {

            $directories = array_filter($items, 'is_dir');

            $directories = array_map(function ($directory) {
                return new Directory([
                    'root' => $this->root,
                    'path' => str_replace($this->root, '', $directory)
                ]);
            }, $directories);

            $files = array_filter($items, 'is_file');

            $files = array_map(function ($file) {
                return new File([
                    'root' => $this->root,
                    'path' => str_replace($this->root, '', $file)
                ]);
            }, $files);

            $result = array_merge($directories, $files);
        }

        if ( ! $this->isRoot) {
            array_unshift($result, (object)[
                'name' => '..',
                'path' => $this->parent->path,
                'icon' => 'fa-level-up'
            ]);
        }

        return $result;
    }
}