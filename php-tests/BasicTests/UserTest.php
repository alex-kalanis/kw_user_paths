<?php

namespace BasicTests;


use CommonTestClass;
use InvalidArgumentException;
use kalanis\kw_paths\PathsException;
use kalanis\kw_user_paths\UserDir;
use UnexpectedValueException;


class UserTest extends CommonTestClass
{
    public function testBasics(): void
    {
        $lib = new UserDir();
        $this->assertEmpty($lib->getHomeDir());
        $this->assertEmpty($lib->getDataDir());
        $this->assertFalse($lib->wantHomeDir(false)->hasHomeDir());
        $this->assertTrue($lib->wantHomeDir(true)->hasHomeDir());
        $this->assertFalse($lib->wantDataDir(false)->hasDataDir());
        $this->assertTrue($lib->wantDataDir(true)->hasDataDir());
    }

    public function testUser(): void
    {
        $lib = new UserDir();
        $lib->setUserName('dummy');
        $this->assertEquals('dummy', $lib->getUserName());
    }

    public function testUserEmpty(): void
    {
        $lib = new UserDir();
        $this->expectException(InvalidArgumentException::class);
        $lib->setUserName('');
    }

    public function testUserInvalid(): void
    {
        $lib = new UserDir();
        $this->expectException(InvalidArgumentException::class);
        $lib->setUserName('which:me');
    }

    public function testPathSetterClear(): void
    {
        $lib = new UserDir();
        $this->assertTrue($lib->setUserPath(null));
    }

    /**
     * @throws PathsException
     */
    public function testFullPathInvalid(): void
    {
        $lib = new UserDir();
        $this->expectException(PathsException::class);
        $lib->getFullPath();
    }

    /**
     * @param string $path
     * @param bool $useHomeDir
     * @param bool $useDataDir
     * @dataProvider pathsProvider
     */
    public function testPaths(string $path, bool $useHomeDir, bool $useDataDir): void
    {
        $lib = new UserDir();
        $lib->setUserPath($path);
        $this->assertEquals($path, $lib->getUserPath());
        $this->assertEquals($useHomeDir, $lib->hasHomeDir());
        $this->assertEquals($useDataDir, $lib->hasDataDir());
    }

    public function pathsProvider(): array
    {
        return [
            ['abc/def/ghi', true, true],
            ['/abc/def/ghi/', false, false],
            ['/abc/def/ghi', false, true],
            ['abc/def/ghi/', true, false],
            ['/', false, false],
            ['', true, true],
        ];
    }

    /**
     * @throws PathsException
     */
    public function testProcessInvalid(): void
    {
        $lib = new UserDir();
        $this->expectException(UnexpectedValueException::class);
        $lib->process();
    }

    /**
     * @param string $name
     * @param bool $fromHomeDir
     * @param bool $useSubDir
     * @param string $resultPath
     * @throws PathsException
     * @dataProvider processNamesProvider
     */
    public function testProcessNames(string $name, bool $fromHomeDir, bool $useSubDir, string $resultPath): void
    {
        $lib = new UserDir();
        $lib->setUserName($name)->wantHomeDir($fromHomeDir)->wantDataDir($useSubDir)->process();
        $this->assertEquals($resultPath, $lib->getUserPath());
    }

    public function processNamesProvider(): array
    {
        return [
            ['dummy', true, true, 'dummy'],
            ['dummy', false, true, '/dummy'],
            ['dummy', false, false, '/dummy/'],
            ['dummy', true, false, 'dummy/'],
        ];
    }

    public function testPathSetterInvalid(): void
    {
        $lib = new UserDir();
        $this->assertFalse($lib->setUserPath('which:me'));
    }
}
