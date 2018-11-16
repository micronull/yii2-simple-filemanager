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

        $directoriesList = explode('/', $this->path);

        array_pop($directoriesList);

        $path = implode('/', $directoriesList);

        if (substr($path, 0, 1) != '/') {
            $path = '/' . $path;
        }

        return new Directory([
            'root' => $this->root,
            'path' => $path
        ]);
    }

    public function getBreadcrumbs($deactivateLast = true)
    {
        $breadcrumbs[] = [
            'label' => Yii::t('filemanager', 'File manager'),
            'url'   => ['default/index']
        ];

        if ($this->isRoot) {
            return $breadcrumbs;
        }

        $directoriesList = explode('/', $this->path);

        $currentPath = '';

        foreach ($directoriesList as $n => $directory) {
            if (!$directory)
                continue;

            if ( ! $deactivateLast || $n < count($directoriesList) - 1) {
                $currentPath .= '/' . $directory;

                $breadcrumbs[] = [
                    'label' => $directory,
                    'url'   => ['default/index', 'path' => $currentPath]
                ];
            } else {
                $breadcrumbs[] = $directory;
            }
        }

        return $breadcrumbs;
    }

    public function getIsRoot()
    {
        return $this->path === '/';
    }

    public function getIcon()
    {
        return SimpleFilemanagerModule::getInstance()->icons['dir'];
    }

    public function getList()
    {
        $path = $this->fullPath;

        if (substr($path, -1) != '/') {
            $path .= '/';
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

    /**
     * @param string $path
     *
     * @return Directory
     */
    public static function createByPath($path)
    {
        $directory       = new Directory();
        $directory->root = SimpleFilemanagerModule::getInstance()->fullUploadPath;

        if ($path) {
            if (substr($path, 0, 1) != '/') {
                $path = '/' . $path;
            }

            $directory->path = $path;
        }

        return $directory;
    }
}