<?php

namespace TraitsTests;


use CommonTestClass;
use kalanis\kw_user_paths\Interfaces\IUPTranslations;
use kalanis\kw_user_paths\Traits\TLang;
use kalanis\kw_user_paths\Translations;


class LangTest extends CommonTestClass
{
    public function testSimple(): void
    {
        $lib = new XLang();
        $this->assertNotEmpty($lib->getUpLang());
        $this->assertInstanceOf(Translations::class, $lib->getUpLang());
        $lib->setUpLang(new XTrans());
        $this->assertInstanceOf(XTrans::class, $lib->getUpLang());
        $lib->setUpLang(null);
        $this->assertInstanceOf(Translations::class, $lib->getUpLang());
    }
}


class XLang
{
    use TLang;
}


class XTrans implements IUPTranslations
{
    public function upUserNameIsShort(): string
    {
        return 'mock';
    }

    public function upUserNameContainsChars(): string
    {
        return 'mock';
    }

    public function upUserNameNotDefined(): string
    {
        return 'mock';
    }

    public function upCannotDetermineUserDir(): string
    {
        return 'mock';
    }

    public function upCannotCreateUserDir(): string
    {
        return 'mock';
    }

    public function upCannotGetFullPaths(): string
    {
        return 'mock';
    }
}