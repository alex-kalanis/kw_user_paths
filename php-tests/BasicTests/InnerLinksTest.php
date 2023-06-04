<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\PathsException;
use kalanis\kw_routed_paths\RoutedPath;
use kalanis\kw_routed_paths\Sources\Arrays;
use kalanis\kw_user_paths\InnerLinks;


class InnerLinksTest extends CommonTestClass
{
    /**
     * @param string[] $expected
     * @param string $module
     * @param string[] $startPath
     * @param bool $moreUsers
     * @param bool $moreLangs
     * @param string[] $prefixPath
     * @param bool $sysSeparator
     * @param bool $dataSeparator
     * @throws PathsException
     * @dataProvider modulePathsProvider
     */
    public function testModulePaths(array $expected, string $module, array $startPath, bool $moreUsers, bool $moreLangs, array $prefixPath, bool $sysSeparator, bool $dataSeparator): void
    {
        $lib = new InnerLinks(
            new RoutedPath(new Arrays(['user' => 'foo/him', 'lang' => 'baz'])),
            $moreUsers,
            $moreLangs,
            $prefixPath,
            $sysSeparator,
            $dataSeparator
        );
        $this->assertEquals($expected, $lib->toModulePath($module, $startPath));
    }

    public function modulePathsProvider(): array
    {
        return [
            [['dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, [], false, false],
            [['dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, [], false, true],
            [['modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, [], true, false],
            [['modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, [], true, true],
            [['prev', 'me', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, ['prev', 'me'], false, false],
            [['prev', 'me', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, ['prev', 'me'], false, true],

            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, ['prev', 'me'], true, false],
            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, ['prev', 'me'], true, true],
            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, ['prev', 'me'], true, true],
            [['dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, [], false, false],
            [['dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, [], false, true],

            [['modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, [], true, false],
            [['modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, [], true, true],
            [['prev', 'me', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, ['prev', 'me'], false, false],
            [['prev', 'me', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, ['prev', 'me'], false, true],
            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, ['prev', 'me'], true, false],

            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, ['prev', 'me'], true, true],
            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, ['prev', 'me'], true, true],
            [['dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, [], false, false],
            [['dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, [], false, true],
            [['modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, [], true, false],

            [['modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, [], true, true],
            [['prev', 'me', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, ['prev', 'me'], false, false],
            [['prev', 'me', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, ['prev', 'me'], false, true],
            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, ['prev', 'me'], true, false],
            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, ['prev', 'me'], true, true],

            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, ['prev', 'me'], true, true],
            [['dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, [], false, false],
            [['dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, [], false, true],
            [['modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, [], true, false],
            [['modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, [], true, true],

            [['prev', 'me', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, ['prev', 'me'], false, false],
            [['prev', 'me', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, ['prev', 'me'], false, true],
            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, ['prev', 'me'], true, false],
            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, ['prev', 'me'], true, true],
            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, ['prev', 'me'], true, true],

            [['dummy'], 'dummy', [], false, false, [], false, false],
            [['dummy'], 'dummy', [], false, false, [], false, true],
            [['modules', 'dummy'], 'dummy', [], false, false, [], true, false],
            [['prev', 'me', 'dummy'], 'dummy', [], false, false, ['prev', 'me'], false, false],
            [['dummy'], 'dummy', [], false, true, [], false, false],
            [['dummy'], 'dummy', [], true, false, [], false, false],
            [['prev', 'me', 'modules', 'dummy'], 'dummy', [], true, true, ['prev', 'me'], true, true],
        ];
    }

    /**
     * @param string[] $expected
     * @param string[] $startPath
     * @param bool $moreUsers
     * @param bool $moreLangs
     * @param string[] $prefixPath
     * @param bool $sysSeparator
     * @param bool $dataSeparator
     * @throws PathsException
     * @dataProvider userPathsProvider
     */
    public function testUserPaths(array $expected, array $startPath, bool $moreUsers, bool $moreLangs, array $prefixPath, bool $sysSeparator, bool $dataSeparator): void
    {
        $lib = new InnerLinks(
            new RoutedPath(new Arrays(['user' => 'foo/him', 'lang' => 'baz'])),
            $moreUsers,
            $moreLangs,
            $prefixPath,
            $sysSeparator,
            $dataSeparator
        );
        $this->assertEquals($expected, $lib->toUserPath($startPath));
    }

    public function userPathsProvider(): array
    {
        return [
            [['abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, [], false, false],
            [['abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, [], false, true],
            [['user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, [], true, false],
            [['user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, [], true, true],
            [['prev', 'me', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, ['prev', 'me'], false, false],
            [['prev', 'me', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, ['prev', 'me'], false, true],

            [['prev', 'me', 'user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, ['prev', 'me'], true, false],
            [['prev', 'me', 'user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, ['prev', 'me'], true, true],
            [['prev', 'me', 'user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, ['prev', 'me'], true, true],
            [['abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, [], false, false],
            [['abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, [], false, true],

            [['user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, [], true, false],
            [['user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, [], true, true],
            [['prev', 'me', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, ['prev', 'me'], false, false],
            [['prev', 'me', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, ['prev', 'me'], false, true],
            [['prev', 'me', 'user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, ['prev', 'me'], true, false],

            [['prev', 'me', 'user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, ['prev', 'me'], true, true],
            [['prev', 'me', 'user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, ['prev', 'me'], true, true],
            [['foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, [], false, false],
            [['foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, [], false, true],
            [['user', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, [], true, false],

            [['user', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, [], true, true],
            [['prev', 'me', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, ['prev', 'me'], false, false],
            [['prev', 'me', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, ['prev', 'me'], false, true],
            [['prev', 'me', 'user', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, ['prev', 'me'], true, false],
            [['prev', 'me', 'user', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, ['prev', 'me'], true, true],

            [['prev', 'me', 'user', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, ['prev', 'me'], true, true],
            [['foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, [], false, false],
            [['foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, [], false, true],
            [['user', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, [], true, false],
            [['user', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, [], true, true],

            [['prev', 'me', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, ['prev', 'me'], false, false],
            [['prev', 'me', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, ['prev', 'me'], false, true],
            [['prev', 'me', 'user', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, ['prev', 'me'], true, false],
            [['prev', 'me', 'user', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, ['prev', 'me'], true, true],
            [['prev', 'me', 'user', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, ['prev', 'me'], true, true],

            [[], [], false, false, [], false, false],
            [[], [], false, false, [], false, true],
            [['user'], [], false, false, [], true, false],
            [['prev', 'me'], [], false, false, ['prev', 'me'], false, false],
            [[], [], false, true, [], false, false],
            [['foo', 'him'], [], true, false, [], false, false],
            [['prev', 'me', 'user', 'foo', 'him'], [], true, true, ['prev', 'me'], true, true],
        ];
    }

    /**
     * @param string[] $expected
     * @param string $module
     * @param string[] $startPath
     * @param bool $moreUsers
     * @param bool $moreLangs
     * @param string[] $prefixPath
     * @param bool $sysSeparator
     * @param bool $dataSeparator
     * @throws PathsException
     * @dataProvider userModulePathsProvider
     */
    public function testUserModulePaths(array $expected, string $module, array $startPath, bool $moreUsers, bool $moreLangs, array $prefixPath, bool $sysSeparator, bool $dataSeparator): void
    {
        $lib = new InnerLinks(
            new RoutedPath(new Arrays(['user' => 'foo/him', 'lang' => 'baz'])),
            $moreUsers,
            $moreLangs,
            $prefixPath,
            $sysSeparator,
            $dataSeparator
        );
        $this->assertEquals($expected, $lib->toUserModulePath($module, $startPath));
    }

    public function userModulePathsProvider(): array
    {
        return [
            [['dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, [], false, false],
            [['modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, [], false, true],
            [['user', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, [], true, false],
            [['user', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, [], true, true],
            [['prev', 'me', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, ['prev', 'me'], false, false],
            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, ['prev', 'me'], false, true],

            [['prev', 'me', 'user', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, ['prev', 'me'], true, false],
            [['prev', 'me', 'user', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, ['prev', 'me'], true, true],
            [['prev', 'me', 'user', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, false, ['prev', 'me'], true, true],
            [['dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, [], false, false],
            [['modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, [], false, true],

            [['user', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, [], true, false],
            [['user', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, [], true, true],
            [['prev', 'me', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, ['prev', 'me'], false, false],
            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, ['prev', 'me'], false, true],
            [['prev', 'me', 'user', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, ['prev', 'me'], true, false],

            [['prev', 'me', 'user', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, ['prev', 'me'], true, true],
            [['prev', 'me', 'user', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], false, true, ['prev', 'me'], true, true],
            [['foo', 'him', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, [], false, false],
            [['foo', 'him', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, [], false, true],
            [['user', 'foo', 'him', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, [], true, false],

            [['user', 'foo', 'him', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, [], true, true],
            [['prev', 'me', 'foo', 'him', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, ['prev', 'me'], false, false],
            [['prev', 'me', 'foo', 'him', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, ['prev', 'me'], false, true],
            [['prev', 'me', 'user', 'foo', 'him', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, ['prev', 'me'], true, false],
            [['prev', 'me', 'user', 'foo', 'him', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, ['prev', 'me'], true, true],

            [['prev', 'me', 'user', 'foo', 'him', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, false, ['prev', 'me'], true, true],
            [['foo', 'him', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, [], false, false],
            [['foo', 'him', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, [], false, true],
            [['user', 'foo', 'him', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, [], true, false],
            [['user', 'foo', 'him', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, [], true, true],

            [['prev', 'me', 'foo', 'him', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, ['prev', 'me'], false, false],
            [['prev', 'me', 'foo', 'him', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, ['prev', 'me'], false, true],
            [['prev', 'me', 'user', 'foo', 'him', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, ['prev', 'me'], true, false],
            [['prev', 'me', 'user', 'foo', 'him', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, ['prev', 'me'], true, true],
            [['prev', 'me', 'user', 'foo', 'him', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], true, true, ['prev', 'me'], true, true],

            [['dummy'], 'dummy', [], false, false, [], false, false],
            [['modules', 'dummy'], 'dummy', [], false, false, [], false, true],
            [['user', 'dummy'], 'dummy', [], false, false, [], true, false],
            [['prev', 'me', 'dummy'], 'dummy', [], false, false, ['prev', 'me'], false, false],
            [['dummy'], 'dummy', [], false, true, [], false, false],
            [['foo', 'him', 'dummy'], 'dummy', [], true, false, [], false, false],
            [['prev', 'me', 'user', 'foo', 'him', 'modules', 'dummy'], 'dummy', [], true, true, ['prev', 'me'], true, true],
        ];
    }

    /**
     * @param string[] $expected
     * @param string[] $startPath
     * @param bool $moreUsers
     * @param bool $moreLangs
     * @param string[] $prefixPath
     * @param bool $sysSeparator
     * @param bool $dataSeparator
     * @throws PathsException
     * @dataProvider fullPathsProvider
     */
    public function testFullPaths(array $expected, array $startPath, bool $moreUsers, bool $moreLangs, array $prefixPath, bool $sysSeparator, bool $dataSeparator): void
    {
        $lib = new InnerLinks(
            new RoutedPath(new Arrays(['user' => 'foo/him', 'lang' => 'baz'])),
            $moreUsers,
            $moreLangs,
            $prefixPath,
            $sysSeparator,
            $dataSeparator
        );
        $this->assertEquals($expected, $lib->toFullPath($startPath));
    }

    public function fullPathsProvider(): array
    {
        return [
            [['abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, [], false, false],
            [['data', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, [], false, true],
            [['user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, [], true, false],
            [['user', 'data', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, [], true, true],
            [['prev', 'me', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, ['prev', 'me'], false, false],
            [['prev', 'me', 'data', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, ['prev', 'me'], false, true],

            [['prev', 'me', 'user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, ['prev', 'me'], true, false],
            [['prev', 'me', 'user', 'data', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, ['prev', 'me'], true, true],
            [['prev', 'me', 'user', 'data', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, false, ['prev', 'me'], true, true],
            [['baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, [], false, false],
            [['data', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, [], false, true],

            [['user', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, [], true, false],
            [['user', 'data', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, [], true, true],
            [['prev', 'me', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, ['prev', 'me'], false, false],
            [['prev', 'me', 'data', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, ['prev', 'me'], false, true],
            [['prev', 'me', 'user', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, ['prev', 'me'], true, false],

            [['prev', 'me', 'user', 'data', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, ['prev', 'me'], true, true],
            [['prev', 'me', 'user', 'data', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], false, true, ['prev', 'me'], true, true],
            [['foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, [], false, false],
            [['foo', 'him', 'data', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, [], false, true],
            [['user', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, [], true, false],

            [['user', 'foo', 'him', 'data', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, [], true, true],
            [['prev', 'me', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, ['prev', 'me'], false, false],
            [['prev', 'me', 'foo', 'him', 'data', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, ['prev', 'me'], false, true],
            [['prev', 'me', 'user', 'foo', 'him', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, ['prev', 'me'], true, false],
            [['prev', 'me', 'user', 'foo', 'him', 'data', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, ['prev', 'me'], true, true],

            [['prev', 'me', 'user', 'foo', 'him', 'data', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, false, ['prev', 'me'], true, true],
            [['foo', 'him', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, [], false, false],
            [['foo', 'him', 'data', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, [], false, true],
            [['user', 'foo', 'him', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, [], true, false],
            [['user', 'foo', 'him', 'data', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, [], true, true],

            [['prev', 'me', 'foo', 'him', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, ['prev', 'me'], false, false],
            [['prev', 'me', 'foo', 'him', 'data', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, ['prev', 'me'], false, true],
            [['prev', 'me', 'user', 'foo', 'him', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, ['prev', 'me'], true, false],
            [['prev', 'me', 'user', 'foo', 'him', 'data', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, ['prev', 'me'], true, true],
            [['prev', 'me', 'user', 'foo', 'him', 'data', 'baz', 'abc', 'def/ghi'], ['abc', 'def/ghi'], true, true, ['prev', 'me'], true, true],

            [[], [], false, false, [], false, false],
            [['data'], [], false, false, [], false, true],
            [['user'], [], false, false, [], true, false],
            [['prev', 'me'], [], false, false, ['prev', 'me'], false, false],
            [['baz'], [], false, true, [], false, false],
            [['foo', 'him'], [], true, false, [], false, false],
            [['prev', 'me', 'user', 'foo', 'him', 'data', 'baz'], [], true, true, ['prev', 'me'], true, true],
        ];
    }
}
