# kw_user_paths

[![Build Status](https://app.travis-ci.com/alex-kalanis/kw_user_paths.svg?branch=master)](https://app.travis-ci.com/github/alex-kalanis/kw_user_paths)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_user_paths/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_user_paths/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_user_paths/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_user_paths)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_user_paths.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_user_paths)
[![License](https://poser.pugx.org/alex-kalanis/kw_user_paths/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_user_paths)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_user_paths/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_user_paths/?branch=master)

Define user paths library inside the KWCMS. Parse from config, update against structure on system.

## PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_user_paths": ">=1.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote storage.

3.) Connect the "kalanis\kw_user_paths" into your app. Extends it for setting your case.

4.) Connect library into your bootstrap process.

5.) Just use class "kalanis\kw_user_paths\Path" as data storage
