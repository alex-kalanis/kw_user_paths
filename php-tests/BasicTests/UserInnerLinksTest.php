<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_paths\PathsException;
use kalanis\kw_user_paths\UserInnerLinks;


class UserInnerLinksTest extends CommonTestClass
{
    /**
     * @param string[] $expected
     * @param string $module
     * @param string[] $startPath
     * @param string|null $useUser
     * @param string[] $prefixPath
     * @dataProvider modulePathsProvider
     */
    public function testModulePaths(array $expected, string $module, array $startPath, ?string $useUser, array $prefixPath): void
    {
        $lib = new UserInnerLinks($useUser, $prefixPath);
        $this->assertEquals($expected, $lib->toModulePath($module, $startPath));
    }

    public function modulePathsProvider(): array
    {
        return [
            [['modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], '/whatever/', []],
            [['prev', 'me', 'modules', 'dummy', 'abc', 'def/ghi'], 'dummy', ['abc', 'def/ghi'], '/whatever/', ['prev', 'me']],
            [['modules', 'dummy'], 'dummy', [], '/whatever/', []],
            [['prev', 'me', 'modules', 'dummy'], 'dummy', [], '/whatever/', ['prev', 'me']],
        ];
    }

    /**
     * @param string[] $expected
     * @param string[] $startPath
     * @param string|null $useUser
     * @param string[] $prefixPath
     * @throws PathsException
     * @dataProvider userPathsProvider
     */
    public function testUserPaths(array $expected, array $startPath, ?string $useUser, array $prefixPath): void
    {
        $lib = new UserInnerLinks($useUser, $prefixPath);
        $this->assertEquals($expected, $lib->toUserPath($startPath));
    }

    public function userPathsProvider(): array
    {
        return [
            [['abc', 'def/ghi'], ['abc', 'def/ghi'], '/', []],
            [['someone', 'abc', 'def/ghi'], ['abc', 'def/ghi'], '/someone/', []],
            [['user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], '/user/', []],
            [['user', 'user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], 'user', []],
            [['prev', 'me', 'user', 'abc', 'def/ghi'], ['abc', 'def/ghi'], '/user/', ['prev', 'me']],
            [['someone', 'abc', 'def/ghi'], ['abc', 'def/ghi'], '/someone', []],

            [['user', 'someone', 'abc', 'def/ghi'], ['abc', 'def/ghi'], 'someone', []],
            [[], [], '/', []],
            [['someone'], [], '/someone/', []],
            [['someone'], [], '/someone', []],
            [['user', 'someone'], [], 'someone/', []],

            [['user', 'someone'], [], 'someone', []],
        ];
    }

    /**
     * @param string[] $expected
     * @param string $module
     * @param string[] $startPath
     * @param string|null $useUser
     * @param string[] $prefixPath
     * @throws PathsException
     * @dataProvider userModulePathsProvider
     */
    public function testUserModulePaths(array $expected, string $module, array $startPath, ?string $useUser, array $prefixPath): void
    {
        $lib = new UserInnerLinks($useUser, $prefixPath);
        $this->assertEquals($expected, $lib->toUserModulePath($module, $startPath));
    }

    public function userModulePathsProvider(): array
    {
        return [
            [['dummy'], 'dummy', [], null, []],
            [['dummy'], 'dummy', [], '/', []],
            [['someone', 'dummy'], 'dummy', [], '/someone/', []],
            [['prev', 'me', 'dummy'], 'dummy', [], '/', ['prev', 'me']],
            [['dummy'], 'dummy', [], '/', []],
            [['user', 'someone', 'dummy'], 'dummy', [], 'someone/', []],
            [['prev', 'me', 'user', 'someone', 'modules', 'dummy'], 'dummy', [], 'someone', ['prev', 'me']],
        ];
    }

    /**
     * @param string[] $expected
     * @param string[] $startPath
     * @param string|null $useUser
     * @param string[] $prefixPath
     * @throws PathsException
     * @dataProvider fullPathsProvider
     */
    public function testFullPaths(array $expected, array $startPath, ?string $useUser, array $prefixPath): void
    {
        $lib = new UserInnerLinks($useUser, $prefixPath);
        $this->assertEquals($expected, $lib->toFullPath($startPath));
    }

    public function fullPathsProvider(): array
    {
        return [
            [[], [], null, []],
            [[], [], '/', []],
            [['someone', 'data'], [], '/someone', []],
            [['user', 'someone'], [], 'someone/', []],
            [['prev', 'me'], [], '/', ['prev', 'me']],
            [['baz'], ['baz'], '/', []],
            [['foo', 'him'], [], '/foo/him/', []],
            [['prev', 'me', 'user', 'foo', 'him', 'data', 'baz'], ['baz'], 'foo/him', ['prev', 'me']],
        ];
    }
}
