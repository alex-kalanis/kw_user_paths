<?php

namespace BasicTests;


use CommonTestClass;
use kalanis\kw_files\FilesException;
use kalanis\kw_files\Processing\Storage as files;
use kalanis\kw_paths\ArrayPath;
use kalanis\kw_paths\Interfaces\IPaths;
use kalanis\kw_paths\PathsException;
use kalanis\kw_storage\Storage as store;
use kalanis\kw_user_paths\Actions;
use kalanis\kw_user_paths\UserDir;


class ActionsTest extends CommonTestClass
{
    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCreateInvalid1(): void
    {
        $lib = $this->getActionsWithoutPaths('/for_test');
        $this->expectException(PathsException::class);
        $lib->createTree();
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCreateInvalid2(): void
    {
        $lib = $this->getActions('for_test');
        $this->expectException(PathsException::class);
        $lib->createTree();
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testCreate(): void
    {
        $lib = $this->getActions('/for_test');
        $lib->createTree();
        $this->assertTrue($lib->wipeConfDirs());
        $this->assertTrue($lib->wipeHomeDir());
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testWipeWorkDir(): void
    {
        $lib = $this->getActions('prepared');
        $this->assertTrue($lib->wipeWorkDir());
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testWipeWorkDir2(): void
    {
        $lib = $this->getActions('prepared/');
        $this->assertTrue($lib->wipeWorkDir());
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testWipeWorkDirInvalid1(): void
    {
        $lib = $this->getActionsWithoutPaths(null);
        $this->expectException(PathsException::class);
        $lib->wipeWorkDir();
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testWipeWorkDirInvalid2(): void
    {
        $lib = $this->getActions('/d/');
        $this->assertFalse($lib->wipeWorkDir());
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testWipeConfDir(): void
    {
        $lib = $this->getActions('prepared');
        $this->assertTrue($lib->wipeConfDirs());
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testWipeConfDirInvalid1(): void
    {
        $lib = $this->getActionsWithoutPaths(null);
        $this->expectException(PathsException::class);
        $lib->wipeConfDirs();
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testWipeConfDirInvalid2(): void
    {
        $lib = $this->getActionsWithShortPaths('/d');
        $this->assertFalse($lib->wipeConfDirs());
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testWipeConfDirInvalid3(): void
    {
        $lib = $this->getActions('/dummy/');
        $this->assertFalse($lib->wipeConfDirs());
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testWipeHomeDir(): void
    {
        $lib = $this->getActions('prepared');
        $this->assertTrue($lib->wipeHomeDir());
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testWipeHomeDirInvalid1(): void
    {
        $lib = $this->getActionsWithoutPaths(null);
        $this->expectException(PathsException::class);
        $lib->wipeHomeDir();
    }

    /**
     * @throws FilesException
     * @throws PathsException
     */
    public function testWipeHomeDirInvalid2(): void
    {
        $lib = $this->getActions('/d/');
        $this->assertFalse($lib->wipeHomeDir());
    }

    /**
     * @param string|null $path
     * @throws FilesException
     * @throws PathsException
     * @return Actions
     */
    protected function getActions(?string $path): Actions
    {
        $storage = $this->getStorage();
        return new Actions(
            $this->getUserDir($path),
            new files\ProcessNode($storage),
            new files\ProcessDir($storage)
        );
    }

    /**
     * @param string|null $path
     * @throws FilesException
     * @throws PathsException
     * @return Actions
     */
    protected function getActionsWithoutPaths(?string $path): Actions
    {
        $userDir = $this->getUserDir($path);
        $userDir->emptyFullPath();
        $storage = $this->getStorage();
        return new Actions(
            $userDir,
            new files\ProcessNode($storage),
            new files\ProcessDir($storage)
        );
    }

    /**
     * @param string|null $path
     * @throws FilesException
     * @throws PathsException
     * @return Actions
     */
    protected function getActionsWithShortPaths(?string $path): Actions
    {
        $userDir = $this->getUserDir($path);
        $userDir->shortFullPath();
        $storage = $this->getStorage();
        return new Actions(
            $userDir,
            new files\ProcessNode($storage),
            new files\ProcessDir($storage)
        );
    }

    /**
     * @param string|null $path
     * @throws PathsException
     * @return xUserDir
     */
    protected function getUserDir(?string $path): xUserDir
    {
        $userDir = new xUserDir();
        $userDir->setUserPath($path);
        $userDir->process();
        return $userDir;
    }

    /**
     * @throws FilesException
     * @throws PathsException
     * @return store\Storage
     */
    protected function getStorage(): store\Storage
    {
        $storage = new store\Storage(new store\Key\DefaultKey(), new store\Target\Memory());
        $this->mockStorageWithContent($storage);
        return $storage;
    }

    /**
     * @param store\Storage $storage
     * @throws FilesException
     * @throws PathsException
     */
    protected function mockStorageWithContent(store\Storage $storage): void
    {
        // hack - some predefined content in storage
        $dirs = new files\ProcessDir($storage);
        // testing data tree structure for accessing user content
        $dirs->createDir([IPaths::DIR_USER, 'prepared', IPaths::DIR_DATA], true);
        $dirs->createDir([IPaths::DIR_USER, 'prepared', IPaths::DIR_CONF], true);
        $dirs->createDir([IPaths::DIR_USER, 'prepared', IPaths::DIR_STYLE], true);
        $files = new files\ProcessFile($storage);
        $files->saveFile([IPaths::DIR_USER, 'prepared', IPaths::DIR_STYLE, 'moar'], 'content');
        // this one is not a directory, it's file and cannot be re-created as dir
        $files->saveFile([IPaths::DIR_USER, 'for_test'], 'okmjinuhb');
    }
}


class xUserDir extends UserDir
{
    /**
     * Hack for undefined user name
     * @return string
     */
    protected function makeFromUserName(): string
    {
        return '';
    }

    public function emptyFullPath(): void
    {
        $this->fullPath = new ArrayPath();
    }

    public function shortFullPath(): void
    {
        $this->fullPath = new ArrayPath();
        $this->fullPath->setArray(['d']);
    }
}
