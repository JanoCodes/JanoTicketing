<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2018 Andrew Ying and other contributors.
 *
 * This file is part of Jano Ticketing System.
 *
 * Jano Ticketing System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v3.0 as
 * published by the Free Software Foundation. You must preserve all legal
 * notices and author attributions present.
 *
 * Jano Ticketing System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Jano\Composer;

use function array_key_exists;
use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

class PackageInstaller extends LibraryInstaller
{
    protected $locations = array(
        'module' => 'modules/{$name}/',
    );

    /**
     * Convert string to camel case.
     *
     * @param $string
     * @param bool $capitalizeFirstCharacter
     * @return string
     */
    private function camelCase($string, $capitalizeFirstCharacter = false)
    {

        $str = str_replace('-', '', ucwords($string, '-'));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }

    /**
     * Return type of package
     *
     * @param string $type
     * @return bool|string
     */
    private function getPackageType($type)
    {
        if (!preg_match('/jano-([A-Za-z]+)/', $type, $matches)) {
            return false;
        }

        return $matches[1];
    }

    /**
     * {@inheritdoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        $type = $package->getType();

        $prettyName = $package->getPrettyName();
        if (strpos($prettyName, '/') !== false) {
            list($vendor, $name) = explode('/', $prettyName);
        } else {
            $vendor = '';
            $name = $prettyName;
        }

        $availableVars = $this->inflectPackageVars(compact('name', 'vendor', 'type'));

        $packageType = $this->getPackageType($type);

        if (!array_key_exists($packageType, $this->locations)) {
            throw new \InvalidArgumentException(
                'Sorry the package type of this package is not yet supported.'
            );
        }

        return $this->templatePath($this->locations[$packageType], $availableVars);
    }

    /**
     * Replace vars in a path
     *
     * @param  string $path
     * @param  array  $vars
     * @return string
     */
    protected function templatePath($path, array $vars = array())
    {
        if (strpos($path, '{') !== false) {
            extract($vars);
            preg_match_all('@\{\$([A-Za-z0-9_]*)\}@i', $path, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $var) {
                    $path = str_replace('{$' . $var . '}', $$var, $path);
                }
            }
        }

        return $path;
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::uninstall($repo, $package);
        $installPath = $this->getPackageBasePath($package);
        $this->io->write(sprintf('Deleting %s - %s', $installPath, !file_exists($installPath) ?
            '<comment>deleted</comment>' : '<error>not deleted</error>'));
    }

    /**
     * {@inheritdoc}
     */
    public function supports($packageType)
    {
        return $this->getPackageType($packageType) !== false;
    }

    /**
     * Format package name.
     *
     * @param array $vars
     */
    public function inflectPackageVars($vars)
    {
        $vars['name'] = $this->camelCase($vars['name'], true);
    }
}